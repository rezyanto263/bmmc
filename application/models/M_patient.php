<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_patient extends CI_Model {
    public function getPatientDataByNIK($patientNIK) {
        $this->db->select('f.*, ph.*, c.companyName');
        $this->db->from('family f');
        $this->db->where('f.familyNIK', $patientNIK);
        $this->db->join('policyholder ph', 'ph.policyholderNIK = f.policyholderNIK', 'left');
        $this->db->join('compolder cp', 'cp.policyholderNIK = ph.policyholderNIK', 'left');
        $this->db->join('company c', 'c.companyId = cp.companyId', 'left');
        $result = $this->db->get();
    
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            $this->db->select('ph.*, c.companyName');
            $this->db->from('policyholder ph');
            $this->db->where('ph.policyholderNIK', $patientNIK);
            $this->db->join('compolder cp', 'cp.policyholderNIK = ph.policyholderNIK', 'left');
            $this->db->join('company c', 'c.companyId = cp.companyId', 'left');
            return $this->db->get()->result_array();
        }
    }
}

/* End of file M_historyhealth.php */

?>