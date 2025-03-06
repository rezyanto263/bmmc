<div class="content-header <?= $subtitle == 'Dashboard' ? 'mt-2 d-lg-flex flex-lg-row' : 'mt-5' ?> align-items-center justify-content-between">
    <h1 class="mb-1 mt-5 d-flex align-items-center <?= $subtitle == 'Dashboard' ? '' : 'd-none' ?>">
        <img src="<?= base_url('assets/images/wave.gif'); ?>" width="40px" height="40px" draggable="false">
        <span>Hello, <?= $this->session->userdata('adminName'); ?></span>
    </h1>
    <div class="d-flex <?= $subtitle == 'Dashboard' ? 'flex-lg-column mb-3 mb-lg-1' : '' ?> justify-content-between align-items-end p-0 mt-1">
        <h3 class="my-0"><?= $subtitle ?></h3>
        <button class="rounded-2 p-2 mt-3 d-flex align-items-center gap-1 position-relative" id="btnActivityLog" data-bs-toggle="offcanvas" data-bs-target="#offcanvasActivityLog" aria-controls="offcanvasActivityLog">
            <i class="las la-history fs-5"></i>
            Activity Log
            <span class="position-absolute top-0 start-100 translate-middle bg-danger rounded-circle" style="padding: 6px"></span>
        </button>
    </div>
</div>

<div class="offcanvas offcanvas-end" id="offcanvasActivityLog">
    <div class="offcanvas-header">
        <h4 class="offcanvas-title"><i class="las la-history fs-1 align-middle"></i> Activity Log</h4>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
    ...
    </div>
</div>

<div class="modal fade" id="logoutModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h3 class="modal-title text-danger">LOGOUT</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body border-0">
                <p>Are you sure want to logout from Bali Mitra Medical Center?</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn-primary" data-bs-dismiss="modal" aria-label="Close">CANCEL</button>
                <a href="<?= base_url('dashboard/logout'); ?>" class="btn-danger text-decoration-none">LOGOUT</a>
            </div>
        </div>
    </div>
</div>