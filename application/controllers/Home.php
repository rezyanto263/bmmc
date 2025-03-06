<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {    

    public function index() {
        $this->load->model(['M_companies', 'M_hospitals', 'M_news']);

        $allCompaniesLogo = array_column($this->M_companies->getAllCompaniesLogo(), 'companyLogo');
        $allHospitalsLogo = array_column($this->M_hospitals->getAllHospitalsLogo(), 'hospitalLogo');
        $totalInsuranceMembers = $this->M_companies->getAllCompaniesInsuranceMembers();
        $totalCompanies = $this->M_companies->getTotalCompanies();
        $totalHospitals = $this->M_hospitals->getTotalHospitals();
        $fourLatestNews = $this->M_news->getFourLatestNews();

        $datas = array(
            'title' => 'BMMC | Bali Mitra Medical Center',
            'subtitle' => 'Home',
            'contentType' => 'user',
            'allHospitalsLogo' => $allHospitalsLogo,
            'allCompaniesLogo' => $allCompaniesLogo,
            'totalMembers' => $totalInsuranceMembers,
            'totalCompanies' => $totalCompanies,
            'totalHospitals' => $totalHospitals,
            'latestNews' => $fourLatestNews
        );

        $partials = array(
            'head' => 'partials/head',
            'navbar' => 'partials/user/navbar',
            'content' => 'user/home',
            'footer' => 'partials/user/footer',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

}

/* End of file Home.php */

?>