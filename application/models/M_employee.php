<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_employee extends CI_Model {

    public function getAllEmployeesDatas($companyId) {
        $this->db->select('policyholder.*');
        $this->db->from('policyholder');
        $this->db->join('compolder', 'compolder.policyholderNIK = policyholder.policyholderNIK');
        $this->db->where('compolder.companyId', $companyId);
        return $this->db->get()->result_array();
    }
    
    public function getCompanyByAdminId($adminId)
    {
        $this->db->where('adminId', $adminId);
        $query = $this->db->get('company'); // Ganti dengan nama tabel yang sesuai
        return $query->row_array(); // Mengambil satu baris data
    }

    public function checkEmployee($param, $employeeData) {
        return $this->db->get_where('policyholder', array($param => $employeeData))->row_array();
    }

    public function insertEmployee($employeeData) {
        return $this->db->insert('policyholder', $employeeData);
    }
    
    public function insertCompolder($compolderData) {
        return $this->db->insert('compolder', $compolderData); // Ganti 'compolder' dengan nama tabel Anda
    }
    
    public function getEmployeeByNIK($policyholderNIK) {
        $this->db->where('policyholderNIK', $policyholderNIK);
        $query = $this->db->get('policyholder');  // pastikan 'employee' adalah nama tabel yang sesuai
        return $query->row_array();  // mengembalikan satu baris data
    }    

    public function updateEmployee($policyholderNIK, $employeeData) {
        $this->db->where('policyholderNIK', $policyholderNIK);
        return $this->db->update('policyholder', $employeeData);
    }
    
    public function updateCompolder($policyholderNIK, $compolderData) {
        $this->db->where('policyholderNIK', $policyholderNIK);
        return $this->db->update('compolder', $compolderData);
    }
    

    public function deleteEmployee($policyholderNIK) {
        // Hapus data terkait di tabel 'compolder' berdasarkan policyholderNIK
        $this->db->where('policyholderNIK', $policyholderNIK);
        $this->db->delete('compolder');
    
        // Setelah data di 'compolder' dihapus, hapus data di tabel 'policyholder'
        $this->db->where('policyholderNIK', $policyholderNIK);
        return $this->db->delete('policyholder');
    }
    

}

/* End of file M_employee.php */
