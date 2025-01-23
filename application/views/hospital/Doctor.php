<div class="content-body py-3">
    <div id="#crudAlert" data-flashdata="" data-errorflashdata=""></div>
    <button type="button" class="btn-primary w-100 my-3 d-flex align-items-center justify-content-center gap-2"
        data-bs-toggle="modal" data-bs-target="#addDoctorModal">
        <i class="las la-plus-circle fs-4"></i>
        ADD DOCTOR
    </button>
    <table id="doctorTable" class="table" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Doctor Name</th>
                <th>Address</th>
                <th>Date of Birth</th>
                <th>Specialization</th>
                <th>Doctor Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>#</th>
                <th>Doctor Name</th>
                <th>Address</th>
                <th>Date of Birth</th>
                <th>Specialization</th>
                <th>Doctor Status</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>
</div>

<!-- Modal Add -->
<div class="modal fade" id="addDoctorModal">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form id="addDoctorForm">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">ADD DOCTOR</h1>
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
                                <input class="form-control" type="text" placeholder="Doctor Name" name="doctorName">
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
                                    <option value="disabled">Disabled</option>
                                </select>
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
<div class="modal fade" id="editDoctorModal">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form id="editDoctorForm">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">EDIT DOCTOR</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    <input type="text" id="doctorId" name="doctorId" hidden>
                    <div class="row gy-4">
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip"
                                    data-bs-title="Doctor Name">
                                    <i class="las la-user-cog fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Doctor Name" name="doctorName">
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
                                    <option hidden></option>
                                    <option value="active">Active</option>
                                    <option value="disabled">Disabled</option>
                                </select>
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
<div class="modal fade" id="deleteDoctorModal" aria-hidden="true">
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
                    Are you sure want to delete <span class="fw-bold" id="doctorName"></span> account?
                    <input type="text" id="doctorId" name="doctorId" hidden>
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