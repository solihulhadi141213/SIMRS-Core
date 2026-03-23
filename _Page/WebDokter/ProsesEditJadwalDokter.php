<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/WebFunction.php";
    $Url=urlService('Edit Jadwal');
    $updatetime=date('Y-m-d H:i');
    if(empty($_POST['id_jadwal'])){
        echo '<span class="text-danger">ID Jadwal Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['hari'])){
            echo '<span class="text-danger">Nama Hari Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['jam1'])){
                echo '<span class="text-danger">Jam Mulai Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['jam2'])){
                    echo '<span class="text-danger">Jam Selesai Tidak Boleh Kosong!</span>';
                }else{
                    if(empty($_POST['kuota_non_jkn'])){
                        echo '<span class="text-danger">Kuota Non JKN Tidak Boleh Kosong!</span>';
                    }else{
                        if(empty($_POST['kuota_jkn'])){
                            echo '<span class="text-danger">Kuota JKN Tidak Boleh Kosong!</span>';
                        }else{
                            if(empty($_POST['time_max'])){
                                echo '<span class="text-danger">Waktu Maksimal Kedatangan Tidak Boleh Kosong!</span>';
                            }else{
                                $id_jadwal=$_POST['id_jadwal'];
                                $hari=$_POST['hari'];
                                $jam1=$_POST['jam1'];
                                $jam2=$_POST['jam2'];
                                $jam="$jam1-$jam2";
                                $kuota_non_jkn=$_POST['kuota_non_jkn'];
                                $kuota_jkn=$_POST['kuota_jkn'];
                                $time_max=$_POST['time_max'];
                                $KirimData = array(
                                    'api_key' => $api_key,
                                    'id_jadwal' => $id_jadwal,
                                    'hari' => $hari,
                                    'jam' => $jam,
                                    'kuota_non_jkn' => $kuota_non_jkn,
                                    'kuota_jkn' => $kuota_jkn,
                                    'time_max' => $time_max
                                );
                                $json = json_encode($KirimData);
                                //Mulai CURL
                                $ch = curl_init();
                                curl_setopt($ch,CURLOPT_URL, "$Url");
                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                curl_setopt($ch,CURLOPT_HEADER, 0);
                                curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
                                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                $content = curl_exec($ch);
                                $err = curl_error($ch);
                                curl_close($ch);
                                if(!empty($err)){
                                    echo '<span class="text-danger">'.$err.'</span>';
                                }else{
                                    $JsonData =json_decode($content, true);
                                    if(!empty($JsonData['metadata']['massage'])){
                                        $massage=$JsonData['metadata']['massage'];
                                    }else{
                                        $massage="";
                                    }
                                    if(!empty($JsonData['metadata']['code'])){
                                        $code=$JsonData['metadata']['code'];
                                    }else{
                                        $code="";
                                    }
                                    if($code==200){
                                        $_SESSION['NotifikasiSwal']="Edit Jadwal Berhasil";
                                        echo '<span class="text-success" id="NotifikasiEditJadwalDokterBerhasil">Success</span>';
                                    }else{
                                        echo '<span class="text-danger">'.$massage.'</span>';
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