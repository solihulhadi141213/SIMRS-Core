<?php
    include "../../_Config/Connection.php";
    //Menangkap id apabila ada
    if(empty($_POST['id_dokter'])){
       echo '<div class="row">';
       echo '   <div class="col-md-12 mb-3 text-center text-danger">';
       echo '       ID Dokter Tidak Boleh Kosong!';
       echo '   </div>';
       echo '</div>';
    }else{
        $id_dokter=$_POST['id_dokter'];
?>
    <input type="hidden" id="id_dokter" name="id_dokter" value="<?php echo "$id_dokter"; ?>">
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="id_poliklinik">Pilih Poliklinik</label>
            <select name="id_poliklinik" id="id_poliklinik" class="form-control">
                <option value="">Pilih</option>
                <?php
                    include "../../_Config/Connection.php";
                    include "../../_Config/SettingKoneksiWeb.php";
                    include "../../_Config/WebFunction.php";
                    $url=urlService("List Poliklinik");
                    $keyword_by="";
                    $keyword="";
                    $short_by="ASC";
                    $order_by="nama";
                    $ListPoliklinik=GetListInline($api_key,$url,$keyword_by,$keyword,$short_by,$order_by);
                    $JumlahPoli=count($ListPoliklinik);
                    if(empty($JumlahPoli)){
                        echo '<option>Data Poliklinik Belum Ada</option>';
                    }else{
                        $no=1;
                        foreach($ListPoliklinik as $value){
                            $id_poliklinik=$value['id_poliklinik'];
                            $nama=$value['nama'];
                            echo '<option value="'.$id_poliklinik.'">'.$nama.'</option>';
                        }
                    }
                ?>
            </select>
        </div>
        <div class="col-md-12 mb-3">
            <label for="hari">Nama Hari</label>
            <select name="hari" id="hari" class="form-control">
                <option value="Senin">Senin</option>
                <option value="Selasa">Selasa</option>
                <option value="Rabu">Rabu</option>
                <option value="Kamis">Kamis</option>
                <option value="Jumat">Jumat</option>
                <option value="Sabtu">Sabtu</option>
                <option value="Minggu">Minggu</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="jam1">Jam Mulai</label>
            <input type="time" name="jam1" id="jam1" class="form-control">
        </div>
        <div class="col-md-6 mb-3">
            <label for="jam2">Jam Selesai</label>
            <input type="time" name="jam2" id="jam2" class="form-control">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="kuota_non_jkn">Kuota Non JKN</label>
            <input type="number" min="1" name="kuota_non_jkn" id="kuota_non_jkn" class="form-control">
        </div>
        <div class="col-md-6 mb-3">
            <label for="kuota_jkn">Kuota JKN</label>
            <input type="number" min="1" name="kuota_jkn" id="kuota_jkn" class="form-control">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="time_max">Waktu Maksimal Kedatangan</label>
            <input type="number" min="0" name="time_max" id="time_max" class="form-control">
            <small>Menit</small>
        </div>
    </div>
    <div class="row">
        <div class="col col-md-12 mb-3" id="NotifikasiTambahJadwalManual">
            <span class="text-primary">Pastikan semua data jadwal sudah terisi dengan benar</span>
        </div>
    </div>
<?php } ?>