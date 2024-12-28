<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Patient extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('adminRole') != ('hospital')) {
            redirect('dashboard');
        }

        $this->load->model('M_hospitals');
        $this->load->model('M_historyhealth');
        $this->load->model('M_hisealthtals');
    }    

    public function index()
    {
        $datas = array(
            'title' => 'BIM Dashboard | Patient',
            'subtitle' => 'Patient',
            'contentType' => 'dashboard'
        );

        $partials = array(
            'head' => 'partials/head',
            'sidebar' => 'partials/dashboard/sidebar',
            'floatingMenu' => 'partials/dashboard/floatingMenu',
            'contentHeader' => 'partials/dashboard/contentHeader',
            'contentBody' => 'hospitals/Patient',
            'footer' => 'partials/dashboard/footer',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }
}
?>