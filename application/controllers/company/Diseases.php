<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Diseases extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('adminRole') != 'company') {
      redirect('dashboard/login');
    }

    $this->load->model('M_diseases');
  }

  public function index() {
    $datas = array(
      'title' => 'BMMC Company | Diseases',
      'subtitle' => 'Diseases',
      'contentType' => 'dashboard'
    );

    $partials = array(
        'head' => 'partials/head',
        'sidebar' => 'partials/company/sidebar',
        'floatingMenu' => 'partials/floatingMenu',
        'contentHeader' => 'partials/contentHeader',
        'contentBody' => 'company/diseases',
        'script' => 'partials/script'
    );

    $this->load->vars($datas);
    $this->load->view('master', $partials);
  }

  public function getCompanyDiseases() {
    $companyId = $this->session->userdata('companyId');
    $diseasesDatas = $this->M_diseases->getCompanyDiseases($companyId);
    $datas = array(
        'data' => $diseasesDatas
    );

    echo json_encode($datas);
  }

  public function addDisabledDisease() {
    $companyId = $this->session->userdata('companyId');
    $diseaseId = $this->input->post('diseaseId');
    $this->M_diseases->insertCompanyDisabledDiseases($companyId, $diseaseId);

    echo json_encode(array('status' => 'success', 'csrfToken' => $this->security->get_csrf_hash()));
  }

  public function deleteDisabledDisease() {
    $companyId = $this->session->userdata('companyId');
    $diseaseId = $this->input->post('diseaseId');
    $this->M_diseases->deleteCompanyDisabledDiseases($companyId, $diseaseId);

    echo json_encode(array('status' => 'success', 'csrfToken' => $this->security->get_csrf_hash()));
  }

}

/* End of file Diseases.php */

?>