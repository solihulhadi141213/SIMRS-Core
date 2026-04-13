<?php
    date_default_timezone_set('Asia/Jakarta');

    // Connection
    include "../../_Config/Connection.php";

    // Simrs Function
    include "../../_Config/SimrsFunction.php";

    // Session
    include "../../_Config/Session.php";

    // Validasi Session
    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger text-center">
                <small>Sesi Akses Sudah Berakhir! Silahkan Login Ulang!</small>
            </div>
        ';
        exit;
    }

    // Validasi id_akses_fitur
    if(empty($_POST['id_akses_fitur'])){
        echo '
            <div class="alert alert-danger text-center">
                <small>ID Fitur Tidak Boleh Kosong!</small>
            </div>
        ';
        exit;
    }

    // Buat Variabel Dan Sanitasi
    $id_akses_fitur = validateAndSanitizeInput($_POST['id_akses_fitur']);

    // Buka Data Dengan Prepared Statment
    $sql  = "SELECT * FROM  akses_fitur WHERE id_akses_fitur = ?";
    $stmt = $Conn->prepare($sql);

    // Bind parameter (tipe data integer "i")
    $stmt->bind_param("i", $id_akses_fitur);

    // Eksekusi statement
    $stmt->execute();

    // Ambil hasil query
    $result = $stmt->get_result();
    $Data = $result->fetch_assoc();

    // Simpan hasil ke variabel
    $nama_fitur = $Data['nama_fitur'] ?? null;
    $kategori   = $Data['kategori'] ?? null;
    $kode       = $Data['kode'] ?? null;
    $keterangan = $Data['keterangan'] ?? null;

    // Tutup statement
    $stmt->close();

    // Tampilkan Data
    echo '
        <div class="row mb-2">
            <div class="col-4"><small>Nama Fitur</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-muted">'.$nama_fitur.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Kategori</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-muted">'.$kategori.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Kode</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-muted">'.$kode.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Keterangan</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-muted">'.$keterangan.'</small></div>
        </div>
    ';

?>