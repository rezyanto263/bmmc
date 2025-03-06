<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Diseases extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('adminRole') != 'hospital') {
            redirect('dashboard/login');
        }

        $this->load->model('M_healthhistories');
        $this->load->model('M_hospitals');
        $this->load->model('M_diseases');
    }    

    public function index()
    {
        $datas = array(
            'title' => 'BMMC Hospital | Disease',
            'subtitle' => 'Disease',
            'contentType' => 'dashboard'
        );

        $partials = array(
            'head' => 'partials/head',
            'sidebar' => 'partials/hospital/sidebar',
            'floatingMenu' => 'partials/floatingMenu',
            'contentHeader' => 'partials/contentHeader',
            'contentBody' => 'hospital/Disease',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

    public function getDiseaseDatas() {
        $diseaseDatas = $this->M_hospitals->getDiseaseDatas();
        $datas = array(
            'data' => $diseaseDatas
        );

        echo json_encode($datas);
    }

    public function getCompanyDiseases() {
        $companyId = $this->input->get('id');
        $diseaseDatas = $this->M_diseases->getCompanyDiseases($companyId);
        $datas = array( 
            'data' => $diseaseDatas
        );

        echo json_encode($datas);
    }
}