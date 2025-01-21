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
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form id="addTreatmentForm">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">PROCESS FOR TREATMENT</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    <div class="row gy-4">
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip"
                                    data-bs-title="Doctor Name">
                                    <i class="las la-user-cog fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Patient Name" name="patientName">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip"
                                    data-bs-title="Doctor Date Of Birth">
                                    <i class="las la-calendar fs-4"></i>
                                </span>
                                <input type="date" class="form-control" id="date" title="Date" name="doctorDateOfBirth"/>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip"
                                    data-bs-title="Specialization">
                                    <i class="las la-stethoscope fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Doctor Specialization"
                                    name="doctorSpecialization">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip"
                                    data-bs-title="Doctor Address">
                                    <i class="las la-map fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Address" name="doctorAddress">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip"
                                    data-bs-title="Doctor Status">
                                    <i class="las la-user-clock fs-4"></i>
                                </span>
                                <select class="form-control" id="doctorStatus" name="doctorStatus">
                                    <option hidden ></option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="suspended">Suspended</option>
                                    <option value="disabled">Disabled</option>
                                </select>
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
                                <span class="form-control" id="referralPatientRole"></span>
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
                    <input type="text" id="hospitalId" name="hospitalId" hidden>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn-primary" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn-danger" id="deleteQueueButton">DELETE</button>
                </div>
            </form>
        </div>
    </div>
</div>