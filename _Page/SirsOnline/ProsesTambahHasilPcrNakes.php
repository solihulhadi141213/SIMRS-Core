<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $WaktuLog=date('Y-m-d H:i:s');
    if(empty($_POST['id_nakes'])){
        echo '<span class="text-danger">ID Nakes Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['nama_nakes'])){
            echo '<span class="text-danger">Nama Nakes Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['kategori_nakes'])){
                echo '<span class="text-danger">Kategori Nakes Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['hasil_pcr'])){
                    echo '<span class="text-danger">Hasil PCR Tidak Boleh Kosong!</span>';
                }else{
                    if(empty($_POST['tanggal'])){
                        echo '<span class="text-danger">Tanggal Hasil PCR Tidak Boleh Kosong!</span>';
                    }else{
                        $id_nakes=$_POST['id_nakes'];
                        $tanggal=$_POST['tanggal'];
                        $nama_nakes=$_POST['nama_nakes'];
                        $kategori_nakes=$_POST['kategori_nakes'];
                        $hasil_pcr=$_POST['hasil_pcr'];
                        //Cek Duplikasi Data
                        $ValidasiDuplikat = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_pcr WHERE id_nakes='$id_nakes' AND tanggal='$tanggal'"));
                        if(!preg_match('/^[a-zA-Z\s]+$/', $nama_nakes)) {
                            echo '<span class="text-danger">Nama Nakes Hanya Boleh Huruf dan Spasi!</span>';
                        }else{
                            if(!preg_match('/^[a-zA-Z\s]+$/', $kategori_nakes)) {
                                echo '<span class="text-danger">Kategori Nakes Hanya Boleh Huruf dan Spasi!</span>';
                            }else{
                                if(!preg_match('/^[a-zA-Z\s]+$/', $hasil_pcr)) {
                                    echo '<span class="text-danger">Hasil PCR Hanya Boleh Huruf dan Spasi!</span>';
                                }else{
                                    if(!empty($ValidasiDuplikat)){
                                        echo '<span class="text-danger">Data Hasil Pemeriksaan PCR Nakes bersangkutan saudah ada di tanggal tersebut!</span>';
                                    }else{
                                        $entry="INSERT INTO nakes_pcr (
                                            id_nakes,
                                            tanggal,
                                            nama_nakes,
                                            kategori_nakes,
                                            hasil_pcr,
                                            id_akses
                                        ) VALUES (
                                            '$id_nakes',
                                            '$tanggal',
                                            '$nama_nakes',
                                            '$kategori_nakes',
                                            '$hasil_pcr',
                                            '$SessionIdAkses'
                                        )";
                                        $Input=mysqli_query($Conn, $entry);
                                        if($Input){
                                            $MenyimpanLog=getSaveLog($Conn,$WaktuLog,$SessionNama,"Tambah Hasil PCR nakes","PCR Nakes",$SessionIdAkses,$LogJsonFile);
                                            if($MenyimpanLog=="Berhasil"){
                                                echo '<span class="text-success" id="NotifikasiTambahHasilPcrNakesBerhasil">Success</span>';
                                            }else{
                                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                            }
                                        }else{
                                            echo '<span class="text-danger">Tambah Data Hasil PCR Gagal!</span>';
                                        }
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