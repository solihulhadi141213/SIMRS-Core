<?php
    //Koneksi ke database
    include "../../_Config/Connection.php";
    //Session
    include "../../_Config/Session.php";
    //Setting Bridging
    include "../../_Config/SettingBridging.php";
    //Fungsi Autoload
    include "../../vendor/autoload.php";
    //validasi data dari form
    if(empty($_POST['kode_dokter'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col col-md-12">';
        echo '          <div class="alert alert-danger alert-dismissible fade show" role="alert">';
        echo '              <b>Kode Dokter Tidak Boleh Kosong</b>';
        echo '          </div>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['tanggal'])){
            echo '<div class="modal-body">';
            echo '  <div class="row">';
            echo '      <div class="col col-md-12">';
            echo '          <div class="alert alert-danger alert-dismissible fade show" role="alert">';
            echo '              <b>Tanggal Jadwal Tidak Boleh Kosong</b>';
            echo '          </div>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $kode=$_POST['kode_dokter'];
            $tanggal=$_POST['tanggal'];
            // function decrypt
            function stringDecrypt($key, $string){
                $encrypt_method = 'AES-256-CBC';
                // hash
                $key_hash = hex2bin(hash('sha256', $key));
                // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
                $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);
                $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);
                return $output;
            }
            // function lzstring decompress 
            // download libraries lzstring : https://github.com/nullpunkt/lz-string-php
            function decompress($string){
                return \LZCompressor\LZString::decompressFromEncodedURIComponent($string);
            }
            //Timestamp
            date_default_timezone_set('UTC');
            $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));
            //Creat Signature
            $signature = hash_hmac('sha256', $cons_id_antrol."&".$tStamp, $secret_key_antrol, true);
            $encodedSignature = base64_encode($signature);
            $urlencodedSignature = urlencode($encodedSignature);
            // base64 encode…
            $encodedSignature_manual="LwwWyiWHrr+tTQexsodhb6aWLzs+8Ofo4or68g9jIJM=";
            $timestamp_manual="1646230513";
            $key="$cons_id_antrol$secret_key_antrol$tStamp";
            //Membuat header
            $headers = array(
                'Content-Type:Application/x-www-form-urlencoded',
                'X-cons-id: '.$cons_id_antrol .'',
                'X-timestamp: '.$tStamp.'' ,
                'X-signature: '.$encodedSignature.'',
                'user_key: '.$user_key_antrol.''
            ); 
            //Membuat URL
            $url="$url_antrol/jadwaldokter/kodepoli/$kode/tanggal/$tanggal";
            //Mulai CURL
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL, "$url");
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch,CURLOPT_HEADER, 0);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $content = curl_exec($ch);
            $err = curl_error($ch);
            curl_close($ch);
            $ambil_json =json_decode($content, true);
            if(empty($ambil_json["response"])){
                $pesan=$ambil_json["metadata"]["message"];
                echo '<div class="modal-body">';
                echo '  <div class="row">';
                echo '      <div class="col col-md-12">';
                echo '          <div class="alert alert-danger alert-dismissible fade show" role="alert">';
                echo '              <b>Tidak ada jadwal untuk tanggal '.$tanggal.'<br>  Keterangan : '.$pesan.'</b>';
                echo '          </div>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
            }else{
                $string=$ambil_json["response"];
                $metadata=$ambil_json["metadata"];
                $code=$metadata["code"];
                $message=$metadata["message"];
                $Terjemahkan=stringDecrypt($key, $string);
                $FileDekompresi=decompress("$Terjemahkan");
                $JsonData =json_decode($FileDekompresi, true);
                $JumlahJadwal=count($JsonData);
?>
    <div class="modal-body">
        <div class="row">
            <div class="col-12">
                <div class="table table-responsive pre-scrollable">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center"><dt>No</dt></th>
                                <th class="text-center"><dt>Hari</dt></th>
                                <th class="text-center"><dt>Poliklinik</dt></th>
                                <th class="text-center"><dt>spesialis</dt></th>
                                <th class="text-center"><dt>Nama Dokter</dt></th>
                                <th class="text-center"><dt>Jadwal</dt></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if($message!=="OK"){
                                    echo "<tr>
                                        <td colspan='3' class='text-center'>$message</td>
                                    </tr>";
                                }else{
                                    $no=1;
                                    for($a=0; $a<$JumlahJadwal; $a++){
                                        $kodesubspesialis=$JsonData[$a]['kodesubspesialis'];
                                        $hari=$JsonData[$a]['hari'];
                                        $kapasitaspasien=$JsonData[$a]['kapasitaspasien'];
                                        $libur=$JsonData[$a]['libur'];
                                        $namahari=$JsonData[$a]['namahari'];
                                        $jadwal=$JsonData[$a]['jadwal'];
                                        $namasubspesialis=$JsonData[$a]['namasubspesialis'];
                                        $namadokter=$JsonData[$a]['namadokter'];
                                        $kodedokter=$JsonData[$a]['kodedokter'];
                                        $kodepoli=$JsonData[$a]['kodepoli'];
                                        $namapoli=$JsonData[$a]['namapoli'];
                                        if($hari=="1"){
                                            $hari="Senin";
                                        }else{
                                            if($hari=="2"){
                                                $hari="Selasa";
                                            }else{
                                                if($hari=="3"){
                                                    $hari="Rabu";
                                                }else{
                                                    if($hari=="4"){
                                                        $hari="Kamis";
                                                    }else{
                                                        if($hari=="5"){
                                                            $hari="Jumat";
                                                        }else{
                                                            if($hari=="6"){
                                                                $hari="Sabtu";
                                                            }else{
                                                                if($hari=="7"){
                                                                    $hari="Minggu";
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        echo '<tr>';
                                        echo '  <td class="text-center">'.$no.'</td>';
                                        echo '  <td>'.$hari.'</td>';
                                        echo '  <td>'.$kodepoli.'-'.$namapoli.'</td>';
                                        echo '  <td>'.$kodesubspesialis.'-'.$namasubspesialis.'</td>';
                                        echo '  <td>'.$kodedokter.'-'.$namadokter.'</td>';
                                        echo '  <td>'.$jadwal.'</td>';
                                        echo '</tr>';
                                    $no++;}
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
    </div>
<?php }}} ?>