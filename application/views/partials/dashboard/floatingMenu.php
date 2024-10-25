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
                <input class="border border-1 rounded my-3 mx-5 px-2 text-center" readonly type="text" placeholder="Scan your QR please!" id="qrData">
            </div>
        </div>
    </div>
</div>
<!-- Scan Modal End -->