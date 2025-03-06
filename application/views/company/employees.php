<div class="content-body py-3">
    <div id="#crudAlert" data-flashdata="" data-errorflashdata=""></div>
    <button type="button" class="btn-primary w-100 my-3 d-flex align-items-center justify-content-center gap-2" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
        <i class="las la-plus-circle fs-4"></i>    
        ADD EMPLOYEE
    </button>
    <table id="employeesTable" class="table" style="width:100%;">
        <thead>
            <tr>
                <th class="text-start">NIK</th>
                <th>Name</th>
                <th>Status</th>
                <th>Gender</th>
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
<div class="modal fade" id="addEmployeeModal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="addEmployeeForm" enctype="multipart/form-data">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">ADD EMPLOYEE</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    <div class="row gy-4">
                        <div class="col-12 d-flex flex-column justify-content-center align-items-center">
                            <div class="imgContainer">
                                <img class="object-fit-cover" src="<?= base_url('assets/images/user-placeholder.png'); ?>" data-originalsrc="<?= base_url('assets/images/user-placeholder.png'); ?>" alt="Employee Photo" draggable="false" id="imgPreview" data-bs-toggle="tooltip" data-bs-title="Employee Photo">
                            </div>
                            <label class="btn-warning mt-3 text-center w-50" for="addImgFile">UPLOAD PHOTO</label>
                            <input type="file" accept="image/jpg, image/jpeg, image/png" name="employeePhoto" class="imgFile" id="addImgFile" hidden>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Employee NIK">
                                    <i class="las la-id-card fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Employee NIK" name="employeeNIK">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Name">
                                    <i class="las la-user fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Name" name="employeeName">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Employee Email">
                                    <i class="las la-envelope fs-4"></i>
                                </span>
                                <input class="form-control" type="email" placeholder="Employee Email" name="employeeEmail">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Employee Phone">
                                    <i class="las la-phone fs-4"></i>
                                </span>
                                <input class="form-control phone-input" type="text" placeholder="Employee Phone" name="employeePhone">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Employee Birth Date">
                                    <i class="las la-birthday-cake fs-4"></i>
                                </span>
                                <input class="form-control" type="date" placeholder="Employee Birth Date" name="employeeBirth">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Employee Gender">
                                    <i class="las la-venus-mars fs-4"></i>
                                </span>
                                <select class="form-control" name="employeeGender">
                                    <option hidden></option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Employee Department">
                                    <i class="las la-sitemap fs-4"></i>
                                </span>
                                <select class="form-control" data-live-search="true" title="Choose Insurance" name="employeeDepartment">
                                    <option hidden></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Employee Band">
                                    <i class="las la-layer-group fs-4"></i>
                                </span>
                                <select class="form-control" data-live-search="true" title="Choose Insurance" name="employeeBand">
                                    <option hidden></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Insurance Class">
                                    <i class="las la-shield-alt fs-4"></i>
                                </span>
                                <select class="form-control" data-live-search="true" title="Choose Insurance" name="insuranceId">
                                    <option hidden></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Employee Status">
                                    <i class="las la-user-tag fs-4"></i>
                                </span>
                                <div class="form-control readonly" id="employeeStatus" style="cursor: default;"></div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Employee Address">
                                    <i class="las la-map-marked-alt fs-4"></i>
                                </span>
                                <textarea class="form-control" type="text" placeholder="Employee Address" name="employeeAddress"></textarea>
                            </div>
                        </div>
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn-danger" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn-primary" id="addEmployeeButton">ADD</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal View -->
<div class="modal fade" id="viewEmployeeModal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header border-0 shadow-lg">
                <h1 class="modal-title fs-4">EMPLOYEE DETAILS</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body border-0">
                <div class="container-xxl">
                    <h1>Profile Details</h1>
                    <div class="row gy-4 mt-auto mb-5">
                        <div class="col-12 col-xl-3 my-auto mb-4 mb-xl-auto d-flex justify-content-center">
                            <div class="imgContainer my-auto" style="width: 300px; height: 300px;">
                                <img class="object-fit-cover" src="<?= base_url('assets/images/user-placeholder.png') ?>" data-originalsrc="<?= base_url('assets/images/user-placeholder.png'); ?>" id="imgPreview" alt="User Photo"  draggable="false">
                            </div>
                        </div>
                        <div class="col-12 col-xl-9 my-auto">
                            <div class="row g-4 py-auto">
                                <div class="col-12 col-md-6">
                                    <div class="input-group p-0">
                                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="NIK">
                                            <i class="las la-id-card fs-4"></i>    
                                        </span>
                                        <div class="form-control" id="employeeNIK"></div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="input-group p-0">
                                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Name">
                                            <i class="las la-user fs-4"></i>
                                        </span>
                                        <div class="form-control" id="employeeName"></div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="input-group p-0">
                                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Date of Birth">
                                            <i class="las la-birthday-cake fs-4"></i>
                                        </span>
                                        <div class="form-control" id="employeeBirth"></div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="input-group p-0">
                                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Gender">
                                            <i class="las la-transgender fs-4"></i>
                                        </span>
                                        <div class="form-control" id="employeeGender"></div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="input-group p-0">
                                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Department">
                                            <i class="las la-sitemap fs-4"></i>
                                        </span>
                                        <div class="form-control" id="employeeDepartment"></div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="input-group p-0">
                                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Band">
                                            <i class="las la-layer-group fs-4"></i>
                                        </span>
                                        <div class="form-control" id="employeeBand"></div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="input-group p-0">
                                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Email">
                                            <i class="las la-envelope fs-4"></i>
                                        </span>
                                        <div class="form-control" id="employeeEmail"></div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="input-group p-0">
                                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Phone Number">
                                            <i class="las la-phone fs-4"></i>
                                        </span>
                                        <div class="form-control" id="employeePhone"></div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="input-group p-0">
                                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Address">
                                            <i class="las la-map-marked-alt fs-4"></i>
                                        </span>
                                        <div class="form-control text-truncate" id="employeeAddress"></div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="input-group p-0">
                                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Status">
                                            <i class="las la-user-tag fs-4"></i>
                                        </span>
                                        <div class="form-control" id="employeeStatus"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h1 class="mb-0">Insurance Details</h1>
                    <small class="text-info px-0 lh-1">The data below includes insurance usage by both the employee and registered family members.</small>
                    <div class="row g-4 mb-5 mt-1">
                        <div class="col-12 col-lg-4">
                            <div class="card bg-transparent box-total">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <h5 class="card-title text-center">TREATMENTS THIS MONTH</h5>
                                    <h1 class="text-center fw-bold" id="totalTreatmentsThisMonth">0</h1>
                                    <div class="card-text text-center">
                                        <hr>
                                        <div class="d-flex justify-content-around">
                                            <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Billed">
                                                <i class="las la-file-medical text-success fs-4"></i>
                                                <span id="totalBilledTreatmentsThisMonth">0</span>
                                            </div>
                                            <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Referred">
                                                <i class="las la-file-medical text-info fs-4"></i>
                                                <span id="totalReferredTreatmentsThisMonth">0</span>
                                            </div>
                                            <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Free">
                                                <i class="las la-file-medical text-secondary-subtl fs-4"></i>
                                                <span id="totalFreeTreatmentsThisMonth">0</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="card bg-transparent box-total">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <h5 class="card-title text-center">TOTAL TREATMENTS</h5>
                                    <h1 class="text-center fw-bold" id="totalTreatments">0</h1>
                                    <div class="card-text text-center">
                                        <hr>
                                        <div class="d-flex justify-content-around">
                                            <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Billed">
                                                <i class="las la-file-medical text-success fs-4"></i>
                                                <span id="totalBilledTreatments">0</span>
                                            </div>
                                            <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Referred">
                                                <i class="las la-file-medical text-info fs-4"></i>
                                                <span id="totalReferredTreatments">0</span>
                                            </div>
                                            <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Free">
                                                <i class="las la-file-medical text-secondary-subtl fs-4"></i>
                                                <span id="totalFreeTreatments">0</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="card bg-transparent box-total">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <h5 class="card-title text-center">INSURANCE BILLING REMAINING</h5>
                                    <h4 class="text-center fw-bold"  id="totalBillingRemaining">Rp 000.000.000,00</h4>
                                    <span class="text-center" style="font-size: 0.8rem;" id="insuranceTier" data-bs-toggle="tooltip" data-bs-title="Insurance Tier">
                                        Insurance Tier
                                    </span>
                                    <div class="card-text text-center">
                                        <hr class="mt-0">
                                        <div class="d-flex justify-content-around">
                                            <div class="d-inline-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Billing Used">
                                                <i class="las la-credit-card text-danger fs-4"></i>
                                                <span style="font-size: 0.8rem;" id="totalBillingUsed">000.000.000</span>
                                            </div>
                                            <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Billing Amount">
                                                <i class="las la-credit-card text-info fs-4"></i>
                                                <span style="font-size: 0.8rem;" id="totalBillingAmount">000.000.000</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h1>Family Members</h1>
                    <div class="row">
                        <div class="col-12">
                            <table id="employeeFamiliesTable" class="table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>NIK</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Gender</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Date of Birth</th>
                                        <th>Address</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="col-12 d-flex justify-content-between flex-column flex-lg-row mt-5">
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
</div>

