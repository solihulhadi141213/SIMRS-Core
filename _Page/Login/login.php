<!DOCTYPE html>
<html lang="id">
    <head>
        <title><?php echo "Login"; ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="description" content="<?php echo $aplication_description; ?>" />
        <meta name="keywords" content="<?php echo $aplication_keyword_show; ?>" />
        <meta name="author" content="<?php echo $aplication_author; ?>" />
        
        <!-- Favicon icon -->
        <link rel="icon" type="image/x-icon" href="assets/img/favicon/favicon.ico">
        <link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicon/favicon-32x32.png">
        
        <!-- Google font-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Bootstrap -->
        <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css" crossorigin="anonymous">

        <!-- LoginStyle.css -->
        <link rel="stylesheet" type="text/css" href="assets/css/LoginStyle.css?v=<?php echo date('YmdHis'); ?>">

        <!-- sweetalert2 -->
        <link rel="stylesheet" href="node_modules/sweetalert2/dist/sweetalert2.min.css">

        <!-- bootstrap-icons -->
        <link href="node_modules/bootstrap-icons/font/bootstrap-icons.min.css" rel="stylesheet" crossorigin="anonymous">

    </head> 
    <body class="login-body">
        <section class="login-section">
            <div class="login-layout">
                <aside class="brand-panel">
                    <div class="brand-content">
                        <img src="assets/img/ui/app-logo.png" alt="Logo <?php echo $aplication_name; ?>" class="brand-logo">
                        <p class="eyebrow">Selamat Datang Kembali Di Aplikasi</p>
                        <h1 class="brand-title"><?php echo $aplication_name; ?></h1>
                        <p class="brand-desc">Manajemen Data Pasien, Pendaftaran Kunjungan, Manajemen Poliklinik, Referensi Ruang Rawat, Integrasi VClaim BPJS, Integrasi SATUSEHAT, Integrasi RMS, Integrasi LMS, Pelaporan</p>
                    </div>
                    <p class="brand-note"><?php echo $aplication_description; ?></p>
                </aside>
                <main class="login-panel">
                    <div class="login-main">
                        <div class="login-card">
                            <div class="card-head">
                                <p class="login-intro mb-0">Silahkan Masukan Email Dan Password Anda Untuk Masuk Ke Sistem</p>
                            </div>
                            <form id="ProsesLogin" class="login-form" autocomplete="off" onsubmit="return false;">
                                <input type="hidden" name="id_captcha" id="id_captcha" value="">
                                <div class="form-field">
                                    <label for="email" class="form-label">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                        <input type="email" name="email" id="email" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-field">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group password-group">
                                        <span class="input-group-text"><i class="bi bi-key"></i></span>
                                        <input type="password" name="password" id="password" class="form-control" required>
                                        <input class="visually-hidden" type="checkbox" value="Ya" id="TampilkanPassword" name="TampilkanPassword">
                                        <label class="password-toggle" for="TampilkanPassword" aria-label="Tampilkan Password">
                                            <i class="bi bi-eye"></i>
                                        </label>
                                    </div>
                                </div>
                                <div class="captcha-field">
                                    <div class="captcha-frame">
                                        <img src="" alt="Captcha" id="GetUrlCaptcha">
                                        <button type="button" class="captcha-reload" id="ReloadCaptcha" aria-label="Muat ulang captcha" title="Muat ulang captcha">
                                            <i class="bi bi-arrow-clockwise"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="form-field captcha-input">
                                    <label for="captcha" class="form-label">Captcha</label>
                                    <input type="text" class="form-control" id="captcha" name="captcha" required>
                                </div>
                                <div id="NotifikasiLogin"></div>
                                <button type="submit" class="btn btn-primary login-submit" id="button_login">Login</button>
                                <div class="login-divider">Atau</div>
                                <a href="_Page/Login/LoginGoogle.php" class="btn btn-google">
                                    <i class="bi bi-google"></i> Login Dengan Google
                                </a>
                                <button type="button" class="login-text-link access-link" id="modal_pengajuan_akses">
                                    Belum Punya Akun? <strong>Kirim Pengajuan Akses</strong>
                                </button>
                                <button type="button" class="login-text-link reset-link" id="modal_reset_password">Lupa Password</button>
                            </form>
                        </div>
                    </div>
                    <footer class="login-footer">
                        <small><?php echo $aplication_name; ?> &copy; <?php echo date('Y'); ?> <?php echo $aplication_author; ?>. All rights reserved.</small>
                    </footer>
                </main>
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
