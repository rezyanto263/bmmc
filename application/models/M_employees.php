<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_employees extends CI_Model {

    public function getAllEmployees() {
        $this->db->select('e.*,
            eh.employeehistoryDepartment, eh.employeehistoryBand, eh.employeehistoryStatus,
            i.insuranceId, i.insuranceTier, i.insuranceAmount, i.insuranceDescription, 
            c.companyId, c.companyName, c.companyLogo, c.companyStatus
        ');
        $this->db->from('employee e');
        $this->db->join(
            '(SELECT eh1.* FROM employeehistory eh1
                JOIN (SELECT employeeNIK, MAX(employeehistoryStartedAt) AS latestHistory
                        FROM employeehistory GROUP BY employeeNIK) latest
                ON eh1.employeeNIK = latest.employeeNIK 
                AND eh1.employeehistoryStartedAt = latest.latestHistory) eh',
            'eh.employeeNIK = e.employeeNIK', 'left');
        $this->db->join('insurance i', 'i.insuranceId = eh.insuranceId');
        $this->db->join('company c', 'c.companyId = eh.companyId');
        return $this->db->get()->result_array();
    }

    public function getAllEmployeesByCompanyId($companyId) {
        $this->db->select('e.*, i.insuranceTier, i.insuranceAmount, i.insuranceDescription');
        $this->db->from('employee e');
        $this->db->join(
            '(SELECT eh1.* FROM employeehistory eh1
                JOIN (SELECT employeeNIK, MAX(employeehistoryStartedAt) AS latestHistory
                        FROM employeehistory GROUP BY employeeNIK) latest
                ON eh1.employeeNIK = latest.employeeNIK 
                AND eh1.employeehistoryStartedAt = latest.latestHistory) eh',
            'eh.employeeNIK = e.employeeNIK');
        $this->db->join('company c', 'c.companyId = eh.companyId');
        $this->db->join('insurance i', 'i.insuranceId = eh.insuranceId');
        $this->db->where('eh.companyId', $companyId);
        return $this->db->get()->result_array();
    }

    public function getEmployeeDetails($employeeNIK) {
        $this->db->select("
            SUM(CASE WHEN MONTH(hh.healthhistoryDate) = MONTH(CURDATE()) AND YEAR(hh.healthhistoryDate) = YEAR(CURDATE()) THEN hh.healthhistoryTotalBill ELSE 0 END) AS totalBillingUsed,
            COUNT(CASE WHEN hh.healthhistoryTotalBill != 0 AND hh.healthhistoryReferredTo IS NULL THEN hh.healthhistoryId ELSE NULL END) AS totalBilledTreatments,
            COUNT(CASE WHEN hh.healthhistoryTotalBill = 0 AND hh.healthhistoryReferredTo IS NULL THEN hh.healthhistoryId ELSE NULL END) AS totalFreeTreatments,
            COUNT(CASE WHEN hh.healthhistoryReferredTo IS NOT NULL THEN hh.healthhistoryId ELSE NULL END) AS totalReferredTreatments,
            COUNT(hh.healthhistoryId) AS totalTreatments,

            -- Current month treatment counts

            COUNT(CASE WHEN hh.healthhistoryTotalBill != 0 AND hh.healthhistoryReferredTo IS NULL AND MONTH(hh.healthhistoryDate) = MONTH(CURDATE()) AND YEAR(hh.healthhistoryDate) = YEAR(CURDATE()) THEN hh.healthhistoryId ELSE NULL END) AS totalBilledTreatmentsThisMonth,
            COUNT(CASE WHEN hh.healthhistoryTotalBill = 0 AND hh.healthhistoryReferredTo IS NULL AND MONTH(hh.healthhistoryDate) = MONTH(CURDATE()) AND YEAR(hh.healthhistoryDate) = YEAR(CURDATE()) THEN hh.healthhistoryId ELSE NULL END) AS totalFreeTreatmentsThisMonth,
            COUNT(CASE WHEN hh.healthhistoryReferredTo IS NOT NULL AND MONTH(hh.healthhistoryDate) = MONTH(CURDATE()) AND YEAR(hh.healthhistoryDate) = YEAR(CURDATE()) THEN hh.healthhistoryId ELSE NULL END) AS totalReferredTreatmentsThisMonth,
            COUNT(CASE WHEN MONTH(hh.healthhistoryDate) = MONTH(CURDATE()) AND YEAR(hh.healthhistoryDate) = YEAR(CURDATE()) THEN hh.healthhistoryId ELSE NULL END) AS totalTreatmentsThisMonth
        ");
        $this->db->from('employee e');
        $this->db->join('family f', 'f.employeeNIK = e.employeeNIK', 'left');
        $this->db->join('healthhistory hh', 'hh.patientNIK = e.employeeNIK OR hh.patientNIK = f.familyNIK', 'left');
        $this->db->join('billing b', 'b.billingId = hh.billingId', 'left');
        $this->db->join('invoice i', 'b.billingId = hh.billingId', 'left');
        $this->db->where('e.employeeNIK', $employeeNIK);
        return $this->db->get()->result_array();
    }

    public function getEmployeeByNIK($employeeNIK) {
        $this->db->select('e.*, 
            i.insuranceTier, i.insuranceAmount, 
            c.companyName, c.companyStatus, 
            "employee" AS familyRelationship
        ');
        $this->db->from('employee e');
        $this->db->join(
            '(SELECT eh1.* FROM employeehistory eh1
                JOIN (SELECT employeeNIK, MAX(employeehistoryStartedAt) AS latestHistory
                        FROM employeehistory GROUP BY employeeNIK) latest
                ON eh1.employeeNIK = latest.employeeNIK 
                AND eh1.employeehistoryStartedAt = latest.latestHistory) eh',
            'eh.employeeNIK = e.employeeNIK');
        $this->db->join('company c', 'c.companyId = eh.companyId', 'left');
        $this->db->join('insurance i', 'i.insuranceId = eh.insuranceId', 'left');
        $this->db->where('e.employeeNIK', $employeeNIK);
        return $this->db->get()->row_array();
    }

    public function getAllDepartmentByCompanyId($companyId) {
        $this->db->distinct();
        $this->db->select('eh.employeehistoryDepartment AS departmentName');
        $this->db->from('employeehistory eh');
        $this->db->where('eh.companyId', $companyId);
        return $this->db->get()->result_array();
    }

    public function getAllBandByCompanyId($companyId) {
        $this->db->distinct();
        $this->db->select('eh.employeehistoryBand AS bandName');
        $this->db->from('employeehistory eh');
        $this->db->where('eh.companyId', $companyId);
        return $this->db->get()->result_array();
    }

    public function checkEmployee($param, $value) {
        $employeeColumns = $this->db->list_fields('employee');
        $employeeHistoryColumns = $this->db->list_fields('employeehistory');

        if (in_array($param, $employeeColumns) && in_array($param, $employeeHistoryColumns)) {
            $alias = 'e.';
        } elseif (in_array($param, $employeeColumns)) {
            $alias = 'e.';
        } elseif (in_array($param, $employeeHistoryColumns)) {
            $alias = 'eh.';
        }

        $this->db->select('e.*, eh.*');
        $this->db->from('employee e');
        $this->db->join(
        '(SELECT eh1.* FROM employeehistory eh1
            JOIN (SELECT employeeNIK, MAX(employeehistoryStartedAt) AS latestHistory
                    FROM employeehistory GROUP BY employeeNIK) latest
            ON eh1.employeeNIK = latest.employeeNIK 
            AND eh1.employeehistoryStartedAt = latest.latestHistory) eh',
        'eh.employeeNIK = e.employeeNIK', 'left');
        $this->db->where($alias . $param, $value);
        return $this->db->get()->row_array();
    }

    public function insertEmployee($employeeData, $employeehistoryData) {
        $this->db->trans_start();

        $this->db->insert('employee', $employeeData);
        if ($this->db->affected_rows() === 0) {
            $this->db->trans_rollback();
            return FALSE;
        }

        if (!isset($employeehistoryData['employeeNIK'])) {
            $employeehistoryData['employeeNIK'] = $employeeData['employeeNIK'];
        }

        $this->db->insert('employeehistory', $employeehistoryData);
        if ($this->db->affected_rows() === 0) {
            $this->db->trans_rollback();
            return FALSE;
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function updateEmployee($employeeNIK, $employeeData, $employeehistoryData) {
        $this->db->trans_start();

        if (!empty($employeeData['employeeNIK']) && $employeeData['employeeNIK'] !== $employeeNIK) {
            $this->db->where('employeeNIK', $employeeData['employeeNIK']);
            if ($this->db->get('employee')->row()) {
                $this->db->trans_rollback();
                return FALSE;
            }

            $this->db->where('patientNIK', $employeeNIK);
            if (!$this->db->update('healthhistory', ['patientNIK' => $employeeData['employeeNIK']])) {
                $this->db->trans_rollback();
                return FALSE;
            }
        }

        $this->db->select('eh.*');
        $this->db->from('(SELECT eh1.* FROM employeehistory eh1
        JOIN (SELECT employeeNIK, MAX(employeehistoryStartedAt) AS latestHistory
                FROM employeehistory GROUP BY employeeNIK) latest
        ON eh1.employeeNIK = latest.employeeNIK 
        AND eh1.employeehistoryStartedAt = latest.latestHistory) eh');
        $this->db->where('eh.employeeNIK', $employeeNIK);
        $latestEmployeeHistory = $this->db->get()->row_array();

        $this->db->where('employeeNIK', $employeeNIK);
        $this->db->where('employeehistoryId !=', $latestEmployeeHistory['employeehistoryId']);
        if (!$this->db->update('employeehistory', ['employeehistoryStatus' => 'discontinued'])) {
            $this->db->trans_rollback();
            return FALSE;
        }

        $difference = ($latestEmployeeHistory && array_diff_assoc($employeehistoryData, $latestEmployeeHistory));

        if ($difference) {
            if ((!isset($employeehistoryData['companyId']) && strtotime($latestEmployeeHistory['employeehistoryStartedAt']) >= strtotime('-1 day')) 
                || $latestEmployeeHistory['employeehistoryStatus'] === 'unverified') {
                $this->db->where('employeehistoryId', $latestEmployeeHistory['employeehistoryId']);
                if (!$this->db->update('employeehistory', $employeehistoryData)) {
                    $this->db->trans_rollback();
                    return FALSE;
                }
            } else {
                $employeehistoryData['employeeNIK'] = $employeeNIK;
                $employeehistoryData['companyId'] = $employeehistoryData['companyId'] ?? $latestEmployeeHistory['companyId'];
            
                $this->db->where('employeehistoryId', $latestEmployeeHistory['employeehistoryId']);
                if (!$this->db->update('employeehistory', ['employeehistoryStatus' => 'discontinued'])) {
                    $this->db->trans_rollback();
                    return FALSE;
                }
            
                if (!$this->db->insert('employeehistory', $employeehistoryData)) {
                    $this->db->trans_rollback();
                    return FALSE;
                }
            }
            
        }

        $this->db->where('employeeNIK', $employeeNIK);
        if (!$this->db->update('employee', $employeeData)) {
            $this->db->trans_rollback();
            return FALSE;
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function deleteEmployee($employeeNIK) {
        $this->db->where('employeeNIK', $employeeNIK);
        return $this->db->delete('employee');
    }

}

/* End of file M_employee.php */
