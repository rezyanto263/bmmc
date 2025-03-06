<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_employees extends CI_Model {

    public function getAllEmployeesByCompanyId($companyId) {
        $this->db->select('e.*, i.insuranceTier, i.insuranceAmount, i.insuranceDescription');
        $this->db->from('employee e');
        $this->db->join('insurance i', 'i.insuranceId = e.insuranceId');
        $this->db->where('i.companyId', $companyId);
        return $this->db->get()->result_array();
    }

    public function getEmployeeDetails($employeeNIK) {
        $this->db->select("
            SUM(CASE WHEN MONTH(hh.healthhistoryDate) = MONTH(CURDATE()) AND YEAR(hh.healthhistoryDate) = YEAR(CURDATE()) THEN hh.healthhistoryTotalBill ELSE 0 END) AS totalBillingUsed,
            COUNT(CASE WHEN hh.healthhistoryTotalBill != 0 AND hh.healthhistoryReferredTo IS NULL THEN hh.healthhistoryId ELSE NULL END) AS totalBilledTreatments,
            COUNT(CASE WHEN hh.healthhistoryTotalBill = 0 AND hh.healthhistoryReferredTo IS NULL THEN hh.healthhistoryId ELSE NULL END) AS totalFreeTreatments,
            COUNT(CASE WHEN hh.healthhistoryReferredTo IS NOT NULL THEN hh.healthhistoryId ELSE NULL END) AS totalReferredTreatments,
            COUNT(hh.healthhistoryId) AS totalTreatments,

            -- Current month treatment counts

            COUNT(CASE WHEN hh.healthhistoryTotalBill != 0 AND hh.healthhistoryReferredTo IS NULL AND MONTH(hh.healthhistoryDate) = MONTH(CURDATE()) AND YEAR(hh.healthhistoryDate) = YEAR(CURDATE()) THEN hh.healthhistoryId ELSE NULL END) AS totalBilledTreatmentsThisMonth,
            COUNT(CASE WHEN hh.healthhistoryTotalBill = 0 AND hh.healthhistoryReferredTo IS NULL AND MONTH(hh.healthhistoryDate) = MONTH(CURDATE()) AND YEAR(hh.healthhistoryDate) = YEAR(CURDATE()) THEN hh.healthhistoryId ELSE NULL END) AS totalFreeTreatmentsThisMonth,
            COUNT(CASE WHEN hh.healthhistoryReferredTo IS NOT NULL AND MONTH(hh.healthhistoryDate) = MONTH(CURDATE()) AND YEAR(hh.healthhistoryDate) = YEAR(CURDATE()) THEN hh.healthhistoryId ELSE NULL END) AS totalReferredTreatmentsThisMonth,
            COUNT(CASE WHEN MONTH(hh.healthhistoryDate) = MONTH(CURDATE()) AND YEAR(hh.healthhistoryDate) = YEAR(CURDATE()) THEN hh.healthhistoryId ELSE NULL END) AS totalTreatmentsThisMonth
        ");
        $this->db->from('employee e');
        $this->db->join('family f', 'f.employeeNIK = e.employeeNIK', 'left');
        $this->db->join('healthhistory hh', 'hh.patientNIK = e.employeeNIK OR hh.patientNIK = f.familyNIK', 'left');
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
    
    public function getEmployeeByNIK($employeeNIK) {
        $this->db->select('e.*, 
            i.insuranceTier, i.insuranceAmount, 
            c.companyName, c.companyStatus, 
            "employee" AS familyRelationship
        ');
        $this->db->from('employee e');
        $this->db->join('insurance i', 'i.insuranceId = e.insuranceId', 'left');
        $this->db->join('company c', 'c.companyId = i.companyId', 'left');
        $this->db->where('e.employeeNIK', $employeeNIK);
        return $this->db->get()->row_array();
    }

    public function getAllDepartmentByCompanyId($companyId) {
        $this->db->distinct();
        $this->db->select('e.employeeDepartment AS departmentName');
        $this->db->from('employee e');
        $this->db->join('insurance i', 'i.insuranceId = e.insuranceId', 'left');
        $this->db->where('i.companyId', $companyId);
        return $this->db->get()->result_array();
    }
    
    public function getAllBandByCompanyId($companyId) {
        $this->db->distinct();
        $this->db->select('e.employeeBand AS bandName');
        $this->db->from('employee e');
        $this->db->join('insurance i', 'i.insuranceId = e.insuranceId', 'left');
        $this->db->where('i.companyId', $companyId);
        return $this->db->get()->result_array();
    }
    

    public function checkEmployee($param, $employeeData) {
        return $this->db->get_where('employee', array($param => $employeeData))->row_array();
    }

    public function insertEmployee($employeeData) {
        return $this->db->insert('employee', $employeeData);
    }   

    public function updateEmployee($employeeNIK, $employeeData) {
        $this->db->trans_start();

        $this->db->where('employeeNIK', $employeeNIK);
        $this->db->update('employee', $employeeData);
        
        if (!empty($employeeData['employeeNIK']) && $employeeData['employeeNIK'] !== $employeeNIK) {
            $this->db->where('employeeNIK', $employeeData['employeeNIK']);
            $existingEmployee = $this->db->get('employee')->row();

            if (!empty($existingEmployee)) {
                $this->db->trans_rollback();
                return FALSE;
            }

            $this->db->where('patientNIK', $employeeNIK);
            $updateHealthHistory = $this->db->update('healthhistory', array('patientNIK' => $employeeData['employeeNIK']));

            if (!$updateHealthHistory) {
                $this->db->trans_rollback();
                return FALSE;
            }
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function deleteEmployee($employeeNIK) {
        $this->db->where('employeeNIK', $employeeNIK);
        return $this->db->delete('employee');
    }

}

/* End of file M_employee.php */
