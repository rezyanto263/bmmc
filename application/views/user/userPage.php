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
                    <h5 class="mb-0">Cicak Muslimah</h5>
                    <small class="text-muted">realnamurag@gmail.com</small>
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
                <form id="editProfileForm" enctype="multipart/form-data">
                    <!-- Upload Photo Section -->
                    <div class="d-flex flex-column justify-content-center align-items-center mb-3">
                        <div class="imgContainer">
                            <img src="<?= base_url('assets/images/default-profile.png'); ?>" alt="Profile Photo" id="imgPreview" class="img-thumbnail">
                        </div>
                        <label class="btn-warning mt-3 text-center w-50" for="uploadProfilePhoto">UPLOAD PHOTO</label>
                        <input type="file" accept="image/jpg, image/jpeg, image/png" name="profilePhoto" id="uploadProfilePhoto" hidden>
                    </div>
                    <!-- Form Fields with Icons -->
                    <div class="form-group mb-3">
                        <div class="input-group">
                            <span class="input-group-text bg-transparent"><i class="las la-user fs-4"></i></span>
                            <input type="text" class="form-control" id="fullName" value="Cicak Muslimah" placeholder="Nama Lengkap">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                      
                        <div class="input-group">
                            <span class="input-group-text bg-transparent"><i class="las la-envelope fs-4"></i></span>
                            <input type="email" class="form-control" id="email" value="realnamurag@gmail.com" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        
                        <div class="input-group">
                            <span class="input-group-text bg-transparent"><i class="las la-phone fs-4"></i></span>
                            <input type="text" class="form-control" id="phone" placeholder="No Telepon">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                      
                        <div class="input-group">
                            <span class="input-group-text bg-transparent"><i class="las la-calendar fs-4"></i></span>
                            <input type="date" class="form-control" id="birthDate" placeholder="Tanggal Lahir">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                     
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="male" value="male">
                            <label class="form-check-label" for="male">Laki-laki</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                            <label class="form-check-label" for="female">Perempuan</label>
                        </div>
                    </div>
                    <div class="form-group">
                      
                        <div class="input-group">
                            <span class="input-group-text bg-transparent"><i class="las la-map-marker fs-4"></i></span>
                            <textarea class="form-control" id="address" rows="2" placeholder="Alamat"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">CANCEL</button>
                <button type="submit" class="btn btn-primary" form="editProfileForm">SAVE</button>
            </div>
        </div>
    </div>
</div>


          <!-- Family Members List -->
