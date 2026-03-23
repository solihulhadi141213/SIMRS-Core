<?php
    //Apabila memperoleh parameter Get id_kunjungan
    if(!empty($_GET['id_kunjungan'])){
        $id_kunjungan=$_GET['id_kunjungan'];
        $id_pasien=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_pasien');
        $NamaPasien=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'nama');
        $TujuanKunjungan=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'tujuan');
    }else{
        $id_kunjungan="";
        $id_pasien="";
        $NamaPasien="";
        $TujuanKunjungan="";
    }
    if(empty($_SESSION['UrlBackLab'])){
        $UrlBack="index.php?Page=Laboratorium&Sub=PermintaanLab";
    }else{
        $UrlBack=$_SESSION['UrlBackLab'];
    }
?>
<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-xl-12 col-md-12">
                        <div class="card table-card">
                            <form action="javascript:void(0);" id="ProsesTambahPermintaanLab">
                                <div class="card-header border-info">
                                    <div class="row">
                                        <div class="col-md-10 mb-3 card-title">
                                            <h4 class="text-dark">
                                                <i class="icofont-prescription"></i> Form Permintaan Pemeriksaan Laboratorium
                                            </h4>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <a href="<?php echo $UrlBack;?>" class="btn btn-sm btn-block btn-secondary" title="kembali Ke Data Permintaan Lab">
                                                <i class="ti ti-arrow-circle-left text-white"></i> Kembali
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-4">
                                        <div class="col-md-2">
                                            <dt>Tanggal/Waktu</dt>
                                        </div>
                                        <div class="col-md-5 col-6">
                                            <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?php echo date('Y-m-d'); ?>">
                                            <small>Tanggal Permintaan</small>
                                        </div>
                                        <div class="col-md-5 col-6">
                                            <input type="time" class="form-control" name="waktu" id="waktu" value="<?php echo date('H:i'); ?>">
                                            <small>Jam Permintaan</small>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-2">
                                            <dt>RM Pasien</dt>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="id_pasien" id="id_pasien" placeholder="Nomor RM Pasien" value="<?php echo "$id_pasien"; ?>">
                                                <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#ModalPilihPasien">
                                                    <i class="ti-arrow-circle-up"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" readonly class="form-control" name="nama_pasien" id="nama_pasien" value="<?php echo "$NamaPasien"; ?>">
                                            <small>Nama Pasien</small>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-2">
                                            <dt>No.Reg</dt>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="id_kunjungan" id="id_kunjungan" placeholder="Kunjungan pasien" value="<?php echo "$id_kunjungan"; ?>">
                                                <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#ModalPilihKunjungan">
                                                    <i class="ti-arrow-circle-up"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" readonly class="form-control" name="jenis_kunjungan" id="jenis_kunjungan" value="<?php echo "$TujuanKunjungan"; ?>">
                                            <small>Jenis Kunjungan</small>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-2">
                                            <dt>Dokter Pengirim</dt>
                                        </div>
                                        <div class="col-md-5">
                                            <select name="id_dokter" id="id_dokter" class="form-control">
                                                <option value="">Pilih</option>
                                                <?php
                                                    $QryDokter = mysqli_query($Conn, "SELECT*FROM dokter ORDER BY nama ASC");
                                                    while ($DataDokter = mysqli_fetch_array($QryDokter)) {
                                                        $id_dokter= $DataDokter['id_dokter'];
                                                        $NamaDokter= $DataDokter['nama'];
                                                        echo '<option value="'.$id_dokter.'">'.$NamaDokter.'</option>';
                                                    }
                                                ?>
                                                <option value="Lainnya">Lainnya</option>
                                            </select>
                                            <small>Pilih Dari Referensi Dokter</small>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" readonly class="form-control" name="dokter" id="dokter">
                                            <small>Nama Dokter</small>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-2">
                                            <dt>Faskes Pemohon</dt>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="faskes" id="faskes" value="<?php echo $NamaFaskes; ?>">
                                            <small>Nama RS/Klinik/Dokter Yang Mengirim Permintaan</small>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-2">
                                            <dt>Unit/Instalasi</dt>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="unit" id="unit">
                                            <small>Nama Unit/Instalasi/Divisi Yang mengajukan Permintaan Pemeriksaan</small>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-2">
                                            <dt>Prioritas</dt>
                                        </div>
                                        <div class="col-md-10">
                                            <select name="prioritas" id="prioritas" class="form-control">
                                                <option value="NON CITO">NON CITO</option>
                                                <option value="CITO">CITO</option>
                                            </select>
                                            <small>Urutan/Tingkat Kecepatan dalam melakukan pemeriksaan</small>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-2">
                                            <dt>Diagnosis/Penyakit</dt>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="diagnosis" id="diagnosis">
                                            <small>Diagnosis penyakit / Keterangan masalah 	</small>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-2">
                                            <dt>Keterangan</dt>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="keterangan_permintaan" id="keterangan_permintaan">
                                            <small>Informasi tambahan terkait permintaan pemeriksaan</small>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-2">
                                            <dt>A/N Pemohon</dt>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="nama_signature" id="nama_signature" value="<?php echo "$SessionNama"; ?>">
                                            <small>Atas Nama (Nama Lengkap) Pemohon</small>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-12">
                                            <div class="row mb-4">
                                                <div class="col-md-12">
                                                    <label for="signature"><dt>Tanda Tangan Pemohon</dt></label>
                                                    <canvas id="signature-pad" class="signature-pad" width="100%">
                                                        <!-- Konten Tanda Tangan Disimpan Disini -->
                                                    </canvas>
                                                </div>
                                                <div class="col-md-12 text-center">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-sm btn-outline-dark" id="change-color" title="Ubah Warna Tinta">
                                                            <span class="ti-palette"></span>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-outline-dark" id="undo" title="Undo">
                                                            <span class="ti-back-left"></span>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-outline-dark" id="clear" title="Batalkan Semua">
                                                            <span class="ti-eraser"></span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-12" id="NotifikasiTambahPermintaan">
                                            <span class="text-primary">Pastikan Data Permintaan Sudah Sesuai</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-md btn-primary mb-3">
                                        <i class="ti ti-save"></i> Simpan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="styleSelector">

        </div>
    </div>
</div>
<?php
    //Hancurkan Session
    $_SESSION['UrlBackLab']="";
?>
