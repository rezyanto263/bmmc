<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_historyhealth extends CI_Model {

    public function getHospitalHistoriesDatas($hospitalId) {
        $this->db->select('hh.*');
        $this->db->from('historyhealth hh');
        $this->db->where_in('hh.hospitalId', $hospitalId);
        $this->db->order_by('hh.historyhealthDate', 'DESC');
        $query = $this->db->get();
    
        $results = array();
        foreach ($query->result() as $row) {
            $this->db->select('hh.*, e.employeeName, c.companyName, d.doctorName, in.invoiceStatus, di.diseaseName' . ($row->historyhealthRole != 'employee' ? ', f.familyName' : ''));
            $this->db->from('historyhealth hh');
            $this->db->join('doctor d', 'd.doctorId = hh.doctorId', 'left');
            $this->db->join('hisealtheas h', 'h.historyhealthId = hh.historyhealthId', 'left');
            $this->db->join('disease di', 'di.diseaseId = h.diseaseId', 'left');
    
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
            $this->db->where('hh.historyhealthId', $row->historyhealthId);
            $result = $this->db->get()->row_array();
            $results[] = $result;
        }
        return $results;
    }

    public function checkBillByPatientNIK($patientNIK, $role) {
        if ($role == 'Employee') {
            $this->db->from('employee e');
            $this->db->where('e.employeeNIK', $patientNIK);
        } else {
            $this->db->from('family f');
            $this->db->where('f.familyNIK', $patientNIK);
            $this->db->join('employee e', 'e.employeeNIK = f.employeeNIK', 'left');
        }

        $this->db->join('insurance i', 'i.insuranceId = e.insuranceId', 'left');
        $this->db->join('company c', 'c.companyId = i.companyId', 'left');
        $this->db->join('billing b', 'b.companyId = c.companyId', 'left');

        $this->db->select('b.billingId');
        return $this->db->get()->row_array();
    }

    public function insertReferral($referralDatas) {
        return $this->db->insert('historyhealth', $referralDatas);
    }

    public function insertTreatment($treatmentDatas) {
        return $this->db->insert('historyhealth', $treatmentDatas);
    }

    public function insertHisealtheas($historyhealthId, $diseaseId) {
        $hisealtheasData = array(
            'historyhealthId' => $historyhealthId,
            'diseaseId' => $diseaseId
        );
        return $this->db->insert('hisealtheas', $hisealtheasData);
    }

    public function getUserHistories($patientNIK, $role) {
        $this->db->select('hh.*, e.employeeName, h.hospitalName,f.familyName, d.doctorName, in.invoiceStatus, di.diseaseName');
        $this->db->from('historyhealth hh');
        $this->db->order_by('hh.historyhealthDate', 'DESC');
        
        $this->db->join('hospital h', 'h.hospitalId = hh.hospitalId', 'left');
        $this->db->join('doctor d', 'd.doctorId = hh.doctorId', 'left');
        $this->db->join('billing b', 'b.billingId = hh.billingId', 'left');
        $this->db->join('invoice in', 'in.billingId = b.billingId', 'left');
        $this->db->join('hisealtheas ht', 'ht.historyhealthId = hh.historyhealthId', 'left');
        $this->db->join('disease di', 'di.diseaseId = ht.diseaseId', 'left');
        $this->db->join('employee e', 'e.employeeNIK = hh.patientNIK', 'left');
        $this->db->join('family f', 'f.familyNIK = hh.patientNIK', 'left');
        $this->db->join('insurance i', 'i.insuranceId = e.insuranceId', 'left');
        $this->db->join('company c', 'c.companyId = i.companyId', 'left');
        
        if ($role == 'employee') {
            $this->db->where("hh.patientNIK = '$patientNIK' OR hh.patientNIK IN (SELECT familyNIK FROM family WHERE employeeNIK = '$patientNIK')");
        } else {
            $this->db->where('hh.patientNIK', $patientNIK);
        }
        
        $query = $this->db->get();
        return $query->result();
    }
}

/* End of file M_historyhealth.php */

?>