<?php
    if(empty($_GET['id'])){
        include "_Page/Bantuan/NoPage.php";
    }else{
        $id_bantuan=$_GET['id'];
        //Membuka detail halaman poliklinik
        $QryBantuan = mysqli_query($Conn,"SELECT * FROM bantuan WHERE id_bantuan='$id_bantuan'")or die(mysqli_error($Conn));
        $DataBantuan = mysqli_fetch_array($QryBantuan);
        $judul = $DataBantuan['judul'];
        $tanggal= $DataBantuan['tanggal'];
        $kategori= $DataBantuan['kategori'];
        $isi= $DataBantuan['isi'];
?>
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h5 class="m-b-10"><a href="index.php?Page=Bantuan" class="h5">
                            <i class="ti ti-help-alt"></i> Detail Bantuan</a>
                        </h5>
                        <p class="m-b-0">Lihat Bantuan Selengkapnya</p>
                    </div>
                </div>
                <div class="col-md-4 text-right">
                    <a href="index.php?Page=Bantuan" class="btn btn-md btn-inverse mr-2 mt-2">
                        <i class="ti-arrow-circle-left text-white"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5><dt> <?php echo "$judul"; ?></dt></h5><br>
                                    <small><i class="ti ti-calendar"></i> <?php echo "$tanggal"; ?></small><br>
                                    <small><i class="ti ti-tag"></i> <?php echo "$kategori"; ?></small><br>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col col-md-12">
                                            <?php echo "$isi"; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <?php if($SessionAkses=="Admin"){ ?>
                                        <a href="index.php?Page=Bantuan&Sub=EditBantuan&id=<?php echo "$id_bantuan"; ?>" class="btn btn-md btn-primary mt-2 mr-2">
                                            <i class="ti-save"></i> Edit
                                        </a>
                                        <button type="button" class="btn btn-md btn-danger mt-2 mr-2" data-toggle="modal" data-target="#ModalDeleteBantuan" data-id="<?php echo "$id_bantuan"; ?>">
                                            <i class="ti-trash"></i> Delete
                                        </button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="styleSelector">

            </div>
        </div>
    </div>
<?php } ?>