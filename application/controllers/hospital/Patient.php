<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Patient extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('adminRole') != ('hospital')) {
            redirect('dashboard');
        }

        $this->load->model('M_patient');
        $this->load->model('M_companies');
        $this->load->model('M_hospitals');
        $this->load->model('M_historyhealth');
    }    

    public function index()
    {
        $datas = array(
            'title' => 'BMMC Hospital | Patient Profile',
            'subtitle' => 'Patient Profile',
            'contentType' => 'dashboard'
        );

        $partials = array(
            'head' => 'partials/head',
            'sidebar' => 'partials/hospital/sidebar',
            'floatingMenu' => 'partials/hospital/floatingMenu',
            'contentHeader' => 'partials/hospital/contentHeader',
            'contentBody' => 'hospital/Patient',
            'footer' => 'partials/hospital/footer',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
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
?>