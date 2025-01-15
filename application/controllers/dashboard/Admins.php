<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

use Ramsey\Uuid\Uuid;

class Admins extends CI_Controller {

    
    public function __construct() {
        parent::__construct();

        if ($this->session->userdata('adminRole') != 'admin') {
            redirect('dashboard');
        }

        $this->load->model('M_admins');
    }

    public function index(){
        $datas = array(
            'title' => 'BMMC Dashboard | Admins',
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
                'rules' => 'required|trim|max_length[40]|regex_match[/^[a-zA-Z\s\'-]+$/]',
                'errors' => array(
                    'required' => 'You should provide a %s.',
                    'max_length' => '%s max 40 characters in length.',
                    'regex_match' => '%s can only contain letters, spaces, hyphens, and apostrophes.'
                )
            ),
            array(
                'field' => 'adminRole',
                'label' => 'Role',
                'rules' => 'required|trim|in_list[admin,company,hospital]|regex_match[/^[a-zA-Z\s]+$/]',
                'errors' => array(
                    'required' => 'You should provide a %s.',
                    'in_list' => 'Invalid selection. Please choose a valid option from the list.',
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
            echo json_encode(array('status' => 'invalid', 'errors' => $errors, 'csrfToken' => $this->security->get_csrf_hash()));
        } else {
            $uuid = Uuid::uuid7();
            $checkAdminEmail = $this->M_admins->checkAdmin('adminEmail', htmlspecialchars($this->input->post('adminEmail')));
            if ($checkAdminEmail) {
                echo json_encode(array('status' => 'failed', 'failedMsg' => 'email used', 'csrfToken' => $this->security->get_csrf_hash()));
            } else {
                $adminDatas = array(
                    'adminId' => $uuid->toString(),
                    'adminName' => $this->input->post('adminName'),
                    'adminEmail' => htmlspecialchars($this->input->post('adminEmail')),
                    'adminRole' => htmlspecialchars($this->input->post('adminRole')),
                    'adminPassword' => password_hash(htmlspecialchars($this->input->post('adminPassword')), PASSWORD_DEFAULT)
                );
                $this->M_admins->insertAdmin($adminDatas);

                echo json_encode(array('status' => 'success', 'csrfToken' => $this->security->get_csrf_hash()));
            }
        }
    }

    public function editAdmin() {
        $validate = array(
            array(
                'field' => 'adminName',
                'label' => 'Name',
                'rules' => 'required|trim|max_length[40]|regex_match[/^[a-zA-Z\s\'-]+$/]',
                'errors' => array(
                    'required' => 'You should provide a %s.',
                    'max_length' => '%s max 40 characters in length.',
                    'regex_match' => '%s can only contain letters, spaces, hyphens, and apostrophes.'
                )
            ),
            array(
                'field' => 'adminRole',
                'label' => 'Role',
                'rules' => 'required|trim|in_list[admin,company,hospital]|regex_match[/^[a-zA-Z\s]+$/]',
                'errors' => array(
                    'required' => 'You should provide a %s.',
                    'in_list' => 'Invalid selection. Please choose a valid option from the list.',
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
            echo json_encode(array('status' => 'invalid', 'errors' => $errors, 'csrfToken' => $this->security->get_csrf_hash()));
        } else {
            $adminId = htmlspecialchars($this->input->post('adminId'));
            $checkAdmin = $this->M_admins->checkAdmin('adminId', $adminId);

            $adminDatas = array(
                'adminName' => $this->input->post('adminName')
            );

            $newEmail = htmlspecialchars($this->input->post('newEmail'));
            if ($newEmail) {
                $checkEmail = $this->M_admins->checkAdmin('adminEmail', $newEmail);
                if ($checkEmail) {
                    echo json_encode(array('status' => 'failed', 'failedMsg' => 'email used', 'csrfToken' => $this->security->get_csrf_hash()));
                    return;
                }
            }

            $newPassword = htmlspecialchars($this->input->post('newPassword'));
            if ($newPassword && !password_verify($newPassword, $checkAdmin['adminPassword'])) {
                $adminDatas['adminPassword'] = password_hash($newPassword, PASSWORD_DEFAULT);
            }

            $newRole = htmlspecialchars($this->input->post('adminRole'));
            if ($newRole != $checkAdmin['adminRole']) {
                $adminDatas['adminRole'] = $newRole;
            }

            $this->M_admins->updateAdmin($adminId, $adminDatas);

            echo json_encode(array('status' => 'success', 'data' => $adminDatas, 'csrfToken' => $this->security->get_csrf_hash()));
        }
    }

    public function deleteAdmin() {
        $adminId = $this->input->post('adminId');
        $checkAdmin = $this->M_admins->checkAdmin('adminId', $adminId);

        if (!empty($checkAdmin['status'])) {
            echo json_encode(array(
                'status' => 'failed', 
                'failedMsg' => 'can not delete linked data', 
                'csrfToken' => $this->security->get_csrf_hash()
            ));
            return;
        }

        $this->M_admins->deleteAdmin($adminId);
        echo json_encode(array('status' => 'success', 'csrfToken' => $this->security->get_csrf_hash()));
    }

}

/* End of file Admins.php */

?>