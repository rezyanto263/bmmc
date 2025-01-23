<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Admins extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('adminRole') != 'admin') {
            redirect('dashboard');
        }

        $this->load->model('M_admins');
    }
    

    public function index()
    {
        $datas = array(
            'title' => 'BIM Dashboard | Admins',
            'subtitle' => 'Admins',
            'contentType' => 'dashboard',
        );

        $partials = array(
            'head' => 'partials/head',
            'sidebar' => 'partials/dashboard/sidebar',
            'floatingMenu' => 'partials/floatingMenu',
            'contentHeader' => 'partials/contentHeader',
            'contentBody' => 'dashboard/admins',
            'footer' => 'partials/dashboard/footer',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

    public function test()
    {
        $datas = array(
            'title' => 'BIM Dashboard | Admins',
            'subtitle' => 'Admins',
            'contentType' => 'dashboard',
        );

        $partials = array(
            'head' => 'partials/head',
            'sidebar' => 'partials/dashboard/sidebar',
            'floatingMenu' => 'partials/dashboard/floatingMenu',
            'contentHeader' => 'partials/dashboard/contentHeader',
            'contentBody' => 'dashboard/admins',
            'footer' => 'partials/dashboard/footer',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

    public function getAllAdminsDatas() {
        $adminsDatas = $this->M_admins->getAllAdminsDatas();
        $datas = array(
            'data' => $adminsDatas
        );

        echo json_encode($datas);
    }

    public function getAllUnconnectedHospitalAdminsDatas() {
        $adminDatas = $this->M_admins->getAllUnconnectedHospitalAdminsDatas();
        $datas = array(
            'data' => $adminDatas
        );

        echo json_encode($datas);
    }

    public function getAllUnconnectedCompanyAdminsDatas() {
        $adminDatas = $this->M_admins->getAllUnconnectedCompanyAdminsDatas();
        $datas = array(
            'data' => $adminDatas
        );

        echo json_encode($datas);
    }

    public function addAdmin() {
        $validate = array(
            array(
                'field' => 'adminName',
                'label' => 'Name',
                'rules' => 'required|trim|regex_match[/^[a-zA-Z\s\'-]+$/]',
                'errors' => array(
                    'required' => 'You should provide a %s.',
                    'regex_match' => '%s can only contain letters, spaces, hyphens, and apostrophes.'
                )
            ),
            array(
                'field' => 'adminRole',
                'label' => 'Role',
                'rules' => 'required|trim|regex_match[/^[a-zA-Z\s]+$/]',
                'errors' => array(
                    'required' => 'You should provide a %s.',
                    'regex_match' => '%s can only contain letters and spaces.'
                )
            ),
            array(
                'field' => 'adminStatus',
                'label' => 'Status',
                'rules' => 'required|trim|regex_match[/^[a-zA-Z\s]+$/]',
                'errors' => array(
                    'required' => 'You should provide a %s.',
                    'regex_match' => '%s can only contain letters and spaces.'
                )
            ),
            array(
                'field' => 'adminEmail',
                'label' => 'Email',
                'rules' => 'required|trim|valid_email',
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
            ),
            array(
                'field' => 'confirmPassword',
                'label' => 'Password Confirmation',
                'rules' => 'required|matches[adminPassword]',
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
            $checkAdminEmail = $this->M_admins->checkAdmin('adminEmail', htmlspecialchars($this->input->post('adminEmail')));
            if ($checkAdminEmail) {
                echo json_encode(array('status' => 'failed', 'failedMsg' => 'email used'));
            } else {
                $adminDatas = array(
                    'adminName' => $this->input->post('adminName'),
                    'adminEmail' => htmlspecialchars($this->input->post('adminEmail')),
                    'adminRole' => htmlspecialchars($this->input->post('adminRole')),
                    'adminStatus' => htmlspecialchars($this->input->post('adminStatus')),
                    'adminPassword' => password_hash(htmlspecialchars($this->input->post('adminPassword')), PASSWORD_DEFAULT)
                );
                $this->M_admins->insertAdmin($adminDatas);

                echo json_encode(array('status' => 'success'));
            }
        }
    }

    public function editAdmin() {
        $validate = array(
            array(
                'field' => 'adminName',
                'label' => 'Name',
                'rules' => 'required|trim|regex_match[/^[a-zA-Z\s\'-]+$/]',
                'errors' => array(
                    'required' => 'You should provide a %s.',
                    'regex_match' => '%s can only contain letters, spaces, hyphens, and apostrophes.'
                )
            ),
            array(
                'field' => 'adminRole',
                'label' => 'Role',
                'rules' => 'required|trim|regex_match[/^[a-zA-Z\s]+$/]',
                'errors' => array(
                    'required' => 'You should provide a %s.',
                    'regex_match' => '%s can only contain letters and spaces.'
                )
            ),
            array(
                'field' => 'adminStatus',
                'label' => 'Status',
                'rules' => 'required|trim|regex_match[/^[a-zA-Z\s]+$/]',
                'errors' => array(
                    'required' => 'You should provide a %s.',
                    'regex_match' => '%s can only contain letters and spaces.'
                )
            ),
            array(
                'field' => 'newEmail',
                'label' => 'Email',
                'rules' => 'trim|valid_email',
                'errors' => array(
                    'required' => 'You should provide an %s.',
                    'valid_email' => 'You must provide a valid %s.'
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
            $newEmail = htmlspecialchars($this->input->post('newEmail'));
            $newPassword = htmlspecialchars($this->input->post('newPassword'));

            $checkEmail = $this->M_admins->checkAdmin('adminEmail', $newEmail);

            $adminDatas = array(
                'adminName' => $this->input->post('adminName'),
                'adminRole' => htmlspecialchars($this->input->post('adminRole')),
                'adminStatus' => htmlspecialchars($this->input->post('adminStatus')),
            );
            !empty($newEmail) && empty($checkEmail)? $adminDatas['adminEmail'] = $newEmail : '';
            !empty($newPassword)? $adminDatas['adminPassword'] = $newPassword : '';

            $this->M_admins->updateAdmin($this->input->post('adminId'), $adminDatas);

            echo json_encode(array('status' => 'success'));
        }
    }

    public function deleteAdmin() {
        $adminId = $this->input->post('adminId');
        $this->load->model('M_hospitals');
        $this->load->model('M_companies');

        
        $this->M_admins->deleteAdmin($adminId);
        echo json_encode(array('status' => 'success'));
    }

}

/* End of file Admins.php */

?>