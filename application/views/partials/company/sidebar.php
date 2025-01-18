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
                    <a class="d-flex align-items-center gap-3 ps-4 py-3 <?= $subtitle == 'Companies'?'active':''; ?>" href="<?= base_url('company/Dashboard') ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Dashboard">
                        <i class="las la-stream fs-4"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a class="d-flex align-items-center gap-3 ps-4 py-3 <?= $subtitle == 'Employee'?'active':''; ?>" href="<?= base_url('company/Employee') ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Employee">
                        <i class="las la-user-tie fs-4"></i>
                        <span>Employee</span>
                    </a>
                </li>
                <li>
                    <a class="d-flex align-items-center gap-3 ps-4 py-3 <?= $subtitle == 'Insurance'?'active':''; ?>" href="<?= base_url('company/Insurance') ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Insurance">
                        <i class="las la-tag fs-4"></i>
                        <span>Insurance</span>
                    </a>
                </li>
                <li>
                    <a class="d-flex align-items-center gap-3 ps-4 py-3 <?= $subtitle == 'Family'?'active':''; ?>" href="<?= base_url('company/Family/index2') ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Family">
                        <i class="las la-user-injured fs-4"></i>
                        <span>Family</span>
                    </a>
                </li>
                <li>
                    <a class="d-flex align-items-center gap-3 ps-4 py-3 <?= $subtitle == 'Treatment History'?'active':''; ?>" href="<?= base_url('company/TreatmentHistory') ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Treatment History">
                        <i class="las la-file-medical fs-4"></i>
                        <span>Treatment History</span>
                    </a>
                </li>
                <li>
                    <a class="d-flex align-items-center gap-3 ps-4 py-3 <?= $subtitle == 'Monthly Payment'?'active':''; ?>" href="<?= base_url('company/MonthlyPayment') ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Monthly Payment">
                        <i class="las la-file-invoice fs-4"></i>
                        <span>Monthly Payment</span>
                    </a>
                </li>
                <li>
                    <a class="d-flex align-items-center gap-3 ps-4 py-3 <?= $subtitle == 'Hospitals'?'active':''; ?>" href="<?= base_url('company/Hospitals') ?>" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Hospitals">
                        <i class="las la-hospital fs-4"></i>
                        <span>Hospitals</span>
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