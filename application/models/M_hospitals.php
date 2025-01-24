<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_hospitals extends CI_Model {

    public function getAllHospitalsDatas() {
        $this->db->select('h.*, a.adminEmail, a.adminName');
        $this->db->from('hospital h');
        $this->db->join('admin a', 'a.adminId = h.adminId', 'left');
        return $this->db->get()->result_array();
    }

    public function checkHospital($param, $data) {
        return $this->db->get_where('hospital', array($param => $data))->row_array();
    }

    public function countHospitalDoctorByHospitalId($hospitalId) {
        $this->db->select('COUNT(*) as count');
        $this->db->from('doctor');
        $this->db->where('hospitalId', $hospitalId);
        $query = $this->db->get();
        return $query->row()->count;
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

    public function getPatientHistoryHealthDetailsByNIK($patientNIK) {
        $this->db->select('hh.*, h.hospitalName, d.doctorName, 
                            GROUP_CONCAT(DISTINCT ds.diseaseName SEPARATOR "|") AS diseaseNames,
                            GROUP_CONCAT(DISTINCT ds.diseaseInformation SEPARATOR "|") AS diseaseInformations,
                            CASE 
                                WHEN hh.historyhealthReferredTo IS NOT NULL THEN "referred"
                                WHEN hh.historyhealthTotalBill = 0 THEN "free"
                                ELSE IFNULL(i.invoiceStatus, "unpaid")
                            END AS status
        ');
        $this->db->from('historyhealth hh');
        $this->db->join('billing b', 'b.billingId = hh.billingId', 'left');
        $this->db->join('invoice i', 'i.billingId = b.billingId', 'left');
        $this->db->join('hospital h', 'h.hospitalId = hh.hospitalId', 'left');
        $this->db->join('doctor d', 'd.doctorId = hh.doctorId', 'left');
        $this->db->join('hisealtheas hd', 'hd.historyhealthId = hh.historyhealthId', 'left');
        $this->db->join('disease ds', 'ds.diseaseId = hd.diseaseId', 'left');
        $this->db->where('hh.patientNIK', $patientNIK);
        $this->db->group_by('hh.patientNIK');
        return $this->db->get()->result_array();
    }

    public function getActiveHospitalsDatas() {
        return $this->db->get_where('hospital', array('hospitalStatus' => 'active'))->result_array();
    }

    public function getHospitalQueueDatas($hospitalId) {
        $this->db->select('q.*, e.employeeName, f.familyName, c.companyId, c.companyName, i.insuranceAmount');
        $this->db->from('queue q');
        $this->db->order_by('q.createdAt', 'ASC');
        $this->db->join('family f', 'f.familyNIK = q.patientNIK', 'left');
        $this->db->join('employee e', '(e.employeeNIK = q.patientNIK OR e.employeeNIK = f.employeeNIK)', 'left');
        $this->db->join('insurance i', 'i.insuranceId = e.insuranceId', 'left');
        $this->db->join('company c', 'c.companyId = i.companyId', 'left');
        $this->db->where_in('q.hospitalId', $hospitalId);
        return $this->db->get()->result_array();
    }
    
    public function getDiseaseDatas()
    {
        return $this->db->get('disease')->result_array();
    }

    public function getCompanyInsuredDisease($companyId)
    {
        $this->db->select('d.*');
        $this->db->from('compease c');
        $this->db->join('disease d', 'd.diseaseId = c.diseaseId', 'left');
        $this->db->where_in('c.companyId', (array) $companyId);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function addQueue($patientNIK, $hospitalId) {
        $data = array(
            'patientNIK' => $patientNIK,
            'hospitalId' => $hospitalId
        );
        return $this->db->insert('queue', $data);
    }

    public function deleteQueue($patientNIK, $hospitalId) {
        $this->db->where('patientNIK', $patientNIK);
        $this->db->where('hospitalId', $hospitalId);
        return $this->db->delete('queue');
    }
}

/* End of file M_hospitals.php */

?>