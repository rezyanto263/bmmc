<main>
    <div class="container d-flex justify-content-center align-items-center">
        <div class="login-frame rounded-2 shadow overflow-hidden d-flex justify-content-center align-items-center my-5">
            <div class="row h-100">
                <div class="login-design col-6 d-none d-lg-flex gap-3 flex-lg-column justify-content-center align-items-center py-5">
                    <h3 class="fw-bold mb-4 text-white">WELCOME TO</h3>
                    <img class="" src="../assets/images/logo.png" alt="">
                    <h5 class="text-white mb-4">BALI MITRA MEDICAL CENTER</h5>
                    <p class="text-white text-center mx-5 mb-4">
                        At BMMC (Bali Mitra Medical Center), your health is our priority. We provide comprehensive health insurance services tailored to meet the unique needs of our clients, ensuring peace of mind and quality care when you need it most.
                    </p>
                    <div class="login-contact d-flex align-items-center gap-2 text-white mt-5">
                        <i class="las la-phone"></i>
                        <span>(0361) 480085</span>
                        <span class="border border-right-1 border-white h-100 mx-2"></span>
                        <i class="las la-envelope"></i>
                        <span>bmmc@gmail.com</span>
                    </div>
                </div>
                <div class="login-form col-12 col-lg-6 d-flex flex-column justify-content-center align-items-center p-md-5 px-4 py-5">
                    <h1 class="mb-5">
                        Login Dashboard
                    </h1>
                    <div id="loginAlert" data-flashdata="<?= $this->session->flashdata('flashdata');?>"></div>
                    <form class="row gy-2 d-flex justify-content-center px-3" action="<?= base_url('authDashboard/loginDashboard') ?>" method="POST">
                        <div class="mb-3 p-0">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent">
                                    <i class="las la-envelope fs-4"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Email" name="adminEmail" value="<?= set_value('adminEmail'); ?>">
                            </div>
                            <?= form_error('adminEmail', '<small class="text-danger px-0 lh-1">', '</small>'); ?>
                        </div>
                        <div class="p-0">
                            <div class="input-group p-0">
                                <span class="input-group-text bg-transparent">
                                    <i class="las la-key fs-4"></i>
                                </span>
                                <input class="form-control" id="inputPassword" type="password" placeholder="Password" name="adminPassword" autocomplete="current-password" value="<?= set_value('adminPassword'); ?>">
                                <span type="button" class="input-group-text bg-transparent" id="btnShowPassword">
                                    <i class="las la-eye-slash fs-4"></i>
                                </span>
                            </div>
                            <?= form_error('adminPassword', '<small class="text-danger px-0 lh-1">', '</small>'); ?>
                        </div>
                        <div class="d-flex justify-content-between px-0 text-secondary fs-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="rememberMe">
                                <label class="form-check-label">
                                    Remember me
                                </label>
                            </div>
                            <a href="<?= base_url('dashboard/forgotpassword') ?>" class="text-secondary">
                                Forgot password?
                            </a>
                        </div>
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <div class="g-recaptcha my-4 d-flex justify-content-center" data-sitekey="<?= $_ENV['CAPTCHA_SITE_KEY'] ?>"></div>
                        <button type="submit" class="btn-primary">
                            LOGIN
                        </button>
                        <p></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>