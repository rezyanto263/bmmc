<div class="content-body py-3">
    <div id="#crudAlert" data-flashdata="" data-errorflashdata=""></div>
    <button type="button" class="btn-primary w-100 my-3 d-flex align-items-center justify-content-center gap-2"
        data-bs-toggle="modal" data-bs-target="#addDoctorModal">
        <i class="las la-plus-circle fs-4"></i>
        ADD DOCTOR
    </button>
    <table id="doctorsTable" class="table" style="width:100%">
        <thead>
            <tr>
                <th>Logo</th>
                <th>Hospital Name</th>
                <th>Doctor Name</th>
                <th>Specialization</th>
                <th>Date of Birth</th>
                <th>Doctor Status</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>
</div>

<!-- Modal Add -->
<div class="modal fade" id="addDoctorModal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form id="addDoctorForm">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">ADD DOCTOR</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    <div class="row gy-4">
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Hospital">
                                    <i class="las la-hospital fs-4"></i>
                                </span>
                                <select class="form-control" name="hospitalId">
                                    <option hidden></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip"
                                    data-bs-title="Doctor Name">
                                    <i class="las la-user-nurse fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Doctor Name" name="doctorName">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip"
                                    data-bs-title="Specialization">
                                    <i class="las la-stethoscope fs-4"></i>
                                </span>
                                <select class="form-control" name="doctorSpecialization[]" multiple>
                                    <option hidden></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip"
                                    data-bs-title="Doctor Date Of Birth">
                                    <i class="las la-calendar fs-4"></i>
                                </span>
                                <input type="date" class="form-control" placeholder="Date Of Birth" name="doctorDateOfBirth">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Doctor Status">
                                    <i class="las la-user-tag fs-4"></i>
                                </span>
                                <select class="form-control" name="doctorStatus">
                                    <option hidden></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip"
                                    data-bs-title="Doctor Address">
                                    <i class="las la-map fs-4"></i>
                                </span>
                                <textarea class="form-control" type="text" placeholder="Address" name="doctorAddress"></textarea>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn-danger" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn-primary" id="addDoctorButton">ADD</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Edit -->
<div class="modal fade" id="editDoctorModal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form id="editDoctorForm">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">EDIT DOCTOR</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    <div class="row gy-4">
                        <input type="hidden" name="doctorId">
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Hospital">
                                    <i class="las la-hospital fs-4"></i>
                                </span>
                                <select class="form-control" name="hospitalId">
                                    <option hidden></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip"
                                    data-bs-title="Doctor Name">
                                    <i class="las la-user-nurse fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Doctor Name" name="doctorName">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip"
                                    data-bs-title="Specialization">
                                    <i class="las la-stethoscope fs-4"></i>
                                </span>
                                <select class="form-control" name="doctorSpecialization[]" multiple>
                                    <option hidden></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip"
                                    data-bs-title="Doctor Date Of Birth">
                                    <i class="las la-calendar fs-4"></i>
                                </span>
                                <input type="date" class="form-control" placeholder="Date Of Birth" name="doctorDateOfBirth">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Doctor Status">
                                    <i class="las la-user-tag fs-4"></i>
                                </span>
                                <select class="form-control" name="doctorStatus">
                                    <option hidden></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip"
                                    data-bs-title="Doctor Address">
                                    <i class="las la-map fs-4"></i>
                                </span>
                                <textarea class="form-control" type="text" placeholder="Address" name="doctorAddress"></textarea>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn-danger" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn-primary" id="editDoctorButton">SAVE</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="deleteDoctorModal" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form id="deleteDoctorForm">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">
                        DELETE DOCTOR
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    Are you sure want to delete "<span class="fw-bold" id="doctorName"></span>" doctor?
                    <input type="hidden" name="doctorId">
                </div>
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <div class="modal-footer border-0">
                    <button type="button" class="btn-primary" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn-danger" id="deleteDoctorButton">DELETE</button>
                </div>
            </form>
        </div>
    </div>
</div>