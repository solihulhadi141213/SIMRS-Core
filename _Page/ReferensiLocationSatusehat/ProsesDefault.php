<?php
    header('Content-Type: application/json; charset=utf-8');

    // Load koneksi, helper SATUSEHAT, dan sesi pengguna.
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // Kirim response JSON dengan HTTP status yang sesuai.
    $sendResponse = static function ($status, $message, $data = [], $httpStatus = 200) {
        http_response_code($httpStatus);
        echo json_encode(
            array_merge([
                'status' => $status,
                'message' => $message
            ], $data),
            JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );
        exit;
    };

    // Pastikan pengguna memiliki sesi aktif.
    if (empty($SessionIdAkses)) {
        $sendResponse('error', 'Sesi akses sudah berakhir. Silakan login ulang.', [], 401);
    }

    // Hanya terima request POST.
    if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
        $sendResponse('error', 'Metode request tidak valid.', [], 405);
    }

    // Ambil dan validasi ID Location dari request.
    $idLocationInput = $_POST['id_location'] ?? '';
    if (!is_scalar($idLocationInput)) {
        $sendResponse('error', 'ID Location tidak valid.', [], 400);
    }
    $idLocation = trim((string)$idLocationInput);
    if (!preg_match('/^[A-Za-z0-9.-]{1,64}$/', $idLocation)) {
        $sendResponse('error', 'ID Location tidak valid.', [], 400);
    }

    // Verifikasi bahwa terdapat setting_satusehat yang aktif (status_setting_satusehat = 1).
    $stmtCheck = $Conn->prepare(
        "SELECT id_setting_satusehat, default_location_id
         FROM setting_satusehat
         WHERE status_setting_satusehat = 1
         LIMIT 1"
    );
    if (!$stmtCheck) {
        $sendResponse('error', 'Gapai database gagal: ' . htmlspecialchars($Conn->error, ENT_QUOTES, 'UTF-8'), [], 500);
    }
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();
    $dataSetting = $resultCheck->fetch_assoc();
    $stmtCheck->close();

    if (!$dataSetting) {
        $sendResponse('error', 'Tidak ditemukan setting_satusehat yang aktif (status_setting_satusehat = 1).', [], 404);
    }

    $idSettingSatusehat = $dataSetting['id_setting_satusehat'];
    $existingDefault = $dataSetting['default_location_id'] ?? null;

    // Update default_location_id pada setting_satusehat yang aktif.
    $stmtUpdate = $Conn->prepare(
        "UPDATE setting_satusehat
         SET default_location_id = ?
         WHERE id_setting_satusehat = ?"
    );
    if (!$stmtUpdate) {
        $sendResponse('error', 'Gagal persiapan query update: ' . htmlspecialchars($Conn->error, ENT_QUOTES, 'UTF-8'), [], 500);
    }
    $stmtUpdate->bind_param("si", $idLocation, $idSettingSatusehat);
    if (!$stmtUpdate->execute()) {
        $stmtUpdate->close();
        $sendResponse('error', 'Gagal menyimpan default location: ' . htmlspecialchars($stmtUpdate->error, ENT_QUOTES, 'UTF-8'), [], 500);
    }
    $stmtUpdate->close();

    // Simpan log aktivitas ubah default location referensi
    SaveLog(
        $Conn,
        $SessionIdAkses,
        $SessionNama,
        'Ubah Default Location Referensi',
        'Referensi Location',
        [
            'id_location' => $idLocation,
            'id_setting_satusehat' => $idSettingSatusehat,
            'previous_default' => $existingDefault
        ]
    );

    $sendResponse(
        'success',
        'Default location berhasil diperbarui.',
        [
            'id_location' => $idLocation,
            'id_setting_satusehat' => $idSettingSatusehat,
            'previous_default' => $existingDefault
        ]
    );
?>
