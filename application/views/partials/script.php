<!-- JQuery -->
<script defer src="<?= base_url('node_modules/jquery/dist/jquery.min.js') ?>"></script>
<script defer src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
<script defer src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>

<!-- Bootstrap -->
<script defer src="<?= base_url('vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js') ?>"></script>

<!-- Select2 -->
<script defer src="<?= base_url('node_modules/select2/dist/js/select2.min.js') ?>"></script>

<!-- Fontawesome -->
<script defer src="https://kit.fontawesome.com/1a07ed5a89.js" crossorigin="anonymous"></script>

<!-- Sweetalert 2 -->
<script defer src="<?= base_url('node_modules/sweetalert2/dist/sweetalert2.all.min.js') ?>"></script>


<?php if ($contentType == 'dashboard'): ?>

    <!-- Instascan -->
    <script defer type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
    <script defer type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
    <script defer type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

    <!-- Datatables -->
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script defer src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.1.4/af-2.7.0/b-3.1.1/b-colvis-3.1.1/b-html5-3.1.1/b-print-3.1.1/cr-2.0.4/date-1.5.3/fc-5.0.1/fh-4.0.1/kt-2.12.1/r-3.0.2/rg-1.5.0/rr-1.5.0/sc-2.4.3/sb-1.8.0/sp-2.3.2/sl-2.0.5/sr-1.4.1/datatables.min.js"></script>

    <!--Map-->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script defer src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
    <script defer src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <!-- Moment -->
    <script defer src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>

    <!-- Flatpickr -->
    <script defer src="<?= base_url('node_modules/flatpickr/dist/flatpickr.min.js') ?>"></script>

    <!-- Cleave -->
    <script defer src="<?= base_url('node_modules/cleave.js/dist/cleave.min.js') ?>"></script>
    <script defer src="<?= base_url('node_modules/cleave.js/dist/addons/cleave-phone.id.js') ?>"></script>

<?php endif; ?>


<!-- My Script -->
<script defer src="<?= base_url('assets/js/script.js') ?>"></script>

<?php if ($contentType == 'dashboard'): ?>
    
    <script defer src="<?= base_url('assets/js/table.js') ?>"></script>
    <script defer src="<?= base_url('assets/js/scanner.js') ?>"></script>
    
<?php endif; ?>

<?php if ($contentType == 'user'): ?>

    <!-- CDN JAVASCRIPT BOOTSTRAP -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>

    <!-- CDN Slider -->
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide-extension-auto-scroll@0.5.3/dist/js/splide-extension-auto-scroll.min.js"></script>

    <!-- script AOS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

     <!-- Datatables -->
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script defer src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.1.4/af-2.7.0/b-3.1.1/b-colvis-3.1.1/b-html5-3.1.1/b-print-3.1.1/cr-2.0.4/date-1.5.3/fc-5.0.1/fh-4.0.1/kt-2.12.1/r-3.0.2/rg-1.5.0/rr-1.5.0/sc-2.4.3/sb-1.8.0/sp-2.3.2/sl-2.0.5/sr-1.4.1/datatables.min.js"></script>

    <script>
      AOS.init();
    </script>

    <script defer src="<?= base_url('assets/js/user.js') ?>"></script>
    
<?php endif; ?>

<script defer src="<?= base_url('assets/js/alert.js') ?>"></script>
