<?php
    //KONEKSI KE DATABASE
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i');
    if(empty($_POST['id_rad'])){
        echo '<span class="text-danger">ID Radiologi Tidak Boleh Kosong</span>';
    }else{
        $id_rad=$_POST['id_rad'];
        //Hapus radiologi
        $HapusRadiologi = mysqli_query($Conn, "DELETE from radiologi WHERE id_rad='$id_rad'") or die(mysqli_error($Conn));
        if ($HapusRadiologi) {
            //Hapus Verifikasi
            $HapusVerifikasi = mysqli_query($Conn, "DELETE from radiologi_sig WHERE id_rad='$id_rad'") or die(mysqli_error($Conn));
            if($HapusVerifikasi) {
                //Hitung Jumlah Rincian
                $JumlahRincian = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM radiologi_rincian WHERE id_rad='$id_rad'"));
                //Hitung Lampiran
                $JumlahLampiran = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM radiologi_file WHERE id_rad='$id_rad'"));
                //Looping Rincian
                $JumlahRincianDiHapus=0;
                $QryHasil = mysqli_query($Conn, "SELECT*FROM radiologi_rincian WHERE id_rad='$id_rad'");
                while ($DataHasil = mysqli_fetch_array($QryHasil)) {
                    $id_rincian= $DataHasil['id_rincian'];
                    //Hapus Rincian
                    $HapusRincianRadiologi = mysqli_query($Conn, "DELETE from radiologi_rincian WHERE id_rincian='$id_rincian'") or die(mysqli_error($Conn));
                    if($HapusRincianRadiologi){
                        $JumlahRincianDiHapus=$JumlahRincianDiHapus+1;
                    }else{
                        $JumlahRincianDiHapus=$JumlahRincianDiHapus+0;
                    }
                }
                //Lopping lampiran
                $JumlahLampiranDihapus=0;
                $QryLampiran = mysqli_query($Conn, "SELECT*FROM radiologi_file WHERE id_rad='$id_rad'");
                while ($DataLampiran = mysqli_fetch_array($QryLampiran)) {
                    $id_radiologi_file= $DataLampiran['id_radiologi_file'];
                    $filename= $DataLampiran['filename'];
                    $internal_eksternal= $DataLampiran['internal_eksternal'];
                    //Hapus Lampiran
                    $HapusLampiran = mysqli_query($Conn, "DELETE from radiologi_file WHERE id_radiologi_file='$id_radiologi_file'") or die(mysqli_error($Conn));
                    if($HapusLampiran){
                        if($internal_eksternal=="Internal"){
                            $UrlGambar="../../assets/images/Radiologi/$filename";
                            if(file_exists("$UrlGambar")){
                                unlink($UrlGambar);
                            }
                        }
                        $JumlahLampiranDihapus=$JumlahLampiranDihapus+1;
                    }else{
                        $JumlahLampiranDihapus=$JumlahLampiranDihapus+0;
                    }
                }
                if($JumlahRincian==$JumlahRincianDiHapus){
                    if($JumlahLampiran==$JumlahLampiranDihapus){
                        //menyimpan Log
                        $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Hapus Radiologi","Radiologi",$SessionIdAkses,$LogJsonFile);
                        if($MenyimpanLog=="Berhasil"){
                            $_SESSION['NotifikasiSwal']="Hapus Radiologi Berhasil";
                            echo '<span class="text-success" id="NotifikasiHapusRadiologiBerhasil">Success</span>';
                        }else{
                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                        }
                    }else{
                        echo '<span class="text-danger">Terjadi kesalahan pada saat menghapus lampiran</span>';
                    }
                }else{
                    echo '<span class="text-danger">Terjadi kesalahan pada saat menghapus rincian pemeriksaan</span>';
                }
            }
        }else{
            echo '<span class="text-danger">Hapus Rincian Gagal!</span>';
        }
    }
?>