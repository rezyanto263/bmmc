<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Hospital extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('adminRole') != ('hospital')) {
            redirect('dashboard');
        }

        $this->load->model('M_hospitals');
    }
    

    public function index()
    {
        $datas = array(
            'title' => 'BIM Hospital | Profile',
            'subtitle' => 'Hospital',
            'contentType' => 'dashboard'
        );

        $partials = array(
            'head' => 'partials/head',
            'sidebar' => 'partials/hospital/sidebar',
            'floatingMenu' => 'partials/floatingMenu',
            'contentHeader' => 'partials/contentHeader',
            'contentBody' => 'hospitals/Hospital',
            'footer' => 'partials/hospital/footer',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }
}
?>