<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_auth extends CI_Model {

    public function getAllAdmin() {
        $this->db->select('a.*,
            IF(a.adminRole = "company", c.companyStatus, 
                IF(a.adminRole = "hospital", h.hospitalStatus, NULL)) AS status
        ');
        $this->db->from('admin a');
        $this->db->join('company c', 'c.adminId = a.adminId', 'left');
        $this->db->join('hospital h', 'h.adminId = a.adminId', 'left');
        return $this->db->get()->result_array();
    }

    public function checkAdmin($param, $adminData) {
        $this->db->select('a.*,
            IF(a.adminRole = "company", c.companyStatus, 
                IF(a.adminRole = "hospital", h.hospitalStatus, NULL)) AS status
        ');
        $this->db->from('admin a');
        $this->db->join('company c', 'c.adminId = a.adminId', 'left');
        $this->db->join('hospital h', 'h.adminId = a.adminId', 'left');
        $this->db->where('a.' . $param, $adminData);
        return $this->db->get()->row_array();
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