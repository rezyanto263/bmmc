<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invoice</title>
</head>
<style>
  html, body {
    background: #EEE;
    font-family: 'Roboto', sans-serif;
    margin: 0;
    padding: 0;
    max-width: 210mm !important;
    max-height: 297mm !important;
    width: 100%;
    height: 100%;
  }

  .table {
    width: 100%;
    background-color: transparent;
  }

  .table-bordered {
    border: 1px solid #ddd;
  }

  .table-bordered th,
  .table-bordered td {
    border: 1px solid #ddd;
    padding-left: 5px;
    padding-right: 5px;
    padding-top: 10px;
    padding-bottom: 10px;
  }

  table th,
  table td {
    vertical-align: top;
    text-align: start;
    min-width: 1px;
  }

  .table-condensed {
    border-collapse: collapse;
  }
  
  .invoice {
    background: #fff;
    max-width: 210mm !important;
    max-height: 297mm !important;
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 0;
  }
  .invoice .invoice-header {
    padding: 20px 20px 15px;
  }
  .invoice .invoice-header h1 {
    margin: 0;
  }
  .invoice .invoice-header .media .media-body {
    font-size: 0.9em;
    margin: 0;
  }
  .invoice .invoice-body {
    border-radius: 10px;
    padding: 25px;
    background: #FFF;
  }
  .invoice .invoice-footer {
    padding: 15px;
    font-size: 0.9em;
    text-align: center;
    color: #999;
  }

  .invoice-h1 {
    font-size: 2.5rem;
    color: #00afef !important;
  }
  
  .logo {
    height: 100%;
    max-height: 65px;
  }

  .rowtotal {
    font-size: 1.3em;
  }

  .hr {
    background: rgba(0,175,239,1);
    background: linear-gradient(45deg, rgba(0,175,239,1) 0%, rgba(129,206,139,1) 100%);
    height: 0.8rem;
    width: 100%;
  }

  .hr-reverse {
    background: rgba(129,206,139,1);
    background: linear-gradient(45deg, rgba(129,206,139,1) 0%, rgba(0,175,239,1) 100%);
    height: 0.8rem;
    width: 100%;
  }

  .panel-heading {
    background: #f5f5f5;
  }

  .panel-title {
    font-size: 18px;
    font-weight: bold;
  }

  .panel-body {
    border: 1px solid #ececec !important;
  }

  .fw-bold {
    font-weight: bold;
  }

  .lh-1 {
    line-height: 1;
  }

  .m-0 {
    margin: 0;
  }

  .mb-0 {
    margin-bottom: 0 !important;
  }

  .mb-3 {
    margin-bottom: 15px !important;
  }

  .mb-4{
    margin-bottom: 20px !important;
  }

  .mt-5 {
    margin-top: 40px !important; 
  }

  .w-100 {
    width: 100%;
  }

  .w-50 {
    width: 50%;
  }

  .h-100 {
    height: 100%;
  }

  .px-3 {
    padding-left: 15px !important;
    padding-right: 15px !important;
  }

  .py-3 {
    padding-top: 15px !important;
    padding-bottom: 15px !important;
  }

  .py-2 {
    padding-top: 10px !important;
    padding-bottom: 10px !important;
  }

  .py-1 {
    padding-top: 5px !important;
    padding-bottom: 5px !important;
  }

  .ps-3 {
    padding-left: 15px;
  }

  .ps-2 {
    padding-left: 10px;
  }

  .ps-1 {
    padding-left: 5px;
  }

  .pe-3 {
    padding-right: 15px;
  }

  .pe-2 {
    padding-right: 10px;
  }

  .pt-2 {
    padding-top: 10px;
  }

  .pb-2 {
    padding-bottom: 10px;
  }

  .text-info {
    color: #00afef;
  }

  .bg-info {
    background-color: #00afef;
  }

  .text-danger {
    color: #ff4545;
  }

  .bg-danger {
    background-color: #ff4545;
  }

  .text-white {
    color: #fff;
  }

  .border-none {
    border: none;
  }

  .align-top {
    vertical-align: top;
  }

  .align-middle {
    vertical-align: middle;
  }

  .text-center {
    text-align: center;
  }

  .text-start {
    text-align: left;
  }

  .text-end {
    text-align: right;
  }

  .table {
    border-collapse: collapse;
  } 
