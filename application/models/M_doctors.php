<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_doctors extends CI_Model {

    public function getHospitalDoctorsDatas($param, $data) {
        return $this->db->get_where('doctor', array($param => $data))->result_array();
    }

    public function getAllDoctors() {
        $this->db->select('d.*, h.hospitalLogo, h.hospitalName');
        $this->db->from('doctor d');
        $this->db->join('hospital h', 'h.hospitalId = d.hospitalId', 'left');
        return $this->db->get()->result_array();
    }

    public function getAllDoctorsByHospitalId($hospitalId) {
        return $this->db->get_where('doctor', array('hospitalId' => $hospitalId))->result_array();
    }

    public function getAllDoctorSpecialization() {
        $this->db->distinct();
        $this->db->select('GROUP_CONCAT(d.doctorSpecialization SEPARATOR ", ") AS specializationName');
        $this->db->from('doctor d');
        return $this->db->get()->row()->specializationName;
    }
    
    public function insertDoctor($doctorDatas) {
        return $this->db->insert('doctor', $doctorDatas);
    }

    public function updateDoctor($doctorId, $doctorDatas) {
        $this->db->where('doctorId', $doctorId);
        return $this->db->update('doctor', $doctorDatas);
    }

    public function deleteDoctor($doctorId) {
        $this->db->where('doctorId', $doctorId);
        return $this->db->delete('doctor');
    }
}

/* End of file M_doctors.php */

?>