<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_historyhealth extends CI_Model {

    public function getHospitalHistoriesDatas($hospitalId) {
        $this->db->select('hh.*');
        $this->db->from('historyhealth hh');
        $this->db->where_in('hh.hospitalId', $hospitalId);
        $query = $this->db->get();
    
        $results = array();
        foreach ($query->result() as $row) {
            $select = 'hh.*, e.employeeName, c.companyName, d.doctorName, in.invoiceStatus, di.diseaseName';
            $select .= ($row->historyhealthRole != 'employee') ? ', f.familyName' : '';
            $this->db->select($select, FALSE);
            $this->db->from('historyhealth hh');

            if ($row->historyhealthRole == 'employee') {
                $this->db->join('employee e', 'e.employeeNIK = hh.patientNIK', 'left');
            } else {
                $this->db->join('family f', 'f.familyNIK = hh.patientNIK', 'left');
                $this->db->join('employee e', 'e.employeeNIK = f.employeeNIK', 'left');
            }

            $this->db->join('insurance i', 'i.insuranceId = e.insuranceId', 'left');
            $this->db->join('company c', 'c.companyId = i.companyId', 'left');
            $this->db->join('billing b', 'b.companyId = c.companyId', 'left');
            $this->db->join('invoice in', 'in.billingId = b.billingId', 'left');
            $this->db->join('hisealtheas h', 'h.historyhealthId = hh.historyhealthId', 'left');
            $this->db->join('disease di', 'di.diseaseId = h.diseaseId', 'left');
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