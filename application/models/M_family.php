<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_family extends CI_Model {

    public function getAllFamilyDatas() {
        $this->db->select('family.*');
        $this->db->from('family');
        return $this->db->get()->result_array();
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