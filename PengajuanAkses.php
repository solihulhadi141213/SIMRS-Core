<?php
    session_start();
    include "_Config/Connection.php";
    include "_Config/Setting.php";
    include "_Config/SettingFaskes.php";
    if(empty($_GET['page'])){
        $page="";
    }else{
        $page = $_GET['page'];
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo "$judul_tab";?></title>
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
        <script src="assets/tinymce/tinymce.min.js"></script>
        <script src="assets/sweetalert2/dist/sweetalert2.all.min.js"></script>
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
        <link rel="stylesheet" type="text/css" href="assets/icon/icofont/icofont.min.css">
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
        <section class="register-block">
            <!-- Container-fluid starts -->
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <form action="javascript:void(0);" id="ProsesPengajuanAkses">
                            <div class="card mt-3">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <a href="">
                                                <h4><i class="ti-email"></i> Form Pengajuan Akses </h4>
                                            </a>
                                            <p>
                                                Isi form berikut ini dengan lengkap dan benar.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-4">
                                        <div class="col-md-3">
                                            <label for="nama"><dt>Nama Lengkap</dt></label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="nama" name="nama">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-3">
                                            <label for="nik"><dt>Nomor KTP/NIK</dt></label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="nik" name="nik">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-3">
                                            <label for="kontak"><dt>Nomor Kontak</dt></label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="kontak" name="kontak" placeholder="62">
                                            <small class="text-muted">Gunakan nomor kontak yang valid, karena mungkin tim validator kami akan menghubungi anda.</small>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-3">
                                            <label for="email"><dt>Alamat Email</dt></label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="email" class="form-control" id="email" name="email" placeholder="email@domain.com">
                                            <small class="text-muted">Gunakan email yang valid, karena kami akan mengirim informasi status akses ke email tersebut</small>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-3">
                                            <label for="alamat"><dt>Alamat Tinggal</dt></label>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea name="alamat" id="alamat" class="form-control" cols="30" rows="3"></textarea>
                                            <small class="text-muted">Maksimal 200 karakter</small>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-3">
                                            <label for="deskripsi">
                                                <dt>Kebutuhan Akses</dt>
                                                <small class="text-muted">Jelaskan secara singkat kebutuhan akses informasi dan penggunaan aplikasi</small>
                                            </label>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea name="deskripsi" id="deskripsi" class="form-control" cols="30" rows="3"></textarea>
                                            <small class="text-muted">Maksimal 200 karakter</small>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-3">
                                            <label for="email"><dt>Pas Foto</dt></label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="file" class="form-control" id="foto" name="foto">
                                            <small class="text-muted">Gunakan foto jelas diri anda dengan format JPG, JPEG, GIF atau PNG (maksimal 2 mb)</small>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-3">
                                        </div>
                                        <div class="col-md-3">
                                            <span id="GambarCaptchaDisini">
                                                <img src="_Page/Akses/Captcha.php" alt="captcha" width="100%" id="ViewCaptcha" />
                                            </span>
                                            <small id="GetDigitHere"></small>
                                            <a href="javascript:void(0);" id="ReloadGambarCaptcha">
                                                <i class="ti ti-reload"></i> Reload Gambar
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-3">
                                            <label for="captcha"><dt>Kode Captcha</dt></label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="captcha" name="captcha">
                                            <small class="text-muted">Masukan kode captcha dari gambar di atas</small>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-3">
                                        </div>
                                        <div class="col-md-9">
                                            <small class="text-muted">
                                                Dengan ini saya menyatakan dengan sesungguhnya bahwa semua informasi yang disampaikan dalam seluruh 
                                                dokumen serta lampiran-lampirannya ini adalah benar dan kesatuan yang tidak dapat dipisahkan. 
                                                Apabila diketemukan dan/atau dibuktikan adanya penipuan/pemalsuan atas informasi yang kami sampaikan, 
                                                maka kami bersedia dikenakan dan menerima penerapan sanksi.
                                            </small>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-3">
                                        </div>
                                        <div class="col-md-9" id="NotifikasiPengajuanAkses">
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <button type="submit" class="btn btn-md btn-primary btn-block mb-3">
                                                <i class="icofont-send-mail"></i> Kirim Pengajuan
                                            </button>
                                            <p>
                                                <a href="Login.php" class="text-success">Kembali Ke Halaman Login</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- end of col-sm-12 -->
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
        <script type="text/javascript" src="assets/js/script.js "></script>
        <script type="text/javascript" src="_Page/Akses/Akses.js"></script>
        <?php
            if(empty($_SESSION['NotifikasiSwal'])){
                $NotifikasiSwal="";
            }else{
                $NotifikasiSwal=$_SESSION['NotifikasiSwal'];
            }
            include "_Page/Akses/NotifikasiAkses.php";
            unset($_SESSION['NotifikasiSwal']);
        ?>
    </body>

</html>
