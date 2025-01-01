<!-- navbar -->
<nav
  class="navbar navbar-expand-lg bg-light shadow fixed-top"
  data-aos="fade-down"
  data-aos-duration="1000"
>
  <div class="container">
    <!-- logo -->
    <div class="overflow-hidden" style="width: 200px">
      <img src="<?= base_url('assets/images/logo.png');?>" style="width: 40px" alt="" />
    </div>

    <button
      class="navbar-toggler"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>

    <div
      class="collapse navbar-collapse justify-content-lg-center"
      style="width: 100%"
      id="navbarSupportedContent"
    >
      <ul class="navbar-nav mb-2 mt-2 mb-lg-0 lg-text-center">
        <li class="nav-item">
          <a
            class="nav-link mx-1 fw-bold"
            aria-current="page"
            href="<?=base_url('user/LandingPage');?>"
            >Home</a
          >
        </li>
        <li class="nav-item">
          <a class="nav-link mx-1 fw-bold" href="<?=base_url('user/MapMitra');?>"
            >Mitra</a
          >
        </li>
        <li class="nav-item">
          <a class="nav-link mx-1 fw-bold" href="<?=base_url('user/ListBerita');?>"
            >Berita Terkini</a
          >
        </li>
        <li class="nav-item">
          <a class="nav-link mx-1 fw-bold" href="#">Tentang Kami</a>
        </li>
      </ul>
      <div class="d-lg-none mt-2">
        <a
          href="<?=base_url('user/AuthUser1');?>"
          class="btn btn-primary mx-1"
          tabindex="-1"
          role="button"
          aria-disabled="true"
          >Login</a
        >
        <a
          href="<?=base_url('user/Profile');?>"
          class="btn btn-primary mx-1"
          tabindex="-1"
          role="button"
          aria-disabled="true"
          >Profile</a
        >
      </div>
    </div>

    <div class="d-none d-lg-flex">
      <a
        href="<?=base_url('login');?>"
        class="btn btn-primary mx-1"
        tabindex="-1"
        role="button"
        aria-disabled="true"
        >Login</a
      >
      <a
        href="<?=base_url('user/Profile');?>"
        class="btn btn-primary mx-1"
        tabindex="-1"
        role="button"
        aria-disabled="true"
        >Profile</a
      >
    </div>
  </div>
</nav>
