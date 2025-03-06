<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_invoices extends CI_Model {

  public function getAllCompanyInvoiceDatas() {
    $this->db->select('
        b.*,
        inv.invoiceId, inv.invoiceNumber, inv.invoiceDate, inv.invoiceSubtotal, 
        inv.invoiceDiscount, inv.invoiceTotalBill, COALESCE(inv.invoiceStatus, "upcoming") as invoiceStatus,
        c.companyName, c.companyLogo, c.companyPhone,
        c.companyStatus, c.companyAddress, c.companyCoordinate,
        a.adminName, a.adminEmail,
        IFNULL(SUM(DISTINCT hh.healthhistoryTotalBill), 0) as billingUsed,
    ');
    $this->db->from('billing b');
    $this->db->join('invoice inv', 'inv.billingId = b.billingId', 'left');
    $this->db->join('company c', 'c.companyId = b.companyId', 'left');
    $this->db->join('admin a', 'a.adminId = c.adminId', 'left');
    $this->db->join('healthhistory hh', 'hh.billingId = b.billingId', 'left');
    $this->db->group_by('b.billingId');
    return $this->db->get()->result_array();
  }

  public function getAllInvoicesByCompanyId($companyId) {
    $this->db->select('
        b.*,
        inv.invoiceId, inv.invoiceNumber, inv.invoiceDate, inv.invoiceSubtotal, 
        inv.invoiceDiscount, inv.invoiceTotalBill, COALESCE(inv.invoiceStatus, "upcoming") as invoiceStatus,
        c.companyName, c.companyLogo, c.companyPhone,
        c.companyStatus, c.companyAddress, c.companyCoordinate,
        a.adminName, a.adminEmail,
        IFNULL(SUM(hh.healthhistoryTotalBill), 0) as billingUsed,
    ');
    $this->db->from('billing b');
    $this->db->join('invoice inv', 'inv.billingId = b.billingId', 'left');
    $this->db->join('company c', 'c.companyId = b.companyId', 'left');
    $this->db->join('admin a', 'a.adminId = c.adminId', 'left');
    $this->db->join('healthhistory hh', 'hh.billingId = b.billingId', 'left');
    $this->db->where('b.companyId', $companyId);
    $this->db->group_by('b.billingId');
    return $this->db->get()->result_array();
  }

  public function getDepartmentAllocationBillsByBillingId($billingId) {
    $this->db->select("
        COALESCE(e.employeeDepartment, e2.employeeDepartment) AS departmentName,
        
        COUNT(DISTINCT CASE WHEN hh.patientRole = 'employee' THEN hh.patientNIK END) AS totalEmployees,
        COUNT(DISTINCT CASE WHEN hh.patientRole = 'family' THEN hh.patientNIK END) AS totalFamilies,
        
        COUNT(DISTINCT CASE WHEN hh.healthhistoryReferredTo IS NULL AND hh.healthhistoryTotalBill != 0 THEN hh.healthhistoryId END) AS totalBilledTreatments,
        COUNT(DISTINCT CASE WHEN hh.healthhistoryReferredTo IS NOT NULL THEN hh.healthhistoryId END) AS totalReferredTreatments,
        COUNT(DISTINCT CASE WHEN hh.healthhistoryReferredTo IS NULL AND hh.healthhistoryTotalBill = 0 THEN hh.healthhistoryId END) AS totalFreeTreatments,

        COUNT(DISTINCT hh.healthhistoryId) AS totalTreatments,
        SUM(hh.healthhistoryTotalBill) AS departmentTotalBill
    ", false);

    $this->db->from('billing b');
    $this->db->join('healthhistory hh', 'hh.billingId = b.billingId', 'left');
    $this->db->join('employee e', 'e.employeeNIK = hh.patientNIK AND hh.patientRole = "employee"', 'left');
    $this->db->join('family f', 'f.familyNIK = hh.patientNIK AND hh.patientRole = "family"', 'left');
    $this->db->join('employee e2', 'e2.employeeNIK = f.employeeNIK', 'left');

    $this->db->where('b.billingId', $billingId);
    $this->db->group_by('departmentName');

    return $this->db->get()->result_array();
  }

  public function checkCurrentBillingByCompanyId($companyId) {
    $this->db->select('b.*, IFNULL(SUM(hh.healthhistoryTotalBill), 0) as totalBillingUsed');
    $this->db->from('billing b');
    $this->db->join('healthhistory hh', 'hh.billingId = b.billingId', 'left');
    $this->db->where('companyId', $companyId);
    $this->db->where('MONTH(b.billingStartedAt) = MONTH(CURDATE())');
    $this->db->where('YEAR(b.billingStartedAt) = YEAR(CURDATE())');
    $this->db->where('CURDATE() BETWEEN b.billingStartedAt AND b.billingEndedAt');
    return $this->db->get()->row_array();
  }

  public function checkInvoice($param, $value) {
    return $this->db->get_where('invoice', array($param => $value))->row_array();
  }

  public function checkBilling($param, $value) {
    return $this->db->get_where('billing', array($param => $value))->row_array();
  }

  public function updateInvoice($invoiceId, $invoiceDatas) {
    $this->db->where('invoiceId', $invoiceId);
    return $this->db->update('invoice', $invoiceDatas);
  }

}

/* End of file M_invoices.php */

?>