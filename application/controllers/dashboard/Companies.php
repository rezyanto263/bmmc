<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Companies extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('adminRole') != ('admin') && $this->session->userdata('adminRole') != ('company')) {
            redirect('dashboard');
        }

        $this->load->model('M_companies');
    }
    

    public function index()
    {
        $datas = array(
            'title' => 'BIM Dashboard | Companies',
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

    public function addCompany() {
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
            echo json_encode(array('status' => 'invalid', 'errors' => $errors));
        } else {
            $checkCompanyCoordinate = $this->M_companies->checkCompany('companyCoordinate', $this->input->post('companyCoordinate'));
            if (!$checkCompanyCoordinate) {
                $companyDatas = array(
                    'companyName' => $this->input->post('companyName'),
                    'adminId' => $this->input->post('adminId') ?: NULL,
                    'companyPhone' => htmlspecialchars($this->input->post('companyPhone')),
                    'companyAddress' => $this->input->post('companyAddress'),
                    'companyCoordinate' => $this->input->post('companyCoordinate')
                );

                if ($_FILES['companyLogo']['name']) {
                    $fileName = strtoupper(trim(str_replace('.', ' ',$companyDatas['companyName']))).'-'.time();
                    $companyLogo = $this->_uploadLogo('companyLogo', array('file_name' => $fileName));
                    if ($companyLogo['status']) {
                        $companyDatas['companyLogo'] = $companyLogo['data']['file_name'];
                        $this->M_companies->insertCompany($companyDatas);
                        echo json_encode(array('status' => 'success'));
                    } else {
                        echo json_encode(array('status' => 'failed', 'failedMsg' => 'upload failed', 'errorMsg' => $companyLogo['error']));
                    }
                } else {
                    $this->M_companies->insertCompany($companyDatas);
                    echo json_encode(array('status' => 'success'));
                }
            } else {
                echo json_encode(array('status' => 'failed', 'failedMsg' => 'coordinate used'));
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

    private function _deleteLogo($companyId) {
        $companyDatas = $this->M_companies->checkCompany('companyId', $companyId);
        unlink(FCPATH . 'uploads/logos/' . $companyDatas['companyLogo']);
    }

    public function editCompany() {
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
                    'required' => 'Company should provide a %s.',
                    'regex_match' => 'The %s field must contain valid latitude and longitude coordinates.'
                )
            ),
        );
        $this->form_validation->set_rules($validate);

        if ($this->form_validation->run() == FALSE) {
            $errors = $this->form_validation->error_array();
            echo json_encode(array('status' => 'invalid', 'errors' => $errors));
        } else {
            $companyCoordinate = $this->input->post('companyCoordinate');

            $companyDatas = array(
                'companyName' => $this->input->post('companyName'),
                'adminId' => $this->input->post('adminId') ?: NULL,
                'companyPhone' => htmlspecialchars($this->input->post('companyPhone')),
                'companyAddress' => $this->input->post('companyAddress'),
            );

            if ($companyCoordinate) {
                $checkCompanyCoordinate = $this->M_companies->checkCompany('companyCoordinate', $companyCoordinate);
                if (!$checkCompanyCoordinate) {
                    $companyDatas['companyCoordinate'] = $companyCoordinate;
                    if ($_FILES['companyLogo']['name']) {
                        $fileName = strtoupper(trim(str_replace('.', ' ', $companyDatas['companyName']))).'-'.time();
                        $companyLogo = $this->_uploadLogo('companyLogo', array('file_name' => $fileName));
                        if ($companyLogo['status']) {
                            $companyDatas['companyLogo'] = $companyLogo['data']['file_name'];
                            $this->M_companies->updateCompany($this->input->post('companyId') ,$companyDatas);
                            echo json_encode(array('status' => 'success'));
                        } else {
                            echo json_encode(array('status' => 'failed', 'failedMsg' => 'upload failed', 'errorMsg' => $companyLogo['error']));
                        }
                    } else {
                        $this->M_companies->updateCompany($this->input->post('companyId'), $companyDatas);
                        echo json_encode(array('status' => 'success'));
                    }
                } else {
                    echo json_encode(array('status' => 'failed', 'failedMsg' => 'coordinate used'));
                }
            } else {
                if ($_FILES['companyLogo']['name']) {
                    $fileName = strtoupper(trim($companyDatas['companyName'])).'-'.time();
                    $companyLogo = $this->_uploadLogo('companyLogo', array('file_name' => $fileName));
                    if ($companyLogo['status']) {
                        $this->_deleteLogo($this->input->post('companyId'));
                        $companyDatas['companyLogo'] = $companyLogo['data']['file_name'];
                        $this->M_companies->updateCompany($this->input->post('companyId') ,$companyDatas);
                        echo json_encode(array('status' => 'success'));
                    } else {
                        echo json_encode(array('status' => 'failed', 'failedMsg' => 'upload failed', 'errorMsg' => $companyLogo['error']));
                    }
                } else {
                    $this->M_companies->updateCompany($this->input->post('companyId'), $companyDatas);
                    echo json_encode(array('status' => 'success'));
                }
            }
        }
    }

    public function deleteCompany() {
        $companyId = $this->input->post('companyId');
        $this->_deleteLogo($companyId);
        $this->M_companies->deleteCompany($companyId);

        echo json_encode(array('status' => 'success'));
    }

    public function scanQR() {
        $qrInput = $this->input->post('qrData');
        if (!$qrInput) {
            echo json_encode(array(
                'status' => 'failed',
                'failedMsg' => 'qr data missing'
            ));
            return;
        }
    
        $decodedData = base64_decode($qrInput, true);
        if ($decodedData === false) {
            echo json_encode(array(
                'status' => 'failed',
                'failedMsg' => 'invalid qr'
            ));
            return;
        }
        
        $qrData = explode('-', $decodedData);
        if (!(count($qrData) == 2)) {
            echo json_encode(array(
                'status' => 'failed',
                'failedMsg' => 'incorrect format qr data'
            ));
            return;
        }
        
        $NIK = trim($qrData[0]) ?: NULL;
        $role = trim($qrData[1]) ?: NULL;
        if (!$NIK || !$role) {
            echo json_encode(array(
                'status' => 'failed',
                'failedMsg' => 'incomplete qr data'
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
            ));
        } else {
            echo json_encode(array(
                'status' => 'failed',
                'failedMsg' => 'scan not found'
            ));
        }
    }

}

/* End of file Companies.php */

?>