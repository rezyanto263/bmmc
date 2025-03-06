<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Partners extends CI_Controller {    

    public function index()
    {
        $datas = array(
            'title' => 'BMMC | Partners',
            'subtitle' => 'Partners',
            'contentType' => 'user'
        );

        $partials = array(
            'head' => 'partials/head',
            'navbar' => 'partials/user/navbar',
            'footer' => 'partials/user/footer',
            'content' => 'user/partners',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

    public function getAllActivePartnersMapData() {
        $this->load->model(['M_companies', 'M_hospitals']);
        
        $allActiveCompaniesMapData = $this->M_companies->getAllActiveCompaniesMapData();
        $allActiveHospitalsMapData = $this->M_hospitals->getAllActiveHospitalsMapData();

        $allActivePartnersMapData = array_merge($allActiveHospitalsMapData, $allActiveCompaniesMapData);

        $datas = array(
            'data' => $allActivePartnersMapData
        );
        
        echo json_encode($datas);
    }

}

/* End of file Partners.php */

?>