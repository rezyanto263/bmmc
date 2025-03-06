<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

use chillerlan\QRCode\Data\QRMatrix;
use chillerlan\QRCode\Common\EccLevel;
use chillerlan\QRCode\Output\QRGdImagePNG;
use chillerlan\QRCode\{QRCode, QROptions};
use chillerlan\QRCode\Output\QROutputInterface;
use chillerlan\QRCode\Output\QRCodeOutputException;

require_once APPPATH . 'libraries/QRWithLogo.php';

class Profile extends CI_Controller {    

    public function __construct()
    {
        parent::__construct();
        if (!in_array($this->session->userdata('userRole'), ['employee', 'family'])) {
            redirect('login');
        }

        $this->load->model('M_auth');
        $this->load->model('M_healthhistories');
    }

    public function index() {
        $userData = $this->M_auth->checkUser('userNIK', $this->session->userdata('userNIK'));
        $this->_initSession($userData);

        $employeeNIK = $userData['employeeNIK'];
        $userNIK = $userData['userNIK'];
        $userRole = $userData['userRole'];

        $this->load->library('encryption');
        $qrData = $this->encryption->encrypt($userNIK . '-' . $userRole);

        $this->load->model('M_families');
        $families = $this->M_families->getFamiliesByEmployeeNIK($employeeNIK);

        $insuranceMembers = 1;
        foreach ($families as $family) {
            if (!in_array($family['familyStatus'], ['archived', 'unverified'])) {
                $insuranceMembers += 1;
            }
        }

        $this->load->model('M_insurances');
        $insurances = array_merge($this->M_insurances->getInsuranceDetailsByEmployeeNIK($employeeNIK), array('insuranceMembers' => $insuranceMembers));

        $datas = array(
            'title' => 'BMMC | Profile',
            'subtitle' => 'Profile',
            'contentType' => 'user',
            'qr' => $this->generateQR($qrData),
            'insurance' => $insurances,
            'families' => $families
        );

        $partials = array(
            'head' => 'partials/head',
            'navbar' => 'partials/user/navbar',
            'content' => 'user/profile',
            'footer' => 'partials/user/footer',
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

    private function _deleteImage($userNIK, $field, $path) {
        $userDatas = $this->M_auth->checkUser('userNIK', $userNIK);
        $userDatas[$field] && unlink($path . $userDatas[$field]);
    }

    private function _initSession($userDatas) {
        $sessionDatas = array(
            'employeeNIK' => $userDatas['employeeNIK'],
            'insuranceId' => $userDatas['insuranceId'],
            'userNIK' => $userDatas['userNIK'],
            'userPhoto' => $userDatas['userPhoto'],
            'userName' => $userDatas['userName'],
            'userEmail' => $userDatas['userEmail'],
            'userPhone' => $userDatas['userPhone'],
            'userBirth' => $userDatas['userBirth'],
            'userGender' => $userDatas['userGender'],
            'userDepartment' => $userDatas['userDepartment'],
            'userBand' => $userDatas['userBand'],
            'userRelationship' => $userDatas['userRelationship'],
            'userRole' => $userDatas['userRole'],
            'userStatus' => $userDatas['userStatus'],
            'userAddress' => $userDatas['userAddress'],
        );

        $this->session->set_userdata($sessionDatas);
    }

    public function getAllInsuranceMembersHealhtHistoriesByUserNIK() {
        $userNIK = $this->session->userdata('userNIK');
        $healthhistoriesDatas = $this->M_healthhistories->getAllInsuranceMembersHealhtHistoriesByUserNIK($userNIK);
        $datas = array(
            'data' => $healthhistoriesDatas
        );

        echo json_encode($datas);
    }

    public function generateQR(String $data) {
        $options = new QROptions;
        $options->version             = 14;
        $options->outputType          = QROutputInterface::GDIMAGE_PNG;
        $options->scale               = 15;
        $options->outputBase64        = false;
        $options->eccLevel            = EccLevel::H;
        $options->addLogoSpace        = true;
        $options->logoSpaceWidth      = 16;
        $options->logoSpaceHeight     = 16;
        $options->imageTransparent    = true;
        $options->addQuietzone        = false;
        $options->drawLightModules    = false;
        $options->cornerRadius        = 10;
        $options->keepAsSquare        = [
            QRMatrix::M_FINDER_DARK,
            QRMatrix::M_FINDER_DOT,
            QRMatrix::M_ALIGNMENT_DARK,
        ];
        $options->moduleValues        = [
            QRMatrix::M_DARKMODULE       => [69,69,69],
            QRMatrix::M_DATA_DARK        => [69,69,69],
            QRMatrix::M_FINDER_DARK      => [69,69,69],
            QRMatrix::M_SEPARATOR_DARK   => [69,69,69],
            QRMatrix::M_ALIGNMENT_DARK   => [69,69,69],
            QRMatrix::M_TIMING_DARK      => [69,69,69],
            QRMatrix::M_FORMAT_DARK      => [69,69,69],
            QRMatrix::M_VERSION_DARK     => [69,69,69],
            QRMatrix::M_QUIETZONE_DARK   => [69,69,69],
            QRMatrix::M_LOGO_DARK        => [69,69,69],
            QRMatrix::M_FINDER_DOT       => [69,69,69],
        ];

        $qrcode = new QRCode($options);
        $qrcode->render($data);

        $qrOutputInterface = new QRWithLogo($options, $qrcode->getQRMatrix());

        $data =  $qrOutputInterface->dump(null, FCPATH . 'assets/images/logo.png');
        return $data;
    }

    public function editProfile() {
        $userNIK = $this->session->userdata('userNIK');
        $userRole = $this->session->userdata('userRole');
        $currentUserData = $this->M_auth->checkUser('userNIK', $userNIK);
        $userData = [];

        if (!empty($this->input->post('currentPassword'))) {
            $validate = array(
                array(
                    'field' => 'currentPassword',
                    'label' => 'Current Password',
                    'rules' => 'trim',
                    'errors' => array(
                        'required' => '%s is required to proceed with the update.'
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
                echo json_encode(array('status' => 'invalid', 'errors' => $errors));
                return;
            }

            
            $currentPassword = $this->input->post('currentPassword');
            $newPassword = $this->input->post('newPassword');
            if (!empty($newPassword) && password_verify($currentPassword, $currentUserData['userPassword'])) {
                $userData[$userRole . 'Password'] = password_hash($newPassword, PASSWORD_DEFAULT);
            }
        }

        if (!empty($_FILES['userPhoto']['name'])) {
            $photoFileName = strtoupper(trim(str_replace('.', ' ', $userData['userName']))) . '-' . time();
            $userPhoto = $this->_uploadImage('userPhoto', array('file_name' => $photoFileName, 'upload_path' => FCPATH . 'uploads/profiles/'));
            if ($userPhoto['status']) {
                if (!empty($currentUserData['userPhoto'])) {
                    $this->_deleteImage($userNIK, FCPATH . 'uploads/profiles/');
                }
                $userData[$userRole . 'Photo'] = $userPhoto['data']['file_name'];
            } else {
                echo json_encode(array('status' => 'failed', 'failedMsg' => 'upload failed', 'errorMsg' => $userPhoto['error'], 'csrfToken' => $this->security->get_csrf_hash()));
                return;
            }
        }

        $this->M_auth->updateProfile($userNIK, $userRole, $userData);
        $newUserData = $this->M_auth->checkUser('userNIK', $userNIK);
        $this->_initSession($newUserData);
        echo json_encode(array('status' => 'success', 'csrfToken' => $this->security->get_csrf_hash()));
    }

}


/* End of file Profile.php */

?>