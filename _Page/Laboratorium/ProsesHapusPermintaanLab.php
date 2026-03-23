<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i');
    if(empty($_POST['id_permintaan'])){
        echo '<span class="text-danger">ID Permintaan Tidak Boleh Kosong</span>';
    }else{
        $id_permintaan=$_POST['id_permintaan'];
        //Buka id_lab
        $id_lab=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'id_lab');
        //hapus Permintaan
        $HapusPermintaan = mysqli_query($Conn, "DELETE FROM laboratorium_permintaan WHERE id_permintaan='$id_permintaan'") or die(mysqli_error($Conn));
        if ($HapusPermintaan) {
            //hapus laboratorium_pemeriksaan
            $HapusPemeriksaan = mysqli_query($Conn, "DELETE FROM laboratorium_pemeriksaan WHERE id_permintaan='$id_permintaan'") or die(mysqli_error($Conn));
            if ($HapusPemeriksaan) {
                //hapus rincian
                $HapusRincian = mysqli_query($Conn, "DELETE FROM laboratorium_rincian WHERE id_permintaan='$id_permintaan'") or die(mysqli_error($Conn));
                if ($HapusRincian) {
                    //Hapus sample lab
                    $HapusSample = mysqli_query($Conn, "DELETE FROM laboratorium_sample WHERE id_lab='$id_lab'") or die(mysqli_error($Conn));
                    if ($HapusSample) {
                        //Menyimpan Log
                        $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Hapus Permintaan Laboratorium","Laboratorium",$SessionIdAkses,$LogJsonFile);
                        if($MenyimpanLog=="Berhasil"){
                            $_SESSION['NotifikasiSwal']="Hapus Permintaan Berhasil";
                            echo '<span class="text-success" id="NotifikasiHapusPermintaanLabBerhasil">Success</span>';
                        }else{
                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                        }
                    }else{
                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menghapus Data Sample!</span>';
                    }
                }else{
                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menghapus Data rincian!</span>';
                }
            }else{
                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menghapus Data Pemeriksaan!</span>';
            }
        }else{
            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menghapus Data Permintaan Lab!</span>';
        }
    }
?>