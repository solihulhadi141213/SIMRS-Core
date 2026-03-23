<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="ti ti-user"></i> Aksesibilitas</a>
                    </h5>
                    <p class="m-b-0">Kelola referensi fitur, entitas akses, akses user dan pengajuan akses</p>
                </div>
            </div>
            <!-- <div class="col-md-6 text-right">
                <button class="btn btn-md btn-inverse mr-2 mt-2" data-toggle="modal" data-target="#ModalTambahtAkses">
                    <i class="ti-plus text-white"></i> Tambah User
                </button>
                <a href="index.php?Page=Aksesibilitas" class="btn btn-md btn-info mr-2 mt-2">
                    <i class="ti-settings text-white"></i> Setting Akses
                </a>
            </div> -->
        </div>
    </div>
</div>
<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <?php
                    include "_Config/SimrsFunction.php";
                    if($Sub=="ReferensiFitur"){
                        include "_Page/Akses/ReferensiFitur.php";
                    }else{
                        if($Sub=="EntitasAkses"){
                            include "_Page/Akses/EntitasAkses.php";
                        }else{
                            if($Sub=="TambahEntitasAkses"){
                                include "_Page/Akses/TambahEntitasAkses.php";
                            }else{
                                if($Sub=="DetailEntitas"){
                                    include "_Page/Akses/DetailEntitas.php";
                                }else{
                                    if($Sub=="EditEntitas"){
                                        include "_Page/Akses/EditEntitas.php";
                                    }else{
                                        if($Sub=="AksesUser"){
                                            include "_Page/Akses/AksesUser.php";
                                        }else{
                                            if($Sub=="DetailAkses"){
                                                include "_Page/Akses/DetailAkses.php";
                                            }else{
                                                if($Sub=="PengajuanAkses"){
                                                    include "_Page/Akses/PengajuanAkses.php";
                                                }else{
                                                    if($Sub=="DetailPengajuanAkses"){
                                                        include "_Page/Akses/DetailPengajuanAkses.php";
                                                    }else{
                                                        include "_Page/Akses/AksesUser.php";
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                ?>
            </div>
        </div>
    </div>
</div>