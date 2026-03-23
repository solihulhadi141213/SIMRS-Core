<?php
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Menangkap data id_rujukan
    if(empty($_POST['id_rujukan'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-danger">';
        echo '          Mohon maaf, ID Rujukan Tidak Bisa Ditangkap Oleh sistem!!';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer bg-primary">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-danger">';
        echo '          <button type="button" class="btn btn-md btn-danger btn-round" data-dismiss="modal">';
        echo '             <i class="ti ti-close"></i> Tutup';
        echo '          </button>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_rujukan=$_POST['id_rujukan'];
        //membuka data pada database
        $Qry = mysqli_query($Conn,"SELECT * FROM rujukan WHERE id_rujukan='$id_rujukan'")or die(mysqli_error($Conn));
        $Data = mysqli_fetch_array($Qry);
        $IdRujukan= $Data['id_rujukan'];
        $id_pasien= $Data['id_pasien'];
        $id_kunjungan= $Data['id_kunjungan'];
        $nama= $Data['nama'];
        $nik= $Data['nik'];
        $no_bpjs= $Data['no_bpjs'];
        $noSep= $Data['noSep'];
        $noRujukan= $Data['noRujukan'];
        $tglRujukan= $Data['tglRujukan'];
        $tglRencanaKunjungan= $Data['tglRencanaKunjungan'];
        $ppkDirujuk= $Data['ppkDirujuk'];
        $jnsPelayanan= $Data['jnsPelayanan'];
        $catatan= $Data['catatan'];
        $diagRujukan= $Data['diagRujukan'];
        $tipeRujukan= $Data['tipeRujukan'];
        $poliRujukan= $Data['poliRujukan'];
        $user= $Data['user'];
        //Membuka data rujukan dari database BPJS
        //Zona Waktu
        date_default_timezone_set('UTC');
        //SettingBridging
        include "../../_Config/SettingBridging.php";
        //Membuat fungsi
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
        if($kategori_ppk=="PCare"){
            $URLKatalog="Rujukan/$noRujukan";
        }else{
            $URLKatalog="Rujukan/RS/$noRujukan";
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
        $string=$ambil_json["response"];
        $code=$ambil_json["metaData"]["code"];
        $message=$ambil_json["metaData"]["message"];
        //Proses decode dan dekompresi
        //--membuat key
        $key="$consid$secret_key$timestamp";
        //--masukan ke fungsi
        $FileDeskripsi=stringDecrypt("$key", "$string");
        $FileDekompresi=decompress("$FileDeskripsi");
        //--konveris json to raw
        $JsonData =json_decode($FileDekompresi, true);
        //--Get row poli
        $rujukan=$JsonData['rujukan'];
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
?>
    <div class="modal-body pre-scrollable">
        <div class="row">
            <div class="col col-md-4 mt-2"><dt>ID.Rujukan</dt></div>
            <div class="col col-md-8 mt-2"><?php echo ": $IdRujukan"; ?></div>
        </div>
        <div class="row">
            <div class="col col-md-4 mt-2"><dt>No.Rujukan</dt></div>
            <div class="col col-md-8 mt-2"><?php echo ": $noRujukan"; ?></div>
        </div>
        <div class="row">
            <div class="col col-md-4 mt-2"><dt>No.RM</dt></div>
            <div class="col col-md-8 mt-2"><?php echo ": $id_pasien"; ?></div>
        </div>
        <div class="row">
            <div class="col col-md-4 mt-2"><dt>Nama Pasien</dt></div>
            <div class="col col-md-8 mt-2"><?php echo ": $nama"; ?></div>
        </div>
        <div class="row">
            <div class="col col-md-4 mt-2"><dt>No.Kartu</dt></div>
            <div class="col col-md-8 mt-2"><?php echo ": $no_bpjs"; ?></div>
        </div>
        <div class="row">
            <div class="col col-md-4 mt-2"><dt>No.Nik</dt></div>
            <div class="col col-md-8 mt-2"><?php echo ": $nik"; ?></div>
        </div>
        <?php if(empty($noKunjungan)){ ?>
            <div class="row">
                <div class="col col-md-12 mt-2 text-danger text-center">
                    Sistem Tidak Bisa Meemukan Data Rujukan Ini<br>
                    <?php echo "Keterangan : $message <br>"; ?>
                    <?php echo "URL : <small>$url</small><br>"; ?>
                </div>
            </div>
        <?php 
            }else{ 
                $keluhan=$rujukan['keluhan'];
                $tglKunjungan=$rujukan['tglKunjungan'];
        ?>
            <div class="row">
                <div class="col col-md-4 mt-2"><dt>Keluhan</dt></div>
                <div class="col col-md-8 mt-2"><?php echo ": $keluhan"; ?></div>
            </div>
            <div class="row">
                <div class="col col-md-4 mt-2"><dt>Tgl.Kunjungan</dt></div>
                <div class="col col-md-8 mt-2"><?php echo ": $tglKunjungan"; ?></div>
            </div>
            <div class="row">
                <div class="col col-md-4 mt-2"><dt>Tgl.Kunjungan</dt></div>
                <div class="col col-md-8 mt-2"><?php echo ": $tglKunjungan"; ?></div>
            </div>
        <?php } ?>
    </div>
    <div class="modal-footer">
        <div class="row">
            <div class="col-md-12">
                <button type="button" class="btn btn-md btn-outline-primary btn-round mt-2 mr-2" data-toggle="modal" data-target="#ModalKonfirmasiEditRujukan" data-id="<?php echo "$IdRujukan";?>">
                    <i class="ti ti-pencil"></i> Edit
                </button>
                <button type="button" class="btn btn-md btn-outline-danger btn-round mt-2 mr-2" data-toggle="modal" data-target="#ModalKonfirmasiHapusRujukan" data-id="<?php echo "$noRujukan";?>">
                    <i class="ti ti-trash"></i> Hapus
                </button>
                <button type="button" class="btn btn-md btn-outline-dark btn-round mt-2 mr-2" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
<?php } ?>