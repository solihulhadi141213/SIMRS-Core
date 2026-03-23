<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5">
                            <i class="ti ti-help-alt"></i> Bantuan
                        </a>
                    </h5>
                    <p class="m-b-0">Kelola data konten bantuan secara dinamis untukl membantu pengguna memahami cara menggunakan aplikasi</p>
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
                    //Desiossion Akses
                    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'5fOBWxW2qn');
                    if($StatusAkses=="Yes"){
                        if(empty($_GET['Sub'])){
                            include "_Page/Bantuan/BantuanHome.php";
                        }else{
                            $Sub=$_GET['Sub'];
                            if($Sub=="TambahBantuan"){
                                include "_Page/Bantuan/TambahBantuan.php";
                            }else{
                                if($Sub=="EditBantuan"){
                                    include "_Page/Bantuan/EditBantuan.php";
                                }else{
                                    if($Sub=="DetailBantuan"){
                                        include "_Page/Bantuan/DetailBantuan.php";
                                    }else{
                                        include "_Page/Bantuan/BantuanHome.php";
                                    }
                                }
                            }
                        }
                    }else{
                        include "_Page/UnPage/ErrorPage.php";
                    }


                ?>
            </div>
        </div>
    </div>
</div>
