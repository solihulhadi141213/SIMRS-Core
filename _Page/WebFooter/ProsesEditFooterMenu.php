<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/WebFunction.php";
    $Url=urlService('Edit Footer Menu');
    //Validasi Form Data
    if(empty($_POST['id_web_menu'])){
        echo '<span class="text-danger">ID Footer Menu Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['kategori'])){
            echo '<span class="text-danger">Kategori Footer Menu Tidak Boleh Kosong</span>';
        }else{
            if(empty($_POST['label'])){
                echo '<span class="text-danger">Label Footer menu Tidak Boleh Kosong</span>';
            }else{
                if(empty($_POST['url'])){
                    echo '<span class="text-danger">URL Footer Menu Tidak Boleh Kosong</span>';
                }else{
                    $id_web_menu=$_POST['id_web_menu'];
                    $kategori=$_POST['kategori'];
                    $label=$_POST['label'];
                    $url=$_POST['url'];
                    $KirimData = array(
                        'api_key' => $api_key,
                        'id_web_menu' => $id_web_menu,
                        'kategori' => $kategori,
                        'label' => $label,
                        'url' => $url
                    );
                    $Metode="POST";
                    $Response=GetResponseApis($Url,$KirimData,$Metode);
                    if(empty($Response)){
                        echo '<span class="text-danger">Terjadi kesalahan koneksi dengan website</span>';
                    }else{
                        $JsonData=$Response;
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
                            echo '<span class="text-success" id="NotifikasiEditFooterMenuBerhasil">Success</span>';
                        }else{
                            echo '<span class="text-danger">Simpan FAQ gagal<br>Pesan: '.$massage.'<br>URL: '.$Url.'</span>';
                        }
                    }
                }
            }
        }
    }
?>