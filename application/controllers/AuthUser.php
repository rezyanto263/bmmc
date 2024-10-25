<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class AuthUser extends CI_Controller {

    public function index()
    {
        // Check Cookie
        $loginKey = $this->input->cookie('loginKey', TRUE) ?: FALSE;
        $keyReference = $this->input->cookie('keyReference', TRUE);

        if ($loginKey) {
            $policyholderDatas = $this->M_auth->checkPolicyHolder('policyholderId', $keyReference);
            if ($loginKey === hash('sha256', $policyholderDatas['policyholderNIN'])) {
                $this->_setSession($policyholderDatas, 'policyholder');
                redirect('home');
            }

            $familyDatas = $this->M_auth->checkFamily('policyholderId', $keyReference);
            if ($loginKey === hash('sha256', $familyDatas['familyNIN'])) {
                $this->_setSession($familyDatas, 'family');
                redirect('home');
            }
        }

        // Check Session
        if ($this->session->userdata('familyNIN')) {
            redirect('home');
        }

        $datas = array(
            'title' => 'BIM | Sign In',
            'contentType' => 'authentication'
        );

        $partials = array(
            'head' => 'partials/head',
            'content' => 'user/login',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

    public function loginUser() {
        $userNIN = htmlspecialchars($this->input->post('userNIN'));
        $userPassword = $this->input->post('userPassword');
        $rememberMe = $this->input->post('rememberMe') ?: FALSE;

        if ($userDatas = $this->M_auth->checkPolicyHolder('policyholderNIN', $policyholderNIN)) {
            $userType = 'policyholder';
        } else if ($userDatas = $this->M_auth->checkFamily('familyNIN', $familyNIN)) {
            $userType = 'family';
        }

        $validate = array(
            array(
                'field' => 'userNIN',
                'label' => 'NIN/NIK',
                'rules' => 'required|trim|numeric|min_length[16]|max_length[16]',
                'errors' => array(
                    'required' => 'You should provide %s.',
                    'min_length' => '%s must be at least 16 characters in length.',
                    'max_length' => '%s max 16 characters in length.'
                )
            ),
            array(
                'field' => 'userPassword',
                'label' => 'Password',
                'rules' => 'required|trim|min_length[8]|max_length[20]|regex_match[/^(?=.*[A-Z])(?=.*\d).+$/]',
                'errors' => array(
                    'required' => 'You should provide %s.',
                    'min_length' => '%s must be at least 8 characters in length.',
                    'max_length' => '%s max 20 characters in length.',
                    'regex_match' => '%s must contain at least one uppercase letter and one number.'
                )
            )
        );
        $this->form_validation->set_rules($validate);

        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            $this->_login($userPassword, $userDatas, $userType, $rememberMe);
        }
    }

    private function _login($userPassword, $userDatas, $userType, $rememberMe = FALSE) {
        if (!empty($userDatas)) {
            if (password_verify($userPassword, $userDatas['userPassword'])) {
                if ($rememberMe) {
                    $this->input->set_cookie('loginKey', hash('sha256',$userDatas['userNIN']), 0);
                    $this->input->set_cookie('keyReference', $userDatas['policyholderId'], 0);
                }

                $this->_setSession($userDatas, $userType);
                redirect('home');
            } else {
                $this->session->set_flashdata('flashdata', 'wrong password');
                redirect('login');
            }
        } else {
            $this->session->set_flashdata('flashdata', 'not found');
            redirect('login');
        }
    }

    private function _setSession($userDatas, $userType) {
        if ($userType == 'policyholder') {

            $sessionDatas = array(
                'userNIN' => $userDatas['policyholderNIN'],
                'userName' => $userDatas['policyholderName'],
                'userAddress' => $userDatas['policyholderAddress'],
                'userBirth' => $userDatas['policyholderBirth'],
                'userGender' => $userDatas['policyholderGender'],
                'userPassword' => $userDatas['policyholderPassword'],
                'userStatus' => $userDatas['policyholderStatus'],
            );

        } else if ($userType == 'family') {

            $sessionDatas = array(
                'userNIN' => $userDatas['familyNIN'],
                'userName' => $userDatas['familyName'],
                'policyholderId' => $userDatas['policyholderId'],
                'userAddress' => $userDatas['familyAddress'],
                'userBirth' => $userDatas['familyBirth'],
                'userGender' => $userDatas['familyGender'],
                'userPassword' => $userDatas['familyPassword'],
                'userStatus' => $userDatas['familyStatus'],
            );

        }

        $sessionDatas['userType'] = $userType;
        $this->session->set_userdata($sessionDatas);
    }

    public function logoutUser() {
        delete_cookie('loginKey');
        delete_cookie('keyReference');

        $userType = $this->session->userdata('userType');
        $sessionDatas = array('userNIN', 'userName', 'userAddress', 'userBirth', 'userGender', 'userPassword', 'userStatus');

        $userType == 'family'? $sessionDatas[]='policyholderId' : '';

        $this->session->sess_destroy($sessionDatas);

        redirect('login');
    }

}

/* End of file AuthUser.php */

?>