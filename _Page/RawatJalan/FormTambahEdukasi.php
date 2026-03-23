<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php"; 
    //Tangkap ID
    if(empty($_POST['id_kunjungan'])){
        echo '<span class="text-danger">Belum Ada Data Kunjungan Yang Dipilih</span>';
    }else{
        $id_kunjungan=$_POST['id_kunjungan'];
        //Buka ID Pasien
        $id_pasien=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_pasien');
?>
    <form action="javascript:void(0);" id="ProsesTambahEdukasi">
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
                <input type="text" name="petugas_entry" id="petugas_entry" class="form-control" value="<?php echo "$SessionNama"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="tanggal_edukasi">Tanggal Edukasi</label>
            </div>
            <div class="col-md-5">
                <input type="date" name="tanggal_edukasi" id="tanggal_edukasi" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                <small>Tanggal Edukasi</small>
            </div>
            <div class="col-md-4">
                <input type="time" name="jam_edukasi" id="jam_edukasi" class="form-control" value="<?php echo date('H:i'); ?>">
                <small>Jam Edukasi</small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="kategori_edukasi">Kategori Edukasi</label>
            </div>
            <div class="col-md-9">
                <input type="text" name="kategori_edukasi" id="kategori_edukasi" class="form-control" list="KategoriEdukasi">
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
                <div id="materi_edukasi"></div>
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
                <input type="text" name="nama_pemberi_edukasi" id="nama_pemberi_edukasi" class="form-control" value="">
                <small>Nama Sesuai Identitas</small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="kontak_pemberi_edukasi">Nomor Kontak</label>
            </div>
            <div class="col-md-9">
                <input type="text" name="kontak_pemberi_edukasi" id="kontak_pemberi_edukasi" class="form-control" value="">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="identitas_pemberi_edukasi">Identitas</label>
            </div>
            <div class="col-md-4">
                <input type="text" name="identitas_pemberi_edukasi" id="identitas_pemberi_edukasi" list="KategoriIdentitas" class="form-control" value="">
                <small>Kategori Identitas</small>
            </div>
            <div class="col-md-5">
                <input type="text" name="no_identitas_pemberi_edukasi" id="no_identitas_pemberi_edukasi" class="form-control" value="">
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
                <input type="text" name="nama_penerima_edukasi" id="nama_penerima_edukasi" class="form-control" value="">
                <small>Nama Sesuai Identitas</small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="kontak_penerima_edukasi">Nomor Kontak</label>
            </div>
            <div class="col-md-9">
                <input type="text" name="kontak_penerima_edukasi" id="kontak_penerima_edukasi" class="form-control" value="">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="identitas_penerima_edukasi">Identitas</label>
            </div>
            <div class="col-md-4">
                <input type="text" name="identitas_penerima_edukasi" id="identitas_penerima_edukasi" list="KategoriIdentitas" class="form-control" value="">
                <small>Kategori Identitas</small>
            </div>
            <div class="col-md-5">
                <input type="text" name="no_identitas_penerima_edukasi" id="no_identitas_penerima_edukasi" class="form-control" value="">
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
                <input type="text" name="durasi_edukasi" id="durasi_edukasi" class="form-control" value="">
                <small>Tulis Berikut Dengan Unit/Satuan Waktu (ex: Menit, Detik, Jam)</small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="kemampuan_bahasa">Kemampuan Bahasa</label>
            </div>
            <div class="col-md-9">
                <input type="text" name="kemampuan_bahasa" id="kemampuan_bahasa" class="form-control" value="">
                <small>Tulis bahasa yang digunakan (ex: Indonesia, Inggris, Sunda, Jawa)</small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="perlu_penerjemah">Apakah Perlu Penerjemah?</label>
                <ul>
                    <li>
                        <input type="radio" name="perlu_penerjemah" id="perlu_penerjemah1" value="Ya">
                        <label for="perlu_penerjemah1">Ya</label>
                    </li>
                    <li>
                        <input checked type="radio" name="perlu_penerjemah" id="perlu_penerjemah2" value="Tidak"> 
                        <label for="perlu_penerjemah2">Tidak</label>
                    </li>
                </ul>
            </div>
            <div class="col-md-3">
                Apakah Dalam Komunikasi Terdapat Hambatan?
                <ul>
                    <li>
                        <input type="radio" name="hambatan_komunikasi" id="hambatan_komunikasi1" value="Ada">
                        <label for="hambatan_komunikasi1">Ada</label>
                    </li>
                    <li>
                        <input checked type="radio" name="hambatan_komunikasi" id="hambatan_komunikasi2" value="Tidak"> 
                        <label for="hambatan_komunikasi2">Tidak</label>
                    </li>
                </ul>
            </div>
            <div class="col-md-3">
                Sebutkan Jenis Hambatan Komunikasi
                <ul>
                    <li>
                        <input type="checkbox" disabled="disabled" class="jenis_hambatan" name="jenis_hambatan[]" id="jenis_hambatan1" value="Gangguan Pendengaran">
                        <label for="jenis_hambatan1">Gangguan Pendengaran</label>
                    </li>
                    <li>
                        <input type="checkbox" disabled="disabled" class="jenis_hambatan" name="jenis_hambatan[]" id="jenis_hambatan2" value="Gangguan Emosi">
                        <label for="jenis_hambatan2">Gangguan Emosi</label>
                    </li>
                    <li>
                        <input type="checkbox" disabled="disabled" class="jenis_hambatan" name="jenis_hambatan[]" id="jenis_hambatan3" value="Gangguan Penglihatan">
                        <label for="jenis_hambatan3">Gangguan Penglihatan</label>
                    </li>
                    <li>
                        <input type="checkbox" disabled="disabled" class="jenis_hambatan" name="jenis_hambatan[]" id="jenis_hambatan4" value="Hilang Memori">
                        <label for="jenis_hambatan4">Hilang Memori</label>
                    </li>
                    <li>
                        <input type="checkbox" disabled="disabled" class="jenis_hambatan" name="jenis_hambatan[]" id="jenis_hambatan5" value="Gangguan Bicara">
                        <label for="jenis_hambatan5">Gangguan Bicara</label>
                    </li>
                    <li>
                        <input type="checkbox" disabled="disabled" class="jenis_hambatan" name="jenis_hambatan[]" id="jenis_hambatan6" value="Motivasi Buruk">
                        <label for="jenis_hambatan6">Motivasi Buruk</label>
                    </li>
                    <li>
                        <input type="checkbox" disabled="disabled" class="jenis_hambatan" name="jenis_hambatan[]" id="jenis_hambatan7" value="Secara Fisiologis Tidak Mampu Belajar">
                        <label for="jenis_hambatan7">Secara Fisiologis Tidak Mampu Belajar</label>
                    </li>
                </ul>
            </div>
            <div class="col-md-3">
                Kesediaan Menerima Edukasi?
                <ul>
                    <li>
                        <input type="radio" checked name="kesediaan_edukasi" id="kesediaan_edukasi1" value="Bersedia">
                        <label for="kesediaan_edukasi1">Bersedia</label>
                    </li>
                    <li>
                        <input type="radio" name="kesediaan_edukasi" id="kesediaan_edukasi2" value="Tidak"> 
                        <label for="kesediaan_edukasi2">Tidak</label>
                    </li>
                </ul>
            </div>
            <div class="col-md-3">
                Status Edukasi
                <ul>
                    <li>
                        <input checked type="radio" name="status_edukasi" id="status_edukasi1" value="Sudah Mengerti">
                        <label for="status_edukasi1">Sudah Mengerti</label>
                    </li>
                    <li>
                        <input type="radio" name="status_edukasi" id="status_edukasi2" value="Re Edukasi"> 
                        <label for="status_edukasi2">Re Edukasi</label>
                    </li>
                    <li>
                        <input type="radio" name="status_edukasi" id="status_edukasi3" value="Re Demonstrasi"> 
                        <label for="status_edukasi3">Re Demonstrasi</label>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12" id="NotifikasiTambahEdukasi">
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
    //Proses Tambah Edukasi
    $('#ProsesTambahEdukasi').submit(function(){
        var ProsesTambahEdukasi = $('#ProsesTambahEdukasi').serialize();
        var materi_edukasi =  $('#materi_edukasi').summernote('code');
        $('#NotifikasiTambahEdukasi').html("Loading...");
        $.ajax({
            type 	    :   'POST',
            url 	    :   '_Page/RawatJalan/ProsesTambahEdukasi.php',
            data        :   {ProsesTambahEdukasi, materi_edukasi: materi_edukasi},
            success     :   function(data){
                $('#NotifikasiTambahEdukasi').html(data);
                var NotifikasiTambahEdukasiBerhasil=$('#NotifikasiTambahEdukasiBerhasil').html();
                if(NotifikasiTambahEdukasiBerhasil=="Success"){
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
                        text: 'Tambah Edukasi Berhasil',
                        icon: 'success',
                        confirmButtonText: 'Tutup'
                    })
                }
            }
        });
    });
</script>