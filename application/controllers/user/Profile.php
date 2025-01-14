<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {    

    public function __construct()
    {
        parent::__construct();
        
        // Check if the user is logged in by verifying session data
        if ($this->session->userdata('userType') != 'policyholder' && $this->session->userdata('userType') != 'family') {
            redirect('login');
        }

        $this->load->model('M_auth');
        $this->load->model('M_historyhealth');
    }

    public function index()
    {
        $userType = $this->session->userdata('userType');
        if ($userType == 'policyholder') {
            // Use session data for the logged-in policyholder
            $policyholderId = $this->session->userdata('userNIK');
            $policyholderDatas = $this->M_auth->getPolicyHolderDataById($policyholderId);
            $familyMembers = $this->M_auth->getFamilyMembersByPolicyHolder($policyholderId);
        } else {
            // Assuming you are also retrieving family data if logged in as family
            $familyId = $this->session->userdata('userNIK');
            $policyholderDatas = $this->M_auth->getFamilyDataById($familyId);
            $familyMembers = null;
        }

        $datas = array(
            'title' => 'BIM | User',
            'subtitle' => 'Profile',
            'contentType' => 'user',
            'policyholderDatas' => $policyholderDatas, // Send data to the view
            'familyMembers' => $familyMembers
        );

        $partials = array(
            'head' => 'partials/head',
            'navbar' => 'partials/user/navbar',
            'footer' => 'partials/user/footer',
            'content' => 'user/Profile',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

    public function getUserHistories() {
        $userDatas = $this->M_auth->checkPolicyHolder('policyholderNIK', $this->session->userdata('userNIK'));
        if (!$userDatas) {
            $familyDatas = $this->M_auth->checkFamily('familyNIK', $this->session->userdata('userNIK'));
        }
        if (!$userDatas['familyNIK']) {
            var_dump($userDatas);
            exit;
        }
        var_dump('test');
        exit;
        $hospitalDatas = $this->M_hospitals->checkHospital('adminId', $adminDatas['adminId']);

        if ($hospitalDatas) {
            $hisealthtalsDatas = $this->M_historyhealth->getHospitalHisealthtalsDatas('hospitalId', $hospitalDatas['hospitalId']);
            $historyhealthIds = array_column($hisealthtalsDatas, 'historyhealthId');
        
            if ($historyhealthIds) {
                $historiesDatas = $this->M_historyhealth->getHospitalHistoriesDatas($historyhealthIds);
                $datas = array(
                    'data' => $historiesDatas,
                );
                echo json_encode($datas);
            } else {
                echo json_encode(['data' => []]);
            }
        } else {
            echo json_encode(['data' => []]);
        }
    }

    public function editEmployee() {
        // Validation rules
        $validate = array(
            array(
                'field' => 'policyholderEmail',
                'label' => 'Email',
                'rules' => 'required|trim|valid_email',
                'errors' => array(
                    'required' => 'You should provide a %s.',
                    'valid_email' => 'The %s field must contain a valid email address.'
                )
            ),
            array(
                'field' => 'oldPassword',
                'label' => 'Old Password',
                'rules' => 'trim', // Not required, only checked if newPassword is provided
                'errors' => array(
                    'required' => '%s is required to proceed with the update.'
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
        
        // Check if validation fails
        if ($this->form_validation->run() == FALSE) {
            // Return errors if validation fails
            $errors = $this->form_validation->error_array();
            echo json_encode(array('status' => 'invalid', 'errors' => $errors));
        } else {
            // Get the logged-in user's NIK from the session
            $policyholderNIK = $this->input->post('policyholderNIK');
            $oldPassword = htmlspecialchars($this->input->post('oldPassword'));
            $newPassword = htmlspecialchars($this->input->post('newPassword'));
            $newEmail = $this->input->post('policyholderEmail');
        
            // If new password is provided, verify the old password
            if (!empty($newPassword)) {
                // Fetch the current password hash from the database (use the policyholderNIK to fetch the correct record)
                $currentPasswordHash = $this->M_auth->getCurrentPasswordByNIK($policyholderNIK);
                
                // Verify if the old password matches the current password
                if (!password_verify($oldPassword, $currentPasswordHash)) {
                    echo json_encode(array('status' => 'invalid', 'errors' => array('oldPassword' => 'The old password is incorrect.')));
                    return;
                }
            }
        
            // Prepare employee data for updating
            $employeeData = array(
                'policyholderEmail' => $newEmail,
            );
        
            // Update the password if a new password is provided
            if (!empty($newPassword)) {
                // Hash the new password before saving
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $employeeData['policyholderPassword'] = $hashedPassword;
            }
        
            // Call model function to update the employee data (email and password)
            $updateResult = $this->M_auth->updateEmployee($policyholderNIK, $employeeData);
        
            // Check if update was successful
            if ($updateResult) {
                // Update session data for the logged-in user
                $this->session->set_userdata('userEmail', $newEmail);
        
                // Respond with success
                echo json_encode(array('status' => 'success'));
            } else {
                // Respond with failure if update fails
                echo json_encode(array('status' => 'error', 'message' => 'Failed to update profile.'));
            }
        }
    }    

    public function editFamily() {
        $validate = array(
            array(
                'field' => 'familyEmail',
                'label' => 'Email',
                'rules' => 'required|trim|valid_email',
                'errors' => array(
                    'required' => 'Employee should provide a %s.',
                    'valid_email' => 'The %s field must contain a valid email address.'
                )
            ),
            array(
                'field' => 'familyEmail',
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
            $familyNIK = $this->input->post('familyNIK');
            $password = $this->input->post('familyPassword');
            $newPassword = htmlspecialchars($this->input->post('newPassword'));
            $employeeData = array(
                'familyNIK' => $this->input->post('familyNIK'),
                'familyEmail' => $this->input->post('familyEmail'),
            );
            !empty($newPassword)? $employeeData['familyPassword'] = $newPassword : '';

            $this->M_auth->updateFamilyPassword($familyNIK, $employeeData);
            echo json_encode(array('status' => 'success'));
        }
    }

}

/* End of file Company.php */

?>