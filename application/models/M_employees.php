<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_employees extends CI_Model {

    public function getAllEmployeesDatas($companyId) {
        $this->db->select('e.*, i.insuranceTier, i.insuranceAmount, i.insuranceDescription');
        $this->db->from('employee e');
        $this->db->join('insurance i', 'i.insuranceId = e.insuranceId');
        $this->db->where('i.companyId', $companyId);
        return $this->db->get()->result_array();
    }

    public function getEmployeeDetails($employeeNIK) {
        $this->db->select("
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
        ");
        $this->db->from('employee e');
        $this->db->join('family f', 'f.employeeNIK = e.employeeNIK', 'left');
        $this->db->join('historyhealth hh', 'hh.patientNIK = e.employeeNIK OR hh.patientNIK = f.familyNIK', 'left');
        $this->db->join('billing b', 'b.billingId = hh.billingId', 'left');
        $this->db->join('invoice i', 'b.billingId = hh.billingId', 'left');
        $this->db->where('e.employeeNIK', $employeeNIK);
        return $this->db->get()->result_array();
    }

    public function getCompanyByAdminId($adminId) {
        $this->db->where('adminId', $adminId);
        $query = $this->db->get('company');
        return $query->row_array();
    }

    public function checkEmployee($param, $employeeData) {
        return $this->db->get_where('employee', array($param => $employeeData))->row_array();
    }

    public function insertEmployee($employeeData) {
        return $this->db->insert('employee', $employeeData);
    }
    
    public function getEmployeeByNIK($employeeNIK) {
        $this->db->select('e.*, i.insuranceTier, i.insuranceAmount');
        $this->db->join('insurance i', 'i.insuranceId = e.insuranceId');
        $this->db->where('employeeNIK', $employeeNIK);
        $query = $this->db->get('employee');
        return $query->row_array();
    }    

    public function updateEmployee($employeeNIK, $employeeData) {
        $this->db->trans_start();

        $this->db->where('employeeNIK', $employeeNIK);
        $this->db->update('employee', $employeeData);
        
        if (!empty($employeeData['employeeNIK']) && $employeeData['employeeNIK'] !== $employeeNIK) {
            $this->db->where('patientNIK', $employeeNIK);
            $this->db->update('historyHealth', array('patientNIK' => $employeeData['employeeNIK']));
        }

        $this->db->trans_complete();

        return $this->db->trans_status() !== FALSE;
    }

    public function deleteEmployee($employeeNIK) {
        $this->db->where('employeeNIK', $employeeNIK);
        return $this->db->delete('employee');
    }
    

}

/* End of file M_employee.php */
