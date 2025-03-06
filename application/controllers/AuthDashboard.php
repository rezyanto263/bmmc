<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class AuthDashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('M_auth');
    }

    public function index() {
        // Check Cookie
        $adminLoginKey = $this->input->cookie('adminLoginKey', TRUE);
        $adminKeyReference = $this->input->cookie('adminKeyReference', TRUE);
        if (!empty($adminLoginKey) && !empty($adminKeyReference)) {
            $adminDatas = $this->M_auth->checkAdmin('adminId', $adminKeyReference);
            if ($adminLoginKey === hash('sha256', $adminDatas['adminEmail'])) {
                $this->_initSession($adminDatas);
                $adminDatas['adminRole'] === 'admin' 
                    ? redirect('dashboard') 
                    : redirect($adminDatas['adminRole'] . '/dashboard');
            }
        }

        // Check Session
        if ($this->session->userdata('adminRole')) {
            $adminDatas['adminRole'] === 'admin' 
                ? redirect('dashboard') 
                : redirect($adminDatas['adminRole'] . '/dashboard');
        }

        $datas = array(
            'title' => 'BMMC Dashboard | Login',
            'contentType' => 'authentication'
        );

        $partials = array(
            'head' => 'partials/head',
            'content' => 'dashboard/login',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

    public function loginDashboard() {
        $validate = array(
            array(
                'field' => 'adminEmail',
                'label' => 'Email',
                'rules' => 'required|valid_email',
                'errors' => array(
                    'required' => 'You should provide an %s.',
                    'valid_email' => 'You must provide a valid %s.'
                )
            ),
            array(
                'field' => 'adminPassword',
                'label' => 'Password',
                'rules' => 'required|trim|min_length[8]|max_length[20]|regex_match[/^(?=.*[A-Z])(?=.*\d).+$/]',
                'errors' => array(
                    'required' => 'You should provide a %s.',
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
            $adminEmail = htmlspecialchars($this->input->post('adminEmail'));
            $adminPassword = htmlspecialchars($this->input->post('adminPassword'));
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

            $adminDatas = $this->M_auth->checkAdmin('adminEmail', $adminEmail);

            $this->_login($adminPassword, $adminDatas, $captchaResult, $rememberMe);
        }
    }

    private function _login($adminPassword, $adminDatas, $captchaResult, $rememberMe = FALSE) {
        if (!$captchaResult->success) {
            $this->session->set_flashdata('flashdata', 'you are a robot');
            redirect('dashboard/login');
        }

        if (!empty($adminDatas) && $adminDatas['status'] === 'discontinued') {
            $this->session->set_flashdata('flashdata', 'account discontinued');
            redirect('dashboard/login');
        }

        if (!empty($adminDatas) && !($adminDatas['adminRole'] !== 'admin' && $adminDatas['status'] == NULL)) {
            if (password_verify($adminPassword, $adminDatas['adminPassword'])) {
                if ($rememberMe) {
                    $this->input->set_cookie('adminLoginKey', hash('sha256', $adminDatas['adminEmail']), 0);
                    $this->input->set_cookie('adminKeyReference', $adminDatas['adminId'], 0);
                }

                if (($adminDatas['adminRole'] === 'company' || $adminDatas['adminRole'] === 'hospital') && $adminDatas['status'] == 'unverified') {
                    $this->M_auth->updateUnverifiedAdmin($adminDatas['adminId'], $adminDatas['adminRole'], array($adminDatas['adminRole'].'Status' => 'active'));
                }
    
                $this->_initSession($adminDatas);
                $adminRole = $this->session->userdata('adminRole');
                if ($adminRole == 'admin') {
                    redirect('dashboard');
                } elseif ($adminRole == 'company') {
                    redirect('company/dashboard');
                } elseif ($adminRole == 'hospital') {
                    redirect('hospital/dashboard');
                }
            } else {
                $this->session->set_flashdata('flashdata', 'wrong email or password');
                redirect('dashboard/login');
            }
        } else {
            $this->session->set_flashdata('flashdata', 'not found');
            redirect('dashboard/login');
        }
    }

    private function _initSession($adminDatas) {
        $sessionData = array(
            'adminId'    => $adminDatas['adminId'],
            'adminName'  => $adminDatas['adminName'],
            'adminEmail' => $adminDatas['adminEmail'],
            'adminRole'  => $adminDatas['adminRole']
        );
    
        if ($adminDatas['adminRole'] === 'company') {
            $this->load->model('M_companies');
            $companyData = $this->M_companies->getCompanyByAdminId($adminDatas['adminId']);
    
            $sessionData = array_merge($sessionData, array(
                'companyLogo'      => $companyData['companyLogo'] ? base_url('uploads/logos/' . $companyData['companyLogo']) : base_url('assets/images/company-placeholder.jpg'),
                'companyPhoto'     => $companyData['companyPhoto'] ? base_url('uploads/photos/' . $companyData['companyPhoto']) : base_url('assets/images/company-placeholder.jpg'),
                'companyId'        => $companyData['companyId'],
                'companyName'      => $companyData['companyName'],
                'companyPhone'     => $companyData['companyPhone'],
                'companyAddress'   => $companyData['companyAddress'],
                'companyStatus'    => $companyData['companyStatus'],
                'companyCoordinate'=> $companyData['companyCoordinate']
            ));
        } elseif ($adminDatas['adminRole'] === 'hospital') {
            $this->load->model('M_hospitals');
            $hospitalData = $this->M_hospitals->getHospitalByAdminId($adminDatas['adminId']);
    
            $sessionData = array_merge($sessionData, array(
                'hospitalLogo'      => $hospitalData['hospitalLogo'] ? base_url('uploads/logos/' . $hospitalData['hospitalLogo']) : base_url('assets/images/hospital-placeholder.jpg'),
                'hospitalPhoto'     => $hospitalData['hospitalPhoto'] ? base_url('uploads/photos/' . $hospitalData['hospitalPhoto']) : base_url('assets/images/hospital-placeholder.jpg'),
                'hospitalId'        => $hospitalData['hospitalId'],
                'hospitalName'      => $hospitalData['hospitalName'],
                'hospitalPhone'     => $hospitalData['hospitalPhone'],
                'hospitalAddress'   => $hospitalData['hospitalAddress'],
                'hospitalStatus'    => $hospitalData['hospitalStatus'],
                'hospitalCoordinate'=> $hospitalData['hospitalCoordinate']
            ));
        }
    
        $this->session->set_userdata($sessionData);
    }

    public function logoutDashboard() {
        delete_cookie('adminLoginKey');
        delete_cookie('adminKeyReference');

        $this->session->sess_destroy();

        redirect('dashboard/login');
    }

    public function forgotPasswordPage() {
        $datas = array(
            'title' => 'BMMC Dashboard | Forgot Password',
            'contentType' => 'authentication'
        );

        $partials = array(
            'head' => 'partials/head',
            'content' => 'dashboard/forgotpassword',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

    public function forgotPassword() {
        $validate = array(
            array(
                'field' => 'adminEmail',
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

            $adminEmail = htmlspecialchars($this->input->post('adminEmail'));
            $adminDatas = $this->M_auth->checkAdmin('adminEmail', $adminEmail);
            
            if (!empty($adminDatas)) {
                $this->load->library('sendemail');

                $token = base64_encode(random_bytes(16).'~'.date('d-m-Y H:i:s', strtotime('+1 days')));
                $datas = array(
                    'name' => $adminDatas['adminName'],
                    'url' => base_url('dashboard/resetpassword?token='. urlencode($token))
                );
                $subject = 'Reset Account Password';
                $body = $this->load->view('email/forgotPassEmail', $datas, TRUE);

                if (!$this->sendemail->send($adminEmail, $subject, $body)) {
                    $this->session->set_flashdata('flashdata', 'send email failed');
                    $this->session->set_flashdata('errorflashdata', "Sorry, we can't send you an email right now");
                    redirect('dashboard/forgotpassword');
                } else {
                    $this->M_auth->setAdminToken($adminDatas['adminEmail'], $token);
                    $this->session->set_flashdata('flashdata', 'forgot password');
                    redirect('dashboard/forgotpassword');
                }
            } else {
                $this->session->set_flashdata('flashdata', 'not found');
                redirect('dashboard/forgotpassword');
            }
        }
    }

    public function resetPasswordPage() {
        $adminToken = $this->input->get('token') ?: $this->session->userdata('resetPassToken');
        $adminDatas = $this->M_auth->checkAdmin('adminToken', $adminToken);

        if (!empty($adminDatas)) {
            $tokenData = explode('~', base64_decode($adminToken));
            if (strtotime($tokenData[1]) >= strtotime(date('d-m-Y H:i:s'))) {
                $this->session->set_userdata('resetPassToken', $adminToken);
                $datas = array(
                    'title' => 'BMMC Dashboard | Reset Password',
                    'adminEmail' => $adminDatas['adminEmail'],
                    'contentType' => 'authentication',
                );

                $partials = array(
                    'head' => 'partials/head',
                    'content' => 'dashboard/resetpassword',
                    'script' => 'partials/script'
                );
                $this->load->vars($datas);
                $this->load->view('master', $partials);
            } else {
                $this->session->set_flashdata('flashdata', 'token expired');
                redirect('dashboard/forgotpassword');
            }
        } else {
            $this->session->set_flashdata('flashdata', 'cannot use token');
            redirect('dashboard/forgotpassword');
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
            $adminToken = $this->session->userdata('resetPassToken');
            $adminPassword = password_hash($this->input->post('newPassword'), PASSWORD_DEFAULT);

            $this->M_auth->changeAdminPassword($adminToken, $adminPassword);
            $this->session->unset_userdata('resetPassToken');

            $this->session->set_flashdata('flashdata', 'reset password success');
            redirect('dashboard/login');
        }
    }

}

/* End of file AuthDashboard.php */

?>