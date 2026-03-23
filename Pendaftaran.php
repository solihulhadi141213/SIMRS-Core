<?php
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
                        <!-- Authentication card start -->
                            <div class="card mt-3">
                                <div class="card card-body">
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <h4>Selamat Datang Di Halaman Pendaftaran Online</h4>
                                            <img src="assets/images/<?php echo $logo;?>" width="100px">
                                            <h6 class="text-dark"><?php echo "<dt>$NamaFaskes</dt>";?></h6>
                                            <h6 class="text-dark"><?php echo "$AlamatFaskes";?></h6>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <a href="Pendaftaran.php?page=pendaftaran" class="btn btn-sm <?php if($page!=="DetailPendaftaranClient"&$page!=="history"&$page!=="bantuan"&$page!=="detail_bantuan"){echo "btn-outline-info";}else{echo "btn-outline-dark";} ?> mt-2">
                                                <i class="icofont-user-alt-2"></i> Pendaftaran
                                            </a>
                                            <a href="Pendaftaran.php?page=history" class="btn btn-sm <?php if($page=="history"||$page=="DetailPendaftaranClient"){echo "btn-outline-info";}else{echo "btn-outline-dark";} ?> mt-2">
                                                <i class="ti ti-search"></i> Cari
                                            </a>
                                            <a href="Pendaftaran.php?page=bantuan" class="btn btn-sm <?php if($page=="bantuan"||$page=="detail_bantuan"){echo "btn-outline-info";}else{echo "btn-outline-dark";} ?> mt-2">
                                                <i class="fa fa-question" aria-hidden="true"></i> Bantuan
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                    //routing page
                                    if(isset($_GET['page'])){
                                        $page = $_GET['page'];
                                        switch ($page) {
                                            case 'PasienLamaBaru':
                                                include "_Page/Pendaftaran/PasienLamaBaru.php";
                                                break;
                                            case 'PasienBpjsUmum':
                                                include "_Page/Pendaftaran/PasienBpjsUmum.php";
                                                break;
                                            case 'PendaftaranUmum':
                                                include "_Page/Pendaftaran/PendaftaranUmum.php";
                                                break;
                                            case 'PendaftaranBpjs':
                                                include "_Page/Pendaftaran/PendaftaranBpjs.php";
                                                break;
                                            case 'history':
                                                include "_Page/Pendaftaran/history.php";
                                                break;
                                            case 'FormPendaftaranPasienLama':
                                                include "_Page/Pendaftaran/FormPendaftaranPasienLama.php";
                                                break;
                                            case 'DetailPendaftaranClient':
                                                include "_Page/Pendaftaran/DetailPendaftaranClient.php";
                                                break;
                                            case 'bantuan':
                                                include "_Page/Pendaftaran/bantuan.php";
                                                break;
                                            case 'detail_bantuan':
                                                include "_Page/Pendaftaran/detail_bantuan.php";
                                                break;
                                            default:
                                                include "_Page/Pendaftaran/PasienLamaBaru.php";
                                                break;
                                        }
                                    }else{
                                        include "_Page/Pendaftaran/PasienLamaBaru.php";
                                    }
                                ?>
                            </div>
                            
                            <!-- end of form -->
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
        <?php
            include "_Page/Pendaftaran/PendaftaranJs.php";
        ?>
    </body>

</html>
