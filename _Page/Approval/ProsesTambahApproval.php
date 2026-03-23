<?php
    date_default_timezone_set('UTC');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingBridging.php";
    include "../../_Config/SimrsFunction.php";
    include "../../vendor/autoload.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    if(empty($_POST['nomor_kartu'])){
        echo '<span class="text-danger">Nomor Kartu Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['tanggal_sep'])){
            echo '<span class="text-danger">Nomor Kartu Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['jenis_pelayanan'])){
                echo '<span class="text-danger">Jenis Pelayanan Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['jenis_pengajuan'])){
                    echo '<span class="text-danger">Jenis Pengajuan Tidak Boleh Kosong!</span>';
                }else{
                    if(empty($_POST['keterangan'])){
                        echo '<span class="text-danger">Keterangan Tidak Boleh Kosong!</span>';
                    }else{
                        $nomor_kartu=$_POST['nomor_kartu'];
                        $tanggal_sep=$_POST['tanggal_sep'];
                        $jenis_pelayanan=$_POST['jenis_pelayanan'];
                        $jenis_pengajuan=$_POST['jenis_pengajuan'];
                        $keterangan=$_POST['keterangan'];
                        $user=$SessionNama;
                        $status="Pengajuan";
                        //Buat JSON Header
                        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                        //Creat Signature
                        $signature = hash_hmac('sha256', $consid."&".$timestamp, $secret_key, true);
                        // base64 encode…
                        $encodedSignature = base64_encode($signature);
                        $headers = array(
                            'X-signature: '.$encodedSignature.'',
                            'X-timestamp: '.$timestamp.'' ,
                            'X-cons-id: '.$consid .'',
                            'user_key: '.$user_key.'',
                            'Content-Type:Application/x-www-form-urlencoded'         
                        );
                        $t_sep = array(
                            "noKartu"=> "$nomor_kartu",        
                            "tglSep"=> "$tanggal_sep",        
                            "jnsPelayanan"=> "$jenis_pelayanan",        
                            "jnsPengajuan"=> "$jenis_pengajuan",        
                            "keterangan"=> "$keterangan",        
                            "user"=> "$user" 
                        );
                        $request = array(
                            "t_sep"=> $t_sep,
                        );
                        $arr = array(
                            "request"=> $request,
                        );
                        $json = json_encode($arr);
                        $url="$url_vclaim/Sep/pengajuanSEP";
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
                        if(empty($content)){
                            echo '<span class="text-danger">Tidak ada response dari WS BPJS!</span>';
                        }else{
                            if(empty($ambil_json['metaData'])){
                                echo '<span class="text-danger">'.$content.'</span>';
                            }else{
                                if($ambil_json['metaData']['code']!=="200"){
                                    echo '<span class="text-danger">Keterangan : '.$ambil_json['metaData']['message'].'</span>';
                                }else{
                                    //Simpan Ke Database Lokal
                                    $entry="INSERT INTO approval (
                                        id_akses,
                                        noKartu,
                                        tglSep,
                                        jnsPelayanan,
                                        jnsPengajuan,
                                        keterangan,
                                        user,
                                        status
                                    ) VALUES (
                                        '$SessionIdAkses',
                                        '$nomor_kartu',
                                        '$tanggal_sep',
                                        '$jenis_pelayanan',
                                        '$jenis_pengajuan',
                                        '$keterangan',
                                        '$user',
                                        '$status'
                                    )";
                                    $Input=mysqli_query($Conn, $entry);
                                    if($Input){
                                        $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Tambah Approval","Approval",$SessionIdAkses,$LogJsonFile);
                                        if($MenyimpanLog=="Berhasil"){
                                            echo '<span class="text-success" id="NotifikasiTambahApprovalBerhasil">Success</span>';
                                        }else{
                                            echo '<span class="text-danger">Terjadi kesalahan pada saat menyimpan data log!</span>';
                                        }
                                    }else{
                                        echo '<span class="text-danger">Terjadi kesalahan pada saat menyimpan data approval!</span>';
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