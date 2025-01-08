<style>
    .status {
        background-color: var(--primary);
        color: white;
        border-radius: 7px;
        padding: 8px 10px;
        font-weight: var(--fwbold);
        box-shadow: none;
    }

    .image-patient {
        object-fit: cover;
        width: 100%;
    }

    .custom-icon {
        font-size: 8rem;
    }
</style>

<div class="content-body py-3">
    <div id="#crudAlert" data-flashdata="" data-errorflashdata=""></div>
    <button type="button" class="btn-primary w-100 my-3 d-flex align-items-center justify-content-center gap-2"
        data-bs-toggle="modal" data-bs-target="#testCheckPatientModal">
        <i class="las la-plus-circle fs-4"></i>
        Scan Patient
    </button>
    <?php
    // if (isset($patientTable) && isset($hPatientTable)) {
        $n = 1;
        if ($n == 1) {
        ?>
        <content class="content-body py-3">
            <div class="row">
                <div class="col-md-5 mb-3">
                    <img src="<?= base_url("assets/images/pria.png") ?>" alt="" class="image-patient">
                </div>
                <div class="col-md-6">
                    <table class="table" id="" style="width:100%">
                        <tbody>
                            <tr>
                                <th>Name:</th>
                                <td></td>
                            </tr>
                            <tr>
                                <th>NIK:</th>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Company:</th>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Birth Date:</th>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Gender:</th>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Address:</th>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Phone:</th>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-end p-0 mt-4">
                <h3 class="my-0">History Patient</h3>
                <button type="button" class="btn-primary rounded-2 p-2 mt-3 d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#addHistoryModal">
                    <i class="las la-plus-circle fs-4"></i>
                    ADD HISTORY PATIENT
                </button>
            </div>
            <div class="content-body py-3">
                <div id="#crudAlert" data-flashdata="" data-errorflashdata=""></div>
                <!-- id="hPatientTable" -->
                <table class="table" id="" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Patient Name</th>
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
                            <th>Doctor Name</th>
                            <th>Bill</th>
                            <th>Date</th>
                            <th>History Status</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                </table>
                
            </div>
        </content>
        <?php
    } else {
        ?>
        <div style="height: 200px; py-3">
            <button type="button" id="btn-scan"
                class="btn h-100 w-100 my-3 d-flex align-items-center justify-content-center gap-2 rounded-4" data-bs-toggle="modal"
                data-bs-target="#scannerModal">
                <i class="las la-qrcode custom-icon"></i>
                <span class="fs-1">Please Scan Patient QR First</span>
            </button>
        </div>
        <?php
    }
    ?>
</div>

<!-- test check patient modal -->
<div class="modal fade" id="testCheckPatientModal">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form id="testCheckPatientForm">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">Check Patient</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    <div class="row gy-4">
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip"
                                    data-bs-title="Input NIK Patient">
                                    <i class="las la-user-cog fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Patient NIK" id="patientNIK" name="patientNIK">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn-danger" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn-primary" id="testCheckPatient">CHECK</button>
                </div>
            </form>
        </div>
    </div>
</div>