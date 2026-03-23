<?php
    include "_Config/SettingBridging.php";
    include "vendor/autoload.php";
    date_default_timezone_set('UTC');
    //Tangkap ID
    if(empty($_GET['sep'])){
        echo '<span class="text-danger">Belum Ada data Pasien Yang Dipilih</span>';
    }else{
        $sep=$_GET['sep'];
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
        $URLKatalog="SEP/$sep";
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
        $noSep=$JsonData["noSep"];
        $tglSep=$JsonData["tglSep"];
        $jnsPelayanan=$JsonData["jnsPelayanan"];
        $kelasRawat=$JsonData["kelasRawat"];
        $diagnosa=$JsonData["diagnosa"];
        $noRujukan=$JsonData["noRujukan"];
        $poli=$JsonData["poli"];
        $poliEksekutif=$JsonData["poliEksekutif"];
        $catatan=$JsonData["catatan"];
        $penjamin=$JsonData["penjamin"];
        $kdStatusKecelakaan=$JsonData["kdStatusKecelakaan"];
        $nmstatusKecelakaan=$JsonData["nmstatusKecelakaan"];
        $cob=$JsonData["cob"];
        $katarak=$JsonData["katarak"];
        //lokasiKejadian
        $kdKab=$JsonData["lokasiKejadian"]["kdKab"];
        $kdKec=$JsonData["lokasiKejadian"]["kdKec"];
        $kdProp=$JsonData["lokasiKejadian"]["kdProp"];
        $ketKejadian=$JsonData["lokasiKejadian"]["ketKejadian"];
        $lokasi=$JsonData["lokasiKejadian"]["lokasi"];
        $tglKejadian=$JsonData["lokasiKejadian"]["tglKejadian"];
        //dpjp
        $kdDPJP=$JsonData["dpjp"]["kdDPJP"];
        $nmDPJP=$JsonData["dpjp"]["nmDPJP"];
        //peserta
        $asuransi=$JsonData["peserta"]["asuransi"];
        $hakKelas=$JsonData["peserta"]["hakKelas"];
        $jnsPeserta=$JsonData["peserta"]["jnsPeserta"];
        $kelamin=$JsonData["peserta"]["kelamin"];
        $nama=$JsonData["peserta"]["nama"];
        $noKartu=$JsonData["peserta"]["noKartu"];
        $noMr=$JsonData["peserta"]["noMr"];
        $tglLahir=$JsonData["peserta"]["tglLahir"];
        //klsRawat
        $klsRawatHak=$JsonData["klsRawat"]["klsRawatHak"];
        $klsRawatNaik=$JsonData["klsRawat"]["klsRawatNaik"];
        $pembiayaan=$JsonData["klsRawat"]["pembiayaan"];
        $penanggungJawab=$JsonData["klsRawat"]["penanggungJawab"];
        //kontrol
        $kdDokter=$JsonData["kontrol"]["kdDokter"];
        $nmDokter=$JsonData["kontrol"]["nmDokter"];
        $noSurat=$JsonData["kontrol"]["noSurat"];
        //Membuka data pasien berdasarkan mr
        $QryPasien = mysqli_query($Conn,"SELECT * FROM pasien WHERE id_pasien='$noMr'")or die(mysqli_error($Conn));
        $DataPasien = mysqli_fetch_array($QryPasien);
        $kontak= $DataPasien['kontak'];
        //Membuka data kunjungan berdasarkan sep
        $QryKunjungan = mysqli_query($Conn,"SELECT * FROM kunjungan_utama WHERE sep='$sep'")or die(mysqli_error($Conn));
        $DataKunjungan = mysqli_fetch_array($QryKunjungan);
        $DiagAwal= $DataKunjungan['DiagAwal'];
?>
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="index.php?Page=RawatJalan&Sub=EditSep&id=<?php echo "$sep"; ?>" class="h5">
                            <i class="icofont-icu"></i> Edit SEP Kunjungan Rawat Jalan
                        </a>
                    </h5>
                    <p class="m-b-0">Edit Data SEP Berdasarkan Kunjungan Rawat Jalan</p>
                </div>
            </div>
            <div class="col-md-4 text-right">
                <a href="index.php?Page=RawatJalan" class="btn btn-md btn-inverse mr-2 mt-2">
                    <i class="ti-arrow-circle-left text-white"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="javascript:void(0);" id="ProsesEditSep" autocomplete="off">
                            <input type="hidden" name="sep" id="sep" value="<?php echo "$sep"; ?>">
                            <div class="card">
                                <div class="card-header">
                                    <h5>
                                        <dt>Form Edit SEP Kunjungan Rawat Jalan</dt>
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 mt-3">
                                            <label for="id_pasien">
                                                <dt>No.Sep</dt>
                                            </label>
                                            <input type="text" readonly name="noSep" id="noSep" value="<?php echo "$noSep"; ?>" class="form-control">
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="klsRawatHak"><dt>Hak Kelas</dt></label>
                                            <select name="klsRawatHak" id="klsRawatHak" class="form-control">
                                                <option <?php if($hakKelas=="Kelas 1"){echo "selected";} ?> value="1">Kelas 1</option>
                                                <option <?php if($hakKelas=="Kelas 2"){echo "selected";} ?> value="2">Kelas 2</option>
                                                <option <?php if($hakKelas=="Kelas 3"){echo "selected";} ?> value="3">Kelas 3</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="klsRawatNaik"><dt>Naik Kelas</dt></label>
                                            <select name="klsRawatNaik" id="klsRawatNaik" class="form-control">
                                                <option <?php if($klsRawatNaik==""){echo "selected";} ?> value="">Pilih</option>
                                                <option <?php if($klsRawatNaik=="1"){echo "selected";} ?> value="1">VVIP</option>
                                                <option <?php if($klsRawatNaik=="2"){echo "selected";} ?> value="2">VIP</option>
                                                <option <?php if($klsRawatNaik=="3"){echo "selected";} ?> value="3">Kelas 1</option>
                                                <option <?php if($klsRawatNaik=="4"){echo "selected";} ?> value="4">Kelas 2</option>
                                                <option <?php if($klsRawatNaik=="5"){echo "selected";} ?> value="5">Kelas 3</option>
                                                <option <?php if($klsRawatNaik=="6"){echo "selected";} ?> value="6">ICCU</option>
                                                <option <?php if($klsRawatNaik=="7"){echo "selected";} ?> value="7">ICU</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="pembiayaan"><dt>Pembiayaan</dt></label>
                                            <select name="pembiayaan" id="pembiayaan" class="form-control">
                                                <option <?php if($pembiayaan==""){echo "selected";} ?> value="">Pilih</option>
                                                <option <?php if($pembiayaan=="1"){echo "selected";} ?> value="1">Pribadi</option>
                                                <option <?php if($pembiayaan=="2"){echo "selected";} ?> value="2">Pemberi Kerja</option>
                                                <option <?php if($pembiayaan=="3"){echo "selected";} ?> value="3">Asuransi Kesehatan Tambahan</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="penanggungJawab"><dt>Penanggung Jawab</dt></label>
                                            <select name="penanggungJawab" id="penanggungJawab" class="form-control">
                                                <option <?php if($penanggungJawab==""){echo "selected";} ?> value="">Pilih</option>
                                                <option <?php if($penanggungJawab=="1"){echo "selected";} ?> value="Pribadi">Pribadi</option>
                                                <option <?php if($penanggungJawab=="2"){echo "selected";} ?> value="Pemberi Kerja">Pemberi Kerja</option>
                                                <option <?php if($penanggungJawab=="3"){echo "selected";} ?> value="Asuransi Kesehatan Tambahan">Asuransi Kesehatan Tambahan</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="noMR"><dt>No.RM</dt></label>
                                            <input type="text" name="noMR" id="noMR" value="<?php echo "$noMr"; ?>" class="form-control">
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="catatan"><dt>Catatan</dt></label>
                                            <input type="text" name="catatan" id="catatan" value="<?php echo "$catatan"; ?>" class="form-control">
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="sep">
                                                <dt>
                                                    Diagnosa Awal  
                                                    <a href="javascript:void(0);" class="badge badge-primary" data-toggle="modal" data-target="#ModalCariDiagnosa">
                                                        <i class="ti ti-search"></i> Cari
                                                    </a>
                                                </dt>
                                            </label>
                                            <input type="text" name="diagAwal" id="DiagAwal" value="<?php echo "$DiagAwal"; ?>" class="form-control">
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="tujuan"><dt>Poliklinik</dt></label>
                                            <select name="tujuan" id="tujuan" class="form-control">
                                                <option value="">Pilih</option>
                                                <?php
                                                    //menamilkan dari database
                                                    $query = mysqli_query($Conn, "SELECT*FROM poliklinik");
                                                    while ($data = mysqli_fetch_array($query)) {
                                                        $id_poliklinik_list= $data['id_poliklinik'];
                                                        $nama= $data['nama'];
                                                        $kode= $data['kode'];
                                                        if($poli==$nama){
                                                            echo '<option selected value="'.$kode.'">'.$nama.'</option>';
                                                        }else{
                                                            echo '<option value="'.$kode.'">'.$nama.'</option>';
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="eksekutif"><dt>Poli eksekutif</dt></label>
                                            <select name="eksekutif" id="eksekutif" class="form-control">
                                                <option <?php if($poliEksekutif=="0"){echo "selected";} ?> value="0">Tidak</option>
                                                <option  <?php if($poliEksekutif=="1"){echo "selected";} ?>value="1">Ya</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="cob"><dt>COB</dt></label>
                                            <select name="cob" id="cob" class="form-control">
                                                <option <?php if($cob=="0"){echo "selected";} ?> value="0">Tidak</option>
                                                <option <?php if($cob=="1"){echo "selected";} ?> value="1">Ya</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="katarak"><dt>Katarak</dt></label>
                                            <select name="katarak" id="katarak" class="form-control">
                                                <option <?php if($katarak=="0"){echo "selected";} ?> value="0">Tidak</option>
                                                <option <?php if($katarak=="1"){echo "selected";} ?> value="1">Ya</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="lakaLantas"><dt>Laka-Lantas</dt></label>
                                            <select name="lakaLantas" id="lakaLantas" class="form-control">
                                                <option value="">Pilih</option>
                                                <option <?php if($kdStatusKecelakaan=="0") ?> value="0">Bukan Kecelakaan</option>
                                                <option <?php if($kdStatusKecelakaan=="1") ?> value="1">KLL dan bukan kecelakaan Kerja</option>
                                                <option <?php if($kdStatusKecelakaan=="2") ?> value="2">KLL dan KK</option>
                                                <option <?php if($kdStatusKecelakaan=="3") ?> value="3">KK</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="tglKejadian"><dt>Tanggal Kejadian</dt></label>
                                            <input type="date" name="tglKejadian" id="tglKejadian" value="<?php echo "$tglKejadian";?>" class="form-control">
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="keterangan"><dt>Keterangan Kejadian</dt></label>
                                            <input type="text" name="keterangan" id="keterangan" value="<?php echo "$ketKejadian";?>" class="form-control">
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="suplesi"><dt>Suplesi</dt></label>
                                            <select name="suplesi" id="suplesi" class="form-control">
                                                <option value="0">Tidak</option>
                                                <option value="1">Ya</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="noSepSuplesi"><dt>No SEP Suplesi</dt></label>
                                            <input type="text" name="noSepSuplesi" id="noSepSuplesi" class="form-control">
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="kdPropinsi"><dt>Propinsi Laka</dt></label>
                                            <input type="text" name="kdPropinsi" id="kdPropinsi" value="<?php echo "$kdProp";?>" class="form-control">
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="kdKabupaten"><dt>Kabupaten Laka</dt></label>
                                            <input type="text" name="kdKabupaten" id="kdKabupaten" value="<?php echo "$kdKab";?>" class="form-control">
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="kdKecamatan"><dt>Kecamatan Laka</dt></label>
                                            <input type="text" name="kdKecamatan" id="kdKecamatan" value="<?php echo "$kdKec";?>" class="form-control">
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="dpjpLayan"><dt>Dokter Pelayanan</dt></label>
                                            <select name="dpjpLayan" id="dpjpLayan" class="form-control">
                                                <option value="">Pilih</option>
                                                <?php
                                                    //menamilkan dari database
                                                    $query = mysqli_query($Conn, "SELECT*FROM dokter");
                                                    while ($data = mysqli_fetch_array($query)) {
                                                        $id_dokter_list= $data['id_dokter'];
                                                        $nama= $data['nama'];
                                                        $kodeDpjpList= $data['kode'];
                                                        if($kdDPJP==$kodeDpjpList){
                                                            echo '<option selected value="'.$kodeDpjpList.'">'.$nama.'</option>';
                                                        }else{
                                                            echo '<option value="'.$kodeDpjpList.'">'.$nama.'</option>';
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="noTelp"><dt>No.Telpn Pasien</dt></label>
                                            <input type="text" name="noTelp" id="noTelp" value="<?php echo "$kontak";?>" class="form-control">
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="user"><dt>User/Petugas</dt></label>
                                            <input type="text" readonly name="user" id="user" value="<?php echo "$SessionNama"; ?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12" id="NotifikasiEditSep">
                                            <span class="text-primary">
                                                <dt>Keterangan : </dt> Pastikan Data SEP Yang Anda Input Sudah Benar!
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-md btn-primary">
                                        <i class="ti-save"></i> Simpan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="styleSelector">
        </div>
    </div>
</div>
<?php } ?>