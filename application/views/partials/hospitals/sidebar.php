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
                    <a class="d-flex align-items-center gap-3 ps-4 py-3" href="<?= base_url('hospitals/dashboard') ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Dashboard">
                        <i class="las la-stream fs-4"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a class="d-flex align-items-center gap-3 ps-4 py-3" href="<?= base_url('hospitals/History') ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="History">
                    <i class="las la-notes-medical fs-4"></i>
                        <span>History</span>
                    </a>
                </li>
                <li>
                    <a class="d-flex align-items-center gap-3 ps-4 py-3" href="<?= base_url('hospitals/Doctors') ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Doctors">
                    <i class="las la-stethoscope fs-4"></i>
                        <span>Doctors</span>
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