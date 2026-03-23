<?php
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi ke database
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    //Buka Pengaturan SIRS Online
    $x_id_rs=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','id_rs');
    $url_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','url_sirs_online');
    $password_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','password_sirs_online');
    //Tangkap id_antrian
    if(empty($_POST['id_shk'])){
        echo '  <div class="row">';
        echo '      <div class="col-md-12 mb-3 text-center text-danger">';
        echo '          ID SHK Tidak Boleh Kosong';
        echo '      </div>';
        echo '  </div>';
    }else{
        $id_shk=$_POST['id_shk'];
?>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <label for="id_shk">ID SHK</label>
            </div>
            <div class="col col-md-8">
                <input type="text" class="form-control" name="id_shk" id="id_shk" value="<?php echo "$id_shk"; ?>">
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <label for="id_shk">Jenis Pmeriksaan</label>
            </div>
            <div class="col col-md-8">
                <select name="jenis_pemeriksaan" id="jenis_pemeriksaan" class="form-control">
                    <option value="">Pilih</option>
                    <option value="1">Pemeriksaan TSH</option>
                    <option value="2">Pemeriksaan Tes Konfirmasi</option>
                </select>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <label for="hasil_pemeriksaan">Hasil Pmeriksaan</label>
            </div>
            <div class="col col-md-8">
                <select name="hasil_pemeriksaan" id="hasil_pemeriksaan" class="form-control">
                    <option value="">Pilih</option>
                    <option value="1">Normal</option>
                    <option value="2">Tinggi</option>
                </select>
            </div>
        </div>
        <div class="row mb-3" id="FormHasilPemeriksaan"> 
            <div class="col col-md-4">
                <label for="hasil_pemeriksaan">Hasil Pmeriksaan</label>
            </div>
            <div class="col col-md-8">
                <select name="hasil_pemeriksaan" id="hasil_pemeriksaan" class="form-control">
                    <option value="">Pilih</option>
                    <option value="1">Normal</option>
                    <option value="2">Tinggi</option>
                </select>
            </div>
        </div>
<?php } ?>