<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

use Ramsey\Uuid\Uuid;

class Insurance extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('adminRole') != 'company') {
            redirect('dashboard/login');
        }
        
        $this->load->model('M_insurances');
    }

    public function index()
    {
        $datas = array(
            'title' => 'BMMC Company | Insurances',
            'subtitle' => 'Insurances',
            'contentType' => 'dashboard'
        );

        $partials = array(
            'head' => 'partials/head',
            'sidebar' => 'partials/company/sidebar',
            'floatingMenu' => 'partials/floatingMenu',
            'contentHeader' => 'partials/contentHeader',
            'contentBody' => 'company/insurances',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

    public function getAllInsuranceByCompanyId() {
        $companyId = $this->session->userdata('companyId');
        $insuranceDatas = $this->M_insurances->getAllInsuranceByCompanyId($companyId);
        $datas = array(
            'data' => $insuranceDatas,
            'csrfToken' => $this->security->get_csrf_hash()
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
            echo json_encode(array('status' => 'invalid', 'errors' => $errors, 'csrfToken' => $this->security->get_csrf_hash()));
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
            $this->M_insurances->insertInsurance($insuranceData);
            echo json_encode(array('status' => 'success', 'csrfToken' => $this->security->get_csrf_hash()));
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
            echo json_encode(array('status' => 'invalid', 'errors' => $errors, 'csrfToken' => $this->security->get_csrf_hash()));
        } else {
            $insuranceId = $this->input->post('insuranceId');
            $companyId = $this->session->userdata('companyId');
            $insuranceData = array(
                'insuranceTier' => $this->input->post('insuranceTier'),
                'insuranceAmount' => $this->input->post('insuranceAmount'),
                'insuranceDescription' => $this->input->post('insuranceDescription')
            );
            $this->M_insurances->updateInsurance($insuranceId, $insuranceData);
            echo json_encode(array('status' => 'success', 'csrfToken' => $this->security->get_csrf_hash()));
        }
    }

    public function deleteInsurance() {
        $insuranceId = $this->input->post('insuranceId');
        $this->M_insurances->deleteInsurance($insuranceId);
        
        echo json_encode(array('status' => 'success', 'csrfToken' => $this->security->get_csrf_hash()));
    }

}

/* End of file Insurance.php */

?>