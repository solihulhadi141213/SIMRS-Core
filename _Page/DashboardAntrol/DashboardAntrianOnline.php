<?php
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingBridging.php";
    include "../../vendor/autoload.php";
    //menangkap data
    if(empty($_POST['mode'])){
        echo "<span class='text-danger'>Mode Data Tidak Boleh Kosong</span>";
    }else{
        $mode=$_POST['mode'];
        if($mode=="Harian"){
            if(empty($_POST['tanggal'])){
                echo "<span class='text-danger'>Tanggal Harus Diisi</span>";
            }else{
                $tanggal=$_POST['tanggal'];
                $waktu=$_POST['waktu'];
                $Validasi="Oke";
                $url="$url_antrol/dashboard/waktutunggu/tanggal/$tanggal/waktu/$waktu";
            }
        }else{
            if(empty($_POST['bulan'])){
                echo "<span class='text-danger'>Form Bulan Harus Diisi</span>";
            }else{
                if(empty($_POST['tahun'])){
                    echo "<span class='text-danger'>Form Tahun Harus Diisi</span>";
                }else{
                    $bulan=$_POST['bulan'];
                    $tahun=$_POST['tahun'];
                    $Validasi="Oke";
                    $waktu=$_POST['waktu'];
                    $url="$url_antrol/dashboard/waktutunggu/bulan/$bulan/tahun/$tahun/waktu/$waktu";
                }
            }
        }
    }
    if($Validasi!=="Oke"){
        echo "<span class='text-danger'><br>Maaf Data Tidak Bisa Ditampilkan</span>";
    }else{
        //menampilkan LIST task ID
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
        //Mulai CURL
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "$url");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        $ambil_json =json_decode($content, true);
        if(empty($ambil_json["response"])){
            $pesan=$ambil_json["metadata"]["message"];
            echo '<span class="text-center text-danger"><b>Keterangan :</b> '.$pesan.'</span>';
        }else{
            $string=$ambil_json["response"]["list"];
            $metadata=$ambil_json["metadata"];
            $code=$metadata["code"];
            $message=$metadata["message"];
            // $Terjemahkan=stringDecrypt($key, $string);
            // $FileDekompresi=decompress("$Terjemahkan");
            $JsonData =$string;
            $JumlahTaskID=count($string);
            //menampilkan Data
            if($code==200){
                echo "<div class='table table-responsive'>";
                echo "  <table class='table table-bordered table-hover'>";
                echo "      <thead>";
                echo "          <tr>";
                echo '              <th class="text-center"><dt>No</dt></th>';
                echo '              <th class="text-center"><dt>Poli</dt></th>';
                echo '              <th class="text-center"><dt>Antran</dt></th>';
                echo '              <th class="text-center"><dt>TI1</dt></th>';
                echo '              <th class="text-center"><dt>TI2</dt></th>';
                echo '              <th class="text-center"><dt>TI3</dt></th>';
                echo '              <th class="text-center"><dt>TI4</dt></th>';
                echo '              <th class="text-center"><dt>TI5</dt></th>';
                echo '              <th class="text-center"><dt>TI6</dt></th>';
                echo '              <th class="text-center"><dt>Insert Date</dt></th>';
                echo '          </tr>';
                echo '      </thead>';
                $no=1;
                for($a=0; $a<$JumlahTaskID; $a++){
                    $kdppk=$JsonData[$a]['kdppk'];
                    $waktu_task1=$JsonData[$a]['waktu_task1'];
                    $avg_waktu_task4=$JsonData[$a]['avg_waktu_task4'];
                    $jumlah_antrean=$JsonData[$a]['jumlah_antrean'];
                    $avg_waktu_task3=$JsonData[$a]['avg_waktu_task3'];
                    $namapoli=$JsonData[$a]['namapoli'];
                    $avg_waktu_task6=$JsonData[$a]['avg_waktu_task6'];
                    $avg_waktu_task5=$JsonData[$a]['avg_waktu_task5'];
                    $nmppk=$JsonData[$a]['nmppk'];
                    $avg_waktu_task2=$JsonData[$a]['avg_waktu_task2'];
                    $avg_waktu_task1=$JsonData[$a]['avg_waktu_task1'];
                    $kodepoli=$JsonData[$a]['kodepoli'];
                    $waktu_task5=$JsonData[$a]['waktu_task5'];
                    $waktu_task4=$JsonData[$a]['waktu_task4'];
                    $waktu_task3=$JsonData[$a]['waktu_task3'];
                    $insertdate=$JsonData[$a]['insertdate'];
                    $tanggal=$JsonData[$a]['tanggal'];
                    $waktu_task2=$JsonData[$a]['waktu_task2'];
                    $waktu_task6=$JsonData[$a]['waktu_task6'];
                    $InsertDate=date("d/m/Y H:i", ($insertdate / 1000) );
                    echo "      <tbody>";
                    echo "          <tr>";
                    echo '              <td class="text-center">'.$no.'</td>';
                    echo '              <td class="text-left"><dt>'.$kodepoli.'</dt>'.$namapoli.'</td>';
                    echo '              <td class="text-center">'.$jumlah_antrean.'</td>';
                    echo '              <td class="text-center"><dt>'.$waktu_task1.'</dt>'.$avg_waktu_task1.' Sec</td>';
                    echo '              <td class="text-center"><dt>'.$waktu_task2.'</dt>'.$avg_waktu_task2.' Sec</td>';
                    echo '              <td class="text-center"><dt>'.$waktu_task3.'</dt>'.$avg_waktu_task3.' Sec</td>';
                    echo '              <td class="text-center"><dt>'.$waktu_task4.'</dt>'.$avg_waktu_task4.' Sec</td>';
                    echo '              <td class="text-center"><dt>'.$waktu_task5.'</dt>'.$avg_waktu_task5.' Sec</td>';
                    echo '              <td class="text-center"><dt>'.$waktu_task6.'</dt>'.$avg_waktu_task6.' Sec</td>';
                    echo '              <td class="text-left"><small>'.$InsertDate.'</small></td>';
                    echo '          </tr>';
                    echo '      </tbody>';
                $no++;}
                echo "  </table>";
                echo "</div>";
                // echo "$content";
            }else{
                echo '<span class="text-center text-danger"><b>Keterangan :</b> '.$message.'</span>';
            }
        }
    }
?>