<?php
header('Content-Type: application/json');

include "../../_Config/Connection.php";
include "../../_Config/Session.php";
include "../../_Config/SimrsFunction.php";

$response = [
    'status' => 'error',
    'message' => ''
];

try {

    // SESSION
    if (empty($SessionIdAkses)) {
        throw new Exception("Sesi akses berakhir!");
    }

    // VALIDASI
    $required = [
        'id_alergi',
        'id_pasien',
        'id_kunjungan',
        'kategori_alergen',
        'clinical_status'
    ];

    foreach ($required as $r) {

        if (empty($_POST[$r])) {
            throw new Exception("$r wajib diisi!");
        }
    }

    // MAPPING
    $id_alergi         = trim($_POST['id_alergi']);
    $id_pasien         = trim($_POST['id_pasien']);
    $id_kunjungan      = trim($_POST['id_kunjungan']);
    $kategori_alergen  = trim($_POST['kategori_alergen']);
    $clinical_status   = trim($_POST['clinical_status']);
    $id_praktisi       = trim($_POST['id_praktisi'] ?? '');
    $manual_alergen    = trim($_POST['manual_alergen'] ?? '');
    $id_alergi_alergen = trim($_POST['id_alergi_alergen'] ?? '');
    $keterangan_alergi = trim($_POST['keterangan_alergi'] ?? '');

    // DEFAULT
    $verification_status = 'confirmed';

    // PRAKTISI
    $nama_praktisi = '';

    if (!empty($id_praktisi)) {

        $stmt = $Conn->prepare("
            SELECT nama_praktisi
            FROM praktisi
            WHERE id_praktisi = ?
        ");

        $stmt->bind_param("i", $id_praktisi);
        $stmt->execute();

        $result = $stmt->get_result();
        $praktisi = $result->fetch_assoc();

        if ($praktisi) {
            $nama_praktisi = $praktisi['nama_praktisi'];
        }
    }

    // MANUAL ALERGEN
    if (!empty($manual_alergen)) {

        $nama_alergen = $manual_alergen;

        $stmt = $Conn->prepare("
            INSERT INTO alergi_alergen (
                kategori_alergen,
                nama_alergen,
                author_id,
                author_name,
                datetime_creat,
                status
            ) VALUES (
                ?, ?, ?, ?, NOW(), 1
            )
        ");

        $stmt->bind_param(
            "ssis",
            $kategori_alergen,
            $nama_alergen,
            $SessionIdAkses,
            $SessionNama
        );

        if (!$stmt->execute()) {
            throw new Exception($stmt->error);
        }

        $id_alergi_alergen = $Conn->insert_id;

    } else {

        if (!empty($id_alergi_alergen) && is_numeric($id_alergi_alergen)) {

            $stmt = $Conn->prepare("
                SELECT nama_alergen
                FROM alergi_alergen
                WHERE id_alergi_alergen = ?
            ");

            $stmt->bind_param("i", $id_alergi_alergen);
            $stmt->execute();

            $result = $stmt->get_result();
            $alergen = $result->fetch_assoc();

            $nama_alergen = $alergen['nama_alergen'] ?? '';

        } else {

            $nama_alergen = $id_alergi_alergen;
            $id_alergi_alergen = NULL;
        }
    }

    // UPDATE
    $stmt = $Conn->prepare("
        UPDATE alergi
        SET
            id_alergi_alergen = ?,
            kategori_alergen = ?,
            nama_alergen = ?,
            clinical_status = ?,
            verification_status = ?,
            id_praktisi = ?,
            nama_praktisi = ?,
            keterangan_alergi = ?
        WHERE id_alergi = ?
    ");

    $stmt->bind_param(
        "issssisss",
        $id_alergi_alergen,
        $kategori_alergen,
        $nama_alergen,
        $clinical_status,
        $verification_status,
        $id_praktisi,
        $nama_praktisi,
        $keterangan_alergi,
        $id_alergi
    );

    if (!$stmt->execute()) {
        throw new Exception($stmt->error);
    }

    $response = [
        'status' => 'success',
        'message' => 'Edit alergi berhasil',
        'id_kunjungan' => $id_kunjungan
    ];

} catch (Exception $e) {

    $response = [
        'status' => 'error',
        'message' => $e->getMessage()
    ];
}

echo json_encode($response, JSON_PRETTY_PRINT);