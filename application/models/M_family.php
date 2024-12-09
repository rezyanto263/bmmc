<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_family extends CI_Model {

    public function getAllFamilyDatas($companyId) {
        // Select fields from the family table
        $this->db->select('family.*');
        // From the family table
        $this->db->from('family');
        // Join with the policyholder table on policyholderNIN
        $this->db->join('policyholder', 'policyholder.policyholderNIN = family.policyholderNIN');
        // Join with the compolder table to filter by companyId
        $this->db->join('compolder', 'compolder.policyholderNIN = policyholder.policyholderNIN');
        // Where the companyId matches the given company ID
        $this->db->where('compolder.companyId', $companyId);
        // Execute the query and return the results
        return $this->db->get()->result_array();
    }

    public function getCompanyByAdminId($adminId)
    {
        $this->db->where('adminId', $adminId);
        $query = $this->db->get('company'); // Ganti dengan nama tabel yang sesuai
        return $query->row_array(); // Mengambil satu baris data
    }
    

    public function getFamiliesByPolicyholderNIN($policyholderNIN) {
        $this->db->select('family.*');
        $this->db->from('family');
        $this->db->where('policyholderNIN', $policyholderNIN); // Filter berdasarkan policyholderNIN
        return $this->db->get()->result_array();
    }
    
    public function insertFamily($familyData) {
        return $this->db->insert('family', $familyData);
    }
    
    public function updateFamily($familyNIN, $familyData) {
        $this->db->where('familyNIN', $familyNIN);
        return $this->db->update('family', $familyData);
    }

    public function deleteFamily($familyNIN) {
        $this->db->where('familyNIN', $familyNIN);
        return $this->db->delete('family');
    }

}

/* End of file M_companies.php */

?>