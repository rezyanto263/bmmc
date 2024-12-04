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

}

/* End of file M_auth.php */

?>