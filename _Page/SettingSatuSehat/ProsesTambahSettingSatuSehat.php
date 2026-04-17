<?php
    // Header Format
    header('Content-Type: application/json');

    // Time Zone
    date_default_timezone_set('Asia/Jakarta');

    // Connection
    include "../../_Config/Connection.php";

    // Simrs Function
    include "../../_Config/SimrsFunction.php";

    // Session
    include "../../_Config/Session.php";

    // Default response
    $response = [
        'status' => 'error',
        'message' => 'Terjadi kesalahan.'
    ];

    // =============================================
    // VALIDASI SESSION
    // =============================================
    if (empty($SessionIdAkses)) {
        $response['message'] = 'Sesi akses sudah berakhir, silakan login ulang.';
        echo json_encode($response);
        exit;
    }

    // =============================================
    // VALIDASI METHOD
    // =============================================
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $response['message'] = 'Metode request tidak valid.';
        echo json_encode($response);
        exit;
    }

    try {

        // =============================================
        // AMBIL & VALIDASI INPUT
        // =============================================
        $nama_setting_satusehat = trim($_POST['nama_setting_satusehat'] ?? '');
        $url_satusehat          = trim($_POST['url_satusehat'] ?? '');
        $organization_id        = trim($_POST['organization_id'] ?? '');
        $client_key             = trim($_POST['client_key'] ?? '');
        $secret_key             = trim($_POST['secret_key'] ?? '');
        $status                 = isset($_POST['status']) ? 1 : 0;

        if (
            empty($nama_setting_satusehat) ||
            empty($url_satusehat) ||
            empty($organization_id) ||
            empty($client_key) ||
            empty($secret_key)
        ) {
            $response['message'] = 'Semua field wajib diisi.';
            echo json_encode($response);
            exit;
        }

        // =============================================
        // CEK DUPLIKAT NAMA (OPSIONAL TAPI DISARANKAN)
        // =============================================
        $stmtCheck = $Conn->prepare("SELECT id_setting_satusehat FROM setting_satusehat WHERE nama_setting_satusehat = ?");
        $stmtCheck->bind_param("s", $nama_setting_satusehat);
        $stmtCheck->execute();
        $stmtCheck->store_result();

        if ($stmtCheck->num_rows > 0) {
            $response['message'] = 'Nama profil sudah digunakan.';
            echo json_encode($response);
            exit;
        }
        $stmtCheck->close();

        // =============================================
        // JIKA STATUS AKTIF, NONAKTIFKAN YANG LAIN
        // =============================================
        if ($status == 1) {
            $nonaktifkan = $Conn->prepare("
                UPDATE setting_satusehat 
                SET status_setting_satusehat = 0
            ");
            $nonaktifkan->execute();
            $nonaktifkan->close();
        }

        // =============================================
        // INSERT DATA
        // =============================================
        $token = NULL;
        $datetime_expired = date('Y-m-d H:i:s');

        $stmt = $Conn->prepare("
            INSERT INTO setting_satusehat (
                nama_setting_satusehat,
                url_satusehat,
                organization_id,
                client_key,
                secret_key,
                token,
                datetime_expired,
                status_setting_satusehat
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "sssssssi",
            $nama_setting_satusehat,
            $url_satusehat,
            $organization_id,
            $client_key,
            $secret_key,
            $token,
            $datetime_expired,
            $status
        );

        if ($stmt->execute()) {

            $response['status']  = 'success';
            $response['message'] = 'Data berhasil disimpan.';

        } else {
            $response['message'] = 'Gagal menyimpan data.';
        }

        $stmt->close();

    } catch (Exception $e) {
        $response['message'] = "Error: " . $e->getMessage();
    }

    // =============================================
    // OUTPUT JSON
    // =============================================
    echo json_encode($response);
?>