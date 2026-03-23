<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10"><a href="index.php?Page=ProfileUser&Sub=MyProfile" class="h5">My Profile</a></h5>
                    <p class="m-b-0">Kelola informasi akses, identitas dan riwayat aktivitas anda</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <?php
                    //Menangkpa Subpages
                    if(empty($_GET['Sub'])){
                        include "_Page/ProfileUser/MyProfile.php";
                    }else{
                        $Sub=$_GET['Sub'];
                        if($Sub=="LaporanPengguna"){
                            include "_Page/ProfileUser/LaporanPengguna.php";
                        }else{
                            if($Sub=="MyLog"){
                                include "_Page/ProfileUser/MyLog.php";
                            }else{
                                include "_Page/ProfileUser/MyProfile.php";
                            }
                        }
                    }
                ?>
            </div>
        </div>
    </div>
</div>
