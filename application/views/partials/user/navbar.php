<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
    <div class="container">
        <!-- Brand Logo -->
        <a class="navbar-brand me-auto" href="#">
            <img src="<?= base_url('assets/images/logo.png'); ?>" alt="BMMC Logo" height="40">
        </a>

        <!-- Toggler for small screens -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Items -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Centered Menu -->
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link fw-bold" href="#">Produk</a></li>
                <li class="nav-item"><a class="nav-link fw-bold" href="#">Mitra</a></li>
                <li class="nav-item"><a class="nav-link fw-bold" href="#">Berita Terkini</a></li>
                <li class="nav-item"><a class="nav-link fw-bold" href="#">Tentang Kami</a></li>
            </ul>
            <!-- Buttons -->
            <div class="d-flex mt-2 mt-lg-0">
                <button class="btn btn-outline-primary me-2">Login</button>
                <button class="btn btn-outline-primary visually-hidden">Profile</button>
            </div>
        </div>
    </div>
</nav>
