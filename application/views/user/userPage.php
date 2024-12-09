<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .profile-header {
            margin-top: -30px;
            padding-top: 15px;
            background-color: #f8f9fa;
            border-radius: 15px 15px 0 0;
        }
        .profile-header img {
            border: 3px solid #fff;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #dee2e6;
        }
        .table-title {
            font-weight: bold;
            font-size: 1.2em;
        }
    </style>
</head>
<body>
    <div class="container py-3">
        <!-- Navbar Mobile Toggle -->
        <nav class="navbar navbar-expand-lg navbar-light d-lg-none"></nav>

        <!-- QR Code and User Profile -->
        <div class="wrap text-center">
            <div class="profile-header p-3">
                <img src="<?= base_url('assets/images/logo.png') ?>" class="rounded mx-auto d-block mb-3" alt="QR Code" style="width: 100px;">
            </div>
            
            <!-- User Profile Info -->
            <div class="d-flex align-items-center justify-content-center mb-2">
                <img src="<?= base_url('assets/images/logo.png') ?>" class="rounded-circle mr-2" alt="User Image" style="width: 50px; height: 50px;">
                <div>
                    <h5 class="mb-0"><?= isset($policyholderDatas['policyholderName']) ? $policyholderDatas['policyholderName'] : $policyholderDatas['familyName'] ?></h5>
                    <small class="text-muted"><?= isset($policyholderDatas['policyholderEmail']) ? $policyholderDatas['policyholderEmail'] : $policyholderDatas['familyEmail'] ?></small>
                </div>
                <a href="#" class="ml-2" data-toggle="modal" data-target="#editProfileModal">
                    <i class="fas fa-edit"></i>
                </a>
            </div>
            <!-- Modal for Editing Profile -->
            <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-md">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editProfileModalLabel">Edit Profil User</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="editProfileForm" method="POST" action="<?= !empty($policyholderDatas['familyNIN']) ? base_url('user/editFamily') : base_url('user/editEmployee') ?>">
                                            <!-- Form Fields with Icons -->
                                            <?php if (empty($policyholderDatas['familyNIN'])): ?>
                                            <div class="form-group mb-3">
                                                <div class="input-group">
                                                    <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="NIN">
                                                        <i class="las la-id-card fs-4"></i>
                                                    </span>
                                                    <input class="form-control" type="text" placeholder="National ID Number" name="policyholderNIN" id="editNIN" value="<?= set_value('policyholderNIN', $policyholderDatas['policyholderNIN']) ?>" required readonly />
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                            <?php if (!empty($policyholderDatas['familyNIN'])): ?>
                                                <div class="form-group mb-3">
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="NIN">
                                                            <i class="las la-id-card fs-4"></i>
                                                        </span>
                                                        <input class="form-control" type="text" placeholder="National ID Number" name="familyNIN" id="editNIN" value="<?= set_value('familyNIN', $policyholderDatas['familyNIN']) ?>" required readonly />
                                                    </div>
                                                </div
                                            <?php endif; ?>>
                                            <div class="form-group mb-3">
                                                <div class="input-group">
                                                    <span class="input-group-text bg-transparent"><i class="las la-user fs-4"></i></span>
                                                    <input type="text" class="form-control" id="fullName" name="policyholderName" value="<?= isset($policyholderDatas['policyholderName']) && $policyholderDatas['policyholderName'] ? $policyholderDatas['policyholderName'] : (isset($policyholderDatas['familyName']) ? $policyholderDatas['familyName'] : '') ?>" placeholder="Nama Lengkap">

                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <div class="input-group">
                                                    <span class="input-group-text bg-transparent"><i class="las la-envelope fs-4"></i></span>
                                                    <input type="email" class="form-control" id="email" name="policyholderEmail" value="<?= isset($policyholderDatas['policyholderEmail']) && $policyholderDatas['policyholderEmail'] ? $policyholderDatas['policyholderEmail'] : (isset($policyholderDatas['familyEmail']) ? $policyholderDatas['familyEmail'] : '') ?>">
                                                </div>
                                            </div>

                                            <!-- Password -->
                                            <div class="form-group mb-3">
                                                <div class="input-group">
                                                    <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Admin New Password">
                                                        <i class="las la-key fs-4"></i>
                                                    </span>
                                                    <input type="password" class="form-control" id="adminPassword" placeholder="Password" name="newPassword">
                                                    <span type="button" class="input-group-text bg-transparent" id="btnShowPassword" data-bs-toggle="tooltip" data-bs-title="Show/Hide Password">
                                                        <i class="las la-eye-slash fs-4"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <div class="input-group">
                                                    <span class="input-group-text bg-transparent" data-bs-toggle="tooltip" data-bs-title="Admin Password Confirmation">
                                                        <i class="las la-key fs-4"></i>
                                                    </span>
                                                    <input type="password" class="form-control" placeholder="Password Confirmation" name="confirmPassword">
                                                    <span type="button" class="input-group-text bg-transparent" id="btnShowPassword" data-bs-toggle="tooltip" data-bs-title="Show/Hide Password">
                                                        <i class="las la-eye-slash fs-4"></i>
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- Other Fields -->
                                            <div class="form-group mb-3">
                                                <div class="input-group">
                                                    <span class="input-group-text bg-transparent"><i class="las la-calendar fs-4"></i></span>
                                                    <input type="date" class="form-control" id="birthDate" placeholder="Tanggal Lahir" name="policyholderBirth" value="<?= isset($policyholderDatas['policyholderBirth']) && $policyholderDatas['policyholderBirth'] ? $policyholderDatas['policyholderBirth'] : (isset($policyholderDatas['familyBirth']) ? $policyholderDatas['familyBirth'] : '') ?>">
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <?php 
                                                    $selectedGender = isset($policyholderDatas['policyholderGender']) 
                                                        ? $policyholderDatas['policyholderGender'] 
                                                        : (isset($policyholderDatas['familyGender']) 
                                                            ? $policyholderDatas['familyGender'] 
                                                            : '');
                                                ?>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="policyholderGender" id="male" value="male" <?= ($selectedGender == 'male') ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="male">Male</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="policyholderGender" id="female" value="female" <?= ($selectedGender == 'female') ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="female">Female</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-text bg-transparent"><i class="las la-map-marker fs-4"></i></span>
                                                    <textarea class="form-control" id="address" rows="2" placeholder="Alamat" name="policyholderAddress"><?= isset($policyholderDatas['policyholderAddress']) && $policyholderDatas['policyholderAddress'] ? $policyholderDatas['policyholderAddress'] : (isset($policyholderDatas['familyAddress']) ? $policyholderDatas['familyAddress'] : '') ?></textarea>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">CANCEL</button>
                                        <button type="submit" class="btn btn-primary">SAVE</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


 <!-- Family Members List -->
 <?php if (empty($policyholderDatas['familyNIN'])): ?>
