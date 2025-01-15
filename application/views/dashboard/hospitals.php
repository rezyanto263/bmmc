<div class="content-body py-3">
    <div id="#crudAlert" data-flashdata="" data-errorflashdata=""></div>
    <button type="button" class="btn-primary w-100 my-3 d-flex align-items-center justify-content-center gap-2" data-bs-toggle="modal" data-bs-target="#addHospitalModal">
        <i class="las la-plus-circle fs-4"></i>    
        ADD HOSPITAL
    </button>
    <table id="hospitalsTable" class="table" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Admin</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Status</th>
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
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>
</div>


<!-- Modal Add -->
<div class="modal fade" id="addHospitalModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="addHospitalForm" enctype="multipart/form-data">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">ADD HOSPITAL</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    <div class="row gy-4">
                        <div class="col-12 col-lg-6 d-flex flex-column justify-content-center align-items-center">
                            <div class="imgContainer">
                                <img src="<?= base_url('assets/images/hospital-placeholder.jpg'); ?>" data-originalsrc="<?= base_url('assets/images/hospital-placeholder.jpg'); ?>" alt="Hospital Logo" draggable="false" id="imgPreview" data-bs-toggle="tooltip" data-bs-title="Hospital Logo">
                            </div>
                            <label class="btn-warning mt-3 text-center w-50" for="addImgFile">UPLOAD LOGO</label>
                            <input type="file" accept="image/jpg, image/jpeg, image/png" name="hospitalLogo" class="imgFile" id="addImgFile" hidden>
                        </div>
                        <div class="col-12 col-lg-6 d-flex flex-column justify-content-center align-items-center">
                            <div class="imgContainer">
                                <img src="<?= base_url('assets/images/hospital-placeholder.jpg'); ?>" data-originalsrc="<?= base_url('assets/images/hospital-placeholder.jpg'); ?>" alt="Hospital Photo" draggable="false" id="imgPreview" data-bs-toggle="tooltip" data-bs-title="Hospital Photo">
                            </div>
                            <label class="btn-warning mt-3 text-center w-50" for="addImgFile2">UPLOAD PHOTO</label>
                            <input type="file" accept="image/jpg, image/jpeg, image/png" name="hospitalPhoto" class="imgFile" id="addImgFile2" hidden>
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Hospital Name">
                                    <i class="las la-hospital fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Name" name="hospitalName">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">   
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Hospital Phone">
                                    <i class="las la-phone fs-4"></i>
                                </span>
                                <input class="form-control phone-input" type="text" placeholder="Phone Number" name="hospitalPhone">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">   
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Hospital Status">
                                    <i class="las la-tag fs-4"></i>
                                </span>
                                <select class="form-control" id="hospitalStatus" name="hospitalStatus">
                                    <option hidden></option>
                                </select>
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
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Hospital Address">
                                    <i class="las la-map fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Address" name="hospitalAddress">
                            </div>
                        </div>
                        <div class="col-12">   
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Hospital Coordinate">
                                    <i class="las la-map-marker fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Location Coordinate" name="hospitalCoordinate">
                            </div>
                        </div>
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn-danger" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn-primary" id="addHospitalButton">ADD</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal View -->
<div class="modal fade" id="viewHospitalModal">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h1 class="modal-title fs-4">HOSPITAL DETAILS</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body border-0">
                <div class="row">
                    <div class="col-12 col-lg-6 d-flex justify-content-center align-items-center">
                    <div class="row gy-4">
                        <div class="col-12 d-flex flex-column justify-content-center align-items-center">
                            <div class="imgContainer">
                                <img src="<?= base_url('assets/images/hospital-placeholder.jpg'); ?>" data-originalsrc="<?= base_url('assets/images/hospital-placeholder.jpg'); ?>" alt="Hospital Logo" draggable="false" id="imgPreview" data-bs-toggle="tooltip" data-bs-title="Hospital Logo">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Hospital Name">
                                    <i class="las la-hospital fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Name" name="hospitalName" disabled>
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
                        <div class="col-12 col-lg-6">   
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Hospital Phone">
                                    <i class="las la-phone fs-4"></i>
                                </span>
                                <input class="form-control phone-input" type="text" placeholder="Phone Number" name="hospitalPhone" disabled>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">   
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Hospital Status">
                                    <i class="las la-tag fs-4"></i>
                                </span>
                                <div class="form-control" id="hospitalStatus"></div>
                            </div>
                        </div>
                        <div class="col-12">   
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Hospital Address">
                                    <i class="las la-map fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Address" name="hospitalAddress" disabled>
                            </div>
                        </div>
                        <div class="col-12">   
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Hospital Coordinate">
                                    <i class="las la-map-marker fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Location Coordinate" name="hospitalCoordinate" disabled>
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
<div class="modal fade" id="editHospitalModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="editHospitalForm" enctype="multipart/form-data">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">EDIT HOSPITAL</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    <div class="row gy-4">
                        <input type="hidden" name="hospitalId">
                        <div class="col-12 col-lg-6 d-flex flex-column justify-content-center align-items-center">
                            <div class="imgContainer">
                                <img src="<?= base_url('assets/images/hospital-placeholder.jpg'); ?>" data-originalsrc="<?= base_url('assets/images/hospital-placeholder.jpg'); ?>" alt="Hospital Logo" draggable="false" id="imgPreview" data-bs-toggle="tooltip" data-bs-title="Hospital Logo">
                            </div>
                            <label class="btn-warning mt-3 text-center w-50" for="editImgFile">UPLOAD LOGO</label>
                            <input type="file" accept="image/jpg, image/jpeg, image/png" name="hospitalLogo" class="imgFile" id="editImgFile" hidden>
                        </div>
                        <div class="col-12 col-lg-6 d-flex flex-column justify-content-center align-items-center">
                            <div class="imgContainer">
                                <img src="<?= base_url('assets/images/hospital-placeholder.jpg'); ?>" data-originalsrc="<?= base_url('assets/images/hospital-placeholder.jpg'); ?>" alt="Hospital Photo" draggable="false" id="imgPreview2" data-bs-toggle="tooltip" data-bs-title="Hospital Photo">
                            </div>
                            <label class="btn-warning mt-3 text-center w-50" for="editImgFile2">UPLOAD PHOTO</label>
                            <input type="file" accept="image/jpg, image/jpeg, image/png" name="hospitalPhoto" class="imgFile" id="editImgFile2" hidden>
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Hospital Name">
                                    <i class="las la-hospital fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Name" name="hospitalName">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">   
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Hospital Phone">
                                    <i class="las la-phone fs-4"></i>
                                </span>
                                <input class="form-control phone-input" type="text" placeholder="Phone Number" name="hospitalPhone">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">   
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Hospital Status">
                                    <i class="las la-tag fs-4"></i>
                                </span>
                                <select class="form-control" name="hospitalStatus">
                                    <option hidden></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Admin Account">
                                    <i class="las la-user-cog fs-4"></i>
                                </span>
                                <select class="form-control" data-live-search="true" title="Choose Admin" name="adminId">
                                    <option hidden></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">   
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Hospital Address">
                                    <i class="las la-map fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Address" name="hospitalAddress">
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
                                <input class="form-control" type="text" placeholder="Location Coordinate" name="hospitalCoordinate">
                            </div>
                        </div>
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn-danger" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn-primary" id="editHospitalButton">SAVE</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="deleteHospitalModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form id="deleteHospitalForm">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">
                        DELETE HOSPITAL
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    Are you sure want to delete <span class="fw-bold" id="hospitalName"></span> hospital?
                    <input type="hidden" name="hospitalId">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn-primary" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn-danger" id="deleteHospitalButton">DELETE</button>
                </div>
            </form>
        </div>
    </div>
</div>