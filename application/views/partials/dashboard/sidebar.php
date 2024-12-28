<!-- Sidebar Start -->
<aside class="minimize shadow-sm">
    <div class="container-fluid p-0 d-flex flex-column justify-content-between">
        <div class="sidebar-header p-3 gap-3">
            <img src="<?= base_url('assets/images/logo.png') ?>" alt="" draggable="false">
            <div class="logo-text" draggable="false">
                <h4 class="mb-0">
                    BALI MITRA <br>
                    MEDICAL CENTER
                </h4>
                <p class="mb-0">
                    Health Insurance Service<br> 
                    Provider in Bali
                </p>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="p-0 m-0">
                <li>
                    <a class="d-flex align-items-center gap-3 ps-4 py-3 <?= $subtitle == 'Dashboard'?'active':''; ?>" href="<?= base_url('dashboard') ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Dashboard">
                        <i class="las la-stream fs-4"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a class="d-flex align-items-center gap-3 ps-4 py-3 <?= $subtitle == 'Scan Details'?'active':''; ?>" href="<?= base_url('dashboard/scan') ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Scan Details">
                        <i class="las la-id-card fs-4"></i>
                        <span>Scan Details</span>
                    </a>
                </li>
                <li>
                    <a class="d-flex align-items-center gap-3 ps-4 py-3 <?= $subtitle == 'Bills'?'active':''; ?>" href="<?= base_url('dashboard/bills') ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Bills">
                        <i class="las la-file-invoice-dollar fs-4"></i>
                        <span>Bills</span>
                    </a>
                </li>
                <li>
                    <a class="d-flex align-items-center gap-3 ps-4 py-3 <?= $subtitle == 'Companies'?'active':''; ?>" href="<?= base_url('dashboard/companies') ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Companies">
                        <i class="las la-building fs-4"></i>
                        <span>Companies</span>
                    </a>
                </li>
                <li>
                    <a class="d-flex align-items-center gap-3 ps-4 py-3 <?= $subtitle == 'Hospitals'?'active':''; ?>" href="<?= base_url('dashboard/hospitals') ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Hospitals">
                        <i class="las la-hospital fs-4"></i>
                        <span>Hospitals</span>
                    </a>
                </li>
                <li>
                    <a class="d-flex align-items-center gap-3 ps-4 py-3 <?= $subtitle == 'News'?'active':''; ?>" href="<?= base_url('dashboard/news') ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="News">
                        <i class="las la-newspaper fs-4"></i>
                        <span>News</span>
                    </a>
                </li>
                <li>
                    <a class="d-flex align-items-center gap-3 ps-4 py-3 <?= $subtitle == 'Insuranced D'?'active':''; ?>" href="<?= base_url('dashboard/news') ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="News">
                        <i class="las la-medkit fs-4"></i>
                        <span>Insured Disease</span>
                    </a>
                </li>
                <li>
                    <a class="d-flex align-items-center gap-3 ps-4 py-3 <?= $subtitle == 'Admins'?'active':''; ?>" href="<?= base_url('dashboard/admins') ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Admins">
                        <i class="las la-users-cog fs-4"></i>
                        <span>Admins</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="sidebar-extramenu">
            <ul class="p-0 m-0">
                <li>
                    <a href="#" class="d-flex align-items-center gap-3 ps-4 py-3" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Profile">
                        <i class="las la-user-circle fs-4" ></i>
                        <span>Profile</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('dashboard/logout'); ?>" class="d-flex align-items-center gap-3 ps-4 py-3" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Logout">
                        <i class="las la-sign-out-alt fs-4"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</aside>
<!-- Sidebar End -->