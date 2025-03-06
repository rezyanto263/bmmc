<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_companies extends CI_Model {

    public function getAllCompaniesDatas() {
        $this->db->select('c.*,
            a.adminEmail, 
            a.adminName,
            b.billingId,
            b.billingStatus, 
            b.billingAmount, 
            b.billingStartedAt,
            b.billingEndedAt, 
            IFNULL(SUM(CASE 
                WHEN MONTH(hh.healthhistoryDate) = MONTH(CURDATE()) 
                AND YEAR(hh.healthhistoryDate) = YEAR(CURDATE()) 
                THEN hh.healthhistoryTotalBill ELSE 0 END), 0) AS billingUsed');
        $this->db->from('company c');
        $this->db->join('admin a', 'a.adminId = c.adminId', 'left');
        $this->db->join('billing b', 'b.companyId = c.companyId AND b.billingStatus != "finished"', 'left');
        $this->db->join('healthhistory hh', 'hh.billingId = b.billingId', 'left');
        $this->db->group_by('c.companyId');
        return $this->db->get()->result_array();
    }

    public function getCompanyByAdminId($adminId) {
        $this->db->where('adminId', $adminId);
        $query = $this->db->get('company');
        return $query->row_array();
    }

    public function getCompanyStatus($companyId) {
        $this->db->select('companyStatus');
        $this->db->where('companyId', $companyId);
        return $this->db->get('company')->row_array()['companyStatus'] ?? null;
    }

    public function getCompanyDetails($companyId) {
        $this->db->select('
            IFNULL(COUNT(DISTINCT i.invoiceId), 0) AS totalInvoices,
            IFNULL(SUM(CASE WHEN i.invoiceStatus = "paid" THEN 1 ELSE 0 END), 0) AS totalPaidInvoices,
            IFNULL(SUM(CASE WHEN i.invoiceStatus = "unpaid" THEN 1 ELSE 0 END), 0) AS totalUnpaidInvoices,
            IFNULL(COUNT(DISTINCT e.employeeNIK), 0) AS totalEmployees,
            IFNULL(SUM(CASE WHEN e.employeeStatus = "unverified" THEN 1 ELSE 0 END), 0) AS totalUnverifiedEmployees,
            IFNULL(SUM(CASE WHEN e.employeeStatus = "active" THEN 1 ELSE 0 END), 0) AS totalActiveEmployees,
            IFNULL(SUM(CASE WHEN e.employeeStatus = "on hold" THEN 1 ELSE 0 END), 0) AS totalOnHoldEmployees,
            IFNULL(SUM(CASE WHEN e.employeeStatus = "discontinued" THEN 1 ELSE 0 END), 0) AS totalDiscontinuedEmployees,
            IFNULL(COUNT(DISTINCT f.familyNIK), 0) AS totalFamilyMembers,
            IFNULL(SUM(CASE WHEN f.familyStatus = "unverified" THEN 1 ELSE 0 END), 0) AS totalUnverifiedFamilyMembers,
            IFNULL(SUM(CASE WHEN f.familyStatus = "active" THEN 1 ELSE 0 END), 0) AS totalActiveFamilyMembers,
            IFNULL(SUM(CASE WHEN f.familyStatus = "on hold" THEN 1 ELSE 0 END), 0) AS totalOnHoldFamilyMembers,
            IFNULL(SUM(CASE WHEN f.familyStatus = "archived" THEN 1 ELSE 0 END), 0) AS totalArchivedFamilyMembers
        ');
        $this->db->from('company c');
        $this->db->join('insurance ins', 'ins.companyId = c.companyId', 'left');
        $this->db->join('employee e', 'e.insuranceId = ins.insuranceId', 'left');
        $this->db->join('family f', 'f.employeeNIK = e.employeeNIK', 'left');
        $this->db->join('billing b', 'b.companyId = c.companyId', 'left');
        $this->db->join('invoice i', 'i.billingId = b.billingId', 'left');
        $this->db->where('c.companyId', $companyId);
        return $this->db->get()->row_array();
    }

    public function countEmployeeByCompanyId($companyId) {
        $this->db->select('COUNT(e.employeeNIK) as count');
        $this->db->from('company c');
        $this->db->join('insurance i', 'i.companyId = c.companyId', 'left');
        $this->db->join('employee e', 'e.insuranceId = i.insuranceId', 'left');
        $this->db->where('c.companyId', $companyId);
        $query = $this->db->get();
        return $query->row()->count;
    }

    public function getAllCompaniesLogo() {
        $this->db->select('companyLogo');
        $this->db->from('company');
        $this->db->where('companyLogo IS NOT NULL AND companyLogo != ""');
        return $this->db->get()->result_array();
    }

    public function getTotalCompanies() {
        $this->db->where('companyStatus !=', 'discontinued');
        return $this->db->count_all('company');
    }

    public function getAllCompaniesInsuranceMembers() {
        $this->db->select('SUM(CASE WHEN e.employeeNIK IS NOT NULL THEN 1 WHEN f.familyNIK IS NOT NULL THEN 1 ELSE 0 END) AS totalInsuranceMembers');
        $this->db->from('company c');
        $this->db->join('insurance i', 'i.companyId = c.companyId', 'left');
        $this->db->join('employee e', 'e.insuranceId = i.insuranceId', 'left');
        $this->db->join('family f', 'f.employeeNIK = e.employeeNIK', 'left');
        return $this->db->get()->row_array()['totalInsuranceMembers'];
    }

    public function getAllActiveCompaniesMapData() {
        $this->db->select('
            companyPhoto AS photo, 
            companyLogo AS logo, 
            companyCoordinate AS coordinate,
            companyName AS partnerName, 
            "company" AS partnerRole
        ');
        $this->db->from('company');
        $this->db->where('companyStatus', 'active');
        return $this->db->get()->result_array();
    }

    public function checkCompany($param, $companyData) {
        return $this->db->get_where('company', array($param => $companyData))->row_array();
    }

    public function insertCompany($companyDatas, $billingDatas) {
        $this->db->trans_start();

        $this->db->insert('company', $companyDatas);
        $companyId = $this->db->insert_id();

        $billingDatas['companyId'] = $companyId;
        $this->db->insert('billing', $billingDatas);
        
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return false;
        } else {
            return true;
        }
    }

    public function updateCompany($companyId, $companyDatas, $billingDatas = NULL) {
        $this->db->trans_start();

        $this->db->where('companyId', $companyId);
        $this->db->update('company', $companyDatas);

        if (!empty($billingDatas) && $billingDatas['billingAmount'] != NULL) {
            $this->db->where('billingId', $billingDatas['billingId']);
            $this->db->update('billing', array('billingAmount' => $billingDatas['billingAmount']));
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return false;
        } else {
            return true;
        }
    }

    public function deleteCompany($companyId) {
        $this->db->where('companyId', $companyId);
        return $this->db->delete('company');
    }

}

/* End of file M_companies.php */

?>