<div class="content-body py-3">
    <div id="#crudAlert" data-flashdata="" data-errorflashdata=""></div>
    <button type="button" class="btn-primary w-100 my-3 d-flex align-items-center justify-content-center gap-2" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
        <i class="las la-plus-circle fs-4"></i>    
        ADD EMPLOYEE
    </button>
    <table id="employeesTable" class="table" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Birth</th>
                <th>Gender</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>#</th>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Birth</th>
                <th>Gender</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>
</div>


<!-- Modal Add -->
<div class="modal fade" id="addEmployeeModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="addEmployeeForm">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">ADD EMPLOYEE</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    <div class="row gy-4">
                        <div class="col-12 d-flex flex-column justify-content-center align-items-center">
                                <div class="imgContainer">
                                    <img src="<?= base_url('assets/images/company-placeholder.jpg'); ?>" data-originalsrc="<?= base_url('assets/images/company-placeholder.jpg'); ?>" alt="Company Logo" draggable="false" id="imgPreview" data-bs-toggle="tooltip" data-bs-title="Company Logo">
                                </div>
                                <label class="btn-warning mt-3 text-center w-50" for="addImgFile">UPLOAD LOGO</label>
                                <input type="file" accept="image/jpg, image/jpeg, image/png" name="employeePhoto" class="imgFile" id="addImgFile" hidden>
                            </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="NIK">
                                    <i class="las la-id-card fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="National ID Number" name="employeeNIK">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Name">
                                    <i class="las la-user fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Name" name="employeeName">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Insurance Account">
                                    <i class="las la-user-cog fs-4"></i>
                                </span>
                                <select class="form-control" data-live-search="true" title="Choose Insurance" id="insuranceId" name="insuranceId">
                                    <option hidden></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Email">
                                    <i class="las la-envelope fs-4"></i>
                                </span>
                                <input class="form-control" type="email" placeholder="Email" name="employeeEmail">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Password">
                                    <i class="las la-key fs-4"></i>
                                </span>
                                <input type="password" class="form-control" id="employeePassword" placeholder="Password" name="employeePassword">
                                <span type="button" class="input-group-text bg-transparent" id="btnShowPassword" data-bs-toggle="tooltip" data-bs-title="Show/Hide Password">
                                    <i class="las la-eye-slash fs-4"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Password Confirmation">
                                    <i class="las la-key fs-4"></i>
                                </span>
                                <input type="password" class="form-control" placeholder="Password Confirmation" name="confirmPassword">
                                <span type="button" class="input-group-text bg-transparent" id="btnShowPassword" data-bs-toggle="tooltip" data-bs-title="Show/Hide Password">
                                    <i class="las la-eye-slash fs-4"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Phone">
                                    <i class="las la-map fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Phone" name="employeePhone">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Address">
                                    <i class="las la-map fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Address" name="employeeAddress">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Birth Date">
                                    <i class="las la-calendar fs-4"></i>
                                </span>
                                <input class="form-control" type="date" placeholder="Birth Date" name="employeeBirth">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Gender">
                                    <i class="las la-venus-mars fs-4"></i>
                                </span>
                                <select class="form-control" id="employeeGender" name="employeeGender">
                                    <option hidden></option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                        </div>
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


<!-- Modal Edit -->
<div class="modal fade" id="editEmployeeModal">
    <div class="modal-dialog modal-dialog-centered modal-md">
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
                                <img src="<?= base_url('assets/images/company-placeholder.jpg'); ?>" data-originalsrc="<?= base_url('assets/images/company-placeholder.jpg'); ?>" alt="Company Logo" draggable="false" id="imgPreview" data-bs-toggle="tooltip" data-bs-title="Company Logo">
                            </div>
                            <label class="btn-warning mt-3 text-center w-50" for="editImgFile">UPLOAD LOGO</label>
                            <input type="file" accept="image/jpg, image/jpeg, image/png" name="employeePhoto" class="imgFile" id="editImgFile" hidden>
                        </div>
                        <!-- National ID -->
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="NIK">
                                    <i class="las la-id-card fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="National ID Number" name="employeeNIK" id="editNIK">
                            </div>
                        </div>

                        <!-- Name -->
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Name">
                                    <i class="las la-user fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Name" name="employeeName" id="editName">
                            </div>
                        </div>
                        
                        <!-- Insurance -->
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Insurance Account">
                                    <i class="las la-user-cog fs-4"></i>
                                </span>
                                <select class="form-control" title="Choose Insurance" id="insuranceId" name="insuranceId">
                                    <option hidden></option>
                                </select>
                            </div>
                        </div>
                        <!-- Email -->
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Email">
                                    <i class="las la-envelope fs-4"></i>
                                </span>
                                <input class="form-control" type="email" placeholder="Email" name="employeeEmail" id="editEmail">
                            </div>
                        </div>
                        <!-- Phone -->
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Phone">
                                    <i class="las la-envelope fs-4"></i>
                                </span>
                                <input class="form-control" type="phone" placeholder="Phone" name="employeePhone" id="editPhone">
                            </div>
                        </div>
                        <!-- Password -->
                        <div class="col-12 d-flex justify-content-between w-100">
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
                                <input type="password" class="form-control" id="adminPassword" placeholder="Password" name="newPassword">
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

                        <!-- Address -->
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Address">
                                    <i class="las la-map fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Address" name="employeeAddress" id="editAddress">
                            </div>
                        </div>

                        <!-- Birth Date -->
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Birth Date">
                                    <i class="las la-calendar fs-4"></i>
                                </span>
                                <input class="form-control" type="date" placeholder="Birth Date" name="employeeBirth" id="editBirthDate">
                            </div>
                        </div>

                        <!-- Gender -->
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Gender">
                                    <i class="las la-venus-mars fs-4"></i>
                                </span>
                                <select class="form-control" name="employeeGender" id="editGender">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
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
<div class="modal fade" id="deleteEmployeeModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form id="deleteEmployeeForm">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">
                        DELETE Employee
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    Are you sure want to delete <span class="fw-bold" id="employeeName"></span> Employee?
                    <input type="number" id="employeeNIK" name="employeeNIK" hidden>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn-danger" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn-primary" id="deleteEmployeeButton">DELETE</button>
                </div>
            </form>
        </div>
    </div>
</div>