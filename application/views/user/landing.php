<!DOCTYPE html>
<html lang="en">
    <style>
        .carousel-inner{
            
        }

    </style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMMC Bali Insurance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="logo.png" alt="BMMC Logo" height="40">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Produk</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Layanan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Program</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Tentang Kami</a></li>
                </ul>
                <button class="btn btn-outline-primary ms-2">Temukan Agen</button>
            </div>
        </div>
    </nav>

    <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active vh-50">
      <img src="<?= base_url('assets/images/landing1.jpg'); ?>" 
           class="d-block w-80 h-80 object-fit-cover img-fluid" 
           alt="Placeholder image for hospital 1">
    </div>
    <div class="carousel-item vh-100">
      <img src="<?= base_url('assets/images/landing1.jpg'); ?>" 
           class="d-block w-80 h-80 object-fit-cover img-fluid" 
           alt="Placeholder image for hospital 2">
    </div>
    <div class="carousel-item vh-100">
      <img src="<?= base_url('assets/images/landing1.jpg'); ?>" 
           class="d-block w-100 h-100 object-fit-cover img-fluid" 
           alt="Placeholder image for hospital 3">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Sebelumnya</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Berikutnya</span>
  </button>
</div>





    <!-- Pilihan Produk -->
    <div class="container py-5">
        <h2 class="text-center mb-4">Pilih kebutuhan Anda</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card">
                    <img src="produk1.jpg" class="card-img-top" alt="Asuransi Individu">
                    <div class="card-body text-center">
                        <h5 class="card-title">Asuransi Individu</h5>
                        <p class="card-text">Pilihan produk asuransi individu untuk Anda dan keluarga.</p>
                        <a href="#" class="btn btn-primary">Lihat Produk</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="produk2.jpg" class="card-img-top" alt="Asuransi Kesehatan">
                    <div class="card-body text-center">
                        <h5 class="card-title">Asuransi Kesehatan</h5>
                        <p class="card-text">Proteksi produk asuransi kesehatan untuk Anda dan keluarga.</p>
                        <a href="#" class="btn btn-primary">Lihat Produk</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="produk3.jpg" class="card-img-top" alt="Asuransi Online">
                    <div class="card-body text-center">
                        <h5 class="card-title">Asuransi Online</h5>
                        <p class="card-text">Beli asuransi online tanpa perlu keluar rumah.</p>
                        <a href="#" class="btn btn-primary">Lihat Produk</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Artikel -->
    <div class="container py-5">
        <h2 class="text-center mb-4">Artikel Explore BMMC Indonesia</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card">
                    <img src="artikel1.jpg" class="card-img-top" alt="Artikel 1">
                    <div class="card-body">
                        <h5 class="card-title">Judul Artikel 1</h5>
                        <p class="card-text">Deskripsi singkat artikel 1.</p>
                        <a href="#" class="btn btn-primary">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="artikel2.jpg" class="card-img-top" alt="Artikel 2">
                    <div class="card-body">
                        <h5 class="card-title">Judul Artikel 2</h5>
                        <p class="card-text">Deskripsi singkat artikel 2.</p>
                        <a href="#" class="btn btn-primary">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="artikel3.jpg" class="card-img-top" alt="Artikel 3">
                    <div class="card-body">
                        <h5 class="card-title">Judul Artikel 3</h5>
                        <p class="card-text">Deskripsi singkat artikel 3.</p>
                        <a href="#" class="btn btn-primary">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-light py-4">
        <div class="container text-center">
            <p class="mb-0">&copy; 2024 BMMC Bali Insurance. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
