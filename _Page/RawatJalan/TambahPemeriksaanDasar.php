<?php
    include "_Config/SimrsFunction.php"; 
    
    //Tangkap ID
    if(empty($_GET['id_kunjungan'])){
        echo '<span class="text-danger">ID Kunjungan Tidak Boleh Kosong!</span>';
    }else{
        $id_kunjungan=$_GET['id_kunjungan'];
        if(empty($_SESSION['UrlBackPemeriksaanDasar'])){
            $UrlBack='index.php?Page=RawatJalan';
        }else{
            $UrlBack=$_SESSION['UrlBackPemeriksaanDasar'];
        }
        //Membuka data antrian
        $id_pasien=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'id_pasien');
        $nama=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'nama');
        //Tanggal sekarang
        $tanggal=date('Y-m-d');
        $jam=date('H:i');
?>
<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="javascript:void(0);" id="ProsesTambahPemeriksaanDasar" autocomplete="off">
                            <input type="hidden" name="UrlForBack" id="UrlForBack" value="<?php echo "$UrlBack"; ?>">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-10 mb-2">
                                            <h4>
                                                <i class="ti ti-plus"></i> Form Tambah Sesi Pemeriksaan Fisik
                                            </h4>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <a href="<?php echo $UrlBack;?>" class="btn btn-sm btn-secondary btn-block">
                                                <i class="ti ti-angle-left"></i> Kembali
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="id_kunjungan">ID Kunjungan (No.Reg)</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" id="id_kunjungan" name="id_kunjungan" value="<?php echo "$id_kunjungan"; ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="id_pasien">No.RM Pasien</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" id="id_pasien" name="id_pasien" value="<?php echo "$id_pasien"; ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="nama_pasien">Nama Pasien</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" id="nama_pasien" name="nama_pasien" value="<?php echo "$nama"; ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4 mb-2">
                                            <label for="tanggal">Tanggal/Jam Pemeriksaan</label>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?php echo "$tanggal"; ?>">
                                            <small>Tanggal Pemeriksaan</small>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <input type="time" class="form-control" id="jam" name="jam" value="<?php echo "$jam"; ?>">
                                            <small>Jam Pemeriksaan</small>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="id_dokter">Dokter Pemeriksa</label>
                                        </div>
                                        <div class="col-md-8">
                                            <select class="form-control" id="id_dokter" name="id_dokter">
                                                <option value="">Pilih</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3 mt-3">
                                        <div class="col-md-4">
                                            <label for="anatomi">Anatomi</label>
                                        </div>
                                        <div class="col-md-8">
                                            <!-- <img src="assets\images\avatar-1.jpg" alt="" width="100%"> -->
                                            <canvas id="anatomi-pad" class="anatomi-pad" width="100%" style="background: url('https://initu.id/wp-content/uploads/2017/09/Keajaiban-Anatomi-Tubuh-Manusia-Jika-Anda-Mengerti-Maka-Tidak-Layak-Sombong.jpg') no-repeat; ">
                                                
                                            </canvas>
                                        </div>
                                        <div class="col-md-4"></div>
                                        <div class="col-md-8 text-center">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-outline-dark" id="change-color">
                                                    <i class="icofont-paint"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-dark" id="undo">
                                                    <i class="icofont-undo"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-dark" id="clear">
                                                    <i class="ti ti-close"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-dark" id="addImage">
                                                    <i class="ti ti-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3 mt-3">
                                        <div class="col-md-4">
                                            <label for="gambaran_umum">Gambaran Umum</label>
                                        </div>
                                        <div class="col-md-8">
                                            <textarea class="form-control" id="gambaran_umum" name="gambaran_umum"></textarea>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12" id="NotifikasiTambahPemeriksaanDasar">
                                            <span class="text-primary">
                                                <dt>Keterangan : </dt> Pastikan Data Pemeriksaan Dasar Yang Anda Input Sudah Benar!
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="ti-save"></i> Simpan Pemeriksaan Dasar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>