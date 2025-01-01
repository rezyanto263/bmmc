<div class="content-body py-3">
    <div id="#crudAlert" data-flashdata="" data-errorflashdata=""></div>
    <table id="hHistoriesTable" class="table" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Patient Name</th>
                <th>Relationship to Policyholder</th>
                <th>Company Name</th>
                <th>Doctor Name</th>
                <th>Bill</th>
                <th>Date</th>
                <th>History Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>#</th>
                <th>Patient Name</th>
                <th>Relationship to Policyholder</th>
                <th>Company Name</th>
                <th>Doctor Name</th>
                <th>Bill</th>
                <th>Date</th>
                <th>History Status</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>
</div>


<!-- Modal Add -->
<div class="modal fade" id="checkPatient">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form id="checkPatientForm" enctype="multipart/form-data">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">Check Patient</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    <div class="row gy-4">
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Patient NIK">
                                    <i class="las la-stethoscope fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Patient NIK" name="patientNIK" pattern="\d{16}" title="NIK hanya dapat berisi 16 angka">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn-danger" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn-primary" id="chechPatientButton">CHECK</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="detailHistoryModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div id="detailContent">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">HISTORY DETAIL</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    <div class="row gy-4">
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Patient Name">
                                    <i class="las la-user-injured fs-4"></i>
                                </span>
                                <span class="form-control" id="patientName"></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Patient Status">
                                    <i class="las la-user-tag fs-4"></i>
                                </span>
                                <span class="form-control" id="historyhealthFamilyStatus"></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Policyholder Name">
                                    <i class="las la-user-shield fs-4"></i>
                                </span>
                                <span class="form-control" id="policyholderName"></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company Name">
                                    <i class="las la-building fs-4"></i>
                                </span>
                                <span class="form-control" id="companyName"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="History Health Date">
                                    <i class="las la-calendar-day fs-4"></i>
                                </span>
                                <span class="form-control" id="historyhealthDate"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="History Health Status">
                                    <i class="las la-history fs-4"></i>
                                </span>
                                <span class="form-control" id="historyhealthStatus"></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Doctor Name">
                                    <i class="las la-stethoscope fs-4"></i>
                                </span>
                                <span class="form-control" id="detailDoctorName"></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Complaint Note">
                                    <i class="las la-clipboard fs-4"></i>
                                </span>
                                <span class="form-control" id="historyhealthComplaint"></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Details">
                                    <i class="las la-file-alt fs-4"></i>
                                </span>
                                <span class="form-control" id="historyhealthDetails"></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Date Create">
                                    <i class="las la-calendar-plus fs-4"></i>
                                </span>
                                <span class="form-control" id="createdAt"></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Date Update">
                                    <i class="las la-calendar-check fs-4"></i>
                                </span>
                                <span class="form-control" id="updatedAt"></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Bill">
                                    <i class="las la-money-bill-wave fs-4"></i>
                                </span>
                                <span class="form-control" id="historyhealthBill"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn-secondary" data-bs-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>
</div>