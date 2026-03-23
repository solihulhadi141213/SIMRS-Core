<?php
    if(empty($_POST['id_dokter'])){
        echo "
        <tr>
            <td colspan='5' class='text-center'>Data ID Dokter Tidak Boleh Kosong</td>
        </tr>";
    }else{
        if(empty($_POST['id_poliklinik'])){
            echo "
            <tr>
                <td colspan='5' class='text-center'>Data ID Poliklinik Tidak Boleh Kosong</td>
            </tr>";
        }else{
            //Koneksi ke database
            include "../../_Config/Connection.php";
            //Session
            include "../../_Config/Session.php";
            //Setting Bridging
            include "../../_Config/SettingBridging.php";
            //Fungsi Autoload
            include "../../vendor/autoload.php";
            //Tangkap variabel yang dikirim dari form
            $id_dokter=$_POST['id_dokter'];
            $id_poliklinik=$_POST['id_poliklinik'];
            //Buka data jadwal dokter dari database
            $JumlahData = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM jadwal_dokter WHERE id_dokter='$id_dokter' AND id_poliklinik='$id_poliklinik'"));
            //Kondisi jika data jadwal dokter kosong
            if(empty($JumlahData)){
                echo "
                <tr>
                    <td colspan='5' class='text-center'>Tidak Ada Jadwal Dokter</td>
                </tr>";
            }else{
                //Buka data kode dokter
                $QryDokter = mysqli_query($Conn,"SELECT * FROM dokter WHERE id_dokter='$id_dokter'")or die(mysqli_error($Conn));
                $DataDokter = mysqli_fetch_array($QryDokter);
                $KodeDokter= $DataDokter['kode'];
                $QryPoliklinik = mysqli_query($Conn,"SELECT * FROM poliklinik WHERE id_poliklinik='$id_poliklinik'")or die(mysqli_error($Conn));
                $DataPoliklinik = mysqli_fetch_array($QryPoliklinik);
                $KodePoli= $DataPoliklinik['kode'];
                //Buka data jadwal dokter
                $QryJadwalDokter = "SELECT * FROM jadwal_dokter WHERE id_dokter='$id_dokter' AND id_poliklinik='$id_poliklinik'";
                $DataJadwalDokter  =mysqli_query($Conn, $QryJadwalDokter);
                $jadwal = array();
                $jadwal['jadwal'] = array();
                while($x = mysqli_fetch_array($DataJadwalDokter)){
                    //Buat variabel
                    $NamaHari= $x['hari'];
                    if($NamaHari=="Senin"){
                        $KodeHari="1";
                    }else{
                        if($NamaHari=="Selasa"){
                            $KodeHari="2";
                        }else{
                            if($NamaHari=="Rabu"){
                                $KodeHari="3";
                            }else{
                                if($NamaHari=="Kamis"){
                                    $KodeHari="4";
                                }else{
                                    if($NamaHari=="Jumat"){
                                        $KodeHari="5";
                                    }else{
                                        if($NamaHari=="Sabtu"){
                                            $KodeHari="6";
                                        }else{
                                            if($NamaHari=="Minggu"){
                                                $KodeHari="7";
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $jam= $x['jam'];
                    //explode jam
                    $ExplodeJam = explode("-", $jam);
                    $JamMulai = $ExplodeJam[0];
                    $JamSelesai = $ExplodeJam[1];
                    //Buat array
                    $h['hari']=$KodeHari;
                    $h['buka'] =$JamMulai;
                    $h['tutup'] =$JamSelesai;
                    array_push($jadwal['jadwal'], $h);
                }
                //Update Data Jadwal Dokter
                //Time zone
                date_default_timezone_set('UTC');
                $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                //Creat Signature
                $signature = hash_hmac('sha256', $cons_id_antrol."&".$tStamp, $secret_key_antrol, true);
                $encodedSignature = base64_encode($signature);
                $urlencodedSignature = urlencode($encodedSignature);
                $key="$cons_id_antrol$secret_key_antrol$tStamp";
                //Membuat header
                $headers = array(
                    'Content-Type:Application/x-www-form-urlencoded',
                    'X-cons-id: '.$cons_id_antrol .'',
                    'X-timestamp: '.$tStamp.'' ,
                    'X-signature: '.$encodedSignature.'',
                    'user_key: '.$user_key_antrol.''
                ); 
                $arr =
                    array(
                        "kodepoli"=> "$KodePoli",
                        "kodesubspesialis"=> "$KodePoli",
                        "kodedokter"=> $KodeDokter,
                        "jadwal"=>$jadwal['jadwal']
                    );
                $json = json_encode($arr);
                //Membuat URL
                $url="$url_antrol/jadwaldokter/updatejadwaldokter";
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
                $code=$ambil_json["metadata"]["code"];
                $message=$ambil_json["metadata"]["message"];
                if($code=="200"){
                    echo "
                    <tr>
                        <td colspan='5' class='text-center text-success'>Berhasil Update Jadwal Dokter</td>
                    </tr>";
                }else{
                    echo "$content<br>";
                    echo "$json<br>";
                    echo "$url_antrol/jadwaldokter/updatejadwaldokter<br>";
                }
            }
        }
    }
?>