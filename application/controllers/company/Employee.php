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
            'floatingMenu' => 'partials/dashboard/floatingMenu',
            'contentHeader' => 'partials/company/contentHeader',
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
                'field' => 'policyholderName',
                'label' => 'Nama',
                'rules' => 'required',
                'errors' => array('required' => 'Karyawan harus memberikan %s.')
            ),
            array(
                'field' => 'policyholderNIK',
                'label' => 'NIK',
                'rules' => 'required|trim',
                'errors' => array('required' => 'Karyawan harus memberikan %s.')
            ),
            array(
                'field' => 'policyholderEmail',
                'label' => 'Email',
                'rules' => 'required|trim|valid_email',
                'errors' => array(
                    'required' => 'Karyawan harus memberikan %s.',
                    'valid_email' => 'Field %s harus berisi alamat email yang valid.'
                )
            ),
            array(
                'field' => 'policyholderPassword',
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
                'rules' => 'required|matches[policyholderPassword]',
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
                'policyholderNIK' => htmlspecialchars($this->input->post('policyholderNIK')),
                'policyholderName' => $this->input->post('policyholderName'),
                'policyholderEmail' => $this->input->post('policyholderEmail'),
                'policyholderPassword' => password_hash(htmlspecialchars($this->input->post('policyholderPassword')), PASSWORD_DEFAULT),
                'policyholderAddress' => $this->input->post('policyholderAddress'),
                'policyholderPhone' => $this->input->post('policyholderPhone'),
                'policyholderBirth' => $this->input->post('policyholderBirth'),
                'policyholderGender' => $this->input->post('policyholderGender'),
                'policyholderStatus' => $this->input->post('policyholderStatus'),
            );
    
            // Handle file upload if a photo is provided
            if ($_FILES['policyholderPhoto']['name']) {
                $fileName = strtoupper(trim(str_replace('.', ' ', $employeeData['policyholderName']))) . '-' . time();
                $policyholderPhoto = $this->_uploadLogo('policyholderPhoto', array('file_name' => $fileName));
    
                if ($policyholderPhoto['status']) {
                    $employeeData['policyholderPhoto'] = $policyholderPhoto['data']['file_name'];
    
                    // Insert employee data into the database
                    $this->M_employee->insertEmployee($employeeData);
    
                    // Insert data into the compolder table
                    $compolderData = array(
                        'companyId' => $companyId,
                        'policyholderNIK' => $this->input->post('policyholderNIK')
                    );
                    $this->M_employee->insertCompolder($compolderData);
    
                    echo json_encode(array('status' => 'success'));
                    return;
                } else {
                    echo json_encode(array('status' => 'failed', 'failedMsg' => 'Upload failed', 'errorMsg' => $policyholderPhoto['error']));
                    return; // Stop execution if upload fails
                }
            } else {
                // No photo uploaded, just insert data
                $this->M_employee->insertEmployee($employeeData);
    
                // Insert data into the compolder table
                $compolderData = array(
                    'companyId' => $companyId,
                    'policyholderNIK' => $this->input->post('policyholderNIK')
                );
                $this->M_employee->insertCompolder($compolderData);
    
                echo json_encode(array('status' => 'success'));
            }
        }
    }

    private function _uploadLogo($fileLogo, $customConfig = []) {
        $defaultConfig = array(
            'upload_path'   => FCPATH . 'uploads/logos/',
            'allowed_types' => 'jpg|jpeg|png',
            'max_size'      => 1024,
            'max_width'     => 0,
            'max_height'    => 0
        );

        $config = array_merge($defaultConfig, $customConfig);

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($fileLogo)) {
            return array('status' => false, 'error' => $this->upload->display_errors());
        } else {
            return array('status' => true, 'data' => $this->upload->data());
        }
    }

    private function _deleteLogo($policyholderNIK) {
        $employeeData = $this->M_employee->checkEmployee('policyholderNIK', $policyholderNIK);
        unlink(FCPATH . 'uploads/logos/' . $employeeData['policyholderPhoto']);
    }

    public function editEmployee() {
        // Validation rules
        $validate = array(
            array(
                'field' => 'policyholderName',
                'label' => 'Name',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Employee should provide a %s.'
                )
            ),
            array(
                'field' => 'policyholderEmail',
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
            $policyholderNIK = $this->input->post('policyholderNIK');
            $employeeData = array(
                'policyholderNIK' => $this->input->post('policyholderNIK'),
                'policyholderName' => $this->input->post('policyholderName'),
                'policyholderEmail' => $this->input->post('policyholderEmail'),
                'policyholderAddress' => $this->input->post('policyholderAddress'),
                'policyholderPhone' => $this->input->post('policyholderPhone'),
                'policyholderBirth' => $this->input->post('policyholderBirth'),
                'policyholderGender' => $this->input->post('policyholderGender'),
                'policyholderStatus' => $this->input->post('policyholderStatus'),
            );
    
            // Handle password change if provided
            $newPassword = htmlspecialchars($this->input->post('newPassword'));
            if (!empty($newPassword)) {
                $employeeData['policyholderPassword'] = $newPassword;
            }
    
            // Handle photo upload if provided
            if ($_FILES['policyholderPhoto']['name']) {
                $fileName = strtoupper(trim(str_replace('.', ' ', $employeeData['policyholderName']))) . '-' . time();
                $policyholderPhoto = $this->_uploadLogo('policyholderPhoto', array('file_name' => $fileName));
    
                if ($policyholderPhoto['status']) {
                    // If there's an existing photo, delete it
                    $this->_deleteLogo($policyholderNIK);
                    $employeeData['policyholderPhoto'] = $policyholderPhoto['data']['file_name'];
                } else {
                    echo json_encode(array('status' => 'failed', 'failedMsg' => 'upload failed', 'errorMsg' => $policyholderPhoto['error']));
                    return; // Exit here if photo upload fails
                }
            }
    
            // Update employee record
            $this->M_employee->updateEmployee($policyholderNIK, $employeeData);
            echo json_encode(array('status' => 'success'));
        }
    }    

    public function deleteEmployee() {
        $policyholderNIK = $this->input->post('policyholderNIK');
        $this->M_employee->deleteEmployee($policyholderNIK);

        echo json_encode(array('status' => 'success'));
    }
}

/* End of file Company.php */

?>