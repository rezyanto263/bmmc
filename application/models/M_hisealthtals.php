<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_hisealthtals extends CI_Model {

    public function getHospitalHisealthtalsDatas($param, $data) {
        return $this->db->get_where('hisealthtal', array($param => $data))->result_array();
    }
}

/* End of file M_hisealthtals.php */

?>