<div class="content-body py-3">
    <div id="#crudAlert" data-flashdata="" data-errorflashdata=""></div>
    <button type="button" class="btn-primary w-100 my-3 d-flex align-items-center justify-content-center gap-2" data-bs-toggle="modal" data-bs-target="#addFamilyModal">
        <i class="las la-plus-circle fs-4"></i>    
        ADD FAMILY
    </button>
    <table id="familiesTable" class="table" style="width:100%">
        <thead>
            <tr>
                <th class="text-start">NIK</th>
                <th>Name</th>
                <th>Status</th>
                <th>Gender</th>
                <th>Relationship</th>
                <th>Department</th>
                <th>Band</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Date of Birth</th>
                <th>Address</th>
                <th class="text-start">Created At</th>
                <th class="text-start">Updated At</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
    </table>
</div>

<!-- Modal Add -->
<div class="modal fade" id="addFamilyModal" data-bs-backdrop="static" data-bs-keyboard="false">    
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="addFamilyForm" enctype="multipart/form-data">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">ADD FAMILY</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    <div class="row gy-4">
                        <div class="col-12 d-flex flex-column justify-content-center align-items-center">
                            <div class="imgContainer">
                                <img class="object-fit-cover" src="<?= base_url('assets/images/user-placeholder.png'); ?>" data-originalsrc="<?= base_url('assets/images/user-placeholder.png'); ?>" alt="Family Photo" draggable="false" id="imgPreview" data-bs-toggle="tooltip" data-bs-title="Family Photo">
                            </div>
                            <label class="btn-warning mt-3 text-center w-50" for="addImgFile">UPLOAD PHOTO</label>
                            <input type="file" accept="image/jpg, image/jpeg, image/png" name="familyPhoto" class="imgFile" id="addImgFile" hidden>
                        </div>
                        <div class="col-12 col-lg-8">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Employee">
                                    <i class="las la-user-tie fs-4"></i>
                                </span>
                                <select class="form-control" name="employeeNIK">
                                    <option hidden></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Family NIK">
                                    <i class="las la-id-card fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Family NIK" name="familyNIK">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Name">
                                    <i class="las la-user fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Name" name="familyName">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Family Email">
                                    <i class="las la-envelope fs-4"></i>
                                </span>
                                <input class="form-control" type="email" placeholder="Family Email" name="familyEmail">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Family Phone">
                                    <i class="las la-phone fs-4"></i>
                                </span>
                                <input class="form-control phone-input" type="text" placeholder="Family Phone" name="familyPhone">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Family Birth Date">
                                    <i class="las la-calendar fs-4"></i>
                                </span>
                                <input class="form-control" type="date" placeholder="Family Birth Date" name="familyBirth">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Family Gender">
                                    <i class="las la-venus-mars fs-4"></i>
                                </span>
                                <select class="form-control" name="familyGender">
                                    <option hidden></option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Family Relationship">
                                    <i class="las la-link fs-4"></i>
                                </span>
                                <select class="form-control" name="familyRelationship">
                                    <option hidden></option>
                                    <option value="spouse">Spouse</option>
                                    <option value="child">Child</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Family Address">
                                    <i class="las la-map-marked-alt fs-4"></i>
                                </span>
                                <textarea class="form-control" type="text" placeholder="Family Address" name="familyAddress"></textarea>
                            </div>
                        </div>
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn-danger" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn-primary" id="addFamilyButton">ADD</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editFamilyModal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="editFamilyForm" enctype="multipart/form-data">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">EDIT FAMILY</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    <div class="row gy-4">
                        <input type="hidden" name="familyNIK" hidden>
                        <div class="col-12 d-flex flex-column justify-content-center align-items-center">
                            <div class="imgContainer">
                                <img class="object-fit-cover" src="<?= base_url('assets/images/user-placeholder.png'); ?>" data-originalsrc="<?= base_url('assets/images/user-placeholder.png'); ?>" alt="Family Photo" draggable="false" id="imgPreview" data-bs-toggle="tooltip" data-bs-title="Family Photo">
                            </div>
                            <label class="btn-warning mt-3 text-center w-50" for="editImgFile">UPLOAD PHOTO</label>
                            <input type="file" accept="image/jpg, image/jpeg, image/png" name="familyPhoto" class="imgFile" id="editImgFile" hidden>
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Employee">
                                    <i class="las la-user-tie fs-4"></i>
                                </span>
                                <select class="form-control" name="employeeNIK">
                                    <option hidden></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Family NIK">
                                    <i class="las la-id-card fs-4"></i>
                                </span>
                                <input class="form-control readonly" type="text" placeholder="Family NIK" name="familyNIK" readonly style="cursor: default;">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Email">
                                    <i class="las la-envelope fs-4"></i>
                                </span>
                                <input class="form-control readonly" type="email" placeholder="Email" name="familyEmail" disabled>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-between w-100">
                            <div>
                                <input class="form-check-input" type="checkbox" id="newFamilyNIK" data-bs-toggle="tooltip" data-bs-title="Change Password Checkbox">
                                <label class="form-check-label">Change NIK?</label>
                            </div>
                            <div>
                                <input class="form-check-input" type="checkbox" id="newEmailCheck" data-bs-toggle="tooltip" data-bs-title="Change Email Checkbox">
                                <label class="form-check-label">Change Email?</label>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6"  id="newFamilyNIKInput" style="display: none;">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Change Family NIK">
                                    <i class="las la-id-card fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Change Family NIK" name="newFamilyNIK">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 changeEmailInput" style="display: none;">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Change Family Email">
                                    <i class="las la-envelope fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Change Family Email" name="newFamilyEmail">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Name">
                                    <i class="las la-user fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Name" name="familyName">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Phone">
                                    <i class="las la-phone fs-4"></i>
                                </span>
                                <input class="form-control phone-input" type="phone" placeholder="Phone" name="familyPhone">
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Birth Date">
                                    <i class="las la-calendar fs-4"></i>
                                </span>
                                <input class="form-control" type="date" placeholder="Birth Date" name="familyBirth">
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Gender">
                                    <i class="las la-venus-mars fs-4"></i>
                                </span>
                                <select class="form-control" name="familyGender">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Family Relationship">
                                    <i class="las la-link fs-4"></i>
                                </span>
                                <select class="form-control" name="familyRelationship">
                                    <option hidden></option>
                                    <option value="spouse">Spouse</option>
                                    <option value="child">Child</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Status">
                                    <i class="las la-user-tag fs-4"></i>
                                </span>
                                <select class="form-control" name="familyStatus">
                                    <option hidden></option>
                                </select>
                            </div>
                            <small class="warning-message text-warning px-0 lh-1" style="display: none">
                                You can't change unverified status.
                            </small>
                        </div>

                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Address">
                                    <i class="las la-map fs-4"></i>
                                </span>
                                <textarea class="form-control" type="text" placeholder="Address" name="familyAddress" id="editAddress"></textarea>
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-between w-100">
                            <div>
                                <input class="form-check-input" type="checkbox" id="newPasswordCheck" data-bs-toggle="tooltip" data-bs-title="Change Password Checkbox">
                                <label class="form-check-label">Change password?</label>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 changePasswordInput">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Admin New Password">
                                    <i class="las la-key fs-4"></i>
                                </span>
                                <input type="password" class="form-control" id="adminPassword" placeholder="Password" name="newPassword">
                                <span type="button" class="input-group-text bg-transparent" id="btnShowPassword" data-bs-toggle="tooltip" data-bs-title="Show/Hide Password">
                                    <i class="las la-eye-slash fs-4"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 changePasswordInput">
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
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn-danger" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn-primary" id="editFamilyButton">SAVE</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="deleteFamilyModal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form id="deleteFamilyForm">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">
                        DELETE FAMILY
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    Are you sure want to delete <span class="fw-bold" id="familyName"></span> Family?
                    <input type="hidden" name="familyNIK">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn-danger" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn-primary" id="deleteFamilyButton">DELETE</button>
                </div>
            </form>
        </div>
    </div>
</div>