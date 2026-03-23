<?php
    //Zona Waktu
    date_default_timezone_set('UTC');
    //Koneksi
    include "../../_Config/Connection.php";
    //SettingBridging
    include "../../_Config/SettingBridging.php";
    //Membuat fungsi
    include "../../vendor/autoload.php";
    //Menangkap sep
    if(empty($_POST['sep'])){
        echo '<span class="text-danger">SEP Tidak Dipilih Pada Paramter Detail</span>';
    }else{
        $sep=$_POST['sep'];
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
        // Inisiasi gender
        if($kelamin=="L"){
            $gender="Laki-Laki";
        }else{
            $gender="Perempuan";
        }
        if(!empty($noSep)){
            echo '<div class="modal-body">';
            echo '<div class="table pre-scrollable">';
            echo '  <table class="table">';
            if(!empty($noSep)){
                echo '      <tr>';
                echo '          <td><dt>No.SEP</dt></td>';
                echo '          <td><dt>:</dt></td>';
                echo '          <td>'.$noSep.'</td>';
                echo '      </tr>';
            }
            if(!empty($tglSep)){
                echo '      <tr>';
                echo '          <td><dt>Tgl.SEP</dt></td>';
                echo '          <td><dt>:</dt></td>';
                echo '          <td>'.$tglSep.'</td>';
                echo '      </tr>';
            }
            if(!empty($jnsPelayanan)){
                echo '      <tr>';
                echo '          <td><dt>Jenis Pelayanan</dt></td>';
                echo '          <td><dt>:</dt></td>';
                echo '          <td>'.$jnsPelayanan.'</td>';
                echo '      </tr>';
            }
            if(!empty($kelasRawat)){
                echo '      <tr>';
                echo '          <td><dt>Kelas Rawat</dt></td>';
                echo '          <td><dt>:</dt></td>';
                echo '          <td>'.$kelasRawat.'</td>';
                echo '      </tr>';
            }
            if(!empty($diagnosa)){
                echo '      <tr>';
                echo '          <td><dt>Diagnosa</dt></td>';
                echo '          <td><dt>:</dt></td>';
                echo '          <td>'.$diagnosa.'</td>';
                echo '      </tr>';
            }
            if(!empty($noRujukan)){
                echo '      <tr>';
                echo '          <td><dt>No>Rujukan</dt></td>';
                echo '          <td><dt>:</dt></td>';
                echo '          <td>'.$noRujukan.'</td>';
                echo '      </tr>';
            }
            if(!empty($poli)){
                echo '      <tr>';
                echo '          <td><dt>No.Poliklinik</dt></td>';
                echo '          <td><dt>:</dt></td>';
                echo '          <td>'.$poli.'</td>';
                echo '      </tr>';
            }
            if(!empty($poliEksekutif)){
                echo '      <tr>';
                echo '          <td><dt>No>Poli Eksekutif</dt></td>';
                echo '          <td><dt>:</dt></td>';
                echo '          <td>'.$poliEksekutif.'</td>';
                echo '      </tr>';
            }
            if(!empty($catatan)){
                echo '      <tr>';
                echo '          <td><dt>Catatan</dt></td>';
                echo '          <td><dt>:</dt></td>';
                echo '          <td>'.$catatan.'</td>';
                echo '      </tr>';
            }
            if(!empty($penjamin)){
                echo '      <tr>';
                echo '          <td><dt>Penjamin</dt></td>';
                echo '          <td><dt>:</dt></td>';
                echo '          <td>'.$penjamin.'</td>';
                echo '      </tr>';
            }
            if(!empty($kdStatusKecelakaan)){
                echo '      <tr>';
                echo '          <td><dt>Status KLL</dt></td>';
                echo '          <td><dt>:</dt></td>';
                echo '          <td>'.$kdStatusKecelakaan.'-'.$nmstatusKecelakaan.'</td>';
                echo '      </tr>';
            }
            if(!empty($cob)){
                echo '      <tr>';
                echo '          <td><dt>COB</dt></td>';
                echo '          <td><dt>:</dt></td>';
                echo '          <td>'.$cob.'</td>';
                echo '      </tr>';
            }
            if(!empty($katarak)){
                echo '      <tr>';
                echo '          <td><dt>katarak</dt></td>';
                echo '          <td><dt>:</dt></td>';
                echo '          <td>'.$katarak.'</td>';
                echo '      </tr>';
            }
            if(!empty($kdKab)){
                echo '      <tr>';
                echo '          <td><dt>Lokasi KLL</dt></td>';
                echo '          <td><dt>:</dt></td>';
                echo '          <td>'.$lokasi.'</td>';
                echo '      </tr>';
            }
            if(!empty($ketKejadian)){
                echo '      <tr>';
                echo '          <td><dt>Keterangan KLL</dt></td>';
                echo '          <td><dt>:</dt></td>';
                echo '          <td>'.$ketKejadian.'</td>';
                echo '      </tr>';
            }
            if(!empty($tglKejadian)){
                echo '      <tr>';
                echo '          <td><dt>Tanggal KLL</dt></td>';
                echo '          <td><dt>:</dt></td>';
                echo '          <td>'.$tglKejadian.'</td>';
                echo '      </tr>';
            }
            if(!empty($kdDPJP)){
                echo '      <tr>';
                echo '          <td><dt>Dokter DPJP</dt></td>';
                echo '          <td><dt>:</dt></td>';
                echo '          <td>'.$kdDPJP.'-'.$nmDPJP.'</td>';
                echo '      </tr>';
            }
            if(!empty($asuransi)){
                echo '      <tr>';
                echo '          <td><dt>Asuransi</dt></td>';
                echo '          <td><dt>:</dt></td>';
                echo '          <td>'.$asuransi.'</td>';
                echo '      </tr>';
            }
            if(!empty($hakKelas)){
                echo '      <tr>';
                echo '          <td><dt>Hak Kelas</dt></td>';
                echo '          <td><dt>:</dt></td>';
                echo '          <td>'.$hakKelas.'</td>';
                echo '      </tr>';
            }
            if(!empty($jnsPeserta)){
                echo '      <tr>';
                echo '          <td><dt>Jenis Peserta</dt></td>';
                echo '          <td><dt>:</dt></td>';
                echo '          <td>'.$jnsPeserta.'</td>';
                echo '      </tr>';
            }
            if(!empty($kelamin)){
                echo '      <tr>';
                echo '          <td><dt>Gender</dt></td>';
                echo '          <td><dt>:</dt></td>';
                echo '          <td>'.$gender.'-'.$kelamin.' </td>';
                echo '      </tr>';
            }
            if(!empty($nama)){
                echo '      <tr>';
                echo '          <td><dt>Nama Peserta</dt></td>';
                echo '          <td><dt>:</dt></td>';
                echo '          <td>'.$nama.'</td>';
                echo '      </tr>';
            }
            if(!empty($noKartu)){
                echo '      <tr>';
                echo '          <td><dt>No.BPJS</dt></td>';
                echo '          <td><dt>:</dt></td>';
                echo '          <td>'.$noKartu.'</td>';
                echo '      </tr>';
            }
            if(!empty($noMr)){
                echo '      <tr>';
                echo '          <td><dt>No.RM</dt></td>';
                echo '          <td><dt>:</dt></td>';
                echo '          <td>'.$noMr.'</td>';
                echo '      </tr>';
            }
            if(!empty($tglLahir)){
                echo '      <tr>';
                echo '          <td><dt>Tgl Lahir</dt></td>';
                echo '          <td><dt>:</dt></td>';
                echo '          <td>'.$tglLahir.'</td>';
                echo '      </tr>';
            }
            if(!empty($klsRawatHak)){
                echo '      <tr>';
                echo '          <td><dt>Hak Kelas Rawat</dt></td>';
                echo '          <td><dt>:</dt></td>';
                echo '          <td>'.$klsRawatHak.'</td>';
                echo '      </tr>';
            }
            if(!empty($klsRawatNaik)){
                echo '      <tr>';
                echo '          <td><dt>Kelas Rawat Naik</dt></td>';
                echo '          <td><dt>:</dt></td>';
                echo '          <td>'.$klsRawatNaik.'</td>';
                echo '      </tr>';
            }
            if(!empty($pembiayaan)){
                echo '      <tr>';
                echo '          <td><dt>Pembiayaan</dt></td>';
                echo '          <td><dt>:</dt></td>';
                echo '          <td>'.$pembiayaan.'</td>';
                echo '      </tr>';
            }
            if(!empty($penanggungJawab)){
                echo '      <tr>';
                echo '          <td><dt>Penanggung Jawab</dt></td>';
                echo '          <td><dt>:</dt></td>';
                echo '          <td>'.$penanggungJawab.'</td>';
                echo '      </tr>';
            }
            if(!empty($kdDokter)){
                echo '      <tr>';
                echo '          <td><dt>Dokter (Kontrol)</dt></td>';
                echo '          <td><dt>:</dt></td>';
                echo '          <td>'.$kdDokter.'-'.$nmDokter.'</td>';
                echo '      </tr>';
            }
            if(!empty($noSurat)){
                echo '      <tr>';
                echo '          <td><dt>No.Surat Kontrol</dt></td>';
                echo '          <td><dt>:</dt></td>';
                echo '          <td>'.$noSurat.'</td>';
                echo '      </tr>';
            }
            echo '  </table>';
            echo '</div>';
            echo '</div>';
        }else{
            echo "<span class='text-danger'>Data Tidak Ditemukan</span>";
        }
    }
?>
<div class="modal-footer bg-inverse">
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="btn-group dropdown-split-inverse">
                <button type="button" class="btn btn-md btn-primary dropdown-toggle dropdown-toggle-split waves-effect waves-light mt-2 ml-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="OptionButton">
                    Option
                </button>
                <div class="dropdown-menu" x-placement="top-start" style="position: absolute; transform: translate3d(107px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                    <a class="dropdown-item waves-effect waves-light" href="_Page/RawatJalan/CetakSep.php?sep=<?php echo "$sep";?>">
                        <i class="ti ti-printer"></i> Cetak SEP
                    </a>
                    <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalEditSEP" data-id="<?php echo "$sep";?>">
                        <i class="ti ti-pencil-alt2"></i> Edit SEP
                    </a>
                    <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalHapusSep" data-id="<?php echo "$sep";?>">
                        <i class="ti ti-trash"></i> Hapus SEP
                    </a>
                </div>
            </div>
            <button type="button" class="btn btn-md btn-light mt-2 ml-2" data-dismiss="modal">
                <i class="ti-close"></i> Tutup
            </button>
        </div>
    </div>
</div>