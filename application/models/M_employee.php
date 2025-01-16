<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_employee extends CI_Model {

    public function getAllEmployeesDatas($companyId) {
        $this->db->select('employee.*');
        $this->db->from('employee');
        $this->db->join('compolder', 'compolder.employeeNIK = employee.employeeNIK');
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
        return $this->db->get_where('employee', array($param => $employeeData))->row_array();
    }

    public function insertEmployee($employeeData) {
        return $this->db->insert('employee', $employeeData);
    }
    
    public function insertCompolder($compolderData) {
        return $this->db->insert('compolder', $compolderData); // Ganti 'compolder' dengan nama tabel Anda
    }
    
    public function getEmployeeByNIK($employeeNIK) {
        $this->db->where('employeeNIK', $employeeNIK);
        $query = $this->db->get('employee');  // pastikan 'employee' adalah nama tabel yang sesuai
        return $query->row_array();  // mengembalikan satu baris data
    }    

    public function updateEmployee($employeeNIK, $employeeData) {
        $this->db->where('employeeNIK', $employeeNIK);
        return $this->db->update('employee', $employeeData);
    }
    
    public function updateCompolder($employeeNIK, $compolderData) {
        $this->db->where('employeeNIK', $employeeNIK);
        return $this->db->update('compolder', $compolderData);
    }
    

    public function deleteEmployee($employeeNIK) {
        // Hapus data terkait di tabel 'compolder' berdasarkan employeeNIK
        $this->db->where('employeeNIK', $employeeNIK);
        $this->db->delete('compolder');
    
        // Setelah data di 'compolder' dihapus, hapus data di tabel 'employee'
        $this->db->where('employeeNIK', $employeeNIK);
        return $this->db->delete('employee');
    }
    

}

/* End of file M_employee.php */
