<?php
    //Zona Waktu
    date_default_timezone_set('UTC');
    //Koneksi
    include "../../_Config/Connection.php";
    //SettingBridging
    include "../../_Config/SettingBridging.php";
    //Membuat fungsi
    include "../../vendor/autoload.php";
    if(empty($_POST['nik'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12">';
        echo '      <div class="alert alert-danger" role="alert">NIK Pasien Tidak Boleh Kosong!</div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $nik=$_POST['nik'];
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
        $URLKatalog="Peserta/nik/$nik/tglSEP/$TanggalSekarang";
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
        //Verifikasi
        if(empty($JsonData["peserta"]["nama"])){
            echo '<div class="row">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-danger" role="alert">NIK Pasien Tidak Ditemukan!</div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $nama=$JsonData["peserta"]["nama"];
            $nik=$JsonData["peserta"]["nik"];
            $noKartu=$JsonData["peserta"]["noKartu"];
            $pisa=$JsonData["peserta"]["pisa"];
            $sex=$JsonData["peserta"]["sex"];
            $tglCetakKartu=$JsonData["peserta"]["tglCetakKartu"];
            $tglLahir=$JsonData["peserta"]["tglLahir"];
            $tglTAT=$JsonData["peserta"]["tglTAT"];
            $tglTMT=$JsonData["peserta"]["tglTMT"];
            //COB
            $nmAsuransi=$JsonData["peserta"]["cob"]["nmAsuransi"];
            $noAsuransi=$JsonData["peserta"]["cob"]["noAsuransi"];
            $tglTAT=$JsonData["peserta"]["cob"]["tglTAT"];
            $tglTMT=$JsonData["peserta"]["cob"]["tglTMT"];
            //hakKelas
            $hakKelasketerangan=$JsonData["peserta"]["hakKelas"]["keterangan"];
            $hakKelaskode=$JsonData["peserta"]["hakKelas"]["kode"];
            //informasi
            $dinsos=$JsonData["peserta"]["informasi"]["dinsos"];
            $noSKTM=$JsonData["peserta"]["informasi"]["noSKTM"];
            $prolanisPRB=$JsonData["peserta"]["informasi"]["prolanisPRB"];
            //jenisPeserta
            $jenisPesertaketerangan=$JsonData["peserta"]["jenisPeserta"]["keterangan"];
            $jenisPesertakode=$JsonData["peserta"]["jenisPeserta"]["kode"];
            //mr
            $noMR=$JsonData["peserta"]["mr"]["noMR"];
            $noTelepon=$JsonData["peserta"]["mr"]["noTelepon"];
            //provUmum
            $kdProvider=$JsonData["peserta"]["provUmum"]["kdProvider"];
            $nmProvider=$JsonData["peserta"]["provUmum"]["nmProvider"];
            //statusPeserta
            $statusPesertaketerangan=$JsonData["peserta"]["statusPeserta"]["keterangan"];
            $statusPesertakode=$JsonData["peserta"]["statusPeserta"]["kode"];
            //umur
            $umurSaatPelayanan=$JsonData["peserta"]["umur"]["umurSaatPelayanan"];
            $umurSekarang=$JsonData["peserta"]["umur"]["umurSekarang"];
?>
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="alert alert-info" role="alert">  
                Berikut ini adalah informasi pasien berdasarkan NIK dari BPJS.
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3 pre-scrollable">
            <?php
                echo '<div class="table table-responsive">';
                echo '  <table class="table table-hover">';
                echo '      <tr>';
                echo '          <td><dt>No.Kartu</dt></td>';
                echo '          <td><dt>:</dt></td>';
                echo '          <td>'.$noKartu.'</td>';
                echo '      </tr>';
                echo '      <tr>';
                echo '          <td><dt>No.NIK</dt></td>';
                echo '          <td><dt>:</dt></td>';
                echo '          <td>'.$nik.'</td>';
                echo '      </tr>';
                echo '      <tr>';
                echo '          <td><dt>No.RM & No.Telepon</dt></td>';
                echo '          <td><dt>:</dt></td>';
                echo '          <td>'.$noMR.' & '.$noTelepon.'</td>';
                echo '      </tr>';
                echo '      <tr>';
                echo '          <td><dt>Nama</dt></td>';
                echo '          <td><dt>:</dt></td>';
                echo '          <td>'.$nama.' ('.$sex.')</td>';
                echo '      </tr>';
                echo '      <tr>';
                echo '          <td><dt>Tanggal Lahir</dt></td>';
                echo '          <td><dt>:</dt></td>';
                echo '          <td>'.$tglLahir.'</td>';
                echo '      </tr>';
                echo '      <tr>';
                echo '          <td><dt>Umur Peserta</dt></td>';
                echo '          <td><dt>:</dt></td>';
                echo '          <td>'.$umurSaatPelayanan.'<br>'.$umurSekarang.'</td>';
                echo '      </tr>';
                echo '      <tr>';
                echo '          <td><dt>Hak Kelas</dt></td>';
                echo '          <td><dt>:</dt></td>';
                echo '          <td>'.$hakKelaskode.'-'.$hakKelasketerangan.'</td>';
                echo '      </tr>';
                echo '      <tr>';
                echo '          <td><dt>Jenis Peserta</dt></td>';
                echo '          <td><dt>:</dt></td>';
                echo '          <td>'.$jenisPesertakode.'-'.$jenisPesertaketerangan.'</td>';
                echo '      </tr>';
                echo '      <tr>';
                echo '          <td><dt>Provider</dt></td>';
                echo '          <td><dt>:</dt></td>';
                echo '          <td>'.$kdProvider.'-'.$nmProvider.'</td>';
                echo '      </tr>';
                echo '      <tr>';
                echo '          <td><dt>Dinsos</dt></td>';
                echo '          <td><dt>:</dt></td>';
                echo '          <td>'.$dinsos.'</td>';
                echo '      </tr>';
                echo '      <tr>';
                echo '          <td><dt>No.SKTM</dt></td>';
                echo '          <td><dt>:</dt></td>';
                echo '          <td>'.$noSKTM.'</td>';
                echo '      </tr>';
                echo '      <tr>';
                echo '          <td><dt>Prolansi PRB</dt></td>';
                echo '          <td><dt>:</dt></td>';
                echo '          <td>'.$prolanisPRB.'</td>';
                echo '      </tr>';
                echo '      <tr>';
                echo '          <td><dt>Status</dt></td>';
                echo '          <td><dt>:</dt></td>';
                echo '          <td>'.$statusPesertakode.'-'.$statusPesertaketerangan.'</td>';
                echo '      </tr>';
                echo '  </table>';
                echo '</div>';
            ?>
        </div>
    </div>
<?php }} ?>