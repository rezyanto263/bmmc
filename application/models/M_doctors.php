<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_doctors extends CI_Model {

    public function getHospitalDoctorsDatas($param, $data) {
        return $this->db->get_where('doctor', array($param => $data))->result_array();
    }

    public function insertDoctor($doctorDatas) {
        return $this->db->insert('doctor', $doctorDatas);
    }

    public function updateDoctor($doctorEIN, $doctorDatas) {
        $this->db->where('doctorEIN', $doctorEIN);
        return $this->db->update('doctor', $doctorDatas);
    }

    public function deleteDoctor($doctorEIN) {
        $this->db->where('doctorEIN', $doctorEIN);
        return $this->db->delete('doctor');
    }
}

/* End of file M_doctors.php */

?>