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
            'title' => 'BIM Dashboard | Doctors',
            'subtitle' => 'Doctors',
            'contentType' => 'dashboard'
        );

        $partials = array(
            'head' => 'partials/head',
            'sidebar' => 'partials/dashboard/sidebar',
            'floatingMenu' => 'partials/dashboard/floatingMenu',
            'contentHeader' => 'partials/dashboard/contentHeader',
            'contentBody' => 'hospitals/Doctors',
            'footer' => 'partials/dashboard/footer',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

    public function getHospitalDoctorsDatas() {
        $adminDatas = $this->M_admins->checkAdmin('adminEmail', $this->session->userdata('adminEmail'));
        $hospitalDatas = $this->M_hospitals->checkHospital('adminId', $adminDatas['adminId']);
        $doctorsDatas = $this->M_doctors->getHospitalDoctorsDatas('hospitalId', $hospitalDatas['hospitalId']);
        $datas = array(
            'data' => $doctorsDatas
        );

        echo json_encode($datas);
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
                'field' => 'doctorEIN',
                'label' => 'EIN',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Doctor should provide an %s.'
                )
            ),
            array(
                'field' => 'doctorDateOfBirth',
                'label' => 'Date of Birth',
                'rules' => 'required',
                'errors' => array(
                    'required' => '%s is required.',
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
                'doctorEIN' => $this->input->post('doctorEIN'),
                'hospitalId' => $hospitalDatas['hospitalId'],
                'doctorName' => $this->input->post('doctorName'),
                'doctorAddress' => htmlspecialchars($this->input->post('doctorAddress')),
                'doctorDateOfBirth' => $this->input->post('doctorDateOfBirth'),
                'doctorSpecialization' => htmlspecialchars($this->input->post('doctorSpecialization')),
                'doctorStatus' => htmlspecialchars($this->input->post('doctorStatus'))
            );
            var_dump($doctorDatas);
            $this->M_doctors->insertDoctor($doctorDatas);

            echo json_encode(array('status' => 'success'));
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
                'field' => 'doctorEIN',
                'label' => 'EIN',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Doctor should provide an %s.'
                )
            ),
            array(
                'field' => 'doctorDateOfBirth',
                'label' => 'Date of Birth',
                'rules' => 'required',
                'errors' => array(
                    'required' => '%s is required.',
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
                'doctorEIN' => $this->input->post('doctorEIN'),
                'hospitalId' => $hospitalDatas['hospitalId'],
                'doctorName' => $this->input->post('doctorName'),
                'doctorAddress' => htmlspecialchars($this->input->post('doctorAddress')),
                'doctorDateOfBirth' => $this->input->post('doctorDateOfBirth'),
                'doctorSpecialization' => htmlspecialchars($this->input->post('doctorSpecialization')),
                'doctorStatus' => htmlspecialchars($this->input->post('doctorStatus'))
            );
            $this->M_doctors->updateDoctor($this->input->post('doctorEIN'), $doctorDatas);

            echo json_encode(array('status' => 'success'));
        }
    }

    public function deleteDoctor() {
        $doctorEIN = $this->input->post('doctorEIN');
        
        $this->M_doctors->deleteDoctor($doctorEIN);
        echo json_encode(array('status' => 'success'));
    }


}

?>