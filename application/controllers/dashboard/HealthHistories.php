<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

use Ramsey\Uuid\Uuid;

class HealthHistories extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('adminRole') != 'admin') {
        redirect('dashboard/login');
        }
        
        $this->load->model('M_healthhistories');
    }

    public function index() {
        $datas = array(
            'title' => 'BMMC Dashboard | Health Histories',
            'subtitle' => 'Health Histories',
            'contentType' => 'dashboard'
        );

        $partials = array(
            'head' => 'partials/head',
            'sidebar' => 'partials/dashboard/sidebar',
            'floatingMenu' => 'partials/floatingMenu',
            'contentHeader' => 'partials/contentHeader',
            'contentBody' => 'dashboard/healthhistories',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

    public function getAllHealthHistoriesDatas() {
        $healthhistoriesDatas = $this->M_healthhistories->getAllHealthHistoriesDatas();
        $datas = array(
            'data' => $healthhistoriesDatas
        );

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($datas));
    }

    public function getPatientHealthHistoryDetailsByNIK() {
        $patientNIK = $this->input->get('nik');
        $patientRole = $this->input->get('role');
        $healthhistoryDatas = $this->M_healthhistories->getPatientHealthHistoryDetailsByNIK($patientNIK, $patientRole);
        $datas = array(
            'data' => $healthhistoryDatas
        );

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($datas));
    }

    public function getAllPatientsData() {
        $patientsData = $this->M_healthhistories->getAllPatientsData();
        $datas = array(
            'data' => $patientsData
        );

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($datas));
    }

    public function getAllDoctorsByHospitalId() {
        $this->load->model('M_doctors');
        $doctorDatas = $this->M_doctors->getHospitalDoctorsDatas('hospitalId', $this->input->get('id'));
        $datas = array(
            'data' => $doctorDatas
        );

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($datas));
    }

    public function getAllHealthHistoriesByBillingId() {
        $billingId = $this->input->get('id');
        $healthistoriesData = $this->M_healthhistories->getAllHealthHistoriesByBillingId($billingId);
        $datas = array(
            'data' => $healthistoriesData
        );

        echo json_encode($datas);
    }

    public function addHealthHistory() {
        $validate = array(
            'companyId' => array(
                'field' => 'companyId',
                'label' => 'Company',
                'rules' => 'required|trim|numeric',
                'errors' => array(
                    'required' => 'Health History should provide a patient %s',
                    'numeric' => 'The %s field must contain only numbers.',
                )
            ),
            'patientNIK' => array(
                'field' => 'patientNIK',
                'label' => 'NIK',
                'rules' => 'required|trim|numeric|exact_length[16]',
                'errors' => array(
                    'required' => 'Health History should provide a patient %s',
                    'numeric' => 'The %s field must contain only numbers.',
                    'exact_length' => 'The %s field must be exactly 16 characters long.'
                ),
            ),
            'hospitalId' => array(
                'field' => 'hospitalId',
                'label' => 'Hospital',
                'rules' => 'required|trim|numeric',
                'errors' => array(
                    'required' => 'Health History should provide a patient %s',
                    'numeric' => 'The %s field must contain only numbers.',
                )
            ),
            'doctorId' => array(
                'field' => 'doctorId',
                'label' => 'Doctor',
                'rules' => 'trim|numeric',
                'errors' => array(
                    'numeric' => 'The %s field must contain only numbers.',
                )
            ),
            'diseaseIds' => array(
                'field' => 'diseaseIds[]',
                'label' => 'Disease',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Health History should provide at least one disease.',
                )
            ),
            'healthhistoryDate' => array(
                'field' => 'healthhistoryDate',
                'label' => 'Date',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Health History should provide a patient %s',
                )
            ),
            'healthhistoryDescription' => array(
                'field' => 'healthhistoryDescription',
                'label' => 'Description',
                'rules' => 'trim|max_length[256]',
                'errors' => array(
                    'max_length' => '%s max 256 characters in length.',
                )
            ),
            'healthhistoryDoctorFee' => array(
                'field' => 'healthhistoryDoctorFee',
                'label' => 'Doctor Fee',
                'rules' => 'required|numeric|greater_than_equal_to[0]',
                'errors' => array(
                    'required' => 'Health History should provide a patient %s',
                    'numeric' => 'The %s field must contain only numbers.',
                    'greater_than_equal_to' => 'The %s must be a positive number.',
                ),
            ),
            'healthhistoryMedicineFee' => array(
                'field' => 'healthhistoryMedicineFee',
                'label' => 'Medicine Fee',  
                'rules' => 'required|numeric|greater_than_equal_to[0]',
                'errors' => array(
                    'required' => 'Health History should provide a patient %s',
                    'numeric' => 'The %s field must contain only numbers.',
                    'greater_than_equal_to' => 'The %s must be a positive number.',
                ),
            ),
            'healthhistoryLabFee' => array(
                'field' => 'healthhistoryLabFee',
                'label' => 'Lab Fee',
                'rules' => 'required|numeric|greater_than_equal_to[0]',
                'errors' => array(
                    'required' => 'Health History should provide a patient %s',
                    'numeric' => 'The %s field must contain only numbers.',
                    'greater_than_equal_to' => 'The %s must be a positive number.',
                ),
            ),
            'healthhistoryActionFee' => array(
                'field' => 'healthhistoryActionFee',    
                'label' => 'Action Fee',
                'rules' => 'required|numeric|greater_than_equal_to[0]',
                'errors' => array(
                    'required' => 'Health History should provide a patient %s',
                    'numeric' => 'The %s field must contain only numbers.',
                    'greater_than_equal_to' => 'The %s must be a positive number.',
                ),
            ),
            'healthhistoryDiscount' => array(
                'field' => 'healthhistoryDiscount',
                'label' => 'Discount',
                'rules' => 'numeric|greater_than_equal_to[0]',
                'errors' => array(
                    'numeric' => 'The %s field must contain only numbers.',
                    'greater_than_equal_to' => 'The %s must be a positive number.',
                ),
            ),
            'healthhistoryTotalBill' => array(
                'field' => 'healthhistoryTotalBill',
                'label' => 'Total Bill',
                'rules' => 'required|numeric|greater_than_equal_to[0]',
                'errors' => array(
                    'required' => 'Health History should provide a patient %s',
                    'numeric' => 'The %s field must contain only numbers.',
                    'greater_than_equal_to' => 'The %s must be a positive number.',
                ), 
            )
        );
        $this->form_validation->set_rules($validate);

        if ($this->form_validation->run() == FALSE) {
            $errors = $this->form_validation->error_array();
            echo json_encode(array('status' => 'invalid', 'errors' => $errors, 'csrfToken' => $this->security->get_csrf_hash()));
        } else {
            $uuid = Uuid::uuid7();
            $healthhistoryDatas = array(
                'healthhistoryId' => $uuid->toString(),
                'patientNIK' => htmlspecialchars($this->input->post('patientNIK')),
                'patientRole' => htmlspecialchars($this->input->post('patientRole')),
                'hospitalId' => htmlspecialchars($this->input->post('hospitalId')),
                'healthhistoryDate' => htmlspecialchars($this->input->post('healthhistoryDate')),
                'healthhistoryDoctorFee' => htmlspecialchars($this->input->post('healthhistoryDoctorFee')),
                'healthhistoryMedicineFee' => htmlspecialchars($this->input->post('healthhistoryMedicineFee')),
                'healthhistoryLabFee' => htmlspecialchars($this->input->post('healthhistoryLabFee')),
                'healthhistoryActionFee' => htmlspecialchars($this->input->post('healthhistoryActionFee')),
                'healthhistoryDiscount' => htmlspecialchars($this->input->post('healthhistoryDiscount')),
            );

            $healthhistoryDatas['healthhistoryTotalBill'] = ($healthhistoryDatas['healthhistoryDoctorFee'] 
                    + $healthhistoryDatas['healthhistoryMedicineFee'] 
                    + $healthhistoryDatas['healthhistoryLabFee'] 
                    + $healthhistoryDatas['healthhistoryActionFee'])
                    - $healthhistoryDatas['healthhistoryDiscount'];

            $doctorId = htmlspecialchars($this->input->post('doctorId') ?: '', ENT_COMPAT);
            if (!empty($doctorId)) {
                $healthhistoryDatas['doctorId'] = $doctorId;
            }

            $healthhistoryDescription = htmlspecialchars($this->input->post('healthhistoryDescription') ?: '', ENT_NOQUOTES);
            if (!empty($healthhistoryDescription)) {
                $healthhistoryDatas['healthhistoryDescription'] = $healthhistoryDescription;
            }

            $healthistoryReferredTo = htmlspecialchars($this->input->post('healthhistoryReferredTo') ?: '');
            if (!empty($healthistoryReferredTo)) {
                $healthhistoryDatas['healthhistoryReferredTo'] = $healthistoryReferredTo;
            }

            $companyId = htmlspecialchars($this->input->post('companyId'));
            $this->load->model('M_invoices');
            $checkBilling = $this->M_invoices->checkCurrentBillingByCompanyId($companyId);
            if (empty($checkBilling)) {
                echo json_encode(array(
                    'status' => 'failed', 
                    'failedMsg' => 'billing not found', 
                    'csrfToken' => $this->security->get_csrf_hash()
                ));
                return;
            }
            $healthhistoryDatas['billingId'] = $checkBilling['billingId'];

            $diseaseIds = $this->input->post('diseaseIds') ?: [];
            if (!is_array($diseaseIds)) {
                $diseaseIds = explode(',', $diseaseIds);
            }

            $this->M_healthhistories->insertHealthHistory($healthhistoryDatas, $diseaseIds);
            echo json_encode(array('status' => 'success', 'csrfToken' => $this->security->get_csrf_hash()));
        }
    }

    public function editHealthHistory() {
        $validate = array(
            'healthhistoryId' => array(
                'field' => 'healthhistoryId',
                'label' => 'Health History ID',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Health History should provide a health history ID',
                )
            ),
            'companyId' => array(
                'field' => 'companyId',
                'label' => 'Company',
                'rules' => 'required|trim|numeric',
                'errors' => array(
                    'required' => 'Health History should provide a patient %s',
                    'numeric' => 'The %s field must contain only numbers.',
                )
            ),
            'patientNIK' => array(
                'field' => 'patientNIK',
                'label' => 'NIK',
                'rules' => 'required|trim|numeric|exact_length[16]',
                'errors' => array(
                    'required' => 'Health History should provide a patient %s',
                    'numeric' => 'The %s field must contain only numbers.',
                    'exact_length' => 'The %s field must be exactly 16 characters long.'
                ),
            ),
            'hospitalId' => array(
                'field' => 'hospitalId',
                'label' => 'Hospital',
                'rules' => 'required|trim|numeric',
                'errors' => array(
                    'required' => 'Health History should provide a patient %s',
                    'numeric' => 'The %s field must contain only numbers.',
                )
            ),
            'doctorId' => array(
                'field' => 'doctorId',
                'label' => 'Doctor',
                'rules' => 'trim|numeric',
                'errors' => array(
                    'numeric' => 'The %s field must contain only numbers.',
                )
            ),
            'diseaseIds' => array(
                'field' => 'diseaseIds[]',
                'label' => 'Disease',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Health History should provide at least one disease.',
                )
            ),
            'healthhistoryDate' => array(
                'field' => 'healthhistoryDate',
                'label' => 'Date',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Health History should provide a patient %s',
                )
            ),
            'healthhistoryDescription' => array(
                'field' => 'healthhistoryDescription',
                'label' => 'Description',
                'rules' => 'trim|max_length[256]',
                'errors' => array(
                    'max_length' => '%s max 256 characters in length.',
                )
            ),
            'healthhistoryDoctorFee' => array(
                'field' => 'healthhistoryDoctorFee',
                'label' => 'Doctor Fee',
                'rules' => 'required|numeric|greater_than_equal_to[0]',
                'errors' => array(
                    'required' => 'Health History should provide a patient %s',
                    'numeric' => 'The %s field must contain only numbers.',
                    'greater_than_equal_to' => 'The %s must be a positive number.',
                ),
            ),
            'healthhistoryMedicineFee' => array(
                'field' => 'healthhistoryMedicineFee',
                'label' => 'Medicine Fee',  
                'rules' => 'required|numeric|greater_than_equal_to[0]',
                'errors' => array(
                    'required' => 'Health History should provide a patient %s',
                    'numeric' => 'The %s field must contain only numbers.',
                    'greater_than_equal_to' => 'The %s must be a positive number.',
                ),
            ),
            'healthhistoryLabFee' => array(
                'field' => 'healthhistoryLabFee',
                'label' => 'Lab Fee',
                'rules' => 'required|numeric|greater_than_equal_to[0]',
                'errors' => array(
                    'required' => 'Health History should provide a patient %s',
                    'numeric' => 'The %s field must contain only numbers.',
                    'greater_than_equal_to' => 'The %s must be a positive number.',
                ),
            ),
            'healthhistoryActionFee' => array(
                'field' => 'healthhistoryActionFee',    
                'label' => 'Action Fee',
                'rules' => 'required|numeric|greater_than_equal_to[0]',
                'errors' => array(
                    'required' => 'Health History should provide a patient %s',
                    'numeric' => 'The %s field must contain only numbers.',
                    'greater_than_equal_to' => 'The %s must be a positive number.',
                ),
            ),
            'healthhistoryDiscount' => array(
                'field' => 'healthhistoryDiscount',
                'label' => 'Discount',
                'rules' => 'numeric|greater_than_equal_to[0]',
                'errors' => array(
                    'numeric' => 'The %s field must contain only numbers.',
                    'greater_than_equal_to' => 'The %s must be a positive number.',
                ),
            ),
            'healthhistoryTotalBill' => array(
                'field' => 'healthhistoryTotalBill',
                'label' => 'Total Bill',
                'rules' => 'required|numeric|greater_than_equal_to[0]',
                'errors' => array(
                    'required' => 'Health History should provide a patient %s',
                    'numeric' => 'The %s field must contain only numbers.',
                    'greater_than_equal_to' => 'The %s must be a positive number.',
                ), 
            )
        );
        $this->form_validation->set_rules($validate);

        if ($this->form_validation->run() == FALSE) {
            $errors = $this->form_validation->error_array();
            echo json_encode(array('status' => 'invalid', 'errors' => $errors, 'csrfToken' => $this->security->get_csrf_hash()));
        } else {
            $healthhistoryDatas = array(
                'patientNIK' => htmlspecialchars($this->input->post('patientNIK')),
                'patientRole' => htmlspecialchars($this->input->post('patientRole')),
                'hospitalId' => htmlspecialchars($this->input->post('hospitalId')),
                'healthhistoryDate' => htmlspecialchars($this->input->post('healthhistoryDate')),
                'healthhistoryDoctorFee' => htmlspecialchars($this->input->post('healthhistoryDoctorFee')),
                'healthhistoryMedicineFee' => htmlspecialchars($this->input->post('healthhistoryMedicineFee')),
                'healthhistoryLabFee' => htmlspecialchars($this->input->post('healthhistoryLabFee')),
                'healthhistoryActionFee' => htmlspecialchars($this->input->post('healthhistoryActionFee')),
                'healthhistoryDiscount' => htmlspecialchars($this->input->post('healthhistoryDiscount')),
                'healthhistoryReferredTo' => htmlspecialchars($this->input->post('healthhistoryReferredTo') ?: '') ?: NULL
            );

            $healthhistoryTotalBill = ($healthhistoryDatas['healthhistoryDoctorFee'] 
                    + $healthhistoryDatas['healthhistoryMedicineFee'] 
                    + $healthhistoryDatas['healthhistoryLabFee'] 
                    + $healthhistoryDatas['healthhistoryActionFee'])
                    - $healthhistoryDatas['healthhistoryDiscount'];
            if ($healthhistoryTotalBill !== 0) {
                if ($healthhistoryDatas['patientRole'] === 'employee') {
                    $this->load->model('M_employees');
                    $employeeData = $this->M_employees->getEmployeeByNIK($healthhistoryDatas['patientNIK']);
                    $employeeNIK = $employeeData['employeeNIK'];
                    $insuranceAmount = $employeeData['insuranceAmount'];
                } else {
                    $this->load->model('M_families');
                    $familyData = $this->M_families->getFamilyByNIK($healthhistoryDatas['patientNIK']);
                    $employeeNIK = $familyData['employeeNIK'];
                    $insuranceAmount = $familyData['insuranceAmount'];
                }
                
                $this->load->model('M_insurances');
                $insuranceData = $this->M_insurances->getInsuranceDetailsByEmployeeNIK($employeeNIK);
                $totalBillingRemaining = $insuranceAmount - $insuranceData['totalBillingUsedThisMonth'];

                if ($totalBillingRemaining < $healthhistoryTotalBill) {
                    echo json_encode(array(
                        'status' => 'failed', 
                        'failedMsg' => 'Insurance amount not sufficient', 
                        'csrfToken' => $this->security->get_csrf_hash()
                    ));
                    return;
                }

                $healthhistoryDatas['healthhistoryTotalBill'] = $healthhistoryTotalBill;
            }

            $doctorId = htmlspecialchars($this->input->post('doctorId') ?: '', ENT_COMPAT);
            if (!empty($doctorId)) {
                $healthhistoryDatas['doctorId'] = $doctorId;
            }

            $healthhistoryDescription = htmlspecialchars($this->input->post('healthhistoryDescription') ?: '', ENT_NOQUOTES);
            if (!empty($healthhistoryDescription)) {
                $healthhistoryDatas['healthhistoryDescription'] = $healthhistoryDescription;
            }

            $companyId = htmlspecialchars($this->input->post('companyId'));
            $this->load->model('M_billings');
            $checkBilling = $this->M_billings->checkCurrentBillingByCompanyId($companyId);
            if (empty($checkBilling)) {
                echo json_encode(array(
                    'status' => 'failed', 
                    'failedMsg' => 'billing not found', 
                    'csrfToken' => $this->security->get_csrf_hash()
                ));
                return;
            }
            $healthhistoryDatas['billingId'] = $checkBilling['billingId'];

            $diseaseIds = $this->input->post('diseaseIds') ?: [];
            if (!is_array($diseaseIds)) {
                $diseaseIds = explode(',', $diseaseIds);
            }

            $this->M_healthhistories->updateHealthHistory($healthhistoryDatas, $diseaseIds, htmlspecialchars($this->input->post('healthhistoryId')));
            echo json_encode(array('status' => 'success', 'csrfToken' => $this->security->get_csrf_hash()));
        }
    }

    public function deleteHealthHistory() {
        $healthhistoryId = htmlspecialchars($this->input->post('healthhistoryId'));
        $this->M_healthhistories->deleteHealthHistory($healthhistoryId);

        echo json_encode(array('status' => 'success', 'csrfToken' => $this->security->get_csrf_hash()));
    }

}

/* End of file HealthHistories.php */

?>