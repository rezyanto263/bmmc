<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_auth extends CI_Model {

    /*
    | ----------------------------------------------------------------
    | ADMIN QUERY
    | ----------------------------------------------------------------
    */

    public function getAllAdmin() {
        $this->db->select('a.*,
            IF(a.adminRole = "company", c.companyStatus, 
                IF(a.adminRole = "hospital", h.hospitalStatus, NULL)) AS status
        ');
        $this->db->from('admin a');
        $this->db->join('company c', 'c.adminId = a.adminId', 'left');
        $this->db->join('hospital h', 'h.adminId = a.adminId', 'left');
        return $this->db->get()->result_array();
    }

    public function checkAdmin($param, $value) {
        $this->db->select('a.*,
            IF(a.adminRole = "company", c.companyStatus, 
                IF(a.adminRole = "hospital", h.hospitalStatus, NULL)) AS status
        ');
        $this->db->from('admin a');
        $this->db->join('company c', 'c.adminId = a.adminId', 'left');
        $this->db->join('hospital h', 'h.adminId = a.adminId', 'left');
        $this->db->where('a.' . $param, $value);
        return $this->db->get()->row_array();
    }

    public function setAdminToken($adminEmail, $adminToken) {
        $this->db->where('adminEmail', $adminEmail);
        return $this->db->update('admin', array('adminToken' => $adminToken));
    }

    public function changeAdminPassword($adminToken, $adminPassword) {
        $this->db->where('adminToken', $adminToken);
        $this->db->update('admin', array('adminPassword' => $adminPassword, 'adminToken' => NULL));
    }

    public function updateUnverifiedAdmin($adminId, $adminRole, $adminDatas) {
        $this->db->where('adminId', $adminId);
        return $this->db->update($adminRole, $adminDatas);
    }

    /*
    | ----------------------------------------------------------------
    | USER QUERY
    | ----------------------------------------------------------------
    */

    public function checkUser($param, $value) {
        $this->db->select([
            'eh.insuranceId AS insuranceId',
            'e.employeeNIK AS employeeNIK',
            'eh.employeehistoryStatus AS employeeStatus',
            'COALESCE(c.companyStatus, "") AS companyStatus',
            'e.employeeNIK AS userNIK',
            'e.employeePhoto AS userPhoto',
            'e.employeeName AS userName',
            'e.employeeEmail AS userEmail',
            'e.employeeBirth AS userBirth',
            'e.employeeGender AS userGender',
            'e.employeePhone AS userPhone',
            'e.employeeAddress AS userAddress',
            'eh.employeehistoryStatus AS userStatus',
            'eh.employeehistoryDepartment AS userDepartment',
            'eh.employeehistoryBand AS userBand',
            "'employee' AS userRole",
            "'employee' AS userRelationship",
            'e.employeePassword AS userPassword',
            'e.employeeToken AS userToken'
        ]);
        $this->db->from('employee e');
        $this->db->join(
            '(SELECT eh1.* FROM employeehistory eh1
                JOIN (SELECT employeeNIK, MAX(employeehistoryStartedAt) AS latestHistory
                        FROM employeehistory GROUP BY employeeNIK) latest
                ON eh1.employeeNIK = latest.employeeNIK 
                AND eh1.employeehistoryStartedAt = latest.latestHistory) eh',
            'eh.employeeNIK = e.employeeNIK', 'left');
        $this->db->join('company c', 'c.companyId = eh.companyId', 'left');
        $this->db->where($param, $value);

        $subquery1 = $this->db->get_compiled_select();

        $this->db->select([
            'COALESCE(eh.insuranceId, 0) AS insuranceId',
            'f.employeeNIK AS employeeNIK',
            'eh.employeehistoryStatus AS employeeStatus',
            'COALESCE(c.companyStatus, "") AS companyStatus',
            'f.familyNIK AS userNIK',
            'f.familyPhoto AS userPhoto',
            'f.familyName AS userName',
            'f.familyEmail AS userEmail',
            'f.familyBirth AS userBirth',
            'f.familyGender AS userGender',
            'f.familyPhone AS userPhone',
            'f.familyAddress AS userAddress',
            'f.familyStatus AS userStatus',
            'COALESCE(eh.employeehistoryDepartment, "") AS userDepartment',
            'COALESCE(eh.employeehistoryBand, "") AS userBand',
            "'family' AS userRole",
            'f.familyRelationship AS userRelationship',
            'f.familyPassword AS userPassword',
            'f.familyToken AS userToken'
        ]);
        $this->db->from('family f');
        $this->db->join('employee e', 'e.employeeNIK = f.employeeNIK', 'inner');
        $this->db->join(
            '(SELECT eh1.* FROM employeehistory eh1
                JOIN (SELECT employeeNIK, MAX(employeehistoryStartedAt) AS latestHistory
                        FROM employeehistory GROUP BY employeeNIK) latest
                ON eh1.employeeNIK = latest.employeeNIK 
                AND eh1.employeehistoryStartedAt = latest.latestHistory) eh',
            'eh.employeeNIK = e.employeeNIK', 'left');
        $this->db->join('company c', 'c.companyId = eh.companyId', 'left');
        $this->db->where($param, $value);
    
        $subquery2 = $this->db->get_compiled_select();
    
        return $this->db->query("$subquery1 UNION $subquery2")->row_array();
    }

    public function updateUnverifiedUser($userNIK, $userRole, $status) {
        $this->db->where($userRole . 'NIK', $userNIK);
        if ($userRole === 'employee') {
            $this->db->where('employeehistoryEndedAt', NULL);
            return $this->db->update('employeehistory', array('employeehistoryStatus' => $status));
        } else {
            return $this->db->update('family', array('familyStatus' => $status));
        }
    }

    public function updateProfile($userNIK, $userRole, $userData) {
        $this->db->where($userRole . 'NIK', $userNIK);
        return $this->db->update($userRole, $userData);
    }

    public function setUserToken($userEmail, $userRole, $userToken) {
        $this->db->where($userRole . 'Email', $userEmail);
        return $this->db->update($userRole, array($userRole . 'Token' => $userToken));
    }

    public function changeUserPassword($userToken, $userPassword) {
        $this->db->where('familyToken', $userToken);
        $family = $this->db->get('family')->row();
        $this->db->where('employeeToken', $userToken);
        $employee = $this->db->get('employee')->row();
        
        if (!empty($family)) {
            $this->db->update('family', array('familyPassword' => $userPassword, 'familyToken' => NULL));
        } elseif (!empty($employee)) {
            $this->db->update('employee', array('employeePassword' => $userPassword, 'employeeToken' => NULL));
        } else {
            return false;
        }
        return true;
    }

}

/* End of file M_auth.php */

?>