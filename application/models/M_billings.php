<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_billings extends CI_Model {

  public function getAllCompanyBillingDatas() {
    $this->db->select('b.*, c.companyName, c.companyPhoto, c.companyLogo, c.companyStatus');
    $this->db->from('billing b');
    $this->db->join('company c', 'c.companyId = b.companyId', 'left');
    $this->db->group_by('b.companyId');
    return $this->db->get()->result_array();
  }

}

/* End of file M_billings.php */

?>