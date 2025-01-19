<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class History extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('adminRole') != ('hospital')) {
            redirect('dashboard');
        }
        
        $this->load->model('M_admins');
        $this->load->model('M_hospitals');
        $this->load->model('M_historyhealth');
        
    } 

    public function index()
    {
        $datas = array(
            'title' => 'BMMC Hospital | History',
            'subtitle' => 'History',
            'contentType' => 'dashboard'
        );

        $partials = array(
            'head' => 'partials/head',
            'sidebar' => 'partials/hospital/sidebar',
            'floatingMenu' => 'partials/hospital/floatingMenu',
            'contentHeader' => 'partials/hospital/contentHeader',
            'contentBody' => 'hospital/History',
            'footer' => 'partials/hospital/footer',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

    public function getHospitalHistoriesDatas() {
        $adminDatas = $this->M_admins->checkAdmin('adminEmail', $this->session->userdata('adminEmail'));
        $hospitalDatas = $this->M_hospitals->checkHospital('adminId', $adminDatas['adminId']);
        $historiesDatas = $this->M_historyhealth->getHospitalHistoriesDatas($hospitalDatas['hospitalId']);
        if ($historiesDatas) {
            $datas = array(
                'data' => $historiesDatas,
            );
            echo json_encode($datas);
        } else {
            echo json_encode(['data' => []]);
        }
    }

    public function getHPatientHistoryHealthDetailsByNIK($patientNIK) {
        $historyhealthDatas = $this->M_hospitals->getPatientHistoryHealthDetailsByNIK($patientNIK);
        $datas = array(
            'data' => $historyhealthDatas
        );
        echo json_encode($datas);
    }

    public function addReferral() {
        $adminDatas = $this->M_admins->checkAdmin('adminEmail', $this->session->userdata('adminEmail'));
        $hospitalDatas = $this->M_hospitals->checkHospital('adminId', $adminDatas['adminId']);
        $validate = array(
            array(
                'field' => 'doctorName',
                'label' => 'Name',
                'rules' => 'required|trim|regex_match[/^[a-zA-Z\s\'-]+$/]',
                'errors' => array(
                    'required' => 'Doctor should provide a %s.',
                    'regex_match' => '%s can only contain letters, spaces, hyphens, and apostrophes.'
                )
            ),
            array(
                'field' => 'doctorDateOfBirth',
                'label' => 'Date of Birth',
                'rules' => 'required|less_than_or_equal_to_date['.date('Y-m-d').']',
                'errors' => array(
                    'required' => '%s is required.',
                    'less_than_or_equal_to_date' => '%s must not be later than today.',
                )
            ),
            array(
                'field' => 'doctorAddress',
                'label' => 'Address',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Doctor should provide a %s.'
                )
            ),
            array(
                'field' => 'doctorSpecialization',
                'label' => 'Specialize',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Hospital should provide a %s.',
                )
            ),
            array(
                'field' => 'doctorStatus',
                'label' => 'Status',
                'rules' => 'required|trim|regex_match[/^[a-zA-Z\s]+$/]',
                'errors' => array(
                    'required' => 'You should provide a %s.',
                    'regex_match' => '%s can only contain letters and spaces.'
                )
            ),
        );
        $this->form_validation->set_rules($validate);

        if ($this->form_validation->run() == FALSE) {
            $errors = $this->form_validation->error_array();
            echo json_encode(array('status' => 'invalid', 'errors' => $errors));
        } else {
            $doctorDatas = array(
                'hospitalId' => $hospitalDatas['hospitalId'],
                'doctorName' => $this->input->post('doctorName'),
                'doctorAddress' => htmlspecialchars($this->input->post('doctorAddress')),
                'doctorDateOfBirth' => $this->input->post('doctorDateOfBirth'),
                'doctorSpecialization' => htmlspecialchars($this->input->post('doctorSpecialization')),
                'doctorStatus' => htmlspecialchars($this->input->post('doctorStatus'))
            );
            $this->M_doctors->insertDoctor($doctorDatas);

            echo json_encode(array('status' => 'success'));
        }
    }
}

?>