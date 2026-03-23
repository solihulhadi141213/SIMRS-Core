<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Buka Profile Sekolah
    $QryProfile = mysqli_query($Conn,"SELECT * FROM setting_profile WHERE id_profile='1'")or die(mysqli_error($Conn));
    $DataProfile = mysqli_fetch_array($QryProfile);
    $nama_faskes= $DataProfile['nama_faskes'];
    $alamat= $DataProfile['alamat'];
    $kontak= $DataProfile['kontak'];
    $email= $DataProfile['email'];
    //short_by
    if(!empty($_POST['short_by'])){
        $Short=$_POST['short_by'];
    }else{
        $Short="ASC";
    }
    //order_by
    if(!empty($_POST['order_by'])){
        $Order=$_POST['order_by'];
    }else{
        $Order="nis";
    }
    //format_by
    if(!empty($_POST['format_by'])){
        $Format=$_POST['format_by'];
    }else{
        $Format="HTML";
    }
    //keyword
    if(!empty($_POST['keyword'])){
        $keyword=$_POST['keyword'];
    }else{
        $keyword="";
    }
    //Tampilkan Data berdasarkan Formatnya
    if($Format=="Excel"){
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=DataPasien.xls");
    }else{
        if($format=="PDF"){
            //koneksi dan error
            $FileName= "DataPasien";
            //Config Plugin MPDF
            define('_MPDF_PATH','../../assets/mpdf60/');
            include(_MPDF_PATH . "mpdf.php");
            $mpdf=new mPDF('utf-8', 'A4');
            $html='<style>@page *{margin-top: 0px;}</style>'; 
            //Beginning Buffer to save PHP variables and HTML tags
            ob_start(); 
        }
    }
    include "ExportDataPasien.php";
    if($format=="PDF"){
        $html = ob_get_contents();
        ob_end_clean();
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output($FileName.".pdf" ,'I');
        exit;
    }
?>