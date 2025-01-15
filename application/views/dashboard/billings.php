<div class="content-body py-3">
    <div id="#crudAlert" data-flashdata="" data-errorflashdata=""></div>
    <button type="button" class="btn-primary w-100 my-3 d-flex align-items-center justify-content-center gap-2" data-bs-toggle="modal" data-bs-target="#addBillingModal">
        <i class="las la-plus-circle fs-4"></i>    
        ADD BILLING
    </button>
    <table id="billingsTable" class="table" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Logo</th>
                <th>Name</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Billing</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>#</th>
                <th>Logo</th>
                <th>Name</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Billing</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>
</div>


<!-- Modal Add -->
<div class="modal fade" id="addBillingModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form id="addBillingForm">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">ADD BILLING</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    <div class="row gy-4 gx-3">
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Company">
                                    <i class="las la-building fs-4"></i>
                                </span>
                                <select class="form-control" data-live-search="true" title="Choose Company" name="companyId">
                                    <option hidden></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Billing Start Date">
                                    <i class="las la-calendar-check fs-4"></i>
                                </span>
                                <input class="form-control" type="date" name="billingStartedAt" min="<?= date('Y-m-d'); ?>" placeholder="Start Date">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Billing End Date">
                                    <i class="las la-calendar-times fs-4"></i>
                                </span>
                                <input class="form-control" type="date" name="billingEndedAt" min="<?= date('Y-m-d'); ?>" placeholder="End Date">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Billing Status">
                                    <i class="las la-tag fs-4"></i>
                                </span>
                                <select class="form-control" name="billingStatus">
                                    <option hidden></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Billing Amount">
                                    <i class="las la-credit-card fs-4"></i>
                                </span>
                                <input class="form-control currency-input" placeholder="Billing Amount" min="0" name="billingAmount">
                            </div>
                        </div>
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn-danger" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn-primary" id="addButton">ADD</button>
                </div>
            </form>
        </div>
    </div>
</div>