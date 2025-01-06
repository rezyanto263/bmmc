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

    public function countPolicyholderByCompanyId($companyId) {
        $this->db->select('COUNT(*) as count');
        $this->db->from('compolder');
        $this->db->where('companyId', $companyId);
        $query = $this->db->get();
        return $query->row()->count;
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

    public function getPolicyholderByNIK($policyholderNIK) {
        $this->db->select('p.*, c.companyName');
        $this->db->from('policyholder p');
        $this->db->join('compolder cp', 'cp.policyholderNIK = p.policyholderNIK', 'left');
        $this->db->join('company c', 'c.companyId = cp.companyId', 'left');
        $this->db->where('p.policyholderNIK', $policyholderNIK);
        return $this->db->get()->row_array();
    }

    public function getFamilyByNIK($familyNIK) {
        $this->db->select('f.*, c.companyName');
        $this->db->from('family f');
        $this->db->join('compolder cp', 'cp.policyholderNIK = f.policyholderNIK', 'left');
        $this->db->join('company c', 'c.companyId = cp.companyId', 'left');
        $this->db->where('f.familyNIK', $familyNIK);
        return $this->db->get()->row_array();
    }

}

/* End of file M_companies.php */

?>