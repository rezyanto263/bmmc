<div class="content-header <?= $subtitle != 'Companies'? 'mt-5':'mt-2 d-lg-flex flex-lg-row' ?> align-items-center justify-content-between">
    <h1 class="mb-0 mt-5 <?= $subtitle != 'Companies'? 'd-none':'' ?>">Hello, <?= $this->session->userdata('adminName'); ?></h1>
    <div class="d-flex <?= $subtitle != 'Companies'? '':'flex-lg-column' ?> justify-content-between align-items-end p-0 mt-1">
        <h3 class="my-0 fw-semibold fs-2"><?= $subtitle ?></h3>
        <button class="rounded-2 p-2 mt-3 d-flex align-items-center gap-1" id="btn-notification" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNotification">
            <i class="las la-bell fs-5"></i>
                Notification
            <span class="bg-danger text-white rounded-2 p-1" id="totalNotification">10</span>
        </button>
    </div>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNotification">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Notifications</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
    ...
    </div>
</div>