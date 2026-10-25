<head>
    <title><?php echo "$judul_halaman | $aplication_name"; ?></title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="<?php echo "$aplication_description"; ?>" />
    <meta name="keywords" content="<?php echo "$aplication_keyword_show"; ?>" />
    <meta name="author" content="<?php echo "$aplication_author"; ?>" />

    <!-- Favicon icon -->
    <link rel="icon" type="image/x-icon" href="assets/img/favicon/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicon/favicon-32x32.png">

    <!-- Google font-->
    <link href="assets/css/Fonts/Font.css?v=3" rel="stylesheet">

    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="node_modules/jquery-ui/dist/themes/base/jquery-ui.min.css">

    <!-- bootstrap -->
    <link rel="stylesheet" href="node_modules/mdb-ui-kit/css/mdb.min.css">

    <!-- sweetalert2 -->
    <script src="node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>

    <!-- tinymce -->
    <?php
        // Agar Aplikasi lebih ringan maka tinymce hanya di panggil pada halaman tertentu
        if($Page=="Kunjungan"){
            echo ' <script src="node_modules/tinymce/tinymce.min.js"></script>';
        }
    ?>

    <!-- Quill -->
    <?php
        // Agar Aplikasi lebih ringan maka tinymce hanya di panggil pada halaman tertentu
        if($Page=="Profile" || $Page=="LaporanKesalahan"){
            echo '
                <link href="node_modules/quill/dist/quill.snow.css" rel="stylesheet">
                <script src="node_modules/quill/dist/quill.js"></script>
            ';
        }
    ?>

    <!-- Custome Style (Style.css) -->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css?v=<?php echo filemtime(__DIR__ . '/../assets/css/style.css'); ?>">
    <link rel="stylesheet" href="assets/css/layout.css?v=<?php echo filemtime(__DIR__ . '/../assets/css/layout.css'); ?>">

    <!-- Driver -->
    <link rel="stylesheet" href="node_modules/driver.js/dist/driver.css">
    
    <!-- Select2 CSS -->
    <link href="node_modules/select2/dist/css/select2.min.css" rel="stylesheet">
    <link href="node_modules/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet">

    <!-- bootstrap-icons -->
    <link href="node_modules/bootstrap-icons/font/bootstrap-icons.min.css" rel="stylesheet" crossorigin="anonymous">
</head>