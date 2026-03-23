<?php
//Desiossion Akses
$StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'8prgG5vbhC');
if($StatusAkses=="Yes"){
    if(empty($_GET['Sub'])){
        $Sub="";
    }else{
        $Sub=$_GET['Sub'];
    }
?>
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="index.php?Page=KelasRuangan" class="h5">
                            <i class="icofont-hospital"></i> Kelas & Ruangan
                        </a>
                    </h5>
                    <p class="m-b-0">Kelola data ketersediaan tempat tidur, ruangan dan kelas.</p>
                </div>
            </div>
            <div class="col-md-6 text-right">
                <a href="index.php?Page=KelasRuangan" class="btn btn-md <?php if($Sub==""){echo "btn-info";}else{echo "btn-primary";} ?> mr-2 mt-2">
                    <i class="icofont-hospital"></i> Data RS
                </a>
                <a href="index.php?Page=KelasRuangan&Sub=Aplicare"  class="btn btn-md <?php if($Sub=="Aplicare"){echo "btn-info";}else{echo "btn-primary";} ?> mr-2 mt-2">
                    <i class="icofont-table"></i> Aplicare
                </a>
                <a href="index.php?Page=KelasRuangan&Sub=Autoupdate"  class="btn btn-md <?php if($Sub=="Autoupdate"){echo "btn-info";}else{echo "btn-primary";} ?> mr-2 mt-2">
                    <i class="ti ti-reload text-white"></i> Autoupdate
                </a>
            </div>
        </div>
    </div>
</div>
<div class="pcoded-inner-content">
    <div class="main-body">
        <?php
            if(empty($_GET['Sub'])){
                include "_Page/KelasRuangan/KelasRuanganRs.php";
            }else{
                $Sub=$_GET['Sub'];
                if($Sub=="Aplicare"){
                    include "_Page/KelasRuangan/Aplicare.php";
                }else{
                    if($Sub=="Autoupdate"){
                        include "_Page/KelasRuangan/Autoupdate.php";
                    }else{
                        
                    }
                }
                
            }
        ?>
    </div>
</div>
<?php
}else{
    include "_Page/UnPage/ErrorPage.php";
}
?>