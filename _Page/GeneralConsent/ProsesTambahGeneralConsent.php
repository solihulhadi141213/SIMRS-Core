<?php
    // =========================================================
    // CONNECTION, FUNCTION & SESSION
    // =========================================================
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // =========================================================
    // HEADER JSON
    // =========================================================
    header('Content-Type: application/json');

    // =========================================================
    // VALIDASI SESSION
    // =========================================================
    if (empty($SessionIdAkses)) {

        echo json_encode([
            'status' => 'error',
            'message' => 'Sesi akses sudah berakhir! Silahkan login ulang.'
        ]);

        exit;
    }

    // =========================================================
    // VALIDASI INPUT WAJIB
    // =========================================================
    $required = [
        'id_kunjungan',
        'id_pasien',
        'metode_consent',
        'policy_rule',
        'petugas_edukasi_id',
        'petugas_edukasi_nama',
        'penandatangan_tipe',
        'penandatangan_nama'
    ];

    foreach ($required as $field) {

        if (empty($_POST[$field])) {

            echo json_encode([
                'status' => 'error',
                'message' => 'Field '.$field.' tidak boleh kosong.'
            ]);

            exit;
        }
    }

    // =========================================================
    // SANITASI INPUT
    // =========================================================
    $id_kunjungan            = validateAndSanitizeInput($_POST['id_kunjungan']);
    $id_pasien               = validateAndSanitizeInput($_POST['id_pasien']);

    $metode_consent          = validateAndSanitizeInput($_POST['metode_consent']);

    $policy_rule             = validateAndSanitizeInput($_POST['policy_rule']);

    $petugas_edukasi_id      = validateAndSanitizeInput($_POST['petugas_edukasi_id']);
    $petugas_edukasi_nama    = validateAndSanitizeInput($_POST['petugas_edukasi_nama']);
    $petugas_edukasi_nik     = validateAndSanitizeInput($_POST['petugas_edukasi_nik'] ?? '');

    $penandatangan_tipe      = validateAndSanitizeInput($_POST['penandatangan_tipe']);
    $penandatangan_nama      = validateAndSanitizeInput($_POST['penandatangan_nama']);
    $penandatangan_nik       = validateAndSanitizeInput($_POST['penandatangan_nik'] ?? '');

    $penandatangan_ttd       = $_POST['penandatangan_ttd'] ?? '';
    $petugas_edukasi_ttd     = $_POST['petugas_edukasi_ttd'] ?? '';

    // =========================================================
    // PERNYATAAN PASIEN
    // =========================================================
    $pernyataan_pasien = [];

    if (!empty($_POST['pernyataan_pasien'])) {

        $pernyataan_pasien = $_POST['pernyataan_pasien'];

    }

    // Convert JSON
    $pernyataan_pasien_json = json_encode(
        $pernyataan_pasien,
        JSON_UNESCAPED_UNICODE
    );

    // =========================================================
    // DATETIME
    // =========================================================
    $datetime_now = date('Y-m-d H:i:s');

    // =========================================================
    // STATUS
    // =========================================================
    $status = 1;

    // =========================================================
    // ID CONSENT (SATUSEHAT)
    // =========================================================
    $id_consent = '';

    // =========================================================
    // INSERT DATA
    // =========================================================
    $sql = "
        INSERT INTO general_consent (
            id_consent,
            id_kunjungan,
            id_pasien,
            metode_consent,

            petugas_edukasi_id,
            petugas_edukasi_nama,
            petugas_edukasi_nik,
            petugas_edukasi_ttd,

            penandatangan_tipe,
            penandatangan_nama,
            penandatangan_nik,
            penandatangan_ttd,

            policy_rule,
            pernyataan_pasien,

            status,
            datetime_creat,
            datetime_update

        ) VALUES (

            ?, ?, ?, ?,

            ?, ?, ?, ?,

            ?, ?, ?, ?,

            ?, ?,

            ?, ?, ?
        )
    ";

    $stmt = $Conn->prepare($sql);

    if (!$stmt) {

        echo json_encode([
            'status' => 'error',
            'message' => 'Prepare statement gagal.'
        ]);

        exit;
    }

    $stmt->bind_param(

        "sississsssssssiss",

        $id_consent,
        $id_kunjungan,
        $id_pasien,
        $metode_consent,

        $petugas_edukasi_id,
        $petugas_edukasi_nama,
        $petugas_edukasi_nik,
        $petugas_edukasi_ttd,

        $penandatangan_tipe,
        $penandatangan_nama,
        $penandatangan_nik,
        $penandatangan_ttd,

        $policy_rule,
        $pernyataan_pasien_json,

        $status,
        $datetime_now,
        $datetime_now
    );

    // =========================================================
    // EXECUTE
    // =========================================================
    if ($stmt->execute()) {

        // Ambil ID Insert
        $id_general_consent = $stmt->insert_id;

        echo json_encode([
            'status' => 'success',
            'message' => 'General Consent berhasil dibuat.',
            'id_general_consent' => $id_general_consent
        ]);

    } else {

        echo json_encode([
            'status' => 'error',
            'message' => 'Terjadi kesalahan saat menyimpan data.'
        ]);
    }

    // =========================================================
    // CLOSE
    // =========================================================
    $stmt->close();
?>