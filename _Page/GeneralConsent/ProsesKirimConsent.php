<?php
    // CONNECTION, FUNCTION & SESSION
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // RESPONSE JSON
    header('Content-Type: application/json');

    // Updatetime
    $datetime_update = date('Y-m-d H:i:s');

    // VALIDASI SESSION
    if (empty($SessionIdAkses)) {
        echo json_encode([
            "status"  => "error",
            "message" => "Sesi akses berakhir!"
        ]);
        exit;
    }

    // VALIDASI INPUT
    if (empty($_POST['id_general_consent'])) {
        echo json_encode([
            "status"  => "error",
            "message" => "ID General Consent kosong!"
        ]);
        exit;
    }

    // SANITASI INPUT
    $id_general_consent = validateAndSanitizeInput($_POST['id_general_consent']);

    // JIKA ID CONSENT ADA
    if (!empty($_POST['id_consent'])) {
        $id_consent = validateAndSanitizeInput($_POST['id_consent']);

        // Update Ke Database
        $update = "UPDATE general_consent SET id_consent = ?, datetime_update = ? WHERE id_general_consent = ?";
        $stmtUpdate = $Conn->prepare($update);
        $stmtUpdate->bind_param(
            "ssi",
            $id_consent,
            $datetime_update,
            $id_general_consent
        );
        $success = $stmtUpdate->execute();

        // VALIDASI UPDATE
        if (!$success) {
            echo json_encode([
                "status"  => "error",
                "message" => "Terjadi Kesalahan Pada Saat Update ID Consent!"
            ]);
        }else{
            echo json_encode([
                "status"  => "success",
                "message" => "Consent Berhasil Disimpan"
            ]);
        }
        exit;
    }

    // AMBIL KONFIGURASI SATUSEHAT
    $status_setting = 1;
    $sql = "SELECT * FROM setting_satusehat WHERE status_setting_satusehat = ? LIMIT 1";
    $stmt = $Conn->prepare($sql);
    $stmt->bind_param("i", $status_setting);
    $stmt->execute();
    $Data = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    // VALIDASI
    if (empty($Data)) {
        echo json_encode([
            "status"  => "error",
            "message" => "Konfigurasi SATUSEHAT tidak ditemukan!"
        ]);
        exit;
    }

    /// MAPPING CONFIG
    $url_satusehat    = rtrim($Data['url_satusehat'] ?? '', '/');
    $token            = $Data['token'] ?? '';
    $organization_id  = $Data['organization_id'] ?? '';
    $datetime_expired = $Data['datetime_expired'] ?? '';

    // GENERATE TOKEN BARU JIKA EXPIRED
    if (empty($token) || strtotime($datetime_expired) <= time()) {
        $tokenResult = generateTokenSatuSehat($Conn);
        if (($tokenResult['status'] ?? '') !== 'success') {
            echo json_encode([
                "status"  => "error",
                "message" => "Terjadi kesalahan saat generate token SATUSEHAT!"
            ]);
            exit;
        }
        $token = $tokenResult['token'] ?? '';
    }

    // VALIDASI TOKEN
    if (empty($token)) {
        echo json_encode([
            "status"  => "error",
            "message" => "Token SATUSEHAT tidak tersedia!"
        ]);
        exit;
    }

    // QUERY GENERAL CONSENT
    $query = "
        SELECT 
            gc.*,

            k.id_encounter,

            p.nama AS nama_pasien,
            p.id_ihs AS patient_ihs

        FROM general_consent gc

        LEFT JOIN kunjungan k 
            ON gc.id_kunjungan = k.id_kunjungan

        LEFT JOIN pasien p 
            ON gc.id_pasien = p.id_pasien

        WHERE gc.id_general_consent = ?
        LIMIT 1
    ";

    $stmt = $Conn->prepare($query);
    $stmt->bind_param("i", $id_general_consent);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    // VALIDASI DATA
    if (empty($data)) {

        echo json_encode([
            "status"  => "error",
            "message" => "Data General Consent tidak ditemukan!"
        ]);
        exit;
    }

    // VALIDASI SUDAH TERKIRIM
    if (!empty($data['id_consent'])) {

        echo json_encode([
            "status"  => "error",
            "message" => "Consent sudah pernah dikirim sebelumnya!"
        ]);
        exit;
    }

    // VALIDASI IHS PASIEN
    if (empty($data['patient_ihs'])) {

        echo json_encode([
            "status"  => "error",
            "message" => "IHS Pasien tidak tersedia!"
        ]);
        exit;
    }

    // MAPPING DATA
    $patient_ihs        = $data['patient_ihs'];
    $penandatangan_nama = $data['penandatangan_nama'] ?? '';
    $policy_rule        = $data['policy_rule'] ?? 'opt-in';

    if($policy_rule=="opt-in"){
        $policy_rule = "OPTIN";
    }else{
        $policy_rule = "OPTOUT";
    }

    // BUILD PAYLOAD SEDERHANA
    $KirimData = array(
        "patient_id" => $patient_ihs,
        "agent"      => $penandatangan_nama,
        "action"     => $policy_rule
    );

    // ENCODE JSON
    $JsonEncode = json_encode($KirimData, JSON_PRETTY_PRINT);

    // KIRIM KE SATUSEHAT
    $response = UpdateConsent($url_satusehat,$JsonEncode,$token);

    // VALIDASI RESPONSE
    if (empty($response)) {
        echo json_encode([
            "status"  => "error",
            "message" => "Tidak ada response dari SATUSEHAT"
        ]);
        exit;
    }

    // DECODE RESPONSE
    $result = json_decode($response, true);

    // TANGKAP ID
    if(empty($result['id'])){
        echo json_encode([
            "status"  => "error",
            "message" => "Consent Gagal Dikirim",
            "text" => "$response",
        ]);
        exit;
    }
    $id_consent = $result['id'];

    // Update Ke Database
    $update = "UPDATE general_consent SET id_consent = ?, datetime_update = ? WHERE id_general_consent = ?";
    $stmtUpdate = $Conn->prepare($update);
    $stmtUpdate->bind_param(
        "ssi",
        $id_consent,
        $datetime_update,
        $id_general_consent
    );
    $success = $stmtUpdate->execute();

    // VALIDASI UPDATE
    if (!$success) {
        echo json_encode([
            "status"  => "error",
            "message" => "Terjadi Kesalahan Pada Saat Update ID Consent!"
        ]);
    }else{
        echo json_encode([
            "status"  => "success",
            "message" => "Consent Berhasil Disimpan"
        ]);
    }
    exit;
?>