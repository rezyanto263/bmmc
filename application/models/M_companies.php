<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_companies extends CI_Model {

    public function getAllCompaniesDatas() {
        $this->db->select('c.*, a.adminEmail, a.adminName, a.adminStatus');
        $this->db->from('company c');
        $this->db->join('admin a', 'a.adminId = c.adminId', 'left');
        return $this->db->get()->result_array();
    }

    public function checkCompany($param, $companyData) {
        return $this->db->get_where('company', array($param => $companyData))->row_array();
    }

    public function insertCompany($companyDatas) {
        return $this->db->insert('company', $companyDatas);
    }

    public function updateCompany($companyId, $companyDatas) {
        $this->db->where('companyId', $companyId);
        return $this->db->update('company', $companyDatas);
    }

    public function deleteCompany($companyId) {
        $this->db->where('companyId', $companyId);
        return $this->db->delete('company');
    }

}

/* End of file M_companies.php */

?>