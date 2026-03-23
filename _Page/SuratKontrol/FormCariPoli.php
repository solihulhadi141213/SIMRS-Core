<?php
    //Koneksi dan session
    date_default_timezone_set('UTC');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingBridging.php";
    //Menangkap variabel
    if(empty($_POST['JenisKontrol'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-danger">';
        echo '          Jenis Kontrol Tidak Boleh Kosong!!';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center">';
        echo '          <button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Tutup</button>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['Nomor'])){
            echo '<div class="modal-body">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-danger">';
            echo '          Nomor Kartu/SEP Tidak Boleh Kosong!!';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
            echo '<div class="modal-footer">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-center">';
            echo '          <button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Tutup</button>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            if(empty($_POST['tglRencanaKontrol'])){
                echo '<div class="modal-body">';
                echo '  <div class="row">';
                echo '      <div class="col-md-12 text-danger">';
                echo '          Tanggal Rencana Kontrol Tidak Boleh Kosong!!';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
            }else{
                $JenisKontrol=$_POST['JenisKontrol'];
                $Nomor=$_POST['Nomor'];
                $tglRencanaKontrol=$_POST['tglRencanaKontrol'];
                include "../../vendor/autoload.php";
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
                $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                //Creat Signature
                $signature = hash_hmac('sha256', $consid."&".$timestamp, $secret_key, true);
                // base64 encode…
                $encodedSignature = base64_encode($signature);
                //Membuat header
                $headers = array(
                    'X-signature: '.$encodedSignature.'',
                    'X-timestamp: '.$timestamp.'' ,
                    'X-cons-id: '.$consid .'',
                    'user_key: '.$user_key.'',
                    'Content-Type:Application/x-www-form-urlencoded'         
                ); 
                //Membuat URL
                $TanggalSekarang=date('Y-m-d');
                $URLUtama=$url_vclaim;
                $URLKatalog="RencanaKontrol/ListSpesialistik/JnsKontrol/$JenisKontrol/nomor/$Nomor/TglRencanaKontrol/$tglRencanaKontrol";
                $url="$URLUtama$URLKatalog";
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
                $string=$ambil_json["response"];
                //Proses decode dan dekompresi
                //--membuat key
                $key="$consid$secret_key$timestamp";
                //--masukan ke fungsi
                $FileDeskripsi=stringDecrypt("$key", "$string");
                $FileDekompresi=decompress("$FileDeskripsi");
                //--konveris json to raw
                $JsonData =json_decode($FileDekompresi, true);
                //--Get row poli
                $list=$JsonData['list'];
                //--Hitung jumlah list
                $Jumlah=count($list);
                if(empty($Jumlah)){
                    echo '<div class="modal-body">';
                    echo '  <div class="row">';
                    echo '      <div class="col-md-12 text-danger">';
                    echo '          Data hasil Pencarian Tidak ada!!';
                    echo '      </div>';
                    echo '  </div>';
                    echo '</div>';
                }
?>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="table table-responsive pre-scrollable">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center"><dt>No</dt></th>
                                <th class="text-center"><dt>Kode</dt></th>
                                <th class="text-center"><dt>Poli</dt></th>
                                <th class="text-center"><dt>Kapasitas</dt></th>
                                <th class="text-center"><dt>Jumlah</dt></th>
                                <th class="text-center"><dt>Persentase</dt></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no=1;
                                for($a=0; $a<$Jumlah; $a++){
                                    $kodePoli=$list[$a]['kodePoli'];
                                    $namaPoli=$list[$a]['namaPoli'];
                                    $kapasitas=$list[$a]['kapasitas'];
                                    $jmlRencanaKontroldanRujukan=$list[$a]['jmlRencanaKontroldanRujukan'];
                                    $persentase=$list[$a]['persentase'];
                                    echo '<tr>';
                                    echo '  <td class="text-center">'.$no.'</td>';
                                    echo '  <td><button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#ModalKonfirmasiPilihPoli" data-id="'.$kodePoli.'">'.$kodePoli.'</button></td>';
                                    echo '  <td>'.$namaPoli.'</td>';
                                    echo '  <td>'.$kapasitas.'</td>';
                                    echo '  <td>'.$jmlRencanaKontroldanRujukan.'</td>';
                                    echo '  <td>'.$persentase.'</td>';
                                    echo '</tr>';
                                $no++;}
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="row">
            <div class="col-md-12">
                <button type="button" class="btn btn-md btn-grd-danger btn-round" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
<?php
            }
        }
    }

?>