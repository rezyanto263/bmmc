<div class="content-body py-3">
    <div id="#crudAlert" data-flashdata="" data-errorflashdata=""></div>
    <button type="button" class="btn-primary w-100 my-3 d-flex align-items-center justify-content-center gap-2" data-bs-toggle="modal" data-bs-target="#addCompanyModal">
        <i class="las la-plus-circle fs-4"></i>    
        ADD COMPANY
    </button>
    <table id="companiesTable" class="table" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Admin</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Admin</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>
</div>


<!-- Modal Add -->
<div class="modal fade" id="addCompanyModal">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form id="addCompanyForm" enctype="multipart/form-data">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">ADD COMPANY</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    <div class="row gy-4">
                        <div class="col-12 d-flex flex-column justify-content-center align-items-center">
                            <div class="imgContainer">
                                <img src="<?= base_url('assets/images/company-placeholder.jpg'); ?>" data-originalsrc="<?= base_url('assets/images/company-placeholder.jpg'); ?>" alt="Company Logo" draggable="false" id="imgPreview" data-bs-toggle="tooltip" data-bs-title="Company Logo">
                            </div>
                            <label class="btn-warning mt-3 text-center w-50" for="addImgFile">UPLOAD LOGO</label>
                            <input type="file" accept="image/jpg, image/jpeg, image/png" name="companyLogo" class="imgFile" id="addImgFile" hidden>
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
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Admin Account">
                                    <i class="las la-user-cog fs-4"></i>
                                </span>
                                <select class="form-control" data-live-search="true" title="Choose Admin" id="adminId" name="adminId">
                                    <option hidden></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">   
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="company Phone">
                                    <i class="las la-phone fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Company Phone Number" name="companyPhone">
                            </div>
                        </div>
                        <div class="col-12">   
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company Address">
                                    <i class="las la-map fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Address" name="companyAddress">
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
<div class="modal fade" id="viewCompanyModal">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h1 class="modal-title fs-4">COMPANY DETAILS</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body border-0">
                <div class="row gy-4">
                    <div class="col-12 col-lg-6 d-flex justify-content-center align-items-center">
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
                            <div class="col-12">   
                                <div class="input-group p-0">
                                    <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company Phone">
                                        <i class="las la-phone fs-4"></i>
                                    </span>
                                    <input class="form-control" type="text" placeholder="Company Phone Number" name="companyPhone" disabled>
                                </div>
                            </div>
                            <div class="col-12">   
                                <div class="input-group p-0">
                                    <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company Address">
                                        <i class="las la-map fs-4"></i>
                                    </span>
                                    <input class="form-control" type="text" placeholder="Company Address" name="companyAddress" disabled>
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
                    <div class="col-12 col-lg-6 d-flex justify-content-center align-items-center">
                        <div id="map" class="w-100 h-100" style="min-height:300px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal Edit -->
<div class="modal fade" id="editCompanyModal">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form id="editCompanyForm" enctype="multipart/form-data">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">EDIT COMPANY</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    <div class="row gy-4">
                        <input type="number" id="companyId" name="companyId" hidden>
                        <div class="col-12 d-flex flex-column justify-content-center align-items-center">
                            <div class="imgContainer">
                                <img src="<?= base_url('assets/images/company-placeholder.jpg'); ?>" data-originalsrc="<?= base_url('assets/images/company-placeholder.jpg'); ?>" alt="Company Logo" draggable="false" id="imgPreview" data-bs-toggle="tooltip" data-bs-title="Company Logo">
                            </div>
                            <label class="btn-warning mt-3 text-center w-50" for="editImgFile">UPLOAD LOGO</label>
                            <input type="file" accept="image/jpg, image/jpeg, image/png" name="companyLogo" class="imgFile" id="editImgFile" hidden>
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
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Admin Account">
                                    <i class="las la-user-cog fs-4"></i>
                                </span>
                                <select class="form-control" data-live-search="true" title="Choose Admin" id="adminId" name="adminId">
                                    <option hidden></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">   
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company Phone">
                                    <i class="las la-phone fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Company Phone Number" name="companyPhone">
                            </div>
                        </div>
                        <div class="col-12">   
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company Address">
                                    <i class="las la-map fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Address" name="companyAddress">
                            </div>
                        </div>
                        <div class="col-12">
                            <input class="form-check-input" type="checkbox" id="newCoordinateCheck" data-bs-toggle="tooltip" data-bs-title="Change Coordinate Checkbox">
                            <label class="form-check-label">Change coordinate?</label>
                        </div>
                        <div class="col-12" id="changeCoordinateInput">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Hospital Coordinate">
                                    <i class="las la-map-marker fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Location Coordinate" name="companyCoordinate">
                            </div>
                        </div>
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
<div class="modal fade" id="deleteCompanyModal" aria-hidden="true">
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
                    <input type="number" id="companyId" name="companyId" hidden>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn-primary" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn-danger" id="deleteCompanyButton">DELETE</button>
                </div>
            </form>
        </div>
    </div>
</div>