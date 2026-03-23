<?php
    //Zona waktu dan koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $now=date('Y-m-d H:i');
    if(empty($_POST['id_dokter'])){
        echo '<span class="text-danger">ID Dokter Tidak dapat ditangkap pada saat proses hapus data</span>';
    }else{
        $id_dokter=$_POST['id_dokter'];
        //Buka data dokter
        $QryDokter= mysqli_query($Conn,"SELECT * FROM dokter WHERE id_dokter='$id_dokter'")or die(mysqli_error($Conn));
        $DataDokter= mysqli_fetch_array($QryDokter);
        if(empty($DataDokter['foto'])){
            //Hapus Dokter
            $HapusDokter = mysqli_query($Conn, "DELETE FROM dokter WHERE id_dokter='$id_dokter'") or die(mysqli_error($Conn));
            if($HapusDokter){
                //Hapus Jadwal Dokter
                $HapusJadwalDokter = mysqli_query($Conn, "DELETE FROM jadwal_dokter WHERE id_dokter='$id_dokter'") or die(mysqli_error($Conn));
                if($HapusJadwalDokter){
                    $JsonUrl="../../_Page/Log/Log.json";
                    $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Hapus Dokter","Dokter",$SessionIdAkses,$JsonUrl);
                    echo '<span class="text-success" id="NotifikasiHapusDokterBerhasil">Success</span>';
                }else{
                    echo '<span class="text-danger">Terjadi kesalahan pada saat menghapus jadwal dokter</span>';
                }
            }else{
                echo '<span class="text-danger">Terjadi kesalahan pada saat menghapus data dokter</span>';
            }
        }else{
            $foto= $DataDokter['foto'];
            $LinkGambar="../../assets/images/Dokter/$foto";
            unlink("$LinkGambar");
            //Proses hapus data
            if(file_exists($LinkGambar)){
                echo '<span class="text-danger">Terjadi kesalahan Pada Saat Hapus File Foto Dokter!!</span>';
            }else{
                //Hapus Dokter
                $HapusDokter = mysqli_query($Conn, "DELETE FROM dokter WHERE id_dokter='$id_dokter'") or die(mysqli_error($Conn));
                if($HapusDokter){
                    //Hapus Jadwal Dokter
                    $HapusJadwalDokter = mysqli_query($Conn, "DELETE FROM jadwal_dokter WHERE id_dokter='$id_dokter'") or die(mysqli_error($Conn));
                    if($HapusJadwalDokter){
                        $JsonUrl="../../_Page/Log/Log.json";
                        $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Hapus Dokter","Dokter",$SessionIdAkses,$JsonUrl);
                        echo '<span class="text-success" id="NotifikasiHapusDokterBerhasil">Success</span>';
                    }else{
                        echo '<span class="text-danger">Terjadi kesalahan pada saat menghapus jadwal dokter</span>';
                    }
                }else{
                    echo '<span class="text-danger">Error: Ketika Proses Hapus Database Dokter!!</span>';
                }
            }
        }
    }
?>