<h6 class="text-left mt-4">Daftar Anggota Keluarga</h6>
<div class="accordion mb-3" id="familyAccordion">
    <?php foreach ($familyMembers as $index => $member): ?>
    <!-- Family Member Item: <?= $member['familyName'] ?> -->
    <div class="card">
        <div class="card-header p-2 d-flex align-items-center justify-content-between">
            <h2 class="mb-0">
                <button class="btn btn-link text-dark text-left" type="button" data-toggle="collapse" data-target="#collapse<?= $index ?>" aria-expanded="false" aria-controls="collapse<?= $index ?>">
                    <?= $member['familyName'] ?>
                </button>
            </h2>
            <button class="btn btn-sm btn-outline-primary" type="button" data-toggle="collapse" data-target="#collapse<?= $index ?>" aria-expanded="false" aria-controls="collapse<?= $index ?>">
                <i class="fas fa-chevron-down"></i>
            </button>
        </div>
        <div id="collapse<?= $index ?>" class="collapse" data-parent="#familyAccordion">
            <div class="card-body">
                <p><strong>Nama:</strong> <?= $member['familyName'] ?></p>
                <p><strong>Alamat:</strong> <?= $member['familyAddress'] ?></p>
                <p><strong>Tanggal Lahir:</strong> <?= $member['familyBirth'] ?></p>
                <p><strong>Status:</strong> <?= $member['familyStatus'] ?></p>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>



                <!-- Tabel Total Tanggungan dan Total Tanggungan Bulan Ini -->
                <div class="row mt-4">
            <!-- Tabel Total Tanggungan -->
            <div class="col-md-6">
                <h6 class="text-left table-title">Total Tanggungan</h6>
                <table class="table table-bordered mb-4">
                    <thead>
                        <tr>
                            <th>Total Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">Rp 50.000.000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Tabel Total Tanggungan Bulan Ini -->
            <div class="col-md-6">
                <h6 class="text-left table-title">Total Tanggungan Bulan Ini</h6>
                <table class="table table-bordered mb-4">
                    <thead>
                        <tr>
                            <th>Total Bulan Ini</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">Rp 18.000.000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


        <!-- Tabs Navigation for Family History -->
