<div class="content-body py-3">
    <div id="#crudAlert" data-flashdata="" data-errorflashdata=""></div>
    <button type="button" class="btn-primary w-100 my-3 d-flex align-items-center justify-content-center gap-2" data-bs-toggle="modal" data-bs-target="#addHealthHistoryModal">
        <i class="las la-plus-circle fs-4"></i>    
        ADD HEALTH HISTORY
    </button>
    <table id="healthhistoriesTable" class="table" style="width:100%">
        <thead>
            <tr>
                <th>Treatments Date</th>
                <th>Company</th> 
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
                                <select class="form-control" title="Choose Company" name="companyId">
                                    <option hidden></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Patient NIK">
                                <i class="las la-id-card fs-4"></i>
                                </span>
                                <select class="form-control" title="Choose Patient NIK" name="patientNIK">
                                    <option hidden></option>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="patientRole">
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Hospital">
                                <i class="las la-hospital fs-4"></i>
                                </span>
                                <select class="form-control" title="Choose Hospital" name="hospitalId">
                                    <option hidden></option>
                                </select>
                            </div>
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
                                <input class="form-control" type="date" min="<?= date('Y-m-1'); ?>" max="<?= date('Y-m-d'); ?>" placeholder="Treatment Date" name="healthhistoryDate">
                            </div>
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
                        <div class="imgContainer position-relative mx-auto">
                            <img src="<?= base_url('assets/images/user-placeholder.png'); ?>" data-originalsrc="<?= base_url('assets/images/user-placeholder.png'); ?>" class="object-fit-cover w-100 h-100" draggable="false" alt="Patient Photo" id="patientPhoto">
                            <div class="position-absolute bottom-0 end-0 m-auto overflow-hidden" style="border-top-left-radius: 6px;width: 35px; heigth: 35px;">
                                <img src="<?= base_url('assets/images/company-placeholder.jpg') ?>" class="object-fit-contain w-100 h-100" alt="Company Logo" id="companyLogo">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="input-group p-0">
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company">
                            <i class="las la-building fs-4"></i>
                            </span>
                            <div class="form-control" id="companyName"></div>
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
                    <div class="col-6 col-lg-3">
                        <div class="input-group p-0">
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Patient Relationship">
                            <i class="las la-user-tag fs-4"></i>
                            </span>
                            <div class="form-control" id="patientRelationship"></div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
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



<!-- Modal Edit -->
<div class="modal fade" id="editHealthHistoryModal" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="editHealthHistoryForm">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">EDIT HEALTH HISTORY</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    <input type="hidden" name="healthhistoryId">
                    <div class="row gy-4 gx-3">
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company">
                                <i class="las la-building fs-4"></i>
                                </span>
                                <select class="form-control" title="Choose Company" name="companyId">
                                    <option hidden></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Patient NIK">
                                <i class="las la-id-card fs-4"></i>
                                </span>
                                <select class="form-control" title="Choose Patient NIK" name="patientNIK">
                                    <option hidden></option>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="patientRole">
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Hospital">
                                <i class="las la-hospital fs-4"></i>
                                </span>
                                <select class="form-control" title="Choose Hospital" name="hospitalId">
                                    <option hidden></option>
                                </select>
                            </div>
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
                                <input class="form-control" type="date" min="<?= date('Y-m-1'); ?>" max="<?= date('Y-m-d'); ?>" placeholder="Treatment Date" name="healthhistoryDate">
                            </div>
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
                    <button type="submit" class="btn-primary" id="editButton">SAVE</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Modal Delete -->
<div class="modal fade" id="deleteHealthHistoryModal" aria-hidden="true"  data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form id="deleteHealthHistoryForm">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">DELETE HEALTH HISTORY</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    <input type="hidden" name="healthhistoryId">
                    Are you sure you want to delete "<span class="fw-bold" id="patientName"></span>" health history at "<span class="fw-bold" id="healthhistoryDate"></span>"?
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn-primary" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn-danger" id="deleteHealthHistoryButton">DELETE</button>
                </div>
            </form>
        </div>
    </div>
</div>