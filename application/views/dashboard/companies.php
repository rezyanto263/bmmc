<div class="content-body py-3">
    <div id="#crudAlert" data-flashdata="" data-errorflashdata=""></div>
    <button type="button" class="btn-primary w-100 my-3 d-flex align-items-center justify-content-center gap-2" data-bs-toggle="modal" data-bs-target="#addCompanyModal">
        <i class="las la-plus-circle fs-4"></i>    
        ADD COMPANY
    </button>
    <table id="companiesTable" class="table" style="width:100%">
        <thead>
            <tr>
                <th>Logo</th>
                <th>Name</th>
                <th>Billing</th>
                <th>Status</th>
                <th>Admin Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
    </table>
</div>


<!-- Modal Add -->
<div class="modal fade" id="addCompanyModal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <form id="addCompanyForm" enctype="multipart/form-data">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">ADD COMPANY</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    <div class="row gy-4">
                        <div class="col-12 col-lg-6 d-flex flex-column justify-content-center align-items-center">
                            <div class="imgContainer">
                                <img src="<?= base_url('assets/images/company-placeholder.jpg'); ?>" data-originalsrc="<?= base_url('assets/images/company-placeholder.jpg'); ?>" alt="Company Logo" draggable="false" id="imgPreview" data-bs-toggle="tooltip" data-bs-title="Company Logo">
                            </div>
                            <label class="btn-warning mt-3 text-center w-50" for="addImgFile">UPLOAD LOGO</label>
                            <input type="file" accept="image/jpg, image/jpeg, image/png" name="companyLogo" class="imgFile" id="addImgFile" hidden>
                        </div>
                        <div class="col-12 col-lg-6 d-flex flex-column justify-content-center align-items-center">
                            <div class="imgContainer">
                                <img src="<?= base_url('assets/images/company-placeholder.jpg'); ?>" data-originalsrc="<?= base_url('assets/images/company-placeholder.jpg'); ?>" alt="Company Logo" draggable="false" id="imgPreview" data-bs-toggle="tooltip" data-bs-title="Company Photo">
                            </div>
                            <label class="btn-warning mt-3 text-center w-50" for="addImgFile2">UPLOAD PHOTO</label>
                            <input type="file" accept="image/jpg, image/jpeg, image/png" name="companyPhoto" class="imgFile" id="addImgFile2" hidden>
                        </div>
                        <div class="col-12 col-xl-4">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company Name">
                                    <i class="las la-building fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Name" name="companyName">
                            </div>
                        </div>
                        <div class="col-12 col-xl-8">
                            <div class="input-group p-0 flex-nowrap">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Admin Account">
                                    <i class="las la-user-cog fs-4"></i>
                                </span>
                                <select class="form-control" data-live-search="true" title="Choose Admin" name="adminId">
                                    <option hidden></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">   
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Billing Amount">
                                    <i class="las la-credit-card fs-4"></i>
                                </span>
                                <input class="form-control currency-input" placeholder="Billing Amount" min="0" name="billingAmount">
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Billing Start Date">
                                    <i class="las la-calendar-check fs-4"></i>
                                </span>
                                <input class="form-control" type="date" name="billingStartedAt" min="<?= date('Y-m-d'); ?>" placeholder="Start Date">
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">   
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company Phone">
                                    <i class="las la-phone fs-4"></i>
                                </span>
                                <input class="form-control phone-input" placeholder="Phone Number" name="companyPhone">
                            </div>
                        </div>
                        <div class="col-12">   
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company Address">
                                    <i class="las la-map fs-4"></i>
                                </span>
                                <textarea class="form-control" type="text" placeholder="Address" name="companyAddress"></textarea>
                            </div>
                        </div>
                        <div class="col-12">   
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company Coordinate">
                                    <i class="las la-map-marker fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Location Coordinate" name="companyCoordinate">
                            </div>
                        </div>
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn-danger" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn-primary" id="addCompanyButton">ADD</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal View -->
<div class="modal fade" id="viewCompanyModal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h1 class="modal-title fs-4">COMPANY DETAILS</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body border-0">
                <div class="row gy-4">
                    <div class="col-12 col-lg-6 d-flex justify-content-center align-items-center order-0 order-lg-0">
                        <div class="row gy-4">
                            <div class="col-12 d-flex flex-column justify-content-center align-items-center">
                                <div class="imgContainer">
                                    <img src="<?= base_url('assets/images/company-placeholder.jpg'); ?>" data-originalsrc="<?= base_url('assets/images/company-placeholder.jpg'); ?>" alt="Company Logo" draggable="false" id="imgPreview" data-bs-toggle="tooltip" data-bs-title="Company Logo">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-group p-0">
                                    <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company Name">
                                        <i class="las la-building fs-4"></i>
                                    </span>
                                    <input class="form-control" type="text" placeholder="Name" name="companyName" disabled>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-group p-0">
                                    <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Admin Account">
                                        <i class="las la-user-cog fs-4"></i>
                                    </span>
                                    <input class="form-control" type="text" placeholder="Admin Account" name="adminId" disabled>
                                </div>
                            </div>
                            <div class="col-12 col-lg-7 col-xl-6">
                                <div class="input-group p-0">
                                    <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company Phone">
                                        <i class="las la-phone fs-4"></i>
                                    </span>
                                    <input class="form-control phone-input" type="text" placeholder="Phone Number" name="companyPhone" disabled>
                                </div>
                            </div>
                            <div class="col-12 col-lg-5 col-xl-6">
                                <div class="input-group p-0">
                                    <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company Status">
                                        <i class="las la-tag fs-4"></i>
                                    </span>
                                    <div class="form-control" placeholder="Company Status" id="companyStatus"></div>
                                </div>
                            </div>
                            <div class="col-12">   
                                <div class="input-group p-0">
                                    <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company Address">
                                        <i class="las la-map fs-4"></i>
                                    </span>
                                    <div class="form-control" id="companyAddress"></div>
                                </div>
                            </div>
                            <div class="col-12">   
                                <div class="input-group p-0">
                                    <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company Coordinate">
                                        <i class="las la-map-marker fs-4"></i>
                                    </span>
                                    <input class="form-control" type="text" placeholder="Location Coordinate" name="companyCoordinate" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 d-flex justify-content-center align-items-center order-4 order-lg-1">
                        <div id="map" class="w-100 h-100" style="min-height:300px"></div>
                    </div>
                    <div class="col-12 order-1 order-lg-2">
                        <div class="row g-4">
                            <div class="col-12 col-lg-3">
                                <div class="card bg-transparent box-total">
                                    <div class="card-body d-flex flex-column justify-content-between">
                                        <h5 class="card-title text-center">TOTAL INVOICES</h5>
                                        <h1 class="text-center fw-bold" id="totalInvoices">0</h1>
                                        <div class="card-text text-center">
                                            <hr>
                                            <div class="d-flex justify-content-around">
                                                <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Paid">
                                                    <i class="las la-file-invoice-dollar text-success fs-4"></i>
                                                    <span id="totalPaidInvoices">o</span>
                                                </div>
                                                <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Unpaid">
                                                    <i class="las la-file-invoice-dollar text-danger fs-4"></i>
                                                    <span id="totalUnpaidInvoices">0</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-3">
                                <div class="card bg-transparent box-total">
                                    <div class="card-body d-flex flex-column justify-content-between">
                                        <h5 class="card-title text-center">TOTAL EMPLOYEES</h5>
                                        <h1 class="text-center fw-bold" id="totalEmployees">0</h1>
                                        <div class="card-text text-center">
                                            <hr>
                                            <div class="d-flex justify-content-around">
                                                <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Unverified">
                                                    <i class="las la-user-tie text-secondary-subtl fs-4"></i>
                                                    <span id="totalUnverifiedEmployees">0</span>
                                                </div>
                                                <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Active">
                                                    <i class="las la-user-tie text-success fs-4"></i>
                                                    <span id="totalActiveEmployees">0</span>
                                                </div>
                                                <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="On Hold">
                                                    <i class="las la-user-tie text-warning fs-4"></i>
                                                    <span id="totalOnHoldEmployees">0</span>
                                                </div>
                                                <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Discontinued">
                                                    <i class="las la-user-tie text-secondary fs-4"></i>
                                                    <span id="totalDiscontinuedEmployees">0</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-3">
                                <div class="card bg-transparent box-total">
                                    <div class="card-body d-flex flex-column justify-content-between">
                                        <h5 class="card-title text-center">TOTAL FAMILY MEMBERS</h5>
                                        <h1 class="text-center fw-bold" id="totalFamilyMembers">0</h1>
                                        <div class="card-text text-center">
                                            <hr>
                                            <div class="d-flex justify-content-around">
                                                <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Unverified">
                                                    <i class="las la-users text-secondary-subtl fs-4"></i>
                                                    <span id="totalUnverifiedFamilyMembers">0</span>
                                                </div>
                                                <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Active">
                                                    <i class="las la-users text-success fs-4"></i>
                                                    <span id="totalActiveFamilyMembers">0</span>
                                                </div>
                                                <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="On Hold">
                                                    <i class="las la-users text-warning fs-4"></i>
                                                    <span id="totalOnHoldFamilyMembers">0</span>
                                                </div>
                                                <div class="d-flex align-items-center gap-2" data-bs-toggle="tooltip" data-bs-title="Archived">
                                                    <i class="las la-users text-secondary fs-4"></i>
                                                    <span id="totalArchivedFamilyMembers">0</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-3">
                                <div class="card bg-transparent box-total">
                                    <div class="card-body d-flex flex-column justify-content-between">
                                        <h5 class="card-title text-center">BILLING REMAINING</h5>
                                        <h4 class="text-center fw-bold"  id="totalBillingRemaining">Rp 000.000.000,00</h4>
                                        <span class="text-center" style="font-size: 0.8rem;" id="billingDate" data-bs-toggle="tooltip" data-bs-title="Billing Start - Billing End">
                                            1 Jan 2024 - 31 Jan 2024
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
                    </div>
                    <div class="col-12 d-flex justify-content-between flex-column flex-lg-row order-5">
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
<div class="modal fade" id="editCompanyModal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="editCompanyForm" enctype="multipart/form-data">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">EDIT COMPANY</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    <div class="row gy-4">
                        <input type="hidden" name="companyId">
                        <div class="col-12 col-lg-6 d-flex flex-column justify-content-center align-items-center">
                            <div class="imgContainer">
                                <img src="<?= base_url('assets/images/company-placeholder.jpg'); ?>" data-originalsrc="<?= base_url('assets/images/company-placeholder.jpg'); ?>" alt="Company Logo" draggable="false" id="imgPreview" data-bs-toggle="tooltip" data-bs-title="Company Logo">
                            </div>
                            <label class="btn-warning mt-3 text-center w-50" for="editImgFile">UPLOAD LOGO</label>
                            <input type="file" accept="image/jpg, image/jpeg, image/png" name="companyLogo" class="imgFile" id="editImgFile" hidden>
                        </div>
                        <div class="col-12 col-lg-6 d-flex flex-column justify-content-center align-items-center">
                            <div class="imgContainer">
                                <img src="<?= base_url('assets/images/company-placeholder.jpg'); ?>" data-originalsrc="<?= base_url('assets/images/company-placeholder.jpg'); ?>" alt="Company Photo" draggable="false" id="imgPreview2" data-bs-toggle="tooltip" data-bs-title="Company Photo">
                            </div>
                            <label class="btn-warning mt-3 text-center w-50" for="editImgFile2">UPLOAD PHOTO</label>
                            <input type="file" accept="image/jpg, image/jpeg, image/png" name="companyPhoto" class="imgFile" id="editImgFile2" hidden>
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company Name">
                                    <i class="las la-building fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Name" name="companyName">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0 flex-nowrap">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Admin Account">
                                    <i class="las la-user-cog fs-4"></i>
                                </span>
                                <select class="form-control" title="Choose Admin" name="adminId">
                                    <option hidden></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">   
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company Status">
                                    <i class="las la-tag fs-4"></i>
                                </span>
                                <select class="form-control" name="companyStatus">
                                    <option hidden></option>
                                </select>
                            </div>
                            <small class="warning-message text-warning px-0 lh-1" style="display: none">
                                You can't change unverified status.
                            </small>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company Phone">
                                    <i class="las la-phone fs-4"></i>
                                </span>
                                <input class="form-control phone-input" type="text" placeholder="Phone Number" name="companyPhone">
                            </div>
                        </div>
                        <div class="col-12">   
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company Address">
                                    <i class="las la-map fs-4"></i>
                                </span>
                                <textarea class="form-control" type="text" placeholder="Address" name="companyAddress"></textarea>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-between flex-wrap w-100">
                            <div>
                                <input class="form-check-input" type="checkbox" id="newBillingAmountCheck" data-bs-toggle="tooltip" data-bs-title="Change Billing Amount Checkbox">
                                <label class="form-check-label">Change billing amount?</label>
                            </div>
                            <div>
                                <input class="form-check-input" type="checkbox" id="newCoordinateCheck" data-bs-toggle="tooltip" data-bs-title="Change Coordinate Checkbox">
                                <label class="form-check-label">Change coordinate?</label>
                            </div>
                        </div>
                        <input type="hidden" name="billingId">
                        <div class="col-12" id="changeBillingAmountInput">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Billing Amount">
                                    <i class="las la-credit-card fs-4"></i>
                                </span>
                                <input class="form-control currency-input" placeholder="Billing Amount" min="0" name="billingAmount">
                            </div>
                        </div>
                        <div class="col-12" id="changeCoordinateInput">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company Coordinate">
                                    <i class="las la-map-marker fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Location Coordinate" name="companyCoordinate">
                            </div>
                        </div>
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn-danger" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn-primary" id="editCompanyButton">SAVE</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Delete -->
<div class="modal fade" id="deleteCompanyModal" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form id="deleteCompanyForm">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">
                        DELETE COMPANY
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    Are you sure want to delete <span class="fw-bold" id="companyName"></span> company?
                    <input type="hidden" name="companyId">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn-primary" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn-danger" id="deleteCompanyButton">DELETE</button>
                </div>
            </form>
        </div>
    </div>
</div>