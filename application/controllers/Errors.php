<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Errors extends CI_Controller {

  public function error404() {
    $datas = array(
      'title' => 'BMMC | Page Not Found',
      'subtitle' => 'Page Not Found',
      'contentType' => 'error'
    );

    $partials = array(
      'head' => 'partials/head',
      'content' => 'errors/404',
      'script' => 'partials/script'
    );

    $this->load->vars($datas);
    $this->load->view('masterError', $partials);
  }

}

/* End of file Errors.php */

?>