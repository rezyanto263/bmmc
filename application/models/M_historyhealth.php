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
            $select = 'hh.*, ph.policyholderName, c.companyName, d.doctorName';

            if ($row->historyhealthFamilyRole != 'policyholder') { 
                $select .= ', f.familyName';
            }

            $this->db->select($select, FALSE);
            $this->db->from('historyhealth hh');

            if ($row->historyhealthFamilyRole == 'policyholder') {
                $this->db->join('policyholder ph', 'ph.policyholderNIK = hh.patientNIK', 'left');
            } else {
                $this->db->join('family f', 'f.familyNIK = hh.patientNIK', 'left');
                $this->db->join('policyholder ph', 'ph.policyholderNIK = f.policyholderNIK', 'left');
            }

            $this->db->join('compolder cp', 'cp.policyholderNIK = ph.policyholderNIK', 'left');
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