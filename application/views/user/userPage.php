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
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editProfileModalLabel">Edit Profil User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="form-group">
                                    <label for="fullName">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="fullName" value="Cicak Muslimah">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" value="realnamurag@gmail.com">
                                </div>
                                <div class="form-group">
                                    <label for="phone">No Telepon</label>
                                    <input type="text" class="form-control" id="phone">
                                </div>
                                <div class="form-group">
                                    <label for="birthDate">Tanggal Lahir</label>
                                    <input type="date" class="form-control" id="birthDate">
                                </div>
                                <div class="form-group">
                                    <label>Jenis Kelamin</label><br>
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
                                    <label for="address">Alamat</label>
                                    <textarea class="form-control" id="address" rows="2"></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Family Members List -->
            <h6 class="text-left mt-4">Daftar Anggota Keluarga</h6>
            <div class="accordion mb-3" id="familyAccordion">
                <!-- Family Member Item -->
                <div class="card">
                    <div class="card-header p-2 d-flex align-items-center justify-content-between">
                        <h2 class="mb-0">
                            <button class="btn btn-link text-dark" type="button" data-toggle="collapse" data-target="#collapseOne">
                                Jawir Pedia
                            </button>
                        </h2>
                        <button class="btn btn-sm btn-outline-primary"><i class="fas fa-chevron-down"></i></button>
                    </div>
                    <div id="collapseOne" class="collapse" data-parent="#familyAccordion">
                        <div class="card-body">
                            Detail anggota keluarga.
                        </div>
                    </div>
                </div>
                <!-- Repeat for additional family members -->
            </div>

            <!-- Payout Amount Table -->
            <h6 class="text-left mt-4 table-title">Jumlah Tanggungan yang Sudah Dicairkan</h6>
            <table class="table table-bordered mb-4">
                <thead>
                    <tr><th>Total Jumlah</th></tr>
                </thead>
                <tbody>
                    <tr><td class="text-center">Rp 18.000.000</td></tr>
                </tbody>
            </table>

            <!-- History Table -->
            <h6 class="text-left mt-4 table-title">Riwayat</h6>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Jenis Tindakan</th>
                        <th>Tanggal</th>
                        <th>Dokter</th>
                        <th>Status Klaim</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Pemeriksaan Rutin</td>
                        <td>01/11/2024</td>
                        <td>Dr. Andi</td>
                        <td>Disetujui</td>
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
