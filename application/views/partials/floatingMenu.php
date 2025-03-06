<!-- Floating Menu Start -->
<div class="floating-btn position-fixed d-flex m-3 gap-3">
    <button class="p-2 rounded floating-btn shadow-sm" id="btn-menu">
        <i class="las la-chevron-circle-left fs-3"></i>
    </button>
    <button class="p-2 rounded floating-btn shadow-sm" id="btn-mode">
        <i class="las la-moon fs-3"></i>
    </button>
    <button class="p-2 rounded floating-btn shadow-sm" id="btn-scan" data-bs-toggle="modal" data-bs-target="#scannerModal">
        <i class="las la-qrcode fs-3"></i>
    </button>
</div>
<!-- Floating Menu End -->

<!-- Scan Modal Start -->
<div class="modal fade" id="scannerModal" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content overflow-hidden">
            <div class="modal-header border-0">
                <h1 class="modal-title fs-5">QR SCANNER</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 d-flex flex-column justify-content-center">
                <video class="m-0" id="qrScanner"></video>
                <form id="qrForm" class="text-center px-5">
                    <div id="adminRole" data-admin-role="<?= base64_encode($this->session->userdata('adminRole')); ?>" hidden></div>
                    <input class="border border-1 rounded my-3 text-center w-100" readonly type="text" placeholder="Scan your QR please!" name="qrData">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Scan Modal End -->