<?php if (empty($policyholderDatas['familyNIN'])): ?>
<h6 class="text-left mt-4 table-title">Riwayat</h6>
<ul class="nav nav-tabs" id="familyHistoryTabs" role="tablist">
    <?php foreach ($familyMembers as $index => $member): ?>
    <li class="nav-item">
        <a class="nav-link <?= ($index == 0) ? 'active' : '' ?>" id="family-tab-<?= $index ?>" data-toggle="tab" href="#family-<?= $index ?>" role="tab" aria-controls="family-<?= $index ?>" aria-selected="<?= ($index == 0) ? 'true' : 'false' ?>">
            <?= $member['familyName'] ?>
        </a>
    </li>
    <?php endforeach; ?>
</ul>
<?php endif; ?>

<!-- Tabs Content for Family History -->
 <?php if (empty($policyholderDatas['familyNIN'])): ?>
<div class="tab-content mt-3" id="familyHistoryTabsContent">
    <?php foreach ($familyMembers as $index => $member): ?>
    <div class="tab-pane fade <?= ($index == 0) ? 'show active' : '' ?>" id="family-<?= $index ?>" role="tabpanel" aria-labelledby="family-tab-<?= $index ?>">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Jenis Tindakan</th>
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Dokter</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Sample data for the family member history
                // This assumes you have a $member['history'] that holds the medical history records
                foreach ($familyMembers as $index => $member): ?>
                    <tr>
                        <td><?= ($index + 1) ?></td>
                        <td><?= $member['familyName']?></td>
                        <td><?= $member['familyName']?></td>
                        <td><?= $member['familyName']?></td>
                        <td><?= $member['familyName']?></td>
                        <td><?= $member['familyName']?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<?php if (!empty($policyholderDatas['familyNIN'])): ?>
<h6 class="text-left mt-4 table-title">Riwayat</h6>
<ul class="nav nav-tabs" id="familyHistoryTabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="family-tab-0" data-toggle="tab" href="#family-0" role="tab" aria-controls="family-0" aria-selected="true">
            <?= $policyholderDatas['familyName'] ?>
        </a>
    </li>
</ul>
<?php endif; ?>

<!-- Tabs Content for Family History -->
<?php if (!empty($policyholderDatas['familyNIN'])): ?>
<div class="tab-content mt-3" id="familyHistoryTabsContent">
    <div class="tab-pane fade show active" id="family-0" role="tabpanel" aria-labelledby="family-tab-0">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Jenis Tindakan</th>
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Dokter</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Sample Tindakan</td>
                    <td><?= $policyholderDatas['familyName'] ?></td>
                    <td>2024-12-06</td>
                    <td>Dr. Sample</td>
                    <td>Completed</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>




    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
