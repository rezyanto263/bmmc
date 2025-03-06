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
                    <a class="d-flex align-items-center gap-3 ps-4 py-3 <?= $subtitle == 'Dashboard'?'active':''; ?>" href="<?= base_url('company/dashboard') ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Dashboard">
                        <i class="las la-stream fs-4"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a class="d-flex align-items-center gap-3 ps-4 py-3 <?= $subtitle == 'Invoices'?'active':''; ?>" href="<?= base_url('company/invoices') ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Invoices">
                        <i class="las la-file-invoice-dollar fs-4"></i>
                        <span>Invoices</span>
                    </a>
                </li>
                <li>
                    <a class="d-flex align-items-center gap-3 ps-4 py-3 <?= $subtitle == 'Employees'?'active':''; ?>" href="<?= base_url('company/employees') ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Employees">
                        <i class="las la-user-tie fs-4"></i>
                        <span>Employees</span>
                    </a>
                </li>
                <li>
                    <a class="d-flex align-items-center gap-3 ps-4 py-3 <?= $subtitle == 'Families'?'active':''; ?>" href="<?= base_url('company/families') ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Families">
                        <i class="las la-users fs-4"></i>
                        <span>Families</span>
                    </a>
                </li>
                <li>
                    <a class="d-flex align-items-center gap-3 ps-4 py-3 <?= $subtitle == 'Insurances'?'active':''; ?>" href="<?= base_url('company/insurance') ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Insurances">
                        <i class="las la-shield-alt fs-4"></i>
                        <span>Insurances</span>
                    </a>
                </li>
                <li>
                    <a class="d-flex align-items-center gap-3 ps-4 py-3 <?= $subtitle == 'Health Histories'?'active':''; ?>" href="<?= base_url('company/healthhistories') ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Health Histories">
                        <i class="las la-file-medical-alt fs-4"></i>
                        <span>Health Histories</span>
                    </a>
                </li>
                <li>
                    <a class="d-flex align-items-center gap-3 ps-4 py-3 <?= $subtitle == 'Diseases'?'active':''; ?>" href="<?= base_url('company/diseases') ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Diseases">
                        <i class="las la-heartbeat fs-4"></i>
                        <span>Diseases</span>
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