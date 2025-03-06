<div class="content-body py-3">
    <div id="#crudAlert" data-flashdata="" data-errorflashdata=""></div>
    <table id="queuesTable" class="table" style="width:100%">
        <thead>
            <tr>
                <th>Logo</th>
                <th>Company Name</th>
                <th>Company Status</th>
                <th class="text-start">Patient NIK</th>
                <th>Patient Name</th>
                <th class="text-center">Relationship</th>
                <th class="text-start">Created At</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
    </table>
</div>

<!-- Modal Add -->
<div class="modal fade" id="addHealthHistoryModal" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="addHealthHistoryForm">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">ADD HEALTH HISTORY</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    <div class="row gy-4 gx-3">
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company">
                                <i class="las la-building fs-4"></i>
                                </span>
                                <div class="form-control readonly" id="companyId"></div>
                            </div>
                            <input type="hidden" name="companyId">
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Patient NIK">
                                <i class="las la-id-card fs-4"></i>
                                </span>
                                <div class="form-control readonly" id="patientNIK"></div>
                            </div>
                            <input type="hidden" name="patientNIK">
                            <input type="hidden" name="patientRole">
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Hospital">
                                <i class="las la-hospital fs-4"></i>
                                </span>
                                <div class="form-control readonly" id="hospitalId"></div>
                            </div>
                            <input type="hidden" name="hospitalId">
                        </div>
                        <div class="col-12 d-flex w-100">
                            <div>
                                <input class="form-check-input" type="checkbox" id="referredCheck" data-bs-toggle="tooltip" data-bs-title="Referred Checkbox">
                                <label class="form-check-label">Referred?</label>
                            </div>
                        </div>
                        <div class="col-12 referredInput" style="display: none;">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Referred To">
                                    <i class="lab la-telegram-plane fs-4"></i>
                                </span>
                                <select class="form-control" title="Choose Referred Hospital" name="healthhistoryReferredTo">
                                    <option hidden></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Date">
                                <i class="las la-calendar-day fs-4"></i>
                                </span>
                                <div class="form-control readonly" id="healthhistoryDate"><?= date('D, d F Y'); ?></div>
                            </div>
                            <input class="form-control" type="hidden" name="healthhistoryDate" value="<?= date('Y-m-d'); ?>">
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Doctor">
                                <i class="las la-stethoscope fs-4"></i>
                                </span>
                                <select class="form-control" title="Choose Doctor" name="doctorId">
                                    <option hidden></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0 flex-nowrap">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Disease">
                                    <i class="las la-heartbeat fs-4"></i>
                                </span>
                                <select class="form-control" title="Choose Disease" name="diseaseIds[]" multiple="multiple" style="width: 60%">
                                    <option hidden></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Description">
                                    <i class="las la-notes-medical fs-4"></i>
                                </span>
                                <textarea class="form-control" placeholder="Description (e.g., Diagnoses, Notes, Referrals) – Optional" name="healthhistoryDescription"></textarea>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Doctor Fee">
                                    <i class="las la-stethoscope fs-4"></i>
                                </span>
                                <input class="form-control currency-input" placeholder="Doctor Fee" name="healthhistoryDoctorFee">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">   
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Medicine Fee">
                                    <i class="las la-capsules fs-4"></i>
                                </span>
                                <input class="form-control currency-input" placeholder="Medicine Fee" min="0" max="100000000" name="healthhistoryMedicineFee" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Lab Fee">
                                    <i class="las la-flask fs-4"></i>
                                </span>
                                <input class="form-control currency-input" placeholder="Lab Fee" min="0" max="100000000" name="healthhistoryLabFee" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Action Fee">
                                    <i class="las la-briefcase-medical fs-4"></i>
                                </span>
                                <input class="form-control currency-input" placeholder="Acion Fee" min="0" max="100000000" name="healthhistoryActionFee" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Discount">
                                    <i class="las la-percent fs-4"></i>
                                </span>
                                <input class="form-control currency-input discount text-danger" placeholder="Discount"  min="0" max="100000000" name="healthhistoryDiscount" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Total Bill">
                                    <i class="las la-money-bill-wave fs-4"></i>
                                </span>
                                <input class="form-control currency-input readonly text-info" placeholder="Total Bill" min="0" name="healthhistoryTotalBill" style="pointer-events: none;" readonly>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn-danger" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn-primary" id="addButton">ADD</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal View -->
<div class="modal fade" id="viewPatientDetailsModal" data-bs-backdrop="static">
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
                        <table id="queuedPatientHealthHistoriesTable" class="table" style="width:100%">
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
        </div>
    </div>
</div>

<!-- Modal View Health History Details -->
<div class="modal fade" id="viewQueuedPatientHealthHistoriesDetailsModal" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
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

<!-- Modal Delete -->
<div class="modal fade" id="deleteQueueModal" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form id="deleteQueueForm">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">
                        DELETE QUEUE
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    Are you sure want to delete "<span class="fw-bold" id="patientName"></span>" queue?
                    <input type="text" id="patientNIK" name="patientNIK" hidden>
                </div>
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <div class="modal-footer border-0">
                    <button type="button" class="btn-primary" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn-danger" id="deleteQueueButton">DELETE</button>
                </div>
            </form>
        </div>
    </div>
</div>