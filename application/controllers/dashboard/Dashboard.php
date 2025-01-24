<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('adminRole') != 'admin') {
            redirect('dashboard/login');
        }
    }
    

    public function index()
    {
        $datas = array(
            'title' => 'BMMC Dashboard',
            'subtitle' => 'Dashboard',
            'contentType' => 'dashboard',
        );

        $partials = array(
            'head' => 'partials/head',
            'sidebar' => 'partials/dashboard/sidebar',
            'floatingMenu' => 'partials/floatingMenu',
            'contentHeader' => 'partials/contentHeader',
            'contentBody' => 'dashboard/dashboard',
            'footer' => 'partials/dashboard/footer',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

}

/* End of file Dashboard.php */

?>