<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/WebFunction.php";
    $Url=urlService('Add Unit');
    $updatetime=date('Y-m-d H:i');
    if(empty($_POST['nama_unit_instalasi'])){
        echo '<span class="text-danger">Nama Unit Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['deskripsi_unit_instalasi'])){
            echo '<span class="text-danger">Deskripsi Unit Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['poster_unit_instalasi'])){
                echo '<span class="text-danger">Poster Unit Tidak Boleh Kosong!</span>';
            }else{
                $nama_unit_instalasi=$_POST['nama_unit_instalasi'];
                $deskripsi_unit_instalasi=$_POST['deskripsi_unit_instalasi'];
                $poster_unit_instalasi=$_POST['poster_unit_instalasi'];
                $KirimData = array(
                    'api_key' => $api_key,
                    'nama_unit_instalasi' => $nama_unit_instalasi,
                    'deskripsi_unit_instalasi' => $deskripsi_unit_instalasi,
                    'poster_unit_instalasi' => $poster_unit_instalasi
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
                        $_SESSION['NotifikasiSwal']="Tambah Unit Berhasil";
                        echo '<span class="text-success" id="NotifikasiTambahUnitBerhasil">Success</span>';
                    }else{
                        echo '<span class="text-danger">'.$massage.'</span>';
                    }
                }
            }
        }
    }
?>