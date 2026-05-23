<?php
header('Content-Type: application/json');

include "../../_Config/Connection.php";
include "../../_Config/Session.php";
include "../../_Config/SimrsFunction.php";

date_default_timezone_set('Asia/Jakarta');

$response = [
    'status' => 'error',
    'message' => '',
];

try {

    // VALIDASI SESSION
    if (empty($SessionIdAkses)) {
        throw new Exception("Sesi akses sudah berakhir!");
    }

    // VALIDASI INPUT
    $required = [
        'id_pasien',
        'id_kunjungan',
        'kategori_alergen',
        'clinical_status',
        'id_praktisi'
    ];

    foreach ($required as $field) {

        if (empty($_POST[$field])) {
            throw new Exception("Field $field wajib diisi!");
        }
    }

    // SANITASI
    $id_pasien         = validateAndSanitizeInput($_POST['id_pasien']);
    $id_kunjungan      = validateAndSanitizeInput($_POST['id_kunjungan']);
    $kategori_alergen  = validateAndSanitizeInput($_POST['kategori_alergen']);
    $clinical_status   = validateAndSanitizeInput($_POST['clinical_status']);
    $id_praktisi       = validateAndSanitizeInput($_POST['id_praktisi']);
    $keterangan_alergi = trim($_POST['keterangan_alergi'] ?? '');

    $manual_alergen    = trim($_POST['manual_alergen'] ?? '');
    $id_alergi_alergen = trim($_POST['id_alergi_alergen'] ?? '');

    // VALIDASI STATUS
    $allowed_clinical = ['active', 'inactive', 'resolved'];

    if (!in_array($clinical_status, $allowed_clinical)) {
        throw new Exception("Clinical status tidak valid!");
    }

    // DEFAULT
    $verification_status = 'confirmed';

    // PRAKTISI
    $stmt = $Conn->prepare("SELECT nama_praktisi FROM praktisi WHERE id_praktisi = ?");

    $stmt->bind_param("i", $id_praktisi);
    $stmt->execute();

    $result = $stmt->get_result();
    $praktisi = $result->fetch_assoc();

    if (!$praktisi) {
        throw new Exception("Data praktisi tidak ditemukan!");
    }

    $nama_praktisi = $praktisi['nama_praktisi'];

    // JIKA INPUT MANUAL
    if (!empty($manual_alergen)) {

        $nama_alergen = $manual_alergen;

        // INSERT REFERENSI ALERGEN
        $stmt = $Conn->prepare("
            INSERT INTO alergi_alergen (
                kategori_alergen,
                nama_alergen,
                code_alergen,
                display_alergen,
                system_alergen,
                author_id,
                author_name,
                datetime_creat,
                status
            ) VALUES (
                ?, ?, '', '', '',
                ?, ?, NOW(), 1
            )
        ");

        $stmt->bind_param(
            "ssiss",
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

        // AMBIL REFERENSI
        $stmt = $Conn->prepare("
            SELECT nama_alergen
            FROM alergi_alergen
            WHERE id_alergi_alergen = ?
        ");

        $stmt->bind_param("i", $id_alergi_alergen);
        $stmt->execute();

        $result = $stmt->get_result();
        $alergen = $result->fetch_assoc();

        if (!$alergen) {
            throw new Exception("Referensi alergen tidak ditemukan!");
        }

        $nama_alergen = $alergen['nama_alergen'];
    }

    // UID
    $id_alergi = GenerateRandomeToken(32);

    // INSERT ALERGI
    $stmt = $Conn->prepare("
        INSERT INTO alergi (
            id_alergi,
            id_pasien,
            id_kunjungan,
            id_alergi_alergen,
            kategori_alergen,
            nama_alergen,
            clinical_status,
            verification_status,
            id_praktisi,
            nama_praktisi,
            keterangan_alergi,
            author_id,
            author_name,
            datetime_creat
        ) VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW()
        )
    ");

    $stmt->bind_param(
        "siiissssissis",
        $id_alergi,
        $id_pasien,
        $id_kunjungan,
        $id_alergi_alergen,
        $kategori_alergen,
        $nama_alergen,
        $clinical_status,
        $verification_status,
        $id_praktisi,
        $nama_praktisi,
        $keterangan_alergi,
        $SessionIdAkses,
        $SessionNama
    );

    if (!$stmt->execute()) {
        throw new Exception($stmt->error);
    }

    $response = [
        'status' => 'success',
        'message' => 'Tambah alergi berhasil',
        'id_kunjungan' => $id_kunjungan
    ];

} catch (Exception $e) {

    $response = [
        'status' => 'error',
        'message' => $e->getMessage()
    ];
}

echo json_encode($response, JSON_PRETTY_PRINT);