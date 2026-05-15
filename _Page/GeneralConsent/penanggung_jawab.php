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
            'success' => false,
            'message' => 'Sesi akses sudah berakhir! Silahkan login ulang.'
        ]);
        exit;
    }

    // =========================================================
    // VALIDASI INPUT
    // =========================================================
    if (
        empty($_POST['id_pasien']) ||
        empty($_POST['penandatangan_tipe'])
    ) {
        echo json_encode([
            'success' => false,
            'message' => 'Data yang dikirim tidak lengkap.'
        ]);
        exit;
    }

    // =========================================================
    // SANITASI INPUT
    // =========================================================
    $id_pasien           = validateAndSanitizeInput($_POST['id_pasien']);
    $penandatangan_tipe  = validateAndSanitizeInput($_POST['penandatangan_tipe']);

    // =========================================================
    // DEFAULT RESPONSE
    // =========================================================
    $response = [
        'success' => true,
        'penandatangan_nama' => '',
        'penandatangan_nik'  => ''
    ];

    // =========================================================
    // JIKA PASIEN SEBAGAI PENANGGUNG JAWAB
    // =========================================================
    if ($penandatangan_tipe == "Pasien") {

        $sql = "
            SELECT 
                nama,
                nik
            FROM pasien
            WHERE id_pasien = ?
            LIMIT 1
        ";

        $stmt = $Conn->prepare($sql);
        $stmt->bind_param("i", $id_pasien);
        $stmt->execute();

        $result = $stmt->get_result();
        $Data   = $result->fetch_assoc();

        // JIKA DATA PASIEN TIDAK DITEMUKAN
        if (empty($Data)) {

            echo json_encode([
                'success' => false,
                'message' => 'Data pasien tidak ditemukan.'
            ]);
            exit;
        }

        // RESPONSE
        $response['penandatangan_nama'] = $Data['nama'] ?? '';
        $response['penandatangan_nik']  = $Data['nik'] ?? '';

        // CLOSE
        $stmt->close();
    }

    // =========================================================
    // OUTPUT JSON
    // =========================================================
    echo json_encode($response);
?>