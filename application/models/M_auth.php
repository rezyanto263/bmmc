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
        $this->db->select('policyholderNIN, policyholderName, policyholderEmail, policyholderAddress, policyholderBirth, policyholderGender, policyholderPassword, policyholderStatus');
        $this->db->from('policyholder');
        $this->db->where('policyholderNIN', $policyholderId);
        return $this->db->get()->row_array();
    }

    public function getFamilyDataById($familyId) {
        $this->db->select('familyId, familyName, familyEmail, policyholderId, familyAddress, familyBirth, familyGender, familyPassword, familyStatus');
        $this->db->from('family');
        $this->db->where('familyId', $familyId);
        return $this->db->get()->row_array();
    }

    public function validatePolicyHolderLogin($nin, $password) {
        $this->db->select('policyholderId, policyholderPassword');
        $this->db->from('policyholder');
        $this->db->where('policyholderNIN', $nin);
        $userData = $this->db->get()->row_array();

        if ($userData && password_verify($password, $userData['policyholderPassword'])) {
            return $userData;
        }
        return FALSE;
    }

    public function validateFamilyLogin($nin, $password) {
        $this->db->select('familyId, familyPassword');
        $this->db->from('family');
        $this->db->where('familyNIN', $nin);
        $userData = $this->db->get()->row_array();
    
        if ($userData && password_verify($password, $userData['familyPassword'])) {
            return $userData;
        }
        return FALSE;
    }    

    public function getFamilyMembersByPolicyHolder($policyholderId) {
        $this->db->select('familyNIN, familyName, familyAddress, familyBirth, familyGender, familyStatus');
        $this->db->from('family');
        $this->db->where('policyholderNIN', $policyholderId);
        return $this->db->get()->result_array();
    }

    public function updatePolicyHolderPassword($policyholderId, $newPassword) {
        $this->db->where('policyholderId', $policyholderId);
        return $this->db->update('policyholder', array('policyholderPassword' => password_hash($newPassword, PASSWORD_DEFAULT)));
    }

    public function updateFamilyPassword($familyId, $newPassword) {
        $this->db->where('familyId', $familyId);
        return $this->db->update('family', array('familyPassword' => password_hash($newPassword, PASSWORD_DEFAULT)));
    }

    public function rememberPolicyHolderLogin($policyholderId, $rememberToken) {
        $this->db->where('policyholderId', $policyholderId);
        return $this->db->update('policyholder', array('rememberToken' => $rememberToken));
    }

    public function rememberFamilyLogin($familyId, $rememberToken) {
        $this->db->where('familyId', $familyId);
        return $this->db->update('family', array('rememberToken' => $rememberToken));
    }
}

/* End of file M_auth.php */

?>