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
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form id="addEmployeeForm">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">ADD EMPLOYEE</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    <div class="row gy-4">
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="NIN">
                                    <i class="las la-id-card fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="National ID Number" name="policyholderNIN">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Name">
                                    <i class="las la-user fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Name" name="policyholderName">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Email">
                                    <i class="las la-envelope fs-4"></i>
                                </span>
                                <input class="form-control" type="email" placeholder="Email" name="policyholderEmail">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Password">
                                    <i class="las la-key fs-4"></i>
                                </span>
                                <input type="password" class="form-control" id="policyholderPassword" placeholder="Password" name="policyholderPassword">
                                <span type="button" class="input-group-text bg-transparent" id="btnShowPassword" data-bs-toggle="tooltip" data-bs-title="Show/Hide Password">
                                    <i class="las la-eye-slash fs-4"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-12">
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
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Phone">
                                    <i class="las la-map fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Phone" name="policyholderPhone">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Address">
                                    <i class="las la-map fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Address" name="policyholderAddress">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Birth Date">
                                    <i class="las la-calendar fs-4"></i>
                                </span>
                                <input class="form-control" type="date" placeholder="Birth Date" name="policyholderBirth">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Gender">
                                    <i class="las la-venus-mars fs-4"></i>
                                </span>
                                <select class="form-control" name="policyholderGender">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Status">
                                    <i class="las la-user-check fs-4"></i>
                                </span>
                                <select class="form-control" name="policyholderStatus">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
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

                        <!-- National ID -->
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="NIN">
                                    <i class="las la-id-card fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="National ID Number" name="policyholderNIN" id="editNIN">
                            </div>
                        </div>

                        <!-- Name -->
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Name">
                                    <i class="las la-user fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Name" name="policyholderName" id="editName">
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Email">
                                    <i class="las la-envelope fs-4"></i>
                                </span>
                                <input class="form-control" type="email" placeholder="Email" name="policyholderEmail" id="editEmail">
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
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Address">
                                    <i class="las la-map fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Address" name="policyholderAddress" id="editAddress">
                            </div>
                        </div>

                        <!-- Birth Date -->
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Birth Date">
                                    <i class="las la-calendar fs-4"></i>
                                </span>
                                <input class="form-control" type="date" placeholder="Birth Date" name="policyholderBirth" id="editBirthDate">
                            </div>
                        </div>

                        <!-- Gender -->
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Gender">
                                    <i class="las la-venus-mars fs-4"></i>
                                </span>
                                <select class="form-control" name="policyholderGender" id="editGender">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Status">
                                    <i class="las la-user-check fs-4"></i>
                                </span>
                                <select class="form-control" name="policyholderStatus" id="editStatus">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
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
                    Are you sure want to delete <span class="fw-bold" id="policyholderName"></span> Employee?
                    <input type="number" id="policyholderNIN" name="policyholderNIN" hidden>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn-danger" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn-primary" id="deleteEmployeeButton">DELETE</button>
                </div>
            </form>
        </div>
    </div>
</div>