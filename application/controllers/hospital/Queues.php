<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Queues extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('adminRole') != 'hospital') {
            redirect('dashboard/login');
        }

        $this->load->model('M_hospitals');
        $this->load->model('M_admins');
    }    

    public function index() {
        $datas = array(
            'title' => 'BMMC Hospital | Queues',
            'subtitle' => 'Queues',
            'contentType' => 'dashboard'
        );

        $partials = array(
            'head' => 'partials/head',
            'sidebar' => 'partials/hospital/sidebar',
            'floatingMenu' => 'partials/floatingMenu',
            'contentHeader' => 'partials/contentHeader',
            'contentBody' => 'hospital/queues',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

    public function getHospitalQueueDatas() {
        $hospitalId = $this->session->userdata('hospitalId');
        $queueDatas = $this->M_hospitals->getHospitalQueueDatas($hospitalId);
        $datas = array(
            'data' => !empty($queueDatas[0]['patientNIK']) ? $queueDatas : [],
        );

        echo json_encode($datas);
    }

    public function addQueue() {
        $hospitalId = $this->session->userdata('hospitalId');
        $patientNIK = $this->input->post('patientNIK');
        $patientRole = $this->input->post('patientRole');

        if ($patientRole === 'employee') {
            $this->load->model('M_employees');
            $companyStatus = $this->M_employees->getEmployeeByNIK($patientNIK)['companyStatus'];
        } else {
            $this->load->model('M_families');
            $companyStatus = $this->M_families->getFamilyByNIK($patientNIK)['companyStatus'];
        }

        if (in_array($companyStatus, array('on hold', 'discontinued', 'unverified'))) {
            echo json_encode(array(
                'status' => 'failed', 
                'failedMsg' => 'add queue failed',
                'errorMsg' => $companyStatus,
                'csrfToken' => $this->security->get_csrf_hash()
            ));
            return;
        }

        $this->M_hospitals->addQueue($patientNIK, $patientRole, $hospitalId);
        echo json_encode(array('status' => 'success', 'csrfToken' => $this->security->get_csrf_hash()));
    }

    public function deleteQueue() {
        $hospitalId = $this->session->userdata('hospitalId');
        $patientNIK = $this->input->post('patientNIK');
        
        $this->M_hospitals->deleteQueue($patientNIK, $hospitalId);
        echo json_encode(array('status' => 'success', 'csrfToken' => $this->security->get_csrf_hash()));
    }

    public function getQueuedPatientDetails() {
        $patientNIK = $this->input->get('nik');
        $patientRole = $this->input->get('role');

        if ($patientRole == 'employee') {
            $this->load->model('M_employees');
            $patientData = $this->M_employees->getEmployeeByNIK($patientNIK);
        } else {
            $this->load->model('M_families');
            $patientData = $this->M_families->getFamilyByNIK($patientNIK);
        }

        $employeeNIK = $patientData['employeeNIK'];
        $this->load->model('M_insurances');
        $insuranceData = $this->M_insurances->getInsuranceDetailsByEmployeeNIK($employeeNIK);

        $datas = array(
            'data' => array(
                'profile' => $patientData, 
                'insurance' => $insuranceData
            ),
        );

        echo json_encode($datas);
    }

    public function getQueuedPatientByNIK() {
        $patientNIK = $this->input->get('nik');
        $patientRole = $this->input->get('role');
        $patientDatas = $this->M_hospitals->getQueuedPatientByNIK($patientNIK, $patientRole);
        $datas = array(
            'data' => $patientDatas,
        );

        echo json_encode($datas);
    }

    public function getAllHospitalsDatas() {
        $hospitalsDatas = $this->M_hospitals->getAllHospitalsDatas();
        $datas = array(
            'data' => $hospitalsDatas
        );

        echo json_encode($datas);
    }
}
