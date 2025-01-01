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
    <?php
    $n = 1;
    if ($n == 1) {
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
    } else {
        ?>
        <content class="content-body py-3">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <img src="<?= base_url("assets/images/pria.png") ?>" alt="" class="image-patient">
                </div>
                <div class="col-md-8">
                    <table class="table" style="width:100%">
                        <tbody>
                            <tr>
                                <th>NIK:</th>
                                <td>test test test test test test test</td>
                            </tr>
                            <tr>
                                <th>Name:</th>
                                <td>test test test test test test test</td>
                            </tr>
                            <tr>
                                <th>Company:</th>
                                <td>test test test test test test test</td>
                            </tr>
                            <tr>
                                <th>Birth:</th>
                                <td>test test test test test test test</td>
                            </tr>
                            <tr>
                                <th>Gender:</th>
                                <td>test test test test test test test</td>
                            </tr>
                            <tr>
                                <th>Address:</th>
                                <td>test test test test test test test</td>
                            </tr>
                            <tr>
                                <th>Phone:</th>
                                <td>test test test test test test test</td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td>test test test test test test test</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-flex justify-content-center mt-2">
                <div class="status w-100 justify-content-center d-flex">
                    <h3>
                        History
                    </h3>
                </div>
            </div>
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
        </content>
        <?php
    }
    ?>
</div>