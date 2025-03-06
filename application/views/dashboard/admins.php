<div class="content-body py-3">
    <div id="#crudAlert" data-flashdata="" data-errorflashdata=""></div>
    <button type="button" class="btn-primary w-100 my-3 d-flex align-items-center justify-content-center gap-2" data-bs-toggle="modal" data-bs-target="#addAdminModal">
        <i class="las la-plus-circle fs-4"></i>    
        ADD ADMIN
    </button>
    <table id="adminsTable" class="table" style="width:100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Partner Status</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
    </table>
</div>

<!-- Modal Add -->
<div class="modal fade" id="addAdminModal" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form id="addAdminForm">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">ADD ADMIN</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    <div class="row gy-4 gx-3">
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Admin Full Name">
                                    <i class="las la-user-cog fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Full Name" name="adminName">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Admin Role">
                                    <i class="las la-user-tag fs-4"></i>
                                </span>
                                <select class="form-control" name="adminRole">
                                    <option hidden></option>
                                    <option value="admin">Admin</option>
                                    <option value="hospital">Hospital</option>  
                                    <option value="company">Company</option>
                                </select>
                            </div>
                            <small class="warning-message text-warning px-0 lh-1" style="display: none;">
                                Admin role can't be changed, account linked to company/hospital.
                            </small>
                        </div>
                        <div class="col-12">   
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Admin Email">
                                    <i class="las la-envelope fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Email" name="adminEmail">
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

<!-- Modal Edit -->
<div class="modal fade" id="editAdminModal" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form id="editAdminForm">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">EDIT ADMIN</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    <input type="hidden" name="adminId">
                    <div class="row gy-4 gx-3">
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Admin Full Name">
                                    <i class="las la-user-cog fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Full Name" name="adminName">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Admin Email">
                                    <i class="las la-envelope fs-4"></i>
                                </span>
                                <input class="form-control readonly" type="text" placeholder="Email" name="adminEmail" disabled>
                            </div>
                            <small class="text-warning px-0 lh-1">
                                Admin email cannot be changed.
                            </small>
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Admin Role">
                                    <i class="las la-user-tag fs-4"></i>
                                </span>
                                <select class="form-control" name="adminRole">
                                    <option hidden></option>
                                    <option value="admin">Admin</option>
                                    <option value="hospital">Hospital</option>
                                    <option value="company">Company</option>
                                </select>
                            </div>
                            <small class="warning-message text-warning px-0 lh-1" style="display: none">
                                Role change is not allowed for linked admins.
                            </small>
                        </div>
                        <div class="col-12 d-flex w-100">
                            <div>
                                <input class="form-check-input" type="checkbox" id="newPasswordCheck" data-bs-toggle="tooltip" data-bs-title="Change Password Checkbox">
                                <label class="form-check-label">Change password?</label>
                            </div>
                        </div>
                        <div class="col-12 changePasswordInput">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Admin New Password">
                                    <i class="las la-key fs-4"></i>
                                </span>
                                <input type="password" class="form-control" placeholder="Password" name="newPassword">
                                <span type="button" class="input-group-text bg-transparent" id="btnShowPassword" data-bs-toggle="tooltip" data-bs-title="Show/Hide Password">
                                    <i class="las la-eye-slash fs-4"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-12 changePasswordInput">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Admin Password Confirmation">
                                    <i class="las la-key fs-4"></i>
                                </span>
                                <input type="password" class="form-control" placeholder="Password Confirmation" name="confirmPassword">
                                <span type="button" class="input-group-text bg-transparent" id="btnShowPassword" data-bs-toggle="tooltip" data-bs-title="Show/Hide Password">
                                    <i class="las la-eye-slash fs-4"></i>
                                </span>
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
<div class="modal fade" id="deleteAdminModal" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form id="deleteAdminForm">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">
                        DELETE ADMIN
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    Are you sure want to delete "<span class="fw-bold" id="adminName"></span>" account?
                    <input type="hidden" name="adminId">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn-primary" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn-danger" id="deleteAdminButton">DELETE</button>
                </div>
            </form>
        </div>
    </div>
</div>