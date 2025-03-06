<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_healthhistories extends CI_Model {

    public function getAllHealthHistoriesDatas() {
        $this->db->select('
                    hh.*,
                    c.companyId,
                    c.companyName,
                    c.companyLogo,
                    c.companyStatus,
                    b.billingStatus,
                    d.doctorName,
                    h.hospitalName,
                    h.hospitalLogo,
                    h2.hospitalName AS referredHospitalName,
                    h2.hospitalLogo AS referredHospitalLogo,
                    COALESCE(e.employeeDepartment, e2.employeeDepartment) AS patientDepartment,
                    COALESCE(e.employeeBand, e2.employeeBand) AS patientBand,
                    IFNULL(e.employeeGender, f.familyGender) AS patientGender,
                    IFNULL(e.employeePhoto, f.familyPhoto) AS patientPhoto,
                    IFNULL(e.employeeName, f.familyName) AS patientName,
                    IFNULL(i.invoiceStatus, "upcoming") AS invoiceStatus,
                    GROUP_CONCAT(ds.diseaseName SEPARATOR ", ") AS diseaseNames,
                    CASE
                        WHEN e.employeeNIK IS NOT NULL THEN "employee"
                        WHEN f.familyNIK IS NOT NULL THEN f.familyRelationship
                        ELSE "unknown"
                    END AS patientRelationship,
                    CASE 
                        WHEN hh.healthhistoryReferredTo IS NOT NULL THEN "referred"
                        WHEN hh.healthhistoryTotalBill = 0 THEN "free"
                        ELSE "billed"
                    END AS status,
        ', false);
        $this->db->from('healthhistory hh');
        $this->db->join('employee e', 'e.employeeNIK = hh.patientNIK AND hh.patientRole = "employee"', 'left');
        $this->db->join('family f', 'f.familyNIK = hh.patientNIK AND hh.patientRole = "family"', 'left');
        $this->db->join('employee e2', 'e2.employeeNIK = f.employeeNIK', 'left');
        $this->db->join('billing b', 'b.billingId = hh.billingId', 'left');
        $this->db->join('company c', 'c.companyId = b.companyId', 'left');
        $this->db->join('invoice i', 'i.billingId = b.billingId', 'left');
        $this->db->join('hospital h', 'h.hospitalId = hh.hospitalId', 'left');
        $this->db->join('hospital h2', 'h2.hospitalId = hh.healthhistoryReferredTo', 'left');
        $this->db->join('doctor d', 'd.doctorId = hh.doctorId', 'left');
        $this->db->join('healthorase ht', 'ht.healthhistoryId = hh.healthhistoryId', 'left');
        $this->db->join('disease ds', 'ds.diseaseId = ht.diseaseId', 'left');
        $this->db->group_by('hh.healthhistoryId');
        return $this->db->get()->result_array();
    }

    public function getAllHealthHistoriesByHospitalId($hospitalId) {
        $this->db->select('
                    hh.*,
                    c.companyId,
                    c.companyName,
                    c.companyLogo,
                    c.companyStatus,
                    b.billingStatus,
                    d.doctorName,
                    h.hospitalName,
                    h.hospitalLogo,
                    h2.hospitalName AS referredHospitalName,
                    h2.hospitalLogo AS referredHospitalLogo,
                    COALESCE(e.employeeDepartment, e2.employeeDepartment) AS patientDepartment,
                    COALESCE(e.employeeBand, e2.employeeBand) AS patientBand,
                    IFNULL(e.employeeGender, f.familyGender) AS patientGender,
                    IFNULL(e.employeePhoto, f.familyPhoto) AS patientPhoto,
                    IFNULL(e.employeeName, f.familyName) AS patientName,
                    IFNULL(i.invoiceStatus, "upcoming") AS invoiceStatus,
                    GROUP_CONCAT(ds.diseaseName SEPARATOR ", ") AS diseaseNames,
                    CASE
                        WHEN e.employeeNIK IS NOT NULL THEN "employee"
                        WHEN f.familyNIK IS NOT NULL THEN f.familyRelationship
                        ELSE "unknown"
                    END AS patientRelationship,
                    CASE 
                        WHEN hh.healthhistoryReferredTo IS NOT NULL THEN "referred"
                        WHEN hh.healthhistoryTotalBill = 0 THEN "free"
                        ELSE "billed"
                    END AS status,
        ', false);
        $this->db->from('healthhistory hh');
        $this->db->join('employee e', 'e.employeeNIK = hh.patientNIK AND hh.patientRole = "employee"', 'left');
        $this->db->join('family f', 'f.familyNIK = hh.patientNIK AND hh.patientRole = "family"', 'left');
        $this->db->join('employee e2', 'e2.employeeNIK = f.employeeNIK', 'left');
        $this->db->join('billing b', 'b.billingId = hh.billingId', 'left');
        $this->db->join('company c', 'c.companyId = b.companyId', 'left');
        $this->db->join('invoice i', 'i.billingId = b.billingId', 'left');
        $this->db->join('hospital h', 'h.hospitalId = hh.hospitalId', 'left');
        $this->db->join('hospital h2', 'h2.hospitalId = hh.healthhistoryReferredTo', 'left');
        $this->db->join('doctor d', 'd.doctorId = hh.doctorId', 'left');
        $this->db->join('healthorase ht', 'ht.healthhistoryId = hh.healthhistoryId', 'left');
        $this->db->join('disease ds', 'ds.diseaseId = ht.diseaseId', 'left');
        $this->db->where('hh.hospitalId', $hospitalId);
        $this->db->group_by('hh.healthhistoryId');
        return $this->db->get()->result_array();
    }

    public function getAllHealthHistoriesByBillingId($billingId) {
        $this->db->select('
                    hh.*,
                    b.billingStatus,
                    d.doctorName,
                    h.hospitalName,
                    h.hospitalLogo,
                    h2.hospitalName AS referredHospitalName,
                    h2.hospitalLogo AS referredHospitalLogo,
                    COALESCE(e.employeeDepartment, e2.employeeDepartment) AS patientDepartment,
                    COALESCE(e.employeeBand, e2.employeeBand) AS patientBand,
                    IFNULL(e.employeeGender, f.familyGender) AS patientGender,
                    IFNULL(e.employeePhoto, f.familyPhoto) AS patientPhoto,
                    IFNULL(e.employeeName, f.familyName) AS patientName,
                    GROUP_CONCAT(ds.diseaseName SEPARATOR ", ") AS diseaseNames,
                    CASE
                        WHEN e.employeeNIK IS NOT NULL THEN "employee"
                        WHEN f.familyNIK IS NOT NULL THEN f.familyRelationship
                        ELSE "unknown"
                    END AS patientRelationship,
                    CASE 
                        WHEN hh.healthhistoryReferredTo IS NOT NULL THEN "referred"
                        WHEN hh.healthhistoryTotalBill = 0 THEN "free"
                        ELSE "billed"
                    END AS status,
        ', false);
        $this->db->from('healthhistory hh');
        $this->db->join('employee e', 'e.employeeNIK = hh.patientNIK AND hh.patientRole = "employee"', 'left');
        $this->db->join('family f', 'f.familyNIK = hh.patientNIK AND hh.patientRole = "family"', 'left');
        $this->db->join('employee e2', 'e2.employeeNIK = f.employeeNIK', 'left');
        $this->db->join('billing b', 'b.billingId = hh.billingId', 'left');
        $this->db->join('hospital h', 'h.hospitalId = hh.hospitalId', 'left');
        $this->db->join('hospital h2', 'h2.hospitalId = hh.healthhistoryReferredTo', 'left');
        $this->db->join('doctor d', 'd.doctorId = hh.doctorId', 'left');
        $this->db->join('healthorase ht', 'ht.healthhistoryId = hh.healthhistoryId', 'left');
        $this->db->join('disease ds', 'ds.diseaseId = ht.diseaseId', 'left');
        $this->db->where('hh.billingId', $billingId);
        $this->db->group_by('hh.healthhistoryId');
        return $this->db->get()->result_array();
    }

    public function getAllHealthHistoriesByCompanyId($companyId) {
        $this->db->select('
                    hh.*,
                    c.companyId,
                    c.companyName,
                    c.companyLogo,
                    c.companyStatus,
                    b.billingStatus,
                    d.doctorName,
                    h.hospitalName,
                    h.hospitalLogo,
                    h2.hospitalName AS referredHospitalName,
                    h2.hospitalLogo AS referredHospitalLogo,
                    COALESCE(e.employeeDepartment, e2.employeeDepartment) AS patientDepartment,
                    COALESCE(e.employeeBand, e2.employeeBand) AS patientBand,
                    IFNULL(e.employeeGender, f.familyGender) AS patientGender,
                    IFNULL(e.employeePhoto, f.familyPhoto) AS patientPhoto,
                    IFNULL(e.employeeName, f.familyName) AS patientName,
                    IFNULL(i.invoiceStatus, "upcoming") AS invoiceStatus,
                    GROUP_CONCAT(ds.diseaseName SEPARATOR ", ") AS diseaseNames,
                    CASE
                        WHEN e.employeeNIK IS NOT NULL THEN "employee"
                        WHEN f.familyNIK IS NOT NULL THEN f.familyRelationship
                        ELSE "unknown"
                    END AS patientRelationship,
                    CASE 
                        WHEN hh.healthhistoryReferredTo IS NOT NULL THEN "referred"
                        WHEN hh.healthhistoryTotalBill = 0 THEN "free"
                        ELSE "billed"
                    END AS status,
        ', false);
        $this->db->from('healthhistory hh');
        $this->db->join('employee e', 'e.employeeNIK = hh.patientNIK AND hh.patientRole = "employee"', 'left');
        $this->db->join('family f', 'f.familyNIK = hh.patientNIK AND hh.patientRole = "family"', 'left');
        $this->db->join('employee e2', 'e2.employeeNIK = f.employeeNIK', 'left');
        $this->db->join('billing b', 'b.billingId = hh.billingId', 'left');
        $this->db->join('company c', 'c.companyId = b.companyId', 'left');
        $this->db->join('invoice i', 'i.billingId = b.billingId', 'left');
        $this->db->join('hospital h', 'h.hospitalId = hh.hospitalId', 'left');
        $this->db->join('hospital h2', 'h2.hospitalId = hh.healthhistoryReferredTo', 'left');
        $this->db->join('doctor d', 'd.doctorId = hh.doctorId', 'left');
        $this->db->join('healthorase ht', 'ht.healthhistoryId = hh.healthhistoryId', 'left');
        $this->db->join('disease ds', 'ds.diseaseId = ht.diseaseId', 'left');
        $this->db->where('c.companyId', $companyId);
        $this->db->group_by('hh.healthhistoryId');
        return $this->db->get()->result_array();
    }

    public function getHealthHistoryByPatientNIK($patientNIK) {
        $this->db->select('*');
        $this->db->from('healthhistory');
        $this->db->where('patientNIK', $patientNIK);
        return $this->db->get()->result_array();
    }

    public function getPatientHealthHistoryDetailsByNIK($patientNIK, $patientRole) {
                $this->db->select('
                hh.*,
                c.companyId,
                c.companyName,
                c.companyLogo,
                c.companyStatus,
                b.billingStatus,
                d.doctorName,
                h.hospitalName,
                h.hospitalLogo,
                h2.hospitalName AS referredHospitalName,
                h2.hospitalLogo AS referredHospitalLogo,
                COALESCE(e.employeeDepartment, e2.employeeDepartment) AS patientDepartment,
                COALESCE(e.employeeBand, e2.employeeBand) AS patientBand,
                IFNULL(e.employeeGender, f.familyGender) AS patientGender,
                IFNULL(e.employeePhoto, f.familyPhoto) AS patientPhoto,
                IFNULL(e.employeeName, f.familyName) AS patientName,
                IFNULL(i.invoiceStatus, "upcoming") AS invoiceStatus,
                GROUP_CONCAT(ds.diseaseName SEPARATOR ", ") AS diseaseNames,
                CASE
                    WHEN e.employeeNIK IS NOT NULL THEN "employee"
                    WHEN f.familyNIK IS NOT NULL THEN f.familyRelationship
                    ELSE "unknown"
                END AS patientRelationship,
                CASE 
                    WHEN hh.healthhistoryReferredTo IS NOT NULL THEN "referred"
                    WHEN hh.healthhistoryTotalBill = 0 THEN "free"
                    ELSE "billed"
                END AS status,
        ', false);
        $this->db->from('healthhistory hh');
        $this->db->join('employee e', 'e.employeeNIK = hh.patientNIK AND hh.patientRole = "employee"', 'left');
        $this->db->join('family f', 'f.familyNIK = hh.patientNIK AND hh.patientRole = "family"', 'left');
        $this->db->join('employee e2', 'e2.employeeNIK = f.employeeNIK', 'left');
        $this->db->join('billing b', 'b.billingId = hh.billingId', 'left');
        $this->db->join('company c', 'c.companyId = b.companyId', 'left');
        $this->db->join('invoice i', 'i.billingId = b.billingId', 'left');
        $this->db->join('hospital h', 'h.hospitalId = hh.hospitalId', 'left');
        $this->db->join('hospital h2', 'h2.hospitalId = hh.healthhistoryReferredTo', 'left');
        $this->db->join('doctor d', 'd.doctorId = hh.doctorId', 'left');
        $this->db->join('healthorase ht', 'ht.healthhistoryId = hh.healthhistoryId', 'left');
        $this->db->join('disease ds', 'ds.diseaseId = ht.diseaseId', 'left');
        if ($patientRole === 'employee') {
            $this->db->where('e.employeeNIK', $patientNIK);
            $this->db->or_where('f.employeeNIK', $patientNIK);
        } else {
            $this->db->where('hh.patientNIK', $patientNIK);
        }
        $this->db->group_by('hh.healthhistoryId');
        return $this->db->get()->result_array();
    }

    public function getAllPatientsData() {
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
        $this->db->group_by('e.employeeNIK, i.insuranceAmount');
        $employee = $this->db->get()->result_array();

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
        $this->db->group_by('f.familyNIK, i.insuranceAmount');
        $family = $this->db->get()->result_array();
    
        return array_merge($employee, $family);
    }

    public function getAllInsuranceMembersHealhtHistoriesByUserNIK($userNIK) {
        $this->db->select('
                    hh.*,
                    c.companyId,
                    c.companyName,
                    c.companyLogo,
                    c.companyStatus,
                    b.billingStatus,
                    d.doctorName,
                    h.hospitalName,
                    h.hospitalLogo,
                    h2.hospitalName AS referredHospitalName,
                    h2.hospitalLogo AS referredHospitalLogo,
                    COALESCE(e.employeeDepartment, e2.employeeDepartment) AS patientDepartment,
                    COALESCE(e.employeeBand, e2.employeeBand) AS patientBand,
                    IFNULL(e.employeeGender, f.familyGender) AS patientGender,
                    IFNULL(e.employeePhoto, f.familyPhoto) AS patientPhoto,
                    IFNULL(e.employeeName, f.familyName) AS patientName,
                    IFNULL(i.invoiceStatus, "upcoming") AS invoiceStatus,
                    GROUP_CONCAT(ds.diseaseName SEPARATOR ", ") AS diseaseNames,
                    CASE
                        WHEN e.employeeNIK IS NOT NULL THEN "employee"
                        WHEN f.familyNIK IS NOT NULL THEN f.familyRelationship
                        ELSE "unknown"
                    END AS patientRelationship,
                    CASE 
                        WHEN hh.healthhistoryReferredTo IS NOT NULL THEN "referred"
                        WHEN hh.healthhistoryTotalBill = 0 THEN "free"
                        ELSE "billed"
                    END AS status,
        ', false);
        $this->db->from('healthhistory hh');
        $this->db->join('employee e', 'e.employeeNIK = hh.patientNIK AND hh.patientRole = "employee"', 'left');
        $this->db->join('family f', 'f.familyNIK = hh.patientNIK AND hh.patientRole = "family"', 'left');
        $this->db->join('employee e2', 'e2.employeeNIK = f.employeeNIK', 'left');
        $this->db->join('billing b', 'b.billingId = hh.billingId', 'left');
        $this->db->join('company c', 'c.companyId = b.companyId', 'left');
        $this->db->join('invoice i', 'i.billingId = b.billingId', 'left');
        $this->db->join('hospital h', 'h.hospitalId = hh.hospitalId', 'left');
        $this->db->join('hospital h2', 'h2.hospitalId = hh.healthhistoryReferredTo', 'left');
        $this->db->join('doctor d', 'd.doctorId = hh.doctorId', 'left');
        $this->db->join('healthorase ht', 'ht.healthhistoryId = hh.healthhistoryId', 'left');
        $this->db->join('disease ds', 'ds.diseaseId = ht.diseaseId', 'left');
        $this->db->where('e.employeeNIK', $userNIK);
        $this->db->or_where('f.employeeNIK', $userNIK);
        $this->db->or_where('f.familyNIK', $userNIK);
        $this->db->group_by('hh.healthhistoryId');
        return $this->db->get()->result_array();
    }

    public function checkHealthHistoryDisease($diseaseId) {
        return $this->db->get('healthorase', array('diseaseId' => $diseaseId))->result_array();
    }

    public function insertHealthHistory($healthhistoryDatas, $diseaseIds) {
        $this->db->trans_start();
    
        $this->db->insert('healthhistory', $healthhistoryDatas);
        if ($this->db->affected_rows() <= 0) {
            $this->db->trans_rollback();
            return false;
        }
    
        if (!empty($diseaseIds)) {
            foreach ($diseaseIds as $diseaseId) {
                $success = $this->insertHealthorase($healthhistoryDatas['healthhistoryId'], $diseaseId);
                if (!$success) {
                    $this->db->trans_rollback();
                    return false;
                }
            }
        }
    
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    private function insertHealthorase($healthhistoryId, $diseaseId) {
        $data = array(
            'healthhistoryId' => $healthhistoryId,
            'diseaseId' => $diseaseId
        );
        $this->db->insert('healthorase', $data);
    
        return $this->db->affected_rows() > 0;
    }

    public function updateHealthHistory($healthhistoryDatas, $diseaseIds, $healthhistoryId) {
        $this->db->trans_start();

        $this->db->update('healthhistory', $healthhistoryDatas, array('healthhistoryId' => $healthhistoryId));
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }

        $this->db->delete('healthorase', array('healthhistoryId' => $healthhistoryId));
        if (!empty($diseaseIds)) {
            foreach ($diseaseIds as $diseaseId) {
                $success = $this->insertHealthorase($healthhistoryId, $diseaseId);
                if (!$success) {
                    $this->db->trans_rollback();
                    return false;
                }
            }
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function deleteHealthHistory($healthhistoryId) {
        $this->db->trans_start();

        $this->db->delete('healthhistory', array('healthhistoryId' => $healthhistoryId));
        if ($this->db->affected_rows() <= 0) {
            $this->db->trans_rollback();
            return false;
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

}

/* End of file M_healthhistories.php */

?>