<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i');
    if(empty($_POST['GetIdRad'])){
        echo '<span class="text-danger">ID Radiologi Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['GetIdRincian'])){
            echo '<span class="text-danger">ID Hasil Pemeriksaan Tidak Boleh Kosong</span>';
        }else{
            if(empty($_POST['EditHasilPemeriksaan'])){
                echo '<span class="text-danger">Silahkan Isi Hasil Analisis Pemeriksaan Pasien Atau Pilih Tombol Kembali Untuk Membatalkan Pengisian</span>';
            }else{
                if(empty($_POST['EditParamaeterPemeriksaan'])){
                    echo '<span class="text-danger">Silahkan Isi Parameter Pemeriksaan Pasien Atau Pilih Tombol Kembali Untuk Membatalkan Pengisian</span>';
                }else{
                    $GetIdRad=$_POST['GetIdRad'];
                    $GetIdRincian=$_POST['GetIdRincian'];
                    $EditHasilPemeriksaan=$_POST['EditHasilPemeriksaan'];
                    $EditParamaeterPemeriksaan=$_POST['EditParamaeterPemeriksaan'];
                    if(empty($_POST['EditKeterangan'])){
                        $EditKeterangan="";
                    }else{
                        $EditKeterangan=$_POST['EditKeterangan'];
                    }
                    //Menyimpan Data Rincian
                    $UpdateRincianRadiologi=mysqli_query($Conn, "UPDATE radiologi_rincian SET 
                        pemeriksaan='$EditParamaeterPemeriksaan', 
                        hasil='$EditHasilPemeriksaan', 
                        keterangan='$EditKeterangan'
                    WHERE id_rincian='$GetIdRincian'");
                    if($UpdateRincianRadiologi){
                        //menyimpan Log
                        $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Edit Rincian Radiologi","Radiologi",$SessionIdAkses,$LogJsonFile);
                        if($MenyimpanLog=="Berhasil"){
                            $_SESSION['NotifikasiSwal']="Edit Rincian Radiologi Berhasil";
                            echo '<input type="hidden" name="GetBackUrl" id="GetBackUrl" value="index.php?Page=Radiologi&Sub=DetailRadiologi&id='.$GetIdRad.'">';
                            echo '<span class="text-success" id="NotifikasiEditHasilPemeriksaanBerhasil">Success</span>';
                        }else{
                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                        }
                    }else{
                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Data!</span>';
                    }
                }
            }
        }
    }
?>