<!-- Scan Result Modal Start -->
<div id="#crudAlert" data-flashdata="" data-errorflashdata=""></div>
<div class="modal fade" id="scanResultModal" data-bs-backdrop="static">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header shadow border-0">
                <h1 class="modal-title fs-5">SCAN RESULT</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-xxl">
                    <h1>Profile Details</h1>
                    <div class="row gy-4 mt-auto mb-5">
                        <div class="col-12 col-xl-3 my-auto mb-4 mb-xl-auto d-flex justify-content-center">
                            <div class="imgContainer my-auto" style="max-width: 300px; max-height: 300px; width: 300px; height: auto;">
                                <img class="object-fit-cover" src="<?= base_url('assets/images/user-placeholder.png') ?>" id="imgPreview" alt="User Photo"  draggable="false">
                            </div>
                        </div>
                        <div class="col-12 col-xl-9 my-auto">
                            <div class="row gy-4 gx-3 py-auto">
                                <div class="col-12 col-md-6">
                                    <div class="input-group p-0">
                                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="NIK">
                                            <i class="las la-id-card fs-4"></i>    
                                        </span>
                                        <div class="form-control" id="nik"></div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="input-group p-0">
                                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Name">
                                            <i class="las la-user fs-4"></i>
                                        </span>
                                        <div class="form-control" id="name"></div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="input-group p-0">
                                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company Name">
                                            <i class="las la-building fs-4"></i>
                                        </span>
                                        <div class="form-control" id="companyName"></div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="input-group p-0">
                                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Department">
                                            <i class="las la-sitemap fs-4"></i>
                                        </span>
                                        <div class="form-control" id="department"></div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-3">
                                    <div class="input-group p-0">
                                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Band">
                                            <i class="las la-layer-group fs-4"></i>
                                        </span>
                                        <div class="form-control" id="band"></div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-3">
                                    <div class="input-group p-0">
                                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Relationship">
                                            <i class="las la-link fs-4"></i>
                                        </span>
                                        <div class="form-control" id="relationship"></div>
                                    </div>
                                    <div id="role" hidden></div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="input-group p-0">
                                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Date of Birth">
                                            <i class="las la-birthday-cake fs-4"></i>
                                        </span>
                                        <div class="form-control" id="birth"></div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-2">
                                    <div class="input-group p-0">
                                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Gender">
                                            <i class="las la-transgender fs-4"></i>
                                        </span>
                                        <div class="form-control" id="gender"></div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="input-group p-0">
                                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Email">
                                            <i class="las la-envelope fs-4"></i>
                                        </span>
                                        <div class="form-control" id="email"></div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-3">
                                    <div class="input-group p-0">
                                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Phone Number">
                                            <i class="las la-phone fs-4"></i>
                                        </span>
                                        <div class="form-control" id="phone"></div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-3">
                                    <div class="input-group p-0">
                                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Status">
                                            <i class="las la-user-tag fs-4"></i>
                                        </span>
                                        <div class="form-control" id="status"></div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group p-0">
                                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Address">
                                            <i class="las la-map-marked-alt fs-4"></i>
                                        </span>
                                        <div class="form-control" id="address"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h1 class="mb-0">Insurance Details</h1>
                    <div class="row g-4 mb-5 mt-1">
                        <div class="col-12 col-lg-4">
                            <div class="card bg-transparent box-total">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <h5 class="card-title text-center">TREATMENTS THIS MONTH</h5>
                                    <h1 class="text-center fw-bold" id="totalTreatmentsThisMonth">0</h1>
                                    <div class="card-text text-center">
                                        <hr>
                                        <div class="d-flex justify-content-around">
                                            <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Billed">
                                                <i class="las la-file-medical text-success fs-4"></i>
                                                <span id="totalBilledTreatmentsThisMonth">0</span>
                                            </div>
                                            <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Referred">
                                                <i class="las la-file-medical text-info fs-4"></i>
                                                <span id="totalReferredTreatmentsThisMonth">0</span>
                                            </div>
                                            <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Free">
                                                <i class="las la-file-medical text-secondary-subtl fs-4"></i>
                                                <span id="totalFreeTreatmentsThisMonth">0</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="card bg-transparent box-total">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <h5 class="card-title text-center">TOTAL TREATMENTS</h5>
                                    <h1 class="text-center fw-bold" id="totalTreatments">0</h1>
                                    <div class="card-text text-center">
                                        <hr>
                                        <div class="d-flex justify-content-around">
                                            <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Billed">
                                                <i class="las la-file-medical text-success fs-4"></i>
                                                <span id="totalBilledTreatments">0</span>
                                            </div>
                                            <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Referred">
                                                <i class="las la-file-medical text-info fs-4"></i>
                                                <span id="totalReferredTreatments">0</span>
                                            </div>
                                            <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Free">
                                                <i class="las la-file-medical text-secondary-subtl fs-4"></i>
                                                <span id="totalFreeTreatments">0</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="card bg-transparent box-total">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <h5 class="card-title text-center">INSURANCE BILLING REMAINING</h5>
                                    <h4 class="text-center fw-bold"  id="totalBillingRemaining">Rp 000.000.000,00</h4>
                                    <span class="text-center" style="font-size: 0.8rem;" id="insuranceTier" data-bs-toggle="tooltip" data-bs-title="Insurance Tier">
                                        Insurance Tier
                                    </span>
                                    <div class="card-text text-center">
                                        <hr class="mt-0">
                                        <div class="d-flex justify-content-around">
                                            <div class="d-inline-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Billing Used">
                                                <i class="las la-credit-card text-danger fs-4"></i>
                                                <span style="font-size: 0.8rem;" id="totalBillingUsed">000.000.000</span>
                                            </div>
                                            <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Billing Amount">
                                                <i class="las la-credit-card text-info fs-4"></i>
                                                <span style="font-size: 0.8rem;" id="totalBillingAmount">000.000.000</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h1>Health History</h1>
                    <div class="row">
                        <table id="patientHealthHistoriesTable" class="table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Treatments Date</th>
                                    <th class="text-start">NIK</th>
                                    <th>Name</th>
                                    <th>Department</th>
                                    <th>Band</th>
                                    <th>Relationship</th>
                                    <th>Gender</th>
                                    <th>Status</th>
                                    <th>Invoice Status</th>
                                    <th class="text-end">Doctor Fee</th>
                                    <th class="text-end">Medicine Fee</th>
                                    <th class="text-end">Lab Fee</th>
                                    <th class="text-end">Action Fee</th>
                                    <th class="text-end">Discount</th>
                                    <th class="text-end">Total Bill</th>
                                    <th>Hospital</th>
                                    <th>Doctor</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <?php if (in_array($this->session->userdata('adminRole'), ['admin','hospital'])): ?>
                <div class="modal-footer border-0 d-flex justify-content-between" style="box-shadow: 0 -1rem 3rem rgba(0, 0, 0, 0.175)">
                    <h6 class="border border-secondary-subtle rounded" style="padding: 8px 10px;">Company Status : <span id="companyStatus"></span></h6>
                    <?php if ($this->session->userdata('adminRole') === 'hospital'): ?>
                    <div class="d-flex gap-1">
                        <button class="btn-danger" data-bs-dismiss="modal" aria-label="Close">CANCEL</button>
                        <button type="button" class="add-queue btn-primary d-flex align-items-center gap-2">
                            <i class="las la-plus-circle fs-4"></i>
                            ADD TO QUEUE
                        </button>
                    </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- Scan Result Modal End -->

