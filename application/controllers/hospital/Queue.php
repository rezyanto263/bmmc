<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Queue extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('adminRole') != ('hospital')) {
            redirect('dashboard');
        }

        $this->load->model('M_historyhealth');
        $this->load->model('M_hospitals');
        $this->load->model('M_admins');
        $this->load->model('M_companies');
    }    

    public function index()
    {
        $datas = array(
            'title' => 'BMMC Hospital | Queue',
            'subtitle' => 'Queue',
            'contentType' => 'dashboard'
        );

        $partials = array(
            'head' => 'partials/head',
            'sidebar' => 'partials/hospital/sidebar',
            'floatingMenu' => 'partials/floatingMenu',
            'contentHeader' => 'partials/contentHeader',
            'contentBody' => 'hospital/Queue',
            'footer' => 'partials/hospital/footer',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

    public function getHospitalQueueDatas() {
        $adminDatas = $this->M_admins->checkAdmin('adminEmail', $this->session->userdata('adminEmail'));
        $hospitalDatas = $this->M_hospitals->checkHospital('adminId', $adminDatas['adminId']);
        $queueDatas = $this->M_hospitals->getHospitalQueueDatas($hospitalDatas['hospitalId']);
        if ($queueDatas) {
            $datas = array(
                'data' => $queueDatas,
            );
            echo json_encode($datas);
        } else {
            echo json_encode(['data' => []]);
        }
    }

    public function addQueue() {
        $adminDatas = $this->M_admins->checkAdmin('adminEmail', $this->session->userdata('adminEmail'));
        $hospitalDatas = $this->M_hospitals->checkHospital('adminId', $adminDatas['adminId']);
        
        if ($this->M_hospitals->addQueue($this->input->post('patientNIK'), $hospitalDatas['hospitalId'])) {
            echo json_encode(array('status' => 'success', 'csrfToken' => $this->security->get_csrf_hash()));
        } else {
            echo json_encode(array('status' => 'failed', 'failedMsg' => 'Gagal menambahkan antrian'));
        }
    }

    public function deleteQueue() {
        $adminDatas = $this->M_admins->checkAdmin('adminEmail', $this->session->userdata('adminEmail'));
        $hospitalDatas = $this->M_hospitals->checkHospital('adminId', $adminDatas['adminId']);
        
        $this->M_hospitals->deleteQueue($this->input->post('patientNIK'), $hospitalDatas['hospitalId']);
        echo json_encode(array('status' => 'success', 'csrfToken' => $this->security->get_csrf_hash()));
    }

    public function scanQR() {
        $qrInput = $this->input->post('qrData');
        if (!$qrInput) {
            echo json_encode(array(
                'status' => 'failed',
                'failedMsg' => 'qr data missing'
            ));
            return;
        }
    
        $decodedData = base64_decode($qrInput, true);
        if ($decodedData === false) {
            echo json_encode(array(
                'status' => 'failed',
                'failedMsg' => 'invalid qr'
            ));
            return;
        }

        
        $qrData = explode('-', $decodedData);
        if (!(count($qrData) == 2)) {
            echo json_encode(array(
                'status' => 'failed',
                'failedMsg' => 'incorrect format qr data'
            ));
            return;
        }
        
        $NIK = trim($qrData[0]) ?: NULL;
        $role = trim($qrData[1]) ?: NULL;
        if (!$NIK || !$role) {
            echo json_encode(array(
                'status' => 'failed',
                'failedMsg' => 'incomplete qr data'
            ));
            return;
        }
    
        $patientData = $role == 'employee' 
            ? $this->M_companies->getEmployeeByNIK($NIK) 
            : $this->M_companies->getFamilyByNIK($NIK);
    
        if ($patientData) {
            echo json_encode(array(
                'status' => 'success',
                'data' => $patientData,
            ));
        } else {
            echo json_encode(array(
                'status' => 'failed',
                'failedMsg' => 'scan not found'
            ));
        }
    }
}