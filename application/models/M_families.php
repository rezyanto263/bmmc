<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_families extends CI_Model {

    public function getAllFamilyDatas($companyId) {
        $this->db->select('family.*, employee.employeeName');
        $this->db->from('family');
        $this->db->join('employee', 'employee.employeeNIK = family.employeeNIK');
        $this->db->join('insurance', 'insurance.insuranceId = employee.insuranceId');
        $this->db->where('insurance.companyId', $companyId);
        return $this->db->get()->result_array();
    }

    public function getCompanyByAdminId($adminId)
    {
        $this->db->where('adminId', $adminId);
        $query = $this->db->get('company');
        return $query->row_array();
    }

    public function getFamiliesByEmployeeNIK($employeeNIK) {
        $this->db->select('
                f.*,
                SUM(CASE WHEN MONTH(hh.historyhealthDate) = MONTH(CURDATE()) THEN hh.historyhealthTotalBill ELSE 0 END) AS totalBillingUsed,
                COUNT(CASE WHEN hh.historyhealthTotalBill != 0 AND hh.historyhealthReferredTo IS NULL THEN hh.historyhealthId ELSE NULL END) AS totalBilledTreatments,
                COUNT(CASE WHEN hh.historyhealthTotalBill = 0 AND hh.historyhealthReferredTo IS NULL THEN hh.historyhealthId ELSE NULL END) AS totalFreeTreatments,
                COUNT(CASE WHEN hh.historyhealthReferredTo IS NOT NULL THEN hh.historyhealthId ELSE NULL END) AS totalReferredTreatments,
                COUNT(hh.historyhealthId) AS totalTreatments,

                -- Current month treatment counts

                COUNT(CASE WHEN hh.historyhealthTotalBill != 0 AND hh.historyhealthReferredTo IS NULL AND MONTH(hh.historyhealthDate) = MONTH(CURDATE()) THEN hh.historyhealthId ELSE NULL END) AS totalBilledTreatmentsThisMonth,
                COUNT(CASE WHEN hh.historyhealthTotalBill = 0 AND hh.historyhealthReferredTo IS NULL AND MONTH(hh.historyhealthDate) = MONTH(CURDATE()) THEN hh.historyhealthId ELSE NULL END) AS totalFreeTreatmentsThisMonth,
                COUNT(CASE WHEN hh.historyhealthReferredTo IS NOT NULL AND MONTH(hh.historyhealthDate) = MONTH(CURDATE()) THEN hh.historyhealthId ELSE NULL END) AS totalReferredTreatmentsThisMonth,
                COUNT(CASE WHEN MONTH(hh.historyhealthDate) = MONTH(CURDATE()) THEN hh.historyhealthId ELSE NULL END) AS totalTreatmentsThisMonth
        ');
        $this->db->from('family f');
        $this->db->join('historyhealth hh', 'hh.patientNIK = f.familyNIK', 'left');
        $this->db->where('f.employeeNIK', $employeeNIK);
        return $this->db->get()->result_array();
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
            $this->db->where('patientNIK', $familyNIK);
            $this->db->update('historyhealth', array('patientNIK' => $familyData['familyNIK']));
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