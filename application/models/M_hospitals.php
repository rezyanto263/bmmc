<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_hospitals extends CI_Model {

    public function getAllHospitalsDatas() {
        $this->db->select('h.*, a.adminEmail, a.adminName, a.adminStatus');
        $this->db->from('hospital h');
        $this->db->join('admin a', 'a.adminId = h.adminId', 'left');
        return $this->db->get()->result_array();
    }

    public function checkHospital($param, $data) {
        return $this->db->get_where('hospital', array($param => $data))->row_array();
    }

    public function insertHospital($hospitalDatas) {
        return $this->db->insert('hospital', $hospitalDatas);
    }

    public function updateHospital($hospitalId, $hospitalDatas) {
        $this->db->where('hospitalId', $hospitalId);
        return $this->db->update('hospital', $hospitalDatas);
    }

    public function deleteHospital($hospitalId) {
        $this->db->where('hospitalId', $hospitalId);
        return $this->db->delete('hospital');
    }

}

/* End of file M_hospitals.php */

?>