<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Invoices extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('adminRole') != 'company') {
            redirect('dashboard');
        }

        $this->load->model('M_invoices');
    }

    public function index() {
        $datas = array(
            'title' => 'BMMC Company | Invoices',
            'subtitle' => 'Invoices',
            'contentType' => 'dashboard'
        );

        $partials = array(
            'head' => 'partials/head',
            'sidebar' => 'partials/company/sidebar',
            'floatingMenu' => 'partials/floatingMenu',
            'contentHeader' => 'partials/contentHeader',
            'contentBody' => 'company/invoices',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

    public function getAllInvoicesByCompanyId() {
        $companyId = $this->input->get('id') ?: $this->session->userdata('companyId');
        $companyInvoicesDatas = $this->M_invoices->getAllInvoicesByCompanyId($companyId);
        $datas = array(
            'data' => $companyInvoicesDatas
        );

        echo json_encode($datas);
    }

    public function getDepartmentAllocationBillsByBillingId() {
        $billingId = $this->input->get('id');
        $deparmentAllocationBillsData = $this->M_invoices->getDepartmentAllocationBillsByBillingId($billingId);
        $datas = array(
            'data' => !empty($deparmentAllocationBillsData[0]['departmentName']) ? $deparmentAllocationBillsData : []
        );

        echo json_encode($datas);
    }

}

/* End of file Company.php */

?>