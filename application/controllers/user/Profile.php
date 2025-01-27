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
        
        // Check if the user is logged in by verifying session data
        if ($this->session->userdata('userType') != 'employee' && $this->session->userdata('userType') != 'family') {
            redirect('login');
        }

        $this->load->model('M_auth');
        $this->load->model('M_historyhealth');
    }

    public function index()
    {
        $userType = $this->session->userdata('userType');
        if ($userType == 'employee') {
            // Use session data for the logged-in employee
            $employeeId = $this->session->userdata('userNIK');
            $employeeDatas = $this->M_auth->getEmployeeDataById($employeeId);
            $familyMembers = $this->M_auth->getFamilyMembersByEmployee($employeeId);
            $insuranceData = $this->M_auth->getInsuranceByEmployeeId($employeeId);
        } else {
            // Assuming you are also retrieving family data if logged in as family
            $familyId = $this->session->userdata('userNIK');
            $employeeDatas = $this->M_auth->getFamilyDataById($familyId);
            $insuranceData = $this->M_auth->getInsuranceByFamilyId($familyId);
            $familyMembers = null;
        }

        $datas = array(
            'title' => 'BIM | User',
            'subtitle' => 'Profile',
            'contentType' => 'user',
            'employeeDatas' => $employeeDatas, // Send data to the view
            'familyMembers' => $familyMembers,
            'insuranceData' => $insuranceData,
            'qr' => $this->generateQR(base64_encode($this->session->userdata('userNIK'). '-' . $userType))
        );

        $partials = array(
            'head' => 'partials/head',
            'navbar' => 'partials/user/navbar',
            'footer' => 'partials/user/footer',
            'content' => 'user/Profile',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

    public function getUserHistories() {
        $familyDatas = $this->M_auth->checkFamily('familyNIK', $this->session->userdata('userNIK'));
        if ($familyDatas) {
            $historiesDatas = $this->M_historyhealth->getUserHistories ($this->session->userdata('userNIK'), 'family');
        } else {
            $historiesDatas = $this->M_historyhealth->getUserHistories ($this->session->userdata('userNIK'), 'employee');
        }
        if ($historiesDatas) {
            $datas = array(
                'data' => $historiesDatas,
            );
            echo json_encode($datas);
        } else {
            echo json_encode(['data' => []]);
        }
    }

    public function editEmployee() {
        // Validation rules
        $validate = array(
            array(
                'field' => 'employeeEmail',
                'label' => 'Email',
                'rules' => 'required|trim|valid_email',
                'errors' => array(
                    'required' => 'You should provide a %s.',
                    'valid_email' => 'The %s field must contain a valid email address.'
                )
            ),
            array(
                'field' => 'oldPassword',
                'label' => 'Old Password',
                'rules' => 'trim', // Not required, only checked if newPassword is provided
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
        
        // Check if validation fails
        if ($this->form_validation->run() == FALSE) {
            // Return errors if validation fails
            $errors = $this->form_validation->error_array();
            echo json_encode(array('status' => 'invalid', 'errors' => $errors));
        } else {
            // Get the logged-in user's NIK from the session
            $employeeNIK = $this->input->post('employeeNIK');
            $oldPassword = htmlspecialchars($this->input->post('oldPassword'));
            $newPassword = htmlspecialchars($this->input->post('newPassword'));
            $newEmail = $this->input->post('employeeEmail');
        
            // If new password is provided, verify the old password
            if (!empty($newPassword)) {
                // Fetch the current password hash from the database (use the employeeNIK to fetch the correct record)
                $currentPasswordHash = $this->M_auth->getCurrentPasswordByNIK($employeeNIK);
                
                // Verify if the old password matches the current password
                if (!password_verify($oldPassword, $currentPasswordHash)) {
                    echo json_encode(array('status' => 'invalid', 'errors' => array('oldPassword' => 'The old password is incorrect.')));
                    return;
                }
            }
        
            // Prepare employee data for updating
            $employeeData = array(
                'employeeEmail' => $newEmail,
            );
        
            // Update the password if a new password is provided
            if (!empty($newPassword)) {
                // Hash the new password before saving
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $employeeData['employeePassword'] = $hashedPassword;
            }
        
            // Call model function to update the employee data (email and password)
            $updateResult = $this->M_auth->updateEmployee($employeeNIK, $employeeData);
        
            // Check if update was successful
            if ($updateResult) {
                // Update session data for the logged-in user
                $this->session->set_userdata('userEmail', $newEmail);
        
                // Respond with success
                $this->session->set_flashdata('refresh_needed', true);
                redirect('user/profile');
            } else {
                // Respond with failure if update fails
                echo json_encode(['success' => false, 'message' => 'Password Lama Salah.']);
            }
        }
    }
    
    public function editFamily() {
        // Validation rules
        $validate = array(
            array(
                'field' => 'familyEmail',
                'label' => 'Email',
                'rules' => 'required|trim|valid_email',
                'errors' => array(
                    'required' => 'You should provide a %s.',
                    'valid_email' => 'The %s field must contain a valid email address.'
                )
            ),
            array(
                'field' => 'oldPassword',
                'label' => 'Old Password',
                'rules' => 'trim', // Not required, only checked if newPassword is provided
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
        
        // Check if validation fails
        if ($this->form_validation->run() == FALSE) {
            // Return errors if validation fails
            $errors = $this->form_validation->error_array();
            echo json_encode(array('status' => 'invalid', 'errors' => $errors));
        } else {
            // Get the logged-in user's NIK from the session
            $familyNIK = $this->input->post('familyNIK');
            $oldPassword = htmlspecialchars($this->input->post('oldPassword'));
            $newPassword = htmlspecialchars($this->input->post('newPassword'));
            $newEmail = $this->input->post('familyEmail');
        
            // If new password is provided, verify the old password
            if (!empty($newPassword)) {
                // Fetch the current password hash from the database (use the familyNIK to fetch the correct record)
                $currentPasswordHash = $this->M_auth->getCurrentPasswordByFamilyNIK($familyNIK);
                
                // Verify if the old password matches the current password
                if (!password_verify($oldPassword, $currentPasswordHash)) {
                    echo json_encode(array('status' => 'invalid', 'errors' => array('oldPassword' => 'The old password is incorrect.')));
                    return;
                }
            }
        
            // Prepare family data for updating
            $employeeData = array(
                'familyEmail' => $newEmail,
            );
        
            // Update the password if a new password is provided
            if (!empty($newPassword)) {
                // Hash the new password before saving
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $employeeData['familyPassword'] = $hashedPassword;
            }
        
            // Call model function to update the family data (email and password)
            $updateResult = $this->M_auth->updatefamily($familyNIK, $employeeData);
        
            // Check if update was successful
            if ($updateResult) {
                // Update session data for the logged-in user
                $this->session->set_userdata('userEmail', $newEmail);
        
                // Respond with success
                $this->session->set_flashdata('refresh_needed', true);
                redirect('user/profile');
            } else {
                // Respond with failure if update fails
                echo json_encode(['success' => false, 'message' => 'Password Lama Salah.']);
            }
        }
    }

    public function generateQR(String $data)
    {   
        $options = new QROptions;
        $options->version             = 5;
        $options->outputType          = QROutputInterface::GDIMAGE_PNG;
        $options->scale               = 15;
        $options->outputBase64        = false;
        $options->eccLevel            = EccLevel::H;
        $options->addLogoSpace        = true;
        $options->logoSpaceWidth      = 8;
        $options->logoSpaceHeight     = 8;
        $options->imageTransparent    = true;
        $options->addQuietzone        = false;
        $options->drawLightModules    = false;
        $options->cornerRadius        = 10;
        // $options->drawCircularModules = true;
        // $options->circleRadius        = 0.4;
        $options->keepAsSquare        = [
            QRMatrix::M_FINDER_DARK,
            QRMatrix::M_FINDER_DOT,
            QRMatrix::M_ALIGNMENT_DARK,
        ];
        $options->moduleValues        = [
            // QRMatrix::M_FINDER_DARK    => [253, 164, 62],
            QRMatrix::M_FINDER_DARK    => [69,69,69],
            QRMatrix::M_FINDER_DOT     => [69,69,69],
            // QRMatrix::M_FINDER_DOT     => [253, 164, 62],
            // QRMatrix::M_ALIGNMENT_DARK => [253, 164, 62],
            QRMatrix::M_ALIGNMENT_DARK => [69,69,69],
            // QRMatrix::M_ALIGNMENT      => [253, 164, 62],
            QRMatrix::M_DATA_DARK      => [69,69,69],
            QRMatrix::M_DARKMODULE     => [69,69,69],
            QRMatrix::M_FORMAT_DARK    => [69,69,69],
            QRMatrix::M_TIMING_DARK    => [69,69,69],
        ];

        $qrcode = new QRCode($options);
        $qrcode->render($data);

        $qrOutputInterface = new QRWithLogo($options, $qrcode->getQRMatrix());

        // dump the output, with an additional logo
        // the logo could also be supplied via the options, see the svgWithLogo example
        $data =  $qrOutputInterface->dump(null, FCPATH . 'assets/images/logo.png');
        return $data;
    }
}


/* End of file Company.php */

?>