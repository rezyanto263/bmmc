<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('adminRole') != ('admin' || 'company')) {
            redirect('dashboard');
        }

        $this->load->model('M_employee');
    }

    public function index()
    {
        $datas = array(
            'title' => 'BIM Dashboard | Companies',
            'subtitle' => 'Employee',
            'contentType' => 'dashboard'
        );

        $partials = array(
            'head' => 'partials/head',
            'sidebar' => 'partials/company/sidebar',
            'floatingMenu' => 'partials/dashboard/floatingMenu',
            'contentHeader' => 'partials/company/contentHeader',
            'contentBody' => 'company/Employee',
            'footer' => 'partials/dashboard/footer',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

    public function getAllEmployeesDatas() {
        $employeesDatas = $this->M_employee->getAllEmployeesDatas();
        $datas = array(
            'data' => $employeesDatas
        );

        echo json_encode($datas);
    }

    public function addEmployee() {
        $validate = array(
            array(
                'field' => 'policyholderName',
                'label' => 'Name',
                'rules' => 'required',
                'errors' => array(
                    'required' => 'Employee should provide a %s.'
                )
            ),
            array(
                'field' => 'policyholderNIN',
                'label' => 'NIN',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Employee should provide a %s.',
                )
            ),
            array(
                'field' => 'policyholderEmail',
                'label' => 'Email',
                'rules' => 'required|trim|valid_email',
                'errors' => array(
                    'required' => 'Employee should provide a %s.',
                    'valid_email' => 'The %s field must contain a valid email address.'
                )
            ),
            array(
                'field' => 'policyholderPassword',
                'label' => 'Password',
                'rules' => 'required|trim|min_length[8]|max_length[20]|regex_match[/^(?=.*[A-Z])(?=.*\d).+$/]',
                'errors' => array(
                    'required' => 'You should provide a %s.',
                    'min_length' => '%s must be at least 8 characters in length.',
                    'max_length' => '%s max 20 characters in length.',
                    'regex_match' => '%s must contain at least one uppercase letter and one number.'
                )
            ),
            array(
                'field' => 'confirmPassword',
                'label' => 'Password Confirmation',
                'rules' => 'required|matches[policyholderPassword]',
                'errors' => array(
					'required' => 'You must provide a %s.',
					'matches' => '%s does not match the Password.'
				)
            )
        );
        $this->form_validation->set_rules($validate);

        if ($this->form_validation->run() == FALSE) {
            $errors = $this->form_validation->error_array();
            echo json_encode(array('status' => 'invalid', 'errors' => $errors));
        } else {
            $employeeData = array(
                'policyholderNIN' => $this->input->post('policyholderNIN'),
                'policyholderName' => $this->input->post('policyholderName'),
                'policyholderEmail' => $this->input->post('policyholderEmail'),
                'policyholderPassword' => $this->input->post('policyholderPassword'),
                'policyholderAddress' => $this->input->post('policyholderAddress'),
                'policyholderBirth' => $this->input->post('policyholderBirth'),
                'policyholderGender' => $this->input->post('policyholderGender'),
                'policyholderStatus' => $this->input->post('policyholderStatus')
            );

            $this->M_employee->insertEmployee($employeeData);
            echo json_encode(array('status' => 'success'));
        }
    }

    public function editEmployee() {
        $validate = array(
            array(
                'field' => 'policyholderName',
                'label' => 'Name',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Employee should provide a %s.'
                )
            ),
            array(
                'field' => 'policyholderEmail',
                'label' => 'Email',
                'rules' => 'required|trim|valid_email',
                'errors' => array(
                    'required' => 'Employee should provide a %s.',
                    'valid_email' => 'The %s field must contain a valid email address.'
                )
            ),
        );
        $this->form_validation->set_rules($validate);

        if ($this->form_validation->run() == FALSE) {
            $errors = $this->form_validation->error_array();
            echo json_encode(array('status' => 'invalid', 'errors' => $errors));
        } else {
            $policyholderNIN = $this->input->post('policyholderNIN');
            $employeeData = array(
                'policyholderName' => $this->input->post('policyholderName'),
                'policyholderEmail' => $this->input->post('policyholderEmail'),
                'policyholderAddress' => $this->input->post('policyholderAddress'),
                'policyholderBirth' => $this->input->post('policyholderBirth'),
                'policyholderGender' => $this->input->post('policyholderGender'),
                'policyholderStatus' => $this->input->post('policyholderStatus')
            );

            $this->M_employee->updateEmployee($policyholderNIN, $employeeData);
            echo json_encode(array('status' => 'success'));
        }
    }

    public function deleteEmployee() {
        $policyholderNIN = $this->input->post('policyholderNIN');
        $this->M_employee->deleteEmployee($policyholderNIN);

        echo json_encode(array('status' => 'success'));
    }
}

/* End of file Company.php */

?>