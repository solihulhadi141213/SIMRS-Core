<?php
    date_default_timezone_set('Asia/Jakarta');
    include "_Config/Connection.php";
    include "_Config/Session.php";
    include "_Config/SettingGeneral.php";
    include "_Config/SettingAkses.php";
    include "_Config/SettingFaskes.php";
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
                            <div class="mobile-search waves-effect waves-light">
                                <div class="header-search">
                                    <div class="main-search morphsearch-search">
                                        <div class="input-group">
                                            <form action="index.php" method="GET">
                                                <span class="input-group-addon search-close"><i class="ti-close"></i></span>
                                                <input type="text" class="form-control" placeholder="cari Bantuan">
                                                <button type="submit" class="input-group-addon search-btn"><i class="ti-search"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="index.php">
                                <h4><b><?php echo "$hospital_name"; ?></b></h4>
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
                                <li class="header-search">
                                    <div class="main-search morphsearch-search">
                                        <form action="index.php" method="GET">
                                            <input type="hidden" name="Page" value="Help">
                                            <div class="input-group">
                                                <span class="input-group-addon search-close"><i class="ti-close"></i></span>
                                                <input type="text" id="KeywordBantuan" name="keyword" class="form-control" placeholder="Cari Bantuan">
                                                <button type="button" class="input-group-addon search-btn" id="PencarianBantuanAtas">
                                                    <i class="ti-search"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" onclick="javascript:toggleFullScreen()" class="waves-effect waves-light">
                                        <i class="ti-fullscreen"></i>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav-right">
                                <?php
                                    //Notifikasi bisa di aktifkan disini
                                    include "_Partial/Notification.php";
                                    //Profile
                                    include "_Partial/Profile.php";
                                ?>
                            </ul>
                        </div>
                    </div>
                </nav>
                <div class="pcoded-main-container">
                    <div class="pcoded-wrapper">
                        <nav class="pcoded-navbar">
                            <?php
                                include "_Partial/Menu.php";
                            ?>
                        </nav>
                        <div class="pcoded-content">
                            <?php
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

            //Routing Page JS
            include "_Partial/RoutingJs.php";

            //RoutingSwall
            include "_Partial/RoutingSwal.php";
        ?>

        
    </body>
    <footer class="text-right">
        <?php
            include "_Partial/Copyright.php";
        ?>
    </footer>
</html>