<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_doctors extends CI_Model {

    public function getAllDoctors() {
        $this->db->select('d.*, h.hospitalName');
        $this->db->from('doctor d');
        $this->db->join('hospital h', 'h.hospitalId = d.hospitalId', 'left');
        return $this->db->get()->result_array();
    }
}

/* End of file M_doctors.php */

?>