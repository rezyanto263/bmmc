<!-- Floating Menu Start -->
<div class="floating-btn position-fixed d-flex m-3 gap-3">
    <button class="p-2 rounded floating-btn shadow-sm" id="btn-menu">
        <i class="las la-bars fs-3"></i>
    </button>
    <button class="p-2 rounded floating-btn shadow-sm" id="btn-mode">
        <i class="las la-moon fs-3"></i>
    </button>
    <button class="p-2 rounded floating-btn shadow-sm" id="btn-scan" data-bs-toggle="modal" data-bs-target="#scannerModal">
        <i class="las la-qrcode fs-3"></i>
    </button>
</div>
<!-- Floating Menu End -->

<!-- Scan Modal Start -->
<div class="modal fade" id="scannerModal" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content overflow-hidden">
            <div class="modal-header border-0">
                <h1 class="modal-title fs-5">QR SCANNER</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 d-flex flex-column justify-content-center">
                <video class="m-0" id="qrScanner"></video>
                <form id="qrForm" class="text-center px-5">
                    <input class="border border-1 rounded my-3 text-center w-100" readonly type="text" placeholder="Scan your QR please!" name="qrData">
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Scan Modal End -->

<!-- Scan Result Modal Start -->
<div id="#crudAlert" data-flashdata="" data-errorflashdata=""></div>
<div class="modal fade" id="scanResultModal" data-bs-backdrop="static">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h1 class="modal-title fs-5">SCAN RESULT</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body container-xxl">
                <h1>Profile Details</h1>
                <div class="row gy-4 mt-auto mb-5">
                    <div class="col-12 col-xl-3 my-auto mb-4 mb-xl-auto d-flex justify-content-center">
                        <div class="imgContainer my-auto" style="max-width: 300px; width: 300px; height: auto;">
                            <img src="<?= base_url('assets/images/user-placeholder.png') ?>" id="imgPreview" alt="User Photo"  draggable="false">
                        </div>
                    </div>
                    <div class="col-12 col-xl-9 my-auto">
                        <div class="row gy-4 gx-3 py-auto">
                            <div class="col-12 col-md-6">
                                <div class="input-group p-0">
                                    <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="NIK">
                                        <i class="las la-id-card fs-4"></i>    
                                    </span>
                                    <input class="form-control" type="text" placeholder="NIK" name="nik" disabled>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="input-group p-0">
                                    <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Name">
                                        <i class="las la-user fs-4"></i>
                                    </span>
                                    <input class="form-control" type="text" placeholder="Name" name="name" disabled>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="input-group p-0">
                                    <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Family Role">
                                        <i class="las la-user-tag fs-4"></i>
                                    </span>
                                    <input class="form-control" type="text" placeholder="Family Role" name="role" disabled>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="input-group p-0">
                                    <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Date of Birth">
                                        <i class="las la-birthday-cake fs-4"></i>
                                    </span>
                                    <input class="form-control" type="text" placeholder="Date of Birth" name="birth" disabled>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="input-group p-0">
                                    <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Gender">
                                        <i class="las la-transgender fs-4"></i>
                                    </span>
                                    <input class="form-control" type="text" placeholder="Gender" name="gender" disabled>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="input-group p-0">
                                    <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company Name">
                                        <i class="las la-building fs-4"></i>
                                    </span>
                                    <input class="form-control" type="text" placeholder="Company Name" name="companyName" disabled>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="input-group p-0">
                                    <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Email">
                                        <i class="las la-envelope fs-4"></i>
                                    </span>
                                    <input class="form-control" type="text" placeholder="Email" name="email" disabled>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="input-group p-0">
                                    <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Phone Number">
                                        <i class="las la-phone fs-4"></i>
                                    </span>
                                    <input class="form-control" type="text" placeholder="Phone Number" name="phone" disabled>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="input-group p-0">
                                    <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Address">
                                        <i class="las la-map-marked-alt fs-4"></i>
                                    </span>
                                    <input class="form-control" type="text" placeholder="Address" name="address" disabled>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="input-group p-0">
                                    <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Status">
                                        <i class="las la-map-marked-alt fs-4"></i>
                                    </span>
                                    <input class="form-control" type="text" placeholder="Status" name="status" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h1>History Health</h1>
                <div class="row">
                    <table id="patientTable" class="table" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Hospital</th>
                                <th>Doctor</th>
                                <th>Disease</th>
                                <th>Date</th>
                                <th>Bill</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Hospital</th>
                                <th>Doctor</th>
                                <th>Disease</th>
                                <th>Date</th>
                                <th>Bill</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Scan Result Modal End -->

<!-- View History Health Details Modal Start -->
<div class="modal fade" id="viewHistoryHealthDetailsModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content overflow-hidden">
            <div class="modal-header border-0">
                <h1 class="modal-title fs-5">History Health Complaint & Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row gy-4 gx-3">
                    <div class="col-12">
                        <div class="input-group p-0">
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Complaint">
                                <i class="las la-comment-dots fs-4"></i>  
                            </span>
                            <textarea class="form-control" type="text" placeholder="Complaint" name="historyhealthComplaint" disabled></textarea>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="input-group p-0">
                            <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Details">
                                <i class="las la-stethoscope fs-4"></i>
                            </span>
                            <textarea class="form-control" type="text" placeholder="Details" name="historyhealthDetails" disabled></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- View Patient Modal End -->