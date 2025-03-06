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
        // Gunakan query SQL manual untuk menghindari masalah escaping
        $sql = "SELECT 
                    employeeNIK, userNIK, insuranceId, userPhoto, userName, userEmail, userBirth, 
                    userGender, userPhone, userAddress, userStatus, 
                    userDepartment, userBand, userRole, userRelationship, userPassword
                FROM (
                    SELECT 
                        employee.employeeNIK AS employeeNIK,
                        employee.insuranceId AS insuranceId,
                        employee.employeeNIK AS userNIK,
                        employee.employeePhoto AS userPhoto,
                        employee.employeeName AS userName,
                        employee.employeeEmail AS userEmail,
                        employee.employeeBirth AS userBirth,
                        employee.employeeGender AS userGender,
                        employee.employeePhone AS userPhone,
                        employee.employeeAddress AS userAddress,
                        employee.employeeStatus AS userStatus,
                        employee.employeeDepartment AS userDepartment,
                        employee.employeeBand AS userBand,
                        'employee' AS userRole,
                        'employee' AS userRelationship,
                        employee.employeePassword AS userPassword,
                        employee.employeeToken AS userToken
                    FROM employee
                    
                    UNION ALL
                    
                    SELECT 
                        family.employeeNIK AS employeeNIK,
                        COALESCE(employee.insuranceId, '') AS insuranceId,
                        family.familyNIK AS userNIK,
                        family.familyPhoto AS userPhoto,
                        family.familyName AS userName,
                        family.familyEmail AS userEmail,
                        family.familyBirth AS userBirth,
                        family.familyGender AS userGender,
                        family.familyPhone AS userPhone,
                        family.familyAddress AS userAddress,
                        family.familyStatus AS userStatus,
                        COALESCE(employee.employeeDepartment, '') AS userDepartment,
                        COALESCE(employee.employeeBand, '') AS userBand,
                        'family' AS userRole,
                        family.familyRelationship AS userRelationship,
                        family.familyPassword AS userPassword,
                        family.familyToken AS userToken
                    FROM family
                    LEFT JOIN employee ON employee.employeeNIK = family.employeeNIK
                ) AS users
                WHERE ".$this->db->protect_identifiers($param)." = ".$this->db->escape($value);
        
        $query = $this->db->query($sql);
        return $query->row_array();
    }
    
    public function updateUnverifiedUser($userNIK, $userRole, $status) {
        $this->db->where($userRole . 'NIK', $userNIK);
        return $this->db->update($userRole, array($userRole . 'Status' => $status));
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