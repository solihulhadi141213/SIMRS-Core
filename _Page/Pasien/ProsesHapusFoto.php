<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i:s');
    $updatetime=date('Y-m-d H:i:s');
    //Validasi Form Data Yang Wajib Diisi
    if(empty($_POST['id_pasien'])){
        echo '<span class="text-danger">ID Pasien Tidak Boleh Kosong</span>';
    }else{
        $id_pasien=$_POST['id_pasien'];
        //Membuka data lama berdasarkan id_pasien
        $QryPasien = mysqli_query($Conn,"SELECT * FROM pasien WHERE id_pasien='$id_pasien'")or die(mysqli_error($Conn));
        $DataPasien = mysqli_fetch_array($QryPasien);
        if(empty($DataPasien['id_pasien'])){
            echo '<span class="text-danger">ID Pasien Tidak Valid</span>';
        }else{
            if(empty($DataPasien['gambar'])){
                echo '<span class="text-danger">Pasien Tidak Memiliki File Foto</span>';
            }else{
                $GambarLama=$DataPasien['gambar'];
                $UpdatePasien= mysqli_query($Conn,"UPDATE pasien SET 
                    gambar='',
                    updatetime='$updatetime'
                WHERE id_pasien='$id_pasien'") or die(mysqli_error($Conn)); 
                if($UpdatePasien){
                    if(!empty($GambarLama)){
                        //Menghapus file
                        $files="../../assets/images/pasien/$GambarLama";
                        unlink($files);
                    }
                    $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Hapus Foto Pasien","Pasien",$SessionIdAkses,$LogJsonFile);
                    if($MenyimpanLog=="Berhasil"){
                        $_SESSION['NotifikasiSwal']="Hapus Foto Pasien Berhasil";
                        echo '<span class="text-success" id="NotifikasiHapusFotoBerhasil">Success</span>';
                    }else{
                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                    }
                }else{
                    echo '<span class="text-danger">Update Pasien Gagal</span>';
                }
            }
        }
    }
?>