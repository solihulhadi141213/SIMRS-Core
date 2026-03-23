<?php
    //Koneksi
    include "../../_Config/Connection.php";

    //tangkap ID
    if(empty($_POST['id_ruang_rawat'])){
        echo '<div clas="alert alert-danger">ID Kelas/Ruangan Tidak Boleh Kosong!</div>';
        exit;
    }

    //Buat Variabel
    $id_ruang_rawat = $_POST['id_ruang_rawat'];

    //Buka Data Dari Database
    $Qry = mysqli_query($Conn,"SELECT kategori, kodekelas, kelas, ruangan, bed  FROM ruang_rawat WHERE id_ruang_rawat='$id_ruang_rawat'")or die(mysqli_error($Conn));
    $Data = mysqli_fetch_array($Qry);

    //Apabila kategori tidak diemukan
    if(Empty($Data['kategori'])){
        echo '<div clas="alert alert-danger">Data yang anda pilih dari database tidak ditemukan!</div>';
        exit;
    }

    $kategori       = $Data['kategori'];
    $kodekelas      = $Data['kodekelas'];
    $kelas          = $Data['kelas'];

    //Proses Hapus Berdasarkan Kategori
    if($kategori=="bed"){
        $HapusRungan = mysqli_query($Conn, "DELETE FROM ruang_rawat WHERE id_ruang_rawat='$id_ruang_rawat'") or die(mysqli_error($Conn));
        if($HapusRungan){
            $validasi_proses = "Berhasil";
        }else{
            $validasi_proses = "Terjadi kesalahan pada saat menghapus tempat tidur";
        }
    }else{
        if($kategori=="ruangan"){
            $ruangan = $Data['ruangan'];
            $HapusRungan = mysqli_query($Conn, "DELETE FROM ruang_rawat WHERE ruangan='$ruangan'") or die(mysqli_error($Conn));
            if($HapusRungan){
                $validasi_proses = "Berhasil";
            }else{
                $validasi_proses = "Terjadi kesalahan pada saat menghapus Ruangan";
            }
        }else{
            if($kategori=="kelas"){
                $kelas = $Data['kelas'];
                $HapusRungan = mysqli_query($Conn, "DELETE FROM ruang_rawat WHERE kelas='$kelas'") or die(mysqli_error($Conn));
                if($HapusRungan){
                    $validasi_proses = "Berhasil";
                }else{
                    $validasi_proses = "Terjadi kesalahan pada saat menghapus Kelas";
                }
            }
        }
    }

    if($validasi_proses!=="Berhasil"){
        echo '<div clas="alert alert-danger">'.$validasi_proses.'</div>';
    }else{
        echo '<div clas="alert alert-success">Hapus Data <b id="NotifikasiHapusBerhasil">Berhasil</b></div>';
    }
?>