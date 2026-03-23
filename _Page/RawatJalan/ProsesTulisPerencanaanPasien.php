<?php
    //Pengaturan waktu
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi dan akses
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i');
    $updatetime=date('Y-m-d H:i');
    //Validasi kelengkapan data
    if(empty($_POST['id_kunjungan'])){
        echo '<span class="text-danger">ID Kunjungan Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['kategori_perencanaan'])){
            echo '<span class="text-danger">Kategori Perencanaan Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['isi_perencanaan_pasien'])){
                echo '<span class="text-danger">Isi Perencanaan Tidak Boleh Kosong!</span>';
            }else{
                //Membuat Variabel
                $id_kunjungan=$_POST['id_kunjungan'];
                $kategori_perencanaan=$_POST['kategori_perencanaan'];
                $isi_perencanaan_pasien=$_POST['isi_perencanaan_pasien'];
                //Buka Id Pasien
                $id_pasien=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_pasien');
                if(empty($id_pasien)){
                    echo '<span class="text-danger">Data Kunjungan Tidak Valid!</span>';
                }else{
                    //Cek Apakah Sebelumnya Sudah ADa
                    $Qry = mysqli_query($Conn,"SELECT * FROM perencanaan_pasien WHERE id_kunjungan='$id_kunjungan' AND kategori_perencanaan='$kategori_perencanaan'")or die(mysqli_error($Conn));
                    $Data = mysqli_fetch_array($Qry);
                    if(empty($Data['id_perencanaan_pasien'])){
                        //Apabila Belum Ada maka di insert
                        $entry="INSERT INTO perencanaan_pasien (
                            id_pasien,
                            id_kunjungan,
                            id_akses,
                            tanggal_entry,
                            kategori_perencanaan,
                            perencanaan
                        ) VALUES (
                            '$id_pasien',
                            '$id_kunjungan',
                            '$SessionIdAkses',
                            '$updatetime',
                            '$kategori_perencanaan',
                            '$isi_perencanaan_pasien'
                        )";
                        $hasil=mysqli_query($Conn, $entry);
                    }else{
                        //Apabila sudah ada maka di edit
                        $id_perencanaan_pasien = $Data['id_perencanaan_pasien'];
                        $hasil= mysqli_query($Conn,"UPDATE perencanaan_pasien SET 
                            perencanaan='$isi_perencanaan_pasien'
                        WHERE id_perencanaan_pasien='$id_perencanaan_pasien'") or die(mysqli_error($Conn));
                    }
                    if($hasil){
                        $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Tulis Perencanaan Pasien","Kunjungan",$SessionIdAkses,$LogJsonFile);
                        if($MenyimpanLog=="Berhasil"){
                            echo '<span class="text-success" id="NotifikasiTulisPerencanaanPasienBerhasil">Success</span>';
                        }else{
                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                        }
                    }else{
                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat menyimpan Data Resep</span>';
                    }
                }
            }
        }
    }
?>