<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $title ?></title>
<link rel="web icon" href="<?= base_url('assets/images/logo.png') ?>">

<!-- Bootstrap -->
<link rel="stylesheet" href="<?= base_url('vendor/twbs/bootstrap/dist/css/bootstrap.min.css') ?>">

<!-- Select2 -->
<link rel="stylesheet" href="<?= base_url('node_modules/select2/dist/css/select2.min.css') ?>">

<!-- Line Awesome -->
<link rel= "stylesheet" href= "https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css" >

<!-- My Style -->
<link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">

<?php if ($contentType == 'dashboard') { ?>

    <!-- Datatables -->
    <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.1.4/af-2.7.0/b-3.1.1/b-colvis-3.1.1/b-html5-3.1.1/b-print-3.1.1/cr-2.0.4/date-1.5.3/fc-5.0.1/fh-4.0.1/kt-2.12.1/r-3.0.2/rg-1.5.0/rr-1.5.0/sc-2.4.3/sb-1.8.0/sp-2.3.2/sl-2.0.5/sr-1.4.1/datatables.min.css" rel="stylesheet">

    <!-- Dashboard Styles -->
    <link rel="stylesheet" href="<?= base_url('assets/css/dashboard.css') ?>">

    <!--Map-->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />

<?php }else if ($contentType == 'user') { ?>

    <!-- User Styles -->
    <link rel="stylesheet" href="<?= base_url('assets/css/user.css') ?>">

<?php }else if ($contentType == 'authentication') { ?>

    <!-- Auth Styles -->
    <link rel="stylesheet" href="<?= base_url('assets/css/auth.css') ?>">

<?php } ?>

<script>
    // Base URL
    var baseUrl = <?= json_encode(base_url()); ?>;
</script>