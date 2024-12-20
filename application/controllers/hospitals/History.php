<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class History extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('adminRole') != ('hospital')) {
            redirect('dashboard');
        }
        
        $this->load->model('M_admins');
        $this->load->model('M_hospitals');
        $this->load->model('M_historyhealth');
        $this->load->model('M_hisealthtals');
        
    }    

    public function index()
    {
        $datas = array(
            'title' => 'BIM Dashboard | History',
            'subtitle' => 'History',
            'contentType' => 'dashboard'
        );

        $partials = array(
            'head' => 'partials/head',
            'sidebar' => 'partials/dashboard/sidebar',
            'floatingMenu' => 'partials/dashboard/floatingMenu',
            'contentHeader' => 'partials/dashboard/contentHeader',
            'contentBody' => 'hospitals/History',
            'footer' => 'partials/dashboard/footer',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

    public function getHospitalHistoriesDatas() {
        $adminDatas = $this->M_admins->checkAdmin('adminEmail', $this->session->userdata('adminEmail'));
        $hospitalDatas = $this->M_hospitals->checkHospital('adminId', $adminDatas['adminId']);

        if ($hospitalDatas) {
            $hisealthtalsDatas = $this->M_hisealthtals->getHospitalHisealthtalsDatas('hospitalId', $hospitalDatas['hospitalId']);
            $historyhealthIds = array_column($hisealthtalsDatas, 'historyhealthId');
        
            if ($historyhealthIds) {
                $historiesDatas = $this->M_historyhealth->getHospitalHistoriesDatas($historyhealthIds);
                $datas = array(
                    'data' => $historiesDatas,
                );
                echo json_encode($datas);
            } else {
                echo json_encode(['data' => []]);
            }
        } else {
            echo json_encode(['data' => []]);
        }
    }
    
}

?>