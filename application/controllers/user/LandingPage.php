<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class LandingPage extends CI_Controller {    

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_hospitals');
    }

    public function index()
    {
        $datas = array(
            'title' => 'BMMC | User',
            'subtitle' => 'Landing Page',
            'contentType' => 'user'
        );

        $partials = array(
            'head' => 'partials/head',
            'navbar' => 'partials/user/navbar',
            'footer' => 'partials/user/footer',
            'content' => 'user/landingPage',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

    public function getActiveHospitalDatas() {
        $hospitalDatas = $this->M_hospitals->getActiveHospitalsDatas();
        if ($hospitalDatas) {
            $datas = array(
                'status' => 'success',
                'data' => $hospitalDatas
            );
            echo json_encode($datas);
        } else {
            echo json_encode(['status' => 'failed', 'data' => []]);
        }
    }

}

/* End of file Company.php */

?>