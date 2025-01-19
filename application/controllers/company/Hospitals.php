<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Hospitals extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('adminRole') != ('admin' || 'company')) {
            redirect('dashboard');
        }

        $this->load->model('M_hospitals');
        $this->load->model('M_companies');
    }    

    public function index()
    {
        $datas = array(
            'title' => 'BIM Dashboard | Hospitals',
            'subtitle' => 'Hospitals',
            'contentType' => 'dashboard'
        );

        $partials = array(
            'head' => 'partials/head',
            'sidebar' => 'partials/company/sidebar',
            'floatingMenu' => 'partials/floatingMenu',
            'contentHeader' => 'partials/contentHeader',
            'contentBody' => 'company/Hospitals',
            'footer' => 'partials/dashboard/footer',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

    public function getAllHospitalsDatas() {
        $hospitalsDatas = $this->M_hospitals->getAllHospitalsDatas();
        $datas = array(
            'data' => $hospitalsDatas
        );

        echo json_encode($datas);
    }

    public function addHospital() {
        $validate = array(
            array(
                'field' => 'hospitalName',
                'label' => 'Name',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Hospital should provide a %s.'
                )
            ),
            array(
                'field' => 'hospitalPhone',
                'label' => 'Phone',
                'rules' => 'required|trim|numeric|max_length[13]',
                'errors' => array(
                    'required' => 'Hospital should provide a %s.',
                    'numeric' => 'The %s field must contain only numbers.',
                    'max_length' => '%s number max 13 digits in length.',
                )
            ),
            array(
                'field' => 'hospitalAddress',
                'label' => 'Address',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Hospital should provide a %s.'
                )
            ),
            array(
                'field' => 'hospitalCoordinate',
                'label' => 'Coordinate',
                'rules' => 'required|trim|regex_match[/^[-+]?\d{1,2}(\.\d+)?,\s*[-+]?\d{1,3}(\.\d+)?$/]',
                'errors' => array(
                    'required' => 'Hospital should provide a %s.',
                    'regex_match' => 'The %s field must contain valid latitude and longitude coordinates.'
                )
            ),
        );
        $this->form_validation->set_rules($validate);

        if ($this->form_validation->run() == FALSE) {
            $errors = $this->form_validation->error_array();
            echo json_encode(array('status' => 'invalid', 'errors' => $errors));
        } else {
            $checkHospitalCoordinate = $this->M_hospitals->checkHospital('hospitalCoordinate', $this->input->post('hospitalCoordinate'));
            if (!$checkHospitalCoordinate) {
                $hospitalDatas = array(
                    'hospitalName' => $this->input->post('hospitalName'),
                    'adminId' => $this->input->post('adminId') ?: NULL,
                    'hospitalPhone' => htmlspecialchars($this->input->post('hospitalPhone')),
                    'hospitalAddress' => $this->input->post('hospitalAddress'),
                    'hospitalCoordinate' => $this->input->post('hospitalCoordinate')
                );

                if ($_FILES['hospitalLogo']['name']) {
                    $fileName = strtoupper(trim(str_replace('.', ' ',$hospitalDatas['hospitalName']))).'-'.time();
                    $hospitalLogo = $this->_uploadLogo('hospitalLogo', array('file_name' => $fileName));
                    if ($hospitalLogo['status']) {
                        $hospitalDatas['hospitalLogo'] = $hospitalLogo['data']['file_name'];
                        $this->M_hospitals->insertHospital($hospitalDatas);
                        echo json_encode(array('status' => 'success'));
                    } else {
                        echo json_encode(array('status' => 'failed', 'failedMsg' => 'upload failed', 'errorMsg' => $hospitalLogo['error']));
                    }
                } else {
                    $this->M_hospitals->insertHospital($hospitalDatas);
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

    private function _deleteLogo($hospitalId) {
        $hospitalDatas = $this->M_hospitals->checkHospital('hospitalId', $hospitalId);
        unlink(FCPATH . 'uploads/logos/' . $hospitalDatas['hospitalLogo']);
    }

    public function editHospital() {
        $validate = array(
            array(
                'field' => 'hospitalName',
                'label' => 'Name',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Hospital should provide a %s.'
                )
            ),
            array(
                'field' => 'hospitalPhone',
                'label' => 'Phone',
                'rules' => 'required|trim|numeric|max_length[13]',
                'errors' => array(
                    'required' => 'Hospital should provide a %s.',
                    'numeric' => 'The %s field must contain only numbers.',
                    'max_length' => '%s number max 13 digits in length.',
                )
            ),
            array(
                'field' => 'hospitalAddress',
                'label' => 'Address',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Hospital should provide a %s.'
                )
            ),
            array(
                'field' => 'hospitalCoordinate',
                'label' => 'Coordinate',
                'rules' => 'trim|regex_match[/^[-+]?\d{1,2}(\.\d+)?,\s*[-+]?\d{1,3}(\.\d+)?$/]',
                'errors' => array(
                    'required' => 'Hospital should provide a %s.',
                    'regex_match' => 'The %s field must contain valid latitude and longitude coordinates.'
                )
            ),
        );
        $this->form_validation->set_rules($validate);

        if ($this->form_validation->run() == FALSE) {
            $errors = $this->form_validation->error_array();
            echo json_encode(array('status' => 'invalid', 'errors' => $errors));
        } else {
            $hospitalCoordinate = $this->input->post('hospitalCoordinate');

            $hospitalDatas = array(
                'hospitalName' => $this->input->post('hospitalName'),
                'adminId' => $this->input->post('adminId') ?: NULL,
                'hospitalPhone' => htmlspecialchars($this->input->post('hospitalPhone')),
                'hospitalAddress' => $this->input->post('hospitalAddress'),
            );

            if ($hospitalCoordinate) {
                $checkHospitalCoordinate = $this->M_hospitals->checkHospital('hospitalCoordinate', $hospitalCoordinate);
                if (!$checkHospitalCoordinate) {
                    $hospitalDatas['hospitalCoordinate'] = $hospitalCoordinate;
                    if ($_FILES['hospitalLogo']['name']) {
                        $fileName = strtoupper(trim(str_replace('.', ' ', $hospitalDatas['hospitalName']))).'-'.time();
                        $hospitalLogo = $this->_uploadLogo('hospitalLogo', array('file_name' => $fileName));
                        if ($hospitalLogo['status']) {
                            
                            $hospitalDatas['hospitalLogo'] = $hospitalLogo['data']['file_name'];
                            $this->M_hospitals->updateHospital($this->input->post('hospitalId') ,$hospitalDatas);
                            echo json_encode(array('status' => 'success'));
                        } else {
                            echo json_encode(array('status' => 'failed', 'failedMsg' => 'upload failed', 'errorMsg' => $hospitalLogo['error']));
                        }
                    } else {
                        $this->M_hospitals->updateHospital($this->input->post('hospitalId'), $hospitalDatas);
                        echo json_encode(array('status' => 'success'));
                    }
                } else {
                    echo json_encode(array('status' => 'failed', 'failedMsg' => 'coordinate used'));
                }
            } else {
                if ($_FILES['hospitalLogo']['name']) {
                    $fileName = strtoupper(trim($hospitalDatas['hospitalName'])).'-'.time();
                    $hospitalLogo = $this->_uploadLogo('hospitalLogo', array('file_name' => $fileName));
                    if ($hospitalLogo['status']) {
                        $this->_deleteLogo($this->input->post('hospitalId'));
                        $hospitalDatas['hospitalLogo'] = $hospitalLogo['data']['file_name'];
                        $this->M_hospitals->updateHospital($this->input->post('hospitalId') ,$hospitalDatas);
                        echo json_encode(array('status' => 'success'));
                    } else {
                        echo json_encode(array('status' => 'failed', 'failedMsg' => 'upload failed', 'errorMsg' => $hospitalLogo['error']));
                    }
                } else {
                    $this->M_hospitals->updateHospital($this->input->post('hospitalId'), $hospitalDatas);
                    echo json_encode(array('status' => 'success'));
                }
            }
        }
    }

    public function deleteHospital() {
        $hospitalId = $this->input->post('hospitalId');
        $this->_deleteLogo($hospitalId);
        $this->M_hospitals->deleteHospital($hospitalId);

        echo json_encode(array('status' => 'success'));
    }

    // public function getPatientDataByNIK() {
    //     $patientNIK = $this->input->post('patientNIK');
    //     $patient = $this->M_patient->getPatientDataByNIK($patientNIK);
    //     var_dump($patient);
    //     exit;
    //     if ($hospitalDatas) {
    //         $hisealthtalsDatas = $this->M_hisealthtals->getHospitalHisealthtalsDatas('hospitalId', $hospitalDatas['hospitalId']);
    //         $historyhealthIds = array_column($hisealthtalsDatas, 'historyhealthId');
        
    //         if ($historyhealthIds) {
    //             $historiesDatas = $this->M_historyhealth->getHospitalHistoriesDatas($historyhealthIds);
    //             $datas = array(
    //                 'data' => $historiesDatas,
    //             );
    //             echo json_encode($datas);
    //         } else {
    //             echo json_encode(['data' => []]);
    //         }
    //     } else {
    //         echo json_encode(['data' => []]);
    //     }
    // }

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

    public function getCPatientHistoryHealthDetailsByNIK($patientNIK) {
        $historyhealthDatas = $this->M_hospitals->getPatientHistoryHealthDetailsByNIK($patientNIK);
        $datas = array(
            'data' => $historyhealthDatas
        );
        echo json_encode($datas);
    }

}

/* End of file Hospitals.php */

?>