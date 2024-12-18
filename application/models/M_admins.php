<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_admins extends CI_Model {

    public function getAllAdminsDatas() {
        $this->db->where('adminEmail !=', $this->session->userdata('adminEmail'));
        return $this->db->get('admin')->result_array();
    }
    
    public function getAllUnconnectedHospitalAdminsDatas() {
        $this->db->select('a.*');
        $this->db->from('admin a');
        $this->db->join('hospital h', 'h.adminId = a.adminId', 'left');
        $this->db->join('company c', 'c.adminId = a.adminId', 'left');
        $this->db->where('h.adminId', NULL);
        $this->db->where('c.adminId', NULL);
        $this->db->where_not_in('adminRole', array('admin', 'company'));
        return $this->db->get()->result_array();
    }

    public function getAllUnconnectedCompanyAdminsDatas() {
        $this->db->select('a.*');
        $this->db->from('admin a');
        $this->db->join('hospital h', 'h.adminId = a.adminId', 'left');
        $this->db->join('company c', 'c.adminId = a.adminId', 'left');
        $this->db->where('h.adminId', NULL);
        $this->db->where('c.adminId', NULL);
        $this->db->where_not_in('adminRole', array('admin', 'hospital'));
        return $this->db->get()->result_array();
    }

    public function checkAdmin($param, $adminData) {
        return $this->db->get_where('admin', array($param => $adminData))->row_array();
    }

    public function insertAdmin($adminDatas) {
        return $this->db->insert('admin', $adminDatas);
    }

    public function updateAdmin($adminId, $adminDatas) {
        $this->db->where('adminId', $adminId);
        return $this->db->update('admin', $adminDatas);
    }

    public function deleteAdmin($adminId) {
        $this->db->where('adminId', $adminId);
        return $this->db->delete('admin');
    }

}

/* End of file M_admins.php */

?>