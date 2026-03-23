<?php
    include "_Config/SettingBridging.php";
    //Tangkap ID
    if(empty($_GET['id'])){
        echo '<span class="text-danger">Belum Ada data Pasien Yang Dipilih</span>';
    }else{
        $id_kunjungan=$_GET['id'];
        //Membuka data
        //Buka data Pasien
        $Qry = mysqli_query($Conn,"SELECT * FROM kunjungan_utama WHERE id_kunjungan='$id_kunjungan'")or die(mysqli_error($Conn));
        $Data = mysqli_fetch_array($Qry);
        $id_pasien= $Data['id_pasien'];
        $no_antrian= $Data['no_antrian'];
        $nik= $Data['nik'];
        $no_bpjs= $Data['no_bpjs'];
        $sep= $Data['sep'];
        $noRujukan= $Data['noRujukan'];
        $skdp= $Data['skdp'];
        $nama= $Data['nama'];
        $tanggal= $Data['tanggal'];
        $propinsi= $Data['propinsi'];
        $kabupaten= $Data['kabupaten'];
        $kecamatan= $Data['kecamatan'];
        $desa= $Data['desa'];
        $alamat= $Data['alamat'];
        $keluhan= $Data['keluhan'];
        $tujuan= $Data['tujuan'];
        $id_dokter= $Data['id_dokter'];
        $dokter= $Data['dokter'];
        $id_poliklinik= $Data['id_poliklinik'];
        $poliklinik= $Data['poliklinik'];
        $kelas= $Data['kelas'];
        $ruangan= $Data['ruangan'];
        $id_kasur= $Data['id_kasur'];
        $DiagAwal= $Data['DiagAwal'];
        $rujukan_dari= $Data['rujukan_dari'];
        $rujukan_ke= $Data['rujukan_ke'];
        $pembayaran= $Data['pembayaran'];
        $cara_keluar= $Data['cara_keluar'];
        $tanggal_keluar= $Data['tanggal_keluar'];
        $status= $Data['status'];
        $id_akses= $Data['id_akses'];
        $nama_petugas= $Data['nama_petugas'];
        //Melakukan explode pada tanggal
        $Pecah = explode(" " , $tanggal);
        $tanggal=$Pecah['0'];
        $waktu=$Pecah['1'];
        //Tanggal sekarang
        $updatetime=date('Y-m-d H:i:s');
?>
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="index.php?Page=RawatJalan&Sub=BuatSep&id=<?php echo "$id_kunjungan"; ?>" class="h5">
                            <i class="icofont-icu"></i> Buat SEP Kunjungan Rawat Jalan
                        </a>
                    </h5>
                    <p class="m-b-0">Buat Data SEP Berdasarkan Kunjungan Rawat Jalan</p>
                </div>
            </div>
            <div class="col-md-4 text-right">
                <a href="index.php?Page=RawatJalan" class="btn btn-md btn-inverse mr-2 mt-2">
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
                        <form action="javascript:void(0);" id="ProsesBuatSep" autocomplete="off">
                            <input type="hidden" name="id_kunjungan" id="id_kunjungan" value="<?php echo "$id_kunjungan"; ?>">
                            <div class="card">
                                <div class="card-header">
                                    <h5>
                                        <dt>Form Buat SEP Kunjungan Rawat Jalan</dt>
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 mt-3">
                                            <label for="id_pasien">
                                                <dt>
                                                    No.RM 
                                                    <a href="javascript:void(0);" class="badge badge-primary" data-toggle="modal" data-target="#ModalDetailPasien" data-id="<?php echo "$id_pasien"; ?>" title="Lihat Detail Pasien">
                                                        <i class="ti ti-info"></i>
                                                    </a>
                                                </dt>
                                            </label>
                                            <input type="text" readonly name="id_pasien" id="id_pasien" value="<?php echo "$id_pasien"; ?>" class="form-control">
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="nik">
                                                <dt>
                                                    No.NIK 
                                                    <a href="javascript:void(0);" class="badge badge-primary" data-toggle="modal" data-target="#ModalStatusKepesertaanNik" data-id="<?php echo "$nik"; ?>">
                                                        <i class="ti ti-info"></i>
                                                    </a>
                                                </dt>
                                            </label>
                                            <input type="text" readonly name="nik" id="nik" value="<?php echo "$nik"; ?>" class="form-control">
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="no_bpjs">
                                                <dt>
                                                    No.BPJS 
                                                    <a href="javascript:void(0);" class="badge badge-primary" data-toggle="modal" data-target="#ModalStatusKepesertaanBPJS" data-id="<?php echo "$no_bpjs"; ?>">
                                                        <i class="ti ti-info"></i>
                                                    </a>
                                                </dt>
                                            </label>
                                            <input type="text" readonly name="no_bpjs" id="no_bpjs" value="<?php echo "$no_bpjs"; ?>" class="form-control">
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="nama"><dt>Nama Pasien</dt></label>
                                            <input type="text" readonly name="nama" id="nama" value="<?php echo "$nama"; ?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 mt-3">
                                            <label for="ppkPelayanan"><dt>PPK Pelayanan</dt></label>
                                            <input type="text" readonly name="ppkPelayanan" id="ppkPelayanan" value="<?php echo "$kode_ppk"; ?>" class="form-control">
                                            <small>Berasal Dari Rencana Kontrol</small>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="noRujukan">
                                                <dt>
                                                    No.Rujukan 
                                                    <a href="javascript:void(0);" class="badge badge-primary" data-toggle="modal" data-target="#ModalCariSEP">
                                                        <i class="ti ti-search"></i> History
                                                    </a>
                                                </dt>
                                            </label>
                                            <input type="text" name="noRujukan" id="noRujukan" value="<?php echo "$noRujukan"; ?>" class="form-control">
                                            <small>Apabila Kunjungan berasal dari rujukan</small>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="tglRujukan"><dt>Tanggal Rujukan</dt></label>
                                            <input type="date" name="tglRujukan" id="tglRujukan" value="" class="form-control">
                                            <small>Hanya apabila ada rujukan</small>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="asalRujukan"><dt>Asal Rujukan</dt></label>
                                            <select name="asalRujukan" id="asalRujukan" class="form-control">
                                                <option value="">Pilih</option>
                                                <option value="1">Faskes 1</option>
                                                <option value="2">Faskes 2</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 mt-3">
                                            <label for="rujukan_dari">
                                                <dt>
                                                    PPk Asal Rujukan 
                                                    <a href="javascript:void(0);" class="badge badge-primary" data-toggle="modal" data-target="#ModalPPKAsal">
                                                        <i class="ti ti-search"></i> Cari
                                                    </a>
                                                </dt>
                                            </label>
                                            <input type="text" name="rujukan_dari" id="rujukan_dari" value="<?php echo "$rujukan_dari"; ?>" class="form-control">
                                            <small>Apabila pasien berasal dari rujukan</small>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="jnsPelayanan"><dt>Jenis Pelayanan</dt></label>
                                            <select name="jnsPelayanan" id="jnsPelayanan" class="form-control">
                                                <option value="1">Rawat Inap</option>
                                                <option selected value="2">Rawat Jalan</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="klsRawatHak"><dt>Hak Kelas</dt></label>
                                            <select name="klsRawatHak" id="klsRawatHak" class="form-control">
                                                <option value="1">Kelas 1</option>
                                                <option value="2">Kelas 2</option>
                                                <option value="3">Kelas 3</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="klsRawatNaik"><dt>Naik Kelas</dt></label>
                                            <select name="klsRawatNaik" id="klsRawatNaik" class="form-control">
                                                <option value="">Pilih</option>
                                                <option value="1">VVIP</option>
                                                <option value="2">VIP</option>
                                                <option value="3">Kelas 1</option>
                                                <option value="4">Kelas 2</option>
                                                <option value="5">Kelas 3</option>
                                                <option value="6">ICCU</option>
                                                <option value="7">ICU</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 mt-3">
                                            <label for="pembiayaan"><dt>Pembiayaan</dt></label>
                                            <select name="pembiayaan" id="pembiayaan" class="form-control">
                                                <option value="">Pilih</option>
                                                <option value="1">Pribadi</option>
                                                <option value="2">Pemberi Kerja</option>
                                                <option value="3">Asuransi Kesehatan Tambahan</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="penanggungJawab"><dt>Penanggung Jawab</dt></label>
                                            <select name="penanggungJawab" id="penanggungJawab" class="form-control">
                                                <option value="">Pilih</option>
                                                <option value="Pribadi">Pribadi</option>
                                                <option value="Pemberi Kerja">Pemberi Kerja</option>
                                                <option value="Asuransi Kesehatan Tambahan">Asuransi Kesehatan Tambahan</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="noSurat"><dt>No.SKDP/SPRI</dt></label>
                                            <input type="text" name="noSurat" id="noSurat" value="<?php echo "$skdp"; ?>" class="form-control">
                                            <small>Berasal Dari Rencana Kontrol</small>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="tanggal"><dt>Tanggal SEP</dt></label>
                                            <input type="date" name="tglSep" id="tglSep" class="form-control">
                                            <small>Tanggal Pelayanan Saat SEP</small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 mt-3">
                                            <label for="sep">
                                                <dt>
                                                    Diagnosa Awal  
                                                    <a href="javascript:void(0);" class="badge badge-primary" data-toggle="modal" data-target="#ModalCariDiagnosa">
                                                        <i class="ti ti-search"></i> Cari
                                                    </a>
                                                </dt>
                                            </label>
                                            <input type="text" name="diagAwal" id="diagAwal" value="<?php echo "$DiagAwal"; ?>" class="form-control">
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="keluhan"><dt>Keluhan</dt></label>
                                            <input type="text" name="keluhan" id="keluhan" value="<?php echo "$keluhan"; ?>" class="form-control">
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="catatan"><dt>Catatan</dt></label>
                                            <input type="text" name="catatan" id="catatan" class="form-control">
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="tujuan"><dt>Poliklinik</dt></label>
                                            <select name="tujuan" id="tujuan" class="form-control">
                                                <option value="">Pilih</option>
                                                <?php
                                                    //menamilkan dari database
                                                    $query = mysqli_query($Conn, "SELECT*FROM poliklinik");
                                                    while ($data = mysqli_fetch_array($query)) {
                                                        $id_poliklinik_list= $data['id_poliklinik'];
                                                        $nama= $data['nama'];
                                                        $kode= $data['kode'];
                                                        if($id_poliklinik==$id_poliklinik_list){
                                                            echo '<option selected value="'.$kode.'">'.$nama.'</option>';
                                                        }else{
                                                            echo '<option value="'.$kode.'">'.$nama.'</option>';
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 mt-3">
                                            <label for="eksekutif"><dt>Poli eksekutif</dt></label>
                                            <select name="eksekutif" id="eksekutif" class="form-control">
                                                <option value="0">Tidak</option>
                                                <option value="1">Ya</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="cob"><dt>COB</dt></label>
                                            <select name="cob" id="cob" class="form-control">
                                                <option value="0">Tidak</option>
                                                <option value="1">Ya</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="katarak"><dt>Katarak</dt></label>
                                            <select name="katarak" id="katarak" class="form-control">
                                                <option value="0">Tidak</option>
                                                <option value="1">Ya</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="dpjpLayan"><dt>Dokter Pelayanan</dt></label>
                                            <select name="dpjpLayan" id="dpjpLayan" class="form-control">
                                                <option value="">Pilih</option>
                                                <?php
                                                    //menamilkan dari database
                                                    $query = mysqli_query($Conn, "SELECT*FROM dokter");
                                                    while ($data = mysqli_fetch_array($query)) {
                                                        $id_dokter_list= $data['id_dokter'];
                                                        $nama= $data['nama'];
                                                        $kodeDpjp= $data['kode'];
                                                        if($id_dokter==$id_dokter_list){
                                                            echo '<option selected value="'.$kodeDpjp.'">'.$nama.'</option>';
                                                        }else{
                                                            echo '<option value="'.$kodeDpjp.'">'.$nama.'</option>';
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 mt-3">
                                            <label for="lakaLantas"><dt>Laka-Lantas</dt></label>
                                            <select name="lakaLantas" id="lakaLantas" class="form-control">
                                                <option value="0">Bukan Kecelakaan</option>
                                                <option value="1">KLL dan bukan kecelakaan Kerja</option>
                                                <option value="2">KLL dan KK</option>
                                                <option value="3">KK</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="tglKejadian"><dt>Tanggal Kejadian</dt></label>
                                            <input type="date" name="tglKejadian" id="tglKejadian" class="form-control">
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="keterangan"><dt>Keterangan Kejadian</dt></label>
                                            <input type="text" name="keterangan" id="keterangan" class="form-control">
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="suplesi"><dt>Suplesi</dt></label>
                                            <select name="suplesi" id="suplesi" class="form-control">
                                                <option value="0">Tidak</option>
                                                <option value="1">Ya</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 mt-3">
                                            <label for="noSepSuplesi">
                                                <dt>
                                                    No SEP Suplesi
                                                    <a href="javascript:void(0);" class="badge badge-primary" data-toggle="modal" data-target="#ModalCariDataSuplesi" data-id="<?php echo "$no_bpjs"; ?>" title="Lihat Detail Pasien">
                                                        <i class="ti ti-info"></i> Suplesi
                                                    </a>
                                                </dt>
                                            </label>
                                            <input type="text" name="noSepSuplesi" id="noSepSuplesi" class="form-control">
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="kdPropinsi"><dt>Propinsi Laka</dt></label>
                                            <input type="text" name="kdPropinsi" id="kdPropinsi" class="form-control" data-toggle="modal" data-target="#ModalCariPropinsi">
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="kdKabupaten"><dt>Kabupaten Laka</dt></label>
                                            <input type="text" name="kdKabupaten" id="kdKabupaten" class="form-control" data-toggle="modal" data-target="#ModdalCariKabupaten">
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="kdKecamatan"><dt>Kecamatan Laka</dt></label>
                                            <input type="text" name="kdKecamatan" id="kdKecamatan" class="form-control" data-toggle="modal" data-target="#ModalcariKecamatan">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-3 mt-3">
                                            <label for="tujuanKunj"><dt>Tujuan Kunjungan</dt></label>
                                            <select name="tujuanKunj" id="tujuanKunj" class="form-control">
                                                <option value="">Pilih</option>
                                                <option value="0">Normal</option>
                                                <option value="1">Prosedur</option>
                                                <option value="2">Konsul</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="flagProcedure"><dt>Flag Procedure</dt></label>
                                            <select name="flagProcedure" id="flagProcedure" class="form-control">
                                                <option value="">Pilih</option>
                                                <option value="0">Prosedur Tidak Berkelanjutan</option>
                                                <option value="1">Prosedur dan Terapi Berkelanjutan</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="kdPenunjang"><dt>Kode Penunjang</dt></label>
                                            <select name="kdPenunjang" id="kdPenunjang" class="form-control">
                                                <option value="">Pilih</option>
                                                <option value="1">Radioterapi</option>
                                                <option value="2">Kemoterapi</option>
                                                <option value="3">Rehabilitasi Medik</option>
                                                <option value="4">Rehabilitasi Psikososial</option>
                                                <option value="5">Transfusi Darah</option>
                                                <option value="6">Pelayanan Gigi</option>
                                                <option value="7">Laboratorium</option>
                                                <option value="8">USG</option>
                                                <option value="9">Farmasi</option>
                                                <option value="10">Lain-Lain</option>
                                                <option value="11">MRI</option>
                                                <option value="12">HEMODIALISA</option>
                                            </select>
                                            <small>Diisi Jika Tujuan Kunjungan Normal</small>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="assesmentPel"><dt>Assesment</dt></label>
                                            <select name="assesmentPel" id="assesmentPel" class="form-control">
                                                <option value="">Pilih</option>
                                                <option value="1">Poli spesialis tidak tersedia pada hari sebelumnya</option>
                                                <option value="2">Jam Poli telah berakhir pada hari sebelumnya</option>
                                                <option value="3">Dokter Spesialis yang dimaksud tidak praktek pada hari sebelumnya</option>
                                                <option value="4">Atas Instruksi RS</option>
                                                <option value="5">Tujuan Kontrol</option>
                                            </select>
                                            <small>Diisi Jika Tujuan Kunjungan Normal</small>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-3 mt-3">
                                            <label for="user"><dt>Petugas</dt></label>
                                            <input type="text" readonly name="user" id="user" value="<?php echo "$nama_petugas"; ?>" class="form-control">
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="kodeDPJP"><dt>Dokter DPJP</dt></label>
                                            <select name="kodeDPJP" id="kodeDPJP" class="form-control">
                                                <option value="">Pilih</option>
                                                <?php
                                                    //menamilkan dari database
                                                    $query = mysqli_query($Conn, "SELECT*FROM dokter");
                                                    while ($data = mysqli_fetch_array($query)) {
                                                        $id_dokter_list= $data['id_dokter'];
                                                        $nama= $data['nama'];
                                                        $kodeDpjp= $data['kode'];
                                                        if($id_dokter==$id_dokter_list){
                                                            echo '<option selected value="'.$kodeDpjp.'">'.$nama.'</option>';
                                                        }else{
                                                            echo '<option value="'.$kodeDpjp.'">'.$nama.'</option>';
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="noTelp"><dt>No.Telpn Pasien</dt></label>
                                            <input type="text" name="noTelp" id="noTelp" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12" id="NotifikasiBuatSep">
                                            <span class="text-primary">
                                                <dt>Keterangan : </dt> Pastikan Data SEP Yang Anda Input Sudah Benar!
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-md btn-primary">
                                        <i class="ti-save"></i> Simpan
                                    </button>
                                    <button type="button" class="btn btn-md btn-primary" id="TampilkanJson">
                                        <i class="ti-save"></i> Tampilkan
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
<?php } ?>