<div class="content-body py-3">
    <div id="#crudAlert" data-flashdata="" data-errorflashdata=""></div>
    <button type="button" class="btn-primary w-100 my-3 d-flex align-items-center justify-content-center gap-2" data-bs-toggle="modal" data-bs-target="#addFamilyModal2">
        <i class="las la-plus-circle fs-4"></i>    
        ADD FAMILY
    </button>
    <table id="allfamiliesTable" class="table" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Family NIN</th>
                <th>Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>Birth Date</th>
                <th>Gender</th>
                <th>Role</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>#</th>
                <th>Family NIN</th>
                <th>Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>Birth Date</th>
                <th>Gender</th>
                <th>Role</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>
</div>

<!-- Modal Add -->
<div class="modal fade" id="addFamilyModal2">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form id="addFamilyForm">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">ADD FAMILY MEMBER</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    <div class="row gy-4">
                        <!-- Family NIN -->
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Family NIN">
                                    <i class="las la-id-card fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Family National ID Number" name="familyNIN" id="familyNIN">
                            </div>
                        </div>
                        <!-- Policyholder NIN -->
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Policyholder NIN">
                                    <i class="las la-id-card fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Policyholder National ID Number" name="policyholderNIN" id="policyholderNIN">
                            </div>
                        </div>
                        <!-- Family Name -->
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Full Name">
                                    <i class="las la-user fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Full Name" name="familyName" id="familyName">
                            </div>
                        </div>
                        <!-- Family Email -->
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Email Address">
                                    <i class="las la-envelope fs-4"></i>
                                </span>
                                <input class="form-control" type="email" placeholder="Email Address" name="familyEmail" id="familyEmail">
                            </div>
                        </div>
                        <!-- Family Password -->
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Password">
                                    <i class="las la-key fs-4"></i>
                                </span>
                                <input type="password" class="form-control" id="familyPassword" placeholder="Password" name="familyPassword">
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
                        <!-- Family Address -->
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Address">
                                    <i class="las la-map-marker-alt fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Address" name="familyAddress" id="familyAddress">
                            </div>
                        </div>
                        <!-- Family Birth -->
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Date of Birth">
                                    <i class="las la-birthday-cake fs-4"></i>
                                </span>
                                <input class="form-control" type="date" name="familyBirth" id="familyBirth">
                            </div>
                        </div>
                        <!-- Family Gender -->
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Gender">
                                    <i class="las la-venus-mars fs-4"></i>
                                </span>
                                <select class="form-select" name="familyGender" id="familyGender">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>
                        <!-- Family Role -->
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Role">
                                    <i class="las la-briefcase fs-4"></i>
                                </span>
                                <select class="form-select" name="familyRole" id="familyRole">
                                    <option value="Children">Children</option>
                                    <option value="Parent">Parent</option>
                                    <option value="Brother/Sister">Brother/Sister</option>
                                </select>
                            </div>
                        </div>
                        <!-- Family Status -->
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Status">
                                    <i class="las la-toggle-on fs-4"></i>
                                </span>
                                <select class="form-select" name="familyStatus" id="familyStatus">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="addFamilyButton">Save Family Member</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editFamilyModal2">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form id="editFamilyForm2" enctype="multipart/form-data">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">EDIT Family</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    <div class="row gy-4">
                        <input type="number" id="familyId" name="familyId" hidden>

                        <!-- Family NIN -->
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Family NIN">
                                    <i class="las la-id-card fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Family National ID Number" name="familyNIN" id="familyNIN">
                            </div>
                        </div>
                        <!-- Policyholder NIN -->
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Policyholder NIN">
                                    <i class="las la-id-card fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Policyholder National ID Number" name="policyholderNIN" id="policyholderNIN">
                            </div>
                        </div>
                        <!-- Family Name -->
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Full Name">
                                    <i class="las la-user fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Full Name" name="familyName" id="familyName">
                            </div>
                        </div>
                        <!-- Family Email -->
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Email Address">
                                    <i class="las la-envelope fs-4"></i>
                                </span>
                                <input class="form-control" type="email" placeholder="Email Address" name="familyEmail" id="familyEmail">
                            </div>
                        </div>
                        <!-- Family Password -->
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Password">
                                    <i class="las la-key fs-4"></i>
                                </span>
                                <input type="password" class="form-control" id="familyPassword" placeholder="Password" name="newPassword">
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
                        <!-- Family Address -->
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Address">
                                    <i class="las la-map-marker-alt fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Address" name="familyAddress" id="familyAddress">
                            </div>
                        </div>
                        <!-- Family Birth -->
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Date of Birth">
                                    <i class="las la-birthday-cake fs-4"></i>
                                </span>
                                <input class="form-control" type="date" name="familyBirth" id="familyBirth">
                            </div>
                        </div>
                        <!-- Family Gender -->
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Gender">
                                    <i class="las la-venus-mars fs-4"></i>
                                </span>
                                <select class="form-select" name="familyGender" id="familyGender">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>
                        <!-- Family Role -->
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Role">
                                    <i class="las la-briefcase fs-4"></i>
                                </span>
                                <select class="form-select" name="familyRole" id="familyRole">
                                    <option value="Children">Children</option>
                                    <option value="Parent">Parent</option>
                                    <option value="Brother/Sister">Brother/Sister</option>
                                </select>
                            </div>
                        </div>
                        <!-- Family Status -->
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Status">
                                    <i class="las la-toggle-on fs-4"></i>
                                </span>
                                <select class="form-select" name="familyStatus" id="familyStatus">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn-danger" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn-primary" id="editFamilyButton2">SAVE</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="deleteFamilyModal2" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form id="deleteFamilyForm2">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">
                        DELETE Family
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    Are you sure want to delete <span class="fw-bold" id="familyName"></span> Family?
                    <input type="number" id="familyNIN" name="familyNIN" hidden>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn-danger" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn-primary" id="deleteFamilyButton2">DELETE</button>
                </div>
            </form>
        </div>
    </div>
</div>