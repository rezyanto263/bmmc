<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_billings extends CI_Model {

  public function checkCompanyBillingDatas($companyId) {
    return $this->db->get_where('billing', array('companyId' => $companyId, 'billingStatus' => 'in use'))->row_array();
  }

  public function getAllCompanyBillingDatas() {
    $this->db->select('b.*, c.companyName, c.companyPhoto, c.companyLogo, c.companyStatus, IFNULL(SUM(hh.historyhealthTotalBill), 0) as billingUsed');
    $this->db->from('billing b');
    $this->db->join('company c', 'c.companyId = b.companyId', 'left');
    $this->db->join('historyhealth hh', 'hh.billingId = b.billingId', 'left');
    $this->db->group_by('b.billingId');
    return $this->db->get()->result_array();
  }

  public function insertBilling($billingDatas) {
    return $this->db->insert('billing', $billingDatas);
  }

}

/* End of file M_billings.php */

?>