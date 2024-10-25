<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\OAuth;
use PHPMailer\PHPMailer\Exception;
use League\OAuth2\Client\Provider\Google;

class AuthDashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('M_auth');
    }

    public function index()
    {
        // Check Cookie
        $adminLoginKey = $this->input->cookie('adminLoginKey', TRUE);
        $adminKeyReference = $this->input->cookie('adminKeyReference', TRUE);
        if ($adminLoginKey) {
            $adminDatas = $this->M_auth->checkAdmin('adminId', $adminKeyReference);
            if ($adminLoginKey === hash('sha256', $adminDatas['adminEmail'])) {
                $sessionDatas = array(
                    'adminName' => $adminDatas['adminName'],
                    'adminEmail' => $adminDatas['adminEmail'],
                    'adminPassword' => $adminDatas['adminPassword'],
                    'adminRole' => $adminDatas['adminRole']
                );
                $this->session->set_userdata($sessionDatas);

                redirect('dashboard');
            }
        }

        // Check Session
        if ($this->session->userdata('adminRole')) {
            redirect('dashboard');
        }

        $datas = array(
            'title' => 'BIM Dashboard | Login',
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

            $adminDatas = $this->M_auth->checkAdmin('adminEmail', $adminEmail);

            $this->_login($adminPassword, $adminDatas, $rememberMe);
        }
    }

    private function _login($adminPassword, $adminDatas, $rememberMe = FALSE) {
        if (!empty($adminDatas)) {
            if (password_verify($adminPassword, $adminDatas['adminPassword'])) {
                if ($rememberMe) {
                    $this->input->set_cookie('adminLoginKey', hash('sha256',$adminDatas['adminEmail']), 0);
                    $this->input->set_cookie('adminKeyReference', $adminDatas['adminId'], 0);
                }

                $sessionDatas = array(
                    'adminName' => $adminDatas['adminName'],
                    'adminEmail' => $adminDatas['adminEmail'],
                    'adminPassword' => $adminDatas['adminPassword'],
                    'adminRole' => $adminDatas['adminRole']
                );
                $this->session->set_userdata($sessionDatas);

                redirect('dashboard');
            } else {
                $this->session->set_flashdata('flashdata', 'wrong password');
                redirect('dashboard/login');
            }
        } else {
            $this->session->set_flashdata('flashdata', 'not found');
            redirect('dashboard/login');
        }
    }

    public function logoutDashboard() {
        delete_cookie('adminLoginKey');
        delete_cookie('adminKeyReference');

        $sessionDatas = array('adminName', 'adminEmail', 'adminPassword', 'adminRole');
        $this->session->unset_userdata($sessionDatas);

        redirect('dashboard/login');
    }

    public function forgotPasswordPage() {
        $datas = array(
            'title' => 'BIM Dashboard | Forgot Password',
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
                $datas = array(
                    'name' => $adminDatas['adminName'],
                    'token' => base64_encode(random_bytes(16).'~'.date('d-m-Y H:i:s', strtotime('+1 days')))
                );

                $mail = new PHPMailer();

                $mail->isSMTP();

                //Enable SMTP debugging
                //SMTP::DEBUG_OFF = off (for production use)
                //SMTP::DEBUG_CLIENT = client messages
                //SMTP::DEBUG_SERVER = client and server messages
                $mail->SMTPDebug = SMTP::DEBUG_OFF;
                $mail->Host = 'smtp.gmail.com';
                $mail->Port = 465;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->SMTPAuth = true;
                $mail->AuthType = 'XOAUTH2';

                $clientId = $_ENV['CLIENT_ID'];
                $clientSecret = $_ENV['CLIENT_SECRET'];
                $refreshToken = $_ENV['REFRESH_TOKEN'];

                $provider = new Google(
                    [
                        'clientId' => $clientId,
                        'clientSecret' => $clientSecret,
                    ]
                );

                $mail->setOAuth(
                    new OAuth(
                        [
                            'provider' => $provider,
                            'clientId' => $clientId,
                            'clientSecret' => $clientSecret,
                            'refreshToken' => $refreshToken,
                            'userName' => $_ENV['SMTP_USER'],
                        ]
                    )
                );

                $mail->isHTML(true);
                $mail->setFrom($_ENV['SMTP_USER'], 'Bali Inti Medika');
                $mail->addAddress($adminEmail);
                $mail->Subject = 'Reset Account Password';
                $mail->CharSet = PHPMailer::CHARSET_UTF8;
                $mail->Body = $this->load->view('dashboard/forgotPassEmail', $datas, TRUE);

                if (!$mail->send()) {
                    $this->session->set_flashdata('flashdata', 'send email failed');
                    $this->session->set_flashdata('errorflashdata', $mail->ErrorInfo);
                    redirect('dashboard/forgotpassword');
                } else {
                    $this->M_auth->setAdminToken($adminDatas['adminEmail'], $datas['token']);
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
                    'title' => 'BIM Dashboard | Reset Password',
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

            $this->session->set_flashdata('flashdata', 'reset password success');
            redirect('dashboard/login');
        }
    }

}

/* End of file AuthDashboard.php */

?>