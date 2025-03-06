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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/confirmDate/confirmDate.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css" id="flatpickr-theme">

<!-- Line Awesome -->
<link rel= "stylesheet" href= "https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css" >

<!--Map-->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />

<!-- Datatables -->
<link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.1.4/af-2.7.0/b-3.1.1/b-colvis-3.1.1/b-html5-3.1.1/b-print-3.1.1/cr-2.0.4/date-1.5.3/fc-5.0.1/fh-4.0.1/kt-2.12.1/r-3.0.2/rg-1.5.0/rr-1.5.0/sc-2.4.3/sb-1.8.0/sp-2.3.2/sl-2.0.5/sr-1.4.1/datatables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/select/3.0.0/css/select.dataTables.css">

<!-- My Style -->
<link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">


<?php if ($contentType == 'dashboard') { ?>

    <!-- PDF JS -->
    <link rel="stylesheet" href="https://mozilla.github.io/pdf.js/web/viewer.css">

    <!-- Tagify -->
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet">

    <!-- Dashboard Styles -->
    <link rel="stylesheet" href="<?= base_url('assets/css/dashboard.css') ?>">

<?php } else if ($contentType == 'user') { ?>

    <!-- CDN Slider -->
    <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet"/>

    <!-- LINK AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />

    <!-- User Styles -->
    <link rel="stylesheet" href="<?= base_url('assets/css/user.css') ?>">

<?php } else if ($contentType == 'authentication') { ?>

    <!-- Auth Styles -->
    <link rel="stylesheet" href="<?= base_url('assets/css/auth.css') ?>">

<?php } ?>

<script defer>
    var baseUrl = <?= json_encode(base_url()); ?>;
    var csrfName = <?= json_encode($this->security->get_csrf_token_name()); ?>;
</script>
