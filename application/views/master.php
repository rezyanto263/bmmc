<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view($head); ?>
</head>
<body class="
    <?= $contentType == 'dashboard' ? 'dashboard' : ''; ?> 
    <?= isset($_COOKIE['colorPreference']) ? $_COOKIE['colorPreference'] : '' ?>">

<?php if ($contentType == 'dashboard'): ?>

    <?php $this->load->view($sidebar); ?>

    <div class="main-container">
        <?php $this->load->view($floatingMenu); ?>

        <main>
            <div class="container-fluid py-3 px-lg-3 px-xxl-4">
                <?php $this->load->view($contentHeader); ?>

                <?php $this->load->view($contentBody); ?>
            </div>
        </main>
    </div>

<?php endif; ?>

<?php if ($contentType == 'user'): ?>

        <?php $this->load->view($navbar); ?>

        <main>
            <?php $this->load->view($content); ?>
        </main>

        <?php $this->load->view($footer); ?>

<?php endif; ?>

<?php if ($contentType == 'authentication'): ?>

    <?php $this->load->view($content); ?>

<?php endif; ?>

<?php if ($contentType == 'profile'): ?>

    <?php $this->load->view($content); ?>

<?php endif; ?>

    <?php $this->load->view($script); ?>
</body>
</html>