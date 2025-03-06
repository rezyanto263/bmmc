<div class="content-body py-3">
    <div class="row g-4">
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card bg-info border border-secondary-subtle">
                <div class="card-body text-center text-white py-4">
                    <i class="las la-building display-2"></i>
                    <h2 class="mb-0" id="totalCompanies"><?= $totalCompanies; ?></h2>
                    <p class="mb-0 fs-5">Total Companies</sp>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card bg-warning border border-secondary-subtle">
                <div class="card-body text-center text-white py-4">
                    <i class="las la-file-invoice-dollar display-2"></i>
                    <h2 class="mb-0" id="totalInvoices"><?= $totalInvoices; ?></h2>
                    <p class="mb-0 fs-5">Total Invoices</sp>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card bg-success border border-secondary-subtle">
                <div class="card-body text-center text-white py-4">
                    <i class="las la-hospital display-2"></i>
                    <h2 class="mb-0" id="totalHospitals"><?= $totalHospitals; ?></h2>
                    <p class="mb-0 fs-5">Total Hospitals</sp>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card bg-danger border border-secondary-subtle">
                <div class="card-body text-center text-white py-4">
                    <i class="las la-file-medical-alt display-2"></i>
                    <h2 class="mb-0" id="totalTreatments"><?= $totalTreatments; ?></h2>
                    <p class="mb-0 fs-5">Total Treatments</sp>
                </div>
            </div>
        </div>
        <div class="col-12">
            <h5 class="text-center fw-bold mb-0"><?= strtoupper(date('1 F Y')) . ' - ' . strtoupper(date('d F Y')); ?></h5>
        </div>
        <div class="col-12 col-md-4">
            <div class="card border border-secondary-subtle text-center">
                <div class="card-header border-0 bg-danger text-white py-1">
                    <h5 class="card-title m-0">Reserve Funds</h5>
                </div>
                <div class="card-body py-1 dashboardMoneyInfo">
                    <h2 class="fw-bold mb-0" id="reserveFunds"><?= 'Rp ' . number_format($reserveFunds, 0, ',', '.'); ?></h2>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card border border-secondary-subtle text-center">
                <div class="card-header border-0 bg-info text-white py-1">
                    <h5 class="card-title m-0">Claim Payouts</h5>
                </div>
                <div class="card-body py-1 dashboardMoneyInfo">
                    <h2 class="fw-bold mb-0" id="claimPayouts"><?= 'Rp ' . number_format($claimPayouts, 0, ',', '.'); ?></h2>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card border border-secondary-subtle text-center">
                <div class="card-header border-0 bg-secondary text-white py-1">
                    <h5 class="card-title m-0">Unutilized Funds</h5>
                </div>
                <div class="card-body py-1 dashboardMoneyInfo">
                    <h2 class="fw-bold mb-0" id="unutilizedFunds"><?= 'Rp ' . number_format($unutilizedFunds, 0, ',', '.'); ?></h2>
                </div>
            </div>
        </div>
    </div>
</div>