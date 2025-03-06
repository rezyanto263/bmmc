<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_families extends CI_Model {

    public function getAllFamilyDatas($companyId) {
        $this->db->select('f.*, e.employeeName, e.employeeDepartment, e.employeeBand');
        $this->db->from('family f');
        $this->db->join('employee e', 'e.employeeNIK = f.employeeNIK');
        $this->db->join('insurance i', 'i.insuranceId = e.insuranceId');
        $this->db->where('i.companyId', $companyId);
        return $this->db->get()->result_array();
    }

    public function getCompanyByAdminId($adminId) {
        $this->db->where('adminId', $adminId);
        $query = $this->db->get('company');
        return $query->row_array();
    }

    public function getFamiliesByEmployeeNIK($employeeNIK) {
        $this->db->select('
            f.*,
            COALESCE(SUM(CASE WHEN hh.healthhistoryDate >= DATE_FORMAT(CURDATE(), "%Y-%m-01") 
                                AND hh.healthhistoryDate < LAST_DAY(CURDATE()) + INTERVAL 1 DAY 
                                THEN hh.healthhistoryTotalBill ELSE 0 END), 0) AS totalBillingUsed,
    
            COALESCE(SUM(CASE WHEN hh.healthhistoryTotalBill != 0 AND hh.healthhistoryReferredTo IS NULL THEN 1 ELSE 0 END), 0) AS totalBilledTreatments,
            COALESCE(SUM(CASE WHEN hh.healthhistoryTotalBill = 0 AND hh.healthhistoryReferredTo IS NULL THEN 1 ELSE 0 END), 0) AS totalFreeTreatments,
            COALESCE(SUM(CASE WHEN hh.healthhistoryReferredTo IS NOT NULL THEN 1 ELSE 0 END), 0) AS totalReferredTreatments,
            COALESCE(COUNT(hh.healthhistoryId), 0) AS totalTreatments,
    
            -- Current month treatment counts
            COALESCE(SUM(CASE WHEN hh.healthhistoryTotalBill != 0 AND hh.healthhistoryReferredTo IS NULL 
                                AND hh.healthhistoryDate >= DATE_FORMAT(CURDATE(), "%Y-%m-01") 
                                AND hh.healthhistoryDate < LAST_DAY(CURDATE()) + INTERVAL 1 DAY 
                                THEN 1 ELSE 0 END), 0) AS totalBilledTreatmentsThisMonth,
    
            COALESCE(SUM(CASE WHEN hh.healthhistoryTotalBill = 0 AND hh.healthhistoryReferredTo IS NULL 
                                AND hh.healthhistoryDate >= DATE_FORMAT(CURDATE(), "%Y-%m-01") 
                                AND hh.healthhistoryDate < LAST_DAY(CURDATE()) + INTERVAL 1 DAY 
                                THEN 1 ELSE 0 END), 0) AS totalFreeTreatmentsThisMonth,
    
            COALESCE(SUM(CASE WHEN hh.healthhistoryReferredTo IS NOT NULL 
                                AND hh.healthhistoryDate >= DATE_FORMAT(CURDATE(), "%Y-%m-01") 
                                AND hh.healthhistoryDate < LAST_DAY(CURDATE()) + INTERVAL 1 DAY 
                                THEN 1 ELSE 0 END), 0) AS totalReferredTreatmentsThisMonth,
    
            COALESCE(COUNT(CASE WHEN hh.healthhistoryDate >= DATE_FORMAT(CURDATE(), "%Y-%m-01") 
                                AND hh.healthhistoryDate < LAST_DAY(CURDATE()) + INTERVAL 1 DAY 
                                THEN hh.healthhistoryId ELSE NULL END), 0) AS totalTreatmentsThisMonth
        ');
        $this->db->from('family f');
        $this->db->join('healthhistory hh', 'hh.patientNIK = f.familyNIK', 'left');
        $this->db->where('f.employeeNIK', $employeeNIK);
        $this->db->group_by('f.familyNIK');
        return $this->db->get()->result_array();
    }

    public function getFamilyByNIK($familyNIK) {
        $this->db->select('f.*, 
            i.insuranceTier, i.insuranceAmount, 
            c.companyName, c.companyStatus, 
            e.employeeDepartment, e.employeeBand
        ');
        $this->db->from('family f');
        $this->db->join('employee e', 'e.employeeNIK = f.employeeNIK', 'left');
        $this->db->join('insurance i', 'i.insuranceId = e.insuranceId', 'left');
        $this->db->join('company c', 'c.companyId = i.companyId', 'left');
        $this->db->where('f.familyNIK', $familyNIK);
        return $this->db->get()->row_array();
    }

    public function insertFamily($familyData) {
        return $this->db->insert('family', $familyData);
    }

    public function checkFamily($param, $familyData) {
        return $this->db->get_where('family', array($param => $familyData))->row_array();
    }
    
    public function updateFamily($familyNIK, $familyData) {
        $this->db->trans_start();

        $this->db->where('familyNIK', $familyNIK);
        $this->db->update('family', $familyData);

        if (!empty($familyData['familyNIK']) && $familyData['familyNIK'] !== $familyNIK) {
            $this->db->where('familyNIK', $familyData['familyNIK']);
            $existingFamily = $this->db->get('family')->row();

            if (!empty($existingFamily)) {
                $this->db->trans_rollback();
                return FALSE;
            }

            $this->db->where('patientNIK', $familyNIK);
            $updateHealthHistory = $this->db->update('healthhistory', array('patientNIK' => $familyData['familyNIK']));

            if (!$updateHealthHistory) {
                $this->db->trans_rollback();
                return FALSE;
            }
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function deleteFamily($familyNIK) {
        $this->db->where('familyNIK', $familyNIK);
        return $this->db->delete('family');
    }

    public function getEmployeeNameByNIK($employeeNIK)
    {
        $this->db->select('employeeName'); // Asumsikan ada kolom 'employeeName'
        $this->db->where('employeeNIK', $employeeNIK);
        $query = $this->db->get('employee'); // Asumsikan tabelnya bernama 'employee'
        
        if ($query->num_rows() > 0) {
            return $query->row()->employeeName;
        }
        
        return null; // Jika tidak ada nama ditemukan
    }

}

/* End of file M_companies.php */

?>