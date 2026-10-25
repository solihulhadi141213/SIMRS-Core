<?php
    // Header JSON
    header('Content-Type: application/json');

    // Koneksi & timezone
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";

    // Hitung Jumlah pasien
    $JumlahPasien     = mysqli_num_rows(mysqli_query($Conn, "SELECT id_pasien FROM pasien"));

    // Hitung Jumlah Kunjungan
    $JumlahKunjungan  = mysqli_num_rows(mysqli_query($Conn, "SELECT id_kunjungan FROM kunjungan"));

    // Hitung Jumlah Poliklinik
    $JumlahPoliklinik = mysqli_num_rows(mysqli_query($Conn, "SELECT id_poliklinik FROM poliklinik WHERE status=1"));

    // Hitung Jumlah Total Tempat Tidur
    $JumlahBed = mysqli_num_rows(mysqli_query($Conn, "SELECT id_tempat_tidur FROM rr_tempat_tidur WHERE status=1"));

    // Tampilkan Response
    echo json_encode([
        "pasien" => $JumlahPasien,
        "kunjungan" => $JumlahKunjungan,
        "poliklinik" => $JumlahPoliklinik,
        "bed_total" => $JumlahBed
    ]);
?>