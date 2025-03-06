<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('adminRole') != 'company') {
            redirect('dashboard/login');
        }

        $this->load->model('M_companies');
    }

    public function index() {
        $this->load->model('M_admins');
        $adminDatas = $this->M_admins->checkAdmin('adminId', $this->session->userdata('adminId'));
        $this->_initCompanySession($adminDatas);

        $invoiceAndInsuranceMember = $this->M_companies->getCompanyDetails($this->session->userdata('companyId'));

        $this->load->model('M_invoices');
        $billing = $this->M_invoices->checkCurrentBillingByCompanyId($this->session->userdata('companyId'));
        $billingInfo = array(
            'totalBillingUsed' => $billing['totalBillingUsed'],
            'totalBillingRemaining' => $billing['billingAmount'] - $billing['totalBillingUsed'],
            'totalBillingAmount' => $billing['billingAmount'],
            'billingStartedAt' => $billing['billingStartedAt'],
            'billingEndedAt' => $billing['billingEndedAt'],
        );

        $companyData = array_merge($invoiceAndInsuranceMember, $billingInfo);

        $datas = array(
            'title' => 'BMMC Company | Dashboard',
            'subtitle' => 'Dashboard',
            'contentType' => 'dashboard',
            'company' => $companyData
        );

        $partials = array(
            'head' => 'partials/head',
            'sidebar' => 'partials/company/sidebar',
            'floatingMenu' => 'partials/floatingMenu',
            'contentHeader' => 'partials/contentHeader',
            'contentBody' => 'company/dashboard',
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

    private function _deleteImage($companyId, $field, $path) {
        $companyDatas = $this->M_companies->checkCompany('companyId', $companyId);
        !empty($companyDatas[$field]) && unlink($path . $companyDatas[$field]);
    }

    private function _initCompanySession($adminDatas) {
        $sessionData = array(
            'adminId'    => $adminDatas['adminId'],
            'adminName'  => $adminDatas['adminName'],
            'adminEmail' => $adminDatas['adminEmail'],
            'adminRole'  => $adminDatas['adminRole']
        );
    
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

        $this->session->set_userdata($sessionData);
    }

    public function scanQR() {
        $this->load->library('encryption');
        $qrInput = $this->encryption->decrypt($this->input->post('qrData'));
        if (!$qrInput) {
            echo json_encode(array(
                'status' => 'failed',
                'failedMsg' => 'qr data missing',
                'csrfToken' => $this->security->get_csrf_hash()
            ));
            return;
        }

        $qrData = explode('-', $qrInput);
        if (!(count($qrData) == 2)) {
            echo json_encode(array(
                'status' => 'failed',
                'failedMsg' => 'incorrect format qr data',
                'csrfToken' => $this->security->get_csrf_hash()
            ));
            return;
        }
        
        $NIK = trim($qrData[0]) ?: NULL;
        $role = trim($qrData[1]) ?: NULL;
        if (!$NIK || !$role) {
            echo json_encode(array(
                'status' => 'failed',
                'failedMsg' => 'incomplete qr data',
                'csrfToken' => $this->security->get_csrf_hash()
            ));
            return;
        }

        if ($role == 'employee') {
            $this->load->model('M_employees');
            $patientData = $this->M_employees->getEmployeeByNIK($NIK);
        } else {
            $this->load->model('M_families');
            $patientData = $this->M_families->getFamilyByNIK($NIK);
        }

        $employeeNIK = $patientData['employeeNIK'];
        $this->load->model('M_insurances');
        $insuranceData = $this->M_insurances->getInsuranceDetailsByEmployeeNIK($employeeNIK);

        if ($patientData && $insuranceData) {
            echo json_encode(array(
                'status' => 'success',
                'data' => array(
                    'profile' => $patientData, 
                    'insurance' => $insuranceData
                ),
                'csrfToken' => $this->security->get_csrf_hash()
            ));
        } else {
            echo json_encode(array(
                'status' => 'failed',
                'failedMsg' => 'scan not found',
                'csrfToken' => $this->security->get_csrf_hash()
            ));
        }
    }

    public function editProfile() {
        $validate = array(
            array(
                'field' => 'companyName',
                'label' => 'Name',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Company should provide a %s.'
                )
            ),
            array(
                'field' => 'companyPhone',
                'label' => 'Phone',
                'rules' => 'required|trim|numeric|max_length[13]',
                'errors' => array(
                    'required' => 'Company should provide a %s.',
                    'numeric' => 'The %s field must contain only numbers.',
                    'max_length' => '%s number max 13 digits in length.',
                )
            ),
            array(
                'field' => 'companyAddress',
                'label' => 'Address',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Company should provide a %s.'
                )
            ),
            array(
                'field' => 'companyCoordinate',
                'label' => 'Coordinate',
                'rules' => 'trim|regex_match[/^[-+]?\d{1,2}(\.\d+)?,\s*[-+]?\d{1,3}(\.\d+)?$/]',
                'errors' => array(
                    'regex_match' => 'The %s field must contain valid latitude and longitude coordinates.'
                )
            ),
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
                'field' => 'adminEmail',
                'label' => 'Email',
                'rules' => 'required|trim|valid_email',
                'errors' => array(
                    'required' => 'You should provide an %s.',
                    'valid_email' => 'You must provide a valid %s.'
                )
            ),
            array(
                'field' => 'currentPassword',
                'label' => 'Password',
                'rules' => 'trim|min_length[8]|max_length[20]|regex_match[/^(?=.*[A-Z])(?=.*\d).+$/]',
                'errors' => array(
                    'min_length' => '%s must be at least 8 characters in length.',
                    'max_length' => '%s max 20 characters in length.',
                    'regex_match' => '%s must contain at least one uppercase letter and one number.'
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
                    'matches' => '%s does not match the new Password.'
                )
            )
        );
        $this->form_validation->set_rules($validate);
    
        if ($this->form_validation->run() == FALSE) {
            $errors = $this->form_validation->error_array();
            echo json_encode(array('status' => 'invalid', 'errors' => $errors, 'csrfToken' => $this->security->get_csrf_hash()));
        } else {
            $companyId = htmlspecialchars($this->session->userdata('companyId'));
            $companyDatas = array(
                'companyName' => htmlspecialchars($this->input->post('companyName'), ENT_COMPAT),
                'companyPhone' => htmlspecialchars($this->input->post('companyPhone')),
                'companyAddress' => htmlspecialchars($this->input->post('companyAddress'), ENT_COMPAT),
            );

            $companyCoordinate = htmlspecialchars($this->input->post('companyCoordinate'));
            if (!empty($companyCoordinate)) {
                $checkCompanyCoordinate = $this->M_companies->checkCompany('companyCoordinate', $companyCoordinate);
                if (!$checkCompanyCoordinate) {
                    $companyDatas['companyCoordinate'] = $companyCoordinate;
                } else {
                    echo json_encode(array(
                        'status' => 'failed', 
                        'failedMsg' => 'coordinate used', 
                        'csrfToken' => $this->security->get_csrf_hash()
                    ));
                    return;
                }
            }

            if (!empty($_FILES['companyLogo']['name'])) {
                $fileName = strtoupper(trim(str_replace('.', ' ',$companyDatas['companyName']))).'-'.time();
                $companyLogo = $this->_uploadImage('companyLogo', array('file_name' => $fileName, 'upload_path' => FCPATH . 'uploads/logos/'));
                if ($companyLogo['status']) {
                    $this->_deleteImage($this->input->post('companyId'), 'companyLogo', FCPATH . 'uploads/logos/');
                    $companyDatas['companyLogo'] = $companyLogo['data']['file_name'];
                } else {
                    echo json_encode(array(
                        'status' => 'failed', 
                        'failedMsg' => 'upload failed', 
                        'errorMsg' => $companyLogo['error'], 
                        'csrfToken' => $this->security->get_csrf_hash()));
                    return;
                }
            }

            if (!empty($_FILES['companyPhoto']['name'])) {
                $fileName = strtoupper(trim(str_replace('.', ' ',$companyDatas['companyName']))).'-'.time();
                $companyPhoto = $this->_uploadImage('companyPhoto', array('file_name' => $fileName, 'upload_path' => FCPATH . 'uploads/photos/'));
                if ($companyPhoto['status']) {
                    $this->_deleteImage($this->input->post('companyId'), 'companyPhoto', FCPATH . 'uploads/photos/');
                    $companyDatas['companyPhoto'] = $companyPhoto['data']['file_name'];
                } else {
                    echo json_encode(array(
                        'status' => 'failed', 
                        'failedMsg' => 'upload failed', 
                        'errorMsg' => $companyPhoto['error'], 
                        'csrfToken' => $this->security->get_csrf_hash()));
                    return;
                }
            }


            $this->load->model('M_admins');
            $adminId = $this->session->userdata('adminId');
            $adminDatas = array(
                'adminName' =>  htmlspecialchars($this->input->post('adminName'), ENT_COMPAT)
            );

            $this->load->model('M_dashboard');
            $currentAdminEmail = htmlspecialchars($this->input->post('currentAdminEmail'));
            $adminEmail = htmlspecialchars($this->input->post('adminEmail'));
            if ($adminEmail !== $currentAdminEmail) {
                $checkEmail = $this->M_dashboard->checkAdminEmailAvailability($adminEmail);
                if (!empty($checkEmail)) {
                    echo json_encode(array(
                        'status' => 'failed',
                        'failedMsg' => 'email used',
                        'csrfToken' => $this->security->get_csrf_hash()
                    ));
                    return;
                }
                $adminDatas['adminEmail'] = $adminEmail;
            }

            $currentAdminPassword = $this->input->post('currentPassword');
            if (!empty($currentAdminPassword)) {
                $checkAdmin = $this->M_admins->checkAdmin('adminId', $adminId);
                if (!password_verify($currentAdminPassword, $checkAdmin['adminPassword'])) {
                    echo json_encode(array(
                        'status' => 'failed',
                        'failedMsg' => 'current password is incorrect',
                        'csrfToken' => $this->security->get_csrf_hash()
                    ));
                    return;
                }
                $adminDatas['adminPassword'] = password_hash($this->input->post('newPassword'), PASSWORD_DEFAULT);
            }

            $this->db->trans_start();
            $this->M_admins->updateAdmin($adminId, $adminDatas);
            $this->M_companies->updateCompany($companyId, $companyDatas);
            $this->db->trans_complete();

            $adminDatas = $this->M_admins->checkAdmin('adminId', $adminId);
            $this->_initCompanySession($adminDatas);

            echo json_encode(array('status' => 'success', 'csrfToken' => $this->security->get_csrf_hash()));
        }
    }

}

/* End of file Dashboard.php */

?>