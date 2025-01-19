<main>
    <div class="container d-flex justify-content-center align-items-center">
        <div class="card d-flex justify-content-center rounded-2 p-md-5 p-4">
            <h1 class="text-center mb-3">Forgot Your Password?</h1>
            <p class="mb-5 text-secondary text-center fs-6">Please enter your account email to reset your password.</p>
            <div id="forgotPassAlert" data-flashdata="<?= $this->session->flashdata('flashdata'); ?>" data-errorflashdata="<?= $this->session->flashdata('errorflashdata'); ?>"></div>
            <form class="mb-5" action="<?= base_url('AuthDashboard/forgotPassword') ?>" method="POST">
                <div class="mb-4 p-0">
                    <div class="input-group p-0">
                        <span class="input-group-text bg-transparent">
                            <i class="las la-envelope fs-4"></i>
                        </span>
                        <input class="form-control" type="text" placeholder="Account Email" name="adminEmail">
                    </div>
                    <?= form_error('adminEmail', '<small class="text-danger px-0 lh-1">', '</small>'); ?>
                </div>
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <button type="submit" class="btn-primary w-100">
                    SUBMIT
                </button>
            </form>
            <a class="text-center text-secondary mb-5 mx-auto" href="<?= base_url('dashboard/login') ?>">Back to Login Page</a>
            <div class="login-contact d-flex flex-md-row flex-column align-items-center justify-content-center text-secondary gx-0 gy-2">
                <div>
                    <i class="las la-phone"></i>
                    <span>(0361) 480085</span>
                    <span class="d-none d-md-inline border border-right-1 border-secondary h-100 mx-2"></span>
                </div>
                <div>
                    <i class="las la-envelope"></i>
                    <span>baliintimedika@gmail.com</span>
                </div>
            </div>
        </div>
    </div>
</main>