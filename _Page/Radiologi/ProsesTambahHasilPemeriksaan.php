<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i');
    if(empty($_POST['GetIdRad'])){
        echo '<span class="text-danger">ID Radiolofi Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['HasilPemeriksaan'])){
            echo '<span class="text-danger">Silahkan Isi Hasil Analisis Pemeriksaan Pasien Atau Pilih Tombol Kembali Untuk Membatalkan Pengisian</span>';
        }else{
            if(empty($_POST['ParamaeterPemeriksaan'])){
                echo '<span class="text-danger">Silahkan Isi Parameter Pemeriksaan Pasien Atau Pilih Tombol Kembali Untuk Membatalkan Pengisian</span>';
            }else{
                $id_rad=$_POST['GetIdRad'];
                $HasilPemeriksaan=$_POST['HasilPemeriksaan'];
                $ParamaeterPemeriksaan=$_POST['ParamaeterPemeriksaan'];
                if(empty($_POST['keterangan'])){
                    $keterangan="";
                }else{
                    $keterangan=$_POST['keterangan'];
                }
                $ValidasiDuplikatData=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM radiologi_rincian WHERE id_rad='$id_rad' AND pemeriksaan='$ParamaeterPemeriksaan' AND hasil='$HasilPemeriksaan'"));
                if(!empty($ValidasiDuplikatData)){
                    echo '<span class="text-danger">Data Tersebut Sudah Ada</span>';
                }else{
                    //Menyimpan Data Radiologi
                    $entry="INSERT INTO radiologi_rincian (
                        id_rad,
                        kategori,
                        pemeriksaan,
                        hasil,
                        keterangan
                    )VALUES (
                        '$id_rad',
                        'Radiologi',
                        '$ParamaeterPemeriksaan',
                        '$HasilPemeriksaan',
                        '$keterangan'
                    )";
                    $hasil=mysqli_query($Conn, $entry);
                    if($hasil){
                        //menyimpan Log
                        $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Tambah Rincian Radiologi","Radiologi",$SessionIdAkses,$LogJsonFile);
                        if($MenyimpanLog=="Berhasil"){
                            $_SESSION['NotifikasiSwal']="Tambah Rincian Radiologi Berhasil";
                            echo '<input type="hidden" name="GetBackUrl" id="GetBackUrl" value="index.php?Page=Radiologi&Sub=DetailRadiologi&id='.$id_rad.'">';
                            echo '<span class="text-success" id="NotifikasiHasilPemeriksaanBerhasil">Success</span>';
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