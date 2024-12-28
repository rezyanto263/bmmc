<div class="content-body py-3">
    <div id="#crudAlert" data-flashdata="" data-errorflashdata=""></div>
    <?php 
        $n = 1;
        if ($n == 1) {
    ?>
        <div style="height: 200px;"> 
            <button type="button" id="btn-scan" class="h-100 w-100 my-3 d-flex align-items-center justify-content-center gap-2" data-bs-toggle="modal" data-bs-target="#scannerModal">
                <i class="las la-qrcode fs-1"></i> 
                <span class="fs-4">Please Scan Patient QR First</span> 
            </button>
        </div>
    <?php 
        } else {
    ?>

    

    <?php 
        }
    ?>
</div>