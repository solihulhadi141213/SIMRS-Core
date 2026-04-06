<?php
    // Zona Waktu
    date_default_timezone_set('Asia/Jakarta');

    // Koneksi
    include "_Config/Connection.php";

    // Include Setting
    include "_Config/SettingGeneral.php";

    // Simrs Function
    include "_Config/SimrsFunction.php";

    // Session
    include "_Config/Session.php";

    // Jika Sesi Akses Belum Ada Maka Redirect
    if(empty($SessionIdAkses)||empty($SessionNama)){
        include "_Page/Login/login.php";
        exit;
    }

    if(empty($SessionGambar)){
        $LinkFotoProfile="avatar-blank.jpg";
    }else{
        $LinkFotoProfile="user/$SessionGambar";
    }

    // Routing Page
    if(!empty($_GET['Page'])){
        $Page=$_GET['Page'];
    }else{
        $Page="";
    }
    if(!empty($_GET['Sub'])){
        $Sub=$_GET['Sub'];
    }else{
        $Sub="";
    }
?>
<!DOCTYPE html>
<html lang="en">
    <?php
        include "_Partial/Head.php";
    ?>
    <body>
        <?php
            // Untuk menampilkan Pre Loader Disini
            include "_Partial/PreLoader.php";
        ?>
        <div id="pcoded" class="pcoded">
            <div class="pcoded-overlay-box"></div>
            <div class="pcoded-container navbar-wrapper">
                <nav class="navbar header-navbar pcoded-header bg-primary">
                    <div class="navbar-wrapper">
                        <div class="navbar-logo">
                            <a class="mobile-menu waves-effect waves-light" id="mobile-collapse" href="javascript:void(0);">
                                <i class="ti-menu"></i>
                            </a>
                            <a href="index.php" class="">
                                <h4><?php echo "$hospital_name"; ?></h4>
                            </a>
                            <a class="mobile-options waves-effect waves-light">
                                <i class="ti-more"></i>
                            </a>
                        </div>
                        <div class="navbar-container container-fluid">
                            <ul class="nav-left">
                                <li>
                                    <div class="sidebar_toggle"><a href="javascript:void(0)"><i class="ti-menu"></i></a></div>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" onclick="javascript:toggleFullScreen()" class="waves-effect waves-light">
                                        <i class="ti-fullscreen"></i>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav-right">
                                <?php
                                    //Menampilkan Dropdown Notifikasi
                                    include "_Partial/Notification.php";
                                ?>

                                <!-- Menampilkan Dropdown Profil -->
                                <li class="user-profile header-notification">
                                    <a href="javascript:void(0);" class="waves-effect waves-light">
                                        <img src="assets/images/<?php echo $LinkFotoProfile;?>" class="img-radius" width="45px" alt="User-Profile-Image">
                                        <span><?php echo $SessionNama;?></span>
                                        <i class="ti-angle-down"></i>
                                    </a>
                                    <ul class="show-notification profile-notification">
                                        <li class="waves-effect waves-light border-bottom border-1 border-bottom-default">
                                            <a href="index.php?Page=Profile" class="p-2 is-hover">
                                                <i class="ti-user"></i> Profile
                                            </a>
                                        </li>
                                        <li class="waves-effect waves-light border-bottom border-1 border-bottom-default">
                                            <a href="index.php?Page=Help" class="p-2 is-hover">
                                                <i class="icofont-question-circle"></i></i> Bantuan
                                            </a>
                                        </li>
                                        <li class="waves-effect waves-light border-bottom border-1 border-bottom-default">
                                            <a href="javascript:void(0);" class="p-2 is-hover" data-bs-toggle="modal" data-bs-target="#ModalLogout">
                                                <i class="ti-lock"></i> Logout
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <!-- Menampilkan Dropdown Profil / END -->
                            </ul>
                        </div>
                    </div>
                </nav>
                <div class="pcoded-main-container">
                    <div class="pcoded-wrapper">
                        <nav class="pcoded-navbar">
                            <?php
                                // Menampilkan Menu Kiri
                                include "_Partial/Menu.php";
                            ?>
                        </nav>
                        <div class="pcoded-content">
                            <?php
                                // Routing Halaman
                                include "_Partial/RoutingPage.php";
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>   
        <?php
            // Footer JS
            include "_Partial/FooterJs.php";

            //Routing Modal
            include "_Partial/Modal.php";

            // Include Toast
            include "_Partial/Toast.php";

            //Routing Page JS
            include "_Partial/RoutingJs.php";

            //RoutingSwall
            include "_Partial/RoutingSwal.php";
        ?>

        <footer class="text-right">
            <?php
                include "_Partial/Copyright.php";
            ?>
        </footer>
    </body>
    
</html>