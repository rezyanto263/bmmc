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
    
<!--Section 6 Mitra Kami-->
<section class="sec6">
    <div class="container py-5">
        <h2 class="text-center mb-4">Mitra Bali Mitra Medical Center</h2>
        <div id="carouselExampleCustom" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner" id="carousel-content">
                <!-- Gambar akan diisi oleh JavaScript -->
            </div>

            <!-- Tombol kontrol -->
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCustom" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCustom" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>

<script>
    // Data gambar
    const imageUrls = [
        "<?= base_url('assets/images/hospital-placeholder.jpg'); ?>", // Gambar 1
        "<?= base_url('assets/images/hospital-placeholder.jpg'); ?>", // Gambar 2
        "<?= base_url('assets/images/hospital-placeholder.jpg'); ?>", // Gambar 3
        "<?= base_url('assets/images/hospital-placeholder.jpg'); ?>", // Gambar 4
        "<?= base_url('assets/images/hospital-placeholder.jpg'); ?>", // Gambar 5
        "<?= base_url('assets/images/hospital-placeholder.jpg'); ?>", // Gambar 6
        "<?= base_url('assets/images/hospital-placeholder.jpg'); ?>", // Gambar 7
        "<?= base_url('assets/images/hospital-placeholder.jpg'); ?>", // Gambar 8
        "<?= base_url('assets/images/hospital-placeholder.jpg'); ?>", // Gambar 9
        "<?= base_url('assets/images/hospital-placeholder.jpg'); ?>"  // Gambar 10
    ];

    const carouselContent = document.getElementById('carousel-content');

    // Menampilkan 4 gambar di awal
    let activeIndex = 0; // Indeks gambar aktif
    const imagesPerSlide = 4;

    function createSlide(startIndex) {
        const slideDiv = document.createElement('div');
        slideDiv.classList.add('carousel-item');
        if (startIndex === 0) slideDiv.classList.add('active');

        const slideContent = document.createElement('div');
        slideContent.classList.add('d-flex', 'justify-content-center', 'gap-3');

        for (let i = 0; i < imagesPerSlide; i++) {
            const img = document.createElement('img');
            const imageIndex = (startIndex + i) % imageUrls.length;
            img.src = imageUrls[imageIndex];
            img.alt = `Logo ${imageIndex + 1}`;
            img.style.maxHeight = '100px';
            img.style.objectFit = 'contain';
            slideContent.appendChild(img);
        }

        slideDiv.appendChild(slideContent);
        return slideDiv;
    }

    // Generate slides
    for (let i = 0; i < imageUrls.length; i++) {
        const slide = createSlide(i);
        carouselContent.appendChild(slide);
    }

    // Carousel event handler
    const carouselElement = document.querySelector('#carouselExampleCustom');
    carouselElement.addEventListener('slide.bs.carousel', (event) => {
        activeIndex = (activeIndex + 1) % imageUrls.length;
        const slides = carouselContent.children;

        // Update each slide to show the correct images
        for (let i = 0; i < slides.length; i++) {
            const startIndex = (activeIndex + i * imagesPerSlide) % imageUrls.length;
            const slideContent = slides[i].querySelector('div');
            slideContent.innerHTML = ''; // Clear existing images
            for (let j = 0; j < imagesPerSlide; j++) {
                const img = document.createElement('img');
                const imageIndex = (startIndex + j) % imageUrls.length;
                img.src = imageUrls[imageIndex];
                img.alt = `Logo ${imageIndex + 1}`;
                img.style.maxHeight = '100px';
                img.style.objectFit = 'contain';
                slideContent.appendChild(img);
            }
        }
    });
</script>





    
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
