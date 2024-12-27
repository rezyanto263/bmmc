<body class="position-relative">
  <!-- hero section -->
  <section
    class="position-relative overflow-x-hidden"
    data-aos="fade-down"
    data-aos-duration="1000"
  >
    <!-- gambar -->
    <div
      class="w-100 d-flex justify-content-center align-items-center overflow-hidden position-relative"
      style="height: 750px"
    >
      <img
        src="<?= base_url('assets/images/test1.jpg');?>"
        class="img-fluid h-100 w-100 object-fit-cover"
        alt="Gambar Keluarga"
      />
      <div
        class="position-absolute top-0 start-0 w-100 h-100 bg-black opacity-50"
      ></div>
    </div>

    <!-- kotak -->
    <div
      class="position-absolute top-50 start-50 translate-middle bg-biru opacity-75 shadow kotak-hero"
    ></div>

    <!-- dalam konten -->
    <div class="position-absolute top-50 start-50 translate-middle z-1 w-75">
      <h2
        class="fw-bold text-center mb-2 m-auto text-white pb-2 title-heading"
      >
        Bali Mitra Medical Center
      </h2>
      <!-- slogan -->
      <h5 class="mt-3 fst-italic text-center text-white slogan">
        Lorem ipsum dolor sit amet consectetur.
      </h5>
    </div>
  </section>

  <!-- about -->
  <section
    class="container overflow-x-hidden d-flex flex-column flex-md-row justify-content-between align-items-center mt-5"
  >
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
    <div
      class="kanan-about d-flex justify-content-center"
      data-aos="zoom-in"
      data-aos-duration="1000"
    >
      <iframe
        class="rounded-3"
        width="100%"
        height="100%"
        src="https://www.youtube.com/embed/2MUdZWu9oKE?si=1qPth17F5H37d3la"
        title="YouTube video player"
        frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
        referrerpolicy="strict-origin-when-cross-origin"
        allowfullscreen
      ></iframe>
    </div>
  </section>

  <!-- mitra -->
  <section
    class="mitra-sec overflow-x-hidden"
    data-aos="fade-up"
    data-aos-duration="1000"
  >
    <div class="container">
      <!-- judul -->
      <h2 class="fw-bold text-white text-center title-mitra m-auto pt-3 pb-2">
        Mitra Bali Mitra Medical Center
      </h2>

      <!-- slider normal -->
      <section
        class="splide normal mt-5 mb-5"
        aria-label="Splide Basic HTML Example"
      >
        <div class="splide__track position-relative">
          <div class="splide__list partner">
            <div class="splide__slide d-flex align-items-center">
              <img
                src="<?= base_url('assets/images/mitra.jpg');?>"
                alt=""
                class="img-mitra"
                loading="lazy"
              />
            </div>
            <div class="splide__slide d-flex align-items-center">
              <img
                src="<?= base_url('assets/images/mitra.jpg');?>"
                alt=""
                class="img-mitra"
                loading="lazy"
              />
            </div>
          </div>
        </div>
      </section>

      <!-- slider reverse -->
      <section
        class="splide reverse mt-5 mb-5"
        aria-label="Splide Basic HTML Example"
      >
        <div class="splide__track position-relative">
          <div class="splide__list partner">
            <div class="splide__slide d-flex align-items-center">
              <img
                src="<?= base_url('assets/images/mitra.jpg');?>"
                alt=""
                class="img-mitra"
                loading="lazy"
              />
            </div>
            <div class="splide__slide d-flex align-items-center">
              <img
                src="<?= base_url('assets/images/mitra.jpg');?>"
                alt=""
                class="img-mitra"
                loading="lazy"
              />
            </div>
          </div>
        </div>
      </section>
    </div>
  </section>

  <!-- berita -->
  <section
    class="bg-white berita-sec"
    id="berita"
    data-aos="fade-up"
    data-aos-duration="1000"
  >
    <div class="container">
      <h2 class="fw-bold title-berita">Berita Terkini</h2>

      <!-- card berita -->
      <div class="row row-cols-1 row-cols-md-3 g-4 mt-3">
        <!-- col 1 -->
        <div class="col" data-aos="zoom-in" data-aos-duration="500">
          <div class="card h-100">
            <div class="h-75">
              <img
                src="<?= base_url('assets/images/95c.png');?>"
                class="card-img-top img-uniform h-100 object-fit-cover"
                alt="..."
              />
            </div>
            <div class="card-body">
              <h5 class="card-title fw-semibold judul-card">
                Lorem ipsum dolor sit amet.
              </h5>
              <!-- tambahan -->
              <div class="d-flex align-items-center flex-wrap my-1">
                <!-- bagian waktu -->
                <div
                  class="d-flex align-items-center bg-danger rounded-pill text-white"
                  style="height: 30px"
                >
                  <i
                    class="fa-solid fa-clock-rotate-left mx-2"
                    style="font-size: 12px"
                  >
                    <span class="fw-normal ms-1">2 Bulan yang lalu</span>
                  </i>
                </div>

                <!-- bagian jenis -->
                <div
                  class="mx-lg-1 d-flex align-items-center bg-success rounded-pill text-white mx-1"
                  style="height: 30px"
                >
                  <i
                    class="fa-solid fa-circle-exclamation mx-2"
                    style="font-size: 12px"
                  >
                    <span class="fw-normal ms-1">Berita</span>
                  </i>
                </div>

                <!-- bagian kategori -->
                <div
                  class="mx-lg-1 d-flex align-items-center bg-primary rounded-pill text-white"
                  style="height: 30px"
                >
                  <i
                    class="fa-solid fa-copyright mx-2"
                    style="font-size: 12px"
                  >
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
              <a class="" href="<?=base_url('user/DetailBerita');?>" role="button">Baca Sekarang </a>
              <i class="fa-solid fa-arrow-right ms-2"></i>
            </div>
          </div>
        </div>

        <!-- col 2 -->
        <div class="col" data-aos="zoom-in" data-aos-duration="500">
          <div class="card h-100">
            <div class="h-75">
              <img
                src="<?= base_url('assets/images/mitra.jpg');?>"
                class="card-img-top img-uniform h-100 object-fit-cover"
                alt="..."
              />
            </div>
            <div class="card-body">
              <h5 class="card-title fw-semibold judul-card">
                Lorem ipsum dolor sit amet.
              </h5>
              <!-- tambahan -->
              <div class="d-flex align-items-center flex-wrap my-1">
                <!-- bagian waktu -->
                <div
                  class="d-flex align-items-center bg-danger rounded-pill text-white"
                  style="height: 30px"
                >
                  <i
                    class="fa-solid fa-clock-rotate-left mx-2"
                    style="font-size: 12px"
                  >
                    <span class="fw-normal ms-1">2 Bulan yang lalu</span>
                  </i>
                </div>

                <!-- bagian jenis -->
                <div
                  class="mx-lg-1 d-flex align-items-center bg-success rounded-pill text-white mx-1"
                  style="height: 30px"
                >
                  <i
                    class="fa-solid fa-circle-exclamation mx-2"
                    style="font-size: 12px"
                  >
                    <span class="fw-normal ms-1">Berita</span>
                  </i>
                </div>

                <!-- bagian kategori -->
                <div
                  class="mx-lg-1 d-flex align-items-center bg-primary rounded-pill text-white"
                  style="height: 30px"
                >
                  <i
                    class="fa-solid fa-copyright mx-2"
                    style="font-size: 12px"
                  >
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
              <a class="" href="<?=base_url('user/DetailBerita');?>" role="button">Baca Sekarang </a>
              <i class="fa-solid fa-arrow-right ms-2"></i>
            </div>
          </div>
        </div>

        <!-- col 3 -->
        <div class="col" data-aos="zoom-in" data-aos-duration="500">
          <div class="card h-100">
            <div class="h-75">
              <img
                src="<?= base_url('assets/images/test1.jpg');?>"
                class="card-img-top img-uniform h-100 object-fit-cover"
                alt="..."
              />
            </div>
            <div class="card-body">
              <h5 class="card-title fw-semibold judul-card">
                Lorem ipsum dolor sit amet.
              </h5>
              <!-- tambahan -->
              <div class="d-flex align-items-center flex-wrap my-1">
                <!-- bagian waktu -->
                <div
                  class="d-flex align-items-center bg-danger rounded-pill text-white"
                  style="height: 30px"
                >
                  <i
                    class="fa-solid fa-clock-rotate-left mx-2"
                    style="font-size: 12px"
                  >
                    <span class="fw-normal ms-1">2 Bulan yang lalu</span>
                  </i>
                </div>

                <!-- bagian jenis -->
                <div
                  class="mx-lg-1 d-flex align-items-center bg-success rounded-pill text-white mx-1"
                  style="height: 30px"
                >
                  <i
                    class="fa-solid fa-circle-exclamation mx-2"
                    style="font-size: 12px"
                  >
                    <span class="fw-normal ms-1">Berita</span>
                  </i>
                </div>

                <!-- bagian kategori -->
                <div
                  class="mx-lg-1 d-flex align-items-center bg-primary rounded-pill text-white"
                  style="height: 30px"
                >
                  <i
                    class="fa-solid fa-copyright mx-2"
                    style="font-size: 12px"
                  >
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
              <a class="" href="<?=base_url('user/DetailBerita');?>" role="button">Baca Sekarang </a>
              <i class="fa-solid fa-arrow-right ms-2"></i>
            </div>
          </div>
        </div>

      <!-- button all berita -->
      <div class="mb-3 mt-4 button-berita-all shadow">
        <a class="" href="./berita_list.html" role="button"
          >Baca Semua Sekarang
        </a>
        <i class="fa-solid fa-arrow-right ms-2"></i>
      </div>
    </div>
  </section>

  <!-- faq -->
  <section class="container" data-aos="fade-up" data-aos-duration="1000">
    <h2 class="fw-bold title-faq mt-5 mb-4">FQA</h2>
    <div class="accordion mb-5" id="accordionExample">
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingOne">
          <button
            class="accordion-button"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseOne"
            aria-expanded="true"
            aria-controls="collapseOne"
          >
            Accordion Item #1
          </button>
        </h2>
        <div
          id="collapseOne"
          class="accordion-collapse collapse show"
          aria-labelledby="headingOne"
          data-bs-parent="#accordionExample"
        >
          <div class="accordion-body">
            <strong>This is the first item's accordion body.</strong> It is
            shown by default, until the collapse plugin adds the appropriate
            classes that we use to style each element. These classes control
            the overall appearance, as well as the showing and hiding via CSS
            transitions. You can modify any of this with custom CSS or
            overriding our default variables. It's also worth noting that just
            about any HTML can go within the <code>.accordion-body</code>,
            though the transition does limit overflow.
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header" id="headingTwo">
          <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseTwo"
            aria-expanded="false"
            aria-controls="collapseTwo"
          >
            Accordion Item #2
          </button>
        </h2>
        <div
          id="collapseTwo"
          class="accordion-collapse collapse"
          aria-labelledby="headingTwo"
          data-bs-parent="#accordionExample"
        >
          <div class="accordion-body">
            <strong>This is the second item's accordion body.</strong> It is
            hidden by default, until the collapse plugin adds the appropriate
            classes that we use to style each element. These classes control
            the overall appearance, as well as the showing and hiding via CSS
            transitions. You can modify any of this with custom CSS or
            overriding our default variables. It's also worth noting that just
            about any HTML can go within the <code>.accordion-body</code>,
            though the transition does limit overflow.
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header" id="headingThree">
          <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseThree"
            aria-expanded="false"
            aria-controls="collapseThree"
          >
            Accordion Item #3
          </button>
        </h2>
        <div
          id="collapseThree"
          class="accordion-collapse collapse"
          aria-labelledby="headingThree"
          data-bs-parent="#accordionExample"
        >
          <div class="accordion-body">
            <strong>This is the third item's accordion body.</strong> It is
            hidden by default, until the collapse plugin adds the appropriate
            classes that we use to style each element. These classes control
            the overall appearance, as well as the showing and hiding via CSS
            transitions. You can modify any of this with custom CSS or
            overriding our default variables. It's also worth noting that just
            about any HTML can go within the <code>.accordion-body</code>,
            though the transition does limit overflow.
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header" id="headingFour">
          <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseFour"
            aria-expanded="false"
            aria-controls="collapseFour"
          >
            Accordion Item #4
          </button>
        </h2>
        <div
          id="collapseFour"
          class="accordion-collapse collapse"
          aria-labelledby="headingFour"
          data-bs-parent="#accordionExample"
        >
          <div class="accordion-body">
            <strong>This is the third item's accordion body.</strong> It is
            hidden by default, until the collapse plugin adds the appropriate
            classes that we use to style each element. These classes control
            the overall appearance, as well as the showing and hiding via CSS
            transitions. You can modify any of this with custom CSS or
            overriding our default variables. It's also worth noting that just
            about any HTML can go within the <code>.accordion-body</code>,
            though the transition does limit overflow.
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header" id="headingFive">
          <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseFive"
            aria-expanded="false"
            aria-controls="collapseFive"
          >
            Accordion Item #5
          </button>
        </h2>
        <div
          id="collapseFive"
          class="accordion-collapse collapse"
          aria-labelledby="headingFive"
          data-bs-parent="#accordionExample"
        >
          <div class="accordion-body">
            <strong>This is the third item's accordion body.</strong> It is
            hidden by default, until the collapse plugin adds the appropriate
            classes that we use to style each element. These classes control
            the overall appearance, as well as the showing and hiding via CSS
            transitions. You can modify any of this with custom CSS or
            overriding our default variables. It's also worth noting that just
            about any HTML can go within the <code>.accordion-body</code>,
            though the transition does limit overflow.
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header" id="headingSix">
          <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseSix"
            aria-expanded="false"
            aria-controls="collapseSix"
          >
            Accordion Item #6
          </button>
        </h2>
        <div
          id="collapseSix"
          class="accordion-collapse collapse"
          aria-labelledby="headingSix"
          data-bs-parent="#accordionExample"
        >
          <div class="accordion-body">
            <strong>This is the third item's accordion body.</strong> It is
            hidden by default, until the collapse plugin adds the appropriate
            classes that we use to style each element. These classes control
            the overall appearance, as well as the showing and hiding via CSS
            transitions. You can modify any of this with custom CSS or
            overriding our default variables. It's also worth noting that just
            about any HTML can go within the <code>.accordion-body</code>,
            though the transition does limit overflow.
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header" id="headingSeven">
          <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseSeven"
            aria-expanded="false"
            aria-controls="collapseSeven"
          >
            Accordion Item #7
          </button>
        </h2>
        <div
          id="collapseSeven"
          class="accordion-collapse collapse"
          aria-labelledby="headingSeven"
          data-bs-parent="#accordionExample"
        >
          <div class="accordion-body">
            <strong>This is the third item's accordion body.</strong> It is
            hidden by default, until the collapse plugin adds the appropriate
            classes that we use to style each element. These classes control
            the overall appearance, as well as the showing and hiding via CSS
            transitions. You can modify any of this with custom CSS or
            overriding our default variables. It's also worth noting that just
            about any HTML can go within the <code>.accordion-body</code>,
            though the transition does limit overflow.
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- script slider -->
  <script>
    // buat normal
    document.addEventListener("DOMContentLoaded", function () {
      new Splide(".normal", {
        type: "loop",
        drag: "free",
        focus: "center",
        pagination: false,
        arrows: false,
        perPage: 5,
        autoScroll: {
          speed: 0.5,
        },
        breakpoints: {
          768: {
            perPage: 3,
          },
          640: {
            perPage: 2,
          },
        },
      }).mount(window.splide.Extensions);
    });

    // buar reverse
    document.addEventListener("DOMContentLoaded", function () {
      new Splide(".reverse", {
        type: "loop",
        drag: "free",
        focus: "center",
        pagination: false,
        arrows: false,
        perPage: 5,
        autoScroll: {
          speed: -0.5,
        },
        breakpoints: {
          768: {
            perPage: 3,
          },
          640: {
            perPage: 2,
          },
        },
      }).mount(window.splide.Extensions);
    });
  </script>
</body>
