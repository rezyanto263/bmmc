<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class DetailBerita extends CI_Controller {    

    public function index()
    {
        $datas = array(
            'title' => 'BIM | User',
            'subtitle' => 'Detail Berita',
            'contentType' => 'user'
        );

        $partials = array(
            'head' => 'partials/head',
            'navbar' => 'partials/user/navbar',
            'footer' => 'partials/user/footer',
            'content' => 'user/DetailBerita',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

}

/* End of file Company.php */

?>