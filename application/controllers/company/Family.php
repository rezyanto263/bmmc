<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Family extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('adminRole') != ('admin' || 'company')) {
            redirect('dashboard');
        }

        $this->load->model('M_family');
        $adminId = $this->session->userdata('adminId');
        $companyData = $this->M_family->getCompanyByAdminId($adminId);
    }
    

    public function index()
    {
        $datas = array(
            'title' => 'BIM Dashboard | Family',
            'subtitle' => 'Family',
            'contentType' => 'dashboard'
        );

        $partials = array(
            'head' => 'partials/head',
            'sidebar' => 'partials/company/sidebar',
            'floatingMenu' => 'partials/company/floatingMenu',
            'contentHeader' => 'partials/company/contentHeader',
            'contentBody' => 'company/Family',
            'footer' => 'partials/dashboard/footer',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

    public function index2()
    {
        $datas = array(
            'title' => 'BIM Dashboard | Family',
            'subtitle' => 'Family',
            'contentType' => 'dashboard'
        );

        $partials = array(
            'head' => 'partials/head',
            'sidebar' => 'partials/company/sidebar',
            'floatingMenu' => 'partials/company/floatingMenu',
            'contentHeader' => 'partials/company/contentHeader',
            'contentBody' => 'company/AllFamily',
            'footer' => 'partials/dashboard/footer',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

    public function saveEmployeeNIK() {
        $employeeNIK = $this->input->post('employeeNIK');
    
        if (!empty($employeeNIK)) {
            $this->session->set_userdata('employeeNIK', $employeeNIK);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Employee NIK tidak valid.']);
        }
    }
    
    public function getAllFamilyDatas() {
        $companyId = $this->session->userdata('companyId');
        $familyDatas = $this->M_family->getAllFamilyDatas($companyId);
        $datas = array(
            'data' => $familyDatas
        );

        echo json_encode($datas);
    }

    public function getFamiliesByEmployeeNIK($employeeNIK = null) {
        if (empty($employeeNIK)) {
            // Ambil NIK dari session jika parameter kosong
            $employeeNIK = $this->session->userdata('employeeNIK');
        }
    
        if (empty($employeeNIK)) {
            // Jika tetap kosong, kembalikan semua data keluarga atau error
            $familyDatas = $this->M_family->getAllFamilyDatas();
        } else {
            $familyDatas = $this->M_family->getFamiliesByEmployeeNIK($employeeNIK);
        }
    
        // Siapkan data untuk dikembalikan dalam format JSON
        $datas = array('data' => $familyDatas);
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
                'field' => 'familyNIK',
                'label' => 'NIN',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Family should provide a %s.',
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
                'field' => 'familyPassword',
                'label' => 'Password',
                'rules' => 'required|trim|min_length[8]|max_length[20]|regex_match[/^(?=.*[A-Z])(?=.*\d).+$/]',
                'errors' => array(
                    'required' => 'You should provide a %s.',
                    'min_length' => '%s must be at least 8 characters in length.',
                    'max_length' => '%s max 20 characters in length.',
                    'regex_match' => '%s must contain at least one uppercase letter and one number.'
                )
            ),
            array(
                'field' => 'confirmPassword',
                'label' => 'Password Confirmation',
                'rules' => 'required|matches[familyPassword]',
                'errors' => array(
                    'required' => 'You must provide a %s.',
                    'matches' => '%s does not match the Password.'
                )
            )
        );
    
        $this->form_validation->set_rules($validate);
    
        if ($this->form_validation->run() == FALSE) {
            $errors = $this->form_validation->error_array();
            echo json_encode(array('status' => 'invalid', 'errors' => $errors));
        } else {
            $familyData = array(
                'familyNIK' => htmlspecialchars($this->input->post('familyNIK')),
                'employeeNIK' => $this->input->post('employeeNIK'),
                'familyName' => $this->input->post('familyName'),
                'familyEmail' => $this->input->post('familyEmail'),
                'familyPassword' => password_hash(htmlspecialchars($this->input->post('familyPassword')), PASSWORD_DEFAULT),
                'familyAddress' => $this->input->post('familyAddress'),
                'familyBirth' => $this->input->post('familyBirth'),
                'familyGender' => $this->input->post('familyGender'),
                'familyRole' => $this->input->post('familyRole'),
                'familyStatus' => $this->input->post('familyStatus')
            );
    
            $this->M_family->insertFamily($familyData);
            echo json_encode(array('status' => 'success'));
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
            echo json_encode(array('status' => 'invalid', 'errors' => $errors));
        } else {
            $familyNIK = $this->input->post('familyNIK');
            $newPassword = htmlspecialchars($this->input->post('newPassword'));
            $familyData = array(
                'familyNIK' => $this->input->post('familyNIK'),
                'employeeNIK' => $this->input->post('employeeNIK'),
                'familyName' => $this->input->post('familyName'),
                'familyEmail' => $this->input->post('familyEmail'),
                'familyAddress' => $this->input->post('familyAddress'),
                'familyBirth' => $this->input->post('familyBirth'),
                'familyGender' => $this->input->post('familyGender'),
                'familyRole' => $this->input->post('familyRole'),
                'familyStatus' => $this->input->post('familyStatus')
            );
            if (!empty($newPassword)) {
                $familyData['familyPassword'] = $newPassword;
            }
    
            $this->M_family->updateFamily($familyNIK, $familyData);
            echo json_encode(array('status' => 'success'));
        }
    }
    
    public function deleteFamily() {
        $familyNIK = $this->input->post('familyNIK');
        $this->M_family->deleteFamily($familyNIK);
    
        echo json_encode(array('status' => 'success'));
    }    
}

/* End of file Companies.php */

?>