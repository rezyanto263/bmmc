<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class LandingToo extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('adminRole') != ('admin' || 'user')) {
            redirect('dashboard');
        }

    }
    

    public function index()
    {
        $datas = array(
            'title' => 'BIM | User',
            'subtitle' => 'User',
            'contentType' => 'user'
        );

        $partials = array(
            'head' => 'partials/head',
            'navbar' => 'partials/user/navbar',
            'footer' => 'partials/user/footer',
            'content' => 'user/landingToo',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

}

/* End of file Company.php */

?>