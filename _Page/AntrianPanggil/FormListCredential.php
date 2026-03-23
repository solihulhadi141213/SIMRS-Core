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
            echo '  </div>';
            echo '</div>';
        }else{
            $settingsData = json_decode(file_get_contents($settingsFile), true);
            $base_url_monitor=$settingsData['base-url-monitor'];
            $access_key=$settingsData['access-key'];
            //Kirim Request Ke Monitor
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => ''.$base_url_monitor.'/_Api/list-credential.php',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>'{
                    "access-key":"'.$access_key.'"
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
?>
            <div class="row">
                <div class="col-md-12 table table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <td class="text-center"><dt>No</dt></td>
                                <td class="text-center"><dt>Kode</dt></td>
                                <td class="text-center"><dt>Title/Subtitle</dt></td>
                                <td class="text-center"><dt>Position</dt></td>
                                <td class="text-center"><dt>Opsi</dt></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(empty(count($data_credential))){
                                    echo '<tr>';
                                    echo '  <td class="text-danger text-center" colspan="5">Tidak ADa Data Yang Ditampilkan</td>';
                                    echo '</tr>';
                                }else{
                                    $no=1;
                                    foreach($data_credential as $row){
                                        $kode_akses=$row['kode-akses'];
                                        $atribut_akses=$row['atribut-akses'];
                                        $title=$atribut_akses['title'];
                                        $subtitle=$atribut_akses['sub-title'];
                                        $position=$atribut_akses['antrian-position'];
                                        echo '<tr>';
                                        echo '  <td class="text-center">'.$no.'</td>';
                                        echo '  <td class="text-left">'.$kode_akses.'</td>';
                                        echo '  <td class="text-left">'.$title.'<br><small>'.$subtitle.'</small></td>';
                                        echo '  <td class="text-center">'.$position.'</td>';
                                        echo '  <td class="text-center">';
                                        echo '      <div class="btn-group">';
                                        echo '          <a href="javascript:void(0);" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalEditCredential" class="edit-credential" data-id="'.$kode_akses.'">';
                                        echo '              <i class="ti ti-pencil"></i>';
                                        echo '          </a>';
                                        echo '          <a href="javascript:void(0);" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#ModalHapusCredential" class="hapus-credential" data-id="'.$kode_akses.'">';
                                        echo '              <i class="ti ti-close"></i>';
                                        echo '          </a>';
                                        echo '      </div>';
                                        echo '  </td>';
                                        echo '</tr>';
                                        $no++;
                                    }
                                }
                            ?>  
                        </tbody>
                    </table>
                </div>
            </div>
<?php
                }
            }
        }
    }
?>