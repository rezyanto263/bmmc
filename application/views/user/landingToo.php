<main>
    <!--Section 1 Carousel -->
    <section class="sec1">
        <div id="carouselExampleInterval" class="carousel slide"        data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleInterval" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleInterval" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleInterval" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
            <div class="carousel-inner">
                <div class="Cimg carousel-item active" data-bs-interval="10000">
                    <img src="<?= base_url('assets/images/landing1.jpg');?>" class="d-block w-100" alt="...">
                </div>
                <div class="Cimg carousel-item" data-bs-interval="2000">
                    <img src="<?= base_url('assets/images/landing1.jpg');?>" class="d-block w-100" alt="...">
                </div>
                <div class="Cimg carousel-item">
                    <img src="<?= base_url('assets/images/landing1.jpg');?>" class="d-block w-100" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    <!--Section 2 Introduction-->
    <section class="sec2">
        <div class="layoutInformasi">
            <div class="information">
                <h2>Bali Mitra Medical Center </h2>
                <p>Asuransi BMMC Bali menghadirkan kemudahan, transparansi, dan efisiensi melalui sistem berbasis QR Code. Karyawan cukup memindai kode untuk mengakses informasi asuransi, seperti data hotel asal, cakupan, dan klaim yang telah digunakan. Proses ini mempercepat administrasi, memastikan transparansi data, serta memudahkan pemantauan pengeluaran dengan laporan yang akurat dan terpercaya.</p>
            </div>
            <div class="graphicInformation">
                <img src="<?= base_url('assets/images/Gcih1YDWEAAddAA.jpg_large2.jpg');?>" alt="" class="giImg">
            </div>
        </div>
    </section>
    
    <!-- Section 6 Mitra Kami -->
    <section class="sec6">
        <div class="container py-5">
            <h2 class="text-center mb-4">Mitra Bali Mitra Medical Center</h2>
            <div class="slider">
                <button class="btn prev" onclick="slide(-1)">&#10094;</button>
                <div class="slides">
                    <!-- Akan ditambahkan kloning elemen dengan JS -->
                    <div class="slide">
                        <img src="<?= base_url('assets/images/hospital-placeholder.jpg'); ?>" alt="Hospital 1">
                    </div>
                    <div class="slide">
                        <img src="<?= base_url('assets/images/hospital-placeholder.jpg'); ?>" alt="Hospital 2">
                    </div>
                    <div class="slide">
                        <img src="<?= base_url('assets/images/hospital-placeholder.jpg'); ?>" alt="Hospital 3">
                    </div>
                    <div class="slide">
                        <img src="<?= base_url('assets/images/hospital-placeholder.jpg'); ?>" alt="Hospital 4">
                    </div>
                </div>
                <button class="btn next" onclick="slide(1)">&#10095;</button>
            </div>
        </div>
    </section>

    <!--Section 5 Artikel-->
    <section class="sec5">
        <div class="container py-5">
            <h2 class="text-center mb-4">Artikel Bali Mitra Medical Center</h2>
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
                <div class="col-md-4">
                    <div class="card">
                        <img src="artikel3.jpg" class="card-img-top" alt="Artikel 3">
                        <div class="card-body">
                            <h5 class="card-title">Judul Artikel 4</h5>
                            <p class="card-text">Deskripsi singkat artikel 4.</p>
                            <a href="#" class="btn btn-primary">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <img src="artikel3.jpg" class="card-img-top" alt="Artikel 3">
                        <div class="card-body">
                            <h5 class="card-title">Judul Artikel 5</h5>
                            <p class="card-text">Deskripsi singkat artikel 5.</p>
                            <a href="#" class="btn btn-primary">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <img src="artikel3.jpg" class="card-img-top" alt="Artikel 3">
                        <div class="card-body">
                            <h5 class="card-title">Judul Artikel 6</h5>
                            <p class="card-text">Deskripsi singkat artikel 6.</p>
                            <a href="#" class="btn btn-primary">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
            </div>
            <a href="#" class="btn btn-primary mt-3">Baca Selengkapnya</a>
        </div>
    </section>
</main>
