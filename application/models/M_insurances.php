<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_insurances extends CI_Model {

    public function getAllInsuranceByCompanyId($companyId) {
        return $this->db->get_where('insurance', array('companyId' => $companyId))->result_array();
    }

    public function getInsuranceDetailsByEmployeeNIK($employeeNIK) {
        // Langkah 1: Buat temporary table/view untuk pasien
        $patients_query = $this->db->query("
            SELECT employeeNIK AS patientNIK, insuranceId 
            FROM employee 
            WHERE employeeNIK = ?
            UNION 
            SELECT f.familyNIK AS patientNIK, e.insuranceId
            FROM family f
            JOIN employee e ON f.employeeNIK = e.employeeNIK
            WHERE f.employeeNIK = ?
        ", [$employeeNIK, $employeeNIK]);
        
        // Jika tidak ada data pasien, return array kosong
        if ($patients_query->num_rows() == 0) {
            return [];
        }
        
        // Langkah 2: Dapatkan semua patientNIK 
        $patients = $patients_query->result_array();
        $patientNIKs = [];
        $insuranceId = null;
        
        foreach ($patients as $patient) {
            $patientNIKs[] = $patient['patientNIK'];
            // Ambil insuranceId dari baris pertama
            if ($insuranceId === null) {
                $insuranceId = $patient['insuranceId'];
            }
        }
        
        // Langkah 3: Dapatkan informasi asuransi
        $insurance_query = $this->db->query("
            SELECT 
                i.insuranceId,
                i.insuranceTier,
                i.insuranceAmount,
                c.companyStatus
            FROM insurance i
            LEFT JOIN company c ON c.companyId = i.companyId
            WHERE i.insuranceId = ?
        ", [$insuranceId]);
        
        $insurance_data = $insurance_query->row_array();
        
        if (empty($insurance_data)) {
            return [];
        }
        
        // Langkah 4: Dapatkan statistik riwayat kesehatan
        $placeholders = implode(',', array_fill(0, count($patientNIKs), '?'));
        
        $stats_query = $this->db->query("
            SELECT
                COUNT(DISTINCT healthhistoryId) AS totalTreatments,
                COUNT(DISTINCT CASE WHEN healthhistoryTotalBill != 0 AND healthhistoryReferredTo IS NULL THEN healthhistoryId END) AS totalBilledTreatments,
                COUNT(DISTINCT CASE WHEN healthhistoryTotalBill = 0 AND healthhistoryReferredTo IS NULL THEN healthhistoryId END) AS totalFreeTreatments,
                COUNT(DISTINCT CASE WHEN healthhistoryReferredTo IS NOT NULL THEN healthhistoryId END) AS totalReferredTreatments,
                COALESCE(SUM(healthhistoryTotalBill), 0) AS totalBillingUsed,
                
                COUNT(DISTINCT CASE WHEN healthhistoryTotalBill != 0 AND healthhistoryReferredTo IS NULL 
                    AND MONTH(healthhistoryDate) = MONTH(CURDATE()) AND YEAR(healthhistoryDate) = YEAR(CURDATE()) 
                    THEN healthhistoryId END) AS totalBilledTreatmentsThisMonth,
                
                COUNT(DISTINCT CASE WHEN healthhistoryTotalBill = 0 AND healthhistoryReferredTo IS NULL 
                    AND MONTH(healthhistoryDate) = MONTH(CURDATE()) AND YEAR(healthhistoryDate) = YEAR(CURDATE()) 
                    THEN healthhistoryId END) AS totalFreeTreatmentsThisMonth,
                
                COUNT(DISTINCT CASE WHEN healthhistoryReferredTo IS NOT NULL 
                    AND MONTH(healthhistoryDate) = MONTH(CURDATE()) AND YEAR(healthhistoryDate) = YEAR(CURDATE()) 
                    THEN healthhistoryId END) AS totalReferredTreatmentsThisMonth,
                
                COUNT(DISTINCT CASE WHEN MONTH(healthhistoryDate) = MONTH(CURDATE()) AND YEAR(healthhistoryDate) = YEAR(CURDATE())  
                    THEN healthhistoryId END) AS totalTreatmentsThisMonth,
                
                COALESCE(SUM(CASE WHEN MONTH(healthhistoryDate) = MONTH(CURDATE()) AND YEAR(healthhistoryDate) = YEAR(CURDATE())
                    THEN healthhistoryTotalBill ELSE 0 END), 0) AS totalBillingUsedThisMonth
            FROM healthhistory
            WHERE patientNIK IN ($placeholders)
        ", $patientNIKs);
        
        $stats_data = $stats_query->row_array();
        
        // Langkah 5: Gabungkan semua data
        return array_merge($insurance_data, $stats_data);
    }

    public function getInsuranceById($insuranceId) {
        return $this->db->get_where('insurance', array('insuranceId' => $insuranceId))->row_array();
    }

    public function getLastBillingUnallocatedAmountByCompanyId($companyId) {
        $this->db->select('
            COALESCE(
                (
                    SELECT SUM(b.billingAmount) 
                    FROM billing b 
                    WHERE b.companyId = c.companyId
                    ORDER BY b.billingEndedAt DESC 
                    LIMIT 1
                ), 0
            ) - 
            COALESCE(
                (
                    SELECT SUM(i.insuranceAmount) 
                    FROM employee e
                    LEFT JOIN insurance i ON i.insuranceId = e.insuranceId
                    WHERE i.companyId = c.companyId
                ), 0
            ) AS totalUnallocatedAmount
        ');
        $this->db->from('company c');
        $this->db->where('c.companyId', $companyId);
    
        return $this->db->get()->row()->totalUnallocatedAmount;
    }

    public function getTotalAllocatedAmountByCompanyId($companyId) {
        $this->db->select('COALESCE(SUM(i.insuranceAmount), 0) AS totalAllocatedAmount');
        $this->db->from('employee e');
        $this->db->join('insurance i', 'i.insuranceId = e.insuranceId', 'left');
        $this->db->where('e.companyId', $companyId);
    
        return $this->db->get()->row_array();
    }

    public function checkInsurance($param, $value) {
        return $this->db->get_where('insurance', array($param => $value))->row_array();
    }

    public function insertInsurance($insuranceData) {
        return $this->db->insert('insurance', $insuranceData);
    }

    public function updateInsurance($insuranceId, $insuranceData) {
        $this->db->where('insuranceId', $insuranceId);
        return $this->db->update('insurance', $insuranceData);
    }

    public function deleteInsurance($insuranceId) {
        $this->db->where('insuranceId', $insuranceId);
        return $this->db->delete('insurance');
    }

}

/* End of file M_insurances.php */

?>