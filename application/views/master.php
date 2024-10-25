<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view($head); ?>
</head>
<body class="<?= $contentType == 'dashboard'?'dashboard':''; ?> <?= isset($_COOKIE['colorPreference'])?$_COOKIE['colorPreference']:'' ?>">

<?php if ($contentType == 'dashboard') { ?>

    <?php $this->load->view($sidebar); ?>

    <div class="main-container">
        <?php $this->load->view($floatingMenu); ?>

        <main>
            <div class="container-md py-3">
                <?php $this->load->view($contentHeader); ?>

                <?php $this->load->view($contentBody); ?>
            </div>
        </main>

        <?php $this->load->view($footer); ?>
    </div>

<?php } else if ($contentType == 'user') { ?>

    <?php $this->load->view($navbar); ?>
    
    <?php $this->load->view($content); ?>
    
<?php } else if ($contentType == 'authentication') { ?>

    <?php $this->load->view($content); ?>

<?php } ?>

    <?php $this->load->view($script); ?>

</body>
</html>