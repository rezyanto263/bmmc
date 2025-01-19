<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_companies extends CI_Model {

    public function getAllCompaniesDatas() {
        $this->db->select('c.*,
            a.adminEmail, 
            a.adminName,
            b.billingStatus, 
            b.billingAmount, 
            b.billingStartedAt,
            b.billingEndedAt, 
            IFNULL(SUM(hh.historyhealthTotalBill), 0) as billingUsed');
        $this->db->from('company c');
        $this->db->join('admin a', 'a.adminId = c.adminId', 'left');
        $this->db->join('billing b', 'b.companyId = c.companyId AND b.billingStatus IN (\'in use\', "stopped")', 'left');
        $this->db->join('historyhealth hh', 'hh.billingId = b.billingId', 'left');
        $this->db->group_by('c.companyId');
        return $this->db->get()->result_array();
    }

    public function getCompanyByAdminId($adminId)
    {
        $this->db->where('adminId', $adminId);
        $query = $this->db->get('company'); // Ganti dengan nama tabel yang sesuai
        return $query->row_array(); // Mengambil satu baris data
    }

    public function checkCompany($param, $companyData) {
        return $this->db->get_where('company', array($param => $companyData))->row_array();
    }

    public function getCompanyDetails($companyId) {
        $this->db->select('
            IFNULL(COUNT(DISTINCT i.invoiceId), 0) AS totalInvoices,
            IFNULL(COUNT(i.invoiceStatus = "paid"), 0) AS totalPaidInvoices,
            IFNULL(COUNT(i.invoiceStatus = "unpaid"), 0) AS totalUnpaidInvoices,
            IFNULL(COUNT(DISTINCT e.employeeNIK), 0) AS totalEmployees,
            IFNULL(SUM(e.employeeStatus = "unverified"), 0) AS totalUnverifiedEmployees,
            IFNULL(SUM(e.employeeStatus = "active"), 0) AS totalActiveEmployees,
            IFNULL(SUM(e.employeeStatus = "on hold"), 0) AS totalOnHoldEmployees,
            IFNULL(SUM(e.employeeStatus = "discontinued"), 0) AS totalDiscontinuedEmployees,
            IFNULL(COUNT(DISTINCT f.familyNIK), 0) AS totalFamilyMembers,
            IFNULL(SUM(f.familyStatus = "unverified"), 0) AS totalUnverifiedFamilyMembers,
            IFNULL(SUM(f.familyStatus = "active"), 0) AS totalActiveFamilyMembers,
            IFNULL(SUM(f.familyStatus = "on hold"), 0) AS totalOnHoldFamilyMembers,
            IFNULL(SUM(f.familyStatus = "archived"), 0) AS totalArchivedFamilyMembers,
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

    public function updateCompany($companyId, $companyDatas, $billingDatas) {
        $this->db->trans_start();

        $this->db->where('companyId', $companyId);
        $this->db->update('company', $companyDatas);

        if ($billingDatas['billingAmount']) {
            $this->db->where('companyId', $companyId);
            $this->db->update('billing', $billingDatas);
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

    public function getEmployeeByNIK($employeeNIK) {
        $this->db->select('e.*, i.insuranceTier, c.companyName');
        $this->db->from('employee e');
        $this->db->join('insurance i', 'i.insuranceId = e.insuranceId', 'left');
        $this->db->join('company c', 'c.companyId = i.companyId', 'left');
        $this->db->where('e.employeeNIK', $employeeNIK);
        return $this->db->get()->row_array();
    }

    public function getFamilyByNIK($familyNIK) {
        $this->db->select('f.*, c.companyName');
        $this->db->from('family f');
        $this->db->join('employee e', 'e.employeeNIK = f.employeeNIK', 'left');
        $this->db->join('insurance i', 'i.insuranceId = e.insuranceId', 'left');
        $this->db->join('company c', 'c.companyId = i.companyId', 'left');
        $this->db->where('f.familyNIK', $familyNIK);
        return $this->db->get()->row_array();
    }

}

/* End of file M_companies.php */

?>