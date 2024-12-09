<div class="content-body py-3">
    <div id="#crudAlert" data-flashdata="" data-errorflashdata=""></div>
    <button type="button" class="btn-primary w-100 my-3 d-flex align-items-center justify-content-center gap-2" data-bs-toggle="modal" data-bs-target="#addTreatmentModal">
        <i class="las la-plus-circle fs-4"></i>
        ADD TREATMENT
    </button>
    <table id="hHistoriesTable" class="table" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Policy Holder Name</th>
                <th>Company Name</th>
                <th>Date</th>
                <th>History Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>#</th>
                <th>Policy Holder Name</th>
                <th>Company Name</th>
                <th>Date</th>
                <th>History Status</th>
                <th>Actions</th>
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
                        <div class="col-12 col-md-8">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Patient NIN">
                                    <i class="las la-user-tag fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Patient NIN" name="patientNIN">
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="input-group p-0">
                                <button class="btn-primary w-100" onclick="checkPatientNIN()">Check</button>
                            </div>
                        </div>
                        <div class="col-12 md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Date">
                                    <i class="las la-building fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Company Name" name="companyName" disabled>
                            </div>
                        </div>
                        <div class="col-12 md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Date">
                                    <i class="las la-user-cog fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Policy Holder Name" name="policyholderName" disabled>
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