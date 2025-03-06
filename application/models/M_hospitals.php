<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_hospitals extends CI_Model {

    public function getAllHospitalsDatas() {
        $this->db->select('h.*, a.adminEmail, a.adminName');
        $this->db->from('hospital h');
        $this->db->join('admin a', 'a.adminId = h.adminId', 'left');
        return $this->db->get()->result_array();
    }

    public function getHospitalByAdminId($adminId) {
        $this->db->where('adminId', $adminId);
        $query = $this->db->get('hospital');
        return $query->row_array();
    }

    public function getHospitalDetailsByHospitalId($hospitalId) {
        $this->db->select('
                h.hospitalId,
                
                -- Doctors
                IFNULL(COUNT(DISTINCT d.doctorId), 0) AS totalDoctors,
                COUNT(DISTINCT CASE WHEN d.doctorStatus = "active" THEN d.doctorId ELSE NULL END) AS totalActiveDoctors,
                COUNT(DISTINCT CASE WHEN d.doctorStatus = "disabled" THEN d.doctorId ELSE NULL END) AS totalDisabledDoctors,
    
                -- All Treatments
                COUNT(DISTINCT hh.healthhistoryId) AS totalTreatments,
                COUNT(DISTINCT CASE WHEN hh.healthhistoryTotalBill != 0 AND hh.healthhistoryReferredTo IS NULL THEN hh.healthhistoryId ELSE NULL END) AS totalBilledTreatments,
                COUNT(DISTINCT CASE WHEN hh.healthhistoryReferredTo IS NOT NULL THEN hh.healthhistoryId ELSE NULL END) AS totalReferredTreatments,
                COUNT(DISTINCT CASE WHEN hh.healthhistoryTotalBill = 0 AND hh.healthhistoryReferredTo IS NULL THEN hh.healthhistoryId ELSE NULL END) AS totalFreeTreatments,
    
                -- Current month treatment
                COUNT(DISTINCT CASE WHEN MONTH(hh.healthhistoryDate) = MONTH(CURDATE()) AND YEAR(hh.healthhistoryDate) = YEAR(CURDATE()) THEN hh.healthhistoryId ELSE NULL END) AS totalTreatmentsThisMonth,
                COUNT(DISTINCT CASE WHEN hh.healthhistoryTotalBill != 0 AND hh.healthhistoryReferredTo IS NULL AND MONTH(hh.healthhistoryDate) = MONTH(CURDATE()) AND YEAR(hh.healthhistoryDate) = YEAR(CURDATE()) THEN hh.healthhistoryId ELSE NULL END) AS totalBilledTreatmentsThisMonth,
                COUNT(DISTINCT CASE WHEN hh.healthhistoryReferredTo IS NOT NULL AND MONTH(hh.healthhistoryDate) = MONTH(CURDATE()) AND YEAR(hh.healthhistoryDate) = YEAR(CURDATE()) THEN hh.healthhistoryId ELSE NULL END) AS totalReferredTreatmentsThisMonth,
                COUNT(DISTINCT CASE WHEN hh.healthhistoryTotalBill = 0 AND hh.healthhistoryReferredTo IS NULL AND MONTH(hh.healthhistoryDate) = MONTH(CURDATE()) AND YEAR(hh.healthhistoryDate) = YEAR(CURDATE()) THEN hh.healthhistoryId ELSE NULL END) AS totalFreeTreatmentsThisMonth
        ');
        $this->db->from('hospital h');
        $this->db->join('doctor d', 'd.hospitalId = h.hospitalId', 'left');
        $this->db->join('healthhistory hh', 'hh.hospitalId = h.hospitalId', 'left');
        $this->db->where('h.hospitalId', $hospitalId);
        $this->db->group_by('h.hospitalId');
        
        return $this->db->get()->result_array();
    }

    public function getHospitalStatus($hospitalId) {
        $this->db->select('hospitalStatus');
        $this->db->where('hospitalId', $hospitalId);
        return $this->db->get('hospital')->row_array()['hospitalStatus'] ?? null;
    }

    public function countHospitalDoctorByHospitalId($hospitalId) {
        $this->db->select('COUNT(*) as count');
        $this->db->from('doctor');
        $this->db->where('hospitalId', $hospitalId);
        $query = $this->db->get();
        return $query->row()->count;
    }

    public function getAllHospitalsLogo() {
        $this->db->select('hospitalLogo');
        $this->db->from('hospital');
        $this->db->where('hospitalLogo IS NOT NULL AND hospitalLogo != ""');
        return $this->db->get()->result_array();
    }

    public function getTotalHospitals() {
        $this->db->where('hospitalStatus != discontinued AND adminId IS NOT NULL');
        return $this->db->count_all('hospital');
    }

    public function getAllActiveHospitalsMapData() {
        $this->db->select('
            hospitalPhoto AS photo, 
            hospitalLogo AS logo, 
            hospitalCoordinate AS coordinate,
            hospitalName AS partnerName, 
            "hospital" AS partnerRole
        ');
        $this->db->from('hospital');
        $this->db->where('hospitalStatus', 'active');
        return $this->db->get()->result_array();
    }

    public function checkHospital($param, $value) {
        return $this->db->get_where('hospital', array($param => $value))->row_array();
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

    public function getHospitalQueueDatas($hospitalId) {
        $this->db->select('q.*,
            IFNULL(e.employeeName, f.familyName) AS patientName,
            IFNULL(e.employeeStatus, f.familyStatus) AS patientStatus,
            IFNULL(e.employeeDepartment, e2.employeeDepartment) AS departmentName,
            IFNULL(e.employeeBand, e2.employeeBand) AS bandName,
            IFNULL(f.familyRelationship, "employee") AS patientRelationship,
            h.hospitalId, h.hospitalName, h.hospitalLogo, h.hospitalStatus,
            c.companyId, c.companyName, c.companyLogo, c.companyStatus, i.insuranceAmount
        ');
        $this->db->from('queue q');
        $this->db->join('hospital h', 'h.hospitalId = q.hospitalId', 'left');
        $this->db->join('family f', 'f.familyNIK = q.patientNIK AND q.patientRole = "family"', 'left');
        $this->db->join('employee e', 'e.employeeNIK = q.patientNIK AND q.patientRole = "employee"', 'left');
        $this->db->join('employee e2', 'e2.employeeNIK = f.employeeNIK', 'left');
        $this->db->join('insurance i', 'i.insuranceId = e.insuranceId', 'left');
        $this->db->join('company c', 'c.companyId = i.companyId', 'left');
        $this->db->where('q.hospitalId', $hospitalId);
        $this->db->order_by('q.createdAt', 'ASC');
        return $this->db->get()->result_array();
    }

    public function getQueuedPatientByNIK($patientNIK, $patientRole) {
        if  ($patientRole === 'employee') {

            $this->db->select('
                i.companyId,
                e.employeeNIK AS patientNIK,
                e.employeeName AS patientName,
                e.employeeStatus AS patientStatus,
                "employee" AS patientRole,
                "employee" AS patientRelationship,
                COALESCE(i.insuranceAmount - COALESCE((
                    SELECT SUM(hh.healthhistoryTotalBill) 
                    FROM healthhistory hh
                    WHERE (hh.patientNIK = e.employeeNIK OR hh.patientNIK IN (
                        SELECT familyNIK FROM family WHERE employeeNIK = e.employeeNIK
                    ))
                    AND MONTH(hh.healthhistoryDate) = MONTH(CURDATE())
                    AND YEAR(hh.healthhistoryDate) = YEAR(CURDATE())
                ), 0), 0) AS totalBillingRemaining
            ', false);
            $this->db->from('employee e');
            $this->db->join('insurance i', 'i.insuranceId = e.insuranceId', 'left');
            $this->db->where('e.employeeNIK', $patientNIK);
            return $this->db->get()->row_array();

        } else if ($patientRole === 'family') {

            $this->db->select('
                i.companyId,
                f.familyNIK AS patientNIK,
                f.familyName AS patientName,
                f.familyStatus AS patientStatus,
                "family" AS patientRole,
                f.familyRelationship AS patientRelationship,
                COALESCE(i.insuranceAmount - COALESCE((
                    SELECT SUM(hh.healthhistoryTotalBill) 
                    FROM healthhistory hh
                    WHERE (hh.patientNIK = e.employeeNIK OR hh.patientNIK IN (
                        SELECT familyNIK FROM family WHERE employeeNIK = e.employeeNIK
                    ))
                    AND MONTH(hh.healthhistoryDate) = MONTH(CURDATE())
                    AND YEAR(hh.healthhistoryDate) = YEAR(CURDATE())
                ), 0), 0) AS totalBillingRemaining
            ', false);
            $this->db->from('family f');
            $this->db->join('employee e', 'e.employeeNIK = f.employeeNIK', 'left');
            $this->db->join('insurance i', 'i.insuranceId = e.insuranceId', 'left');
            $this->db->where('f.familyNIK', $patientNIK);
            return $this->db->get()->row_array();

        }
    }
    
    public function getDiseaseDatas() {
        return $this->db->get('disease')->result_array();
    }

    public function getCompanyInsuredDisease($companyId) {
        $this->db->select('d.*');
        $this->db->from('compease c');
        $this->db->join('disease d', 'd.diseaseId = c.diseaseId', 'left');
        $this->db->where_in('c.companyId', (array) $companyId);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function addQueue($patientNIK, $patientRole, $hospitalId) {
        $data = array(
            'patientNIK' => $patientNIK,
            'patientRole' => $patientRole,
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