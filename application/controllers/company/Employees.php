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
    }

    public function index() {
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
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
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

    public function getAllEmployeesByCompanyId() {
        $companyId = $this->input->get('id') ?: $this->session->userdata('companyId');
        $employeesDatas = $this->M_employees->getAllEmployeesByCompanyId($companyId);
        $datas = array(
            'data' => $employeesDatas
        );
    
        echo json_encode($datas);
    }

    public function getInsuranceDetailsByEmployeeNIK() {
        $employeeNIK = $this->input->get('nik');
        $this->load->model('M_insurances');
        $employeeInsuranceData = $this->M_insurances->getInsuranceDetailsByEmployeeNIK($employeeNIK);
        $datas = array(
            'data' => $employeeInsuranceData
        );
    
        echo json_encode($datas);
    }

    public function getAllDepartmentByCompanyId() {
        $companyId = $this->input->get('id') ?: $this->session->userdata('companyId');
        $departmentNames = $this->M_employees->getAllDepartmentByCompanyId($companyId);
        $datas = array(
            'data' => $departmentNames
        );

        echo json_encode($datas);
    }

    public function getAllBandByCompanyId() {
        $companyId = $this->input->get('id') ?: $this->session->userdata('companyId');
        $bandNames = $this->M_employees->getAllBandByCompanyId($companyId);
        $datas = array(
            'data' => $bandNames
        );

        echo json_encode($datas);
    }

    public function addEmployee() {
        $validate = array(
            array(
                'field' => 'employeeNIK',
                'label' => 'NIK',
                'rules' => 'required|trim|numeric|exact_length[16]',
                'errors' => array(
                    'required' => 'Employee should provide a %s.',
                    'numeric' => '%s should be a number.',
                    'exact_length' => '%s must be exactly 16 digits.',
                    )
            ),
            array(
                'field' => 'employeeName',
                'label' => 'Name',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Employee should provide a %s.',
                )
            ),
            array(
                'field' => 'employeeDepartment',
                'label' => 'Department',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Employee should provide a %s.',
                )
            ),
            array(
                'field' => 'employeeBand',
                'label' => 'Band',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Employee should provide a %s.',
                )
            ),
            array(
                'field' => 'employeeGender',
                'label' => 'Gender',
                'rules' => 'required|trim|in_list[male,female]',
                'errors' => array(
                    'required' => 'Employee should provide a %s.',
                    'in_list' => 'Invalid selection. Please choose a valid option from the list.'
                )
            ),
            array(
                'field' => 'employeeBirth',
                'label' => 'Birth Date',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Employee should provide a %s.',
                )
            ),
            array(
                'field' => 'employeeEmail',
                'label' => 'Email',
                'rules' => 'required|trim|valid_email',
                'errors' => array(
                    'required' => 'Employee should provide a %s.',
                    'valid_email' => 'Field %s harus berisi alamat email yang valid.'
                )
            ),
            array(
                'field' => 'employeePhone',
                'label' => 'Phone',
                'rules' => 'required|trim|numeric',
                'errors' => array(
                    'required' => 'Employee should provide a %s.',
                    'numeric' => '%s should be a number.'
                )
            ),
            array(
                'field' => 'employeeAddress',
                'label' => 'Phone',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Employee should provide a %s.',
                )
            ),
            array(
                'field' => 'insuranceId',
                'label' => 'Email',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Employee should provide a %s.',
                )
            ),
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
            if (!empty($checkEmployee)) {
                echo json_encode(array('status' => 'failed', 'failedMsg' => 'nik used', 'csrfToken' => $this->security->get_csrf_hash()));
                return;
            }

            $employeeData = array(
                'employeeNIK' => $employeeNIK,
                'insuranceId' => htmlspecialchars($this->input->post('insuranceId')),
                'employeeName' => htmlspecialchars($this->input->post('employeeName'), ENT_COMPAT),
                'employeeEmail' => htmlspecialchars($this->input->post('employeeEmail')),
                'employeeBirth' => htmlspecialchars($this->input->post('employeeBirth')),
                'employeeGender' => htmlspecialchars($this->input->post('employeeGender')),
                'employeeDepartment' => htmlspecialchars($this->input->post('employeeDepartment')),
                'employeeBand' => htmlspecialchars($this->input->post('employeeBand')),
                'employeePhone' => htmlspecialchars($this->input->post('employeePhone')),
                'employeeAddress' => htmlspecialchars($this->input->post('employeeAddress'), ENT_COMPAT),
                'employeePassword' => password_hash($employeePassword, PASSWORD_DEFAULT),
                'employeeStatus' => 'unverified'
            );

            $this->load->model('M_insurances');
            $checkInsurance = $this->M_insurances->checkInsurance('insuranceId', $employeeData['insuranceId']);
            $unallocatedBillingAmount = $this->M_insurances->getLastBillingUnallocatedAmountByCompanyId($checkInsurance['companyId']);
            if ($unallocatedBillingAmount < $checkInsurance['insuranceAmount']) {
                echo json_encode(array(
                    'status' => 'failed',
                    'failedMsg' => 'billing amount exceeded',
                    'csrfToken' => $this->security->get_csrf_hash()
                ));
                return;
            }

            $this->load->model('M_dashboard');
            $checkEmailAvailability = $this->M_dashboard->checkUserEmailAvailability($employeeData['employeeEmail']);
            if (!empty($checkEmailAvailability)) {
                echo json_encode(array(
                    'status' => 'failed', 
                    'failedMsg' => 'email used', 
                    'csrfToken' => $this->security->get_csrf_hash()
                ));
                return;
            }

            if (!empty($_FILES['employeePhoto']['name'])) {
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
                'supportEmail' => $_ENV['SUPPORT_EMAIL']
            );

            $subject = 'Login & Reset your password account';
            $body = $this->load->view('email/newAccountEmail', $datas, TRUE);

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

    public function editEmployee() {
        $validate = array(
            array(
                'field' => 'employeeNIK',
                'label' => 'NIK',
                'rules' => 'required|trim|numeric|exact_length[16]',
                'errors' => array(
                    'required' => 'Employee should provide a %s.',
                    'numeric' => '%s should be a number.',
                    'exact_length' => '%s must be exactly 16 digits.',
                )
            ),
            array(
                'field' => 'newEmployeeNIK',
                'label' => 'NIK',
                'rules' => 'trim|numeric|exact_length[16]',
                'errors' => array(
                    'numeric' => '%s should be a number.',
                    'exact_length' => '%s must be exactly 16 digits.',
                )
            ),
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
                'field' => 'employeeDepartment',
                'label' => 'Department',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Employee should provide a %s.',
                )
            ),
            array(
                'field' => 'employeeBand',
                'label' => 'Band',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Employee should provide a %s.',
                )
            ),
            array(
                'field' => 'employeeGender',
                'label' => 'Gender',
                'rules' => 'required|trim|in_list[male,female]',
                'errors' => array(
                    'required' => 'Employee should provide a %s.',
                    'in_list' => 'Invalid selection. Please choose a valid option from the list.'
                )
            ),
            array(
                'field' => 'employeeBirth',
                'label' => 'Birth Date',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Employee should provide a %s.',
                )
            ),
            array(
                'field' => 'newEmployeeEmail',
                'label' => 'Email',
                'rules' => 'trim|valid_email',
                'errors' => array(
                    'valid_email' => 'The %s field must contain a valid email address.'
                )
            ),
            array(
                'field' => 'employeePhone',
                'label' => 'Phone',
                'rules' => 'required|trim|numeric',
                'errors' => array(
                    'required' => 'Employee should provide a %s.',
                    'numeric' => '%s should be a number.'
                )
            ),
            array(
                'field' => 'employeeAddress',
                'label' => 'Phone',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Employee should provide a %s.',
                )
            ),
            array(
                'field' => 'newPassword',
                'label' => 'Password',
                'rules' => 'trim|min_length[8]|max_length[20]|regex_match[/^(?=.*[A-Z])(?=.*\d).+$/]',
                'errors' => array(
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
            $employeeData = array(
                'insuranceId' => htmlspecialchars($this->input->post('insuranceId')),
                'employeeName' => htmlspecialchars($this->input->post('employeeName'), ENT_COMPAT),
                'employeeBirth' => htmlspecialchars($this->input->post('employeeBirth')),
                'employeeGender' => htmlspecialchars($this->input->post('employeeGender')),
                'employeeDepartment' => htmlspecialchars($this->input->post('employeeDepartment')),
                'employeeBand' => htmlspecialchars($this->input->post('employeeBand')),
                'employeePhone' => htmlspecialchars($this->input->post('employeePhone')),
                'employeeAddress' => htmlspecialchars($this->input->post('employeeAddress'), ENT_COMPAT),
            );

            $employeeNIK = htmlspecialchars($this->input->post('employeeNIK'));
            $newEmployeeNIK = htmlspecialchars($this->input->post('newEmployeeNIK') ?: '') ?: NULL;
            if (!empty($newEmployeeNIK) && $employeeNIK !== $newEmployeeNIK) {
                $checkEmployee = $this->M_employees->checkEmployee('employeeNIK', $newEmployeeNIK);
                if (!empty($checkEmployee)) {
                    echo json_encode(array('status' => 'failed', 'failedMsg' => 'nik used', 'csrfToken' => $this->security->get_csrf_hash()));
                    return;
                }
                $employeeData['employeeNIK'] = $newEmployeeNIK;
            }

            $this->load->model('M_insurances');
            $checkEmployee = $this->M_employees->checkEmployee('employeeNIK', $employeeNIK);
            $checkCurrentInsurance = $this->M_insurances->checkInsurance('insuranceId', $checkEmployee['insuranceId']);
            $checkNewInsurance = $this->M_insurances->checkInsurance('insuranceId', $employeeData['insuranceId']);

            $checkEmployeeInsuranceDetails = $this->M_insurances->getInsuranceDetailsByEmployeeNIK($checkEmployee['employeeNIK']);
            if ($checkNewInsurance['insuranceAmount'] < $checkEmployeeInsuranceDetails['totalBillingUsedThisMonth']) {
                echo json_encode(array(
                    'status' => 'failed',
                    'failedMsg' => 'insurance amount exceeded',
                    'p' => $checkEmployeeInsuranceDetails['totalBillingUsedThisMonth'],
                    'csrfToken' => $this->security->get_csrf_hash()
                ));
                return;
            }

            $unallocatedBillingAmount = $this->M_insurances->getLastBillingUnallocatedAmountByCompanyId($checkNewInsurance['companyId']) + $checkCurrentInsurance['insuranceAmount'];
            if (($unallocatedBillingAmount - $checkNewInsurance['insuranceAmount']) < 0) {
                echo json_encode(array(
                    'status' => 'failed',
                    'failedMsg' => 'billing amount exceeded',
                    'p' => $unallocatedBillingAmount,
                    'csrfToken' => $this->security->get_csrf_hash()
                ));
                return;
            }

            $employeeStatus = htmlspecialchars($this->input->post('employeeStatus') ?: '') ?: NULL;
            if (!empty($employeeStatus)) {
                $employeeData['employeeStatus'] = $employeeStatus;
            }

            $newPassword = $this->input->post('newPassword');
            if (!empty($newPassword)) {
                $employeeData['employeePassword'] = password_hash($newPassword, PASSWORD_DEFAULT);
            }

            $newEmployeeEmail = htmlspecialchars($this->input->post('newEmployeeEmail') ?: '') ?: NULL;
            if (!empty($newEmployeeEmail)) {
                $this->load->model('M_dashboard');
                $checkEmailAvailability = $this->M_dashboard->checkUserEmailAvailability($newEmployeeEmail);
                if (!empty($checkEmailAvailability)) {
                    echo json_encode(array(
                        'status' => 'failed', 
                        'failedMsg' => 'email used', 
                        'csrfToken' => $this->security->get_csrf_hash()
                    ));
                    return;
                }
                $employeeData['employeeEmail'] = $newEmployeeEmail;
            }

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