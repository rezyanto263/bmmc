<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Employees extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('adminRole') != 'company') {
            redirect('dashboard/login');
        }

        $this->load->model('M_employees');
        $adminId = $this->session->userdata('adminId');
        $companyData = $this->M_employees->getCompanyByAdminId($adminId);
    }

    public function index()
    {
        $company = array(
            'companyId' => $this->session->userdata('companyId'),
            'companyName' => $this->session->userdata('companyName'),
            'companyLogo' => $this->session->userdata('companyLogo'),
            'companyPhone' => $this->session->userdata('companyPhone'),
            'companyAddress' => $this->session->userdata('companyAddress'),
            'companyCoordinate' => $this->session->userdata('companyCoordinate')
        );

        $datas = array(
            'title' => 'BMMC Company | Employees',
            'subtitle' => 'Employees',
            'contentType' => 'dashboard'
        );

        $partials = array(
            'head' => 'partials/head',
            'sidebar' => 'partials/company/sidebar',
            'floatingMenu' => 'partials/floatingMenu',
            'contentHeader' => 'partials/contentHeader',
            'contentBody' => 'company/employees',
            'footer' => 'partials/dashboard/footer',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

    public function getAllEmployeesDatas() {
        $companyId = $this->session->userdata('companyId');
        $employeesDatas = $this->M_employees->getAllEmployeesDatas($companyId);
        $datas = array(
            'data' => $employeesDatas
        );
    
        echo json_encode($datas);
    }

    public function getEmployeeDetails() {
        $employeeId = $this->input->get('nik');
        $employeeDatas = $this->M_employees->getEmployeeDetails($employeeId);
        $datas = array(
            'data' => $employeeDatas
        );
    
        echo json_encode($datas);
    }

    public function addEmployee() {
        $validate = array(
            array(
                'field' => 'employeeName',
                'label' => 'Nama',
                'rules' => 'required',
                'errors' => array('required' => 'Karyawan harus memberikan %s.')
            ),
            array(
                'field' => 'employeeNIK',
                'label' => 'NIK',
                'rules' => 'required|trim',
                'errors' => array('required' => 'Karyawan harus memberikan %s.')
            ),
            array(
                'field' => 'employeeEmail',
                'label' => 'Email',
                'rules' => 'required|trim|valid_email',
                'errors' => array(
                    'required' => 'Karyawan harus memberikan %s.',
                    'valid_email' => 'Field %s harus berisi alamat email yang valid.'
                )
            ),
            array(
                'field' => 'insuranceId',
                'label' => 'Email',
                'rules' => 'required',
                'errors' => array(
                    'required' => 'Karyawan harus memiliki %s.',
                )
            )
        );
        $this->form_validation->set_rules($validate);
    
        if ($this->form_validation->run() == FALSE) {
            $errors = $this->form_validation->error_array();
            echo json_encode(array('status' => 'invalid', 'errors' => $errors, 'csrfToken' => $this->security->get_csrf_hash()));
        } else {
            $companyId = $this->session->userdata('companyId');
            $employeeNIK = htmlspecialchars($this->input->post('employeeNIK'));
            $employeePassword = strtoupper(uniqid());

            $checkEmployee = $this->M_employees->checkEmployee('employeeNIK', $employeeNIK);
            if ($checkEmployee) {
                echo json_encode(array('status' => 'failed', 'failedMsg' => 'nik used', 'csrfToken' => $this->security->get_csrf_hash()));
                return;
            }

            $employeeData = array(
                'employeeNIK' => $employeeNIK,
                'insuranceId' => htmlspecialchars($this->input->post('insuranceId')),
                'employeeName' => htmlspecialchars($this->input->post('employeeName'), ENT_COMPAT),
                'employeeEmail' => htmlspecialchars($this->input->post('employeeEmail')),
                'employeePassword' => password_hash($employeePassword, PASSWORD_DEFAULT),
                'employeeAddress' => htmlspecialchars($this->input->post('employeeAddress'), ENT_COMPAT),
                'employeePhone' => htmlspecialchars($this->input->post('employeePhone')),
                'employeeBirth' => htmlspecialchars($this->input->post('employeeBirth')),
                'employeeGender' => htmlspecialchars($this->input->post('employeeGender')),
                'employeeStatus' => 'unverified'
            );

            if ($_FILES['employeePhoto']['name']) {
                $photoFileName = strtoupper(trim(str_replace('.', ' ',$employeeData['employeeName']))).'-'.time();
                $employeePhoto = $this->_uploadImage('employeePhoto', array('file_name' => $photoFileName, 'upload_path' => FCPATH . 'uploads/profiles/'));
                if ($employeePhoto['status']) {
                    $employeeData['employeePhoto'] = $employeePhoto['data']['file_name'];
                } else {
                    echo json_encode(array(
                        'status' => 'failed', 
                        'failedMsg' => 
                        'upload failed', 
                        'errorMsg' => $employeePhoto['error'], 
                        'csrfToken' => $this->security->get_csrf_hash()
                    ));
                    return;
                }
            }

            $this->load->library('sendemail');

            $datas = array(
                'accountName' => $employeeData['employeeName'],
                'accountEmail' => $employeeData['employeeEmail'],
                'accountPassword' => $employeePassword,
                'bmmcEmail' => 'testbmmc@gmail.com'
            );

            $subject = 'Login & Reset your password account';
            $body = $this->load->view('company/newAccountEmail', $datas, TRUE);

            if ($this->sendemail->send($employeeData['employeeEmail'], $subject, $body)) {
                $this->M_employees->insertEmployee($employeeData);
                echo json_encode(array('status' => 'success', 'csrfToken' => $this->security->get_csrf_hash()));
            } else {
                echo json_encode(array(
                    'status' => 'failed',
                    'failedMsg' => 'send email failed',
                    'csrfToken' => $this->security->get_csrf_hash()
                ));
            }
        }
    }

    private function _uploadImage($imageInputField, $customConfig = []) {
        $defaultConfig = array(
            'allowed_types' => 'jpg|jpeg|png',
            'max_size'      => 1024,
            'max_width'     => 0,
            'max_height'    => 0
        );

        $config = array_merge($defaultConfig, $customConfig);

        if (!isset($this->upload)) {
            $this->load->library('upload');
        }

        $this->upload->initialize($config);

        if (!$this->upload->do_upload($imageInputField)) {
            return array('status' => false, 'error' => strip_tags($this->upload->display_errors()));
        } else {
            return array('status' => true, 'data' => $this->upload->data());
        }
    }

    private function _deleteImage($employeeNIK, $field, $path) {
        $employeeDatas = $this->M_employees->checkEmployee('employeeNIK', $employeeNIK );
        $employeeDatas[$field] && unlink($path . $employeeDatas[$field]);
    }

    public function editEmployee() {
        $validate = array(
            array(
                'field' => 'employeeName',
                'label' => 'Name',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Employee should provide a %s.'
                )
            ),
            array(
                'field' => 'employeeStatus',
                'label' => 'Status',
                'rules' => 'trim|in_list[active,on hold,discontinued]',
                'errors' => array(
                    'in_list' => 'Invalid selection. Please choose a valid option from the list.'
                )
            ),
            array(
                'field' => 'employeeNIK',
                'label' => 'NIK',
                'rules' => 'required|trim|numeric|max_length[16]|min_length[16]',
                'errors' => array(
                    'required' => 'Employee should provide a %s.',
                    'numeric' => 'Employee %s should be a number.'
                )
            ),
            array(
                'field' => 'employeeEmail',
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
            echo json_encode(array('status' => 'invalid', 'errors' => $errors, 'csrfToken' => $this->security->get_csrf_hash()));
        } else {
            $newPassword = htmlspecialchars($this->input->post('newPassword') ?: '') ?: NULL;
            $employeeNIK = htmlspecialchars($this->input->post('employeeNIK'));
            $newEmployeeNIK = htmlspecialchars($this->input->post('newEmployeeNIK') ?: '') ?: NULL;
            $employeeStatus = htmlspecialchars($this->input->post('employeeStatus') ?: '') ?: NULL;

            $checkEmployee = false;
            !empty($newEmployeeNIK) && $checkEmployee = $this->M_employees->checkEmployee('employeeNIK', $newEmployeeNIK);
            if ($checkEmployee) {
                echo json_encode(array('status' => 'failed', 'failedMsg' => 'nik used', 'csrfToken' => $this->security->get_csrf_hash()));
                return;
            }

            $employeeData = array(
                'insuranceId' => $this->input->post('insuranceId'),
                'employeeName' => $this->input->post('employeeName'),
                'employeeEmail' => $this->input->post('employeeEmail'),
                'employeeAddress' => $this->input->post('employeeAddress'),
                'employeePhone' => $this->input->post('employeePhone'),
                'employeeBirth' => $this->input->post('employeeBirth'),
                'employeeGender' => $this->input->post('employeeGender')
            );
            !empty($newEmployeeNIK) ? $employeeData['employeeNIK'] = $newEmployeeNIK : '';
            !empty($employeeStatus) ? $employeeData['employeeStatus'] = $employeeStatus : '';
            !empty($newPassword) ? $employeeData['employeePassword'] = password_hash($newPassword, PASSWORD_DEFAULT) : '';

            if (!empty($_FILES['employeePhoto']['name'])) {
                $photoFileName = strtoupper(trim(str_replace('.', ' ', $employeeData['employeeName']))) . '-' . time();
                $employeePhoto = $this->_uploadImage('employeePhoto', array('file_name' => $photoFileName, 'upload_path' => FCPATH . 'uploads/profiles/'));
                if ($employeePhoto['status']) {
                    $existingEmployee = $this->M_employees->checkEmployee('employeeNIK', $employeeNIK);
                    if (!empty($existingEmployee['employeePhoto'])) {
                        $this->_deleteImage($existingEmployee['employeePhoto'], FCPATH . 'uploads/profiles/');
                    }
                    $employeeData['employeePhoto'] = $employeePhoto['data']['file_name'];
                } else {
                    echo json_encode(array('status' => 'failed', 'failedMsg' => 'upload failed', 'errorMsg' => $employeePhoto['error'], 'csrfToken' => $this->security->get_csrf_hash()));
                    return;
                }
            }
    
            $this->M_employees->updateEmployee($employeeNIK, $employeeData);
            echo json_encode(array('status' => 'success', 'csrfToken' => $this->security->get_csrf_hash()));
        }
    }

    public function deleteEmployee() {
        $employeeNIK = $this->input->post('employeeNIK');
        $this->M_employees->deleteEmployee($employeeNIK);

        echo json_encode(array('status' => 'success', 'csrfToken' => $this->security->get_csrf_hash()));
    }
}

/* End of file Company.php */

?>