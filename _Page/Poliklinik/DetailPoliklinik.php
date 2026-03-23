<?php
    if(empty($_GET['id'])){
        include "_Page/Poliklinik/NoPage.php";
    }else{
        $id_poliklinik=$_GET['id'];
        //Membuka detail halaman poliklinik
        $QryPoliklinik = mysqli_query($Conn,"SELECT * FROM poliklinik WHERE id_poliklinik='$id_poliklinik'")or die(mysqli_error($Conn));
        $DataPoliklinik = mysqli_fetch_array($QryPoliklinik);
        $nama = $DataPoliklinik['nama'];
        $koordinator= $DataPoliklinik['koordinator'];
        $deskripsi= $DataPoliklinik['deskripsi'];
        $kode= $DataPoliklinik['kode'];
        $status= $DataPoliklinik['status'];
?>
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h5 class="m-b-10"><a href="index.php?Page=Poliklinik" class="h5">
                            <i class="icofont-icu"></i> Detail Poliklinik</a>
                        </h5>
                        <p class="m-b-0">Lihat <i>Preview</i> Informasi Poliklinik dan Pernyataan Pelayanan</p>
                    </div>
                </div>
                <div class="col-md-4 text-right">
                    <a href="index.php?Page=Poliklinik" class="btn btn-md btn-inverse mr-2 mt-2">
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
                                    <h5><dt> <?php echo "$nama"; ?></dt></h5><br>
                                    <small>Kode Poli : <?php echo "$kode"; ?></small><br>
                                    <small>Koordinator : <?php echo "$koordinator"; ?></small><br>
                                    <small>Status : <?php echo "$status"; ?></small><br>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col col-md-12">
                                            <?php echo "$deskripsi"; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <a href="index.php?Page=Poliklinik&Sub=EditPoliklinik&id=<?php echo "$id_poliklinik"; ?>" class="btn btn-md btn-primary mt-2 mr-2">
                                        <i class="ti-save"></i> Edit
                                    </a>
                                    <button type="button" class="btn btn-md btn-danger mt-2 mr-2" data-toggle="modal" data-target="#ModalDeletePoliklinik" data-id="<?php echo "$id_poliklinik"; ?>">
                                        <i class="ti-trash"></i> Delete
                                    </button>
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