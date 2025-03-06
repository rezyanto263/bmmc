<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Doctors extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('adminRole') != 'hospital') {
            redirect('dashboard/login');
        }

        $this->load->model('M_doctors');
        $this->load->model('M_hospitals');
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
            'floatingMenu' => 'partials/floatingMenu',
            'contentHeader' => 'partials/contentHeader',
            'contentBody' => 'hospital/doctors',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

    public function getAllDoctorsByHospitalId() {
        $hospitalId = $this->input->get('id') ?: $this->session->userdata('hospitalId');
        $doctorDatas = $this->M_doctors->getAllDoctorsByHospitalId($hospitalId);
        $datas = array(
            'data' => $doctorDatas
        );

        echo json_encode($datas);
    }

    public function getAllDoctorSpecialization() {
        $hospitalId = $this->input->get('id') ?: $this->session->userdata('hospitalId');
        $specializationDatas = array_unique(explode(', ', $this->M_doctors->getAllDoctorSpecialization($hospitalId)));
        $datas = array(
            'data' => array_values($specializationDatas)
        );

        echo json_encode($datas);
    }

    public function addDoctor() {
        $validate = array(
            array(
                'field' => 'doctorName',
                'label' => 'Name',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Doctor should provide a %s.',
                )
            ),
            array(
                'field' => 'doctorDateOfBirth',
                'label' => 'Date of Birth',
                'rules' => 'less_than_or_equal_to_date['.date('Y-m-d').']',
                'errors' => array(
                    'less_than_or_equal_to_date' => '%s must not be later than today.',
                )
            ),
            array(
                'field' => 'doctorAddress',
                'label' => 'Address',
                'rules' => 'trim',
            ),
            array(
                'field' => 'doctorSpecialization[]',
                'label' => 'Specialize',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Doctor should provide a %s.',
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
            $doctorSpecialization = $this->input->post('doctorSpecialization');
            $specializations = htmlspecialchars(implode(', ', $doctorSpecialization));
            $doctorDatas = array(
                'hospitalId' => $this->session->userdata('hospitalId'),
                'doctorName' => htmlspecialchars($this->input->post('doctorName'), ENT_COMPAT),
                'doctorSpecialization' => $specializations,
                'doctorStatus' => htmlspecialchars($this->input->post('doctorStatus')),
                'doctorDateOfBirth' => htmlspecialchars($this->input->post('doctorDateOfBirth') ?: '') ?: NULL,
                'doctorAddress' => htmlspecialchars($this->input->post('doctorAddress') ?: '', ENT_NOQUOTES) ?: NULL
            );

            $this->M_doctors->insertDoctor($doctorDatas);
            echo json_encode(array('status' => 'success', 'csrfToken' => $this->security->get_csrf_hash()));
        }
    }

    public function editDoctor() {
        $validate = array(
            array(
                'field' => 'doctorName',
                'label' => 'Name',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Doctor should provide a %s.'
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
                'field' => 'doctorSpecialization[]',
                'label' => 'Specialize',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Doctor should provide a %s.',
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
            $doctorSpecialization = $this->input->post('doctorSpecialization');
            $specializations = htmlspecialchars(implode(', ', $doctorSpecialization), ENT_COMPAT);
            $doctorDatas = array(
                'hospitalId' => $this->session->userdata('hospitalId'),
                'doctorName' => htmlspecialchars($this->input->post('doctorName'), ENT_COMPAT),
                'doctorSpecialization' => $specializations,
                'doctorStatus' => htmlspecialchars($this->input->post('doctorStatus')),
                'doctorDateOfBirth' => htmlspecialchars($this->input->post('doctorDateOfBirth') ?: '') ?: NULL,
                'doctorAddress' => htmlspecialchars($this->input->post('doctorAddress') ?: '', ENT_NOQUOTES) ?: NULL
            );

            $doctorId = htmlspecialchars($this->input->post('doctorId'));
            $this->M_doctors->updateDoctor($doctorId, $doctorDatas);

            echo json_encode(array('status' => 'success', 'data' => $doctorDatas, 'csrfToken' => $this->security->get_csrf_hash()));
        }
    }

    public function deleteDoctor() {
        $doctorId = $this->input->post('doctorId');
        
        $this->M_doctors->deleteDoctor($doctorId);
        echo json_encode(array('status' => 'success', 'csrfToken' => $this->security->get_csrf_hash()));
    }

}

?>