<?php
    session_start();
    include "_Config/Connection.php";
    include "_Config/Setting.php";
    include "_Config/SettingFaskes.php";
    // if(!empty($_SESSION['id_akses'])&&!empty($_SESSION['email'])){
    //     header('Location:index.php');
    // }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo "Login-$judul_tab";?></title>
        <!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 10]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <!-- Meta -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="description" content="<?php echo "$judul_tab";?>" />
        <meta name="keywords" content="<?php echo "$NamaFaskes";?>" />
        <meta name="author" content="Solihul Hadi" />
        <script src="assets/js/html5shiv.js"></script>
        <script src="assets/js/respond.min.js"></script>
        <!-- Favicon icon -->
        <link rel="icon" href="assets/images/<?php echo "$favicon"; ?>" type="image/x-icon">
        <!-- Google font-->
        <link href="assets/css/Fonts/Fonts.css" rel="stylesheet">
        <!-- waves.css -->
        <link rel="stylesheet" href="assets/pages/waves/css/waves.min.css" type="text/css" media="all">
        <!-- Required Fremwork -->
        <link rel="stylesheet" type="text/css" href="assets/css/bootstrap/css/bootstrap.min.css">
        <!-- waves.css -->
        <link rel="stylesheet" href="assets/pages/waves/css/waves.min.css" type="text/css" media="all">
        <!-- themify icon -->
        <link rel="stylesheet" type="text/css" href="assets/icon/themify-icons/themify-icons.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" type="text/css" href="assets/icon/font-awesome/css/font-awesome.min.css">
        <!-- scrollbar.css -->
        <link rel="stylesheet" type="text/css" href="assets/css/jquery.mCustomScrollbar.css">
        <!-- am chart export.css -->
        <link rel="stylesheet" href="assets/css/amcharts.css" type="text/css" media="all" />
        <!-- Style.css -->
        <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    </head>
            
    <body themebg-pattern="theme1">
        <!-- Pre-loader start -->
        <div class="theme-loader">
            <div class="loader-track">
                <div class="preloader-wrapper">
                    <div class="spinner-layer spinner-blue">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="gap-patch">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                    <div class="spinner-layer spinner-red">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="gap-patch">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                    
                    <div class="spinner-layer spinner-yellow">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="gap-patch">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                    <div class="spinner-layer spinner-green">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="gap-patch">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pre-loader end -->
        <section class="login-block">
            <!-- Container-fluid starts -->
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <form action="javascript:void(0);" id="ProsesLogin">
                            <div class="text-center text-white">
                                <img class="img-80" src="assets/images/<?php echo "$logo"; ?>" alt="User-Profile-Image mb-3">
                                <h4 class="mt-3"><?php echo "Selamat Datang Di $NamaFaskes";?></h4>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    <div class="card">
                                        <div class="card-block">
                                            <div class="row m-b-20">
                                                <div class="col-md-12">
                                                    <h4 class="text-center">
                                                        <i class="fa fa-lock"></i> Login Ke Akun Anda
                                                    </h4>
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <div class="col-md-12">
                                                    <label for="email">Alamat Email</label>
                                                    <input type="email" name="email" id="email" class="form-control" required="">
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <div class="col-md-12">
                                                    <label for="password">Password</label>
                                                    <input type="password" name="password" id="password" class="form-control" required="">
                                                    <small>
                                                        <input type="checkbox" name="TampilkanPassword" id="TampilkanPassword" value="Ya">
                                                        <label for="TampilkanPassword">Tampilkan Password</label>
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <div class="col-md-12 text-center">
                                                    <img src="" alt="captcha" width="100%" id="GetUrlCaptcha" /><br>
                                                    <a href="javascript:void(0);" id="ReloadCaptcha" class="text-danger">
                                                        <i class="ti ti-reload"></i> Reload Captcha
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control" id="captcha" name="captcha">
                                                    <small class="text-muted">Masukan kode captcha dari gambar di atas</small>
                                                </div>
                                            </div>
                                            <div class="row m-t-25 text-left">
                                                <div class="col-12" id="NotifikasiLogin">
                                                </div>
                                            </div>
                                            <div class="row m-t-30">
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-primary btn-md btn-block btn-round">
                                                        <i class="ti ti-key"></i> Login
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <h5 class="">
                                                        Kebijakan Pengguna
                                                    </h5>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    Sebagai pemegang akun akses SIMRS (Sistem Informasi Manajemen Rumah Sakit), Anda memiliki kewajiban tertentu. 
                                                    Berikut adalah beberapa kewajiban yang pelu anda ketahui :
                                                    <ol>
                                                        <li>
                                                            Anda wajib menjaga kerahasiaan informasi pasien dan tidak membocorkan informasi medis kepada pihak yang tidak berwenang.
                                                        </li>
                                                        <li>
                                                            Anda wajib menggunakan akses SIMRS dengan bertanggung jawab, 
                                                            termasuk menghindari penggunaan yang melanggar hukum, merugikan pasien, 
                                                            atau melanggar kebijakan rumah sakit.
                                                        </li>
                                                        <li>
                                                            Anda wajib melaporkan masalah keamanan atau pelanggaran privasi yang terkait dengan SIMRS kepada administrator 
                                                            atau pihak yang berwenang di rumah sakit.
                                                        </li>
                                                        <li>
                                                            Anda wajib menjaga dan meningkatkan pengetahuan dan keahlian Anda dalam menggunakan SIMRS agar 
                                                            dapat memberikan pelayanan yang terbaik kepada pasien.
                                                        </li>
                                                        <li>
                                                            Anda wajib mematuhi semua peraturan dan kebijakan yang berlaku di rumah sakit terkait dengan penggunaan SIMRS.
                                                        </li>
                                                    </ol>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <h5 class="">Pengajuan Akses</h5>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    Bagi anda yang belum punya akun akses, dapat mengajukan permohonan akses untuk menggunakan aplikasi melalui tautan berikut ini.
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <a href="PengajuanAkses.php" class="btn btn-sm btn-outline-primary btn-block">
                                                        <i class="ti ti-pencil-alt"></i> Pengajuan Akses
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- end of row -->
            </div>
            <!-- end of container-fluid -->
        </section>
        <!-- Required Jquery -->
        <script type="text/javascript" src="assets/js/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="assets/js/jquery-ui/jquery-ui.min.js "></script>
        <script type="text/javascript" src="assets/js/popper.js/popper.min.js"></script>
        <script type="text/javascript" src="assets/js/bootstrap/js/bootstrap.min.js "></script>
        <script type="text/javascript" src="assets/pages/widget/excanvas.js "></script>
        <!-- waves js -->
        <script src="assets/pages/waves/js/waves.min.js"></script>
        <!-- jquery slimscroll js -->
        <script type="text/javascript" src="assets/js/jquery-slimscroll/jquery.slimscroll.js "></script>
        <!-- modernizr js -->
        <script type="text/javascript" src="assets/js/modernizr/modernizr.js "></script>
        <!-- slimscroll js -->
        <script type="text/javascript" src="assets/js/SmoothScroll.js"></script>
        <script src="assets/js/jquery.mCustomScrollbar.concat.min.js "></script>
        <!-- Chart js -->
        <script type="text/javascript" src="assets/js/chart.js/Chart.js"></script>
        <!-- amchart js -->
        <script src="assets/pages/widget/amchart/amcharts.js"></script>
        <script src="assets/pages/widget/amchart/gauge.js"></script>
        <script src="assets/pages/widget/amchart/serial.js"></script>
        <script src="assets/pages/widget/amchart/light.js"></script>
        <script src="assets/pages/widget/amchart/pie.min.js"></script>
        <script src="assets/pages/widget/amchart/export.min.js"></script>
        <!-- menu js -->
        <script src="assets/js/pcoded.min.js"></script>
        <script src="assets/js/vertical-layout.min.js "></script>
        <!-- custom js -->
        <script type="text/javascript" src="assets/pages/dashboard/custom-dashboard.js"></script>
        <!-- Tombol Melayang -->
        <script type="text/javascript" src="assets/js/script.js"></script>
        <script type="text/javascript" src="_Page/Login/Login.js"></script>
    </body>
    <footer>
        Dibuat Oleh:
    </footer>
</html>
