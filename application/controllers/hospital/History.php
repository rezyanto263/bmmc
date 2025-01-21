<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

use Ramsey\Uuid\Uuid;
class History extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('adminRole') != ('hospital')) {
            redirect('dashboard');
        }
        
        $this->load->model('M_admins');
        $this->load->model('M_hospitals');
        $this->load->model('M_historyhealth');
        
    } 

    public function index()
    {
        $datas = array(
            'title' => 'BMMC Hospital | History',
            'subtitle' => 'History',
            'contentType' => 'dashboard'
        );

        $partials = array(
            'head' => 'partials/head',
            'sidebar' => 'partials/hospital/sidebar',
            'floatingMenu' => 'partials/hospital/floatingMenu',
            'contentHeader' => 'partials/hospital/contentHeader',
            'contentBody' => 'hospital/History',
            'footer' => 'partials/hospital/footer',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

    public function getHospitalHistoriesDatas() {
        $adminDatas = $this->M_admins->checkAdmin('adminEmail', $this->session->userdata('adminEmail'));
        $hospitalDatas = $this->M_hospitals->checkHospital('adminId', $adminDatas['adminId']);
        $historiesDatas = $this->M_historyhealth->getHospitalHistoriesDatas($hospitalDatas['hospitalId']);
        if ($historiesDatas) {
            $datas = array(
                'data' => $historiesDatas,
            );
            echo json_encode($datas);
        } else {
            echo json_encode(['data' => []]);
        }
    }

    public function getHPatientHistoryHealthDetailsByNIK($patientNIK) {
        $historyhealthDatas = $this->M_hospitals->getPatientHistoryHealthDetailsByNIK($patientNIK);
        $datas = array(
            'data' => $historyhealthDatas
        );
        echo json_encode($datas);
    }

    public function addReferral() {
        $adminDatas = $this->M_admins->checkAdmin('adminEmail', $this->session->userdata('adminEmail'));
        $hospitalDatas = $this->M_hospitals->checkHospital('adminId', $adminDatas['adminId']);
        $validate = array(
            array(
                'field' => 'historyhealthDescription',
                'label' => 'Description',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Referral should provide a %s.'
                )
            ),
            array(
                'field' => 'historyhealthReferredTo',
                'label' => 'Referred To',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Referral should provide a %s.',
                )
            ),
            array(
                'field' => 'patientNIK',
                'label' => 'NIK',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Referral should provide a %s.'
                )
            ),
            array(
                'field' => 'role',
                'label' => 'Role',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Referral should provide a %s.'
                )
            ),
        );
        $this->form_validation->set_rules($validate);

        if ($this->form_validation->run() == FALSE) {
            $errors = $this->form_validation->error_array();
            echo json_encode(array('status' => 'invalid', 'errors' => $errors));
            return;
        }

        $BillingId = $this->M_historyhealth->checkBillByPatientNIK ($this->input->post('patientNIK'), $this->input->post('role'));
        if (!$BillingId) {
            echo json_encode(array('status' => 'invalid', 'errors' => 'BillId Patient not found.'));
            return;
        }
        $uuid = Uuid::uuid7();
        $referralDatas = array(
            'historyhealthId' => $uuid->toString(),
            'hospitalId' => $hospitalDatas['hospitalId'],
            'billingId' => $BillingId['billingId'],
            'patientNIK' => htmlspecialchars($this->input->post('patientNIK')),
            'historyhealthRole' => htmlspecialchars($this->input->post('role')),
            'historyhealthDescription' => htmlspecialchars($this->input->post('historyhealthDescription')),
            'historyhealthReferredTo' => htmlspecialchars($this->input->post('historyhealthReferredTo')),
        );
        $this->M_historyhealth->insertReferral($referralDatas);
        $this->M_hospitals->deleteQueue($this->input->post('patientNIK'), $hospitalDatas['hospitalId']);
        echo json_encode(array('status' => 'success'));
    }
}

?>