<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/WebFunction.php";
    $url=urlService('Edit Sitemap');
    //Validasi url_site tidak boleh kosong
    if(empty($_POST['url_site'])){
        echo '<span class="text-danger">URL Tidak Boleh Kosong</span>';
    }else{
        //Validasi label tidak boleh kosong
        if(empty($_POST['label'])){
            echo '<span class="text-danger">Label Tidak Boleh Kosong</span>';
        }else{
            //Validasi priority_site tidak boleh kosong
            if(empty($_POST['priority_site'])){
                echo '<span class="text-danger">Priority site Tidak Boleh Kosong</span>';
            }else{
                //Validasi status tidak boleh kosong
                if(empty($_POST['status'])){
                    echo '<span class="text-danger">Status Tidak Boleh Kosong</span>';
                }else{
                    //Validasi id_web_sitemap tidak boleh kosong
                    if(empty($_POST['id_web_sitemap'])){
                        echo '<span class="text-danger">ID Sitemap Tidak Boleh Kosong</span>';
                    }else{
                        $id_web_sitemap=$_POST['id_web_sitemap'];
                        $url_site=$_POST['url_site'];
                        $label=$_POST['label'];
                        $priority_site=$_POST['priority_site'];
                        $status=$_POST['status'];
                        $tanggal=date('Y-m-d H:i');
                        //Proses Kirim Data
                        $KirimData = array(
                            'api_key' => $api_key,
                            'id_web_sitemap' => $id_web_sitemap,
                            'url_site' => $url_site,
                            'priority_site' => $priority_site,
                            'label' => $label,
                            'status' => $status
                        );
                        $json = json_encode($KirimData);
                        //Mulai CURL
                        $ch = curl_init();
                        curl_setopt($ch,CURLOPT_URL, "$url");
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
                            if($code!==200){
                                echo '<span class="text-danger">Gagal!! <br> Pesan: '.$massage.' <br> content: '.$content.'</span>';
                            }else{
                                echo '<span class="text-success" id="NotifikasiEditSitemapBerhasil">Success</span>';
                            }
                        }
                    }
                }
            }
        }
    }
?>