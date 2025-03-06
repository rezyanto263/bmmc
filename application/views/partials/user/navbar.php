<nav class="navbar navbar-expand-lg px-1 px-md-3 px-lg-4 w-100">
  <div class="container-xxl">
    <div>
      <a class="navbar-brand d-flex gap-1" href="<?= base_url(); ?>">
        <img src="<?= base_url('assets/images/logo.png'); ?>" alt="Logo">
        <div class="logo-text d-flex flex-column">
          <h1 class="m-0">
            BALI MITRA <br>
            MEDICAL CENTER
          </h1>
          <small>
            Health Insurance Services <br>
            Provider in Bali
          </small>
        </div>
      </a>
    </div>
    <button class="navbar-toggler p-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-expanded="false">
      <i class="las la-bars fs-1"></i>
    </button>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav mx-auto gap-4">
        <li class="nav-item">
          <a class="nav-link <?= $subtitle === 'Home' ? 'active' : ''; ?>" aria-current="page" href="<?= base_url(); ?>">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $subtitle === 'Partners' ? 'active' : ''; ?>" href="<?= base_url('partners'); ?>">Partners</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $subtitle === 'News' ? 'active' : ''; ?>" href="<?= base_url('news'); ?>">News</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $subtitle === 'About' ? 'active' : ''; ?>" href="<?= base_url('about') ?>">About</a>
        </li>
      </ul>
      <div class="navbar-nav-extra">
        <?php if ($this->session->userdata('userNIK') && $subtitle == 'Profile'): ?>
          <button type="button" class="btn-danger text-decoration-none px-4 me-1" data-bs-toggle="modal" data-bs-target="#logoutModal">
            Logout
          </button>
        <?php elseif ($this->session->userdata('userNIK')): ?>
          <a type="button" href="<?= base_url('profile'); ?>" class="btn-primary bg-gradient text-decoration-none px-3 me-1">Go to Profile</a>
        <?php else: ?>
          <a type="button" href="<?= base_url('login'); ?>" class="btn-outline-primary text-decoration-none px-3 me-1">Sign In</a>
          <a type="button" href="https://api.whatsapp.com/send?phone=6282146934377" target="_blank" class="btn-primary text-decoration-none px-3 bg-gradient">Get in Touch</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>

<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasMenu">
  <div class="offcanvas-header">
    <img class="img-fluid me-3" src="<?= base_url('assets/images/logo.png'); ?>" alt="Logo" width="12%">
    <h1 class="offcanvas-title text-primary fw-bold">MENU</h1>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <ul class="navbar-nav mx-auto gap-4 fs-4">
      <li class="nav-item">
        <a class="nav-link <?= $subtitle === 'Home' ? 'active' : ''; ?>" href="<?= base_url(); ?>">
          <i class="las la-home text-primary"></i> 
          Home
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= $subtitle === 'Partners' ? 'active' : ''; ?>" href="<?= base_url('partners'); ?>">
          <i class="las la-home text-primary"></i> 
          Partners
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= $subtitle === 'News' ? 'active' : ''; ?>" href="<?= base_url('news'); ?>">
          <i class="las la-newspaper text-primary"></i> 
          News
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= $subtitle === 'About' ? 'active' : ''; ?>" href="<?= base_url('about'); ?>">
          <i class="las la-question text-primary"></i> 
          About
        </a>
      </li>
      <li class="nav-item">
        <?php if ($this->session->userdata('userNIK') && $subtitle == 'Profile'): ?>
          <a class="nav-link text-danger" href="<?= base_url('profile') ?>">
            <i class="las la-sign-out-alt text-danger"></i> 
            Logout
          </a>
        <?php elseif ($this->session->userdata('userNIK')): ?>
          <a class="nav-link" href="<?= base_url('profile') ?>">
            <i class="las la-user text-primary"></i> 
            Go to Profile
          </a>
        <?php else: ?>
          <a type="button" class="nav-link" data-bs-toggle="modal" data-bs-target="#logoutModal">
            <i class="las la-sign-in-alt text-primary"></i> 
            Sign In
          </a>
        <?php endif; ?>
      </li>
    </ul>
  </div>
</div>