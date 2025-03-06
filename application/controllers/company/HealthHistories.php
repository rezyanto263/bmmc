<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class HealthHistories extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('adminRole') != 'company') {
            redirect('dashboard');
        }

        $this->load->model('M_healthhistories');
    }

    public function index() {
        $datas = array(
            'title' => 'BMMC Dashboard | Health Histories',
            'subtitle' => 'Health Histories',
            'contentType' => 'dashboard'
        );
        $partials = array(
            'head' => 'partials/head',
            'sidebar' => 'partials/company/sidebar',
            'floatingMenu' => 'partials/floatingMenu',
            'contentHeader' => 'partials/contentHeader',
            'contentBody' => 'company/healthhistories',
            'script' => 'partials/script'
        );
        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

    public function getAllHealthHistoriesByCompanyId() {
        $companyId = $this->session->userdata('companyId');
        $healthhistoriesDatas = $this->M_healthhistories->getAllHealthHistoriesByCompanyId($companyId);
        $datas = array(
            'data' => $healthhistoriesDatas
        );

        echo json_encode($datas);
    }

    public function getAllHealthHistoriesByBillingId() {
        $billingId = $this->input->get('id');
        $healthhistoriesDatas = $this->M_healthhistories->getAllHealthHistoriesByBillingId($billingId);
        $datas = array(
            'data' => $healthhistoriesDatas
        );

        echo json_encode($datas);
    }

    public function getPatientHealthHistoryDetailsByNIK() {
        $patientNIK = $this->input->get('nik');
        $patientRole = $this->input->get('role');
        $healthhistoryDatas = $this->M_healthhistories->getPatientHealthHistoryDetailsByNIK($patientNIK, $patientRole);
        $datas = array(
            'data' => $healthhistoryDatas
        );

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($datas));
    }

}

/* End of file HealthHistories.php */

?>