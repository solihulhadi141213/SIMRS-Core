<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i');
    //Validasi judul
    if(empty($_POST['judul'])){
        echo '<span class="text-danger">Judul Laporan Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['laporan'])){
            echo '<span class="text-danger">Isi Laporan Tidak Boleh Kosong</span>';
        }else{
            $judul=$_POST['judul'];
            $laporan=$_POST['laporan'];
            $JumlahJudul = strlen($judul);
            //Validasi Jumlah Karakter
            if($JumlahJudul>100){
                echo '<span class="text-danger">Judul Laporan Tidak Boleh Lebih Dari 100 Karakter</span>';
            }else{
                //Validasi Duplikat
                $ValidasiDuplikat=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM  laporan_pengguna WHERE tanggal='$now' AND id_akses='$SessionIdAkses'"));
                if(!empty($ValidasiDuplikat)){
                    echo '<span class="text-danger">Data Tersebut Mungkin Sudah Ada!</span>';
                }else{
                    $entry="INSERT INTO laporan_pengguna (
                        id_akses,
                        nama,
                        tanggal,
                        judul,
                        laporan,
                        response
                    ) VALUES (
                        '$SessionIdAkses',
                        '$SessionNama',
                        '$now',
                        '$judul',
                        '$laporan',
                        ''
                    )";
                    $Input=mysqli_query($Conn, $entry);
                    if($Input){
                        $JsonLogFile="../../_Page/Log/Log.json";
                        $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Kirim Laporan Pengguna","My Profile",$SessionIdAkses,$JsonLogFile,$LogJsonFile);
                        if($MenyimpanLog=="Berhasil"){
                            $_SESSION['NotifikasiSwal']="Kirim Laporan Pengguna Berhasil";
                            echo '<span class="text-success" id="NotifikasiKirimLaporanPenggunaBerhasil">Success</span>';
                        }else{
                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                        }
                    }else{
                        echo '<span class="text-danger">Kirim Laporan Pengguna Gagal!</span>';
                    }
                }
            }
        }
    }
?>