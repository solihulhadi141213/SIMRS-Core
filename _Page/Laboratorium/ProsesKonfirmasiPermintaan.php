<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i');
    if(empty($_POST['id_permintaan'])){
        echo '<span class="text-danger">ID Permintaan Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['status_permintaan'])){
            echo '<span class="text-danger">Status Permintaan Tidak Boleh Kosong</span>';
        }else{
            $id_permintaan=$_POST['id_permintaan'];
            $status_permintaan=$_POST['status_permintaan'];
            //Kondisi apabila ditolak
            if($status_permintaan=="Ditolak"){
                if(empty($_POST['keterangan_status'])){
                    echo '<span class="text-danger">Keterangan Status Tidak Boleh Kosong!</span>';
                }else{
                    $keterangan_status=$_POST['keterangan_status'];
                    $UpdatePermintaan= mysqli_query($Conn,"UPDATE laboratorium_permintaan SET 
                        status='Ditolak',
                        keterangan_status='$keterangan_status'
                    WHERE id_permintaan='$id_permintaan'") or die(mysqli_error($Conn));
                    if($UpdatePermintaan){
                        //menyimpan Log
                        $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Konfirmasi Permintaan Pemeriksaan","Laboratorium",$SessionIdAkses,$LogJsonFile);
                        if($MenyimpanLog=="Berhasil"){
                            $_SESSION['NotifikasiSwal']="Konfirmasi Permintaan Berhasil";
                            echo '<span class="text-success" id="NotifikasiKonfirmasiPermintaanBerhasil">Success</span>';
                        }else{
                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                        }
                    }else{
                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Data!</span>';
                    }
                }
            }else{
                if(empty($_POST['tanggal_daftar'])){
                    echo '<span class="text-danger">Tanggal Daftar Tidak Boleh Kosong!</span>';
                }else{
                    $tanggal_daftar=$_POST['tanggal_daftar'];
                    if(empty($_POST['jam_daftar'])){
                        echo '<span class="text-danger">Jam Daftar Tidak Boleh Kosong!</span>';
                    }else{
                        $jam_daftar=$_POST['jam_daftar'];
                        $Tanggal="$tanggal_daftar $jam_daftar";
                        //Update permintaan
                        $UpdatePermintaan= mysqli_query($Conn,"UPDATE laboratorium_permintaan SET 
                            status='Diterima'
                        WHERE id_permintaan='$id_permintaan'") or die(mysqli_error($Conn));
                        if($UpdatePermintaan){
                            //Tambahkan Pemeriksaan Lab
                            $entry="INSERT INTO laboratorium_pemeriksaan (
                                id_permintaan,
                                waktu_pendaftaran
                            )VALUES (
                                '$id_permintaan',
                                '$Tanggal'
                            )";
                            $hasil=mysqli_query($Conn, $entry);
                            if($hasil){
                                //menyimpan Log
                                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Konfirmasi Permintaan Pemeriksaan","Laboratorium",$SessionIdAkses,$LogJsonFile);
                                if($MenyimpanLog=="Berhasil"){
                                    $_SESSION['NotifikasiSwal']="Konfirmasi Permintaan Berhasil";
                                    echo '<span class="text-success" id="NotifikasiKonfirmasiPermintaanBerhasil">Success</span>';
                                }else{
                                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                }
                            }else{
                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Data!</span>';
                            }
                        }else{
                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Data!</span>';
                        }
                    }
                }
            }
        }
    }
?>