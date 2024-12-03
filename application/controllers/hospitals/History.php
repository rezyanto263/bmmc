<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class History extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('adminRole') != ('hospital')) {
            redirect('dashboard');
        }
        
        $this->load->model('M_admins');
        $this->load->model('M_hospitals');
        
    }    

    public function index()
    {
        $datas = array(
            'title' => 'BIM Dashboard | History',
            'subtitle' => 'History',
            'contentType' => 'dashboard'
        );

        $partials = array(
            'head' => 'partials/head',
            'sidebar' => 'partials/dashboard/sidebar',
            'floatingMenu' => 'partials/dashboard/floatingMenu',
            'contentHeader' => 'partials/dashboard/contentHeader',
            'contentBody' => 'hospitals/History',
            'footer' => 'partials/dashboard/footer',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

    public function getAllHospitalsDatas() {
        $hospitalsDatas = $this->M_hospitals->getAllHospitalsDatas();
        $datas = array(
            'data' => $hospitalsDatas
        );

        echo json_encode($datas);
    }
}

?>