<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_perkiraan'])){
        echo '<span class="text-danger">ID Tarif tindakan tidak boleh kosong!</span>';
    }else{
        $id_perkiraan=$_POST['id_perkiraan'];
        //Buka Detail Akun Perkiraan
        $kode=getDataDetail($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'kode');
        $level=getDataDetail($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'level');
        $rank=getDataDetail($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'rank');
        //Kd Anak
        $kd="kd$level";
        //Hapus Akun Perkiraan
        $HapusAkunPerkiraan = mysqli_query($Conn, "DELETE FROM akun_perkiraan WHERE id_perkiraan='$id_perkiraan'") or die(mysqli_error($Conn));
        if($HapusAkunPerkiraan){
            //Hapus data anak akun
            $query2 = mysqli_query($Conn, "DELETE FROM akun_perkiraan WHERE kd$level='$kode' AND level>'$level'") or die(mysqli_error($Conn));
            if($query2){
                echo '<span class="text-success" id="NotifikasiHapusAkunPerkiraanBerhasil">Success</span>';
            }else{
                echo '<i class="text-danger">Delete Anak Akun Gagal</i>';
            }
        }else{
            echo '<span class="text-danger">Terjadi kesalahan pada saat menghapus data akun perkiraan</span>';
        }
    }
?>