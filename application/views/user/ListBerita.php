<body class="position-relative">

  <!-- berita -->
  <section
    class="bg-white berita-sec"
    id="berita"
    data-aos="fade-down"
    data-aos-duration="1000"
  >
    <!-- search dan judul -->
    <div
      class="container d-flex flex-lg-row flex-column justify-content-lg-between justify-content-center align align-items-center"
    >
      <h2 class="fw-bold title-berita">Berita Terkini</h2>

      <form class="d-flex mt-3 mt-lg-0" role="search">
        <input
          class="form-control me-2"
          type="search"
          placeholder="Search"
          aria-label="Search"
        />
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>

    <div class="container">
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
              <a class="" href="<?=base_url('user/DetailBerita');?>" role="button"
                >Baca Sekarang
              </a>
              <i class="fa-solid fa-arrow-right ms-2"></i>
            </div>
          </div>
        </div>

        <!-- col 2 -->
        <div class="col" data-aos="zoom-in" data-aos-duration="500">
          <div class="card h-100">
            <div class="h-75">
              <img
                src="<?= base_url('assets/images/mitra.j');?>pg"
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
                src="<?= base_url('assets/images/test1.j');?>pg"
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

        <!-- col 4 -->
        <div class="col" data-aos="zoom-in" data-aos-duration="500">
          <div class="card h-100">
            <div class="h-75">
              <img
                src="<?= base_url('assets/images/test2.j');?>pg"
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

        <!-- col 5 -->
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

        <!-- col 6 -->
        <div class="col" data-aos="zoom-in" data-aos-duration="500">
          <div class="card h-100">
            <div class="h-75">
              <img
                src="<?= base_url('assets/images/mitra.j');?>pg"
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

        <!-- col 5 -->
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

        <!-- col 6 -->
        <div class="col" data-aos="zoom-in" data-aos-duration="500">
          <div class="card h-100">
            <div class="h-75">
              <img
                src="<?= base_url('assets/images/mitra.j');?>pg"
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
        <!-- col 5 -->
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

        <!-- col 6 -->
        <div class="col" data-aos="zoom-in" data-aos-duration="500">
          <div class="card h-100">
            <div class="h-75">
              <img
                src="<?= base_url('assets/images/mitra.j');?>pg"
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
        <!-- col 5 -->
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

        <!-- col 6 -->
        <div class="col" data-aos="zoom-in" data-aos-duration="500">
          <div class="card h-100">
            <div class="h-75">
              <img
                src="<?= base_url('assets/images/mitra.j');?>pg"
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
      </div>

      <!-- pagination -->
      <div class="mt-5">
        <nav aria-label="Page navigation example">
          <ul class="pagination justify-content-center">
            <li class="page-item disabled">
              <a class="page-link">Previous</a>
            </li>
            <li class="page-item active">
              <a class="page-link" href="#">1</a>
            </li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">4</a></li>
            <li class="page-item"><a class="page-link" href="#">5</a></li>
            <li class="page-item"><a class="page-link" href="#">6</a></li>
            <li class="page-item">
              <a class="page-link" href="#">Next</a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </section>
</body>
