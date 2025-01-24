<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class AuthUser extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('M_auth');
    }

    public function index()
    {
        // Check Cookie
        $loginKey = $this->input->cookie('loginKey', TRUE) ?: FALSE;
        $keyReference = $this->input->cookie('keyReference', TRUE);

        if ($loginKey) {
            $employeeDatas = $this->M_auth->checkEmployee('employeeNIK', $keyReference);
            if ($loginKey === hash('sha256', $employeeDatas['employeeEmail'])) {
                $this->_setSession($employeeDatas, 'employee');
                redirect('user/profile');
            }

            $familyDatas = $this->M_auth->checkFamily('familyNIK', $keyReference);
            if ($loginKey === hash('sha256', $familyDatas['familyEmail'])) {
                $this->_setSession($familyDatas, 'family');
                redirect('user/profile');
            }
        }

        // Check Session
        if ($this->session->userdata('familyEmail')) {
            redirect('home');
        }

        $datas = array(
            'title' => 'BMMC | Sign In',
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
        $validate = array(
            array(
                'field' => 'userEmail',
                'label' => 'Email',
                'rules' => 'required|trim|valid_email',
                'errors' => array(
                    'required' => 'You should provide %s.',
                    'valid_email' => 'You must provide a valid %s.'
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
            $userEmail = htmlspecialchars($this->input->post('userEmail'));
            $userPassword = htmlspecialchars($this->input->post('userPassword'));
            $rememberMe = $this->input->post('rememberMe') ?: FALSE;

            $ch = curl_init('https://www.google.com/recaptcha/api/siteverify');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, [
                'secret' => $_ENV['CAPTCHA_SECRET_KEY'],
                'response' => $this->input->post('g-recaptcha-response')
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            $captchaResult = json_decode($response);

            if ($userDatas = $this->M_auth->checkEmployee('employeeEmail', $userEmail)) {
                $userType = 'employee';
            } else if ($userDatas = $this->M_auth->checkFamily('familyEmail', $userEmail)) {
                $userType = 'family';
            }

            $this->_login($userPassword, $userDatas, $userType, $captchaResult, $rememberMe);
        }
    }

    private function _login($userPassword, $userDatas, $userType, $captchaResult, $rememberMe = FALSE) {
        if (!$captchaResult->success) {
            $this->session->set_flashdata('flashdata', 'you are a robot');
            redirect('login');
        }

        if ($userType === "employee"){
            if (!empty($userDatas)) {
                if (password_verify($userPassword, $userDatas['employeePassword'])) {
                    if ($rememberMe) {
                        $this->input->set_cookie('loginKey', hash('sha256',$userDatas['employeeEmail']), 0);
                        $this->input->set_cookie('keyReference', $userDatas['employeeNIK'], 0);
                    }

                    if ($userDatas['employeeStatus'] == 'unverified') {
                        $this->M_auth->updateEmployee($userDatas['employeeNIK'], array('employeeStatus' => 'active'));
                    }
    
                    $this->_setSession($userDatas, $userType);
                    redirect('user/profile');
                } else {
                    $this->session->set_flashdata('flashdata', 'wrong password');
                    redirect('login');
                }
            } else {
                $this->session->set_flashdata('flashdata', 'not found');
                redirect('login');
            }
        } else {
            if (!empty($userDatas)) {
                if (password_verify($userPassword, $userDatas['familyPassword'])) {
                    if ($rememberMe) {
                        $this->input->set_cookie('loginKey', hash('sha256',$userDatas['familyEmail']), 0);
                        $this->input->set_cookie('keyReference', $userDatas['familyNIK'], 0);
                    }

                    if ($userDatas['familyStatus'] == 'unverified') {
                        $this->M_auth->updateFamily($userDatas['familyNIK'], array('familyStatus' => 'active'));
                    }

                    $this->_setSession($userDatas, $userType);
                    redirect('user/profile');
                } else {
                    $this->session->set_flashdata('flashdata', 'wrong password');
                    redirect('login');
                }
            } else {
                $this->session->set_flashdata('flashdata', 'not found');
                redirect('login');
            }
        }
    }

    private function _setSession($userDatas, $userType) {
        if ($userType == 'employee') {

            $sessionDatas = array(
                'userNIK' => $userDatas['employeeNIK'],
                'userName' => $userDatas['employeeName'],
                'userEmail' => $userDatas['employeeEmail'],
                'userAddress' => $userDatas['employeeAddress'],
                'userBirth' => $userDatas['employeeBirth'],
                'userGender' => $userDatas['employeeGender'],
                'userPassword' => $userDatas['employeePassword'],
                'userStatus' => $userDatas['employeeStatus'],
                'userPhoto' => $userDatas['employeePhoto'],
            );

        } else if ($userType == 'family') {

            $sessionDatas = array(
                'userNIK' => $userDatas['familyNIK'],
                'userName' => $userDatas['familyName'],
                'userEmail' => $userDatas['familyEmail'],
                'employeeNIK' => $userDatas['employeeNIK'],
                'userAddress' => $userDatas['familyAddress'],
                'userBirth' => $userDatas['familyBirth'],
                'userGender' => $userDatas['familyGender'],
                'userPassword' => $userDatas['familyPassword'],
                'userStatus' => $userDatas['familyStatus'],
                'userPhoto' => $userDatas['familyPhoto'],
            );

        }

        $sessionDatas['userType'] = $userType;
        $this->session->set_userdata($sessionDatas);
    }

    public function logoutUser() {
        delete_cookie('loginKey');
        delete_cookie('keyReference');

        $userType = $this->session->userdata('userType');
        $sessionDatas = array('userNIK', 'userName', 'userEmail', 'userAddress', 'userBirth', 'userGender', 'userPassword', 'userStatus');

        $userType == 'family'? $sessionDatas[]='employeeNIK' : '';

        $this->session->sess_destroy($sessionDatas);

        redirect('login');
    }

}

/* End of file AuthUser.php */

?>