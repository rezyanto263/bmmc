<div class="content-body py-3">
    <div id="#crudAlert" data-flashdata="" data-errorflashdata=""></div>
    <button type="button" class="btn-primary w-100 my-3 d-flex align-items-center justify-content-center gap-2" data-bs-toggle="modal" data-bs-target="#addDiseaseModal">
        <i class="las la-plus-circle fs-4"></i>    
        ADD DISEASE
    </button>
    <table id="diseasesTable" class="table" style="width:100%">
        <thead>
            <tr>
                <th>Disease Name</th>
                <th>Disease Information</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
    </table>
</div>



<!-- Modal Add -->
<div class="modal fade" id="addDiseaseModal" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form id="addDiseaseForm">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">ADD DISEASE</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    <div class="row gy-4 gx-3">
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Disease Name">
                                <i class="las la-briefcase-medical fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Disease Name" name="diseaseName">
                            </div>
                        </div>
                        <div class="col-12">   
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Disease Information">
                                    <i class="las la-notes-medical fs-4"></i>
                                </span>
                                <textarea class="form-control" type="text" placeholder="Disease Information" name="diseaseInformation"></textarea>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn-danger" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn-primary" id="addButton">ADD</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Modal Edit -->
<div class="modal fade" id="editDiseaseModal" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form id="editDiseaseForm">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">EDIT DISEASE</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    <div class="row gy-4 gx-3">
                        <input type="hidden" name="diseaseId">
                        <div class="col-12">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Disease Name">
                                    <i class="las la-briefcase-medical fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Disease Name" name="diseaseName">
                            </div>
                        </div>
                        <div class="col-12">   
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Disease Information">
                                    <i class="las la-notes-medical fs-4"></i>
                                </span>
                                <textarea class="form-control" type="text" placeholder="Disease Information" name="diseaseInformation"></textarea>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn-danger" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn-primary" id="editButton">SAVE</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Modal Delete -->
<div class="modal fade" id="deleteDiseaseModal" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form id="deleteDiseaseForm">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-4">
                        DELETE DISEASE
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    Are you sure want to delete "<span class="fw-bold" id="diseaseName"></span>" disease?
                    <input type="hidden" name="diseaseId">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn-primary" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn-danger" id="deleteDiseaseButton">DELETE</button>
                </div>
            </form>
        </div>
    </div>
</div>