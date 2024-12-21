<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class MapMitra extends CI_Controller {    

    public function index()
    {
        $datas = array(
            'title' => 'BIM | User',
            'subtitle' => 'Map Mitra',
            'contentType' => 'user'
        );

        $partials = array(
            'head' => 'partials/head',
            'navbar' => 'partials/user/navbar',
            'footer' => 'partials/user/footer',
            'content' => 'user/MapMitra',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

}

/* End of file Company.php */

?>