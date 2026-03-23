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
            <input type="hidden" name="access_key" value="<?php echo "$access_key"; ?>">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="title_credential">Title/Judul</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="title_credential" id="title_credential" class="form-control" placeholder="Contoh : Poliklinik Penyakit Dalam">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="sub_title_credential">Sub Title</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="sub_title_credential" id="sub_title_credential" class="form-control" placeholder="dr. Laudry Amsal Elfa Gustanar., Sp.PD">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-sm btn-primary btn-block">
                        <i class="ti ti-plus"></i> Tambah Credential
                    </button>
                </div>
            </div>
<?php
        }
    }
?>