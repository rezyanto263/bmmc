<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

use Mpdf\Mpdf;

class Invoices extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if ($this->session->userdata('adminRole') != 'admin') {
            redirect('dashboard/login');
        }

        $this->load->model('M_invoices');
    }

    public function index() {
        $datas = array(
            'title' => 'BMMC Dashboard | Invoices',
            'subtitle' => 'Invoices',
            'contentType' => 'dashboard',
        );

        $partials = array(
            'head' => 'partials/head',
            'sidebar' => 'partials/dashboard/sidebar',
            'floatingMenu' => 'partials/floatingMenu',
            'contentHeader' => 'partials/contentHeader',
            'contentBody' => 'dashboard/invoices',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

    public function getAllCompanyInvoiceDatas() {
        $companyInvoiceDatas = $this->M_invoices->getAllCompanyInvoiceDatas();
        $datas = array(
        'data' => $companyInvoiceDatas
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

    public function createInvoice() {
        $invoiceId = $this->input->post('invoiceId');
        $billingId = $this->input->post('billingId');
        $discountValue = $this->input->post('invoiceDiscount');

        $invoiceCurrentData = $this->M_invoices->checkInvoice('invoiceId', $invoiceId);

        $invoiceDatas = array(
            'invoiceDiscount' => $discountValue,
            'invoiceTotalBill'=> (float) $invoiceCurrentData['invoiceSubtotal'] - (float) $discountValue
        );
        $this->M_invoices->updateInvoice($invoiceId, $invoiceDatas);

        if (in_array($invoiceCurrentData['invoiceStatus'], ['upcoming', 'unpaid', 'paid', 'free'])) {
            echo json_encode(array(
                'status' => 'failed',
                'failedMsg' => 'invoice status not allowed',
                'csrfToken' => $this->security->get_csrf_hash()
            ));
            return;
        }

        $invoiceData = $this->M_invoices->checkInvoice('invoiceId', $invoiceId);
        $deparmentAllocationBillsData = $this->M_invoices->getDepartmentAllocationBillsByBillingId($billingId);
        $billingData = $this->M_invoices->checkBilling('billingId', $billingId);
        $totalTreatments = 0;
        foreach ($deparmentAllocationBillsData as $key => $value) {
            $totalTreatments += $value['totalTreatments'];
        }

        $this->load->model('M_companies');
        $companyData = $this->M_companies->checkCompany('companyId', $billingData['companyId']);

        $this->load->model('M_admins');
        $adminData = $this->M_admins->checkAdmin('adminId', $companyData['adminId']);
        $datas = array(
            'invoice' => $invoiceData,
            'department' => $deparmentAllocationBillsData,
            'companyName' => $companyData['companyName'],
            'companyAddress' => $companyData['companyAddress'],
            'companyPhone' => $companyData['companyPhone'],
            'companyEmail' => $adminData['adminEmail'],
            'billingAmount' => $billingData['billingAmount'],
            'billingStartedAt' => $billingData['billingStartedAt'],
            'billingEndedAt' => $billingData['billingEndedAt'],
            'totalTreatments' => $totalTreatments,
            'bmmcPhone' => $_ENV['SUPPORT_PHONE'],
            'bmmcEmail' => $_ENV['SUPPORT_EMAIL']
        );

        $html = $this->load->view('pdf/invoice', $datas, TRUE);
        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4',
            'orientation' => 'P',
            'margin_top' => 0,
            'margin_bottom' => 0,
            'margin_left' => 0,
            'margin_right' => 0,
            'tempDir' => FCPATH. 'uploads/temp/'
        ]);

        $mpdf->WriteHTML($html);
        $mpdf->Output(FCPATH . 'uploads/invoices/' . $invoiceData['invoiceNumber'] . '.pdf', 'F');

        $this->M_invoices->updateInvoice($invoiceId, array('invoiceStatus' => 'unpaid'));

        echo json_encode(array(
            'status' =>'success',
            'invoiceNumber' => $invoiceData['invoiceNumber'],
            'csrfToken' => $this->security->get_csrf_hash()
        ));
    }

    public function markInvoicesAsPaid() {
        $invoiceIds = $this->input->post('invoiceIds');

        if ($invoiceIds == null) {
            echo json_encode(array(
                'status' => 'failed',
                'failedMsg' => 'invoiceIds is null',
                'csrfToken' => $this->security->get_csrf_hash()
            ));
            return;
        }

        foreach ($invoiceIds as $key => $value) {
            $checkInvoice = $this->M_invoices->checkInvoice('invoiceId', $value);
            if ($checkInvoice['invoiceStatus'] != 'unpaid') {
                echo json_encode(array(
                    'status' => 'failed',
                    'failedMsg' => 'invoice status not allowed',
                    'csrfToken' => $this->security->get_csrf_hash()
                ));
                return;
            }
        }

        foreach ($invoiceIds as $key => $value) {
            $this->M_invoices->updateInvoice($value, array('invoiceStatus' => 'paid'));
        }

        echo json_encode(array(
            'status' => 'success',
            'csrfToken' => $this->security->get_csrf_hash()
        ));
    }

    public function markInvoiceAsUnpaid() {
        $invoiceId = $this->input->post('invoiceId');

        $checkInvoice = $this->M_invoices->checkInvoice('invoiceId', $invoiceId);
        if ($checkInvoice['invoiceStatus'] != 'paid') {
            echo json_encode(array(
                'status' => 'failed',
                'failedMsg' => 'invoice status not allowed',
                'csrfToken' => $this->security->get_csrf_hash()
            ));
            return;
        }

        $this->M_invoices->updateInvoice($invoiceId, array('invoiceStatus' => 'unpaid'));

        echo json_encode(array(
            'status' => 'success',
            'csrfToken' => $this->security->get_csrf_hash()
        ));
    }

}

/* End of file Invoices.php */

?>