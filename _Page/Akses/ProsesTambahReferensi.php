<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $now=date('Y-m-d H:i');
    //Validasi nama_fitur
    if(empty($_POST['nama_fitur'])){
        echo '<span class="text-danger">Nama Fitur Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['kategori'])){
            echo '<span class="text-danger">kategori Tidak Boleh Kosong</span>';
        }else{
            if(empty($_POST['kode'])){
                echo '<span class="text-danger">Kode Tidak Boleh Kosong</span>';
            }else{
                if(empty($_POST['keterangan'])){
                    echo '<span class="text-danger">Setidaknya anda harus memberikan keterangan mengenai fitur tersebut</span>';
                }else{
                    $nama_fitur=$_POST['nama_fitur'];
                    $kategori=$_POST['kategori'];
                    $kode=$_POST['kode'];
                    $keterangan=$_POST['keterangan'];
                    $JumlahKode = strlen($kode);
                    $ValidasiDuplikat=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses_ref WHERE nama_fitur='$nama_fitur'"));
                    $ValidasiKode=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses_ref WHERE kode='$kode'"));
                    if(!empty($ValidasiDuplikat)){
                        echo '<span class="text-danger">Nama Fitur Tersebut Tersebut Sudah Digunakan</span>';
                    }else{
                        if(!empty($ValidasiKode)){
                            echo '<span class="text-danger">Kode Fitur Tersebut Sudah Digunakan</span>';
                        }else{
                            if($JumlahKode>15){
                                echo '<span class="text-danger">Kode Fitur Maksimal 15 karakter</span>';
                            }else{
                                $entry="INSERT INTO akses_ref (
                                    nama_fitur,
                                    kategori,
                                    kode,
                                    keterangan
                                ) VALUES (
                                    '$nama_fitur',
                                    '$kategori',
                                    '$kode',
                                    '$keterangan'
                                )";
                                $Input=mysqli_query($Conn, $entry);
                                if($Input){
                                    $JsonLogFile="../../_Page/Log/Log.json";
                                    $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Tambah Referensi Fitur","Akses",$SessionIdAkses,$JsonLogFile);
                                    if($MenyimpanLog=="Berhasil"){
                                        echo '<span class="text-success" id="NotifikasiTambahReferensiBerhasil">Success</span>';
                                    }else{
                                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                    }
                                }else{
                                    echo '<span class="text-danger">Tambah Data Referensi Gagal!</span>';
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>