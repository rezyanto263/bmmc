<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
use Ramsey\Uuid\Uuid;
class Insurance extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('adminRole') != ('admin' || 'company')) {
            redirect('dashboard');
        }
        
        $this->load->model('M_insurance');
    }

    public function index()
    {
        $datas = array(
            'title' => 'BMMC Company | Insurance',
            'subtitle' => 'Insurance',
            'contentType' => 'dashboard'
        );

        $partials = array(
            'head' => 'partials/head',
            'sidebar' => 'partials/company/sidebar',
            'floatingMenu' => 'partials/floatingMenu',
            'contentHeader' => 'partials/contentHeader',
            'contentBody' => 'company/Insurance',
            'footer' => 'partials/dashboard/footer',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

    public function getAllInsuranceByCompanyId() {
        $companyId = $this->session->userdata('companyId');
        $insuranceDatas = $this->M_insurance->getAllInsuranceByCompanyId($companyId);
        $datas = array(
            'data' => $insuranceDatas
        );
        echo json_encode($datas);
    }

    public function addInsurance() {
        $validate = array(
            // Aturan validasi untuk setiap field
            array(
                'field' => 'insuranceTier',
                'label' => 'Tingkat Asuransi',
                'rules' => 'required',
                'errors' => array('required' => 'Anda harus memberikan %s.')
            ),
            array(
                'field' => 'insuranceAmount',
                'label' => 'Jumlah Asuransi',
                'rules' => 'required|numeric',
                'errors' => array('required' => 'Anda harus memberikan %s.', 'numeric' => '%s harus berupa angka.')
            ),
            array(
                'field' => 'insuranceDescription',
                'label' => 'Deskripsi Asuransi',
                'rules' => 'required',
                'errors' => array('required' => 'Anda harus memberikan %s.')
            ),
        );
        $this->form_validation->set_rules($validate);
            
        // Validasi form
        if ($this->form_validation->run() == FALSE) {
            $errors = $this->form_validation->error_array();
            echo json_encode(array('status' => 'invalid', 'errors' => $errors));
        } else {
            $uuid = Uuid::uuid7();
            $companyId = $this->session->userdata('companyId');
            $insuranceData = array(
                'insuranceId' => $uuid->toString(),
                'companyId' => $companyId,
                'insuranceTier' => $this->input->post('insuranceTier'),
                'insuranceAmount' => $this->input->post('insuranceAmount'),
                'insuranceDescription' => $this->input->post('insuranceDescription')
            );
            $this->M_insurance->insertInsurance($insuranceData);
            echo json_encode(array('status' => 'success'));
        }
    }

    public function editInsurance() {
        $validate = array(
            // Aturan validasi untuk setiap field
            array(
                'field' => 'insuranceId',
                'label' => 'ID Asuransi',
                'rules' => 'required',
                'errors' => array('required' => 'Anda harus memberikan %s.')
            ),
            array(
                'field' => 'insuranceTier',
                'label' => 'Tingkat Asuransi',
                'rules' => 'required',
                'errors' => array('required' => 'Anda harus memberikan %s.')
            ),
            array(
                'field' => 'insuranceAmount',
                'label' => 'Jumlah Asuransi',
                'rules' => 'required|numeric',
                'errors' => array('required' => 'Anda harus memberikan %s.', 'numeric' => '%s harus berupa angka.')
            ),
            array(
                'field' => 'insuranceDescription',
                'label' => 'Deskripsi Asuransi',
                'rules' => 'required',
                'errors' => array('required' => 'Anda harus memberikan %s.')
            ),
        );
        $this->form_validation->set_rules($validate);
    
        // Validasi form
        if ($this->form_validation->run() == FALSE) {
            $errors = $this->form_validation->error_array();
            echo json_encode(array('status' => 'invalid', 'errors' => $errors));
        } else {
            $insuranceId = $this->input->post('insuranceId');
            $companyId = $this->session->userdata('companyId');
            $insuranceData = array(
                'insuranceTier' => $this->input->post('insuranceTier'),
                'insuranceAmount' => $this->input->post('insuranceAmount'),
                'insuranceDescription' => $this->input->post('insuranceDescription')
            );
            $this->M_insurance->updateInsurance($insuranceId, $insuranceData);
            echo json_encode(array('status' => 'success'));
        }
    }

    public function deleteInsurance() {
        $insuranceId = $this->input->post('insuranceId');
        $this->M_insurance->deleteInsurance($insuranceId);
        
        echo json_encode(array('status' => 'success'));
    }

}

/* End of file Insurance.php */

?>