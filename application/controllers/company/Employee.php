<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('adminRole') != ('admin' || 'company')) {
            redirect('dashboard');
        }

        $this->load->model('M_employee');
        $adminId = $this->session->userdata('adminId');
        $companyData = $this->M_employee->getCompanyByAdminId($adminId);
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
            'title' => 'BIM Dashboard | Companies',
            'subtitle' => 'Employee',
            'contentType' => 'dashboard'
        );

        $partials = array(
            'head' => 'partials/head',
            'sidebar' => 'partials/company/sidebar',
            'floatingMenu' => 'partials/floatingMenu',
            'contentHeader' => 'partials/contentHeader',
            'contentBody' => 'company/Employee',
            'footer' => 'partials/dashboard/footer',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

    public function getAllEmployeesDatas() {
        $companyId = $this->session->userdata('companyId');
        $employeesDatas = $this->M_employee->getAllEmployeesDatas($companyId);
        $datas = array(
            'data' => $employeesDatas
        );
    
        echo json_encode($datas);
    }

    public function addEmployee() {
        $validate = array(
            // Aturan validasi untuk setiap field
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
                'field' => 'employeePassword',
                'label' => 'Password',
                'rules' => 'required|trim|min_length[8]|max_length[20]|regex_match[/^(?=.*[A-Z])(?=.*\d).+$/]',
                'errors' => array(
                    'required' => 'Anda harus memberikan %s.',
                    'min_length' => '%s harus memiliki panjang minimal 8 karakter.',
                    'max_length' => '%s maksimal 20 karakter.',
                    'regex_match' => '%s harus mengandung setidaknya satu huruf besar dan satu angka.'
                )
            ),
            array(
                'field' => 'confirmPassword',
                'label' => 'Konfirmasi Password',
                'rules' => 'required|matches[employeePassword]',
                'errors' => array(
                    'required' => 'Anda harus memberikan %s.',
                    'matches' => '%s tidak cocok dengan Password.'
                )
            )
        );
        $this->form_validation->set_rules($validate);
    
        // Validasi form
        if ($this->form_validation->run() == FALSE) {
            $errors = $this->form_validation->error_array();
            echo json_encode(array('status' => 'invalid', 'errors' => $errors));
        } else {
            $companyId = $this->session->userdata('companyId');
            $employeeData = array(
                'employeeNIK' => htmlspecialchars($this->input->post('employeeNIK')),
                'insuranceId' => $this->input->post('insuranceId'),
                'employeeName' => $this->input->post('employeeName'),
                'employeeEmail' => $this->input->post('employeeEmail'),
                'employeePassword' => password_hash(htmlspecialchars($this->input->post('employeePassword')), PASSWORD_DEFAULT),
                'employeeAddress' => $this->input->post('employeeAddress'),
                'employeePhone' => $this->input->post('employeePhone'),
                'employeeBirth' => $this->input->post('employeeBirth'),
                'employeeGender' => $this->input->post('employeeGender')
            );
    
            // Handle file upload if a photo is provided
            if ($_FILES['employeePhoto']['name']) {
                $photoFileName = strtoupper(trim(str_replace('.', ' ',$employeeData['employeeName']))).'-'.time();
                $employeePhoto = $this->_uploadImage('employeePhoto', array('file_name' => $photoFileName, 'upload_path' => FCPATH . 'uploads/photos/'));
                if ($employeePhoto['status']) {
                    $employeeData['employeePhoto'] = $employeePhoto['data']['file_name'];
                } else {
                    echo json_encode(array('status' => 'failed', 'failedMsg' => 'upload failed', 'errorMsg' => $employeePhoto['error']));
                    return;
                }
            }
                // No photo uploaded, just insert data
                $this->M_employee->insertEmployee($employeeData);
                echo json_encode(array('status' => 'success'));
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
        $companyDatas = $this->M_companies->checkCompany('employeeNIK', $employeeNIK );
        $companyDatas[$field] && unlink($path . $companyDatas[$field]);
    }

    public function editEmployee() {
        // Validation rules
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
    
        // Validate the form input
        if ($this->form_validation->run() == FALSE) {
            $errors = $this->form_validation->error_array();
            echo json_encode(array('status' => 'invalid', 'errors' => $errors));
        } else {
            // Retrieve form data
            $employeeNIK = $this->input->post('employeeNIK');
            $newPassword = htmlspecialchars($this->input->post('newPassword'));
            $employeeData = array(
                'employeeNIK' => $this->input->post('employeeNIK'),
                'insuranceId' => $this->input->post('insuranceId'),
                'employeeName' => $this->input->post('employeeName'),
                'employeeEmail' => $this->input->post('employeeEmail'),
                'employeeAddress' => $this->input->post('employeeAddress'),
                'employeePhone' => $this->input->post('employeePhone'),
                'employeeBirth' => $this->input->post('employeeBirth'),
                'employeeGender' => $this->input->post('employeeGender'),
            );
            !empty($newPassword) ? $employeeData['employeePassword'] = password_hash($newPassword, PASSWORD_DEFAULT) : '';
    
            // Handle photo update if a new photo is uploaded
            if ($_FILES['employeePhoto']['name']) {
                $photoFileName = strtoupper(trim(str_replace('.', ' ', $employeeData['employeeName']))) . '-' . time();
                $employeePhoto = $this->_uploadImage('employeePhoto', array('file_name' => $photoFileName, 'upload_path' => FCPATH . 'uploads/photos/'));
                if ($employeePhoto['status']) {
                    // Delete old photo
                    $existingEmployee = $this->M_employee->getEmployeeByNIK($employeeNIK);
                    if (!empty($existingEmployee['employeePhoto'])) {
                        $this->_deleteImage($existingEmployee['employeePhoto'], FCPATH . 'uploads/photos/');
                    }
    
                    $employeeData['employeePhoto'] = $employeePhoto['data']['file_name'];
                } else {
                    echo json_encode(array('status' => 'failed', 'failedMsg' => 'upload failed', 'errorMsg' => $employeePhoto['error']));
                    return;
                }
            }
    
            $this->M_employee->updateEmployee($employeeNIK, $employeeData);
            echo json_encode(array('status' => 'success'));
        }
    }
     

    public function deleteEmployee() {
        $employeeNIK = $this->input->post('employeeNIK');
        $this->M_employee->deleteEmployee($employeeNIK);

        echo json_encode(array('status' => 'success'));
    }
}

/* End of file Company.php */

?>