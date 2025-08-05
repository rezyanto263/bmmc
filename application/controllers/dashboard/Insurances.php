<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

use Ramsey\Uuid\Uuid;

class Insurances extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('adminRole') != 'admin') {
            redirect('dashboard/login');
        }
        
        $this->load->model('M_insurances');
    }

    public function index()
    {
        $datas = array(
            'title' => 'BMMC Dashboard | Insurances',
            'subtitle' => 'Insurances',
            'contentType' => 'dashboard'
        );

        $partials = array(
            'head' => 'partials/head',
            'sidebar' => 'partials/dashboard/sidebar',
            'floatingMenu' => 'partials/floatingMenu',
            'contentHeader' => 'partials/contentHeader',
            'contentBody' => 'dashboard/insurances',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

    public function getAllInsurance() {
        $insuranceDatas = $this->M_insurances->getAllInsurance();
        $datas = array(
            'data' => $insuranceDatas,
            'csrfToken' => $this->security->get_csrf_hash()
        );

        echo json_encode($datas);
    }

    public function addInsurance() {
        $validate = array(
            array(
                'field' => 'insuranceTier',
                'label' => 'Tier',
                'rules' => 'required',
                'errors' => array(
                    'required' => 'Insurance should provide a %s name.'
                )
            ),
            array(
                'field' => 'insuranceAmount',
                'label' => 'Amount',
                'rules' => 'required|numeric',
                'errors' => array(
                    'required' => 'Insurance should provide an %s.', 
                    'numeric' => '%s should be a number'
                )
            )
        );
        $this->form_validation->set_rules($validate);

        if ($this->form_validation->run() == FALSE) {
            $errors = $this->form_validation->error_array();
            echo json_encode(array('status' => 'invalid', 'errors' => $errors, 'csrfToken' => $this->security->get_csrf_hash()));
        } else {
            $uuid = Uuid::uuid7();
            $insuranceData = array(
                'insuranceId' => $uuid->toString(),
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
            array(
                'field' => 'insuranceId',
                'label' => 'ID',
                'rules' => 'required',
                'errors' => array(
                    'required' => 'Insurance should provide an %s.'
                )
            ),
            array(
                'field' => 'insuranceTier',
                'label' => 'Tier',
                'rules' => 'required',
                'errors' => array(
                    'required' => 'Insurance should provide a %s name.'
                )
            ),
            array(
                'field' => 'insuranceAmount',
                'label' => 'Amount',
                'rules' => 'required|numeric',
                'errors' => array(
                    'required' => 'Insurance should provide an %s.', 
                    'numeric' => '%s should be a number'
                )
            )
        );
        $this->form_validation->set_rules($validate);

        if ($this->form_validation->run() == FALSE) {
            $errors = $this->form_validation->error_array();
            echo json_encode(array('status' => 'invalid', 'errors' => $errors, 'csrfToken' => $this->security->get_csrf_hash()));
        } else {
            $insuranceId = $this->input->post('insuranceId');
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

/* End of file Insurances.php */

?>