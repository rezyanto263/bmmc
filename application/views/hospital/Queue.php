<div class="content-body py-3">
    <div id="#crudAlert" data-flashdata="" data-errorflashdata=""></div>
    <table id="hQueueTable" class="table" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Patient Name</th>
                <th>Role</th>
                <th>Company Name</th>
                <th>Date Time</th>
                <th>Action</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>#</th>
                <th>Patient Name</th>
                <th>Role</th>
                <th>Company Name</th>
                <th>Date Time</th>
                <th>Action</th>
            </tr>
        </tfoot>
    </table>
</div>

<!-- Modal Add Treatment-->
<div class="modal fade" id="addTreatmentModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="addTreatmentForm">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">PROCESS FOR TREATMENT</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                <input type="text" id="patientNIK" name="patientNIK" hidden>
                <span id="companyId" hidden></span>
                    <div class="row gy-4">
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Patient Name">
                                    <i class="las la-user-injured fs-4"></i>
                                </span>
                                <span class="form-control" id="treatmentPatientName"></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Patient Role">
                                    <i class="las la-user-tag fs-4"></i>
                                </span>
                                <input class="form-control" type="text" name="role" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Employee Name">
                                    <i class="las la-user-shield fs-4"></i>
                                </span>
                                <span class="form-control" id="treatmentEmployeeName"></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company Name">
                                    <i class="las la-building fs-4"></i>
                                </span>
                                <span class="form-control" id="treatmentCompanyName"></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Available balance for insurance">
                                    <i class="las la-file-alt fs-4"></i>
                                </span>
                                <span class="form-control" id="insuranceAmount"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="History Health Date">
                                    <i class="las la-calendar-day fs-4"></i>
                                </span>
                                <input type="date" class="form-control" id="date" title="Date" name="historyhealthDate">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Doctor Name">
                                    <i class="las la-stethoscope fs-4"></i>
                                </span>
                                <select class="form-control" data-live-search="true" title="Choose Doctor" id="doctorId" name="doctorId">
                                    <option hidden></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Disease Name">
                                    <i class="las la-medkit fs-4"></i>
                                </span>
                                <select class="form-control" data-live-search="true" title="Choose Disease" id="diseaseId" name="diseaseId">
                                    <option hidden></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Doctor Fee">
                                    <i class="las la-briefcase-medical fs-4"></i>
                                </span>
                                <input class="form-control validate-non-negative" type="number" step="0.01" min="0" placeholder="Doctor Fee" name="historyhealthDoctorFee" id="historyhealthDoctorFee">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Medicine Fee">
                                    <i class="las la-pills fs-4"></i>
                                </span>
                                <input class="form-control validate-non-negative" type="number" step="0.01" min="0" placeholder="Medicine Fee" name="historyhealthMedicineFee" id="historyhealthMedicineFee">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Lab Fee">
                                    <i class="las la-file-alt fs-4"></i>
                                </span>
                                <input class="form-control validate-non-negative" type="number" step="0.01" min="0" placeholder="Lab Fee" name="historyhealthLabFee" id="historyhealthLabFee">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Action Fee">
                                    <i class="las la-file-alt fs-4"></i>
                                </span>
                                <input class="form-control validate-non-negative" type="number" step="0.01" min="0" placeholder="Action Fee" name="historyhealthActionFee" id="historyhealthActionFee">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Discount">
                                    <i class="las la-file-alt fs-4"></i>
                                </span>
                                <input class="form-control validate-non-negative" type="number" step="0.01" min="0" placeholder="Discount" name="historyhealthDiscount" id="historyhealthDiscount">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Total Bill">
                                    <i class="las la-money-bill-wave fs-4"></i>
                                </span>
                                <input class="form-control" type="number" placeholder="Total Bill" name="historyhealthTotalBill" id="historyhealthTotalBill" readonly>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip"
                                data-bs-title="Referral Detail">
                                <i class="las la-file-alt fs-4"></i>
                            </span>
                            <input class="form-control" type="text" placeholder="Referral Detail" name="historyhealthDescription">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn-danger" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn-primary" id="addTreatmentButton">ADD</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Add Referral -->
<div class="modal fade" id="addReferralModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="addReferralForm">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">ASSIGN AS REFERRAL</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                <input type="text" id="patientNIK" name="patientNIK" hidden>
                    <div class="row gy-4">
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Patient Name">
                                    <i class="las la-user-injured fs-4"></i>
                                </span>
                                <span class="form-control" id="referralPatientName"></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Patient Role">
                                    <i class="las la-user-tag fs-4"></i>
                                </span>
                                <input class="form-control" type="text" name="role" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Employee Name">
                                    <i class="las la-user-shield fs-4"></i>
                                </span>
                                <span class="form-control" id="referralEmployeeName"></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company Name">
                                    <i class="las la-building fs-4"></i>
                                </span>
                                <span class="form-control" id="referralCompanyName"></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip"
                                data-bs-title="Referral Detail">
                                <i class="las la-file-alt fs-4"></i>
                            </span>
                            <input class="form-control" type="text" placeholder="Referral Detail" name="historyhealthDescription">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip"
                                    data-bs-title="Hospital Referred">
                                    <i class="las la-share-square fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Hospital Referred" name="historyhealthReferredTo">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn-danger" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn-primary" id="addReferralButton">ADD</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="deleteQueueModal" aria-hidden="true">
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
                    Are you sure want to delete <span class="fw-bold" id="patientName"></span> queue?
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