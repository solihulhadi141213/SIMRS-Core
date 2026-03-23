<?php
    //KONEKSI KE DATABASE
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i');
    if(empty($_POST['id_radiologi_file'])){
        echo '<span class="text-danger">ID Lampiran Tidak Boleh Kosong</span>';
    }else{
        $id_radiologi_file=$_POST['id_radiologi_file'];
        //Membuka Detail Lampiran
        if(empty(getDataDetail($Conn,'radiologi_file','id_radiologi_file',$id_radiologi_file,'id_radiologi_file'))){
            echo '<span class="text-danger">ID Lampiran Tidak Valid Atau Tidak Terdapat pada Database</span>';
        }else{
            $internal_eksternal=getDataDetail($Conn,'radiologi_file','id_radiologi_file',$id_radiologi_file,'internal_eksternal');
            $url_file=getDataDetail($Conn,'radiologi_file','id_radiologi_file',$id_radiologi_file,'url_file');
            $filename=getDataDetail($Conn,'radiologi_file','id_radiologi_file',$id_radiologi_file,'filename');
            $HapusLampiran = mysqli_query($Conn, "DELETE from radiologi_file WHERE id_radiologi_file='$id_radiologi_file'") or die(mysqli_error($Conn));
            if($HapusLampiran) {
                //menyimpan Log
                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Hapus File Lampiran Radiologi","Radiologi",$SessionIdAkses,$LogJsonFile);
                if($MenyimpanLog=="Berhasil"){
                    if($internal_eksternal=="Internal"){
                        $UrlGambar="../../assets/images/Radiologi/$filename";
                        if(file_exists("$UrlGambar")){
                            unlink($UrlGambar);
                        }
                    }
                    $_SESSION['NotifikasiSwal']="Hapus Lampiran Radiologi Berhasil";
                    echo '<span class="text-success" id="NotifikasiHapusLampiranBerhasil">Success</span>';
                }else{
                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                }
            }else{
                echo '<span class="text-danger">Hapus Lampiran Gagal!</span>';
            }
        }
    }
?>