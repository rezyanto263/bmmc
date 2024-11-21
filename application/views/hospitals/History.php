<div class="content-body py-3">
    <div id="#crudAlert" data-flashdata="" data-errorflashdata=""></div>
    <button type="button" class="btn-primary w-100 my-3 d-flex align-items-center justify-content-center gap-2" data-bs-toggle="modal" data-bs-target="#addTreatmentModal">
        <i class="las la-plus-circle fs-4"></i>
        ADD TREATMENT
    </button>
    <table id="historiesTable" class="table" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Doctor</th>
                <th>Date</th>
                <th>Health Complaint</th>
                <th>Family Status</th>
                <th>Health Details</th>
                <th>Health Status</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>ID</th>
                <th>Doctor</th>
                <th>Date</th>
                <th>Health Complaint</th>
                <th>Family Status</th>
                <th>Health Details</th>
                <th>Health Status</th>
            </tr>
        </tfoot>
    </table>
</div>


<!-- Modal Add -->
<div class="modal fade" id="addTreatmentModal">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form id="addTreatmentForm" enctype="multipart/form-data">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">ADD TREATMENT</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    <div class="row gy-4">
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Doctor Name">
                                    <i class="las la-stethoscope fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Doctor Name" name="doctorName">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Date">
                                    <i class="las la-calendar fs-4"></i>
                                </span>
                                <input type="date" class="form-control" id="date" name="date" title="Date"/>
                            </div>
                        </div>
                        <div class="col-12">   
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Health Complaint">
                                    <i class="las la-notes-medical fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Health Complaint" name="healthComplaint">
                            </div>
                        </div>
                        <div class="col-12">   
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Family Status">
                                    <i class="las la-user-friends fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Family Status" name="familyStatus">
                            </div>
                        </div>
                        <div class="col-12">   
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Health Detail">
                                    <i class="las la-file-medical fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Health Details" name="healthDetails">
                            </div>
                        </div>
                        <div class="col-12">   
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Health Status">
                                    <i class="las la-star-of-life fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Health Status" name="healthStatus">
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


<!-- Modal Edit -->
<!-- <div class="modal fade" id="editCompanyModal">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form id="editCompanyForm" enctype="multipart/form-data">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">EDIT EMPLOYEE</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    <div class="row gy-4">
                        <input type="number" id="companyId" name="companyId" hidden>
                        <div class="col-12 d-flex flex-column justify-content-center align-items-center">
                            <div class="imgContainer">
                                <img src="<?= base_url('assets/images/company-placeholder.jpg'); ?>" data-originalsrc="<?= base_url('assets/images/company-placeholder.jpg'); ?>" alt="Company Logo" draggable="false" id="imgPreview" data-bs-toggle="tooltip" data-bs-title="Company Logo">
                            </div>
                            <label class="btn-warning mt-3 text-center w-50" for="addimgFile">UPLOAD PHOTO PROFILE</label>
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
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn-danger" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn-primary" id="editCompanyButton">SAVE</button>
                </div>
            </form>
        </div>
    </div>
</div> -->

<!-- Modal Delete -->
<!-- <div class="modal fade" id="deleteCompanyModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form id="deleteCompanyForm">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">
                        DELETE Employee
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    Are you sure want to delete <span class="fw-bold" id="companyName"></span> Employee?
                    <input type="number" id="companyId" name="companyId" hidden>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn-danger" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn-primary" id="deleteCompanyButton">DELETE</button>
                </div>
            </form>
        </div>
    </div>
</div> -->