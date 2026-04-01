<head>
    <title><?php echo "$aplication_name"; ?></title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="<?php echo "$aplication_description"; ?>" />
    <meta name="keywords" content="<?php echo "$aplication_keyword_show"; ?>" />
    <meta name="author" content="<?php echo "$aplication_author"; ?>" />

    <!-- Favicon icon -->
    <link rel="icon" href="assets/images/<?php echo "$favicon"; ?>" type="image/x-icon">

    <!-- Google font-->
    <link href="assets\css\Fonts\Font.css?v=3" rel="stylesheet">

    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="assets/jquery-ui-1.14.2/jquery-ui.min.css">

    <!-- bootstrap -->
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css" crossorigin="anonymous">

    <!-- sweetalert2 -->
    <script src="node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>

    <!-- tinymce -->
    <?php
        // Agar Aplikasi lebih ringan maka tinymce hanya di panggil pada halaman tertentu
        if($Page=="Kunjungan"){
            echo ' <script src="node_modules/tinymce/tinymce.min.js"></script>';
        }
    ?>
   
    <!-- themify icon -->
    <link rel="stylesheet" type="text/css" href="assets/icon/themify-icons/themify-icons.css">

    <!-- icofont -->
    <link rel="stylesheet" type="text/css" href="assets/icon/icofont/icofont.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="assets/icon/font-awesome/css/font-awesome.min.css">

    <!-- Custome Style (Style.css) -->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css?v=<?php echo date('YmdHis'); ?>">

    <!-- Driver -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.css"/>
    
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet">

    <!-- bootstrap-icons -->
    <link href="node_modules/bootstrap-icons/font/bootstrap-icons.min.css" rel="stylesheet" crossorigin="anonymous">
</head>