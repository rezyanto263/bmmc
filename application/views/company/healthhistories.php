<div class="content-body py-3">
    <div id="#crudAlert" data-flashdata="" data-errorflashdata=""></div>
    <table id="healthhistoriesTable" class="table" style="width:100%">
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



<!-- Modal View -->
<div class="modal fade" id="viewHealthHistoryModal" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
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
                            <i class="las la-user-tag fs-4"></i>
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