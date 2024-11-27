<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Family extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('adminRole') != ('admin' || 'company')) {
            redirect('dashboard');
        }
    }

    public function index()
    {
        $datas = array(
            'title' => 'BIM Dashboard | Companies',
            'subtitle' => 'Family',
            'contentType' => 'dashboard'
        );

        $partials = array(
            'head' => 'partials/head',
            'sidebar' => 'partials/company/sidebar',
            'floatingMenu' => 'partials/dashboard/floatingMenu',
            'contentHeader' => 'partials/company/contentHeader',
            'contentBody' => 'company/Family',
            'footer' => 'partials/dashboard/footer',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

}

/* End of file Company.php */

?>