<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_dashboard extends CI_Model {

  public function countCompanies() {
    return $this->db->count_all('company');
  }

  public function countInvoices() {
    return $this->db->count_all('invoice');
  }

  public function countHospitals() {
    return $this->db->count_all('hospital');
  }

  public function countTreatments() {
    return $this->db->count_all('healthhistory');
  }

  public function getReserveFundsThisMonth() {
    $this->db->select_sum('billingAmount');
    $this->db->from('billing');
    $this->db->where('MONTH(billingStartedAt)', date('m'));
    $this->db->where('YEAR(billingStartedAt)', date('Y'));
    return $this->db->get()->row()->billingAmount ?: 0;
  }

  public function getClaimPayoutsThisMonth() {
    $this->db->select_sum('healthhistoryTotalBill');
    $this->db->from('healthhistory');
    $this->db->where('MONTH(healthhistoryDate)', date('m'));
    $this->db->where('YEAR(healthhistoryDate)', date('Y'));
    return $this->db->get()->row()->healthhistoryTotalBill ?: 0;
  }

  public function checkUserEmailAvailability($email) {
    $query = $this->db->query("
        SELECT 'employee' AS source FROM employee WHERE employeeEmail = ? 
        UNION 
        SELECT 'family' AS source FROM family WHERE familyEmail = ?
    ", array($email, $email));

    return $query->num_rows() > 0 ? $query->row_array() : false;
  }

  public function checkAdminEmailAvailability($email) {
    $query = $this->db->query("
        SELECT 'admin' AS source FROM admin WHERE adminEmail = ? 
    ", array($email));

    return $query->num_rows() > 0 ? $query->row_array() : false;
  }

}

/* End of file M_dashboard.php */

?>