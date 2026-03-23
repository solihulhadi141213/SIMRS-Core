<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi ke database
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingAkses.php";
    //Cek Apakah User Punya Akses masuk
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'nTuLofvV0Y');
    if($StatusAkses!=="Yes"){
        //Apabila File Tidak Ada
        echo '<div class="row mb-3"> ';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      Anda Tidak Punya Ijin Untuk Masuk Ke Halaman Ini!';
        echo '  </div>';
        echo '</div>';
    }else{
        //Buka Data
        $settingsFile="setting-koneksi.json";
        if(!file_exists($settingsFile)) {
            //Apabila File Tidak Ada
            echo '<div class="row mb-3"> ';
            echo '  <div class="col-md-12 text-center text-danger">';
            echo '      File Setting Tidak Ditemukan';
            echo '';
            echo '  </div>';
            echo '</div>';
        }else{
            $settingsData = json_decode(file_get_contents($settingsFile), true);
            $base_url_monitor=$settingsData['base-url-monitor'];
            $access_key=$settingsData['access-key'];
?>
    <div class="row mb-3"> 
        <div class="col-md-4">
            <label for="base_url_monitor">Base URL Monitor</label>
        </div>
        <div class="col-md-8">
            <input type="text" class="form-control" name="base_url_monitor" id="base_url_monitor" value="<?php echo $base_url_monitor; ?>">
        </div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-4">
            <label for="access_key">Access Key</label>
        </div>
        <div class="col-md-8">
            <input type="text" class="form-control" name="access_key" id="access_key" value="<?php echo $access_key; ?>">
        </div>
    </div>
<?php 
        } 
    } 
?>