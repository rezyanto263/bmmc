<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

use Ramsey\Uuid\Uuid;

class Companies extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('adminRole') != 'admin') {
            redirect('dashboard/login');
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
            'floatingMenu' => 'partials/floatingMenu',
            'contentHeader' => 'partials/contentHeader',
            'contentBody' => 'dashboard/companies',
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
            if (empty($checkCompanyCoordinate)) {
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

                $this->load->model('M_admins');
                $adminDatas = $this->M_admins->checkAdmin('adminId', $companyDatas['adminId']);
                $adminPassword = strtoupper(uniqid());

                $datas = array(
                    'accountName' => $adminDatas['adminName'],
                    'accountEmail' => $adminDatas['adminEmail'],
                    'accountPassword' => $adminPassword,
                    'supportEmail' => $_ENV['SUPPORT_EMAIL']
                );

                $subject = 'Activate Your Company Account on BMMC Partner Website';
                $body = $this->load->view('email/newAccountEmail', $datas, TRUE);

                $this->load->library('sendemail');
                if ($this->sendemail->send($adminDatas['adminEmail'], $subject, $body)) {
                    $this->M_admins->updateAdmin($companyDatas['adminId'], array('adminPassword' => password_hash($adminPassword, PASSWORD_DEFAULT)));
                    $this->M_companies->insertCompany($companyDatas, $billingDatas);
                    echo json_encode(array('status' => 'success', 'csrfToken' => $this->security->get_csrf_hash()));
                } else {
                    echo json_encode(array(
                        'status' => 'failed',
                        'failedMsg' => 'send email failed',
                        'csrfToken' => $this->security->get_csrf_hash()
                    ));
                }
            } else {
                echo json_encode(array('status' => 'failed', 'failedMsg' => 'coordinate used', 'csrfToken' => $this->security->get_csrf_hash()));
            }
        }
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
            echo json_encode(array(
                'status' => 'invalid', 
                'errors' => $errors, 
                'csrfToken' => $this->security->get_csrf_hash()
            ));
            return;
        } else {
            $companyCoordinate = htmlspecialchars($this->input->post('companyCoordinate') ?: '') ?: NULL;
            $companyStatus = htmlspecialchars($this->input->post('companyStatus') ?: '') ?: NULL;

            $companyDatas = array(
                'companyName' => htmlspecialchars($this->input->post('companyName'), ENT_COMPAT),
                'companyPhone' => htmlspecialchars($this->input->post('companyPhone')),
                'companyAddress' => htmlspecialchars($this->input->post('companyAddress'), ENT_COMPAT),
            );
            $companyStatus && $companyDatas['companyStatus'] = $companyStatus;

            $billingId = htmlspecialchars($this->input->post('billingId') ?: '') ?: NULL;
            $billingAmount = htmlspecialchars($this->input->post('billingAmount') ?: '') ?: NULL;
            if (!empty($billingId) && !empty($billingAmount)) {
                $this->load->model('M_invoices');
                $totalCurrentBillingUsed = $this->M_invoices->checkCurrentBillingByCompanyId($this->input->post('companyId'))['totalBillingUsed'];
                if ($billingAmount < $totalCurrentBillingUsed) {
                    echo json_encode(array(
                        'status' => 'failed', 
                        'failedMsg' => 'invalid billing amount', 
                        'csrfToken' => $this->security->get_csrf_hash()
                    ));
                    return;
                }
            } else {
                $billingDatas = array(
                    'billingId' => $billingId,
                    'billingAmount' => $billingAmount
                );
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

            $adminId = htmlspecialchars($this->input->post('adminId'));
            $checkCompany = $this->M_companies->checkCompany('companyId', $this->input->post('companyId'));
            if (!empty($checkCompany) && !empty($adminId) && $adminId !== $checkCompany['adminId']) {
                $this->load->model('M_admins');
                $checkAdmin = $this->M_admins->checkAdmin('adminId', $adminId);

                if (!empty($checkAdmin)) {
                    $adminPassword = strtoupper(uniqid());
                    $hashedPassword = password_hash($adminPassword, PASSWORD_DEFAULT);

                    $datas = array(
                        'accountName' => $checkAdmin['adminName'],
                        'accountEmail' => $checkAdmin['adminEmail'],
                        'accountPassword' => $adminPassword,
                        'supportEmail' => $_ENV['SUPPORT_EMAIL']
                    );

                    $subject = 'Activate Your Company Account on BMMC Partner Website';
                    $body = $this->load->view('email/newAccountEmail', $datas, TRUE);

                    $this->load->library('sendemail');
                    if ($this->sendemail->send($checkAdmin['accountEmail'], $subject, $body)) {
                        $this->M_admins->updateAdmin($adminId, array('adminPassword' => $hashedPassword));
                        $companyDatas['adminId'] = $adminId;
                    } else {
                        echo json_encode(array(
                            'status' => 'failed',
                            'failedMsg' => 'send email failed',
                            'csrfToken' => $this->security->get_csrf_hash()
                        ));
                        return;
                    }
                }
            }

            $this->M_companies->updateCompany($this->input->post('companyId'), $companyDatas, $billingDatas);
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


}

/* End of file Companies.php */

?>