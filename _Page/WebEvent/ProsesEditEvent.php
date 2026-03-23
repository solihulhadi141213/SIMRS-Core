<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/WebFunction.php";
    $Url=urlService('Edit Event');
    $updatetime=date('Y-m-d H:i');
    if(empty($_POST['id_web_event'])){
        echo '<span class="text-danger">ID Web Event Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['deskripsi_event'])){
            echo '<span class="text-danger">Deskripsi Event Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['jam_event'])){
                echo '<span class="text-danger">Jam Pelaksanaan Event Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['tanggal_event'])){
                    echo '<span class="text-danger">Tanggal Pelaksanaan Event Tidak Boleh Kosong!</span>';
                }else{
                    if(empty($_POST['kategori_event'])){
                        echo '<span class="text-danger">Kategori Event Tidak Boleh Kosong!</span>';
                    }else{
                        if(empty($_POST['nama_event'])){
                            echo '<span class="text-danger">Nama Event Tidak Boleh Kosong!</span>';
                        }else{
                            $id_web_event=$_POST['id_web_event'];
                            $deskripsi_event=$_POST['deskripsi_event'];
                            $jam_event=$_POST['jam_event'];
                            $tanggal_event=$_POST['tanggal_event'];
                            $kategori_event=$_POST['kategori_event'];
                            $nama_event=$_POST['nama_event'];
                            $tanggal_event="$tanggal_event $jam_event";
                            if(empty($_POST['poster_event'])){
                                $poster_event="";
                            }else{
                                $poster_event=$_POST['poster_event'];
                            }
                            $KirimData = array(
                                'api_key' => $api_key,
                                'id_web_event' => $id_web_event,
                                'nama_event' => $nama_event,
                                'kategori_event' => $kategori_event,
                                'tanggal_event' => $tanggal_event,
                                'deskripsi_event' => $deskripsi_event,
                                'poster_event' => $poster_event
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
                                    $_SESSION['NotifikasiSwal']="Edit Event Berhasil";
                                    echo '<span class="text-success" id="NotifikasiEditEventBerhasil">Success</span>';
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
?>