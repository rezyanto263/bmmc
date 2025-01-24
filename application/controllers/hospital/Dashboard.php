<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('adminRole') != ('hospital')) {
            redirect('dashboard');
        }

        $this->load->model('M_hospitals');
    }
    

    public function index() {
        $adminId = $this->session->userdata('adminId');

        $hospitalData = $this->M_hospitals->checkHospital('adminId', $adminId);

        if (!empty($hospitalData)) {
            $this->session->set_userdata('hospitalId', $hospitalData['hospitalId']);
            $this->session->set_userdata('hospitalName', $hospitalData['hospitalName']);
            $this->session->set_userdata('hospitalLogo', $hospitalData['hospitalLogo']);
            $this->session->set_userdata('hospitalPhone', $hospitalData['hospitalPhone']);
            $this->session->set_userdata('hospitalAddress', $hospitalData['hospitalAddress']);
            $this->session->set_userdata('hospitalCoordinate', $hospitalData['hospitalCoordinate']);
        }

        $hospital = array(
            'hospitalId' => $this->session->userdata('hospitalId'),
            'hospitalName' => $this->session->userdata('hospitalName'),
            'hospitalLogo' => $this->session->userdata('hospitalLogo'),
            'hospitalPhone' => $this->session->userdata('hospitalPhone'),
            'hospitalAddress' => $this->session->userdata('hospitalAddress'),
            'hospitalCoordinate' => $this->session->userdata('hospitalCoordinate')
        );

        $datas = array(
            'title' => 'BMMC Hospital | Dashboard',
            'subtitle' => 'Dashboard',
            'contentType' => 'dashboard'
        );

        $partials = array(
            'head' => 'partials/head',
            'sidebar' => 'partials/hospital/sidebar',
            'floatingMenu' => 'partials/floatingMenu',
            'contentHeader' => 'partials/contentHeader',
            'contentBody' => 'hospitals/Hospital',
            'footer' => 'partials/hospital/footer',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }
}
?>