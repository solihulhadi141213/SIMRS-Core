<?php
    //Pengaturan waktu
    date_default_timezone_set('UTC');
    //Koneksi dan akses
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingBridging.php";
    //Membuat fungsi
    include "../../vendor/autoload.php";
    //Inisiasi masing-masing variabel
    if(empty($_POST['noSep'])){
        echo '<span class="text-danger">Maaf No SEP Tidak Boleh Kosong!!</span>';
    }else{
        if(empty($_POST['tglRujukan'])){
            echo '<span class="text-danger">Maaf Tanggal Rujukan Tidak Boleh Kosong!!</span>';
        }else{
            if(empty($_POST['tglRencanaKunjungan'])){
                echo '<span class="text-danger">Maaf Tanggal Rencana Kunjungan Tidak Boleh Kosong!!</span>';
            }else{
                if(empty($_POST['jnsPelayanan'])){
                    echo '<span class="text-danger">Maaf Jenis Pelayanan Tidak Boleh Kosong!!</span>';
                }else{
                    if(empty($_POST['catatan'])){
                        echo '<span class="text-danger">Maaf setidaknya anda harus menjelaskan alasan rujukan dalam catatan!!</span>';
                    }else{
                        if(empty($_POST['diagRujukan'])){
                            echo '<span class="text-danger">Maaf Informasi Kode Diagnosa Tidak Boleh Kosong!!</span>';
                        }else{
                            if(empty($_POST['user'])){
                                echo '<span class="text-danger">Maaf user Pengguna Tidak Boleh Kosong!!</span>';
                            }else{
                                $tglRujukan=$_POST['tglRujukan'];
                                $noSep=$_POST['noSep'];
                                $tglRencanaKunjungan=$_POST['tglRencanaKunjungan'];
                                $jnsPelayanan=$_POST['jnsPelayanan'];
                                $catatan=$_POST['catatan'];
                                $diagRujukan=$_POST['diagRujukan'];
                                $tipeRujukan=$_POST['tipeRujukan'];
                                if(empty($_POST['poliRujukan'])){
                                    $poliRujukan="";
                                }else{
                                    $poliRujukan=$_POST['poliRujukan'];
                                }
                                if(empty($_POST['ppkDirujuk'])){
                                    $ppkDirujuk="";
                                }else{
                                    $ppkDirujuk=$_POST['ppkDirujuk'];
                                }
                                $user=$_POST['user'];
                                //Inisiasi JenisPelayanan
                                if($jnsPelayanan=="1"){
                                    $JenisPelayananKunjungan="Ranap";
                                }else{
                                    $JenisPelayananKunjungan="Rajal";
                                }
                                //Membuka data SEP pada kunjungan
                                $Qry = mysqli_query($Conn,"SELECT * FROM kunjungan_utama WHERE sep='$noSep'")or die(mysqli_error($Conn));
                                $Data = mysqli_fetch_array($Qry);
                                $id_kunjungan= $Data['id_kunjungan'];
                                $id_pasien= $Data['id_pasien'];
                                $nik= $Data['nik'];
                                $no_bpjs= $Data['no_bpjs'];
                                $noRujukan= $Data['noRujukan'];
                                $skdp= $Data['skdp'];
                                $nama= $Data['nama'];
                                //Mengirim data ke BPJS
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
                                $arr = array("request" =>
                                    array("t_rujukan"=>
                                        array(
                                            "noSep"=> "$noSep",
                                            "tglRujukan"=> "$tglRujukan",
                                            "tglRencanaKunjungan"=> "$tglRencanaKunjungan",
                                            "ppkDirujuk"=> "$ppkDirujuk",
                                            "jnsPelayanan"=>"$jnsPelayanan",
                                            "catatan"=>"$catatan",
                                            "diagRujukan"=>"$diagRujukan",
                                            "tipeRujukan"=>"$tipeRujukan",
                                            "poliRujukan"=>"$poliRujukan",
                                            "user"=>"$user"
                                        )
                                    )
                                );
                                $json = json_encode($arr);
                                //Membuat URL
                                $TanggalSekarang=date('Y-m-d');
                                $URLUtama=$url_vclaim;
                                $URLKatalog="Rujukan/2.0/insert";
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
                                //Inisiasi Response
                                $noRujukan=$JsonData["rujukan"]["noRujukan"];
                                $AsalRujukankode=$JsonData["rujukan"]["AsalRujukan"]['kode'];
                                $AsalRujukannama=$JsonData["rujukan"]["AsalRujukan"]['nama'];

                                $diagnosakode=$JsonData["rujukan"]["diagnosa"]['kode'];
                                $diagnosanama=$JsonData["rujukan"]["diagnosa"]['nama'];

                                $asuransi=$JsonData["rujukan"]["peserta"]['asuransi'];
                                $hakKelas=$JsonData["rujukan"]["peserta"]['hakKelas'];
                                $jnsPeserta=$JsonData["rujukan"]["peserta"]['jnsPeserta'];
                                $kelamin=$JsonData["rujukan"]["peserta"]['kelamin'];
                                $nama=$JsonData["rujukan"]["peserta"]['nama'];
                                $noKartu=$JsonData["rujukan"]["peserta"]['noKartu'];
                                $noMr=$JsonData["rujukan"]["peserta"]['noMr'];
                                $tglLahir=$JsonData["rujukan"]["peserta"]['tglLahir'];

                                $poliTujuankode=$JsonData["rujukan"]["poliTujuan"]['kode'];
                                $poliTujuannama=$JsonData["rujukan"]["poliTujuan"]['nama'];
                                
                                $tglBerlakuKunjungan=$JsonData["rujukan"]["tglBerlakuKunjungan"];
                                $tglRencanaKunjungan=$JsonData["rujukan"]["tglRencanaKunjungan"];
                                $tglRujukan=$JsonData["rujukan"]["tglRujukan"];
                                $tujuanRujukankode=$JsonData["rujukan"]["tujuanRujukan"]['kode'];
                                $tujuanRujukannama=$JsonData["rujukan"]["tujuanRujukan"]['nama'];


                                //--konveris json to raw
                                if($code=="200"){
                                    if(!empty($noRujukan)){
                                        //menyimpan data rujukan
                                        $entry="INSERT INTO rujukan (
                                            id_pasien,
                                            id_kunjungan,
                                            nama,
                                            nik,
                                            no_bpjs,
                                            noSep,
                                            noRujukan,
                                            tglRujukan,
                                            tglRencanaKunjungan,
                                            ppkDirujuk,
                                            jnsPelayanan,
                                            catatan,
                                            diagRujukan,
                                            tipeRujukan,
                                            poliRujukan,
                                            user
                                        ) VALUES (
                                            '$id_pasien',
                                            '$id_kunjungan',
                                            '$nama',
                                            '$nik',
                                            '$no_bpjs',
                                            '$noSep',
                                            '$noRujukan',
                                            '$tglRujukan',
                                            '$tglRencanaKunjungan',
                                            '$ppkDirujuk',
                                            '$JenisPelayananKunjungan',
                                            '$catatan',
                                            '$diagRujukan',
                                            '$tipeRujukan',
                                            '$poliRujukan',
                                            '$user'
                                        )";
                                        $hasil=mysqli_query($Conn, $entry);
                                        if($hasil){
                                            echo '<span class="text-primary" id="NotifikasiBuatRujukanBerhasil">Berhasil</span><br>';
                                            echo '<span class="text-primary">Keterangan : Proses Input Data Rujukan Ke Database Berhasil.</span><br>';
                                        }else{
                                            echo '<span class="text-primary" id="NotifikasiBuatRujukanBerhasil">Berhasil</span><br>';
                                            echo '<span class="text-danger">Keterangan : Proses Buat Rujukan Mungkin Berhasil Namun Proses input data rujukan pada database internal gagal!!</span><br>';
                                        }
                                        echo 'No.Rujukan : '.$noRujukan.'<br>';
                                        echo 'Asal Rujukan : '.$AsalRujukankode.'-'.$AsalRujukannama.'<br>';
                                        echo 'Diagnosa : '.$diagnosakode.'-'.$diagnosanama.'<br>';
                                        echo 'Asuransi : '.$asuransi.'<br>';
                                        echo 'Hak Kelas : '.$hakKelas.'<br>';
                                        echo 'Jenis Peserta : '.$jnsPeserta.'<br>';
                                        echo 'Gender : '.$kelamin.'<br>';
                                        echo 'Nama Peserta : '.$nama.'<br>';
                                        echo 'No.Kartu : '.$noKartu.'<br>';
                                        echo 'No.MR : '.$noMr.'<br>';
                                        echo 'Tgl.Lahir : '.$tglLahir.'<br>';
                                        echo 'Poli Tujuan : '.$poliTujuankode.'-'.$poliTujuannama.'<br>';
                                        echo 'Tgl Berlaku Kunjungan : '.$tglBerlakuKunjungan.'<br>';
                                        echo 'Tgl Rencana Kunjungan : '.$tglRencanaKunjungan.'<br>';
                                        echo 'Tgl Rujukan : '.$tglRujukan.'<br>';
                                        echo 'Tujuan Kunjungan : '.$tujuanRujukankode.'-'.$tujuanRujukannama.'<br>';
                                    }else{
                                        echo '<span class="text-danger">Maaf, Kemungkinan Mengirim Data Rujukan Gagal Karena Nomor Rujukan Pada Response Tidak Ada!!</span><br>';
                                        echo '<span class="text-danger">Keterangan :'.$message.'</span><br>';
                                    }
                                }else{
                                    echo '<span class="text-danger">Maaf, Kirim Rujukan Gagal!!</span><br>';
                                    echo '<span class="text-danger">Keterangan :'.$message.'</span><br>';
                                }
                            }
                        }
                    }
                    
                }
            }
        }
    }
?>