<!-- Modal View Family Treatments -->
<div class="modal fade" id="viewFamilyTreatmentModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h1 class="modal-title fs-4">
                    Family Insurance Details
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body border-0">
                <div class="row g-4">
                    <div class="col-12 col-lg-6">
                        <div class="card bg-transparent box-total">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <h5 class="card-title text-center">TREATMENTS THIS MONTH</h5>
                                <h1 class="text-center fw-bold" id="totalTreatmentsThisMonth">0</h1>
                                <div class="card-text text-center">
                                    <hr>
                                    <div class="d-flex justify-content-around">
                                        <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Billed">
                                            <i class="las la-file-medical text-success fs-4"></i>
                                            <span id="totalBilledTreatmentsThisMonth">0</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Referred">
                                            <i class="las la-file-medical text-info fs-4"></i>
                                            <span id="totalReferredTreatmentsThisMonth">0</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Free">
                                            <i class="las la-file-medical text-secondary-subtl fs-4"></i>
                                            <span id="totalFreeTreatmentsThisMonth">0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="card bg-transparent box-total">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <h5 class="card-title text-center">TOTAL TREATMENTS</h5>
                                <h1 class="text-center fw-bold" id="totalTreatments">0</h1>
                                <div class="card-text text-center">
                                    <hr>
                                    <div class="d-flex justify-content-around">
                                        <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Billed">
                                            <i class="las la-file-medical text-success fs-4"></i>
                                            <span id="totalBilledTreatments">0</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Referred">
                                            <i class="las la-file-medical text-info fs-4"></i>
                                            <span id="totalReferredTreatments">0</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Free">
                                            <i class="las la-file-medical text-secondary-subtl fs-4"></i>
                                            <span id="totalFreeTreatments">0</span>
                                        </div>
                                    </div>
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
<div class="modal fade" id="editEmployeeModal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="editEmployeeForm" enctype="multipart/form-data">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">EDIT EMPLOYEE</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    <div class="row gy-4">
                        <input type="number" id="employeeId" name="employeeId" hidden>
                        <div class="col-12 d-flex flex-column justify-content-center align-items-center">
                            <div class="imgContainer">
                                <img class="object-fit-cover" src="<?= base_url('assets/images/user-placeholder.png'); ?>" data-originalsrc="<?= base_url('assets/images/user-placeholder.png'); ?>" alt="Employee Photo" draggable="false" id="imgPreview" data-bs-toggle="tooltip" data-bs-title="Employee Photo">
                            </div>
                            <label class="btn-warning mt-3 text-center w-50" for="editImgFile">UPLOAD PHOTO</label>
                            <input type="file" accept="image/jpg, image/jpeg, image/png" name="employeePhoto" class="imgFile" id="editImgFile" hidden>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Employee NIK">
                                    <i class="las la-id-card fs-4"></i>
                                </span>
                                <input class="form-control readonly" type="text" placeholder="Employee NIK" name="employeeNIK" readonly style="cursor: default;">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Email">
                                    <i class="las la-envelope fs-4"></i>
                                </span>
                                <input class="form-control readonly" type="email" placeholder="Email" name="employeeEmail" id="editEmail" disabled>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-between w-100">
                            <div>
                                <input class="form-check-input" type="checkbox" id="newEmployeeNIK" data-bs-toggle="tooltip" data-bs-title="Change Password Checkbox">
                                <label class="form-check-label">Change NIK?</label>
                            </div>
                            <div>
                                <input class="form-check-input" type="checkbox" id="newEmailCheck" data-bs-toggle="tooltip" data-bs-title="Change Email Checkbox">
                                <label class="form-check-label">Change Email?</label>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6"  id="newEmployeeNIKInput" style="display: none;">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Change Employee NIK">
                                    <i class="las la-id-card fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Change Employee NIK" name="newEmployeeNIK">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 changeEmailInput" style="display: none;">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Change Employee Email">
                                    <i class="las la-envelope fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Change Employee Email" name="newEmployeeEmail">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Name">
                                    <i class="las la-user fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Name" name="employeeName">
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Phone">
                                    <i class="las la-phone fs-4"></i>
                                </span>
                                <input class="form-control phone-input" type="phone" placeholder="Phone" name="employeePhone">
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Birth Date">
                                    <i class="las la-birthday-cake fs-4"></i>
                                </span>
                                <input class="form-control" type="date" placeholder="Birth Date" name="employeeBirth">
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Gender">
                                    <i class="las la-venus-mars fs-4"></i>
                                </span>
                                <select class="form-control" name="employeeGender">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Employee Department">
                                    <i class="las la-sitemap fs-4"></i>
                                </span>
                                <select class="form-control" data-live-search="true" title="Choose Insurance" name="employeeDepartment">
                                    <option hidden></option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Employee Band">
                                    <i class="las la-layer-group fs-4"></i>
                                </span>
                                <select class="form-control" data-live-search="true" title="Choose Insurance" name="employeeBand">
                                    <option hidden></option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Insurance Tier">
                                    <i class="las la-shield-alt fs-4"></i>
                                </span>
                                <select class="form-control" title="Choose Insurance" id="insuranceId" name="insuranceId">
                                    <option hidden></option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Status">
                                    <i class="las la-user-tag fs-4"></i>
                                </span>
                                <select class="form-control" name="employeeStatus">
                                    <option hidden></option>
                                </select>
                            </div>
                            <small class="warning-message text-warning px-0 lh-1 mb-0" style="display: none">
                                You can't change unverified status.
                            </small>
                        </div>

                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Address">
                                    <i class="las la-map-marked-alt fs-4"></i>
                                </span>
                                <textarea class="form-control" type="text" placeholder="Address" name="employeeAddress" id="editAddress"></textarea>
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
                    <button type="submit" class="btn-primary" id="editEmployeeButton">SAVE</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="deleteEmployeeModal" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form id="deleteEmployeeForm">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">
                        DELETE EMPLOYEE
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    Are you sure want to delete <span class="fw-bold" id="employeeName"></span> Employee?
                    <input type="number" name="employeeNIK" hidden>
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn-primary" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn-danger" id="deleteEmployeeButton">DELETE</button>
                </div>
            </form>
        </div>
    </div>
</div>