<?php
    // Header JSON
    header('Content-Type: application/json');

    // Timezone
    date_default_timezone_set('Asia/Jakarta');

    // Connection
    include "../../_Config/Connection.php";

    // Function & Session
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // Default response
    $response = [
        'status'  => 'error',
        'message' => 'Terjadi kesalahan.'
    ];

    // =============================================
    // VALIDASI SESSION
    // =============================================
    if (empty($SessionIdAkses)) {
        $response['message'] = 'Sesi akses sudah berakhir.';
        echo json_encode($response);
        exit;
    }

    // =============================================
    // VALIDASI METHOD
    // =============================================
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $response['message'] = 'Request tidak valid.';
        echo json_encode($response);
        exit;
    }

    try {

        // =============================================
        // AMBIL DATA
        // =============================================
        $id                 = intval($_POST['id_setting_bpjs'] ?? 0);
        $nama_setting_bpjs  = trim($_POST['nama_setting_bpjs'] ?? '');
        $consid             = trim($_POST['consid'] ?? '');
        $user_key           = trim($_POST['user_key'] ?? '');
        $user_key_antrol    = trim($_POST['user_key_antrol'] ?? '');
        $secret_key         = trim($_POST['secret_key'] ?? '');
        $kode_ppk           = trim($_POST['kode_ppk'] ?? '');

        $url_vclaim   = trim($_POST['url_vclaim'] ?? '');
        $url_aplicare = trim($_POST['url_aplicare'] ?? '');
        $url_antrol   = trim($_POST['url_antrol'] ?? '');
        $url_icare    = trim($_POST['url_icare'] ?? '');

        $status = isset($_POST['status']) ? 1 : 0;

        // =============================================
        // VALIDASI WAJIB
        // =============================================
        if (
            empty($id) ||
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
        // VALIDASI URL
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
        // CEK DATA ADA / TIDAK
        // =============================================
        $cek = $Conn->prepare("SELECT id_setting_bpjs FROM setting_bpjs WHERE id_setting_bpjs = ?");
        $cek->bind_param("i", $id);
        $cek->execute();
        $cek->store_result();

        if ($cek->num_rows == 0) {
            $response['message'] = 'Data tidak ditemukan.';
            echo json_encode($response);
            exit;
        }

        // =============================================
        // JIKA STATUS AKTIF → NONAKTIFKAN YANG LAIN
        // =============================================
        if ($status == 1) {
            $nonaktif = $Conn->prepare("UPDATE setting_bpjs SET status = 0 WHERE id_setting_bpjs != ?");
            $nonaktif->bind_param("i", $id);
            $nonaktif->execute();
        }

        // =============================================
        // UPDATE DATA
        // =============================================
        $stmt = $Conn->prepare("
            UPDATE setting_bpjs SET
                nama_setting_bpjs = ?,
                consid = ?,
                user_key = ?,
                user_key_antrol = ?,
                secret_key = ?,
                kode_ppk = ?,
                url_vclaim = ?,
                url_aplicare = ?,
                url_antrol = ?,
                url_icare = ?,
                status = ?
            WHERE id_setting_bpjs = ?
        ");

        if (!$stmt) {
            throw new Exception("Prepare gagal: " . $Conn->error);
        }

        $stmt->bind_param(
            "ssssssssssii",
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
            $status,
            $id
        );

        if (!$stmt->execute()) {
            throw new Exception("Update gagal: " . $stmt->error);
        }

        // =============================================
        // SUCCESS
        // =============================================
        $response['status']  = 'success';
        $response['message'] = 'Data berhasil diperbarui.';

        $stmt->close();

    } catch (Exception $e) {
        $response['message'] = $e->getMessage();
    }

    // OUTPUT JSON
    echo json_encode($response);
?>