<div class="content-body py-3">
    <div id="#crudAlert" data-flashdata="" data-errorflashdata=""></div>
    <table id="invoicesTable" class="table" style="width:100%">
        <thead>
            <tr>
                <th>Invoice Number</th>
                <th>Invoice Date</th>
                <th>Invoice Status</th>
                <th>Invoice Subtotal</th>
                <th>Invoice Discount</th>
                <th>Invoice Total Bill</th>
                <th>Billing Amount</th>
                <th>Billing Status</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>
</div>



<!-- Modal View -->
<div class="modal fade" id="viewInvoiceModal" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header border-0 shadow-lg">
                <div>
                    <h1 class="modal-title fs-4">INVOICE DETAILS</h1>
                    <span class="text-secondary">
                        <span id="invoiceNumber"></span> | <span id="invoiceDate"></span>
                    </sp>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body border-0">
                <div class="container-xxl">
                    <h1>Company</h1>
                    <div class="row gy-4 mt-auto mb-3">
                        <div class="col-12 col-xl-3 my-auto mb-4 mb-xl-auto d-flex justify-content-center">
                            <div class="imgContainer my-auto" style="max-width: 300px; width: 300px; height: auto;">
                                <img src="<?= base_url('assets/images/company-placeholder.jpg') ?>" data-originalsrc="<?= base_url('assets/images/company-placeholder.jpg') ?>" id="imgPreview" alt="User Photo"  draggable="false">
                            </div>
                        </div>
                        <div class="col-12 col-xl-9 my-auto">
                            <div class="row g-4 py-auto">
                                <div class="col-12 col-md-6">
                                    <div class="input-group p-0">
                                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company">
                                            <i class="las la-building fs-4"></i>
                                        </span>
                                        <div class="form-control" id="companyName"></div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="input-group p-0">
                                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Admin Account">
                                            <i class="las la-user-cog fs-4"></i>
                                        </span>
                                        <div class="form-control" id="adminId"></div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="input-group p-0">
                                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company Phone">
                                            <i class="las la-phone fs-4"></i>
                                        </span>
                                        <div class="form-control" id="companyPhone"></div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="input-group p-0">
                                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company Status">
                                            <i class="las la-tag fs-4"></i>
                                        </span>
                                        <div class="form-control" id="companyStatus"></div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="input-group p-0">
                                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Billing Amount">
                                            <i class="las la-credit-card fs-4"></i>
                                        </span>
                                        <div class="form-control" id="billingAmount"></div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="input-group p-0">
                                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company Coordinate">
                                            <i class="las la-map-marker fs-4"></i>
                                        </span>
                                        <div class="form-control" id="companyCoordinate"></div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group p-0">
                                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company Address">
                                            <i class="las la-map fs-4"></i>
                                        </span>
                                        <div class="form-control text-truncate" id="companyAddress"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h1 class="mt-5">Treatments</h1>
                        <div class="col-12 mt-0">
                            <table id="treatmentsTable" class="table" style="width:100%">
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
                        <h1>Department Allocation Bill</h1>
                        <div class="col-12 mt-0">
                            <table id="departmentAllocationBillsTable" class="table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th rowspan="2">Department Name</th>
                                        <th class="text-center pe-none p-0" colspan="6" data-dt-order="disable" style="border-bottom: 0; border-top: 2px solid #00afef;">Treatments</th>
                                        <th rowspan="2">Department Bill</th>
                                    </tr>
                                    <tr>
                                        <th class="py-1">Employee</th>
                                        <th class="py-1">Family</th>
                                        <th class="py-1"><div class="bg-success status-circle"></div><span class="d-inline">Billed</span></th>
                                        <th class="py-1"><div class="bg-info status-circle"></div><span class="d-inline">Referred</span></th>
                                        <th class="py-1"><div class="bg-secondary-subtle status-circle"></div><span class="d-inline">Free</span></th>
                                        <th class="py-1">Total</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="col-12">
                            <div class="row g-4 mt-3">
                                <div class="col-12 col-lg-4">
                                    <div class="card box-total p-3" style="background:rgba(78, 78, 78, 0.17)">
                                        <div class="card-body d-flex flex-column justify-content-between gap-3">
                                            <h5 class="card-title text-center">SUBTOTAL</h5>
                                            <h2 class="text-center fw-bold" id="invoiceSubtotal">Rp 000.000.000</h2>
                                            <hr class="my-0">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="card border border-danger box-total p-3" style="background:rgba(78, 78, 78, 0.17)">
                                        <div class="card-body d-flex flex-column justify-content-between gap-3">
                                            <h5 class="card-title text-center">DISCOUNT</h5>
                                            <h2 class="text-center fw-bold text-danger" id="invoiceDiscount">
                                                <div id="temporaryData" data-billingId="" data-invoiceId=""></div>
                                                <input class="currency-input text-center text-danger fw-bold w-100 bg-transparent" name="invoiceDiscount" disabled>
                                                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                                            </h2>
                                            <hr class="my-0">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="card border border-info box-total p-3" style="background:rgba(78, 78, 78, 0.17)">
                                        <div class="card-body d-flex flex-column justify-content-between gap-3">
                                            <h5 class="card-title text-center">FINAL TOTAL</h5>
                                            <h2 class="text-center fw-bold text-info" id="invoiceTotalBill">-</h2>
                                            <hr class="my-0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 justify-content-between" style="box-shadow:  0 -1rem 3rem rgba(0, 0, 0, 0.175)">
                <h6 class="border border-secondary-subtle rounded" style="padding: 8px 10px;">Status : <span id="invoiceStatus"></span></h6>
                <div>
                    <button class="btn-primary" type="button" id="btnViewInvoice" style="display: none;">VIEW INVOICE</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal View Treatment Details -->
<div class="modal fade" id="viewTreatmentsModal" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h1 class="modal-title fs-4">TREATMENT DETAILS</h1>
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
                    <div class="col-12 col-lg-6">
                        <div class="input-group p-0">
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Patient Relationship">
                            <i class="las la-user-tag fs-4"></i>
                            </span>
                            <div class="form-control" id="patientRelationship"></div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
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
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Status">
                            <i class="las la-tag fs-4"></i>
                            </span>
                            <div class="form-control" id="healthhistoryStatus"></div>
                        </div>
                    </div>
                    <div class="col-12">
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

<!-- Modal View Invoice PDF -->
<div class="modal fade" id="viewInvoicePdfModal" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h1 class="modal-title fs-4">INVOICE PDF</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body border-0 py-0 overflow-hidden">
                <iframe id="pdfViewer" src="" frameborder="0" width="100%" height="100%"></iframe>
            </div>
        </div>
    </div>
</div>