<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="icofont-doctor-alt"></i> Nakes Terinfeksi</a>
                    </h5>
                    <p class="m-b-0">Berikut ini halaman untuk mengelola data </p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    if(!empty($_GET['Sub'])){
        $SubPage=$_GET['Sub'];
        if($SubPage=="DetailNakesTerinfeksi"){
            include "_Page/SirsOnlineNakesTerinfeksi/DetailNakesTerinfeksi.php";
        }else{
            include "_Page/SirsOnlineNakesTerinfeksi/SirsOnlineNakesTerinfeksiHome.php";
        }
    }else{
        include "_Page/SirsOnlineNakesTerinfeksi/SirsOnlineNakesTerinfeksiHome.php";
    }
?>