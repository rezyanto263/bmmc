<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_companies extends CI_Model {

    public function getAllCompaniesDatas() {
        $this->db->select('c.*, a.adminEmail, a.adminName, a.adminStatus');
        $this->db->from('company c');
        $this->db->join('admin a', 'a.adminId = c.adminId', 'left');
        return $this->db->get()->result_array();
    }

    public function getCompanyByAdminId($adminId)
    {
        $this->db->where('adminId', $adminId);
        $query = $this->db->get('company'); // Ganti dengan nama tabel yang sesuai
        return $query->row_array(); // Mengambil satu baris data
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

    public function getEmployeeByNIK($employeeNIK) {
        $this->db->select('e.*, c.companyName');
        $this->db->from('employee e');
        $this->db->join('insurance i', 'i.insuranceId = e.insuranceId', 'left');
        $this->db->join('company c', 'c.companyId = i.companyId', 'left');
        $this->db->where('e.employeeNIK', $employeeNIK);
        return $this->db->get()->row_array();
    }
    public function getFamilyByNIK($familyNIK) {
        $this->db->select('f.*, c.companyName');
        $this->db->from('family f');
        $this->db->join('employee e', 'e.employeeNIK = f.employeeNIK', 'left');
        $this->db->join('insurance i', 'i.insuranceId = e.insuranceId', 'left');
        $this->db->join('company c', 'c.companyId = i.companyId', 'left');
        $this->db->where('f.familyNIK', $familyNIK);
        return $this->db->get()->row_array();
    }


}

/* End of file M_companies.php */

?>