<div class="content-body py-3">
    <div id="temporaryData" 
        data-coordinate="<?= $this->session->userdata('companyCoordinate'); ?>" 
        data-photo="<?= $this->session->userdata('companyPhoto'); ?>"
        hidden
    ></div>
    <div id="profileAlert" 
        data-flashdata="<?= $this->session->flashdata('flashdata'); ?>" 
        data-flashdata-msg="<?= $this->session->flashdata('message'); ?>" 
        hidden
    ></div>
    <div class="row gy-4">
        <div class="col-12 col-lg-6 d-flex justify-content-center align-items-center order-0 order-lg-0">
            <div class="row g-3">
                <div class="col-12 d-flex flex-column justify-content-center align-items-center">
                    <div class="imgContainer">
                        <img src="<?= $this->session->userdata('companyLogo'); ?>" alt="Company Logo" draggable="false" id="imgPreview" data-bs-toggle="tooltip" data-bs-title="Company Logo">
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group p-0">
                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company Name">
                            <i class="las la-building fs-4"></i>
                        </span>
                        <div class="form-control" id="companyName"><?= $this->session->userdata('companyName'); ?></div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group p-0">
                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Admin Account">
                            <i class="las la-user-cog fs-4"></i>
                        </span>
                        <div class="form-control" id="adminId"><?= $this->session->userdata('adminName') . ' | ' . $this->session->userdata('adminEmail'); ?></div>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="input-group p-0">
                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company Phone">
                            <i class="las la-phone fs-4"></i>
                        </span>
                        <div class="form-control" id="companyPhone"><?= $this->session->userdata('companyPhone'); ?></div>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="input-group p-0">
                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company Status">
                            <i class="las la-tag fs-4"></i>
                        </span>
                        <?php $companyStatus = $this->session->userdata('companyStatus'); ?>
                        <div class="form-control" id="companyStatus">
                            <div class="<?= $companyStatus === 'active' ? 'bg-success' : 'bg-warning'; ?> status-circle"></div>
                            <span><?= ucwords($companyStatus) ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-12">   
                    <div class="input-group p-0">
                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company Address">
                            <i class="las la-map fs-4"></i>
                        </span>
                        <div class="form-control" id="companyAddress"><?= $this->session->userdata('companyAddress'); ?></div>
                    </div>
                </div>
                <div class="col-12">   
                    <div class="input-group p-0">
                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company Coordinate">
                            <i class="las la-map-marker fs-4"></i>
                        </span>
                        <div class="form-control" id="companyCoordinate"><?= $this->session->userdata('companyCoordinate'); ?></div>
                    </div>
                </div>
                <div class="col-12">
                    <button class="btn-primary w-100" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        <i class="fa-regular fa-pen-to-square me-1"></i>
                        EDIT PROFILE
                    </button>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 d-flex justify-content-center align-items-center order-3 order-lg-1">
            <div id="map" class="w-100 h-100" style="min-height:450px"></div>
        </div>
        <div class="col-12 order-1 order-lg-2">
            <div class="row g-4">
                <div class="col-12 col-md-6">
                    <div class="card bg-transparent box-total">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <h5 class="card-title text-center">TOTAL INVOICES</h5>
                            <h1 class="text-center fw-bold" id="totalInvoices"><?= $company['totalInvoices']; ?></h1>
                            <div class="card-text text-center">
                                <hr>
                                <div class="d-flex justify-content-around">
                                    <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Paid">
                                        <i class="las la-file-invoice-dollar text-success fs-4"></i>
                                        <span id="totalPaidInvoices"><?= $company['totalPaidInvoices']; ?></span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Unpaid">
                                        <i class="las la-file-invoice-dollar text-danger fs-4"></i>
                                        <span id="totalUnpaidInvoices"><?= $company['totalUnpaidInvoices']; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="card bg-transparent box-total">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <h5 class="card-title text-center">TOTAL EMPLOYEES</h5>
                            <h1 class="text-center fw-bold" id="totalEmployees"><?= $company['totalEmployees']; ?></h1>
                            <div class="card-text text-center">
                                <hr>
                                <div class="d-flex justify-content-around">
                                    <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Unverified">
                                        <i class="las la-user-tie text-secondary-subtl fs-4"></i>
                                        <span id="totalUnverifiedEmployees"><?= $company['totalUnverifiedEmployees']; ?></span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Active">
                                        <i class="las la-user-tie text-success fs-4"></i>
                                        <span id="totalActiveEmployees"><?= $company['totalActiveEmployees']; ?></span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="On Hold">
                                        <i class="las la-user-tie text-warning fs-4"></i>
                                        <span id="totalOnHoldEmployees"><?= $company['totalOnHoldEmployees']; ?></span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Discontinued">
                                        <i class="las la-user-tie text-secondary fs-4"></i>
                                        <span id="totalDiscontinuedEmployees"><?= $company['totalDiscontinuedEmployees']; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="card bg-transparent box-total">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <h5 class="card-title text-center">TOTAL FAMILY MEMBERS</h5>
                            <h1 class="text-center fw-bold" id="totalFamilyMembers"><?= $company['totalFamilyMembers']; ?></h1>
                            <div class="card-text text-center">
                                <hr>
                                <div class="d-flex justify-content-around">
                                    <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Unverified">
                                        <i class="las la-users text-secondary-subtl fs-4"></i>
                                        <span id="totalUnverifiedFamilyMembers"><?= $company['totalUnverifiedFamilyMembers']; ?></span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Active">
                                        <i class="las la-users text-success fs-4"></i>
                                        <span id="totalActiveFamilyMembers"><?= $company['totalActiveFamilyMembers']; ?></span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="On Hold">
                                        <i class="las la-users text-warning fs-4"></i>
                                        <span id="totalOnHoldFamilyMembers"><?= $company['totalOnHoldFamilyMembers']; ?></span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Archived">
                                        <i class="las la-users text-secondary fs-4"></i>
                                        <span id="totalArchivedFamilyMembers"><?= $company['totalArchivedFamilyMembers']; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="card bg-transparent box-total">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <h5 class="card-title text-center">BILLING REMAINING</h5>
                            <h4 class="text-center fw-bold"  id="totalBillingRemaining"><?= 'Rp ' . number_format($company['totalBillingRemaining'], 0, ',', '.'); ?></h4>
                            <span class="text-center" style="font-size: 0.8rem;" id="billingDate" data-bs-toggle="tooltip" data-bs-title="Billing Start - Billing End">
                                
                            </span>
                            <div class="card-text text-center">
                                <hr class="mt-0">
                                <div class="d-flex justify-content-around">
                                    <div class="d-inline-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Billing Used">
                                        <i class="las la-credit-card text-danger fs-4"></i>
                                        <span style="font-size: 0.8rem;" id="totalBillingUsed"><?= 'Rp ' . number_format($company['totalBillingUsed'], 0, ',', '.'); ?></span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Billing Amount">
                                        <i class="las la-credit-card text-info fs-4"></i>
                                        <span style="font-size: 0.8rem;" id="totalBillingAmount"><?= 'Rp ' . number_format($company['totalBillingAmount'], 0, ',', '.'); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Edit -->
    <div class="modal fade" id="editProfileModal" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <form id="editProfileForm" enctype="multipart/form-data">
                    <div class="modal-header border-0">
                        <h1 class="modal-title fs-4">EDIT PROFILE</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body border-0">
                        <div class="row gy-4 gx-3">
                            <h5 class="my-0">Company Profile</h5>
                            <input type="hidden" name="companyId">
                            <div class="col-12 col-lg-6 d-flex flex-column justify-content-center align-items-center">
                                <div class="imgContainer">
                                    <img src="<?= $this->session->userdata('companyLogo'); ?>" data-originalsrc="<?= base_url('assets/images/company-placeholder.jpg'); ?>" alt="Company Logo" draggable="false" id="imgPreview" data-bs-toggle="tooltip" data-bs-title="Company Logo">
                                </div>
                                <label class="btn-warning mt-3 text-center w-50" for="editImgFile">UPLOAD LOGO</label>
                                <input type="file" accept="image/jpg, image/jpeg, image/png" name="companyLogo" class="imgFile" id="editImgFile" hidden>
                            </div>
                            <div class="col-12 col-lg-6 d-flex flex-column justify-content-center align-items-center">
                                <div class="imgContainer">
                                    <img src="<?= $this->session->userdata('companyPhoto'); ?>" data-originalsrc="<?= base_url('assets/images/company-placeholder.jpg'); ?>" alt="Company Photo" draggable="false" id="imgPreview2" data-bs-toggle="tooltip" data-bs-title="Company Photo">
                                </div>
                                <label class="btn-warning mt-3 text-center w-50" for="editImgFile2">UPLOAD PHOTO</label>
                                <input type="file" accept="image/jpg, image/jpeg, image/png" name="companyPhoto" class="imgFile" id="editImgFile2" hidden>
                            </div>
                            <div class="col-12 col-lg-8">
                                <div class="input-group p-0">
                                    <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company Name">
                                        <i class="las la-building fs-4"></i>
                                    </span>
                                    <input class="form-control" type="text" placeholder="Name" name="companyName" value="<?= $this->session->userdata('companyName'); ?>">
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="input-group p-0">
                                    <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company Phone">
                                        <i class="las la-phone fs-4"></i>
                                    </span>
                                    <input class="form-control phone-input" type="text" placeholder="Phone Number" name="companyPhone" value="<?= $this->session->userdata('companyPhone'); ?>">
                                </div>
                            </div>
                            <div class="col-12">   
                                <div class="input-group p-0">
                                    <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company Address">
                                        <i class="las la-map fs-4"></i>
                                    </span>
                                    <textarea class="form-control" type="text" placeholder="Company Address" name="companyAddress"><?= $this->session->userdata('companyAddress'); ?></textarea>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-between w-100">
                                <div>
                                    <input class="form-check-input" type="checkbox" id="newCoordinateCheck" data-bs-toggle="tooltip" data-bs-title="Change Coordinate Checkbox">
                                    <label class="form-check-label">Change coordinate?</label>
                                </div>
                            </div>
                            <div class="col-12" id="changeCoordinateInput">
                                <div class="input-group p-0">
                                    <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company Coordinate">
                                        <i class="las la-map-marker fs-4"></i>
                                    </span>
                                    <input class="form-control" type="text" placeholder="Change Company Coordinate" name="companyCoordinate">
                                </div>
                            </div>
                            <h5 class="mb-0">Account Profile</h5>
                            <div class="col-12 col-lg-6">
                                <div class="input-group p-0">
                                    <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Account Name">
                                        <i class="las la-user fs-4"></i>
                                    </span>
                                    <input class="form-control" type="text" placeholder="Account Name" name="adminName" value="<?= $this->session->userdata('adminName'); ?>">
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="input-group p-0">
                                    <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Account Email">
                                        <i class="las la-envelope fs-4"></i>
                                    </span>
                                    <input class="form-control" type="text" placeholder="Account Email" name="adminEmail" value="<?= $this->session->userdata('adminEmail'); ?>">
                                </div>
                                <input type="hidden" name="currentAdminEmail" value="<?= $this->session->userdata('adminEmail'); ?>">
                            </div>
                            <div class="col-12 d-flex justify-content-between w-100">
                                <div>
                                    <input class="form-check-input" type="checkbox" id="newPasswordCheck" data-bs-toggle="tooltip" data-bs-title="Change Password Checkbox">
                                    <label class="form-check-label">Change password?</label>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 changePasswordInput">
                                <div class="input-group p-0">
                                    <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Admin Current Password">
                                        <i class="las la-key fs-4"></i>
                                    </span>
                                    <input type="password" class="form-control" placeholder="Current Password" name="currentPassword">
                                    <span type="button" class="input-group-text bg-transparent" id="btnShowPassword" data-bs-toggle="tooltip" data-bs-title="Show/Hide Password">
                                        <i class="las la-eye-slash fs-4"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 changePasswordInput">
                                <div class="input-group p-0">
                                    <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Admin New Password">
                                        <i class="las la-key fs-4"></i>
                                    </span>
                                    <input type="password" class="form-control" placeholder="New Password" name="newPassword">
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
                                    <input type="password" class="form-control" placeholder="New Password Confirmation" name="confirmPassword">
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
                        <button type="submit" class="btn-primary">SAVE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>