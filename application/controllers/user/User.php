<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        // Check if the user is logged in by verifying session data
        if ($this->session->userdata('userType') != 'policyholder' && $this->session->userdata('userType') != 'family') {
            redirect('login');
        }

        $this->load->model('M_auth');
    }
    

    public function index()
    {
        // Retrieve the logged-in policyholder's data from session
        $userType = $this->session->userdata('userType');
        if ($userType == 'policyholder') {
            // Use session data for the logged-in policyholder
            $policyholderId = $this->session->userdata('userNIN');
            $policyholderDatas = $this->M_auth->getPolicyHolderDataById($policyholderId);
            $familyMembers = $this->M_auth->getFamilyMembersByPolicyHolder($policyholderId);
        } else {
            // Assuming you are also retrieving family data if logged in as family
            $familyId = $this->session->userdata('userNIN');
            $policyholderDatas = $this->M_auth->getFamilyDataById($familyId);
            $familyMembers = null;
        }

        // Pass policyholder data to view
        $datas = array(
            'title' => 'BIM | User',
            'subtitle' => 'User',
            'contentType' => 'profile',
            'policyholderDatas' => $policyholderDatas, // Send data to the view
            'familyMembers' => $familyMembers
        );

        $partials = array(
            'head' => 'partials/head',
            'navbar' => 'partials/user/navbar',
            'content' => 'user/userPage', // You can access policyholderData here
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
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
            $policyholderNIN = $this->input->post('policyholderNIN');
            $password = $this->input->post('policyholderPassword');
            $newPassword = htmlspecialchars($this->input->post('newPassword'));
            $gender = $this->input->post('policyholderGender');
            $employeeData = array(
                'policyholderNIN' => $this->input->post('policyholderNIN'),
                'policyholderName' => $this->input->post('policyholderName'),
                'policyholderEmail' => $this->input->post('policyholderEmail'),
                'policyholderAddress' => $this->input->post('policyholderAddress'),
                'policyholderBirth' => $this->input->post('policyholderBirth'),
            );
            !empty($newPassword)? $employeeData['policyholderPassword'] = $newPassword : '';
            !empty($gender)? $employeeData['policyholderGender'] = $gender : '';
            $this->M_auth->updateEmployee($policyholderNIN, $employeeData);
            redirect('profile');
        }
    }

    public function editFamily() {
        $validate = array(
            array(
                'field' => 'policyholderName',
                'label' => 'Name',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Family should provide a %s.'
                )
            ),
            array(
                'field' => 'policyholderEmail',
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
    
        $familyNIN = $this->input->post('familyNIN', TRUE);
        $newPassword = $this->input->post('newPassword', TRUE);
        $gender = $this->input->post('policyholderGender');
        // Data utama keluarga
        $familyData = array(
            'familyNIN' => $this->input->post('familyNIN', TRUE),
            'familyName' => htmlspecialchars($this->input->post('policyholderName')),
            'familyEmail' => htmlspecialchars($this->input->post('policyholderEmail')),
            'familyAddress' => htmlspecialchars($this->input->post('policyholderAddress')),
            'familyBirth' => $this->input->post('policyholderBirth', TRUE),
        );
    
        // Enkripsi password jika ada perubahan
        if (!empty($newPassword)) {
            $familyData['familyPassword'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }
        !empty($gender)? $familyData['familyGender'] = $gender : '';
    
        // Perbarui data keluarga
        $this->M_auth->updateFamily($familyNIN, $familyData);
    
        // Redirect ke halaman profil
        redirect('profile');
    }
    
}

/* End of file User.php */
?>
