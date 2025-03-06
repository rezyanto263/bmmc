<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class About extends CI_Controller {    

    public function index()
    {
        $datas = array(
            'title' => 'BMMC | About',
            'subtitle' => 'About',
            'contentType' => 'user'
        );

        $partials = array(
            'head' => 'partials/head',
            'navbar' => 'partials/user/navbar',
            'content' => 'user/about',
            'footer' => 'partials/user/footer',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

}

/* End of file About.php */

?>