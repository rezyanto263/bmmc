<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_diseases extends CI_Model {

  public function getAllDiseasesDatas() {
    $this->db->select('*');
    $this->db->from('disease');
    return $this->db->get()->result_array();
  }

  public function checkDisease($diseaseData) {
    return $this->db->get_where('disease', $diseaseData)->row_array();
  }

  public function insertDisease($diseaseDatas) {
    return $this->db->insert('disease', $diseaseDatas);
  }

  public function updateDisease($diseaseId, $diseaseDatas) {
    $this->db->where('diseaseId', $diseaseId);
    return $this->db->update('disease', $diseaseDatas);
  }

  public function deleteDisease($diseaseId) {
    $this->db->where('diseaseId', $diseaseId);
    return $this->db->delete('disease');
  }

  public function getCompanyDiseases($companyId) {
    $this->db->select('d.*, IFNULL(cd.compeaseStatus, 1) AS diseaseStatus');
    $this->db->from('disease d');
    $this->db->join('compease cd', 'cd.diseaseId = d.diseaseId AND cd.companyId = ' . $companyId, 'left');
    return $this->db->get()->result_array();
  }

  public function insertCompanyDisabledDiseases($companyId, $diseaseId) {
    return $this->db->insert('compease', array('companyId' => $companyId, 'diseaseId' => $diseaseId, 'compeaseStatus' => 0));
  }

  public function deleteCompanyDisabledDiseases($companyId, $diseaseId) {
    $this->db->where('companyId', $companyId);
    $this->db->where('diseaseId', $diseaseId);
    return $this->db->delete('compease');
  }

}

/* End of file M_diseases.php */

?>