<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_insurance extends CI_Model {

    public function getAllInsuranceByCompanyId($companyId) {
        return $this->db->get_where('insurance', array('companyId' => $companyId))->result_array();
    }

    public function insertInsurance($insuranceData) {
        return $this->db->insert('insurance', $insuranceData);
    }

}

/* End of file M_insurance.php */

?>