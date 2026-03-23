<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $WaktuLog=date('Y-m-d H:i:s');
    if(empty($_POST['id_nakes_terinfeksi'])){
        echo '<span class="text-danger">ID Nakes Terinfeksi Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['id_nakes_pcr'])){
            echo '<span class="text-danger">ID Nakes PCR Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['nama'])){
                echo '<span class="text-danger">Nama Nakes Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['kategori'])){
                    echo '<span class="text-danger">Kategori Nakes Tidak Boleh Kosong!</span>';
                }else{
                    if(empty($_POST['tanggal'])){
                        echo '<span class="text-danger">Tanggal Tidak Boleh Kosong!</span>';
                    }else{
                        if(empty($_POST['status'])){
                            echo '<span class="text-danger">Status Tidak Boleh Kosong!</span>';
                        }else{
                            $id_nakes_terinfeksi=$_POST['id_nakes_terinfeksi'];
                            $id_nakes_pcr=$_POST['id_nakes_pcr'];
                            $nama=$_POST['nama'];
                            $kategori=$_POST['kategori'];
                            $tanggal=$_POST['tanggal'];
                            $status=$_POST['status'];
                            if(!preg_match('/^[a-zA-Z\s]+$/', $nama)) {
                                echo '<span class="text-danger">Nama Nakes Hanya Boleh Huruf dan Spasi!</span>';
                            }else{
                                if(!preg_match('/^[0-9]+$/', $id_nakes_pcr)) {
                                    echo '<span class="text-danger">ID Nakes PCR Hanya Boleh Angka!</span>';
                                }else{
                                    $UpdateNakesTerinfeksi = mysqli_query($Conn,"UPDATE nakes_terinfeksi SET 
                                        id_nakes_pcr='$id_nakes_pcr',
                                        nama='$nama',
                                        tanggal='$tanggal',
                                        kategori='$kategori',
                                        status='$status'
                                    WHERE id_nakes_terinfeksi='$id_nakes_terinfeksi'") or die(mysqli_error($Conn)); 
                                    if($UpdateNakesTerinfeksi){
                                        $MenyimpanLog=getSaveLog($Conn,$WaktuLog,$SessionNama,"Edit data nakes terinfeksi","Nakes",$SessionIdAkses,$LogJsonFile);
                                        if($MenyimpanLog=="Berhasil"){
                                            echo '<span class="text-success" id="NotifikasiEditNakesTerinfeksiBerhasil">Success</span>';
                                        }else{
                                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                        }
                                    }else{
                                        echo '<span class="text-danger">Edit Data Nakes Terinfeksi Gagal!</span>';
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>