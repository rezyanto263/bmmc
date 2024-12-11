<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_historyhealth extends CI_Model {

    public function getHospitalHistoriesDatas($historyhealthIds) {
        $this->db->select('hh.*, d.doctorName');
        $this->db->from('historyhealth hh');
        $this->db->join('doctor d', 'd.doctorId = hh.doctorId', 'left');
        $this->db->where_in('hh.historyhealthId', $historyhealthIds);
        return $this->db->get()->result_array();
    }
}

/* End of file M_historyhealth.php */

?>