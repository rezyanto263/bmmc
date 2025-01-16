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
            $employeeDatas = $this->M_auth->checkEmployee('employeeId', $keyReference);
            if ($loginKey === hash('sha256', $employeeDatas['employeeNIK'])) {
                $this->_setSession($employeeDatas, 'employee');
                redirect('user/profile');
            }

            $familyDatas = $this->M_auth->checkFamily('employeeId', $keyReference);
            if ($loginKey === hash('sha256', $familyDatas['familyNIK'])) {
                $this->_setSession($familyDatas, 'family');
                redirect('user/profile');
            }
        }

        // Check Session
        if ($this->session->userdata('familyNIK')) {
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
        $userNIK = htmlspecialchars($this->input->post('userNIK'));
        $userPassword = $this->input->post('userPassword');
        $rememberMe = $this->input->post('rememberMe') ?: FALSE;
        // $userDatas = $this->M_auth->checkEmployee('employeeNIK', $userNIK);
        // var_dump($userDatas);
        // die();
        if ($userDatas = $this->M_auth->checkEmployee('employeeNIK', $userNIK)) {
            $userType = 'employee';
        } else if ($userDatas = $this->M_auth->checkFamily('familyNIK', $userNIK)) {
            $userType = 'family';
        }
        
        $validate = array(
            array(
                'field' => 'userNIK',
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
        // var_dump($userDatas);
        // die();
        if ($userType === "employee"){
            if (!empty($userDatas)) {
                if (password_verify($userPassword, $userDatas['employeePassword'])) {
                    if ($rememberMe) {
                        $this->input->set_cookie('loginKey', hash('sha256',$userDatas['userNIK']), 0);
                        $this->input->set_cookie('keyReference', $userDatas['employeeId'], 0);
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
                        $this->input->set_cookie('loginKey', hash('sha256',$userDatas['userNIK']), 0);
                        $this->input->set_cookie('keyReference', $userDatas['employeeId'], 0);
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

    // private function _loginFamily($userPassword, $familyDatas, $userType, $rememberMe = FALSE) {
    //     // var_dump($userDatas);
    //     // die();

    //     if (!empty($familyDatas)) {
    //         if (password_verify($userPassword, $familyDatas['familyPassword'])) {
    //             if ($rememberMe) {
    //                 $this->input->set_cookie('loginKey', hash('sha256',$familyDatas['userNIK']), 0);
    //                 $this->input->set_cookie('keyReference', $familyDatas['employeeId'], 0);
    //             }

    //             $this->_setSession($familyDatas, $userType);
    //             redirect('profile');
    //         } else {
    //             $this->session->set_flashdata('flashdata', 'wrong password');
    //             redirect('login');
    //         }
    //     } else {
    //         $this->session->set_flashdata('flashdata', 'not found');
    //         redirect('login');
    //     }
    // }

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

        $userType == 'family'? $sessionDatas[]='employeeId' : '';

        $this->session->sess_destroy($sessionDatas);

        redirect('login');
    }

}

/* End of file AuthUser.php */

?>