<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Diseases extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('adminRole') != 'admin') {
            redirect('dashboard/login');
        }

        $this->load->model('M_diseases');
    }

    public function index(){
        $datas = array(
            'title' => 'BMMC Dashboard | Diseases',
            'subtitle' => 'Diseases',
            'contentType' => 'dashboard'
        );

        $partials = array(
            'head' => 'partials/head',
            'sidebar' => 'partials/dashboard/sidebar',
            'floatingMenu' => 'partials/floatingMenu',
            'contentHeader' => 'partials/contentHeader',
            'contentBody' => 'dashboard/diseases',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

    public function getAllDiseasesDatas() {
        $diseasesDatas = $this->M_diseases->getAllDiseasesDatas();
        $datas = array(
            'data' => $diseasesDatas
        );

        echo json_encode($datas);
    }

    public function getCompanyDiseases() {
        $companyId = $this->input->get('id');
        $diseasesDatas = $this->M_diseases->getCompanyDiseases($companyId);
        $datas = array(
            'data' => $diseasesDatas
        );
    
        echo json_encode($datas);
    }

    public function addDisease() {
        $validate = array(
            array(
                'field' => 'diseaseName',
                'label' => 'Name',
                'rules' => 'required|trim|max_length[50]',
                'errors' => array(
                    'required' => 'Disease should provide a %s.',
                    'max_length' => '%s max 50 characters in length.',
                )
            ),
            array(
                'field' => 'diseaseInformation',
                'label' => 'Information',
                'rules' => 'required|trim|max_length[256]',
                'errors' => array(
                    'required' => 'Disease should provide a %s.',
                    'max_length' => '%s max 256 characters in length.',
                )
            )
        );
        $this->form_validation->set_rules($validate);
        
        if ($this->form_validation->run() == FALSE) {
            $errors = $this->form_validation->error_array();
            echo json_encode(array('status' => 'invalid', 'errors' => $errors, 'csrfToken' => $this->security->get_csrf_hash()));
        } else {
            $diseaseDatas = array(
                'diseaseName' => htmlspecialchars($this->input->post('diseaseName'), ENT_COMPAT),
                'diseaseInformation' => htmlspecialchars($this->input->post('diseaseInformation'), ENT_NOQUOTES)
            );

            $checkDisease = $this->M_diseases->checkDisease(array('diseaseName' => $diseaseDatas['diseaseName']));
            if (!empty($checkDisease)) {
                echo json_encode(array(
                    'status' => 'failed', 
                    'failedMsg' => 'disease used', 
                    'csrfToken' => $this->security->get_csrf_hash()
                ));
                return;
            }

            $this->M_diseases->insertDisease($diseaseDatas);
            echo json_encode(array('status' => 'success', 'csrfToken' => $this->security->get_csrf_hash()));
        }
    }

    public function editDisease() {
        $validate = array(
            array(
                'field' => 'diseaseName',
                'label' => 'Name',
                'rules' => 'required|trim|max_length[50]',
                'errors' => array(
                    'required' => 'Disease should provide a %s.',
                    'max_length' => '%s max 50 characters in length.',
                )
            ),
            array(
                'field' => 'diseaseInformation',
                'label' => 'Information',
                'rules' => 'required|trim|max_length[256]',
                'errors' => array(
                    'required' => 'Disease should provide a %s.',
                    'max_length' => '%s max 256 characters in length.',
                )
            )
        );
        $this->form_validation->set_rules($validate);
        
        if ($this->form_validation->run() == FALSE) {
            $errors = $this->form_validation->error_array();
            echo json_encode(array('status' => 'invalid', 'errors' => $errors, 'csrfToken' => $this->security->get_csrf_hash()));
        } else {
            $diseaseDatas = array(
                'diseaseName' => htmlspecialchars($this->input->post('diseaseName'), ENT_COMPAT),
                'diseaseInformation' => htmlspecialchars($this->input->post('diseaseInformation'), ENT_NOQUOTES)
            );

            $diseaseId = htmlspecialchars($this->input->post('diseaseId'));
            $checkDisease = $this->M_diseases->checkDisease(array('diseaseName' => $diseaseDatas['diseaseName'], 'diseaseId !=' => $diseaseId));
            if (!empty($checkDisease)) {
                echo json_encode(array(
                    'status' => 'failed', 
                    'failedMsg' => 'disease used', 
                    'csrfToken' => $this->security->get_csrf_hash()
                ));
                return;
            }

            $this->M_diseases->updateDisease($diseaseId, $diseaseDatas);
            echo json_encode(array('status' => 'success', 'csrfToken' => $this->security->get_csrf_hash()));
        }
    }

    public function deleteDisease() {
        $diseaseId = htmlspecialchars($this->input->post('diseaseId'));

        $this->load->model('M_healthhistories');
        $isDiseaseUsed = $this->M_healthhistories->checkHealthHistoryDisease($diseaseId);
        if (!empty($isDiseaseUsed)) {
            echo json_encode(array(
                'status' => 'failed',
                'failedMsg' => 'can not delete linked data',
                'csrfToken' => $this->security->get_csrf_hash()
            ));
            return;
        }

        $this->M_diseases->deleteDisease($diseaseId);
        echo json_encode(array('status' => 'success', 'csrfToken' => $this->security->get_csrf_hash()));
    }

}

/* End of file Diseases.php */

?>