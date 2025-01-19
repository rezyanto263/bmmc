<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

use Ramsey\Uuid\Uuid;

class Companies extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('adminRole') != ('admin' || 'company')) {
            redirect('dashboard');
        }

        $this->load->model('M_companies');
    }
    

    public function index() {
        $datas = array(
            'title' => 'BMMC Dashboard | Companies',
            'subtitle' => 'Companies',
            'contentType' => 'dashboard'
        );

        $partials = array(
            'head' => 'partials/head',
            'sidebar' => 'partials/dashboard/sidebar',
            'floatingMenu' => 'partials/dashboard/floatingMenu',
            'contentHeader' => 'partials/dashboard/contentHeader',
            'contentBody' => 'dashboard/companies',
            'footer' => 'partials/dashboard/footer',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

    public function getAllCompaniesDatas() {
        $companiesDatas = $this->M_companies->getAllCompaniesDatas();
        $datas = array(
            'data' => $companiesDatas
        );

        echo json_encode($datas);
    }

    public function getCompanyDetails() {
        $companyId = $this->input->get('id');
        $companyDatas = $this->M_companies->getCompanyDetails($companyId);
        $datas = array(
            'data' => $companyDatas
        );

        echo json_encode($datas);
    }

    public function addCompany() {
        $validate = array(
            array(
                'field' => 'adminId',
                'label' => 'Admin',
                'rules' => 'required',
                'errors' => array(
                    'required' => 'Company should provide an %s.'
                )
            ),
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
                'rules' => 'required|trim|regex_match[/^[-+]?\d{1,2}(\.\d+)?,\s*[-+]?\d{1,3}(\.\d+)?$/]',
                'errors' => array(
                    'required' => 'Company should provide a %s.',
                    'regex_match' => 'The %s field must contain valid latitude and longitude coordinates.'
                )
            ),
        );
        $this->form_validation->set_rules($validate);

        if ($this->form_validation->run() == FALSE) {
            $errors = $this->form_validation->error_array();
            echo json_encode(array('status' => 'invalid', 'errors' => $errors, 'csrfToken' => $this->security->get_csrf_hash()));
        } else {
            $checkCompanyCoordinate = $this->M_companies->checkCompany('companyCoordinate', $this->input->post('companyCoordinate'));
            if (!$checkCompanyCoordinate) {
                $companyDatas = array(
                    'companyName' => htmlspecialchars($this->input->post('companyName')),
                    'adminId' => htmlspecialchars($this->input->post('adminId')),
                    'companyPhone' => htmlspecialchars($this->input->post('companyPhone')),
                    'companyAddress' => htmlspecialchars($this->input->post('companyAddress')),
                    'companyCoordinate' => htmlspecialchars($this->input->post('companyCoordinate')),
                    'companyStatus' => 'unverified'
                );

                $billingStartedAt = htmlspecialchars(date('Y-m-d', strtotime($this->input->post('billingStartedAt'))));
                $uuid = Uuid::uuid7();
                $billingDatas = array(
                    'billingId' => $uuid->toString(),
                    'billingAmount' => htmlspecialchars($this->input->post('billingAmount')),
                    'billingStartedAt' => $billingStartedAt,
                    'billingEndedAt' => htmlspecialchars(date('Y-m-t', strtotime($billingStartedAt))),
                    'billingStatus' => 'unverified'
                );

                if ($_FILES['companyLogo']['name']) {
                    $logoFileName = strtoupper(trim(str_replace('.', ' ',$companyDatas['companyName']))).'-'.time();
                    $companyLogo = $this->_uploadImage('companyLogo', array('file_name' => $logoFileName, 'upload_path' => FCPATH . 'uploads/logos/'));
                    if ($companyLogo['status']) {
                        $companyDatas['companyLogo'] = $companyLogo['data']['file_name'];
                    } else {
                        echo json_encode(array('status' => 'failed', 'failedMsg' => 'upload failed', 'errorMsg' => $companyLogo['error'], 'csrfToken' => $this->security->get_csrf_hash()));
                        return;
                    }
                }

                if ($_FILES['companyPhoto']['name']) {
                    $photoFileName = strtoupper(trim(str_replace('.', ' ',$companyDatas['companyName']))).'-'.time();
                    $companyPhoto = $this->_uploadImage('companyPhoto', array('file_name' => $photoFileName, 'upload_path' => FCPATH . 'uploads/photos/'));
                    if ($companyPhoto['status']) {
                        $companyDatas['companyPhoto'] = $companyPhoto['data']['file_name'];
                    } else {
                        echo json_encode(array('status' => 'failed', 'failedMsg' => 'upload failed', 'errorMsg' => $companyPhoto['error'], 'csrfToken' => $this->security->get_csrf_hash()));
                        return;
                    }
                }

                $this->M_companies->insertCompany($companyDatas, $billingDatas);
                echo json_encode(array('status' => 'success', 'csrfToken' => $this->security->get_csrf_hash()));
            } else {
                echo json_encode(array('status' => 'failed', 'failedMsg' => 'coordinate used', 'csrfToken' => $this->security->get_csrf_hash()));
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

    private function _deleteImage($companyId, $field, $path) {
        $companyDatas = $this->M_companies->checkCompany('companyId', $companyId);
        !empty($companyDatas[$field]) && unlink($path . $companyDatas[$field]);
    }

    public function editCompany() {
        $validate = array(
            array(
                'field' => 'adminId',
                'label' => 'Admin',
                'rules' => 'required',
                'errors' => array(
                    'required' => 'Company should provide an %s.'
                )
            ),
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
        );
        $this->form_validation->set_rules($validate);

        if ($this->form_validation->run() == FALSE) {
            $errors = $this->form_validation->error_array();
            echo json_encode(array('status' => 'invalid', 'errors' => $errors, 'csrfToken' => $this->security->get_csrf_hash()));
        } else {
            $companyCoordinate = htmlspecialchars($this->input->post('companyCoordinate'));

            $companyDatas = array(
                'companyName' => htmlspecialchars($this->input->post('companyName')),
                'adminId' => htmlspecialchars($this->input->post('adminId')),
                'companyPhone' => htmlspecialchars($this->input->post('companyPhone')),
                'companyAddress' => htmlspecialchars($this->input->post('companyAddress')),
                'companyStatus' => htmlspecialchars($this->input->post('companyStatus'))
            );

            $billingAmount = $this->input->post('billingAmount') ?: NULL;
            $billingDatas = array(
                'billingAmount' => htmlspecialchars($billingAmount),
            );

            if ($_FILES['companyLogo']['name']) {
                $fileName = strtoupper(trim(str_replace('.', ' ',$companyDatas['companyName']))).'-'.time();
                $companyLogo = $this->_uploadImage('companyLogo', array('file_name' => $fileName, 'upload_path' => FCPATH . 'uploads/logos/'));
                if ($companyLogo['status']) {
                    $this->_deleteImage($this->input->post('companyId'), 'companyLogo', FCPATH . 'uploads/logos/');
                    $companyDatas['companyLogo'] = $companyLogo['data']['file_name'];
                } else {
                    echo json_encode(array('status' => 'failed', 'failedMsg' => 'upload failed', 'errorMsg' => $companyLogo['error'], 'csrfToken' => $this->security->get_csrf_hash()));
                    return;
                }
            }

            if ($_FILES['companyPhoto']['name']) {
                $fileName = strtoupper(trim(str_replace('.', ' ',$companyDatas['companyName']))).'-'.time();
                $companyPhoto = $this->_uploadImage('companyPhoto', array('file_name' => $fileName, 'upload_path' => FCPATH . 'uploads/photos/'));
                if ($companyPhoto['status']) {
                    $this->_deleteImage($this->input->post('companyId'), 'companyPhoto', FCPATH . 'uploads/photos/');
                    $companyDatas['companyPhoto'] = $companyPhoto['data']['file_name'];
                } else {
                    echo json_encode(array('status' => 'failed', 'failedMsg' => 'upload failed', 'errorMsg' => $companyPhoto['error'], 'csrfToken' => $this->security->get_csrf_hash()));
                    return;
                }
            }

            if ($companyCoordinate) {
                $checkCompanyCoordinate = $this->M_companies->checkCompany('companyCoordinate', $companyCoordinate);
                if (!$checkCompanyCoordinate) {
                    $companyDatas['companyCoordinate'] = $companyCoordinate;
                } else {
                    echo json_encode(array('status' => 'failed', 'failedMsg' => 'coordinate used', 'csrfToken' => $this->security->get_csrf_hash()));
                    return;
                }
            }

            $this->M_companies->updateCompany($this->input->post('companyId') ,$companyDatas, $billingDatas);
            echo json_encode(array('status' => 'success', 'csrfToken' => $this->security->get_csrf_hash()));
        }
    }

    public function deleteCompany() {
        $companyId = $this->input->post('companyId');
        $isCompanyHasEmployee = $this->M_companies->countEmployeeByCompanyId($companyId);
        if (!$isCompanyHasEmployee) {
            $this->_deleteImage($companyId, 'companyLogo', FCPATH . 'uploads/logos/');
            $this->_deleteImage($companyId, 'companyPhoto', FCPATH . 'uploads/photos/');
            $this->M_companies->deleteCompany($companyId);

            echo json_encode(array('status' => 'success', 'csrfToken' => $this->security->get_csrf_hash()));
        } else {
            echo json_encode(array(
                'status' => 'failed',
                'failedMsg' => 'can not delete linked data',
                'csrfToken' => $this->security->get_csrf_hash()
            ));
        }
    }

    public function scanQR() {
        $qrInput = $this->input->post('qrData');
        if (!$qrInput) {
            echo json_encode(array(
                'status' => 'failed',
                'failedMsg' => 'qr data missing',
                'csrfToken' => $this->security->get_csrf_hash()
            ));
            return;
        }
    
        $decodedData = base64_decode($qrInput, true);
        if ($decodedData === false) {
            echo json_encode(array(
                'status' => 'failed',
                'failedMsg' => 'invalid qr',
                'csrfToken' => $this->security->get_csrf_hash()
            ));
            return;
        }

        
        $qrData = explode('-', $decodedData);
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
    
        $patientData = $role == 'employee' 
            ? $this->M_companies->getEmployeeByNIK($NIK) 
            : $this->M_companies->getFamilyByNIK($NIK);
    
        if ($patientData) {
            echo json_encode(array(
                'status' => 'success',
                'data' => $patientData,
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
    

}

/* End of file Companies.php */

?>