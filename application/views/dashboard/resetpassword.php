<main>
    <div class="container d-flex justify-content-center align-items-center">
        <div class="card d-flex justify-content-center rounded-2 p-md-5 p-4">
            <h1 class="text-center mb-3">Change Password</h1>
            <p class="mb-5 text-secondary text-center fs-6">Please fill this form to change your password.</p>
            <form class="mb-5" action="<?= base_url('AuthDashboard/resetPassword') ?>" method="POST">
                <input type="hidden" name="adminEmail" value="<?= $this->session->userdata('resetPassEmail');?>">
                <div class="mb-4 p-0">
                    <div class="input-group p-0">
                        <span class="input-group-text bg-transparent">
                            <i class="las la-key fs-4"></i>
                        </span>
                        <input class="form-control" id="inputPassword" type="password" placeholder="New Password" name="newPassword">
                        <span type="button" class="input-group-text bg-transparent" id="btnShowPassword">
                            <i class="las la-eye-slash fs-4"></i>
                        </span>
                    </div>
                    <?= form_error('newPassword', '<small class="text-danger px-0 lh-1">', '</small>'); ?>
                </div>
                <div class="mb-4 p-0">
                    <div class="input-group p-0">
                        <span class="input-group-text bg-transparent">
                            <i class="las la-key fs-4"></i>
                        </span>
                        <input class="form-control" id="inputPassword" type="password" placeholder="Password Confirmation" name="confirmPassword">
                        <span type="button" class="input-group-text bg-transparent" id="btnShowPassword">
                            <i class="las la-eye-slash fs-4"></i>
                        </span>
                    </div>
                    <?= form_error('confirmPassword', '<small class="text-danger px-0 lh-1">', '</small>'); ?>
                </div>
                <button type="submit" class="btn-primary w-100">
                    CHANGE PASSWORD
                </button>
            </form>
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