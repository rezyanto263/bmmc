<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $title ?></title>
<link rel="web icon" href="<?= base_url('assets/images/logo.png') ?>">

<!-- Bootstrap -->
<link rel="stylesheet" href="<?= base_url('vendor/twbs/bootstrap/dist/css/bootstrap.min.css') ?>">

<!-- Select2 -->
<link rel="stylesheet" href="<?= base_url('node_modules/select2/dist/css/select2.min.css') ?>">

<!-- Flatpickr -->
<link rel="stylesheet" href="<?= base_url('node_modules/flatpickr/dist/flatpickr.min.css') ?>">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css" id="flatpickr-theme">

<!-- Line Awesome -->
<link rel= "stylesheet" href= "https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css" >

<!-- My Style -->
<link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat+Underline:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">


<?php if ($contentType == 'dashboard') { ?>

    <!-- Datatables -->
    <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.1.4/af-2.7.0/b-3.1.1/b-colvis-3.1.1/b-html5-3.1.1/b-print-3.1.1/cr-2.0.4/date-1.5.3/fc-5.0.1/fh-4.0.1/kt-2.12.1/r-3.0.2/rg-1.5.0/rr-1.5.0/sc-2.4.3/sb-1.8.0/sp-2.3.2/sl-2.0.5/sr-1.4.1/datatables.min.css" rel="stylesheet">

    <!-- Dashboard Styles -->
    <link rel="stylesheet" href="<?= base_url('assets/css/dashboard.css') ?>">

    <!--Map-->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
    <link rel="stylesheet" href="<?= base_url('assets/css/companyMain.css') ?>">

<?php } else if ($contentType == 'user') { ?>

    <!-- CDN CSS BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"/>

    <!-- CDN Slider -->
    <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet"/>

    <!-- CDN fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <!-- LINK AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />

    <?php if ($subtitle === 'Profile') { ?>

        <!-- LINK Profile -->
        <link rel="stylesheet" href="<?= base_url('assets/css/Profile.css') ?>">

    <?php } else { ?>
                
        <!-- LINK LandingPage -->
        <link rel="stylesheet" href="<?= base_url('assets/css/LandingPage.css') ?>">

    <?php } ?>
    
<?php } else if ($contentType == 'authentication') { ?>

    <!-- Auth Styles -->
    <link rel="stylesheet" href="<?= base_url('assets/css/auth.css') ?>">

<?php } ?>

<script>
    // Base URL
    var baseUrl = <?= json_encode(base_url()); ?>;

    var csrfName = <?= json_encode($this->security->get_csrf_token_name()); ?>;
</script>
