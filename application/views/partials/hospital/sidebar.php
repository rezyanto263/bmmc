<!-- Sidebar Start -->
<aside class="<?= isset($_COOKIE['sidebarSize']) ? $_COOKIE['sidebarSize'] : 'maximize'; ?> shadow-sm">
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
                    <a class="d-flex align-items-center gap-3 ps-4 py-3 <?= $subtitle == 'Dashboard'?'active':''; ?>" href="<?= base_url('hospital/dashboard') ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Dashboard">
                        <i class="las la-stream fs-4"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a class="d-flex align-items-center gap-3 ps-4 py-3 <?= $subtitle == 'Queue'?'active':''; ?>" href="<?= base_url('hospital/queues') ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Queues">
                        <i class="las la-hourglass-half fs-4"></i>
                        <span>Queues</span>
                    </a>
                </li>
                <li>
                    <a class="d-flex align-items-center gap-3 ps-4 py-3 <?= $subtitle == 'Health Histories'?'active':''; ?>" href="<?= base_url('hospital/healthhistories') ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Health Histories">
                        <i class="las la-file-medical-alt fs-4"></i>
                        <span>Health Histories</span>
                    </a>
                </li>
                <li>
                    <a class="d-flex align-items-center gap-3 ps-4 py-3 <?= $subtitle == 'Doctors'?'active':''; ?>" href="<?= base_url('hospital/doctors') ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Doctors">
                        <i class="las la-user-nurse fs-4"></i>
                        <span>Doctors</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="sidebar-extramenu">
            <ul class="p-0 m-0">
                <li class="d-none">
                    <a href="<?= base_url('dashboard/helpsupport'); ?>" class="d-flex align-items-center gap-3 ps-4 py-3 text-info" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Help & Support">
                        <i class="las la-question-circle fs-4" ></i>
                        <span>Help & Support</span>
                    </a>
                </li>
                <li style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Logout">
                    <a data-bs-toggle="modal" data-bs-target="#logoutModal" class="d-flex align-items-center gap-3 ps-4 py-3 btn-logout text-danger">
                        <i class="las la-sign-out-alt fs-4"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</aside>
<!-- Sidebar End -->