<!-- View Health History Details Modal Start -->
<div class="modal fade" id="viewHealthHistoryDetailsModal" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h1 class="modal-title fs-4">HEALTH HISTORY DETAILS</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body border-0">
                <div class="row gy-4 gx-3">
                    <h5 class="m-0">Patient Details</h5>
                    <div class="col-12">
                        <div class="imgContainer mx-auto">
                            <img src="<?= base_url('assets/images/user-placeholder.png'); ?>" data-originalsrc="<?= base_url('assets/images/user-placeholder.png'); ?>" class="object-fit-cover w-100 h-100" draggable="false" alt="Patient Photo" id="patientPhoto">
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="input-group p-0">
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Patient NIK">
                            <i class="las la-id-card fs-4"></i>
                            </span>
                            <div class="form-control" id="patientNIK"></div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="input-group p-0">
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Patient Name">
                            <i class="las la-user fs-4"></i>
                            </span>
                            <div class="form-control" id="patientName"></div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-6">
                        <div class="input-group p-0">
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Patient Relationship">
                            <i class="las la-link fs-4"></i>
                            </span>
                            <div class="form-control" id="patientRelationship"></div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-6">
                        <div class="input-group p-0">
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Patient Gender">
                            <i class="las la-transgender fs-4"></i>
                            </span>
                            <div class="form-control" id="patientGender"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-7 col-lg-6">
                        <div class="input-group p-0">
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Patient Department">
                            <i class="las la-sitemap fs-4"></i>
                            </span>
                            <div class="form-control" id="patientDepartment"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-5 col-lg-6">
                        <div class="input-group p-0">
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Patient Band">
                            <i class="las la-layer-group fs-4"></i>
                            </span>
                            <div class="form-control" id="patientBand"></div>
                        </div>
                    </div>
                    <input type="hidden" name="patientRole">
                    <h5 class="mb-0">Treatment Details</h5>
                    <div class="col-12">
                        <div class="input-group p-0">
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Hospital">
                            <i class="las la-hospital fs-4"></i>
                            </span>
                            <div class="form-control" id="hospitalName"></div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="input-group p-0">
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Status">
                            <i class="las la-tag fs-4"></i>
                            </span>
                            <div class="form-control" id="healthhistoryStatus"></div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="input-group p-0">
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Invoice Status">
                            <i class="las la-file-invoice-dollar fs-4"></i>
                            </span>
                            <div class="form-control" id="invoiceStatus"></div>
                        </div>
                    </div>
                    <div class="col-12 referredInput" style="display: none;">
                        <div class="input-group p-0">
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Referred To">
                                <i class="lab la-telegram-plane fs-4"></i>
                            </span>
                            <div class="form-control" id="healthhistoryReferredTo"></div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="input-group p-0">
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Date">
                            <i class="las la-calendar-day fs-4"></i>
                            </span>
                            <div class="form-control" id="healthhistoryDate"></div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="input-group p-0">
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Doctor">
                            <i class="las la-stethoscope fs-4"></i>
                            </span>
                            <div class="form-control" id="doctorName"></div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="input-group p-0 flex-nowrap">
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Disease">
                                <i class="las la-heartbeat fs-4"></i>
                            </span>
                            <div class="form-control" id="diseaseNames"></div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="input-group p-0">
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Description">
                                <i class="las la-notes-medical fs-4"></i>
                            </span>
                            <textarea class="form-control" placeholder="Description (e.g., Diagnoses, Notes, Referrals) – Optional" name="healthhistoryDescription" readonly></textarea>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="input-group p-0">
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Doctor Fee">
                                <i class="las la-stethoscope fs-4"></i>
                            </span>
                            <div class="form-control currency-input" id="healthhistoryDoctorFee"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">   
                        <div class="input-group p-0">
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Medicine Fee">
                                <i class="las la-capsules fs-4"></i>
                            </span>
                            <div class="form-control currency-input" id="healthhistoryMedicineFee"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="input-group p-0">
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Lab Fee">
                                <i class="las la-flask fs-4"></i>
                            </span>
                            <div class="form-control currency-input" id="healthhistoryLabFee"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="input-group p-0">
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Action Fee">
                                <i class="las la-briefcase-medical fs-4"></i>
                            </span>
                            <div class="form-control currency-input" id="healthhistoryActionFee"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="input-group p-0">
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Discount">
                                <i class="las la-percent fs-4"></i>
                            </span>
                            <div class="form-control currency-input discount text-danger" id="healthhistoryDiscount"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="input-group p-0">
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Total Bill">
                                <i class="las la-money-bill-wave fs-4"></i>
                            </span>
                            <div class="form-control currency-input text-info" id="healthhistoryTotalBill"></div>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-between flex-column flex-lg-row">
                        <small class="text-secondary">
                            Created At: <span id="createdAt"></span>
                        </small>
                        <small class="text-secondary">
                            Updated At: <span id="updatedAt"></span>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- View Health History Details Modal End -->

<!-- Add Queue Modal -->
<div class="modal fade" id="addQueueModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content overflow-hidden">
            <form id="addQueueForm">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">
                        ADD TO QUEUE
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    Are you sure want to add "<span class="fw-bold" id="patientName"></span>" to queue?
                    <input type="hidden" name="patientNIK">
                    <input type="hidden" name="patientRole">
                </div>
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <div class="modal-footer border-0">
                    <button type="button" class="btn-danger" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn-primary" id="addQueueButton">ADD TO QUEUE</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add Queue Modal End -->
