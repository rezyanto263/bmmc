<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_employee extends CI_Model {

    public function getAllEmployeesDatas() {
        $this->db->select('*');
        $this->db->from('policyholder');
        return $this->db->get()->result_array();
    }

    public function checkEmployee($param, $employeeData) {
        return $this->db->get_where('policyholder', array($param => $employeeData))->row_array();
    }

    public function insertEmployee($employeeData) {
        return $this->db->insert('policyholder', $employeeData);
    }

    public function updateEmployee($policyholderNIN, $employeeData) {
        $this->db->where('policyholderNIN', $policyholderNIN);
        return $this->db->update('policyholder', $employeeData);
    }

    public function deleteEmployee($policyholderNIN) {
        $this->db->where('policyholderNIN', $policyholderNIN);
        return $this->db->delete('policyholder');
    }

}

/* End of file M_employee.php */
