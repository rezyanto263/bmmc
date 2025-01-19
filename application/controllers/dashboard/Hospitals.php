<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Hospitals extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // if ($this->session->userdata('adminRole') != 'admin') {
        //     redirect('dashboard');
        // }

        $this->load->model('M_hospitals');
    }    

    public function index() {
        $datas = array(
            'title' => 'BMMC Dashboard | Hospitals',
            'subtitle' => 'Hospitals',
            'contentType' => 'dashboard'
        );

        $partials = array(
            'head' => 'partials/head',
            'sidebar' => 'partials/dashboard/sidebar',
            'floatingMenu' => 'partials/floatingMenu',
            'contentHeader' => 'partials/contentHeader',
            'contentBody' => 'dashboard/hospitals',
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

    public function getPatientHistoryHealthDetailsByNIK($patientNIK) {
        $historyhealthDatas = $this->M_hospitals->getPatientHistoryHealthDetailsByNIK($patientNIK);
        $datas = array(
            'data' => $historyhealthDatas
        );

        echo json_encode($datas);
    }

    public function addHospital() {
        $validate = array(
            array(
                'field' => 'adminId',
                'label' => 'Admin',
                'rules' => 'required',
                'errors' => array(
                    'required' => 'Hospital should provide a %s.'
                )
            ),
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
            echo json_encode(array('status' => 'invalid', 'errors' => $errors, 'csrfToken' => $this->security->get_csrf_hash()));
        } else {
            $checkHospitalCoordinate = $this->M_hospitals->checkHospital('hospitalCoordinate', $this->input->post('hospitalCoordinate'));
            if (!$checkHospitalCoordinate) {
                $hospitalDatas = array(
                    'hospitalName' => $this->input->post('hospitalName'),
                    'adminId' => $this->input->post('adminId'),
                    'hospitalPhone' => htmlspecialchars($this->input->post('hospitalPhone')),
                    'hospitalAddress' => $this->input->post('hospitalAddress'),
                    'hospitalCoordinate' => $this->input->post('hospitalCoordinate'),
                    'hospitalStatus' => $this->input->post('hospitalStatus')
                );

                if ($_FILES['hospitalLogo']['name']) {
                    $fileName = strtoupper(trim(str_replace('.', ' ',$hospitalDatas['hospitalName']))).'-'.time();
                    $hospitalLogo = $this->_uploadImage('hospitalLogo', array('file_name' => $fileName, 'upload_path' => FCPATH . 'uploads/logos/'));
                    if ($hospitalLogo['status']) {
                        $hospitalDatas['hospitalLogo'] = $hospitalLogo['data']['file_name'];
                    } else {
                        echo json_encode(array('status' => 'failed', 'failedMsg' => 'upload failed', 'errorMsg' => $hospitalLogo['error'], 'csrfToken' => $this->security->get_csrf_hash()));
                        return;
                    }
                }

                if ($_FILES['hospitalPhoto']['name']) {
                    $fileName = strtoupper(trim(str_replace('.', ' ',$hospitalDatas['hospitalName']))).'-'.time();
                    $hospitalPhoto = $this->_uploadImage('hospitalPhoto', array('file_name' => $fileName, 'upload_path' => FCPATH . 'uploads/photos/'));
                    if ($hospitalPhoto['status']) {
                        $hospitalDatas['hospitalPhoto'] = $hospitalPhoto['data']['file_name'];
                    } else {
                        echo json_encode(array('status' => 'failed', 'failedMsg' => 'upload failed', 'errorMsg' => $hospitalPhoto['error'], 'csrfToken' => $this->security->get_csrf_hash()));
                        return;
                    }
                }

                $this->M_hospitals->insertHospital($hospitalDatas);
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

    private function _deleteImage($hospitalId, $field, $path) {
        $hospitalDatas = $this->M_hospitals->checkHospital('hospitalId', $hospitalId);
        $hospitalDatas[$field] && unlink($path . $hospitalDatas[$field]);
    }

    public function editHospital() {
        $validate = array(
            array(
                'field' => 'adminId',
                'label' => 'Admin',
                'rules' => 'required',
                'errors' => array(
                    'required' => 'Hospital should provide a %s.'
                )
            ),
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
                    'regex_match' => 'The %s field must contain valid latitude and longitude coordinates.'
                )
            ),
        );
        $this->form_validation->set_rules($validate);

        if ($this->form_validation->run() == FALSE) {
            $errors = $this->form_validation->error_array();
            echo json_encode(array('status' => 'invalid', 'errors' => $errors, 'csrfToken' => $this->security->get_csrf_hash()));
        } else {
            $hospitalCoordinate = $this->input->post('hospitalCoordinate');

            $hospitalDatas = array(
                'hospitalName' => $this->input->post('hospitalName'),
                'adminId' => $this->input->post('adminId') ?: NULL,
                'hospitalPhone' => htmlspecialchars($this->input->post('hospitalPhone')),
                'hospitalAddress' => $this->input->post('hospitalAddress'),
                'hospitalStatus' => $this->input->post('hospitalStatus')
            );

            if ($hospitalCoordinate) {
                $checkHospitalCoordinate = $this->M_hospitals->checkHospital('hospitalCoordinate', $hospitalCoordinate);
                if (!$checkHospitalCoordinate) {
                    $hospitalDatas['hospitalCoordinate'] = $hospitalCoordinate;
                } else {
                    echo json_encode(array('status' => 'failed', 'failedMsg' => 'coordinate used', 'csrfToken' => $this->security->get_csrf_hash()));
                    return;
                }
            }

            if ($_FILES['hospitalLogo']['name']) {
                $logoFileName = strtoupper(trim(str_replace('.', ' ', $hospitalDatas['hospitalName']))).'-'.time();
                $hospitalLogo = $this->_uploadImage('hospitalLogo', array('file_name' => $logoFileName, 'upload_path' => FCPATH . 'uploads/logos/'));
                if ($hospitalLogo['status']) {
                    $this->_deleteImage($this->input->post('hospitalId'), 'hospitalLogo', FCPATH . 'uploads/logos/');
                    $hospitalDatas['hospitalLogo'] = $hospitalLogo['data']['file_name'];
                } else {
                    echo json_encode(array('status' => 'failed', 'failedMsg' => 'upload failed', 'errorMsg' => $hospitalLogo['error'], 'csrfToken' => $this->security->get_csrf_hash()));
                    return;
                }
            }

            if ($_FILES['hospitalPhoto']['name']) {
                $photoFileName = strtoupper(trim(str_replace('.', ' ', $hospitalDatas['hospitalName']))).'-'.time();
                $hospitalPhoto = $this->_uploadImage('hospitalPhoto', array('file_name' => $photoFileName, 'upload_path' => FCPATH . 'uploads/photos/'));
                if ($hospitalPhoto['status']) {
                    $this->_deleteImage($this->input->post('hospitalId'), 'hospitalPhoto', FCPATH . 'uploads/photos/');
                    $hospitalDatas['hospitalPhoto'] = $hospitalPhoto['data']['file_name'];
                } else {
                    echo json_encode(array('status' => 'failed', 'failedMsg' => 'upload failed', 'errorMsg' => $hospitalPhoto['error'], 'csrfToken' => $this->security->get_csrf_hash()));
                    return;
                }
            }

            $this->M_hospitals->updateHospital($this->input->post('hospitalId'), $hospitalDatas);
            echo json_encode(array('status' => 'success', 'csrfToken' => $this->security->get_csrf_hash()));
        }
    }

    public function deleteHospital() {
        $hospitalId = $this->input->post('hospitalId');
        $isHospitalHasDoctor = $this->M_hospitals->countHospitalDoctorByHospitalId($hospitalId);
        if (!$isHospitalHasDoctor) {
            $this->_deleteImage($hospitalId, 'hospitalLogo', FCPATH . 'uploads/logos/');
            $this->_deleteImage($hospitalId, 'hospitalPhoto', FCPATH . 'uploads/photos/');
            $this->M_hospitals->deleteHospital($hospitalId);

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

/* End of file Hospitals.php */

?>