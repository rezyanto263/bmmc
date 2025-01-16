<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_patient extends CI_Model {
    public function getPatientDataByNIK($patientNIK) {
        $this->db->select('f.*, e.*, c.companyName');
        $this->db->from('family f');
        $this->db->where('f.familyNIK', $patientNIK);
        $this->db->join('employee e', 'e.employeeNIK = f.employeeNIK', 'left');
        $this->db->join('compolder cp', 'cp.employeeNIK = e.employeeNIK', 'left');
        $this->db->join('company c', 'c.companyId = cp.companyId', 'left');
        $result = $this->db->get();
    
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            $this->db->select('e.*, c.companyName');
            $this->db->from('employee e');
            $this->db->where('e.employeeNIK', $patientNIK);
            $this->db->join('compolder cp', 'cp.employeeNIK = e.employeeNIK', 'left');
            $this->db->join('company c', 'c.companyId = cp.companyId', 'left');
            return $this->db->get()->result_array();
        }
    }
}

/* End of file M_historyhealth.php */

?>