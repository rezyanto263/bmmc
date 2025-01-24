<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class TreatmentHistory extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('adminRole') != 'company') {
            redirect('dashboard');
        }

        $this->load->model('M_historyhealth');
    }
    public function index()
    {
        $datas = array(
            'title' => 'BIM Dashboard | Companies',
            'subtitle' => 'Treatment History',
            'contentType' => 'dashboard'
        );
        $partials = array(
            'head' => 'partials/head',
            'sidebar' => 'partials/company/sidebar',
            'floatingMenu' => 'partials/floatingMenu',
            'contentHeader' => 'partials/contentHeader',
            'contentBody' => 'company/TreatmentHistory',
            'footer' => 'partials/dashboard/footer',
            'script' => 'partials/script'
        );
        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

    public function getHistoryHealthByCompanyId() {
        $companyId = $this->session->userdata('companyId');
        $historyhealthDatas = $this->M_historyhealth->getHistoryHealthByCompanyId($companyId);
        $datas = array(
            'data' => $historyhealthDatas
        );

        echo json_encode($datas);
    }
}
/* End of file Company.php */
?>