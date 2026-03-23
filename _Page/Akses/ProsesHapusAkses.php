<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    //Waktu Sekarang
    $WaktuLog=date('Y-m-d H:i:s');
    //Apabila ID akses Tidak Ada
    if(empty($_POST['id_akses'])){
        echo '<span class="text-danger">ID Akses Tidak Boleh Kosong!</span>';
    }else{
        $id_akses=$_POST['id_akses'];
        //Buka File Foto
        $GambarAkses=getDataDetail($Conn,'akses','id_akses',$id_akses,'gambar');
        $EmailAkses=getDataDetail($Conn,'akses','id_akses',$id_akses,'email');
        //Buka Data Pengajuan
        $EmailPengajuan=getDataDetail($Conn,'akses_pengajuan','email',$EmailAkses,'email');
        //Proses hapus data
        $HapusAkses = mysqli_query($Conn, "DELETE FROM akses WHERE id_akses='$id_akses'") or die(mysqli_error($Conn));
        if($HapusAkses) {
            $HapusAksesAcc = mysqli_query($Conn, "DELETE FROM akses_acc WHERE id_akses='$id_akses'") or die(mysqli_error($Conn));
            if($HapusAkses) {
                if(!empty($EmailPengajuan)){
                    //Update Pengajuan Akses Menjadi Pending Kembali (Revese)
                    $UpdatePengajuanAkses = mysqli_query($Conn,"UPDATE akses_pengajuan SET 
                        status='Pending'
                    WHERE email='$EmailPengajuan'") or die(mysqli_error($Conn)); 
                    if($UpdatePengajuanAkses){
                        //Hapus File
                        $UrlFoto="../../assets/images/user/$GambarAkses";
                        if(file_exists($UrlFoto)){
                            unlink($UrlFoto);
                        }
                        //Simpan Log
                        $MenyimpanLog=getSaveLog($Conn,$WaktuLog,$SessionNama,"Hapus Akses","Akses",$SessionIdAkses,$LogJsonFile);
                        if($MenyimpanLog=="Berhasil"){
                            $_SESSION['NotifikasiSwal']="Hapus Akses Berhasil";
                            echo '<span class="text-success" id="NotifikasiHapusAksesBerhasil">Success</span>';
                        }else{
                            echo '<span class="text-danger">Gagal Menyimpan Log!</span>';
                        }
                    }else{
                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Update Pengajuan Akses!</span>';
                    }
                }else{
                    //Hapus File
                    $UrlFoto="../../assets/images/user/$GambarAkses";
                    if(file_exists($UrlFoto)){
                        unlink($UrlFoto);
                    }
                    //Simpan Log
                    $MenyimpanLog=getSaveLog($Conn,$WaktuLog,$SessionNama,"Hapus Akses","Akses",$SessionIdAkses,$LogJsonFile);
                    if($MenyimpanLog=="Berhasil"){
                        $_SESSION['NotifikasiSwal']="Hapus Akses Berhasil";
                        echo '<span class="text-success" id="NotifikasiHapusAksesBerhasil">Success</span>';
                    }else{
                        echo '<span class="text-danger">Gagal Menyimpan Log!</span>';
                    } 
                }
            }else{
                echo '<span class="text-danger">Data Akses Sudah Terhapus Namun Akses Acc Gagal!</span>';
            }
        }else{
            echo '<span class="text-danger">Hapus Akses Gagal!</span>';
        }
    }
?>