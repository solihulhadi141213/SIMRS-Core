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
        //Tangkap kode_akses
        if(empty($_POST['kode_akses'])){
            echo '<div class="row mb-3"> ';
            echo '  <div class="col-md-12 text-center text-danger">';
            echo '      Kode Akses Tidak Boleh Kosong!';
            echo '  </div>';
            echo '</div>';
        }else{
            $kode_akses=$_POST['kode_akses'];
            //Buka File Setting
            $settingsFile="setting-koneksi.json";
            if(!file_exists($settingsFile)) {
                //Apabila File Tidak Ada
                echo '<div class="row mb-3"> ';
                echo '  <div class="col-md-12 text-center text-danger">';
                echo '      File Setting Tidak Ditemukan';
                echo '  </div>';
                echo '</div>';
            }else{
                $settingsData = json_decode(file_get_contents($settingsFile), true);
                $base_url_monitor=$settingsData['base-url-monitor'];
                $access_key=$settingsData['access-key'];
                //Kirim Request Ke Monitor
                $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => ''.$base_url_monitor.'/_Api/get-detail-credential.php',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>'{
                    "access-key":"'.$access_key.'",
                    "kode-akses":"'.$kode_akses.'"
                }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
                ));
                $response = curl_exec($curl);
                curl_close($curl);
                if(empty($response)){
                    echo '<div class="row mb-3"> ';
                    echo '  <div class="col-md-12 text-center text-danger">';
                    echo '      Tidak Ada Response Dari Monitor Antrian';
                    echo '  </div>';
                    echo '</div>';
                }else{
                    $arry=json_decode($response,true);
                    if($arry['code']!==200){
                        echo '<div class="row mb-3"> ';
                        echo '  <div class="col-md-12 text-center text-danger">';
                        echo '      Response Monitor : '.$arry['error'].'';
                        echo '  </div>';
                        echo '</div>';
                    }else{
                        $data_credential=$arry['data'];
                        $title=$data_credential['title'];
                        $sub_title=$data_credential['sub-title'];
                        $antrian_position=$data_credential['antrian-position'];
?>
                        <div class="row mb-3">
                            <div class="col-md-4">Title/Judul</div>
                            <div class="col-md-8 text-secondary get-title"><?php echo "$title"; ?></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Sub Title</div>
                            <div class="col-md-8 text-secondary get-sub-title"><?php echo "$sub_title"; ?></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">Position</div>
                            <div class="col-md-8 text-secondary get-antrian-position"><?php echo "$antrian_position"; ?></div>
                        </div>
<?php
                    }
                }
            }
        }
    }
?>
<script>
    $(document).ready(function () {
        var get_title=$('.get-title').html();
        var get_sub_title=$('.get-sub-title').html();
        var get_antrian_position=$('.get-antrian-position').html();
        //Tambahkan Ke Form
        $('#title_monitor').val(get_title);
        $('#sub_title_monitor').val(get_sub_title);
    });
</script>