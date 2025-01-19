<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_insurance extends CI_Model {

    public function getAllInsuranceByCompanyId($companyId) {
        return $this->db->get_where('insurance', array('companyId' => $companyId))->result_array();
    }

    public function insertInsurance($insuranceData) {
        return $this->db->insert('insurance', $insuranceData);
    }

    public function updateInsurance($insuranceId, $insuranceData) {
        $this->db->where('insuranceId', $insuranceId);
        return $this->db->update('insurance', $insuranceData);
    }

    public function deleteInsurance($insuranceId) {
        $this->db->where('insuranceId', $insuranceId);
        return $this->db->delete('insurance');
    }

    public function getInsuranceById($insuranceId) {
        return $this->db->get_where('insurance', array('insuranceId' => $insuranceId))->row_array();
    }

}

/* End of file M_insurance.php */

?>