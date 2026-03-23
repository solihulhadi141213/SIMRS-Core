<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i');
    if(empty($_POST['id'])){
        echo '<span class="text-danger">ID Setting Tidak Boleh Kosong!</span>';
    }else{
        $id_profile=$_POST['id'];
        $FileLamaFavicon=getDataDetail($Conn,'setting_profile','id_profile',$id_profile,'favicon');
        $FileLamaLogo=getDataDetail($Conn,'setting_profile','id_profile',$id_profile,'logo');
        //Proses hapus Setting Satu Sehat
        $HapusSetting = mysqli_query($Conn, "DELETE FROM setting_profile WHERE id_profile='$id_profile'") or die(mysqli_error($Conn));
        if($HapusSetting){
            $UrlFileLamaFavicon = "../../assets/images/".$FileLamaFavicon;
            $UrlFileLamaLogo = "../../assets/images/".$FileLamaLogo;
            unlink($UrlFileLamaFavicon);
            unlink($UrlFileLamaLogo);
            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Hapus Setting Profile Faskes","Setting",$SessionIdAkses,$LogJsonFile);
            if($MenyimpanLog=="Berhasil"){
                $_SESSION['NotifikasiSwal']="Hapus Setting Berhasil";
                echo '<span class="text-success" id="NotifikasiHapusSettingProfileFaskesBerhasil">Success</span>';
            }else{
                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
            }
        }else{
            echo '<span class="text-danger">Hapus Setting Profile Faskes Gagal!</span>';
        }
    }
?>