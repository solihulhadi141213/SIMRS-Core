<?php
    // ======================================================
    // KONEKSI
    // ======================================================
    include "../../_Config/Connection.php";
    header('Content-Type: application/json');

    // ======================================================
    // VALIDASI INPUT
    // ======================================================
    if (empty($_POST['id_kunjungan'])) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'ID Kunjungan Tidak Boleh Kosong!'
        ]);
        exit;
    }

    $id_kunjungan = $_POST['id_kunjungan'];

    // ======================================================
    // QUERY DATA KUNJUNGAN
    // ======================================================
    $Qry = $Conn->prepare("SELECT id_kunjungan, id_pasien, nama, tujuan, pembayaran, poliklinik, ruangan, id_dokter FROM kunjungan_utama WHERE id_kunjungan = ?");
    if (!$Qry) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Prepare statement gagal: ' . $Conn->error
        ]);
        exit;
    }

    $Qry->bind_param("i", $id_kunjungan);

    if (!$Qry->execute()) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Gagal menjalankan query: ' . $Qry->error
        ]);
        exit;
    }

    $Result = $Qry->get_result();
    $Data   = $Result->fetch_assoc();
    $Qry->close();

    // ======================================================
    // VALIDASI DATA ADA / TIDAK
    // ======================================================
    if (!$Data) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'ID Kunjungan Tidak Valid atau Tidak Ditemukan!'
        ]);
        exit;
    }

    // ======================================================
    // RESPONSE SUCCESS
    // ======================================================
    if($Data['tujuan']=="Rajal"){
        $asal_kiriman = $Data['poliklinik'];
    }else{
        $asal_kiriman = $Data['ruangan'];
    }
    echo json_encode([
        'status'       => 'Success',
        'message'      => 'Data kunjungan berhasil ditemukan',
        'id_pasien'    => $Data['id_pasien'],
        'nama'         => $Data['nama'],
        'tujuan'       => $Data['tujuan'],
        'pembayaran'   => $Data['pembayaran'],
        'id_dokter'   => $Data['id_dokter'],
        'asal_kiriman' => $asal_kiriman
    ]);
    exit;
?>