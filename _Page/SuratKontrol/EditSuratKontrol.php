<?php
    //Koneksi dan session
    date_default_timezone_set('UTC');
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //SettingBridging
    include "../../_Config/SettingBridging.php";
    //Membuat fungsi
    include "../../vendor/autoload.php";
    //menangkap nomor kartu
    if(empty($_POST['noSuratKontrol'])){
        $noSuratKontrol="";
        $jnsPelayanan="";
        $noSuratKontrol="";
        $tglRencanaKontrol="";
        $tglTerbit="";
        $jnsKontrol="";
        $poliTujuan="";
        $namaPoliTujuan="";
        $kodeDokter="";
        $namaDokter="";
        $namaJnsKontrol="";
        $noSep="";
    }else{
        $noSuratKontrol=$_POST['noSuratKontrol'];
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
        $URLKatalog="RencanaKontrol/noSuratKontrol/$noSuratKontrol";
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
        if($code!=="200"){
            $jnsPelayanan="";
            $noSuratKontrol="";
            $tglRencanaKontrol="";
            $tglTerbit="";
            $jnsKontrol="";
            $poliTujuan="";
            $namaPoliTujuan="";
            $kodeDokter="";
            $namaDokter="";
            $namaJnsKontrol="";
            $noSep="";
            $noKartu="";
        }else{
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
            $jnsPelayanan=$JsonData['sep']['jnsPelayanan'];
            $noSuratKontrol=$JsonData['noSuratKontrol'];
            $tglRencanaKontrol=$JsonData['tglRencanaKontrol'];
            $tglTerbit=$JsonData['tglTerbit'];
            $jnsKontrol=$JsonData['jnsKontrol'];
            $poliTujuan=$JsonData['poliTujuan'];
            $namaPoliTujuan=$JsonData['namaPoliTujuan'];
            $kodeDokter=$JsonData['kodeDokter'];
            $namaDokter=$JsonData['namaDokter'];
            $namaJnsKontrol=$JsonData['namaJnsKontrol'];
            $noSep=$JsonData['sep']['noSep'];
        }
    }
?>
<div class="card">
    <form action="javascript:void(0);" id="ProsesEditRencanaKontrol">
        <div class="card-header border-info">
            <h4 class="text-primary">
                <dt><i class="icofont-clip-board"></i> Form Edit Surat Kontrol</dt>
            </h4>
        </div>
        <div class="card-body">
            <div class="row mt-2 mb-2"> 
                <div class="col-md-4 mt-3">
                    <label for="JenisKontrol"><dt>Jenis Kontrol <?php echo "$jnsKontrol";?></dt></label>
                    <select name="JenisKontrol" id="JenisKontrol" class="form-control">
                        <option <?php if($jnsKontrol=="1"){echo "selected";} ?> value="1">SPRI</option>
                        <option <?php if($jnsKontrol=="2"){echo "selected";} ?> value="2">Rencana Kontrol</option>
                    </select>
                </div>
                <?php if($jnsKontrol=="1"){ ?>  
                    <div class="col-md-4 mt-3">
                        <label for="noSPRI"><dt>No.SPRI</dt></label>
                        <input type="text" name="noSPRI" id="noSPRI" class="form-control" value="<?php echo "$noSuratKontrol"; ?>" required>
                    </div>
                <?php } ?>
                <?php if($jnsKontrol=="2"){ ?>
                    <div class="col-md-4 mt-3">
                        <label for="noSuratKontrol"><dt>No.Surat Kontrol</dt></label>
                        <input type="text" name="noSuratKontrol" id="noSuratKontrol" class="form-control" value="<?php echo "$noSuratKontrol"; ?>" required>
                    </div>
                    <div class="col-md-4 mt-3">
                        <label for="noSuratKontrol"><dt>No.SEP</dt></label>
                        <input type="text" name="noSEP" id="noSEP" class="form-control" value="<?php echo "$noSEP"; ?>" required>
                    </div>
                <?php } ?>
                <div class="col-md-4 mt-3">
                    <label for="poliKontrol"><dt>Poliklinik</dt></label>
                    <input type="text" name="poliKontrol" id="poliKontrol" class="form-control"  value="<?php echo "$poliTujuan"; ?>" data-toggle="modal" data-target="#ModalCariPoli" required>
                </div>
                <div class="col-md-4 mt-3">
                    <label for="kodeDokter"><dt>Dokter</dt></label>
                    <input type="text" name="kodeDokter" id="kodeDokter" class="form-control" value="<?php echo "$kodeDokter"; ?>" data-toggle="modal" data-target="#ModalCariDokter" required>
                </div>
                <div class="col-md-4 mt-3">
                    <label for="tglRencanaKontrol"><dt>Tanggal Kontrol</dt></label>
                    <input type="date" name="tglRencanaKontrol" id="tglRencanaKontrol" class="form-control" value="<?php echo "$tglRencanaKontrol"; ?>" required>
                </div>
                <div class="col-md-4 mt-3">
                    <label for="user"><dt>Petugas</dt></label>
                    <input type="text" readonly name="user" id="user" class="form-control" value="<?php echo "$SessionNama"; ?>" required>
                </div>
                <div class="col-md-4 mt-3" id="NoIdentitas">
                    <?php if($jnsKontrol=="2"){ ?>
                        <input type="text" name="noSEP" id="noSEP" class="form-control" value="<?php echo "$noSEP"; ?>" required>
                    <?php } ?>
                </div>
            </div>
            <div class="row mt-2 mb-2"> 
                <div class="col-md-12" id="NotifikasiEditRencanaKontrol">
                    <span class="text-info">
                        <dt>Keterangan :</dt>
                        Pastikan data rencana kontrol yang anda isi sudah sesuai.
                    </span>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row mt-2 mb-2"> 
                <div class="col-md-12">
                    <button type="submit" class="btn btn-md btn-primary mt-2 ml-2">
                        <i class="ti-check-box"></i> Simpan
                    </button>
                    <button type="reset" class="btn btn-md btn-secondary mt-2 ml-2">
                        <i class="ti ti-reload"></i> Reset
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>