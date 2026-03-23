<?php
    //Zona Waktu
    ini_set("display_errors","off");
    date_default_timezone_set('UTC');
    //Koneksi
    include "../../_Config/Connection.php";
    //SettingBridging
    include "../../_Config/SettingBridging.php";
    //Membuat fungsi
    include "../../vendor/autoload.php";
    //Menangkap parameter
    if(empty($_POST['noSuratKontrol'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center text-danger">';
        echo '          Maaf, No Surat Tidak bisa Ditangkap Oleh Sistem!!';
        echo '      </div>';
        echo '  </div>';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center mt-3 mb-3">';
        echo '          <button type="button" data-dismiss="modal" class="btn btn-md btn-round btn-danger"><i class="ti ti-close"></i> Tutup</button>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
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
            echo '<div class="modal-body">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-center text-danger">';
            echo '          <dt>Keterangan</dt><br>';
            echo '          '.$message.'.<br>';
            echo '      </div>';
            echo '  </div>';
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-center mt-3 mb-3">';
            echo '          <button type="button" data-dismiss="modal" class="btn btn-md btn-round btn-danger"><i class="ti ti-close"></i> Tutup</button>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
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
            $noSuratKontrol=$JsonData['noSuratKontrol'];
            $tglRencanaKontrol=$JsonData['tglRencanaKontrol'];
            $tglTerbit=$JsonData['tglTerbit'];
            $jnsKontrol=$JsonData['jnsKontrol'];
            $poliTujuan=$JsonData['poliTujuan'];
            $namaPoliTujuan=$JsonData['namaPoliTujuan'];
            $kodeDokter=$JsonData['kodeDokter'];
            $namaDokter=$JsonData['namaDokter'];
            $flagKontrol=$JsonData['flagKontrol'];
            $kodeDokterPembuat=$JsonData['kodeDokterPembuat'];
            $namaDokterPembuat=$JsonData['namaDokterPembuat'];
            $namaJnsKontrol=$JsonData['namaJnsKontrol'];
            $noSep=$JsonData['sep']['noSep'];
            $tglSep=$JsonData['sep']['tglSep'];
            $jnsPelayanan=$JsonData['sep']['jnsPelayanan'];
            $poli=$JsonData['sep']['poli'];
            $noKartu=$JsonData['sep']['peserta']['noKartu'];
            $nama=$JsonData['sep']['peserta']['nama'];
            $tglLahir=$JsonData['sep']['peserta']['tglLahir'];
            $kelamin=$JsonData['sep']['peserta']['kelamin'];
            $hakKelas=$JsonData['sep']['peserta']['hakKelas'];
            $kdProvider=$JsonData['provUmum']['kdProvider'];
            $nmProvider=$JsonData['provUmum']['nmProvider'];
            $kdProviderPerujuk=$JsonData['provPerujuk']['kdProviderPerujuk'];
            $nmProviderPerujuk=$JsonData['provPerujuk']['nmProviderPerujuk'];
            $asalRujukan=$JsonData['provPerujuk']['asalRujukan'];
            $noRujukan=$JsonData['provPerujuk']['noRujukan'];
            $tglRujukan=$JsonData['provPerujuk']['tglRujukan'];
?>
    <div class="modal-body pre-scrollable">
        <div class="row">
            <div class="col col-md-5"><dt>No.Surat</dt></div>
            <div class="col col-md-1"><dt>:</dt></div>
            <div class="col col-md-6"><?php echo "$noSuratKontrol";?></div>
        </div>
        <div class="row">
            <div class="col col-md-5"><dt>Tgl.Rencana Kontrol</dt></div>
            <div class="col col-md-1"><dt>:</dt></div>
            <div class="col col-md-6"><?php echo "$tglRencanaKontrol";?></div>
        </div>
        <div class="row">
            <div class="col col-md-5"><dt>Tgl.Terbit</dt></div>
            <div class="col col-md-1"><dt>:</dt></div>
            <div class="col col-md-6"><?php echo "$tglTerbit";?></div>
        </div>
        <div class="row">
            <div class="col col-md-5"><dt>Jenis Kontrol</dt></div>
            <div class="col col-md-1"><dt>:</dt></div>
            <div class="col col-md-6"><?php echo "$jnsKontrol";?></div>
        </div>
        <div class="row">
            <div class="col col-md-5"><dt>Poli Tujuan</dt></div>
            <div class="col col-md-1"><dt>:</dt></div>
            <div class="col col-md-6"><?php echo "$namaPoliTujuan";?></div>
        </div>
        <div class="row">
            <div class="col col-md-5"><dt>Dokter</dt></div>
            <div class="col col-md-1"><dt>:</dt></div>
            <div class="col col-md-6"><?php echo "$kodeDokter $namaDokter";?></div>
        </div>
        <div class="row">
            <div class="col col-md-5"><dt>Flag Kontrol</dt></div>
            <div class="col col-md-1"><dt>:</dt></div>
            <div class="col col-md-6"><?php echo "$flagKontrol";?></div>
        </div>
        <div class="row">
            <div class="col col-md-5"><dt>Kode Dokter</dt></div>
            <div class="col col-md-1"><dt>:</dt></div>
            <div class="col col-md-6"><?php echo "$kodeDokterPembuat $namaDokterPembuat";?></div>
        </div>
        <div class="row">
            <div class="col col-md-5"><dt>Jenis Kontrol</dt></div>
            <div class="col col-md-1"><dt>:</dt></div>
            <div class="col col-md-6"><?php echo "$namaJnsKontrol";?></div>
        </div>
        <?php if(!empty($noSep)){ ?>
            <div class="row">
                <div class="col col-md-5"><dt>No.SEP</dt></div>
                <div class="col col-md-1"><dt>:</dt></div>
                <div class="col col-md-6"><?php echo "$noSep";?></div>
            </div>
            <div class="row">
                <div class="col col-md-5"><dt>Tgl.SEP</dt></div>
                <div class="col col-md-1"><dt>:</dt></div>
                <div class="col col-md-6"><?php echo "$tglSep";?></div>
            </div>
            <div class="row">
                <div class="col col-md-5"><dt>Jenis Pelayanan</dt></div>
                <div class="col col-md-1"><dt>:</dt></div>
                <div class="col col-md-6"><?php echo "$jnsPelayanan";?></div>
            </div>
            <div class="row">
                <div class="col col-md-5"><dt>Poli</dt></div>
                <div class="col col-md-1"><dt>:</dt></div>
                <div class="col col-md-6"><?php echo "$poli";?></div>
            </div>
            <div class="row">
                <div class="col col-md-5"><dt>No.Kartu</dt></div>
                <div class="col col-md-1"><dt>:</dt></div>
                <div class="col col-md-6"><?php echo "$noKartu";?></div>
            </div>
            <div class="row">
                <div class="col col-md-5"><dt>Nama</dt></div>
                <div class="col col-md-1"><dt>:</dt></div>
                <div class="col col-md-6"><?php echo "$nama";?></div>
            </div>
            <div class="row">
                <div class="col col-md-5"><dt>Tgl Lahir</dt></div>
                <div class="col col-md-1"><dt>:</dt></div>
                <div class="col col-md-6"><?php echo "$tglLahir";?></div>
            </div>
            <div class="row">
                <div class="col col-md-5"><dt>Gender</dt></div>
                <div class="col col-md-1"><dt>:</dt></div>
                <div class="col col-md-6"><?php echo "$kelamin";?></div>
            </div>
            <div class="row">
                <div class="col col-md-5"><dt>Hak Kelas</dt></div>
                <div class="col col-md-1"><dt>:</dt></div>
                <div class="col col-md-6"><?php echo "$hakKelas";?></div>
            </div>
            <div class="row">
                <div class="col col-md-5"><dt>Provider</dt></div>
                <div class="col col-md-1"><dt>:</dt></div>
                <div class="col col-md-6"><?php echo "$kdProvider-$nmProvider";?></div>
            </div>
        <?php }if(!empty($noRujukan)){ ?>
            <div class="row">
                <div class="col col-md-5"><dt>Provider Perujuk</dt></div>
                <div class="col col-md-1"><dt>:</dt></div>
                <div class="col col-md-6"><?php echo "$kdProviderPerujuk-$nmProvider";?></div>
            </div>
            <div class="row">
                <div class="col col-md-5"><dt>Asal Rujukan</dt></div>
                <div class="col col-md-1"><dt>:</dt></div>
                <div class="col col-md-6"><?php echo "$asalRujukan";?></div>
            </div>
            <div class="row">
                <div class="col col-md-5"><dt>No.Rujukan</dt></div>
                <div class="col col-md-1"><dt>:</dt></div>
                <div class="col col-md-6"><?php echo "$noRujukan";?></div>
            </div>
            <div class="row">
                <div class="col col-md-5"><dt>Tgl.Rujukan</dt></div>
                <div class="col col-md-1"><dt>:</dt></div>
                <div class="col col-md-6"><?php echo "$tglRujukan";?></div>
            </div>
        <?php } ?>
    </div>
    <div class="modal-footer">
        <div class="row">
            <div class="col col-md-12 text-center">
                <button type="button" class="btn btn-md btn-round btn-primary ml-2 mt-2" data-toggle="modal" data-target="#ModalEditSpri" data-id="<?php echo "$noSuratKontrol";?>">
                    <i class="ti ti-pencil"></i> Edit
                </button>
                <button type="button" class="btn btn-md btn-round btn-danger ml-2 mt-2" data-toggle="modal" data-target="#ModalHaspusSuratKontrol" data-id="<?php echo "$noSuratKontrol";?>">
                    <i class="ti ti-trash"></i> Hapus
                </button>
                <!-- <button type="button" class="btn btn-md btn-round btn-primary ml-2 mt-2">
                    <i class="ti ti-printer"></i> Cetak
                </button> -->
                <button type="button" data-dismiss="modal" class="btn btn-md btn-round btn-outline-dark ml-2 mt-2">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
<?php  }} ?>