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
            'floatingMenu' => 'partials/dashboard/floatingMenu',
            'contentHeader' => 'partials/company/contentHeader',
            'contentBody' => 'company/Family',
            'footer' => 'partials/dashboard/footer',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

    public function savePolicyholderNIN() {
        $policyholderNIN = $this->input->post('policyholderNIN');
    
        if (!empty($policyholderNIN)) {
            $this->session->set_userdata('policyholderNIN', $policyholderNIN);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Policyholder NIN tidak valid.']);
        }
    }
    
    public function getAllFamilyDatas() {
        $familyDatas = $this->M_family->getAllFamilyDatas();
        $datas = array(
            'data' => $familyDatas
        );

        echo json_encode($datas);
    }

    public function getFamiliesByPolicyholderNIN($policyholderNIN = null) {
        if (empty($policyholderNIN)) {
            // Ambil NIN dari session jika parameter kosong
            $policyholderNIN = $this->session->userdata('policyholderNIN');
        }
    
        if (empty($policyholderNIN)) {
            // Jika tetap kosong, kembalikan semua data keluarga atau error
            $familyDatas = $this->M_family->getAllFamilyDatas();
        } else {
            $familyDatas = $this->M_family->getFamiliesByPolicyholderNIN($policyholderNIN);
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
                'field' => 'familyNIN',
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
                'familyNIN' => $this->input->post('familyNIN'),
                'policyholderNIN' => $this->input->post('policyholderNIN'),
                'familyName' => $this->input->post('familyName'),
                'familyEmail' => $this->input->post('familyEmail'),
                'familyPassword' => $this->input->post('familyPassword'),
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
            $familyNIN = $this->input->post('familyNIN');
            $newPassword = $this->input->post('newPassword');
            $familyData = array(
                'familyNIN' => $this->input->post('familyNIN'),
                'policyholderNIN' => $this->input->post('policyholderNIN'),
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
    
            $this->M_family->updateFamily($familyNIN, $familyData);
            echo json_encode(array('status' => 'success'));
        }
    }
    
    public function deleteFamily() {
        $familyNIN = $this->input->post('familyNIN');
        $this->M_family->deleteFamily($familyNIN);
    
        echo json_encode(array('status' => 'success'));
    }    
}

/* End of file Companies.php */

?>