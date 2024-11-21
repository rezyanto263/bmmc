<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('adminRole') != ('admin' || 'hospitals')) {
            redirect('dashboard');
        }

        $this->load->model('M_hospitals');
    }
    

    public function index()
    {
        $datas = array(
            'title' => 'BIM Dashboard | Hospitals',
            'subtitle' => 'Hospitals',
            'contentType' => 'dashboard'
        );

        $partials = array(
            'head' => 'partials/head',
            'sidebar' => 'partials/hospitals/sidebar',
            'floatingMenu' => 'partials/dashboard/floatingMenu',
            'contentHeader' => 'partials/hospitals/contentHeader',
            'contentBody' => 'hospitals/Dashboard',
            'footer' => 'partials/dashboard/footer',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

}

/* End of file Company.php */

?>