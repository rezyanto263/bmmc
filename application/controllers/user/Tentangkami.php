<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Tentangkami extends CI_Controller {    

    public function index()
    {
        $datas = array(
            'title' => 'BIM | User',
            'subtitle' => 'Tentang kami',
            'contentType' => 'user'
        );

        $partials = array(
            'head' => 'partials/head',
            'navbar' => 'partials/user/navbar',
            'footer' => 'partials/user/footer',
            'content' => 'user/Tentangkami',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

}

/* End of file Company.php */

?>