<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/SettingFaskes.php";
    include "../../_Config/Session.php";
    //Tangkap id_biaya_pendidikan
    if(empty($_POST['periode1'])){
        echo "Periode Awal Tidak Bisa Ditangkap Oleh Sistem";
    }else{
        if(empty($_POST['periode2'])){
            echo "Periode Akhir Tidak Bisa Ditangkap Oleh Sistem";
        }else{
            //Apabila jenis data tidak ada
            if(empty($_POST['format'])){
                echo "Ddata format Tidak Bisa Ditangkap Oleh Sistem";
            }else{
                $periode1=$_POST['periode1'];
                $periode2=$_POST['periode2'];
                $format= $_POST['format'];
                if($format=="PDF"){
                    //koneksi dan error
                    $FileName= "Data-Log-$periode1";
                    //Config Plugin MPDF
                    define('_MPDF_PATH','../../assets/mpdf60/');
                    include(_MPDF_PATH . "mpdf.php");
                    $mpdf=new mPDF('utf-8', 'A4');
                    $html='<style>@page *{margin-top: 0px;}</style>'; 
                    //Beginning Buffer to save PHP variables and HTML tags
                    ob_start(); 
                }else{
                    if($format=="Excel"){
                        header("Content-type: application/vnd-ms-excel");
                        header("Content-Disposition: attachment; filename=Data-Log-$periode1.xls");
                    }
                }
                include "CetakLog.php";
                //Menampilkan header Penutup
                if($format=="PDF"){
                    $html = ob_get_contents();
                    ob_end_clean();
                    $mpdf->WriteHTML(utf8_encode($html));
                    $mpdf->Output($FileName.".pdf" ,'I');
                    exit;
                }
            }
        }
    }
?>