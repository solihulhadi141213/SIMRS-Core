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
                            <i class="ti-pencil-alt"></i> Edit Poliklinik</a>
                        </h5>
                        <p class="m-b-0">Update Informasi Poliklinik dan Pernyataan Pelayanan</p>
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
                            <form action="javascript:void(0);" id="ProsesEditPoliklinik" autocomplete="off">
                                <input type="hidden" name="id_poliklinik" id="id_poliklinik" value="<?php echo "$id_poliklinik"; ?>">
                                <div class="card">
                                    <div class="card-header">
                                        <h5><dt> Form Edit Poliklinik</dt></h5>
                                        <a href="javascript:void(0);" id="EditDeskripsi" class="text-primary">
                                            (Mulai Edit)
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col col-md-4">
                                                <label for="nama"><dt>Kode-Nama Poliklinik</dt></label>
                                                <input type="text" readonly name="nama" id="nama" list="ListNamaPoli" class="form-control" value="<?php echo "$kode-$nama"; ?>">
                                                <datalist id="ListNamaPoli"></datalist>
                                                <small>Contoh Format: OBG-OBGYN</small>
                                            </div>
                                            <div class="col col-md-4">
                                                <label for="koordinator"><dt>Koordinator</dt></label>
                                                <input type="text" readonly name="koordinator" id="koordinator" class="form-control" value="<?php echo "$koordinator"; ?>">
                                            </div>
                                            <div class="col col-md-4">
                                                <label for="status"><dt>Status</dt></label>
                                                <select readonly name="status" id="status" class="form-control">
                                                    <option <?php if($status=="Aktif"){echo "selected";} ?> value="Aktif">Aktif</option>
                                                    <option <?php if($status=="Non-Aktif"){echo "selected";} ?> value="Non-Aktif">Non-Aktif</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 mt-3">
                                                <label for=""><dt>Deskripsi</dt></label>
                                                <?php echo "<div id='IsiKonten'>$deskripsi</div>";?>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col col-md-12" id="NotifikasiEdit">
                                                <span class="text-primary">
                                                    <dt>Keterangan : </dt> Pastikan Data Poliklinik Yang Anda Input Sudah Benar!
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="button" disabled class="btn btn-md btn-info" id="ClickUpdate">
                                            <i class="ti-save"></i> Simpan
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="styleSelector">

            </div>
        </div>
    </div>
    <script>
        
    </script>
<?php } ?>