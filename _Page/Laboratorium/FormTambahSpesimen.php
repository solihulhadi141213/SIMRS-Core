<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_permintaan
    if(empty($_POST['id_lab'])){
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center mb-3">';
        echo '         ID Lab Tidak Boleh Kosong!.';
        echo '      </div>';
        echo '  </div>';
    }else{
        $id_lab=$_POST['id_lab'];
?>
    <input type="hidden" name="id_lab" id="id_lab" value="<?php echo "$id_lab"; ?>">
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="tanggal_pengambilan"><dt>Tanggal</dt></label>
        </div>
        <div class="col-md-8">
            <input type="date" id="tanggal_pengambilan" name="tanggal_pengambilan" class="form-control" value="<?php echo date('Y-m-d'); ?>">
            <small>Tanggal Pengambilan Spesimen</small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="waktu_pengambilan"><dt>Waktu/Jam</dt></label>
        </div>
        <div class="col-md-8">
            <input type="time" id="waktu_pengambilan" name="waktu_pengambilan" class="form-control" value="<?php echo date('H:i'); ?>">
            <small>Jam Pengambilan Spesimen</small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="sumber">
                <dt>Sumber Spesimen</dt>
                <small>(Darah, Urine, Rambut dll )</small>
            </label>
        </div>
        <div class="col-md-8">
            <input type="text" id="sumber" name="sumber" class="form-control" list="ListSumberSpesimen">
            <datalist id="ListSumberSpesimen">
                <?php
                    //Menampilkan datalist Sumber Spesimen
                    $QrySumber = mysqli_query($Conn, "SELECT DISTINCT sumber FROM laboratorium_sample");
                    while ($DataSumber = mysqli_fetch_array($QrySumber)) {
                        if(!empty($DataSumber['sumber'])){
                            $ListSumber= $DataSumber['sumber'];
                            echo '<option value="'. $ListSumber.'">';
                        }
                    }
                ?>
            </datalist>
            <small>Klik 2X pada form untuk melihat datalist sumber spesimen.</small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="lokasi_pengambilan">
                <dt>Lokasi Spesimen</dt>
                <small>(Bagian anggota tubuh spesimen)</small>
            </label>
        </div>
        <div class="col-md-8">
            <input type="text" id="lokasi_pengambilan" name="lokasi_pengambilan" class="form-control" list="ListLokasiSpesimen">
            <datalist id="ListLokasiSpesimen">
                <?php
                    //Menampilkan datalist Sumber Spesimen
                    $QryLokasi = mysqli_query($Conn, "SELECT DISTINCT lokasi_pengambilan FROM laboratorium_sample");
                    while ($DataLokasi = mysqli_fetch_array($QryLokasi)) {
                        if(!empty($DataLokasi['lokasi_pengambilan'])){
                            $ListLokasi= $DataLokasi['lokasi_pengambilan'];
                            echo '<option value="'. $ListLokasi.'">';
                        }
                    }
                ?>
            </datalist>
            <small>Klik 2X pada form untuk melihat datalist lokasi spesimen.</small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="jumlah_sample">
                <dt>Jumlah Spesimen</dt>
            </label>
        </div>
        <div class="col-md-8">
            <input type="text" id="jumlah_sample" name="jumlah_sample" class="form-control">
            <small>Jumlah slice/potongan spesimen</small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="volume_sample">
                <dt>Volume Sample</dt>
            </label>
        </div>
        <div class="col-md-8">
            <input type="text" id="volume_sample" name="volume_sample" class="form-control">
            <small>Jumlah kuantitas spesimen yang akan diperiksa</small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="metode">
                <dt>Metode Pengambilan</dt>
                <small>(Eksisi, kerokan, operasi, aspirasi/biopsi, dan lain-lain)</small>
            </label>
        </div>
        <div class="col-md-8">
            <input type="text" id="metode" name="metode" class="form-control" list="ListMetode">
            <datalist id="ListMetode">
                <?php
                    //Menampilkan datalist Sumber Spesimen
                    $QryMetode = mysqli_query($Conn, "SELECT DISTINCT metode FROM laboratorium_sample");
                    while ($DataMetode = mysqli_fetch_array($QryMetode)) {
                        if(!empty($DataMetode['metode'])){
                            $ListMetode= $DataMetode['metode'];
                            echo '<option value="'. $ListMetode.'">';
                        }
                    }
                ?>
            </datalist>
            <small>Klik 2X pada form untuk melihat datalist metode pengambilan spesimen.</small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="kondisi">
                <dt>Kondisi Spesimen</dt>
                <small>(warna, bau, kekeruhan, dst)</small>
            </label>
        </div>
        <div class="col-md-8">
            <input type="text" id="kondisi" name="kondisi" class="form-control" list="ListKondisi">
            <datalist id="ListKondisi">
                <?php
                    //Menampilkan datalist Sumber Spesimen
                    $QryKondisi = mysqli_query($Conn, "SELECT DISTINCT kondisi FROM laboratorium_sample");
                    while ($DataKondisi = mysqli_fetch_array($QryKondisi)) {
                        if(!empty($DataKondisi['kondisi'])){
                            $ListKondisi= $DataKondisi['kondisi'];
                            echo '<option value="'. $ListKondisi.'">';
                        }
                    }
                ?>
            </datalist>
            <small>Klik 2X pada form untuk melihat datalist kondisi spesimen.</small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="tanggal_fiksasi">
                <dt>Tanggal Fiksasi</dt>
            </label>
        </div>
        <div class="col-md-8">
            <input type="date" id="tanggal_fiksasi" name="tanggal_fiksasi" class="form-control" value="<?php echo date('Y-m-d'); ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="jam_fiksasi">
                <dt>Jam/Waktu Fiksasi</dt>
            </label>
        </div>
        <div class="col-md-8">
            <input type="time" id="jam_fiksasi" name="jam_fiksasi" class="form-control" value="<?php echo date('H:i'); ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="cairan_fiksasi">
                <dt>Cairan Fiksasi</dt>
            </label>
        </div>
        <div class="col-md-8">
            <input type="text" id="cairan_fiksasi" name="cairan_fiksasi" class="form-control">
            <small>Nama bahan cairan fiksasi yang digunakan untuk fiksasi pada jaringan</small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="volume_fiksasi">
                <dt>Volume Fiksasi</dt>
            </label>
        </div>
        <div class="col-md-8">
            <input type="text" id="volume_fiksasi" name="volume_fiksasi" class="form-control">
            <small>Jumlah kuantitas dari cairan fiksasi yang digunakan pada spesimen</small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="petugas_sample">
                <dt>Petugas Spesimen</dt>
            </label>
        </div>
        <div class="col-md-8">
            <input type="text" id="petugas_sample" name="petugas_sample" class="form-control">
            <small>Petugas Yang Mengambil spesimen</small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="petugas_pengantar">
                <dt>Petugas Pengantar</dt>
            </label>
        </div>
        <div class="col-md-8">
            <input type="text" id="petugas_pengantar" name="petugas_pengantar" class="form-control">
            <small>Petugas Yang Mengantar spesimen</small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="petugas_penerima">
                <dt>Petugas Penerima</dt>
            </label>
        </div>
        <div class="col-md-8">
            <input type="text" id="petugas_penerima" name="petugas_penerima" class="form-control">
            <small>Petugas Yang Menerima spesimen</small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="status">
                <dt>Status</dt>
            </label>
        </div>
        <div class="col-md-8">
            <select name="status" id="status" class="form-control">
                <option value="Terdaftar">Terdaftar</option>
                <option value="Proses">Proses</option>
                <option value="Selesai">Selesai</option>
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12" id="NotifikasiTambahSpesimen">
            <span>Pastikan Informasi Spesimen Telah Terisi Dengan Benar!</span>
        </div>
    </div>
<?php } ?>