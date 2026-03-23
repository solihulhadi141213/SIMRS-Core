<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
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
                    if(empty($_POST['id_akses_ref'])){
                        echo '<span class="text-danger">ID Referensi Tidak Boleh Kosong!</span>';
                    }else{
                        $id_akses_ref=$_POST['id_akses_ref'];
                        $nama_fitur=$_POST['nama_fitur'];
                        $kategori=$_POST['kategori'];
                        $kode=$_POST['kode'];
                        $keterangan=$_POST['keterangan'];
                        $JumlahKode = strlen($kode);
                        if($JumlahKode>15){
                            echo '<span class="text-danger">Kode Fitur Maksimal 15 karakter</span>';
                        }else{
                            $UpdateReferensi = mysqli_query($Conn,"UPDATE akses_ref SET 
                                nama_fitur='$nama_fitur',
                                kategori='$kategori',
                                kode='$kode',
                                keterangan='$keterangan'
                            WHERE id_akses_ref='$id_akses_ref'") or die(mysqli_error($Conn)); 
                            if($UpdateReferensi){
                                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Edit Referensi Fitur","Akses",$SessionIdAkses,$LogJsonFile);
                                if($MenyimpanLog=="Berhasil"){
                                    // $_SESSION['NotifikasiSwal']="Edit Referensi Berhasil";
                                    echo '<span class="text-success" id="NotifikasiEditReferensiAksesBerhasil">Success</span>';
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
?>