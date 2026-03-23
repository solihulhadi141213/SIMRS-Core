<?php
    if(empty($_POST['kodepoli'])){
        echo '<option value="">Pilih Poliklinik Dulu</option>';
    }else{
        $KodePoli=$_POST['kodepoli'];
        date_default_timezone_set('Asia/Jakarta');
        include "../../_Config/Connection.php";
        include "../../_Config/Session.php";
        include "../../_Config/SettingKoneksiWeb.php";
        include "../../_Config/WebFunction.php";
        $UrlList=urlService('List Dokter By Kode Poli');
        $KirimData = array(
            'api_key' => $api_key,
            'kode' => $KodePoli
        );
        $Metode ="POST";
        $ResponseDokter =GetResponseApis($UrlList,$KirimData,$Metode);
        $KodeResponse=$ResponseDokter['metadata']['code'];
        $PesanResponse=$ResponseDokter['metadata']['massage'];
        if($KodeResponse==200){
            $JumlahDokter=count($ResponseDokter['response']['list']);
            if(!empty($JumlahDokter)){
                echo '<option value="">Pilih</option>';
                $ListDokter=$ResponseDokter['response']['list'];
                foreach ($ListDokter as $value){
                    $KodeDokter=$value['kode'];
                    $NamaDokter=$value['nama'];
                    echo '<option value="'.$KodeDokter.'">'.$NamaDokter.'</option>';
                }
            }else{
                echo '<option value="">Tidak Ada Dokter</option>';
            }
        }else{
            echo '<option value="">'.$massage.'</option>';
        }
    }
?>