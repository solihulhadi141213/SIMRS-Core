<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo "Login | $aplication_name"; ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="description" content="<?php echo $aplication_description; ?>" />
        <meta name="keywords" content="<?php echo $aplication_keyword_show; ?>" />
        <meta name="author" content="<?php echo $aplication_author; ?>" />
        
        <!-- Favicon icon -->
        <link rel="icon" href="assets/images/<?php echo "$favicon"; ?>" type="image/x-icon">
        
        <!-- Google font-->
        <link href="assets/css/Fonts/Fonts.css" rel="stylesheet">

        <!-- Bootstrap -->
        <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css" crossorigin="anonymous">

        <!-- themify icon -->
        <link rel="stylesheet" type="text/css" href="assets/icon/themify-icons/themify-icons.css">

        <!-- icofont -->
        <link rel="stylesheet" type="text/css" href="assets/icon/icofont/icofont.min.css">
        
        <!-- Font Awesome -->
        <link rel="stylesheet" type="text/css" href="assets/icon/font-awesome/css/font-awesome.min.css">

        <!-- LoginStyle.css -->
        <link rel="stylesheet" type="text/css" href="assets/css/LoginStyle.css?v=<?php echo date('YmdHis'); ?>">

        <!-- sweetalert2 -->
        <link rel="stylesheet" href="node_modules/sweetalert2/dist/sweetalert2.min.css">

        <!-- bootstrap-icons -->
        <link href="node_modules/bootstrap-icons/font/bootstrap-icons.min.css" rel="stylesheet" crossorigin="anonymous">

    </head> 
    <body class="login-body">
        <section class="login-section">
            <div class="aurora"></div>
            <div class="container py-5">
                <div class="row justify-content-center align-items-stretch g-4">
                    <div class="col-xl-5 col-lg-10 col-md-10 d-flex">
                        <div class="brand-panel shadow-sm h-100 text-center">
                            <div class="text-center mb-3">
                                <img src="assets/images/<?php echo $favicon; ?>" alt="logo" class="brand-logo">
                            </div>
                            <h2>
                                <a href="" class="text text-white text-decoration-none"><?php echo $hospital_name; ?></a>
                            </h2>
                            <p class="eyebrow mb-2">Selamat datang kembali Di Aplikasi</p>
                            <h1 class="brand-title mb-3"><?php echo $aplication_name; ?></h1>
                            <p class="brand-desc mb-0"><?php echo $aplication_description; ?></p>
                            <div class="mb-3 mt-3 text-center">
                                <img src="assets\images\login-ilustration.png" alt="tema" width="100%">
                            </div>
                            <button type="button" class="btn btn-soft-light btn-lg mt-3 w-100" id="modal_pengajuan_akses">
                                <i class="fa fa-paper-plane"></i> Kirim Pengajuan Akses
                            </button>
                            <button type="button" class="btn btn-link p-0 text-white text-decoration-none mt-3 mb-3" id="modal_reset_password">
                                Lupa Password
                            </button>
                            <?php
                                include "_Partial/Copyright.php";
                            ?>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-10 col-md-10 d-flex">
                        <div class="login-card shadow-lg h-100">
                            <div class="card-head text-center mb-4">
                                <div class="badge-soft">Secure Access</div>
                                <h4 class="mb-2"><i class="fa fa-lock"></i> Login Ke Akun Anda</h4>
                                <p class="text-muted mb-0">Gunakan email resmi dan password Anda untuk masuk.</p>
                            </div>
                            <form id="ProsesLogin" class="login-form" autocomplete="off" onsubmit="return false;">
                                <input type="hidden" name="id_captcha" id="id_captcha" value="">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Alamat Email</label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text"><i class="ti ti-email"></i></span>
                                        <input type="email" name="email" id="email" class="form-control" placeholder="nama@domain.com" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text"><i class="ti ti-lock"></i></span>
                                        <input type="password" name="password" id="password" class="form-control" placeholder="********" required>
                                    </div>
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" value="Ya" id="TampilkanPassword" name="TampilkanPassword">
                                        <label class="form-check-label" for="TampilkanPassword">Tampilkan Password</label>
                                    </div>
                                </div>
                                <div class="mb-3 text-center">
                                    <div class="captcha-frame mb-2">
                                        <img src="" alt="captcha" id="GetUrlCaptcha" />
                                    </div>
                                    <button type="button" class="btn btn-link p-0 text-danger text-decoration-none" id="ReloadCaptcha">
                                        <i class="ti ti-reload"></i> Muat Ulang Captcha
                                    </button>
                                </div>
                                <div class="mb-4">
                                    <label for="captcha" class="form-label">Kode Captcha</label>
                                    <input type="text" class="form-control form-control-lg" id="captcha" name="captcha" placeholder="Masukkan kode di atas" required>
                                </div>
                                <div class="mb-3" id="NotifikasiLogin"></div>
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-lg" id="button_login">
                                        <i class="ti ti-key"></i> Masuk
                                    </button>
                                    <a href="_Page/Login/LoginGoogle.php" class="btn btn-outline-danger btn-lg btn-google">
                                        <i class="bi bi-google"></i> Login Dengan Google
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- jquery -->
        <script type="text/javascript" src="node_modules/jquery/dist/jquery.min.js"></script>

        <!-- bootstrap -->
        <script type="text/javascript" src="node_modules/bootstrap/dist/js/bootstrap.min.js "></script>

        <!-- sweetalert2 -->
        <script src="node_modules/sweetalert2/dist/sweetalert2.min.js"></script>


        <?php
            //ModalLogin.php
            include "_Page/Login/ModalLogin.php";

            // Custome JS Login.js
            echo '<script type="text/javascript" src="_Page/Login/Login.js?v='.date('Ymdhis').'"></script>';
        ?>
    </body>
</html>
