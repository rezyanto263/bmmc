<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('adminRole') != 'admin') {
            redirect('dashboard/login');
        }
    }
    

    public function index() {
        $this->load->model('M_dashboard');

        $totalCompanies = $this->M_dashboard->countCompanies();
        $totalInvoices = $this->M_dashboard->countInvoices();
        $totalHospitals = $this->M_dashboard->countHospitals();
        $totalTreatments = $this->M_dashboard->countTreatments();
        $reserveFunds = $this->M_dashboard->getReserveFundsThisMonth();
        $claimPayouts = $this->M_dashboard->getClaimPayoutsThisMonth();
        $unutilizedFunds = $reserveFunds - $claimPayouts;


        $datas = array(
            'title' => 'BMMC Dashboard',
            'subtitle' => 'Dashboard',
            'contentType' => 'dashboard',
            'totalCompanies' => $totalCompanies,
            'totalInvoices' => $totalInvoices,
            'totalHospitals' => $totalHospitals,
            'totalTreatments' => $totalTreatments,
            'reserveFunds' => $reserveFunds,
            'claimPayouts' => $claimPayouts,
            'unutilizedFunds' => $unutilizedFunds
        );

        $partials = array(
            'head' => 'partials/head',
            'sidebar' => 'partials/dashboard/sidebar',
            'floatingMenu' => 'partials/floatingMenu',
            'contentHeader' => 'partials/contentHeader',
            'contentBody' => 'dashboard/dashboard',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

    public function scanQR() {
        $this->load->library('encryption');
        $qrInput = $this->encryption->decrypt($this->input->post('qrData'));
        if (!$qrInput) {
            echo json_encode(array(
                'status' => 'failed',
                'failedMsg' => 'qr data missing',
                'csrfToken' => $this->security->get_csrf_hash()
            ));
            return;
        }

        $qrData = explode('-', $qrInput);
        if (!(count($qrData) == 2)) {
            echo json_encode(array(
                'status' => 'failed',
                'failedMsg' => 'incorrect format qr data',
                'csrfToken' => $this->security->get_csrf_hash()
            ));
            return;
        }
        
        $NIK = trim($qrData[0]) ?: NULL;
        $role = trim($qrData[1]) ?: NULL;
        if (!$NIK || !$role) {
            echo json_encode(array(
                'status' => 'failed',
                'failedMsg' => 'incomplete qr data',
                'csrfToken' => $this->security->get_csrf_hash()
            ));
            return;
        }

        if ($role == 'employee') {
            $this->load->model('M_employees');
            $patientData = $this->M_employees->getEmployeeByNIK($NIK);
        } else {
            $this->load->model('M_families');
            $patientData = $this->M_families->getFamilyByNIK($NIK);
        }
        
        $employeeNIK = $patientData['employeeNIK'];
        $this->load->model('M_insurances');
        $insuranceData = $this->M_insurances->getInsuranceDetailsByEmployeeNIK($employeeNIK);

        if ($patientData) {
            echo json_encode(array(
                'status' => 'success',
                'data' => array(
                    'profile' => $patientData, 
                    'insurance' => $insuranceData
                ),
                'csrfToken' => $this->security->get_csrf_hash()
            ));
        } else {
            echo json_encode(array(
                'status' => 'failed',
                'failedMsg' => 'scan not found',
                'csrfToken' => $this->security->get_csrf_hash()
            ));
        }
    }

}

/* End of file Dashboard.php */

?>