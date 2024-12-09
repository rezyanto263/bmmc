<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_historyhealth extends CI_Model {

    public function getHospitalHistoriesDatas($historyhealthIds) {
        $this->db->select('hh.*, ph.policyholderName, c.companyName');
        $this->db->from('historyhealth hh');
        $this->db->join('polderhisealth phh', 'phh.historyhealthId = hh.historyhealthId', 'left');
        $this->db->join('policyholder ph', 'ph.policyholderNIN = phh.policyholderNIN', 'left');
        $this->db->join('compolder cp', 'cp.policyholderNIN = ph.policyholderNIN', 'left');
        $this->db->join('company c', 'c.companyId = cp.companyId', 'left');
        $this->db->where_in('hh.historyhealthId', $historyhealthIds);
        return $this->db->get()->result_array();
    }
}

/* End of file M_historyhealth.php */

?>