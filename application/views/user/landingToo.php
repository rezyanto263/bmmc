<style>
    main, .sec1{
        background-color: #F6FBFF;
        overflow-x:hidden;
    }

    .sec6{
        background-color: rgba(13, 181, 253, 0.09);
        padding-block:40px;
    }
</style>

<main>
    <!--Section 1 Carousel -->
    <section class="sec1" data-aos="zoom-in-up" data-aos-duration="1000">
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
    <section class="container mt-3 py-5" data-aos="zoom-in-up" data-aos-duration="1000">
        <div class=" d-flex flex-column flex-lg-row justify-content-between align-items-center">
            <div class="information"> 
                <h2 class="fw-bold pb-2 border-3 border-bottom border-primary" style="color:#2b3e9a;">Bali Mitra Medical Center </h2>
                <p>Asuransi BMMC Bali menghadirkan kemudahan, transparansi, dan efisiensi melalui sistem berbasis QR Code. Karyawan cukup memindai kode untuk mengakses informasi asuransi, seperti data hotel asal, cakupan, dan klaim yang telah digunakan. Proses ini mempercepat administrasi, memastikan transparansi data, serta memudahkan pemantauan pengeluaran dengan laporan yang akurat dan terpercaya.</p>
            </div>
            <div class="w-sm-100 w-lg-100 d-flex justify-content-center">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3944.340819910745!2d115.2021294747759!3d-8.659099891388179!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd240a4c54e83d7%3A0x679ce1fdc578914e!2sBali%20Mitra%20Medical%20Center!5e0!3m2!1sen!2sid!4v1733744398879!5m2!1sen!2sid" width="500" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>
    
<!--Section 6 Mitra Kami-->
<section class="sec6" data-aos="zoom-in-up" data-aos-duration="1000">
    <div class="container py-5">
        <h2 class="text-center mb-5 fw-bold">Mitra Bali Mitra Medical Center</h2>
        <div class="splide">
                <div class="splide__track">
                    <ul class="splide__list">
                        <li class="splide__slide d-flex justify-content-center align-items-center">
                            <div class=" p-2 sm-w-100 lg-w-50">
                                <img src="<?php echo base_url('assets/images/hospital-placeholder.jpg')?>" alt="" style="width:100%;">
                            </div>
                        </li>
                        <li class="splide__slide d-flex justify-content-center align-items-center">
                            <div class=" p-2 sm-w-100 lg-w-50">
                                <img src="<?php echo base_url('assets/images/hospital-placeholder.jpg')?>" alt="" style="width:100%;">
                            </div>
                        </li>
    
                        <li class="splide__slide d-flex justify-content-center align-items-center">
                            <div class=" p-2 sm-w-100 lg-w-50">
                                <img src="<?php echo base_url('assets/images/hospital-placeholder.jpg')?>" alt="" style="width:100%;">
                            </div>
                        </li>
                        <li class="splide__slide d-flex justify-content-center align-items-center">
                            <div class=" p-2 sm-w-100 lg-w-50">
                                <img src="<?php echo base_url('assets/images/hospital-placeholder.jpg')?>" alt="" style="width:100%;">
                            </div>
                        </li>
                        <li class="splide__slide d-flex justify-content-center align-items-center">
                            <div class=" p-2 sm-w-100 lg-w-50">
                                <img src="<?php echo base_url('assets/images/hospital-placeholder.jpg')?>" alt="" style="width:100%;">
                            </div>
                        </li>
                        <li class="splide__slide d-flex justify-content-center align-items-center">
                            <div class=" p-2 sm-w-100 lg-w-50">
                                <img src="<?php echo base_url('assets/images/hospital-placeholder.jpg')?>" alt="" style="width:100%;">
                            </div>
                        </li>
                         <li class="splide__slide d-flex justify-content-center align-items-center">
                            <div class=" p-2 sm-w-100 lg-w-50">
                                <img src="<?php echo base_url('assets/images/hospital-placeholder.jpg')?>" alt="" style="width:100%;">
                            </div>
                        </li>
                        <li class="splide__slide d-flex justify-content-center align-items-center">
                            <div class=" p-2 sm-w-100 lg-w-50">
                                <img src="<?php echo base_url('assets/images/hospital-placeholder.jpg')?>" alt="" style="width:100%;">
                            </div>
                        </li>
                        <li class="splide__slide d-flex justify-content-center align-items-center">
                            <div class=" p-2 sm-w-100 lg-w-50">
                                <img src="<?php echo base_url('assets/images/hospital-placeholder.jpg')?>" alt="" style="width:100%;">
                            </div>
                        </li>
                        <li class="splide__slide d-flex justify-content-center align-items-center">
                            <div class=" p-2 sm-w-100 lg-w-50">
                                <img src="<?php echo base_url('assets/images/hospital-placeholder.jpg')?>" alt="" style="width:100%;">
                            </div>
                        </li>
                        <li class="splide__slide d-flex justify-content-center align-items-center">
                            <div class=" p-2 sm-w-100 lg-w-50">
                                <img src="<?php echo base_url('assets/images/hospital-placeholder.jpg')?>" alt="" style="width:100%;">
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
    </div>
</section>

<script>
        document.addEventListener( 'DOMContentLoaded', function () {
        new Splide('.splide', {
            type: 'loop',
            perPage: 4,
            focus: 'center',
            autoplay: true,
            interval: 3000,
            updateOnMove: true,
            pagination: false,
            breakpoints: {
                500: {
                    perPage: 3
                },
                800: {
                    perPage: 3
                }
            }
        }).mount();
        });
</script>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
  AOS.init();
</script>

    <!--Section 5 Artikel-->
    <section class="sec5" data-aos="zoom-in-up" data-aos-duration="1000">
        <div class="container py-5">
            <h2 class="text-center mb-4 fw-bold">Artikel Bali Mitra Medical Center</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card">
                        <img src="<?php echo base_url('assets/images/hospital-placeholder.jpg')?>" class="card-img-top" alt="Artikel 1">
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

            <div class="d-flex justify-content-center my-5">
                <a href="#" class="btn btn-primary mt-3">Lihat Selengkapnya</a>
            </div>
        </div>
    </section>
</main>