</style>
<body> 
  <div class="invoice"> 
    <div class="invoice-header">
      <table class="w-100">
        <tr>
          <td class="media align-middle w-50">
            <table class="w-100">
              <tr>
                <td class="text-center" style="width: 65px;">
                  <img class="logo align-middle text-center" src="<?= base_url('assets/images/logo.png'); ?>">
                </td>
                <td>
                  <h4 class="fw-bold m-0 lh-1">
                    BALI MITRA <br>
                    MEDICAL CENTER
                  </h4>
                  <p class="m-0 lh-1" style="font-size: small;">
                    Health Insurance Service <br>
                    Provider in Bali
                  </p>
                </td>
              </tr>
            </table>
          </td>
          <td class="w-50" style="text-align: right; vertical-align: middle;">
              <h1 class="invoice-h1 fw-bold m-0">Invoice</h1>
              <h4 class="fw-bold m-0"><?= $invoice['invoiceNumber']; ?></h4>
          </td>
        </tr>
      </table>
    </div>
    <div class="hr"></div>
    <div class="invoice-body">
    <table class="w-100 mb-4" style="margin-left: auto; margin-right: auto;">
        <tr>
          <td class="pe-2 w-50">
            <table class="w-100" style="border-spacing: 0;">
              <thead>
                <tr>
                  <td class="panel-heading" style="padding-left: 15px; padding-top: 10px; padding-bottom: 10px;">
                    <h3 class="panel-title m-0">To Company</h3>
                  </td>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="border: 1px solid #ddd;">
                    <table class="w-100">
                      <tr>
                        <td class="ps-3 pt-2 fw-bold align-top">Name</td>
                        <td class="px-3 pt-2 fw-bold align-top">:</td>
                        <td class="pe-3 pt-2"><?= $companyName; ?></td>
                      </tr>
                      <tr>
                        <td class="ps-3 fw-bold align-top">Email</td>
                        <td class="px-3 fw-bold align-top">:</td>
                        <td class="pe-3"><?= $companyEmail; ?></td>
                      </tr>
                      <tr>
                        <td class="ps-3 fw-bold">Phone</td>
                        <td class="px-3 fw-bold">:</td>
                        <td class="pe-3"><?= $companyPhone; ?></td>
                      </tr>
                      <tr>
                        <td class="ps-3 pb-2 fw-bold align-top">Address</td>
                        <td class="px-3 pb-2 fw-bold align-top">:</td>
                        <td class="pe-3 pb-2"><?= $companyAddress; ?></td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
          <td class="ps-2 w-50">
            <table class="w-100" style="border-spacing: 0;">
              <thead>
                <tr>
                  <td class="panel-heading" style="padding-left: 15px; padding-top: 10px; padding-bottom: 10px;">
                    <h3 class="panel-title m-0">Billing Information</h3>
                  </td>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="border: 1px solid #ddd;">
                    <table class="w-100">
                      <tbody>
                        <tr>
                          <td class="ps-3 pt-2 fw-bold align-top">Amount</td>
                          <td class="px-3 pt-2 fw-bold align-top">:</td>
                          <td class="pe-3 pt-2"><?= 'Rp ' . number_format($billingAmount, 0, ',', '.'); ?></td>
                        </tr>
                        <tr>
                          <td class="ps-3 fw-bold align-top">Start</td>
                          <td class="px-3 fw-bold align-top">:</td>
                          <td class="pe-3"><?= date('D, d F Y', strtotime($billingStartedAt)); ?></td>
                        </tr>
                        <tr>
                          <td class="ps-3 fw-bold">End</td>
                          <td class="px-3 fw-bold">:</td>
                          <td class="pe-3"><?= date('D, d F Y', strtotime($billingEndedAt)); ?></td>
                        </tr>
                        <tr>
                          <td class="ps-3 pb-2 fw-bold align-top">Total</td>
                          <td class="px-3 pb-2 fw-bold align-top">:</td>
                          <td class="pe-3 pb-2"><?= $totalTreatments; ?> Treatments</td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
      </table>
      <div class="panel panel-default">
        <div class="panel-heading" style="padding-left: 15px; padding-top: 10px; padding-bottom: 10px;">
          <h3 class="panel-title m-0">Departments Allocation Bill</h3>
        </div>
        <table class="table table-bordered table-condensed mb-4 w-100">
          <thead class="text-center">
            <tr class="text-center">
                <th style="text-align: center;">Department Name</th>
                <th style="text-align: center;">Employee</th>
                <th style="text-align: center;">Family</th>
                <th style="text-align: center;">Billed</th>
                <th style="text-align: center;">Referred</th>
                <th style="text-align: center;">Free</th>
                <th style="text-align: center;">Total Treatments</th>
                <th style="text-align: center;">Total Bill</th>
            </tr>
          </thead>
          <tbody class="text-center">
            <?php foreach($department as $d): ?>
            <tr class="text-center">
              <td style="text-align: center;"><?= $d['departmentName']; ?></td>
              <td style="text-align: center;"><?= $d['totalEmployees']; ?></td>
              <td style="text-align: center;"><?= $d['totalFamilies']; ?></td>
              <td style="text-align: center;"><?= $d['totalBilledTreatments']; ?></td>
              <td style="text-align: center;"><?= $d['totalReferredTreatments']; ?></td>
              <td style="text-align: center;"><?= $d['totalFreeTreatments']; ?></td>
              <td style="text-align: center;"><?= $d['totalTreatments']; ?></td>
              <td style="text-align: center;"><?= 'Rp ' . number_format($d['departmentTotalBill'], 0, ',', '.'); ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>      
      <div class="panel panel-default">
        <table class="table table-bordered table-condensed mb-4 w-100">
          <thead>
            <tr>
              <th style="text-align: center; background-color: #f5f5f5;" class="py-1">Subtotal</th>
              <th style="text-align: center;" class="py-1 text-white bg-danger">Discount</th>
              <th style="text-align: center;" class="py-1 text-white bg-info">Total</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th style="text-align: center;" class="rowtotal">
                <?= 'Rp ' . number_format($invoice['invoiceSubtotal'], 0, ',', '.'); ?>
              </th>
              <th style="text-align: center;" class="rowtotal text-danger">
                <?= 'Rp ' . number_format($invoice['invoiceDiscount'], 0, ',', '.'); ?>
              </th>
              <th style="text-align: center;" class="rowtotal text-info">
                <?= 'Rp ' . number_format($invoice['invoiceTotalBill'], 0, ',', '.'); ?>
              </th>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="panel-default px-3" style="border: 0;">
        <i>Comments / Notes</i>
        <hr class="m-0" />
        <div style="border: 0; font-size: 13px; text-align: justify;">
          Thank you for your continued trust in Bali Mitra Medical Center. 
          For any questions or assistance, please don't hesitate to contact us at <?= $bmmcPhone; ?> or <?= $bmmcEmail; ?>.
        </div>
      </div>
      <div class="row justify-content-around mt-5">
        <p class="text-center mb-0"><?= date('l, d F Y', strtotime($invoice['invoiceDate'])); ?></p>
        <div class="align-self-center">
          <div class="panel-default text-center" style="border: 0;">
            <strong>APPROVED BY</strong>
            <br>
            <img style="width: 100px" src="<?= base_url('assets/images/ttd.png'); ?>">
            <br>
            <div>GOJO SANTOSO</div>
          </div>
        </div>
      </div>
    </div>
    <div class="invoice-footer">
      Thank you for choosing our services.
      <br/> We hope to see you again soon
      <br/> <strong>~ BMMC ~</strong>
    </div>
    <div class="hr-reverse"></div>
  </div>
</body>
</html>
