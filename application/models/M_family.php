<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_family extends CI_Model {

    public function getAllFamilyDatas($companyId) {
        // Select fields from the family table
        $this->db->select('family.*');
        // From the family table
        $this->db->from('family');
        // Join with the employee table on employeeNIK
        $this->db->join('employee', 'employee.employeeNIK = family.employeeNIK');
        // Join with the insurance table to filter by companyId
        $this->db->join('insurance', 'insurance.insuranceId = employee.insuranceId');
        // Where the companyId matches the given company ID
        $this->db->where('insurance.companyId', $companyId);
        // Execute the query and return the results
        return $this->db->get()->result_array();
    }

    public function getCompanyByAdminId($adminId)
    {
        $this->db->where('adminId', $adminId);
        $query = $this->db->get('company'); // Ganti dengan nama tabel yang sesuai
        return $query->row_array(); // Mengambil satu baris data
    }
    

    public function getFamiliesByEmployeeNIK($employeeNIK) {
        $this->db->select('family.*');
        $this->db->from('family');
        $this->db->where('employeeNIK', $employeeNIK); // Filter berdasarkan employeeNIK
        return $this->db->get()->result_array();
    }
    
    public function insertFamily($familyData) {
        return $this->db->insert('family', $familyData);
    }
    
    public function updateFamily($familyNIK, $familyData) {
        $this->db->where('familyNIK', $familyNIK);
        return $this->db->update('family', $familyData);
    }

    public function deleteFamily($familyNIK) {
        $this->db->where('familyNIK', $familyNIK);
        return $this->db->delete('family');
    }

    public function getEmployeeNameByNIK($employeeNIK)
    {
        $this->db->select('employeeName'); // Asumsikan ada kolom 'employeeName'
        $this->db->where('employeeNIK', $employeeNIK);
        $query = $this->db->get('employee'); // Asumsikan tabelnya bernama 'employee'
        
        if ($query->num_rows() > 0) {
            return $query->row()->employeeName;
        }
        
        return null; // Jika tidak ada nama ditemukan
    }


}

/* End of file M_companies.php */

?>