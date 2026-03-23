<?php
    if(empty($_GET['Sub'])){
        $Sub="";
    }else{
        $Sub=$_GET['Sub'];
    }
?>
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10"><a href="" class="h5"><i class="icofont-ui-social-link"></i> Referensi</a></h5>
                    <p class="m-b-0">Kelola Data Referensi Dan Kelengkapan Rumah Sakit</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12 mb-3 text-center">
                                <h4><i class="icofont-connection"></i> Referensi Satu Sehat</h4>
                                Semua referensi yang berasal dari plaform satu sehat
                            </div>
                        </div>
                        <div class="row">
                            <div class="col col-md-12 text-center">
                                <div class="btn btn-group">
                                    <a href="index.php?Page=Kfa" class="btn btn-md <?php if(empty($Sub)){echo "btn-secondary";}else{echo "btn-outline-secondary";} ?>" title="Kamus Farmasi & Alkes">
                                        <i class="icofont-drug"></i> KFA
                                    </a>
                                    <a href="index.php?Page=Kfa&Sub=MsiHome" class="btn btn-md <?php if($Sub=="MsiHome"){echo "btn-secondary";}else{echo "btn-outline-secondary";} ?>" title="Master Saraa Index">
                                        <i class="icofont-box"></i> MSI
                                    </a>
                                    <a href="index.php?Page=Kfa&Sub=WilayahHome" class="btn btn-md <?php if($Sub=="WilayahHome"){echo "btn-secondary";}else{echo "btn-outline-secondary";} ?>" title="Master Wilayah">
                                        <i class="ti ti-map-alt"></i> Wilayah
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    if(empty($Sub)){
                        include "_Page/Kfa/KfaHome.php";
                    }else{
                        if($Sub=="MsiHome"){
                            include "_Page/Kfa/MsiHome.php";
                        }else{
                            if($Sub=="WilayahHome"){
                                include "_Page/Kfa/WilayahHome.php";
                            }else{
                                include "_Page/Kfa/KfaHome.php";
                            }
                        }
                    }
                ?>
            </div>
        </div>
    </div>
</div>
