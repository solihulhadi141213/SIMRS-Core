<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/WebFunction.php";
    //Tangkap ruang rawat
    if(empty($_POST['ruang_rawat'])){
        $GetRuangRawat="";
    }else{
        $GetRuangRawat=$_POST['ruang_rawat'];
    }
    $UrlInfo=urlService('Info Ruang Rawat');
    $list_data=GetInfoRuangRawat($api_key,$UrlInfo,"ruang_rawat");
    $no=1;
    foreach($list_data as $value){
        if($GetRuangRawat==$value['ruang_rawat']){
            $ruang_rawat=$value['ruang_rawat'];
            $kelas_ruangan=$value['kelas_ruangan'];
            $kode_kelas=$value['kode_kelas'];
            $kapasitas=$value['kapasitas'];
            $pasien=$value['pasien'];
            $tersedia=$value['tersedia'];
            $status=$value['status'];
            $last_update=$value['last_update'];
?>
    <input type="hidden" name="ruang_rawat_lama" id="ruang_rawat_lama" value="<?php echo "$ruang_rawat"; ?>">
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="ruang_rawat">Ruang Rawat</label>
            <input type="text" class="form-control" name="ruang_rawat" id="ruang_rawat" value="<?php echo "$ruang_rawat"; ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="kelas">Kelas</label>
            <input type="text" class="form-control" name="kelas" id="kelas" value="<?php echo "$kelas_ruangan"; ?>">
        </div>
        <div class="col-md-6 mb-3">
            <label for="kode">Kode</label>
            <input type="text" class="form-control" name="kode" id="kode" value="<?php echo "$kode_kelas"; ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="kapasitas">Kapasitas</label>
            <input type="text" class="form-control" name="kapasitas" id="kapasitas" value="<?php echo "$kapasitas"; ?>">
        </div>
        <div class="col-md-6 mb-3">
            <label for="pasien">Pasien</label>
            <input type="text" class="form-control" name="pasien" id="pasien" value="<?php echo "$pasien"; ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
                <option <?php if($status==""){echo "selected";} ?> value="">Pilih</option>
                <option <?php if($status=="Aktif"){echo "selected";} ?> value="Aktif">Aktif</option>
                <option <?php if($status=="Non Aktif"){echo "selected";} ?> value="Non Aktif">Non Aktif</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3" id="NotifikasiEditRuangan">
            <span class="test-primary">Pastikan Data Ruangan Yang Anda Input Sudah Benar</span>
        </div>
    </div>
<?php
        }
    }
?>
