<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Page/WebMetaTag/FungsiMetatag.php";
    $Url=urlService('Edit Meta Tag');
    $updatetime=date('Y-m-d H:i');
    //Validasi Form Data
    if(empty($_POST['id_web_metatag'])){
        echo '<span class="text-danger">ID Meta Tag Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['Halaman'])){
            echo '<span class="text-danger">Parameter Page Pada Meta Tag Tidak Boleh Kosong</span>';
        }else{
            if(empty($_POST['Author'])){
                echo '<span class="text-danger">Author Tidak Boleh Kosong</span>';
            }else{
                if(empty($_POST['KataKunci'])){
                    echo '<span class="text-danger">Keyword Halaman Tidak Boleh Kosong</span>';
                }else{
                    if(empty($_POST['Deskripsi'])){
                        echo '<span class="text-danger">Deskripsi Halaman Tidak Boleh Kosong</span>';
                    }else{
                        if(empty($_POST['Author'])){
                            echo '<span class="text-danger">Author Halaman Tidak Boleh Kosong</span>';
                        }else{
                            if(empty($_POST['JudulHalaman'])){
                                echo '<span class="text-danger">Judul Halaman Tidak Boleh Kosong</span>';
                            }else{
                                if(empty($_POST['SubHalaman'])){
                                    $SubHalaman="";
                                }else{
                                    $SubHalaman=$_POST['SubHalaman'];
                                }
                                $id_web_metatag=$_POST['id_web_metatag'];
                                $JudulHalaman=$_POST['JudulHalaman'];
                                $Halaman=$_POST['Halaman'];
                                $Author=$_POST['Author'];
                                $KataKunci=$_POST['KataKunci'];
                                $Deskripsi=$_POST['Deskripsi'];
                                $Author=$_POST['Author'];
                                $KirimData = array(
                                    'api_key' => $api_key,
                                    'id_web_metatag' => $id_web_metatag,
                                    'forPage' => $Halaman,
                                    'forSub' => $SubHalaman,
                                    'metatag_title' => $JudulHalaman,
                                    'metatag_description' => $Deskripsi,
                                    'metatag_keywords' => $KataKunci,
                                    'metatag_author' => $Author,
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
                                        echo '<span class="text-success" id="NotifikasiEditMetaTagBerhasil">Success</span>';
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