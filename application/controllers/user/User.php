<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        // Check if the user is logged in by verifying session data
        if ($this->session->userdata('userType') != 'employee' && $this->session->userdata('userType') != 'family') {
            redirect('login');
        }

        $this->load->model('M_auth');
    }
    

    public function index()
    {
        // Retrieve the logged-in employee's data from session
        $userType = $this->session->userdata('userType');
        if ($userType == 'employee') {
            // Use session data for the logged-in employee
            $employeeId = $this->session->userdata('userNIK');
            $employeeDatas = $this->M_auth->getEmployeeDataById($employeeId);
            $familyMembers = $this->M_auth->getFamilyMembersByEmployee($employeeId);
        } else {
            // Assuming you are also retrieving family data if logged in as family
            $familyId = $this->session->userdata('userNIK');
            $employeeDatas = $this->M_auth->getFamilyDataById($familyId);
            $familyMembers = null;
        }

        // Pass employee data to view
        $datas = array(
            'title' => 'BIM | User',
            'subtitle' => 'User',
            'contentType' => 'profile',
            'employeeDatas' => $employeeDatas, // Send data to the view
            'familyMembers' => $familyMembers
        );

        $partials = array(
            'head' => 'partials/head',
            'navbar' => 'partials/user/navbar',
            'content' => 'user/Profile', // You can access employeeData here
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

    public function editEmployee() {
        $validate = array(
            array(
                'field' => 'employeeName',
                'label' => 'Name',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Employee should provide a %s.'
                )
            ),
            array(
                'field' => 'employeeEmail',
                'label' => 'Email',
                'rules' => 'required|trim|valid_email',
                'errors' => array(
                    'required' => 'Employee should provide a %s.',
                    'valid_email' => 'The %s field must contain a valid email address.'
                )
            ),
            array(
                'field' => 'employeeEmail',
                'label' => 'Email',
                'rules' => 'required|trim|valid_email',
                'errors' => array(
                    'required' => 'Employee should provide a %s.',
                    'valid_email' => 'The %s field must contain a valid email address.'
                )
            ),
            array(
                'field' => 'newPassword',
                'label' => 'Password',
                'rules' => 'trim|min_length[8]|max_length[20]|regex_match[/^(?=.*[A-Z])(?=.*\d).+$/]',
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
                'rules' => 'trim|matches[newPassword]',
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
            $employeeNIK = $this->input->post('employeeNIK');
            $password = $this->input->post('employeePassword');
            $newPassword = htmlspecialchars($this->input->post('newPassword'));
            $gender = $this->input->post('employeeGender');
            $employeeData = array(
                'employeeNIK' => $this->input->post('employeeNIK'),
                'employeeName' => $this->input->post('employeeName'),
                'employeeEmail' => $this->input->post('employeeEmail'),
                'employeeAddress' => $this->input->post('employeeAddress'),
                'employeeBirth' => $this->input->post('employeeBirth'),
            );
            !empty($newPassword)? $employeeData['employeePassword'] = $newPassword : '';
            !empty($gender)? $employeeData['employeeGender'] = $gender : '';
            $this->M_auth->updateEmployee($employeeNIK, $employeeData);
            redirect('profile');
        }
    }

    public function editFamily() {
        $validate = array(
            array(
                'field' => 'employeeName',
                'label' => 'Name',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Family should provide a %s.'
                )
            ),
            array(
                'field' => 'employeeEmail',
                'label' => 'Email',
                'rules' => 'required|trim|valid_email',
                'errors' => array(
                    'required' => 'Family should provide a %s.',
                    'valid_email' => 'The %s field must contain a valid email address.'
                )
            ),
            array(
                'field' => 'newPassword',
                'label' => 'Password',
                'rules' => 'trim|min_length[8]|max_length[20]|regex_match[/^(?=.*[A-Z])(?=.*\d).+$/]',
                'errors' => array(
                    'min_length' => '%s must be at least 8 characters in length.',
                    'max_length' => '%s max 20 characters in length.',
                    'regex_match' => '%s must contain at least one uppercase letter and one number.'
                )
            ),
            array(
                'field' => 'confirmPassword',
                'label' => 'Password Confirmation',
                'rules' => 'trim|matches[newPassword]',
                'errors' => array(
                    'matches' => '%s does not match the Password.'
                )
            )
        );
    
        $this->form_validation->set_rules($validate);
    
        if ($this->form_validation->run() == FALSE) {
            $errors = $this->form_validation->error_array();
            echo json_encode(array('status' => 'invalid', 'errors' => $errors));
            return;
        }
    
        $familyNIK = $this->input->post('familyNIK', TRUE);
        $newPassword = $this->input->post('newPassword', TRUE);
        $gender = $this->input->post('employeeGender');
        // Data utama keluarga
        $familyData = array(
            'familyNIK' => $this->input->post('familyNIK', TRUE),
            'familyName' => htmlspecialchars($this->input->post('employeeName')),
            'familyEmail' => htmlspecialchars($this->input->post('employeeEmail')),
            'familyAddress' => htmlspecialchars($this->input->post('employeeAddress')),
            'familyBirth' => $this->input->post('employeeBirth', TRUE),
        );
    
        // Enkripsi password jika ada perubahan
        if (!empty($newPassword)) {
            $familyData['familyPassword'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }
        !empty($gender)? $familyData['familyGender'] = $gender : '';
    
        // Perbarui data keluarga
        $this->M_auth->updateFamily($familyNIK, $familyData);
    
        // Redirect ke halaman profil
        redirect('profile');
    }
    
}

/* End of file User.php */
?>
