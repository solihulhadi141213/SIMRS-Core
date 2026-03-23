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

    //Tampilkan Data
    echo '
        <input type="hidden" name="id_ruang_rawat" value="'.$id_ruang_rawat.'">
        <div class="row mb-3">
            <div class="col-5">Kategori</div>
            <div class="col-1">:</div>
            <div class="col-6">'.$kategori.'</div>
        </div>
        <div class="row mb-3">
            <div class="col-5">Kode Kelas</div>
            <div class="col-1">:</div>
            <div class="col-6">'.$kodekelas.'</div>
        </div>
        <div class="row mb-3">
            <div class="col-5">Nama Kelas</div>
            <div class="col-1">:</div>
            <div class="col-6">'.$kelas.'</div>
        </div>
    ';

    //Menampilkan Detail Berdasarkan Kategori
    if($kategori=="bed"){
        $ruangan    = $Data['ruangan'];
        $bed        = $Data['bed'];
        echo '
            <div class="row mb-3">
                <div class="col-5">Ruangan</div>
                <div class="col-1">:</div>
                <div class="col-6">'.$ruangan.'</div>
            </div>
            <div class="row mb-3">
                <div class="col-5">Tempat Tidur</div>
                <div class="col-1">:</div>
                <div class="col-6">'.$bed.'</div>
            </div>
        ';
    }
    if($kategori=="ruangan"){
        $ruangan          = $Data['ruangan'];
        echo '
            <div class="row mb-3">
                <div class="col-5">Ruangan</div>
                <div class="col-1">:</div>
                <div class="col-6">'.$ruangan.'</div>
            </div>
        ';
    }
    echo '
        <div class="row mb-3">
            <div class="col-12">
                Apakah anda yakin akan menghapus data ini?
            </div>
        </div>
    ';
?>