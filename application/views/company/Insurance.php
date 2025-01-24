<div class="content-body py-3">
    <div id="#crudAlert" data-flashdata="" data-errorflashdata=""></div>
    <button type="button" class="btn-primary w-100 my-3 d-flex align-items-center justify-content-center gap-2" data-bs-toggle="modal" data-bs-target="#addInsuranceModal">
        <i class="las la-plus-circle fs-4"></i>    
        ADD INSURANCE
    </button>
    <table id="insurancesTable" class="table" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Insurance Tier</th>
                <th>Insurance Amount</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>#</th>
                <th>Insurance Tier</th>
                <th>Insurance Amount</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>
</div>

<!-- Modal Add -->
<div class="modal fade" id="addInsuranceModal">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form id="addInsuranceForm">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">ADD INSURANCE</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    <div class="row gy-4">
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Insurance Tier Name">
                                    <i class="las la-tag fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Insurance Tier Name" name="insuranceTier">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Insurance Amount">
                                    <i class="las la-wallet fs-4"></i>
                                </span>
                                <input class="form-control currency-input" type="text" placeholder="Insurance Amount" name="insuranceAmount">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Insurance Description">
                                    <i class="las la-comment-dollar fs-4"></i>
                                </span>
                                <textarea class="form-control" placeholder="Insurance Description" name="insuranceDescription"></textarea>
                            </div>
                        </div>
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn-danger" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn-primary" id="addInsuranceButton">ADD</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Insurance -->
<div class="modal fade" id="editInsuranceModal">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form id="editInsuranceForm">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">EDIT INSURANCE</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    <div class="row gy-4">
                        <input type="hidden" name="insuranceId">
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Insurance Tier Name">
                                    <i class="las la-tag fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Insurance Tier Name" name="insuranceTier">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Insurance Amount">
                                    <i class="las la-wallet fs-4"></i>
                                </span>
                                <input class="form-control currency-input" type="text" placeholder="Insurance Amount" name="insuranceAmount">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Insurance Description">
                                    <i class="las la-comment-dollar fs-4"></i>
                                </span>
                                <textarea class="form-control" placeholder="Insurance Description" name="insuranceDescription"></textarea>
                            </div>
                        </div>
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn-danger" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn-primary" id="editInsuranceButton">SAVE</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Delete Insurance -->
<div class="modal fade" id="deleteInsuranceModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form id="deleteInsuranceForm">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">
                        DELETE Insurance
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    Are you sure want to delete <span class="fw-bold" id="insuranceTier"></span> Insurance?
                    <input type="hidden" name="insuranceId">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                </div>  
                <div class="modal-footer border-0">
                    <button type="button" class="btn-danger" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn-primary" id="deleteInsuranceButton">DELETE</button>
                </div>
            </form>
        </div>
    </div>
</div>