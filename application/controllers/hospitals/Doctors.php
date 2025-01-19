<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Doctors extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('adminRole') != ('hospital')) {
            redirect('dashboard');
        }

        $this->load->model('M_doctors');
        $this->load->model('M_hospitals');
        $this->load->model('M_admins');
    }    

    public function index()
    {
        $datas = array(
            'title' => 'BMMC Hospital | Doctors',
            'subtitle' => 'Doctors',
            'contentType' => 'dashboard'
        );

        $partials = array(
            'head' => 'partials/head',
            'sidebar' => 'partials/hospital/sidebar',
            'floatingMenu' => 'partials/hospital/floatingMenu',
            'contentHeader' => 'partials/hospital/contentHeader',
            'contentBody' => 'hospitals/Doctors',
            'footer' => 'partials/hospital/footer',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

    public function getHospitalDoctorsDatas() {
        $adminDatas = $this->M_admins->checkAdmin('adminEmail', $this->session->userdata('adminEmail'));
        $hospitalDatas = $this->M_hospitals->checkHospital('adminId', $adminDatas['adminId']);

        if ($hospitalDatas) {
            $doctorsDatas = $this->M_doctors->getHospitalDoctorsDatas('hospitalId', $hospitalDatas['hospitalId']);
            $datas = array(
                'data' => $doctorsDatas
            );
            echo json_encode($datas);
        } else {
            echo json_encode(['data' => []]);
        }
    }

    public function addDoctor() {
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
            echo json_encode(array('status' => 'invalid', 'errors' => $errors, 'csrfToken' => $this->security->get_csrf_hash()));
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

            echo json_encode(array('status' => 'success', 'csrfToken' => $this->security->get_csrf_hash()));
        }
    }

    public function editDoctor() {
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
            $this->M_doctors->updateDoctor($this->input->post('doctorId'), $doctorDatas);

            echo json_encode(array('status' => 'success'));
        }
    }

    public function deleteDoctor() {
        $doctorId = $this->input->post('doctorId');
        
        $this->M_doctors->deleteDoctor($doctorId);
        echo json_encode(array('status' => 'success'));
    }


}

?>