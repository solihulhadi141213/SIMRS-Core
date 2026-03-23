<?php
    //Pengaturan waktu
    date_default_timezone_set('UTC');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingBridging.php";
    include "../../vendor/autoload.php";
    //Inisiasi masing-masing variabel
    if(empty($_POST['UrlForBack'])){
        echo '<span class="text-danger">Url Untuk Kembali Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['id_kunjungan'])){
            echo '<span class="text-danger">ID Kunjungan Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['id_pasien'])){
                echo '<span class="text-danger">ID Pasien Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['nik'])){
                    echo '<span class="text-danger">NIK Pasien Tidak Boleh Kosong!</span>';
                }else{
                    if(empty($_POST['no_bpjs'])){
                        echo '<span class="text-danger">Nomor Kartu/BPJS Tidak Boleh Kosong!</span>';
                    }else{
                        if(empty($_POST['nama'])){
                            echo '<span class="text-danger">Nama Pasien Tidak Boleh Kosong!</span>';
                        }else{
                            if(empty($_POST['noTelp'])){
                                echo '<span class="text-danger">Nomor Kontak Pasien Tidak Boleh Kosong!</span>';
                            }else{
                                if(empty($_POST['ppkPelayanan'])){
                                    echo '<span class="text-danger">Kode PPK Pelayanan Tidak Boleh Kosong!</span>';
                                }else{
                                    if(empty($_POST['NamappkPelayanan'])){
                                        echo '<span class="text-danger">Nama PPK Pelayanan Tidak Boleh Kosong!</span>';
                                    }else{
                                        if(empty($_POST['jnsPelayanan'])){
                                            echo '<span class="text-danger">Jenis Pelayanan Tidak Boleh Kosong!</span>';
                                        }else{
                                            if(empty($_POST['tglSep'])){
                                                echo '<span class="text-danger">Tanggal SEP Tidak Boleh Kosong!</span>';
                                            }else{
                                                if(empty($_POST['diagAwal'])){
                                                    echo '<span class="text-danger">Tanggal SEP Tidak Boleh Kosong!</span>';
                                                }else{
                                                    if(empty($_POST['assesmentPel'])){
                                                        $assesmentPel="";
                                                    }else{
                                                        $assesmentPel=$_POST['assesmentPel'];
                                                    }
                                                    if(empty($_POST['user'])){
                                                        echo '<span class="text-danger">Petugas Tidak Boleh Kosong!</span>';
                                                    }else{
                                                        if(empty($_POST['klsRawatHak'])){
                                                            echo '<span class="text-danger">Kelas Rawat Hak Tidak Boleh Kosong!</span>';
                                                        }else{
                                                            $UrlForBack=$_POST['UrlForBack'];
                                                            $id_kunjungan=$_POST['id_kunjungan'];
                                                            $noMR=$_POST['id_pasien'];
                                                            $nik=$_POST['nik'];
                                                            $noKartu=$_POST['no_bpjs'];
                                                            $nama=$_POST['nama'];
                                                            $noTelp=$_POST['noTelp'];
                                                            $ppkPelayanan=$_POST['ppkPelayanan'];
                                                            $NamappkPelayanan=$_POST['NamappkPelayanan'];
                                                            $jnsPelayanan=$_POST['jnsPelayanan'];
                                                            $tglSep=$_POST['tglSep'];
                                                            $diagAwal=$_POST['diagAwal'];
                                                            
                                                            $user=$_POST['user'];
                                                            $klsRawatHak=$_POST['klsRawatHak'];
                                                            //Explode Diagnosa awal
                                                            $Explode = explode("-", $diagAwal);
                                                            $diagAwal=$Explode[0];
                                                            $diagAwal = str_replace(' ', '', $diagAwal);
                                                            if(empty($_POST['dpjpLayan'])){
                                                                $dpjpLayan="";
                                                            }else{
                                                                $dpjpLayan=$_POST['dpjpLayan'];
                                                            }
                                                            if(empty($_POST['sep'])){
                                                                $sep="";
                                                            }else{
                                                                $sep=$_POST['sep'];
                                                            }
                                                            if(empty($_POST['noRujukan'])){
                                                                $noRujukan="";
                                                            }else{
                                                                $noRujukan=$_POST['noRujukan'];
                                                            }
                                                            if(empty($_POST['tglRujukan'])){
                                                                $tglRujukan="";
                                                            }else{
                                                                $tglRujukan=$_POST['tglRujukan'];
                                                            }
                                                            if(empty($_POST['asalRujukan'])){
                                                                $asalRujukan="1";
                                                            }else{
                                                                $asalRujukan=$_POST['asalRujukan'];
                                                            }
                                                            if(empty($_POST['rujukan_dari'])){
                                                                $ppkRujukan="";
                                                            }else{
                                                                $ppkRujukan=$_POST['rujukan_dari'];
                                                            }
                                                            if(empty($_POST['noSurat'])){
                                                                $noSurat="";
                                                            }else{
                                                                $noSurat=$_POST['noSurat'];
                                                            }
                                                            if(empty($_POST['kodeDPJP'])){
                                                                $kodeDPJP="";
                                                            }else{
                                                                $kodeDPJP=$_POST['kodeDPJP'];
                                                            }
                                                            if(empty($_POST['cob'])){
                                                                $cob="0";
                                                            }else{
                                                                $cob=$_POST['cob'];
                                                            }
                                                            if(empty($_POST['katarak'])){
                                                                $katarak="0";
                                                            }else{
                                                                $katarak=$_POST['katarak'];
                                                            }
                                                            if(empty($_POST['catatan'])){
                                                                $catatan="";
                                                            }else{
                                                                $catatan=$_POST['catatan'];
                                                            }
                                                            if(empty($_POST['tujuanKunj'])){
                                                                $tujuanKunj="0";
                                                                $flagProcedure="";
                                                                $kdPenunjang="";
                                                            }else{
                                                                $tujuanKunj=$_POST['tujuanKunj'];
                                                                if($tujuanKunj=="0"){
                                                                    $flagProcedure="";
                                                                    $kdPenunjang="";
                                                                }else{
                                                                    if($tujuanKunj=="2"){
                                                                        $flagProcedure="";
                                                                        $kdPenunjang="";
                                                                    }else{
                                                                        if(empty($_POST['flagProcedure'])){
                                                                            $flagProcedure="0";
                                                                        }else{
                                                                            $flagProcedure=$_POST['flagProcedure'];
                                                                        }
                                                                        if(empty($_POST['kdPenunjang'])){
                                                                            $kdPenunjang="0";
                                                                        }else{
                                                                            $kdPenunjang=$_POST['kdPenunjang'];
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            if(empty($_POST['lakaLantas'])){
                                                                $lakaLantas="0";
                                                            }else{
                                                                $lakaLantas=$_POST['lakaLantas'];
                                                            }
                                                            if(empty($_POST['noLP'])){
                                                                $noLP="";
                                                            }else{
                                                                $noLP=$_POST['noLP'];
                                                            }
                                                            if(empty($_POST['tglKejadian'])){
                                                                $tglKejadian="";
                                                            }else{
                                                                $tglKejadian=$_POST['tglKejadian'];
                                                            }
                                                            if(empty($_POST['keterangan'])){
                                                                $keterangan="";
                                                            }else{
                                                                $keterangan=$_POST['keterangan'];
                                                            }
                                                            if(empty($_POST['suplesi'])){
                                                                $suplesi="0";
                                                            }else{
                                                                $suplesi=$_POST['suplesi'];
                                                            }
                                                            if(empty($_POST['noSepSuplesi'])){
                                                                $noSepSuplesi="";
                                                            }else{
                                                                $noSepSuplesi=$_POST['noSepSuplesi'];
                                                            }
                                                            if(empty($_POST['kdPropinsi'])){
                                                                $kdPropinsi="";
                                                            }else{
                                                                $kdPropinsi=$_POST['kdPropinsi'];
                                                            }
                                                            if(empty($_POST['kdKabupaten'])){
                                                                $kdKabupaten="";
                                                            }else{
                                                                $kdKabupaten=$_POST['kdKabupaten'];
                                                            }
                                                            if(empty($_POST['kdKecamatan'])){
                                                                $kdKecamatan="";
                                                            }else{
                                                                $kdKecamatan=$_POST['kdKecamatan'];
                                                            }
                                                            if(empty($_POST['poli_tujuan'])){
                                                                $tujuan="";
                                                            }else{
                                                                $tujuan=$_POST['poli_tujuan'];
                                                            }
                                                            if(empty($_POST['eksekutif'])){
                                                                $eksekutif="0";
                                                            }else{
                                                                $eksekutif=$_POST['eksekutif'];
                                                            }
                                                            if(empty($_POST['klsRawatNaik'])){
                                                                $klsRawatNaik="";
                                                            }else{
                                                                $klsRawatNaik=$_POST['klsRawatNaik'];
                                                            }
                                                            if(empty($_POST['pembiayaan'])){
                                                                $pembiayaan="";
                                                            }else{
                                                                $pembiayaan=$_POST['pembiayaan'];
                                                            }
                                                            if(empty($_POST['penanggungJawab'])){
                                                                $penanggungJawab="";
                                                            }else{
                                                                $penanggungJawab=$_POST['penanggungJawab'];
                                                            }
                                                            if(empty($_POST['keluhan'])){
                                                                $keluhan="";
                                                            }else{
                                                                $keluhan=$_POST['keluhan'];
                                                            }
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
                                                            //KONDISI APABILA INSERT
                                                            if(empty($_POST['sep'])){
                                                                $arr = array("request" =>
                                                                    array("t_sep"=>
                                                                        array(
                                                                            "noKartu"=> "$noKartu",
                                                                            "tglSep"=> "$tglSep",
                                                                            "ppkPelayanan"=> "$ppkPelayanan",
                                                                            "jnsPelayanan"=> "$jnsPelayanan",
                                                                            "klsRawat"=>array(
                                                                                "klsRawatHak"=>"$klsRawatHak",
                                                                                "klsRawatNaik"=> "$klsRawatNaik",
                                                                                "pembiayaan"=> "$pembiayaan",
                                                                                "penanggungJawab"=> "$penanggungJawab"
                                                                            ),
                                                                            "noMR"=> "$noMR",
                                                                            "rujukan"=>array(
                                                                                "asalRujukan"=>"$asalRujukan",
                                                                                "tglRujukan"=> "$tglRujukan",
                                                                                "noRujukan"=> "$noRujukan",
                                                                                "ppkRujukan"=> "$ppkRujukan"
                                                                            ),
                                                                            "catatan"=> "$catatan",
                                                                            "diagAwal"=> "$diagAwal",
                                                                            "poli"=>array( 
                                                                                "tujuan"=> "$tujuan",
                                                                                "eksekutif"=> "$eksekutif"
                                                                            ),
                                                                            "cob"=>array(
                                                                                "cob"=>"$cob"
                                                                            ),
                                                                            "katarak"=>array(
                                                                                "katarak"=>"$katarak"
                                                                            ),
                                                                            "jaminan"=>array(
                                                                                "lakaLantas"=>"$lakaLantas",
                                                                                "noLP"=>"$noLP",
                                                                                "penjamin"=>array(
                                                                                    "tglKejadian"=>"$tglKejadian",
                                                                                    "keterangan"=>"$keterangan",
                                                                                    "suplesi"=>array(
                                                                                        "suplesi"=>"$suplesi",
                                                                                        "noSepSuplesi"=>"$noSepSuplesi",
                                                                                        "lokasiLaka"=>array(
                                                                                            "kdPropinsi"=>"$kdPropinsi",
                                                                                            "kdKabupaten"=>"$kdKabupaten",
                                                                                            "kdKecamatan"=>"$kdKecamatan"
                                                                                        )
                                                                                    )
                                                                                )
                                                                            ),
                                                                            "tujuanKunj"=>"$tujuanKunj",
                                                                            "flagProcedure"=>"$flagProcedure",
                                                                            "kdPenunjang"=>"$kdPenunjang",
                                                                            "assesmentPel"=>$assesmentPel,
                                                                            "skdp"=>array(
                                                                                "noSurat"=>"$noSurat",
                                                                                "kodeDPJP"=>"$kodeDPJP"
                                                                            ),
                                                                            "dpjpLayan"=>"$dpjpLayan",
                                                                            "noTelp"=>"$noTelp",
                                                                            "user"=>"$user"
                                                                        )
                                                                    )
                                                                );
                                                                $json = json_encode($arr);
                                                                //Membuat URL
                                                                $TanggalSekarang=date('Y-m-d');
                                                                $URLUtama=$url_vclaim;
                                                                $URLKatalog="SEP/2.0/insert";
                                                                $url="$URLUtama$URLKatalog";
                                                                //Mulai CURL
                                                                $ch = curl_init();
                                                                curl_setopt($ch,CURLOPT_URL, "$url");
                                                                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                                                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                                                curl_setopt($ch,CURLOPT_HEADER, 0);
                                                                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                                                                curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                                                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                                                $content = curl_exec($ch);
                                                                $err = curl_error($ch);
                                                                curl_close($ch);
                                                                $ambil_json =json_decode($content, true);
                                                                $code=$ambil_json["metaData"]["code"];
                                                                $message=$ambil_json["metaData"]["message"];
                                                                $string=$ambil_json["response"];
                                                                //Proses decode dan dekompresi
                                                                //--membuat key
                                                                $key="$consid$secret_key$timestamp";
                                                                //--masukan ke fungsi
                                                                $FileDeskripsi=stringDecrypt("$key", "$string");
                                                                $FileDekompresi=decompress("$FileDeskripsi");
                                                                $JsonData =json_decode($FileDekompresi, true);
                                                                if(!empty($JsonData["sep"]["noSep"])){
                                                                    $noSep=$JsonData["sep"]["noSep"];
                                                                }else{
                                                                    $noSep="";
                                                                }
                                                                
                                                                //--konveris json to raw
                                                                if($code=="200"){
                                                                    if(!empty($noSep)){
                                                                        $UpdateKunjungan= mysqli_query($Conn,"UPDATE kunjungan_utama SET 
                                                                            sep='$noSep'
                                                                        WHERE id_kunjungan='$id_kunjungan'") or die(mysqli_error($Conn));
                                                                        if($UpdateKunjungan){
                                                                            $_SESSION['NotifikasiSwal']="Buat SEP Berhasil";
                                                                            echo '<span class="text-info" id="NotifikasiBuatSepBerhasil">Success</span>';
                                                                            echo '<p class="text-info" id="UrlBackBuatSep">'.$UrlForBack.'</p>';
                                                                        }else{
                                                                            echo '<span class="text-danger">Update data SEP pada SIMRS Gagal!!</span><br>';
                                                                        }
                                                                    }
                                                                }else{
                                                                    $ambill_json2 = json_encode($ambil_json, JSON_PRETTY_PRINT);
                                                                    echo '<span class="text-danger">Maaf, Input SEP gagal!!</span><br>';
                                                                    echo '<span class="text-danger">Keterangan :'.$message.'</span><br>';
                                                                    echo '<div class=" pre-scrollable">'.$json.'</div><br><br><br>';
                                                                    echo '<div class=" pre-scrollable">'.$ambill_json2.'</div>';
                                                                }
                                                            }else{
                                                                $arr2 = array("request" =>
                                                                    array("t_sep"=>
                                                                        array(
                                                                            "noSep"=> "$sep",
                                                                            "klsRawat"=>array(
                                                                                "klsRawatHak"=>"$klsRawatHak",
                                                                                "klsRawatNaik"=> "$klsRawatNaik",
                                                                                "pembiayaan"=> "$pembiayaan",
                                                                                "penanggungJawab"=> "$penanggungJawab"
                                                                            ),
                                                                            "noMR"=> "$noMR",
                                                                            "catatan"=> "$catatan",
                                                                            "diagAwal"=> "$diagAwal",
                                                                            "poli"=>array( 
                                                                                "tujuan"=> "$tujuan",
                                                                                "eksekutif"=> "$eksekutif"
                                                                            ),
                                                                            "cob"=>array(
                                                                                "cob"=>"$cob"
                                                                            ),
                                                                            "katarak"=>array(
                                                                                "katarak"=>"$katarak"
                                                                            ),
                                                                            "jaminan"=>array(
                                                                                "lakaLantas"=>"$lakaLantas",
                                                                                "penjamin"=>array(
                                                                                    "tglKejadian"=>"$tglKejadian",
                                                                                    "keterangan"=>"$keterangan",
                                                                                    "suplesi"=>array(
                                                                                        "suplesi"=>"$suplesi",
                                                                                        "noSepSuplesi"=>"$noSepSuplesi",
                                                                                        "lokasiLaka"=>array(
                                                                                            "kdPropinsi"=>"$kdPropinsi",
                                                                                            "kdKabupaten"=>"$kdKabupaten",
                                                                                            "kdKecamatan"=>"$kdKecamatan"
                                                                                        )
                                                                                    )
                                                                                )
                                                                            ),
                                                                            "dpjpLayan"=>"$dpjpLayan",
                                                                            "noTelp"=>"$noTelp",
                                                                            "user"=>"$user"
                                                                        )
                                                                    )
                                                                );
                                                                $JsonContent = json_encode($arr2);
                                                                //Membuat URL
                                                                $url="$url_vclaim/SEP/2.0/update";
                                                                //Mulai CURL
                                                                $ch = curl_init();
                                                                curl_setopt($ch,CURLOPT_URL, "$url");
                                                                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                                                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                                                curl_setopt($ch,CURLOPT_HEADER, 0);
                                                                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                                                                curl_setopt($ch, CURLOPT_POSTFIELDS, $JsonContent);
                                                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                                                $content = curl_exec($ch);
                                                                $err = curl_error($ch);
                                                                curl_close($ch);
                                                                if(empty($content)){
                                                                    echo '<span class="text-danger">Tidak ada response dari bpjs</span>';
                                                                }else{
                                                                    $ambil_json =json_decode($content, true);
                                                                    if(empty($ambil_json["metaData"]["code"])){
                                                                        echo '<span class="text-danger">Kode kesalahan tidak diketahui</span>';
                                                                    }else{
                                                                        $code=$ambil_json["metaData"]["code"];
                                                                        if($code!=="200"){
                                                                            echo '<span class="text-danger">Maaf, Update SEP gagal!!</span><br>';
                                                                            echo '<span class="text-danger">Keterangan :'.$ambil_json["metaData"]["message"].'</span><br>';
                                                                            // echo '<div class=" pre-scrollable">'.$encodedSignature.'</div>';
                                                                            // echo '<div class=" pre-scrollable">'.$timestamp.'</div>';
                                                                            // echo '<div class=" pre-scrollable">'.$consid.'</div>';
                                                                            // echo '<div class=" pre-scrollable">'.$user_key.'</div>';
                                                                            // echo '<div class=" pre-scrollable">'.$url.'</div>';
                                                                            // echo '<div class=" pre-scrollable">'.$JsonContent.'</div>';
                                                                        }else{
                                                                            $_SESSION['NotifikasiSwal']="Edit SEP Berhasil";
                                                                            echo '<span class="text-info" id="NotifikasiBuatSepBerhasil">Success</span>';
                                                                            echo '<p class="text-info" id="UrlBackBuatSep">'.$UrlForBack.'</p>';
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>