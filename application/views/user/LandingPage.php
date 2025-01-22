<body class="position-relative">
  <!-- hero section -->
  <section class="position-relative overflow-x-hidden" data-aos="fade-down" data-aos-duration="1000">
    <!-- gambar -->
    <div class="w-100 d-flex justify-content-center align-items-center overflow-hidden position-relative"
      style="height: 750px">
      <img src="<?= base_url('assets/images/test1.jpg'); ?>" class="img-fluid h-100 w-100 object-fit-cover"
        alt="Gambar Keluarga" />
      <div class="position-absolute top-0 start-0 w-100 h-100 bg-black opacity-50"></div>
    </div>

    <!-- kotak -->
    <div class="position-absolute top-50 start-50 translate-middle bg-biru opacity-75 shadow kotak-hero"></div>

    <!-- dalam konten -->
    <div class="position-absolute top-50 start-50 translate-middle z-1 w-75">
      <h2 class="fw-bold text-center mb-2 m-auto text-white pb-2 title-heading">
        Bali Mitra Medical Center
      </h2>
      <!-- slogan -->
      <h5 class="mt-3 fst-italic text-center text-white slogan">
        Medical Center In Bali.
      </h5>
    </div>
  </section>

  <!-- about -->
  <section
    class="container overflow-x-hidden d-flex flex-column flex-md-row justify-content-between align-items-center mt-5">
    <!-- bagian kiri -->
    <div class="kiri-about" data-aos="fade-up" data-aos-duration="1000">
      <h2 class="title-about fw-bold mb-3">Bali Mitra Medical Center</h2>
      <p class="">
        Asuransi BMMC Bali menghadirkan kemudahan, transparansi, dan efisiensi
        melalui sistem berbasis QR Code. Karyawan cukup memindai kode untuk
        mengakses informasi asuransi, seperti data hotel asal, cakupan, dan
        klaim yang telah digunakan. Proses ini mempercepat administrasi,
        memastikan transparansi data, serta memudahkan pemantauan pengeluaran
        dengan laporan yang akurat dan terpercaya.
      </p>
    </div>

    <!-- bagian kanan -->
    <div class="kanan-about d-flex justify-content-center" data-aos="zoom-in" data-aos-duration="1000">
      <iframe class="rounded-3" width="100%" height="100%"
        src="https://www.youtube.com/embed/9_rDaAdkMs8?si=cBa1QZZLYhRe8rsQ" title="YouTube video player" frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
    </div>
  </section>

  <!-- mitra -->
  <section class="mitra-sec overflow-x-hidden" data-aos="fade-up" data-aos-duration="1000">
    <div class="container">
      <!-- judul -->
      <h2 class="fw-bold text-white text-center title-mitra m-auto pt-3 pb-2">
        Mitra Bali Mitra Medical Center
      </h2>

      <!-- slider normal -->
      <section class="splide normal mt-5 mb-5" aria-label="Splide Normal Slider">
        <div class="splide__track position-relative">
            <div class="splide__list partner-normal">
            </div>
        </div>
      </section>

      <!-- Slider Reverse -->
      <section class="splide reverse mt-5 mb-5" aria-label ="Splide Reverse Slider">
        <div class="splide__track position-relative">
            <div class="splide__list partner-reverse">
            </div>
        </div>
      </section>
    </div>
  </section>

  <!-- berita -->
  <section class="bg-white berita-sec" id="berita" data-aos="fade-up" data-aos-duration="1000">
    <div class="container">
      <h2 class="fw-bold title-berita">Berita Terkini</h2>

      <!-- card berita -->
      <div class="row row-cols-1 row-cols-md-3 g-4 mt-3">
        <!-- col 1 -->
        <div class="col" data-aos="zoom-in" data-aos-duration="500">
          <div class="card h-100">
            <div class="h-75">
              <img src="<?= base_url('assets/images/95c.png'); ?>"
                class="card-img-top img-uniform h-100 object-fit-cover" alt="..." />
            </div>
            <div class="card-body">
              <h5 class="card-title fw-semibold judul-card">
                Lorem ipsum dolor sit amet.
              </h5>
              <!-- tambahan -->
              <div class="d-flex align-items-center flex-wrap my-1">
                <!-- bagian waktu -->
                <div class="d-flex align-items-center bg-danger rounded-pill text-white" style="height: 30px">
                  <i class="fa-solid fa-clock-rotate-left mx-2" style="font-size: 12px">
                    <span class="fw-normal ms-1">2 Bulan yang lalu</span>
                  </i>
                </div>

                <!-- bagian jenis -->
                <div class="mx-lg-1 d-flex align-items-center bg-success rounded-pill text-white mx-1"
                  style="height: 30px">
                  <i class="fa-solid fa-circle-exclamation mx-2" style="font-size: 12px">
                    <span class="fw-normal ms-1">Berita</span>
                  </i>
                </div>

                <!-- bagian kategori -->
                <div class="mx-lg-1 d-flex align-items-center bg-primary rounded-pill text-white" style="height: 30px">
                  <i class="fa-solid fa-copyright mx-2" style="font-size: 12px">
                    <span class="fw-normal ms-1">Kerjasama</span>
                  </i>
                </div>
              </div>
              <p class="card-text">
                This is a wider card with supporting text below as a natural
                lead-in to additional content. This content is a little bit
                longer.
              </p>
            </div>
            <div class="ms-3 mb-3 button-berita">
              <a class="" href="<?= base_url('user/DetailBerita'); ?>" role="button">Baca Sekarang </a>
              <i class="fa-solid fa-arrow-right ms-2"></i>
            </div>
          </div>
        </div>

        <!-- col 2 -->
        <div class="col" data-aos="zoom-in" data-aos-duration="500">
          <div class="card h-100">
            <div class="h-75">
              <img src="<?= base_url('assets/images/mitra.jpg'); ?>"
                class="card-img-top img-uniform h-100 object-fit-cover" alt="..." />
            </div>
            <div class="card-body">
              <h5 class="card-title fw-semibold judul-card">
                Lorem ipsum dolor sit amet.
              </h5>
              <!-- tambahan -->
              <div class="d-flex align-items-center flex-wrap my-1">
                <!-- bagian waktu -->
                <div class="d-flex align-items-center bg-danger rounded-pill text-white" style="height: 30px">
                  <i class="fa-solid fa-clock-rotate-left mx-2" style="font-size: 12px">
                    <span class="fw-normal ms-1">2 Bulan yang lalu</span>
                  </i>
                </div>

                <!-- bagian jenis -->
                <div class="mx-lg-1 d-flex align-items-center bg-success rounded-pill text-white mx-1"
                  style="height: 30px">
                  <i class="fa-solid fa-circle-exclamation mx-2" style="font-size: 12px">
                    <span class="fw-normal ms-1">Berita</span>
                  </i>
                </div>

                <!-- bagian kategori -->
                <div class="mx-lg-1 d-flex align-items-center bg-primary rounded-pill text-white" style="height: 30px">
                  <i class="fa-solid fa-copyright mx-2" style="font-size: 12px">
                    <span class="fw-normal ms-1">Kerjasama</span>
                  </i>
                </div>
              </div>
              <p class="card-text">
                This is a wider card with supporting text below as a natural
                lead-in to additional content. This content is a little bit
                longer.
              </p>
            </div>
            <div class="ms-3 mb-3 button-berita">
              <a class="" href="<?= base_url('user/DetailBerita'); ?>" role="button">Baca Sekarang </a>
              <i class="fa-solid fa-arrow-right ms-2"></i>
            </div>
          </div>
        </div>

        <!-- col 3 -->
        <div class="col" data-aos="zoom-in" data-aos-duration="500">
          <div class="card h-100">
            <div class="h-75">
              <img src="<?= base_url('assets/images/test1.jpg'); ?>"
                class="card-img-top img-uniform h-100 object-fit-cover" alt="..." />
            </div>
            <div class="card-body">
              <h5 class="card-title fw-semibold judul-card">
                Lorem ipsum dolor sit amet.
              </h5>
              <!-- tambahan -->
              <div class="d-flex align-items-center flex-wrap my-1">
                <!-- bagian waktu -->
                <div class="d-flex align-items-center bg-danger rounded-pill text-white" style="height: 30px">
                  <i class="fa-solid fa-clock-rotate-left mx-2" style="font-size: 12px">
                    <span class="fw-normal ms-1">2 Bulan yang lalu</span>
                  </i>
                </div>

                <!-- bagian jenis -->
                <div class="mx-lg-1 d-flex align-items-center bg-success rounded-pill text-white mx-1"
                  style="height: 30px">
                  <i class="fa-solid fa-circle-exclamation mx-2" style="font-size: 12px">
                    <span class="fw-normal ms-1">Berita</span>
                  </i>
                </div>

                <!-- bagian kategori -->
                <div class="mx-lg-1 d-flex align-items-center bg-primary rounded-pill text-white" style="height: 30px">
                  <i class="fa-solid fa-copyright mx-2" style="font-size: 12px">
                    <span class="fw-normal ms-1">Kerjasama</span>
                  </i>
                </div>
              </div>
              <p class="card-text">
                This is a wider card with supporting text below as a natural
                lead-in to additional content. This content is a little bit
                longer.
              </p>
            </div>
            <div class="ms-3 mb-3 button-berita">
              <a class="" href="<?= base_url('user/DetailBerita'); ?>" role="button">Baca Sekarang </a>
              <i class="fa-solid fa-arrow-right ms-2"></i>
            </div>
          </div>
        </div>

        <!-- button all berita -->
        <div class="mb-3 mt-4 button-berita-all shadow">
          <a class="" href="./berita_list.html" role="button">Baca Semua Sekarang
          </a>
          <i class="fa-solid fa-arrow-right ms-2"></i>
        </div>
      </div>
  </section>

  <!-- faq -->
