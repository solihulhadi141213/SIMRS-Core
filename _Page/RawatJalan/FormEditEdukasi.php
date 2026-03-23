<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php"; 
    //Tangkap ID
    if(empty($_POST['id_edukasi'])){
        echo '<span class="text-danger">Belum Ada Data Kunjungan Yang Dipilih</span>';
    }else{
        $id_edukasi=$_POST['id_edukasi'];
        //Buka ID Kunjungan dan Id pasien
        $id_kunjungan=getDataDetail($Conn,"edukasi",'id_edukasi',$id_edukasi,'id_kunjungan');
        $id_pasien=getDataDetail($Conn,"edukasi",'id_edukasi',$id_edukasi,'id_pasien');
        $petugas_entry=getDataDetail($Conn,"edukasi",'id_edukasi',$id_edukasi,'petugas_entry');
        $tanggal_edukasi=getDataDetail($Conn,"edukasi",'id_edukasi',$id_edukasi,'tanggal_edukasi');
        $kategori_edukasi=getDataDetail($Conn,"edukasi",'id_edukasi',$id_edukasi,'kategori_edukasi');
        $materi_edukasi=getDataDetail($Conn,"edukasi",'id_edukasi',$id_edukasi,'materi_edukasi');
        $pemberi_edukasi=getDataDetail($Conn,"edukasi",'id_edukasi',$id_edukasi,'pemberi_edukasi');
        $penerima_edukasi=getDataDetail($Conn,"edukasi",'id_edukasi',$id_edukasi,'penerima_edukasi');
        $keterangan_edukasi=getDataDetail($Conn,"edukasi",'id_edukasi',$id_edukasi,'keterangan_edukasi');
        $status_edukasi=getDataDetail($Conn,"edukasi",'id_edukasi',$id_edukasi,'status_edukasi');
        //Format waktu
        $strtotime=strtotime($tanggal_edukasi);
        $tanggal_edukasi=date('Y-m-d',$strtotime);
        $jam_edukasi=date('H:i',$strtotime);
        //Json 
        $JsonPemberiEdukasi =json_decode($pemberi_edukasi, true);
        $JsonPenerimaEdukasi =json_decode($penerima_edukasi, true);
        $JsonKeteranganEdukasi =json_decode($keterangan_edukasi, true);
        //Pemberi Edukasi
        $NamaPemberiEdukasi=$JsonPemberiEdukasi['nama'];
        $KontakPemberiEdukasi=$JsonPemberiEdukasi['kontak'];
        $IdentitasPemberiEdukasi=$JsonPemberiEdukasi['kategori_identitas'];
        $NomorIdentitasPemberiEdukasi=$JsonPemberiEdukasi['no_identitas'];
        $TtdPemberiEdukasi=$JsonPemberiEdukasi['ttd'];
        if(empty($TtdPemberiEdukasi)){
            $LabelTtdPemberiEdukasi='<a href="javascript:void(0);" id="AddTtdPemberiEdukasi" class="AddTtdPemberiEdukasi" value="'.$id_edukasi.'">Belum Ada <i class="ti ti-pencil"></i></a>';
        }else{
            $LabelTtdPemberiEdukasi='<br><img src="data:image/gif;base64,'. $TtdPemberiEdukasi .'" width="150px">';
        }
        //Penerima Edukasi
        $NamaPenerimaEdukasi=$JsonPenerimaEdukasi['nama'];
        $KontakPenerimaEdukasi=$JsonPenerimaEdukasi['kontak'];
        $IdentitasPenerimaEdukasi=$JsonPenerimaEdukasi['kategori_identitas'];
        $NomorIdentitasPenerimaEdukasi=$JsonPenerimaEdukasi['no_identitas'];
        $TtdPenerimaEdukasi=$JsonPenerimaEdukasi['ttd'];
        if(empty($TtdPenerimaEdukasi)){
            $LabelTtdPenerimaEdukasi='<a href="javascript:void(0);" id="AddTtdPenerimaEdukasi" class="AddTtdPenerimaEdukasi" value="'.$id_edukasi.'">Belum Ada <i class="ti ti-pencil"></i></a>';
        }else{
            $LabelTtdPenerimaEdukasi='<br><img src="data:image/gif;base64,'. $TtdPenerimaEdukasi .'" width="150px">';
        }
        //Keterangan Edukasi
        $Bahasa=$JsonKeteranganEdukasi['bahasa'];
        $Penerjemah=$JsonKeteranganEdukasi['penerjemah'];
        $Hambatan=$JsonKeteranganEdukasi['hambatan'];
        $jenis_hambatan=$JsonKeteranganEdukasi['jenis_hambatan'];
        $durasi=$JsonKeteranganEdukasi['durasi'];
        $kesediaan_edukasi=$JsonKeteranganEdukasi['kesediaan_edukasi'];
?>
    <form action="javascript:void(0);" id="ProsesEditEdukasi">
        <input type="hidden" readonly name="id_edukasi" id="id_edukasi" class="form-control" value="<?php echo "$id_edukasi"; ?>">
        <div class="row mb-3">
            <div class="col-md-12 sub-title">
                <dt>Informasi Edukasi</dt>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="id_pasien">No.RM</label>
            </div>
            <div class="col-md-9">
                <input type="text" readonly name="id_pasien" id="id_pasien" class="form-control" value="<?php echo "$id_pasien"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="id_kunjungan">ID Kunjungan</label>
            </div>
            <div class="col-md-9">
                <input type="text" readonly name="id_kunjungan" id="id_kunjungan" class="form-control" value="<?php echo "$id_kunjungan"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="petugas_entry">Petugas Entry</label>
            </div>
            <div class="col-md-9">
                <input type="text" name="petugas_entry" id="petugas_entry" class="form-control" value="<?php echo "$petugas_entry"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="tanggal_edukasi">Tanggal Edukasi</label>
            </div>
            <div class="col-md-5">
                <input type="date" name="tanggal_edukasi" id="tanggal_edukasi" class="form-control" value="<?php echo "$tanggal_edukasi"; ?>">
                <small>Tanggal Edukasi</small>
            </div>
            <div class="col-md-4">
                <input type="time" name="jam_edukasi" id="jam_edukasi" class="form-control" value="<?php echo "$jam_edukasi"; ?>">
                <small>Jam Edukasi</small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="kategori_edukasi">Kategori Edukasi</label>
            </div>
            <div class="col-md-9">
                <input type="text" name="kategori_edukasi" id="kategori_edukasi" class="form-control" list="KategoriEdukasi" value="<?php echo "$kategori_edukasi"; ?>">
                <datalist id="KategoriEdukasi">
                    <option value="Hak Dan Kewajiban Pasien">
                    <option value="Penyakit, Penyebab, Tanda dan Gejala">
                    <option value="Rencana Tindakan Yang Akan Dilakukan">
                    <option value="Prognosis">
                    <option value="Manajemen Nyeri">
                    <option value="Cuci Tangan Yang Benar">
                    <option value="Rencana Terapi">
                </datalist>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="materi_edukasi">Materi Edukasi</label>
            </div>
            <div class="col-md-9">
                <div id="materi_edukasi"><?php echo "$materi_edukasi"; ?></div>
            </div>
        </div>
        <div class="row mb-3 mt-4">
            <div class="col-md-12 sub-title">
                <dt>Pemberi Edukasi</dt>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="nama_pemberi_edukasi">Nama Pemberi Edukasi</label>
            </div>
            <div class="col-md-9">
                <input type="text" name="nama_pemberi_edukasi" id="nama_pemberi_edukasi" class="form-control" value="<?php echo $NamaPemberiEdukasi; ?>">
                <small>Nama Sesuai Identitas</small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="kontak_pemberi_edukasi">Nomor Kontak</label>
            </div>
            <div class="col-md-9">
                <input type="text" name="kontak_pemberi_edukasi" id="kontak_pemberi_edukasi" class="form-control" value="<?php echo $KontakPemberiEdukasi; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="identitas_pemberi_edukasi">Identitas</label>
            </div>
            <div class="col-md-4">
                <input type="text" name="identitas_pemberi_edukasi" id="identitas_pemberi_edukasi" list="KategoriIdentitas" class="form-control" value="<?php echo $IdentitasPemberiEdukasi; ?>">
                <small>Kategori Identitas</small>
            </div>
            <div class="col-md-5">
                <input type="text" name="no_identitas_pemberi_edukasi" id="no_identitas_pemberi_edukasi" class="form-control" value="<?php echo $NomorIdentitasPemberiEdukasi; ?>">
                <small>Nomor Identitas</small>
            </div>
        </div>
        <div class="row mb-3 mt-4">
            <div class="col-md-12 sub-title">
                <dt>Penerima Edukasi</dt>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="nama_penerima_edukasi">Nama Penerima Edukasi</label>
            </div>
            <div class="col-md-9">
                <input type="text" name="nama_penerima_edukasi" id="nama_penerima_edukasi" class="form-control" value="<?php echo $NamaPenerimaEdukasi; ?>">
                <small>Nama Sesuai Identitas</small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="kontak_penerima_edukasi">Nomor Kontak</label>
            </div>
            <div class="col-md-9">
                <input type="text" name="kontak_penerima_edukasi" id="kontak_penerima_edukasi" class="form-control" value="<?php echo $KontakPenerimaEdukasi; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="identitas_penerima_edukasi">Identitas</label>
            </div>
            <div class="col-md-4">
                <input type="text" name="identitas_penerima_edukasi" id="identitas_penerima_edukasi" list="KategoriIdentitas" class="form-control" value="<?php echo $IdentitasPenerimaEdukasi; ?>">
                <small>Kategori Identitas</small>
            </div>
            <div class="col-md-5">
                <input type="text" name="no_identitas_penerima_edukasi" id="no_identitas_penerima_edukasi" class="form-control" value="<?php echo $NomorIdentitasPenerimaEdukasi; ?>">
                <small>Nomor Identitas</small>
            </div>
            <datalist id="KategoriIdentitas">
                <option value="KTP">
                <option value="SIM">
                <option value="KK">
                <option value="Passport">
            </datalist>
        </div>
        <div class="row mb-3 mt-4">
            <div class="col-md-12 sub-title">
                <dt>Keterangan Edukasi</dt>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="durasi_edukasi">Durasi Pelaksanaan Edukasi</label>
            </div>
            <div class="col-md-9">
                <input type="text" name="durasi_edukasi" id="durasi_edukasi" class="form-control" value="<?php echo $durasi; ?>">
                <small>Tulis Berikut Dengan Unit/Satuan Waktu (ex: Menit, Detik, Jam)</small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="kemampuan_bahasa">Kemampuan Bahasa</label>
            </div>
            <div class="col-md-9">
                <input type="text" name="kemampuan_bahasa" id="kemampuan_bahasa" class="form-control" value="<?php echo $Bahasa; ?>">
                <small>Tulis bahasa yang digunakan (ex: Indonesia, Inggris, Sunda, Jawa)</small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="perlu_penerjemah">Apakah Perlu Penerjemah?</label>
                <ul>
                    <li>
                        <input <?php if($Penerjemah=="Ya"){echo "checked";} ?> type="radio" name="perlu_penerjemah" id="perlu_penerjemah1" value="Ya">
                        <label for="perlu_penerjemah1">Ya</label>
                    </li>
                    <li>
                        <input <?php if($Penerjemah=="Tidak"){echo "checked";} ?> type="radio" name="perlu_penerjemah" id="perlu_penerjemah2" value="Tidak"> 
                        <label for="perlu_penerjemah2">Tidak</label>
                    </li>
                </ul>
            </div>
            <div class="col-md-3">
                Apakah Dalam Komunikasi Terdapat Hambatan?
                <ul>
                    <li>
                        <input <?php if($Hambatan=="Ada"){echo "checked";} ?> type="radio" name="hambatan_komunikasi" id="hambatan_komunikasi1" value="Ada">
                        <label for="hambatan_komunikasi1">Ada</label>
                    </li>
                    <li>
                        <input <?php if($Hambatan=="Tidak"){echo "checked";} ?>  type="radio" name="hambatan_komunikasi" id="hambatan_komunikasi2" value="Tidak"> 
                        <label for="hambatan_komunikasi2">Tidak</label>
                    </li>
                </ul>
            </div>
            <div class="col-md-3">
                Sebutkan Jenis Hambatan Komunikasi
                <ul>
                    <li>
                        <input type="checkbox" <?php if($Hambatan=="Tidak"){echo 'disabled="disabled"';} ?> class="jenis_hambatan" name="jenis_hambatan[]" id="jenis_hambatan1" <?php foreach($jenis_hambatan as $ListHambatan){if($ListHambatan['jenis']=="Gangguan Pendengaran"){echo "checked";}} ?>  value="Gangguan Pendengaran">
                        <label for="jenis_hambatan1">Gangguan Pendengaran</label>
                    </li>
                    <li>
                        <input type="checkbox" <?php if($Hambatan=="Tidak"){echo 'disabled="disabled"';} ?> class="jenis_hambatan" name="jenis_hambatan[]" id="jenis_hambatan2" <?php foreach($jenis_hambatan as $ListHambatan){if($ListHambatan['jenis']=="Gangguan Emosi"){echo "checked";}} ?> value="Gangguan Emosi">
                        <label for="jenis_hambatan2">Gangguan Emosi</label>
                    </li>
                    <li>
                        <input type="checkbox" <?php if($Hambatan=="Tidak"){echo 'disabled="disabled"';} ?> class="jenis_hambatan" name="jenis_hambatan[]" id="jenis_hambatan3" <?php foreach($jenis_hambatan as $ListHambatan){if($ListHambatan['jenis']=="Gangguan Penglihatan"){echo "checked";}} ?> value="Gangguan Penglihatan">
                        <label for="jenis_hambatan3">Gangguan Penglihatan</label>
                    </li>
                    <li>
                        <input type="checkbox" <?php if($Hambatan=="Tidak"){echo 'disabled="disabled"';} ?> class="jenis_hambatan" name="jenis_hambatan[]" id="jenis_hambatan4" <?php foreach($jenis_hambatan as $ListHambatan){if($ListHambatan['jenis']=="Hilang Memori"){echo "checked";}} ?> value="Hilang Memori">
                        <label for="jenis_hambatan4">Hilang Memori</label>
                    </li>
                    <li>
                        <input type="checkbox" <?php if($Hambatan=="Tidak"){echo 'disabled="disabled"';} ?> class="jenis_hambatan" name="jenis_hambatan[]" id="jenis_hambatan5" <?php foreach($jenis_hambatan as $ListHambatan){if($ListHambatan['jenis']=="Gangguan Bicara"){echo "checked";}} ?> value="Gangguan Bicara">
                        <label for="jenis_hambatan5">Gangguan Bicara</label>
                    </li>
                    <li>
                        <input type="checkbox" <?php if($Hambatan=="Tidak"){echo 'disabled="disabled"';} ?> class="jenis_hambatan" name="jenis_hambatan[]" id="jenis_hambatan6" <?php foreach($jenis_hambatan as $ListHambatan){if($ListHambatan['jenis']=="Gangguan Bicara"){echo "checked";}} ?> value="Gangguan Bicara">
                        <label for="jenis_hambatan6">Motivasi Buruk</label>
                    </li>
                    <li>
                        <input type="checkbox" <?php if($Hambatan=="Tidak"){echo 'disabled="disabled"';} ?> class="jenis_hambatan" name="jenis_hambatan[]" id="jenis_hambatan7" <?php foreach($jenis_hambatan as $ListHambatan){if($ListHambatan['jenis']=="Secara Fisiologis Tidak Mampu Belajar"){echo "checked";}} ?> value="Secara Fisiologis Tidak Mampu Belajar">
                        <label for="jenis_hambatan7">Secara Fisiologis Tidak Mampu Belajar</label>
                    </li>
                </ul>
            </div>
            <div class="col-md-3">
                Kesediaan Menerima Edukasi?
                <ul>
                    <li>
                        <input type="radio" <?php if($kesediaan_edukasi=="Bersedia"){echo "checked";} ?> name="kesediaan_edukasi" id="kesediaan_edukasi1" value="Bersedia">
                        <label for="kesediaan_edukasi1">Bersedia</label>
                    </li>
                    <li>
                        <input type="radio" <?php if($kesediaan_edukasi=="Tidak"){echo "checked";} ?> name="kesediaan_edukasi" id="kesediaan_edukasi2" value="Tidak"> 
                        <label for="kesediaan_edukasi2">Tidak</label>
                    </li>
                </ul>
            </div>
            <div class="col-md-3">
                Status Edukasi
                <ul>
                    <li>
                        <input <?php if($status_edukasi=="Sudah Mengerti"){echo "checked";} ?> type="radio" name="status_edukasi" id="status_edukasi1" value="Sudah Mengerti">
                        <label for="status_edukasi1">Sudah Mengerti</label>
                    </li>
                    <li>
                        <input <?php if($status_edukasi=="Re Edukasi"){echo "checked";} ?> type="radio" name="status_edukasi" id="status_edukasi2" value="Re Edukasi"> 
                        <label for="status_edukasi2">Re Edukasi</label>
                    </li>
                    <li>
                        <input <?php if($status_edukasi=="Re Demonstrasi"){echo "checked";} ?> type="radio" name="status_edukasi" id="status_edukasi3" value="Re Demonstrasi"> 
                        <label for="status_edukasi3">Re Demonstrasi</label>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12" id="NotifikasiEditEdukasi">
                <span class="text-primary">Pastikan Informasi Edukasi Sudah Terisi Dengan Benar Dan Lengkap!</span>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <button type="submit" class="btn btn-md btn-primary mr-2">
                    <i class="ti ti-save"></i> Simpan
                </button>
                <button type="reset" class="btn btn-md btn-secondary">
                    <i class="ti ti-reload"></i> Reset
                </button>
            </div>
        </div>
    </form>
<?PHP } ?>
<script>
    //Kondisi Ketika Ada Hambatan
    $('#hambatan_komunikasi1').click(function(){
        $(".jenis_hambatan").removeAttr("disabled");
    });
    $('#hambatan_komunikasi2').click(function(){
        $(".jenis_hambatan").prop("checked", false);
        $(".jenis_hambatan").attr("disabled", true);
    });
    //Proses Edit Edukasi
    $('#ProsesEditEdukasi').submit(function(){
        var ProsesEditEdukasi = $('#ProsesEditEdukasi').serialize();
        var materi_edukasi =  $('#materi_edukasi').summernote('code');
        $('#NotifikasiEditEdukasi').html("Loading...");
        $.ajax({
            type 	    :   'POST',
            url 	    :   '_Page/RawatJalan/ProsesEditEdukasi.php',
            data        :   {ProsesEditEdukasi, materi_edukasi: materi_edukasi},
            success     :   function(data){
                $('#NotifikasiEditEdukasi').html(data);
                var NotifikasiEditEdukasiBerhasil=$('#NotifikasiEditEdukasiBerhasil').html();
                if(NotifikasiEditEdukasiBerhasil=="Success"){
                    $('#KontenEdukasi').html("Loading...");
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/RawatJalan/ListEdukasi.php',
                        data        : {id_kunjungan: GetIdKunjunganEdukasi},
                        success     : function(data){
                            $('#KontenEdukasi').html(data);
                            $("#ListEdukasi").removeClass("btn-outline-dark");
                            $("#ListEdukasi").addClass("btn-dark");
                            $("#TambahEdukasi").removeClass("btn-dark");
                            $("#TambahEdukasi").addClass("btn-outline-dark");
                        }
                    });
                    //Tampilkan Swal
                    Swal.fire({
                        title: 'Good Job!',
                        text: 'Edit Edukasi Berhasil',
                        icon: 'success',
                        confirmButtonText: 'Tutup'
                    })
                }
            }
        });
    });
</script>