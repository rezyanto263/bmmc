<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Billings extends CI_Controller {

  public function __construct() {
      parent::__construct();

      if ($this->session->userdata('adminRole') != 'admin') {
        redirect('dashboard/login');
    }

      $this->load->model('M_billings');
  }

  public function index() {
    $datas = array(
      'title' => 'BMMC Dashboard | Billings',
      'subtitle' => 'Billings',
      'contentType' => 'dashboard',
    );

    $partials = array(
        'head' => 'partials/head',
        'sidebar' => 'partials/dashboard/sidebar',
        'floatingMenu' => 'partials/floatingMenu',
        'contentHeader' => 'partials/contentHeader',
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
        'rules' => 'required|numeric',
        'errors' => array(
            'required' => 'Billing should provide a %s.',
            'numeric' => 'The %s field must contain only numbers.'
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
      array(
        'field' => 'billingEndedAt',
        'label' => 'Ended Date',
        'rules' => 'required',
        'errors' => array(
            'required' => 'Billing should provide an %s.'
        )
      ),
      array(
        'field' => 'billingStatus',
        'label' => 'Status',
        'rules' => 'required',
        'errors' => array(
            'required' => 'Billing should provide a %s.'
        )
      ),
      array(
        'field' => 'billingAmount',
        'label' => 'Amount',
        'rules' => 'required|numeric',
        'errors' => array(
            'required' => 'Billing should provide an %s.',
            'numeric' => 'The %s field must contain only numbers.',
        )
      ),
    );
    $this->form_validation->set_rules($validate);

    if ($this->form_validation->run() == FALSE) {
      $errors = $this->form_validation->error_array();
      echo json_encode(array('status' => 'invalid', 'errors' => $errors));
    } else {
      $companyId = $this->input->post('companyId');
      $billingStartedAt = date('Y-m-d', strtotime($this->input->post('billingStartedAt')));
      $billingEndedAt = date('Y-m-d', strtotime($this->input->post('billingEndedAt')));

      $checkBillingData = $this->M_billings->checkCompanyBillingDatas($companyId);

      if (
        ($billingStartedAt < date('Y-m-d')) ||
        ($billingEndedAt < $billingStartedAt)
      ) {
        echo json_encode(array('status' => 'failed', 'failedMsg' => 'billing date not valid'));
      } else if (
        (($billingStartedAt > $checkBillingData['billingEndedAt']) &&
        ($billingEndedAt > $billingStartedAt)) ||
        !$checkBillingData
      ) {
        $billingDatas = array(
          'companyId' => $companyId,
          'billingAmount' => $this->input->post('billingAmount'),
          'billingStartedAt' => $billingStartedAt,
          'billingEndedAt' => $billingEndedAt,
          'billingStatus' => $this->input->post('billingStatus'),
        );
        $this->M_billings->insertBilling($billingDatas);
  
        echo json_encode(array('status' => 'success'));
      } else {
        echo json_encode(array('status' => 'failed', 'failedMsg' => 'billing date already used'));
      }
    }
  }

}

/* End of file Billings.php */

?>