<!-- FAQ -->
<section id="faqSection" class="container" data-aos="fade-up" data-aos-duration="1000">
    <h2 class="fw-bold title-faq mt-5 mb-4">FAQ</h2>
    <div class="accordion mb-5" id="accordionExample">
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingOne">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
            aria-expanded="true" aria-controls="collapseOne">
            1. Apa itu Sistem Informasi Asuransi BMMC?
          </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
          data-bs-parent="#accordionExample">
          <div class="accordion-body">
            <strong>1. Apa itu Sistem Informasi Asuransi BMMC?</strong> Sistem Informasi Asuransi BMMC adalah platform berbasis website yang dirancang untuk mempermudah pengelolaan polis asuransi, klaim, 
            dan informasi pembayaran bagi pasien yang menggunakan layanan asuransi kesehatan di Bali Mitra Medical Center.
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header" id="headingTwo">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
            2. Bagaimana cara mendaftar dan mengakses sistem ini?
          </button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
          data-bs-parent="#accordionExample">
          <div class="accordion-body">
            <strong>2. Bagaimana cara mendaftar dan mengakses sistem ini?</strong> Anda dapat mendaftar sebagai 
            pengguna dengan menghubungi pihak administrasi BMMC untuk mendapatkan akun. Setelah akun dibuat, Anda dapat masuk ke sistem melalui halaman login dengan menggunakan email dan kata sandi yang terdaftar.
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header" id="headingThree">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
            3. Apa saja fitur yang tersedia dalam sistem ini?
          </button>
        </h2>
        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
          data-bs-parent="#accordionExample">
          <div class="accordion-body">
            <strong>3. Apa saja fitur yang tersedia dalam sistem ini?</strong> Sistem ini menyediakan berbagai fitur, termasuk:
            <li> Pendaftaran dan manajemen data asuransi </li>
            <li> Informasi polis dan riwayat pembayaran</li>
            <li>Pengajuan dan pelacakan status klaim asuransi</li>
            <li> Akses mudah ke informasi rumah sakit mitra  </li>
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header" id="headingFour">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
            4. Bagaimana cara mengajukan klaim asuransi?
          </button>
        </h2>
        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
          data-bs-parent="#accordionExample">
          <div class="accordion-body">
            <strong>4. Bagaimana cara mengajukan klaim asuransi?</strong> Anda dapat mengajukan klaim melalui sistem dengan mengunggah dokumen yang diperlukan dan mengisi formulir klaim. 
            Status klaim dapat dipantau secara real-time melalui akun Anda.
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header" id="headingFive">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
            5. Apakah informasi saya aman di dalam sistem ini?
          </button>
        </h2>
        <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
          data-bs-parent="#accordionExample">
          <div class="accordion-body">
            <strong>5. Apakah informasi saya aman di dalam sistem ini?</strong> 
            Ya, sistem ini menggunakan teknologi keamanan enkripsi dan sistem autentikasi untuk melindungi data pengguna. Kami memastikan bahwa informasi 
            pribadi dan data asuransi Anda tetap aman dan hanya dapat diakses oleh pihak yang berwenang.
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header" id="headingSix">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
            6. Apa yang harus saya lakukan jika mengalami kendala saat menggunakan sistem?
          </button>
        </h2>
        <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix"
          data-bs-parent="#accordionExample">
          <div class="accordion-body">
            <strong>6. Apa yang harus saya lakukan jika mengalami kendala saat menggunakan sistem?</strong> Jika Anda mengalami kendala, Anda dapat menghubungi 
            tim dukungan teknis BMMC melalui fitur bantuan di dalam sistem atau mengirimkan email ke support@bmmc.com untuk mendapatkan bantuan lebih lanjut.
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header" id="headingSeven">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
            7. Apakah saya masih bisa mengakses layanan secara manual jika tidak menggunakan sistem ini?
          </button>
        </h2>
        <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven"
          data-bs-parent="#accordionExample">
          <div class="accordion-body">
            <strong>7. Apakah saya masih bisa mengakses layanan secara manual jika tidak menggunakan sistem ini?</strong> Ya, meskipun kami mendorong penggunaan sistem untuk kemudahan dan efisiensi, Anda tetap dapat mengurus klaim dan administrasi asuransi secara manual dengan mengunjungi bagian administrasi BMMC.
          </div>
        </div>
      </div>
    </div>
  </section>
  
</body>