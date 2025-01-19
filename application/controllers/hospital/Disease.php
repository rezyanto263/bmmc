<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Disease extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('adminRole') != ('hospital')) {
            redirect('dashboard');
        }

        $this->load->model('M_historyhealth');
        $this->load->model('M_hospitals');
        $this->load->model('M_admins');
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
            'floatingMenu' => 'partials/hospital/floatingMenu',
            'contentHeader' => 'partials/hospital/contentHeader',
            'contentBody' => 'hospital/Disease',
            'footer' => 'partials/hospital/footer',
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
}