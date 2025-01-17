<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Queue extends CI_Controller {

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
            'title' => 'BMMC Hospital | Queue',
            'subtitle' => 'Queue',
            'contentType' => 'dashboard'
        );

        $partials = array(
            'head' => 'partials/head',
            'sidebar' => 'partials/hospital/sidebar',
            'floatingMenu' => 'partials/hospital/floatingMenu',
            'contentHeader' => 'partials/hospital/contentHeader',
            'contentBody' => 'hospitals/Queue',
            'footer' => 'partials/hospital/footer',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }
}