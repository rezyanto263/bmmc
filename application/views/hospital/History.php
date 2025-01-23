<div class="content-body py-3">
    <div id="#crudAlert" data-flashdata="" data-errorflashdata=""></div>
    <table id="hHistoriesTable" class="table" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Patient Name</th>
                <th>Role</th>
                <th>Company Name</th>
                <th>Doctor Name</th>
                <th>Date</th>
                <th>Invoice Status</th>
                <th>Total Bill</th>
                <th>Detail</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
               <th></th>
               <th></th>
               <th></th>
               <th></th>
               <th></th>
               <th></th>
               <th class="text-end">Total:</th>
               <th></th>
               <th></th>
            </tr>
        </tfoot>
    </table>
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
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Patient Role">
                                    <i class="las la-user-tag fs-4"></i>
                                </span>
                                <span class="form-control" id="historyhealthRole"></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Employee Name">
                                    <i class="las la-user-shield fs-4"></i>
                                </span>
                                <span class="form-control" id="employeeName"></span>
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
                                <span class="form-control" id="invoiceStatus"></span>
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
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Disease Name">
                                    <i class="las la-medkit fs-4"></i>
                                </span>
                                <span class="form-control" id="diseaseName"></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Doctor Fee">
                                    <i class="las la-briefcase-medical fs-4"></i>
                                </span>
                                <span class="form-control" id="historyhealthDoctorFee"></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Medicine Fee">
                                    <i class="las la-pills fs-4"></i>
                                </span>
                                <span class="form-control" id="historyhealthMedicineFee"></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Lab Fee">
                                    <i class="las la-file-alt fs-4"></i>
                                </span>
                                <span class="form-control" id="historyhealthLabFee"></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Action Fee">
                                    <i class="las la-file-alt fs-4"></i>
                                </span>
                                <span class="form-control" id="historyhealthActionFee"></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Discount">
                                    <i class="las la-file-alt fs-4"></i>
                                </span>
                                <span class="form-control" id="historyhealthDiscount"></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Total Bill">
                                    <i class="las la-money-bill-wave fs-4"></i>
                                </span>
                                <span class="form-control" id="historyhealthTotalBill"></span>
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
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn-secondary" data-bs-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Rujukan -->
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
                                <span class="form-control" id="historyhealthRole"></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Employee Name">
                                    <i class="las la-user-shield fs-4"></i>
                                </span>
                                <span class="form-control" id="employeeName"></span>
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
                                <span class="form-control" id="invoiceStatus"></span>
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
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Disease Name">
                                    <i class="las la-medkit fs-4"></i>
                                </span>
                                <span class="form-control" id="diseaseName"></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Doctor Fee">
                                    <i class="las la-briefcase-medical fs-4"></i>
                                </span>
                                <span class="form-control" id="historyhealthDoctorFee"></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Medicine Fee">
                                    <i class="las la-pills fs-4"></i>
                                </span>
                                <span class="form-control" id="historyhealthMedicineFee"></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Lab Fee">
                                    <i class="las la-file-alt fs-4"></i>
                                </span>
                                <span class="form-control" id="historyhealthLabFee"></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Action Fee">
                                    <i class="las la-file-alt fs-4"></i>
                                </span>
                                <span class="form-control" id="historyhealthActionFee"></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Discount">
                                    <i class="las la-file-alt fs-4"></i>
                                </span>
                                <span class="form-control" id="historyhealthDiscount"></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Total Bill">
                                    <i class="las la-money-bill-wave fs-4"></i>
                                </span>
                                <span class="form-control" id="historyhealthTotalBill"></span>
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
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn-secondary" data-bs-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>
</div>