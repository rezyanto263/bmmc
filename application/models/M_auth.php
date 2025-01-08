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

    public function checkPolicyHolder($param, $policyholderData) {
        return $this->db->get_where('policyholder', array($param => $policyholderData))->row_array();
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

    public function getPolicyHolderDataById($policyholderId) {
        $this->db->select('policyholderNIK, policyholderName, policyholderEmail, policyholderAddress, policyholderBirth, policyholderGender, policyholderPassword, policyholderStatus, policyholderPhoto');
        $this->db->from('policyholder');
        $this->db->where('policyholderNIK', $policyholderId);
        return $this->db->get()->row_array();
    }

    public function updateEmployee($policyholderId, $employeeData) {
        $this->db->where('policyholderNIK', $policyholderId);
        return $this->db->update('policyholder', $employeeData);
    }

    public function getFamilyDataById($familyId) {
        $this->db->select('familyNIK, familyName, familyEmail, policyholderNIK, familyAddress, familyBirth, familyGender, familyPassword, familyStatus, familyPhoto');
        $this->db->from('family');
        $this->db->where('familyNIK', $familyId);
        return $this->db->get()->row_array();
    }

    public function updateFamily($familyNIK, $familyData) {
        $this->db->where('familyNIK', $familyNIK);
        return $this->db->update('family', $familyData);
    }

    public function validatePolicyHolderLogin($NIK, $password) {
        $this->db->select('policyholderNIK, policyholderPassword');
        $this->db->from('policyholder');
        $this->db->where('policyholderNIK', $NIK);
        $userData = $this->db->get()->row_array();

        if ($userData && password_verify($password, $userData['policyholderPassword'])) {
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

    public function getFamilyMembersByPolicyHolder($policyholderId) {
        $this->db->select('familyNIK, familyName, familyAddress, familyBirth, familyGender, familyStatus, familyPhoto');
        $this->db->from('family');
        $this->db->where('policyholderNIK', $policyholderId);
        return $this->db->get()->result_array();
    }

    public function updatePolicyHolderPassword($policyholderId, $newPassword) {
        $this->db->where('policyholderNIK', $policyholderId);
        return $this->db->update('policyholder', array('policyholderPassword' => password_hash($newPassword, PASSWORD_DEFAULT)));
    }

    public function updateFamilyPassword($familyId, $newPassword) {
        $this->db->where('familyNIK', $familyId);
        return $this->db->update('family', array('familyPassword' => password_hash($newPassword, PASSWORD_DEFAULT)));
    }

    public function getCurrentPasswordByNIK($policyholderNIK) {
        $this->db->select('policyholderPassword');
        $this->db->from('policyholder');
        $this->db->where('policyholderNIK', $policyholderNIK);
        $query = $this->db->get();
        $result = $query->row();
        
        if ($result) {
            return $result->policyholderPassword;
        }
        
        return null;  // If no password is found, return null
    }
    

    public function rememberPolicyHolderLogin($policyholderId, $rememberToken) {
        $this->db->where('policyholderNIK', $policyholderId);
        return $this->db->update('policyholder', array('rememberToken' => $rememberToken));
    }

    public function rememberFamilyLogin($familyId, $rememberToken) {
        $this->db->where('familyNIK', $familyId);
        return $this->db->update('family', array('rememberToken' => $rememberToken));
    }
}

/* End of file M_auth.php */

?>