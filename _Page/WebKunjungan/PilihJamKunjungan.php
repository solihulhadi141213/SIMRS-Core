<?php
    if(empty($_POST['tanggal_kunjungan'])){
        echo '<option value="">Isi Tanggal Kunjungan Dulu</option>';
    }else{
        if(empty($_POST['kode_dokter'])){
            echo '<option value="">Pilih Dokter Dulu</option>';
        }else{
            $tanggal_kunjungan=$_POST['tanggal_kunjungan'];
            $kode_dokter=$_POST['kode_dokter'];
            date_default_timezone_set('Asia/Jakarta');
            include "../../_Config/Connection.php";
            include "../../_Config/Session.php";
            include "../../_Config/SettingKoneksiWeb.php";
            include "../../_Config/WebFunction.php";
            $UrlList=urlService('Jadwal Tanggal Dokter');
            $KirimData = array(
                'api_key' => $api_key,
                'kode' => $kode_dokter,
                'tanggal' => $tanggal_kunjungan
            );
            $Metode ="POST";
            $ResponseJadwal =GetResponseApis($UrlList,$KirimData,$Metode);
            $KodeResponse=$ResponseJadwal['metadata']['code'];
            $PesanResponse=$ResponseJadwal['metadata']['massage'];
            if($KodeResponse==200){
                $JumlahJadwal=count($ResponseJadwal['response']['list']);
                if(!empty($JumlahJadwal)){
                    echo '<option value="">Pilih</option>';
                    $ListDokter=$ResponseJadwal['response']['list'];
                    foreach ($ListDokter as $value){
                        $id_jadwal=$value['id_jadwal'];
                        $hari=$value['hari'];
                        $jam=$value['jam'];
                        echo '<option value="'.$jam.'">'.$jam.' ('.$hari.')</option>';
                    }
                }else{
                    echo '<option value="">Tidak Ada Jadwal</option>';
                }
            }else{
                echo '<option value="">'.$massage.'</option>';
            }
        }
    }
?>