<div class="row">
    <?php
        //Zona Waktu
        date_default_timezone_set('UTC');
        //Koneksi
        include "../../_Config/Connection.php";
        //SettingBridging
        include "../../_Config/SettingBridging.php";
        //Membuat fungsi
        include "../../vendor/autoload.php";
        //FaskesBy
        if(empty($_POST['FaskesBy'])){
            echo '<div class="card-body">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-danger">';
            echo '          Maaf, Faskes Tidak Boleh Kosong';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            //SearchBy
            if(empty($_POST['SearchBy'])){
                echo '<div class="card-body">';
                echo '  <div class="row">';
                echo '      <div class="col-md-12 text-danger">';
                echo '          Maaf, Dasar Pencarian Tidak Boleh Kosong';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
            }else{
                //keyword
                if(empty($_POST['keyword'])){
                    echo '<div class="card-body">';
                    echo '  <div class="row">';
                    echo '      <div class="col-md-12 text-danger">';
                    echo '          Maaf, Keyword Pencarian Tidak Boleh Kosong';
                    echo '      </div>';
                    echo '  </div>';
                    echo '</div>';
                }else{
                    $FaskesBy=$_POST['FaskesBy'];
                    $SearchBy=$_POST['SearchBy'];
                    $keyword=$_POST['keyword'];
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
                    if($FaskesBy=="1"){
                        if($SearchBy=="NoKartu"){
                            $URLKatalog="Rujukan/Peserta/$keyword";
                        }else{
                            if($SearchBy=="NoKartuMulti"){
                                $URLKatalog="Rujukan/List/Peserta/$keyword";
                            }else{
                                $URLKatalog="Rujukan/$keyword";
                            }
                        }
                    }else{
                        if($SearchBy=="NoKartu"){
                            $URLKatalog="Rujukan/RS/Peserta/$keyword";
                        }else{
                            if($SearchBy=="NoKartuMulti"){
                                $URLKatalog="Rujukan/RS/List/Peserta/$keyword";
                            }else{
                                $URLKatalog="Rujukan/RS/$keyword";
                            }
                        }
                    }
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
                    $code=$ambil_json["metaData"]["code"];
                    $message=$ambil_json["metaData"]["message"];
                    $string=$ambil_json["response"];
                    if($code!=="200"){
                        echo '<div class="col-md-12 text-center">';
                        echo '  <dt class="text-danger">Koneksi Error</dt>';
                        echo '  Keterangan :'.$message.'<br>';
                        echo '  <small>URL :'.$url.'</small><br>';
                        echo '</div>';
                    }else{
                        //Proses decode dan dekompresi
                        //--membuat key
                        $key="$consid$secret_key$timestamp";
                        //--masukan ke fungsi
                        $FileDeskripsi=stringDecrypt("$key", "$string");
                        $FileDekompresi=decompress("$FileDeskripsi");
                        //--konveris json to raw
                        $JsonData =json_decode($FileDekompresi, true);
                        if($SearchBy=="NoKartuMulti"){
                            //--Get row poli
                            $list=$JsonData['rujukan'];
                            //--Hitung jumlah list
                            $Jumlah=count($list);
                            if(empty($Jumlah)){
                                echo '<div class="col-md-12 text-center">';
                                echo '  <dt class="text-primary">Koneksi Berhasil</dt>';
                                echo '  Keterangan :'.$message.'<br>';
                                echo '  <small>URL: '.$url.'</small>';
                                echo '</div>';
                            }else{
                                $no=1;
                                for($a=0; $a<$Jumlah; $a++){
                                    $noKunjungan=$list[$a]['noKunjungan'];
                                    $keluhan=$list[$a]['keluhan'];
                                    $tglKunjungan=$list[$a]['tglKunjungan'];
                                    //Diagnosa
                                    $KodeDiagnosa=$list[$a]['diagnosa']['kode'];
                                    $NamaDiagnosa=$list[$a]['diagnosa']['nama'];
                                    //pelayanan
                                    $KodePelayanan=$list[$a]['pelayanan']['kode'];
                                    $NamaPelayanan=$list[$a]['pelayanan']['nama'];
                                    //Poli rujukan
                                    $KodePoliRujukan=$list[$a]['poliRujukan']['kode'];
                                    $NamaPoliRujukan=$list[$a]['poliRujukan']['nama'];
                                    //Provider Perujuk
                                    $KodeProvider=$list[$a]['provPerujuk']['kode'];
                                    $NamaProvider=$list[$a]['provPerujuk']['nama'];
                                    //Peserta COB
                                    $nmAsuransi=$list[$a]['peserta']['cob']['nmAsuransi'];
                                    $noAsuransi=$list[$a]['peserta']['cob']['noAsuransi'];
                                    $tglTAT=$list[$a]['peserta']['cob']['tglTAT'];
                                    $tglTMT=$list[$a]['peserta']['cob']['tglTMT'];
                                    //Hak kelas
                                    $KeteranganhakKelas=$list[$a]['peserta']['hakKelas']['keterangan'];
                                    $KodeHakKelas=$list[$a]['peserta']['hakKelas']['kode'];
                                    //Informasi
                                    $dinsos=$list[$a]['peserta']['informasi']['dinsos'];
                                    $noSKTM=$list[$a]['peserta']['informasi']['noSKTM'];
                                    $prolanisPRB=$list[$a]['peserta']['informasi']['prolanisPRB'];
                                    //Jenis Peserta
                                    $keteranganJenisPeserta=$list[$a]['peserta']['jenisPeserta']['keterangan'];
                                    $KodeJenisPeserta=$list[$a]['peserta']['jenisPeserta']['kode'];
                                    //Tampilkan dalam Card
                                    echo '<div class="col-md-4 text-left">';
                                    echo '  <dt class="text-primary">'.$noKunjungan.'</dt>';
                                    echo '  <small>Keluhan : '.$keluhan.'</small><br>';
                                    echo '  <small>Tanggal : '.$tglKunjungan.'</small><br>';
                                    echo '  <small>Pelayanan : '.$KodePelayanan.'-'.$NamaPelayanan.'</small><br>';
                                    echo '  <small>Diagnosa : '.$KodeDiagnosa.'-'.$NamaDiagnosa.'</small><br>';
                                    echo '  <small>Provider : '.$KodeProvider.'-'.$NamaProvider.'</small><br>';
                                    echo '  <small>Hak Kelas : '.$KodeHakKelas.'-'.$KeteranganhakKelas.'</small><br>';
                                    echo '  <small>Jenis Peserta : '.$KodeJenisPeserta.'-'.$keteranganJenisPeserta.'</small><br>';
                                    echo '</div>';
                                $no++;}
                            }
                        }else{
                            $rujukan=$JsonData['rujukan'];
                            $keluhan=$rujukan['keluhan'];
                            $tglKunjungan=$rujukan['tglKunjungan'];
                            $noKunjungan=$rujukan['noKunjungan'];
                            //Diagnosa
                            $KodeDiagnosa=$rujukan['diagnosa']['kode'];
                            $NamaDiagnosa=$rujukan['diagnosa']['nama'];
                            //Pelayanan
                            $KodePelayanan=$rujukan['pelayanan']['kode'];
                            $namaPelayanan=$rujukan['pelayanan']['nama'];
                            //Peserta COB
                            $nmAsuransi=$rujukan['peserta']['cob']['nmAsuransi'];
                            $noAsuransi=$rujukan['peserta']['cob']['noAsuransi'];
                            $tglTAT=$rujukan['peserta']['cob']['tglTAT'];
                            $tglTMT=$rujukan['peserta']['cob']['tglTMT'];
                            //Hak kelas
                            $KeteranganHakKelas=$rujukan['peserta']['hakKelas']['keterangan'];
                            $KodeHakKelas=$rujukan['peserta']['hakKelas']['kode'];
                            //Informasi
                            $dinsos=$rujukan['peserta']['informasi']['dinsos'];
                            $noSKTM=$rujukan['peserta']['informasi']['noSKTM'];
                            $prolanisPRB=$rujukan['peserta']['informasi']['prolanisPRB'];
                            //Poli Rujukan
                            $KodePoliRujukan=$rujukan['peserta']['poliRujukan']['kode'];
                            $NamaPoliRujukan=$rujukan['peserta']['poliRujukan']['nama'];
                            //Poli Rujukan
                            $KodeProvPerujuk=$rujukan['peserta']['provPerujuk']['kode'];
                            $NamaprovPerujuk=$rujukan['peserta']['provPerujuk']['nama'];
                            //Jenis peserta
                            $keteranganJenisPeserta=$rujukan['peserta']['jenisPeserta']['keterangan'];
                            $KodeJenisPeserta=$rujukan['peserta']['jenisPeserta']['kode'];
                            echo '<div class="col-md-4 text-left">';
                            echo '  <dt class="text-primary">'.$noKunjungan.'</dt>';
                            echo '  <small>Keluhan : '.$keluhan.'</small><br>';
                            echo '  <small>Tanggal : '.$tglKunjungan.'</small><br>';
                            echo '  <small>Pelayanan : '.$KodePelayanan.'-'.$namaPelayanan.'</small><br>';
                            echo '  <small>Diagnosa : '.$KodeDiagnosa.'-'.$NamaDiagnosa.'</small><br>';
                            echo '  <small>Provider : '.$KodeProvPerujuk.'-'.$NamaprovPerujuk.'</small><br>';
                            echo '  <small>Hak Kelas : '.$KodeHakKelas.'-'.$KeteranKeteranganHakKelasganhakKelas.'</small><br>';
                            echo '  <small>Jenis Peserta : '.$KodeJenisPeserta.'-'.$keteranganJenisPeserta.'</small><br>';
                            echo '</div>';
                        }
                    }
                }
            }
        }
    ?>
</div>