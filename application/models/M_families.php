<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_families extends CI_Model {

    public function getAllFamilyDatas() {
        $this->db->select('f.*, e.employeeName, eh.employeehistoryDepartment AS employeeDepartment, eh.employeehistoryBand AS employeeBand');
        $this->db->from('family f');
        $this->db->join('employee e', 'e.employeeNIK = f.employeeNIK');
        $this->db->join(
            '(SELECT eh1.* FROM employeehistory eh1
                JOIN (SELECT employeeNIK, MAX(employeehistoryStartedAt) AS latestHistory
                        FROM employeehistory GROUP BY employeeNIK) latest
                ON eh1.employeeNIK = latest.employeeNIK 
                AND eh1.employeehistoryStartedAt = latest.latestHistory) eh',
            'eh.employeeNIK = e.employeeNIK');
        return $this->db->get()->result_array();
    }

    public function getAllFamilyDatasByCompanyId($companyId) {
        $this->db->select('f.*, e.employeeName, eh.employeehistoryDepartment AS employeeDepartment, eh.employeehistoryBand AS employeeBand');
        $this->db->from('family f');
        $this->db->join('employee e', 'e.employeeNIK = f.employeeNIK');
        $this->db->join(
            '(SELECT eh1.* FROM employeehistory eh1
                JOIN (SELECT employeeNIK, MAX(employeehistoryStartedAt) AS latestHistory
                        FROM employeehistory GROUP BY employeeNIK) latest
                ON eh1.employeeNIK = latest.employeeNIK 
                AND eh1.employeehistoryStartedAt = latest.latestHistory) eh',
            'eh.employeeNIK = e.employeeNIK');
        $this->db->where('eh.companyId', $companyId);
        return $this->db->get()->result_array();
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
        $this->db->join(
            '(SELECT eh1.* FROM employeehistory eh1
                JOIN (SELECT employeeNIK, MAX(employeehistoryStartedAt) AS latestHistory
                        FROM employeehistory GROUP BY employeeNIK) latest
                ON eh1.employeeNIK = latest.employeeNIK 
                AND eh1.employeehistoryStartedAt = latest.latestHistory) eh',
            'eh.employeeNIK = e.employeeNIK');
        $this->db->join('company c', 'c.companyId = eh.companyId', 'left');
        $this->db->join('insurance i', 'i.insuranceId = eh.insuranceId', 'left');
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

        $this->db->where('familyNIK', $familyNIK);
        $updateFamily = $this->db->update('family', $familyData);
        if (!$updateFamily) {
            $this->db->trans_rollback();
            return FALSE;
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function deleteFamily($familyNIK) {
        $this->db->where('familyNIK', $familyNIK);
        return $this->db->delete('family');
    }

}

/* End of file M_companies.php */

?>