<h6 class="text-left mt-4">Daftar Anggota Keluarga</h6>
<div class="accordion mb-3" id="familyAccordion">
    <!-- Family Member Item: Jawir Pedia -->
    <div class="card">
        <div class="card-header p-2 d-flex align-items-center justify-content-between">
            <h2 class="mb-0">
                <button class="btn btn-link text-dark text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                    Jawir Pedia
                </button>
            </h2>
            <button class="btn btn-sm btn-outline-primary" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                <i class="fas fa-chevron-down"></i>
            </button>
        </div>
        <div id="collapseOne" class="collapse" data-parent="#familyAccordion">
            <div class="card-body">
                <p><strong>Nama:</strong> Jawir Pedia</p>
                <p><strong>Alamat:</strong> Jalan Mawar No. 123, Denpasar</p>
                <p><strong>Tanggal Lahir:</strong> 01 Januari 1980</p>
            </div>
        </div>
    </div>

            <!-- Family Member Item: Sari Pedia -->
            <div class="card">
                <div class="card-header p-2 d-flex align-items-center justify-content-between">
                    <h2 class="mb-0">
                        <button class="btn btn-link text-dark text-left" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Sari Pedia
                        </button>
                    </h2>
                    <button class="btn btn-sm btn-outline-primary" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </div>
                <div id="collapseTwo" class="collapse" data-parent="#familyAccordion">
                    <div class="card-body">
                        <p><strong>Nama:</strong> Sari Pedia</p>
                        <p><strong>Alamat:</strong> Jalan Melati No. 45, Denpasar</p>
                        <p><strong>Tanggal Lahir:</strong> 15 Mei 1985</p>
                    </div>
                </div>
            </div>

            <!-- Family Member Item: Budi Pedia -->
            <div class="card">
                <div class="card-header p-2 d-flex align-items-center justify-content-between">
                    <h2 class="mb-0">
                        <button class="btn btn-link text-dark text-left" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Budi Pedia
                        </button>
                    </h2>
                    <button class="btn btn-sm btn-outline-primary" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </div>
                <div id="collapseThree" class="collapse" data-parent="#familyAccordion">
                    <div class="card-body">
                        <p><strong>Nama:</strong> Budi Pedia</p>
                        <p><strong>Alamat:</strong> Jalan Cempaka No. 67, Denpasar</p>
                        <p><strong>Tanggal Lahir:</strong> 10 Oktober 1990</p>
                    </div>
                </div>
            </div>
        </div>



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
        <h6 class="text-left mt-4 table-title">Riwayat</h6>
        <ul class="nav nav-tabs" id="familyHistoryTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="ayah-tab" data-toggle="tab" href="#ayah" role="tab" aria-controls="ayah" aria-selected="true">
                    Ayah
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="ibu-tab" data-toggle="tab" href="#ibu" role="tab" aria-controls="ibu" aria-selected="false">
                    Ibu
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="anak1-tab" data-toggle="tab" href="#anak1" role="tab" aria-controls="anak1" aria-selected="false">
                    Anak 1
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="anak2-tab" data-toggle="tab" href="#anak2" role="tab" aria-controls="anak2" aria-selected="false">
                    Anak 2
                </a>
            </li>
        </ul>

        <!-- Tabs Content for Family History -->
        <div class="tab-content mt-3" id="familyHistoryTabsContent">
            <!-- Ayah -->
            <div class="tab-pane fade show active" id="ayah" role="tabpanel" aria-labelledby="ayah-tab">
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
                            <td>Ayah</td>
                            <td>Pemeriksaan Rutin</td>
                            <td>01/11/2024</td>
                            <td>Dr. Andi</td>
                            <td>Selesai</td>
                        </tr>
                        <!-- Repeat for additional records -->
                    </tbody>
                </table>
            </div>

            <!-- Ibu -->
            <div class="tab-pane fade" id="ibu" role="tabpanel" aria-labelledby="ibu-tab">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Jenis Tindakan</th>
                            <th>Tanggal</th>
                            <th>Dokter</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Ibu</td>
                            <td>Reimbursement</td>
                            <td>02/11/2024</td>
                            <td>Rp 1.500.000</td>
                            <td>Disetujui</td>
                        </tr>
                        <!-- Repeat for additional records -->
                    </tbody>
                </table>
            </div>

            <!-- Anak 1 -->
            <div class="tab-pane fade" id="anak1" role="tabpanel" aria-labelledby="anak1-tab">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Jenis Tindakan</th>
                            <th>Tanggal</th>
                            <th>Dokter</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>anak1</td>
                            <td>Imunisasi</td>
                            <td>05/11/2024</td>
                            <td>Dr. Budi</td>
                            <td>Selesai</td>
                        </tr>
                        <!-- Repeat for additional records -->
                    </tbody>
                </table>
            </div>

            <!-- Anak 2 -->
            <div class="tab-pane fade" id="anak2" role="tabpanel" aria-labelledby="anak2-tab">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Jenis Tindakan</th>
                            <th>Tanggal</th>
                            <th>Dokter</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>anak2</td>
                            <td>Pemeriksaan Gigi</td>
                            <td>10/11/2024</td>
                            <td>Dr. Clara</td>
                            <td>Selesai</td>
                        </tr>
                        <!-- Repeat for additional records -->
                    </tbody>
                </table>
            </div>
        </div>



    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
