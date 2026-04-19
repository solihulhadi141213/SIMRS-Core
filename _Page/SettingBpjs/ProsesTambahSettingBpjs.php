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
        // AMBIL & SANITASI DATA
        // =============================================
        $nama_setting_bpjs = trim($_POST['nama_setting_bpjs'] ?? '');
        $consid            = trim($_POST['consid'] ?? '');
        $user_key          = trim($_POST['user_key'] ?? '');
        $user_key_antrol   = trim($_POST['user_key_antrol'] ?? '');
        $secret_key        = trim($_POST['secret_key'] ?? '');
        $kode_ppk          = trim($_POST['kode_ppk'] ?? '');

        $url_vclaim   = trim($_POST['url_vclaim'] ?? '');
        $url_aplicare = trim($_POST['url_aplicare'] ?? '');
        $url_antrol   = trim($_POST['url_antrol'] ?? '');
        $url_icare    = trim($_POST['url_icare'] ?? '');

        // checkbox (kalau tidak dikirim berarti 0)
        $status = isset($_POST['status']) ? 1 : 0;

        // =============================================
        // VALIDASI WAJIB
        // =============================================
        if (
            empty($nama_setting_bpjs) ||
            empty($consid) ||
            empty($user_key) ||
            empty($user_key_antrol) ||
            empty($secret_key) ||
            empty($kode_ppk)
        ) {
            $response['message'] = 'Semua field wajib harus diisi.';
            echo json_encode($response);
            exit;
        }

        // =============================================
        // VALIDASI URL (optional tapi kalau diisi harus valid)
        // =============================================
        $url_fields = [
            'URL Vclaim'   => $url_vclaim,
            'URL Aplicare' => $url_aplicare,
            'URL Antrol'   => $url_antrol,
            'URL iCare'    => $url_icare
        ];

        foreach ($url_fields as $label => $url) {
            if (!empty($url) && !filter_var($url, FILTER_VALIDATE_URL)) {
                $response['message'] = "$label tidak valid.";
                echo json_encode($response);
                exit;
            }
        }

        // =============================================
        // JIKA STATUS = 1 → NONAKTIFKAN YANG LAIN
        // =============================================
        if ($status == 1) {
            $Conn->query("UPDATE setting_bpjs SET status = 0");
        }

        // =============================================
        // INSERT DATA (PREPARED STATEMENT)
        // =============================================
        $stmt = $Conn->prepare("
            INSERT INTO setting_bpjs (
                nama_setting_bpjs,
                consid,
                user_key,
                user_key_antrol,
                secret_key,
                kode_ppk,
                url_vclaim,
                url_aplicare,
                url_antrol,
                url_icare,
                status
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        if (!$stmt) {
            throw new Exception("Prepare gagal: " . $Conn->error);
        }

        $stmt->bind_param(
            "ssssssssssi",
            $nama_setting_bpjs,
            $consid,
            $user_key,
            $user_key_antrol,
            $secret_key,
            $kode_ppk,
            $url_vclaim,
            $url_aplicare,
            $url_antrol,
            $url_icare,
            $status
        );

        if (!$stmt->execute()) {
            throw new Exception("Execute gagal: " . $stmt->error);
        }

        // =============================================
        // SUCCESS
        // =============================================
        $response['status']  = 'success';
        $response['message'] = 'Data setting BPJS berhasil ditambahkan.';

        $stmt->close();

    } catch (Exception $e) {
        $response['message'] = $e->getMessage();
    }

    // =============================================
    // OUTPUT JSON
    // =============================================
    echo json_encode($response);
?>