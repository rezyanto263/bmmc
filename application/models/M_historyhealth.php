<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_historyhealth extends CI_Model {

    public function getHospitalHistoriesDatas($historyhealthIds) {
        $this->db->select('hh.*');
        $this->db->from('historyhealth hh');
        $this->db->where_in('hh.historyhealthId', $historyhealthIds);
        $query = $this->db->get();
    
        $results = array();
        foreach ($query->result() as $row) {
            $this->db->select('hh.*, ph.policyholderName, c.companyName, d.doctorName');
            $this->db->from('historyhealth hh');

            if ($row->historyhealthFamilyStatus == 'policyholder') {
                $this->db->join('policyholder ph', 'ph.policyholderNIN = hh.patientNIN', 'left');
            } else {
                $this->db->join('family f', 'f.familyNIN = hh.patientNIN', 'left');
                $this->db->join('policyholder ph', 'ph.policyholderNIN = f.policyholderNIN', 'left');
            }

            $this->db->join('compolder cp', 'cp.policyholderNIN = ph.policyholderNIN', 'left');
            $this->db->join('company c', 'c.companyId = cp.companyId', 'left');
            $this->db->join('doctor d', 'd.doctorId = hh.doctorId', 'left');
            $this->db->where('hh.historyhealthId', $row->historyhealthId);
            $result = $this->db->get()->row_array();
            $results[] = $result;
        }
        return $results;
    }
}

/* End of file M_historyhealth.php */

?>