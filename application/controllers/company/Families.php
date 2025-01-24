<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Families extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('adminRole') != 'company') {
            redirect('dashboard/login');
        }

        $this->load->model('M_families');
        $adminId = $this->session->userdata('adminId');
        $companyData = $this->M_families->getCompanyByAdminId($adminId);
    }
    

    public function index() {
        $employeeNIK = $this->session->userdata('employeeNIK');
        
        $employeeName = $this->M_families->getEmployeeNameByNIK($employeeNIK);
        $datas = array(
            'title' => 'BMMC Company | Families',
            'subtitle' =>  'Families',
            'contentType' => 'dashboard'
        );

        $partials = array(
            'head' => 'partials/head',
            'sidebar' => 'partials/company/sidebar',
            'floatingMenu' => 'partials/floatingMenu',
            'contentHeader' => 'partials/contentHeader',
            'contentBody' => 'company/families',
            'footer' => 'partials/dashboard/footer',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }
    
    public function getAllFamilyDatas() {
        $companyId = $this->session->userdata('companyId');
        $familyDatas = $this->M_families->getAllFamilyDatas($companyId);
        $datas = array(
            'data' => $familyDatas
        );

        echo json_encode($datas);
    }

    public function getFamiliesByEmployeeNIK() {
        $employeeNIK = $this->input->get('nik');
        $familyDatas = $this->M_families->getFamiliesByEmployeeNIK($employeeNIK);
        $datas = array(
            'data' => $familyDatas
        );

        echo json_encode($datas);
    }
    
    public function addFamily() {
        $validate = array(
            array(
                'field' => 'familyName',
                'label' => 'Name',
                'rules' => 'required',
                'errors' => array(
                    'required' => 'Family should provide a %s.'
                )
            ),
            array(
                'field' => 'employeeNIK',
                'label' => 'Employee',
                'rules' => 'required|trim|numeric',
                'errors' => array(
                    'required' => 'Family should provide a %s.',
                    'numeric' => 'Employee %s should be a number.'
                )
            ),
            array(
                'field' => 'familyNIK',
                'label' => 'NIK',
                'rules' => 'required|trim|numeric',
                'errors' => array(
                    'required' => 'Family should provide a %s.',
                    'numeric' => 'Employee %s should be a number.'
                )
            ),
            array(
                'field' => 'familyEmail',
                'label' => 'Email',
                'rules' => 'required|trim|valid_email',
                'errors' => array(
                    'required' => 'Family should provide a %s.',
                    'valid_email' => 'The %s field must contain a valid email address.'
                )
            ),
            array(
                'field' => 'familyPhone',
                'label' => 'Phone',
                'rules' => 'required|trim|numeric',
                'errors' => array(
                    'required' => 'Family should provide a %s.',
                    'numeric' => 'Employee %s should be a number.'
                )
            ),
            array(
                'field' => 'familyBirth',
                'label' => 'Birth Date',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Family should provide a %s.',
                )
            ),
            array(
                'field' => 'familyGender',
                'label' => 'Gender',
                'rules' => 'required|trim|in_list[male,female]',
                'errors' => array(
                    'required' => 'Family should provide a %s.',
                    'in_list' => 'Invalid selection. Please choose a valid option from the list.'
                )
            ),
            array(
                'field' => 'familyAddress',
                'label' => 'Address',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Family should provide a %s.',
                )
            ),
        );
    
        $this->form_validation->set_rules($validate);
    
        if ($this->form_validation->run() == FALSE) {
            $errors = $this->form_validation->error_array();
            echo json_encode(array('status' => 'invalid', 'errors' => $errors, 'csrfToken' => $this->security->get_csrf_hash()));
        } else {
            $familyPassword = uniqid();
            $familyData = array(
                'familyNIK' => htmlspecialchars($this->input->post('familyNIK')),
                'employeeNIK' => htmlspecialchars($this->input->post('employeeNIK')),
                'familyName' => htmlspecialchars($this->input->post('familyName'), ENT_COMPAT),
                'familyEmail' => htmlspecialchars($this->input->post('familyEmail')),
                'familyPassword' => password_hash($familyPassword, PASSWORD_DEFAULT),
                'familyBirth' => htmlspecialchars($this->input->post('familyBirth')),
                'familyGender' => htmlspecialchars($this->input->post('familyGender')),
                'familyAddress' => htmlspecialchars($this->input->post('familyAddress'), ENT_COMPAT),
            );

            if ($_FILES['familyPhoto']['name']) {
                $photoFileName = strtoupper(trim(str_replace('.', ' ',$familyData['familyName']))).'-'.time();
                $familyPhoto = $this->_uploadImage('familyPhoto', array('file_name' => $photoFileName, 'upload_path' => FCPATH . 'uploads/profiles/'));
                if ($familyPhoto['status']) {
                    $familyData['familyPhoto'] = $familyPhoto['data']['file_name'];
                } else {
                    echo json_encode(array(
                        'status' => 'failed', 
                        'failedMsg' => 
                        'upload failed', 
                        'errorMsg' => $familyPhoto['error'], 
                        'csrfToken' => $this->security->get_csrf_hash()
                    ));
                    return;
                }
            }

            $this->load->library('sendemail');

            $datas = array(
                'accountName' => $familyData['familyName'],
                'accountEmail' => $familyData['familyEmail'],
                'accountPassword' => $familyPassword,
                'bmmcEmail' => 'testbmmc@gmail.com'
            );

            $subject = 'Login & Reset your password account';
            $body = $this->load->view('company/newAccountEmail', $datas, TRUE);

            if ($this->sendemail->send($familyData['familyEmail'], $subject, $body)) {
                $this->M_families->insertFamily($familyData);
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
    
    public function editFamily() {
        $validate = array(
            array(
                'field' => 'familyName',
                'label' => 'Name',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Family should provide a %s.'
                )
            ),
            array(
                'field' => 'familyEmail',
                'label' => 'Email',
                'rules' => 'required|trim|valid_email',
                'errors' => array(
                    'required' => 'Family should provide a %s.',
                    'valid_email' => 'The %s field must contain a valid email address.'
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
                    'matches' => '%s does not match the Password.'
                )
            )
        );
    
        $this->form_validation->set_rules($validate);
    
        if ($this->form_validation->run() == FALSE) {
            $errors = $this->form_validation->error_array();
            echo json_encode(array('status' => 'invalid', 'errors' => $errors, 'csrfToken' => $this->security->get_csrf_hash()));
        } else {
            $familyNIK = htmlspecialchars($this->input->post('familyNIK'));
            $newPassword = htmlspecialchars($this->input->post('newPassword') ?: '') ?: NULL;
            $newFamilyNIK = htmlspecialchars($this->input->post('newFamilyNIK') ?: '') ?: NULL;

            $familyData = array(
                'familyNIK' => $this->input->post('familyNIK'),
                'familyName' => $this->input->post('familyName'),
                'familyEmail' => $this->input->post('familyEmail'),
                'familyAddress' => $this->input->post('familyAddress'),
                'familyBirth' => $this->input->post('familyBirth'),
                'familyGender' => $this->input->post('familyGender')
            );
            !empty($newFamilyNIK) && $familyData['familyNIK'] = $newFamilyNIK;
            !empty($newPassword) && $familyData['familyPassword'] = $newPassword;

            if (!empty($_FILES['familyPhoto']['name'])) {
                $photoFileName = strtoupper(trim(str_replace('.', ' ', $familyData['familyName']))) . '-' . time();
                $familyPhoto = $this->_uploadImage('familyPhoto', array('file_name' => $photoFileName, 'upload_path' => FCPATH . 'uploads/profiles/'));
                if ($familyPhoto['status']) {
                    $existingFamily = $this->M_families->checkFamily('familyNIK', $familyNIK);
                    if (!empty($existingFamily['familyPhoto'])) {
                        $this->_deleteImage($existingFamily['familyPhoto'], FCPATH . 'uploads/profiles/');
                    }
                    $familyData['familyPhoto'] = $familyPhoto['data']['file_name'];
                } else {
                    echo json_encode(array('status' => 'failed', 'failedMsg' => 'upload failed', 'errorMsg' => $familyPhoto['error'], 'csrfToken' => $this->security->get_csrf_hash()));
                    return;
                }
            }
    
            $this->M_families->updateFamily($familyNIK, $familyData);
            echo json_encode(array('status' => 'success', 'csrfToken' => $this->security->get_csrf_hash()));
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

    private function _deleteImage($familyNIK, $field, $path) {
        $familyDatas = $this->M_families->checkFamily('familyNIK', $familyNIK );
        $familyDatas[$field] && unlink($path . $familyDatas[$field]);
    }
    
    public function deleteFamily() {
        $familyNIK = $this->input->post('familyNIK');

        $this->load->model('M_historyhealth');
        $familyHasHistoryHealth = $this->M_historyhealth->getHistoryHealthByPatientNIK($familyNIK);

        if ($familyHasHistoryHealth) {
            echo json_encode(array(
                'status' => 'failed', 
                'failedMsg' => 'can not delete linked data', 
                'csrfToken' => $this->security->get_csrf_hash()
            ));
            return;
        }

        $this->M_families->deleteFamily($familyNIK);
        echo json_encode(array('status' => 'success', 'csrfToken' => $this->security->get_csrf_hash()));
    }    
}

/* End of file Companies.php */

?>