<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_auth extends CI_Model {

    public function getAllAdmin() {
        return $this->db->get('admin')->result_array();
    }

    public function getCompanyDetails($adminId) {
        $this->db->select('companyId, companyName, companyLogo, companyPhone, companyAddress, companyCoordinate');
        $this->db->from('company');  // Assuming the table is named 'companies'
        $this->db->where('adminId', $adminId);
        $query = $this->db->get();
    
        return $query->row_array();  // Return company data as an associative array
    }
    public function checkAdmin($param, $adminData) {
        return $this->db->get_where('admin', array($param => $adminData))->row_array();
    }

    public function checkEmployee($param, $employeeData) {
        return $this->db->get_where('employee', array($param => $employeeData))->row_array();
    }

    public function checkFamily($param, $familyData) {
        return $this->db->get_where('family', array($param => $familyData))->row_array();
    }

    public function setAdminToken($adminEmail, $adminToken) {
        $this->db->where('adminEmail', $adminEmail);
        return $this->db->update('admin', array('adminToken' => $adminToken));
    }

    public function changeAdminPassword($adminToken, $adminPassword) {
        $this->db->where('adminToken', $adminToken);
        $this->db->update('admin', array('adminPassword' => $adminPassword, 'adminToken' => NULL));
    }

    public function getEmployeeDataById($employeeId) {
        $this->db->select('employeeNIK, insuranceId, employeeName, employeeEmail, employeeAddress, employeePhone, employeeBirth, employeeGender, employeePassword, employeeStatus, employeePhoto');
        $this->db->from('employee');
        $this->db->where('employeeNIK', $employeeId);
        return $this->db->get()->row_array();
    }

    public function getInsuranceByEmployeeId($employeeId)
    {
        // Mengambil insuranceId dari tabel employee berdasarkan employeeId
        $this->db->select('i.*,
                IFNULL(SUM(hh.historyhealthTotalBill), 0) AS totalBillingUsed,
        ');
        $this->db->from('employee e');
        $this->db->join('family f', 'f.employeeNIK = e.employeeNIK', 'left');
        $this->db->join('insurance i', 'i.insuranceId = e.insuranceId', 'left');
        $this->db->join('historyhealth hh', 'hh.patientNIK = e.employeeNIK OR hh.patientNIK = f.familyNIK', 'left');
        $this->db->where('e.employeeNIK', $employeeId);
        return $this->db->get()->row_array();
    }

    public function getInsuranceByFamilyId($familyId)
    {
        $this->db->select('i.*, IFNULL(SUM(hh.historyhealthTotalBill), 0) AS totalBillingUsed');
        $this->db->from('employee e');
        $this->db->join('family f', 'f.employeeNIK = e.employeeNIK', 'left');
        $this->db->join('insurance i', 'i.insuranceId = e.insuranceId', 'left');
        $this->db->join('historyhealth hh', 'hh.patientNIK = e.employeeNIK OR hh.patientNIK = f.familyNIK', 'left');
        $this->db->where('f.familyNIK', $familyId);        
        return $this->db->get()->row_array();
    }

    public function updateEmployee($employeeId, $employeeData) {
        $this->db->where('employeeNIK', $employeeId);
        return $this->db->update('employee', $employeeData);
    }

    public function getFamilyDataById($familyId) {
        $this->db->select('familyNIK, familyName, familyEmail, employeeNIK, familyAddress, familyBirth, familyPhone, familyGender, familyPassword, familyStatus');
        $this->db->from('family');
        $this->db->where('familyNIK', $familyId);
        return $this->db->get()->row_array();
    }

    public function updateFamily($familyId, $employeeData) {
        $this->db->where('familyNIK', $familyId);
        return $this->db->update('family', $employeeData);
    }

    public function validateEmployeeLogin($NIK, $password) {
        $this->db->select('employeeNIK, employeePassword');
        $this->db->from('employee');
        $this->db->where('employeeNIK', $NIK);
        $userData = $this->db->get()->row_array();

        if ($userData && password_verify($password, $userData['employeePassword'])) {
            return $userData;
        }
        return FALSE;
    }

    public function validateFamilyLogin($NIK, $password) {
        $this->db->select('familyNIK, familyPassword');
        $this->db->from('family');
        $this->db->where('familyNIK', $NIK);
        $userData = $this->db->get()->row_array();
    
        if ($userData && password_verify($password, $userData['familyPassword'])) {
            return $userData;
        }
        return FALSE;
    }    

    public function getFamilyMembersByEmployee($employeeNIK) {
        return $this->db->get_where('family', ['employeeNIK' => $employeeNIK])->result_array();
    }

    public function updateEmployeePassword($employeeId, $newPassword) {
        $this->db->where('employeeNIK', $employeeId);
        return $this->db->update('employee', array('employeePassword' => password_hash($newPassword, PASSWORD_DEFAULT)));
    }

    public function updateFamilyPassword($familyId, $newPassword) {
        $this->db->where('familyNIK', $familyId);
        return $this->db->update('family', array('familyPassword' => password_hash($newPassword, PASSWORD_DEFAULT)));
    }

    public function getCurrentPasswordByNIK($employeeNIK) {
        $this->db->select('employeePassword');
        $this->db->from('employee');
        $this->db->where('employeeNIK', $employeeNIK);
        $query = $this->db->get();
        $result = $query->row();
        
        if ($result) {
            return $result->employeePassword;
        }
        
        return null;  // If no password is found, return null
    }
    
    public function getCurrentPasswordByFamilyNIK($familyNIK) {
        $this->db->select('familyPassword');
        $this->db->from('family');
        $this->db->where('familyNIK', $familyNIK);
        $query = $this->db->get();
        $result = $query->row();
        
        if ($result) {
            return $result->familyPassword;
        }
        
        return null;  // If no password is found, return null
    }

    public function rememberEmployeeLogin($employeeId, $rememberToken) {
        $this->db->where('employeeNIK', $employeeId);
        return $this->db->update('employee', array('rememberToken' => $rememberToken));
    }

    public function rememberFamilyLogin($familyId, $rememberToken) {
        $this->db->where('familyNIK', $familyId);
        return $this->db->update('family', array('rememberToken' => $rememberToken));
    }
}

/* End of file M_auth.php */

?>