<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Billings extends CI_Controller {

  public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('adminRole') != 'admin') {
            redirect('dashboard');
        }

        $this->load->model('M_billings');
    }

  public function index()
  {
    $datas = array(
      'title' => 'BMMC Dashboard | Billings',
      'subtitle' => 'Billings',
      'contentType' => 'dashboard',
    );

    $partials = array(
        'head' => 'partials/head',
        'sidebar' => 'partials/dashboard/sidebar',
        'floatingMenu' => 'partials/dashboard/floatingMenu',
        'contentHeader' => 'partials/dashboard/contentHeader',
        'contentBody' => 'dashboard/billings',
        'footer' => 'partials/dashboard/footer',
        'script' => 'partials/script'
    );

    $this->load->vars($datas);
    $this->load->view('master', $partials);
  }

  public function getAllCompanyBillingDatas() {
    $companyBillingDatas = $this->M_billings->getAllCompanyBillingDatas();
    $datas = array(
      'data' => $companyBillingDatas
    );

    echo json_encode($datas);
  }

  public function addBilling() {
    $validate = array(
      array(
        'field' => 'companyId',
        'label' => 'Company',
        'rules' => 'required',
        'errors' => array(
            'required' => 'Billing should provide a %s.'
        )
      ),
      array(
        'field' => 'billingStartedAt',
        'label' => 'Started Date',
        'rules' => 'required',
        'errors' => array(
            'required' => 'Billing should provide a %s.'
        )
      ),
    );
  }

}

/* End of file Billings.php */

?>