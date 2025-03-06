<div class="content-body py-3">
    <div id="#crudAlert" data-flashdata="" data-errorflashdata=""></div>
    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
    <button type="button" class="btn-primary w-100 my-3 d-flex align-items-center justify-content-center gap-2" data-bs-toggle="modal" data-bs-target="#addDiseaseModal">
        <i class="las la-plus-circle fs-4"></i>    
        ADD DISEASE
    </button>
    <table id="diseasesTable" class="table" style="width:100%">
        <thead>
            <tr>
                <th>Disease Name</th>
                <th>Disease Information</th>
                <th class="text-center">Coverage</th>
            </tr>
        </thead>
    </table>
</div>