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
                    <a class="d-flex align-items-center gap-3 ps-4 py-3 <?= $subtitle == 'Hospital'?'active':''; ?>" href="<?= base_url('hospital/Hospital') ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Hospital">
                        <i class="las la-hospital fs-4"></i>
                        <span>Hospital</span>
                    </a>
                </li>
                <li>
                    <a class="d-flex align-items-center gap-3 ps-4 py-3 <?= $subtitle == 'History'?'active':''; ?>" href="<?= base_url('hospital/History') ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="History">
                        <i class="las la-book-medical fs-4"></i>
                        <span>History</span>
                    </a>
                </li>
                <li>
                    <a class="d-flex align-items-center gap-3 ps-4 py-3 <?= $subtitle == 'Doctors'?'active':''; ?>" href="<?= base_url('hospital/Doctors') ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Doctors">
                        <i class="las la-stethoscope fs-4"></i>
                        <span>Doctors</span>
                    </a>
                </li>
                <li>
                    <a class="d-flex align-items-center gap-3 ps-4 py-3 <?= $subtitle == 'Queue'?'active':''; ?>" href="<?= base_url('hospital/Queue') ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Queue">
                        <i class="las la-hourglass-half fs-4"></i>
                        <span>Queue</span>
                    </a>
                </li>
                <li>
                    <a class="d-flex align-items-center gap-3 ps-4 py-3 <?= $subtitle == 'Disease'?'active':''; ?>" href="<?= base_url('hospital/Disease') ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Disease">
                        <i class="las la-sad-tear fs-4"></i>
                        <span>Disease</span>
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