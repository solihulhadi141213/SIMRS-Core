

<!-- jquery -->
<script type="text/javascript" src="node_modules/jquery/dist/jquery.min.js"></script>

<!-- jquery-ui-1.14.2 UI JS -->
<script src="node_modules/jquery-ui/dist/jquery-ui.min.js"></script>

<!-- bootstrap -->
<script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

<!-- apexcharts -->
<?php
    // Agar aplikasi lebih ringan maka apexcharts hanya dipanggil pada halaman tertentu
    if($Page==""||$Page=="Dashboard"||$Page=="Profile"){
        echo '<script src="node_modules/apexcharts/dist/apexcharts.min.js"></script>';
    }
?>

<!-- menu js -->

<!-- script.js -->
<script type="text/javascript" src="assets/js/main.js?v=<?php echo filemtime(__DIR__ . '/../assets/js/main.js'); ?>"></script>

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

<!-- qrcodejs -->
<?php 
    // Agar aplikasi lebih ringan maka qrcodejs hanya dipanggil pada halaman tertentu
    if($Page=="Kunjungan"){
        echo '
            <script src="node_modules/qrcodejs/qrcode.min.js"></script>
        ';
    }
?>

<!-- Signature Pad -->
<?php 
    // Agar aplikasi lebih ringan maka Signature Pad hanya dipanggil pada halaman tertentu
    if($Page=="GeneralConsent"){
        echo '
            <script src="node_modules\signature_pad\dist\signature_pad.umd.min.js"></script>
        ';
    }
?>

<!-- jQuery-Mask-Plugin -->
<script src="node_modules/jquery-mask-plugin/dist/jquery.mask.min.js"></script>

<!-- Driver -->
<script src="node_modules/driver.js/dist/driver.js.iife.js"></script>

<!-- Select2 JS -->
<script src="node_modules/select2/dist/js/select2.min.js"></script>
