<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class AuthUser extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('M_auth');
    }

    public function index() {
        // Check Cookie
        $loginKey = $this->input->cookie('loginKey', TRUE) ?: FALSE;
        $keyReference = $this->input->cookie('keyReference', TRUE);
        if (!empty($loginKey) && !empty($keyReference)) {
            $userDatas = $this->M_auth->checkUser('userNIK', $keyReference);
            if ($loginKey === hash('sha256', $userDatas['userEmail'])) {
                $this->_initSession($userDatas);
                redirect('profile');
            }
        }

        // Check Session
        if ($this->session->userdata('userEmail')) {
            redirect('profile');
        }

        $datas = array(
            'title' => 'BMMC | Login',
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

            $userDatas = $this->M_auth->checkUser('userEmail', $userEmail);

            $this->_login($userPassword, $userDatas, $captchaResult, $rememberMe);
        }
    }

    private function _login($userPassword, $userDatas, $captchaResult, $rememberMe = FALSE) {
        if (!$captchaResult->success) {
            $this->session->set_flashdata('flashdata', 'you are a robot');
            redirect('login');
        }

        if (empty($userDatas)) {
            $this->session->set_flashdata('flashdata', 'not found');
            redirect('login');
        }

        $this->load->model(['M_companies', 'M_insurances']);
        $companyId = $this->M_insurances->checkInsurance('insuranceId', $userDatas['insuranceId'])['companyId'];
        $companyStatus = $this->M_companies->getCompanyStatus($companyId);
        if (in_array($userDatas['userStatus'], ['discontinued', 'archived']) || $companyStatus === 'discontinued') {
            $this->session->set_flashdata('flashdata', 'account discontinued');
            redirect('login');
        }

        if (password_verify($userPassword, $userDatas['userPassword'])) {
            if ($rememberMe) {
                $this->input->set_cookie('loginKey', hash('sha256',$userDatas['userEmail']), 0);
                $this->input->set_cookie('keyReference', $userDatas['userNIK'], 0);
            }

            if ($userDatas['userStatus'] === 'unverified') {
                $this->M_auth->updateUnverifiedUser($userDatas['userNIK'], $userDatas['userRole'], 'active');
                $userDatas['userStatus'] = 'active';
            }

            $this->_initSession($userDatas);
            redirect('profile');
        } else {
            $this->session->set_flashdata('flashdata', 'wrong email or password');
            redirect('login');
        }
    }

    private function _initSession($userDatas) {
        $sessionDatas = array(
            'employeeNIK' => $userDatas['employeeNIK'],
            'insuranceId' => $userDatas['insuranceId'],
            'userNIK' => $userDatas['userNIK'],
            'userPhoto' => $userDatas['userPhoto'],
            'userName' => $userDatas['userName'],
            'userEmail' => $userDatas['userEmail'],
            'userPhone' => $userDatas['userPhone'],
            'userBirth' => $userDatas['userBirth'],
            'userGender' => $userDatas['userGender'],
            'userDepartment' => $userDatas['userDepartment'],
            'userBand' => $userDatas['userBand'],
            'userRelationship' => $userDatas['userRelationship'],
            'userRole' => $userDatas['userRole'],
            'userStatus' => $userDatas['userStatus'],
            'userAddress' => $userDatas['userAddress'],
        );

        $this->session->set_userdata($sessionDatas);
    }

    public function logoutUser() {
        delete_cookie('loginKey');
        delete_cookie('keyReference');

        $this->session->sess_destroy();

        redirect('');
    }

    public function forgotPasswordPage() {
        $datas = array(
            'title' => 'BMMC | Forgot Password',
            'contentType' => 'authentication'
        );

        $partials = array(
            'head' => 'partials/head',
            'content' => 'user/forgotpassword',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

    public function forgotPassword() {
        $validate = array(
            array(
                'field' => 'userEmail',
                'label' => 'Email',
                'rules' => 'required|valid_email',
                'errors' => array(
                    'required' => 'You should provide an %s.',
                    'valid_email' => 'You must provide a valid %s.'
                )
            )
        );
        $this->form_validation->set_rules($validate);
        
        if ($this->form_validation->run() == FALSE) {
            $this->forgotPasswordPage();
        } else {

            $userEmail = htmlspecialchars($this->input->post('userEmail'));
            $userDatas = $this->M_auth->checkUser('userEmail', $userEmail);
            
            if (!empty($userDatas)) {
                $this->load->library('sendemail');

                $token = base64_encode(random_bytes(16).'~'.date('d-m-Y H:i:s', strtotime('+1 days')));
                $datas = array(
                    'name' => $userDatas['userName'],
                    'url' => base_url('resetpassword?token='. urlencode($token))
                );
                $subject = 'Reset Account Password';
                $body = $this->load->view('email/forgotPassEmail', $datas, TRUE);

                if (!$this->sendemail->send($userEmail, $subject, $body)) {
                    $this->session->set_flashdata('flashdata', 'send email failed');
                    $this->session->set_flashdata('errorflashdata', "Sorry, we can't send you an email right now");
                    redirect('forgotpassword');
                } else {
                    $this->M_auth->setUserToken($userDatas['userEmail'], $userDatas['userRole'], $token);
                    $this->session->set_flashdata('flashdata', 'forgot password');
                    redirect('forgotpassword');
                }
            } else {
                $this->session->set_flashdata('flashdata', 'not found');
                redirect('forgotpassword');
            }
        }
    }

    public function resetPasswordPage() {
        $userToken = $this->input->get('token') ?: $this->session->userdata('resetPassToken');
        $userDatas = $this->M_auth->checkUser('userToken', $userToken);

        if (!empty($userDatas)) {
            $tokenData = explode('~', base64_decode($userToken));
            if (strtotime($tokenData[1]) >= strtotime(date('d-m-Y H:i:s'))) {
                $this->session->set_userdata('resetPassToken', $userToken);
                $datas = array(
                    'title' => 'BMMC | Reset Password',
                    'userEmail' => $userDatas['userEmail'],
                    'contentType' => 'authentication',
                );

                $partials = array(
                    'head' => 'partials/head',
                    'content' => 'user/resetpassword',
                    'script' => 'partials/script'
                );
                $this->load->vars($datas);
                $this->load->view('master', $partials);
            } else {
                $this->session->set_flashdata('flashdata', 'token expired');
                redirect('forgotpassword');
            }
        } else {
            $this->session->set_flashdata('flashdata', 'cannot use token');
            redirect('forgotpassword');
        }
    }

    public function resetPassword() {
        $validate = array(
            array(
                'field' => 'newPassword',
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
                'rules' => 'required|matches[newPassword]',
                'errors' => array(
					'required' => 'You must provide a %s.',
					'matches' => '%s does not match the Password.'
				)
            )
        );
        $this->form_validation->set_rules($validate);

        if ($this->form_validation->run() == FALSE) {
            $this->resetPasswordPage();
        } else {
            $userToken = $this->session->userdata('resetPassToken');
            $userPassword = password_hash($this->input->post('newPassword'), PASSWORD_DEFAULT);

            $this->M_auth->changeUserPassword($userToken, $userPassword);
            $this->session->unset_userdata('resetPassToken');

            $this->session->set_flashdata('flashdata', 'reset password success');
            redirect('login');
        }
    }

}

/* End of file AuthUser.php */

?>