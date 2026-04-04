<!-- jquery -->
<script type="text/javascript" src="node_modules/jquery/dist/jquery.min.js"></script>

<!-- jquery-ui-1.14.2 UI JS -->
<script src="assets/jquery-ui-1.14.2/jquery-ui.min.js"></script>

<!-- bootstrap -->
<script type="text/javascript" src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

<!-- apexcharts -->
<?php
    // Agar aplikasi lebih ringan maka apexcharts hanya dipanggil pada halaman tertentu
    if($Page==""||$Page=="Dashboard"||$Page=="Profile"){
        echo '<script src="node_modules/apexcharts/dist/apexcharts.min.js"></script>';
    }
?>

<!-- menu js -->
<script type="text/javascript" src="assets/js/accordion.js"></script>
<script src="assets/js/pcoded.min.js"></script>
<script src="assets/js/vertical-layout.min.js "></script>

<!-- script.js -->
<script type="text/javascript" src="assets/js/script.js?v=1"></script>

<!-- Summernote -->
<?php 
    // Agar aplikasi lebih ringan maka summernote hanya dipanggil pada halaman tertentu
    if($Page=="Kunjungan"){
        echo '
            <link href="vendor\Sumernote\summernote.min.css" rel="stylesheet">
            <script src="vendor\Sumernote\summernote.min.js"></script>
        ';
    }
?>

<!-- jQuery-Mask-Plugin -->
<script src="assets/jQuery-Mask-Plugin/dist/jquery.mask.min.js"></script>

<!-- Driver -->
<script src="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.js.iife.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- popper -->
<script src="node_modules\@popperjs\core\dist\umd\popper.min.js" crossorigin="anonymous"></script>
