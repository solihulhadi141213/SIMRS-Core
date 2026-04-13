<?php
    // Header JSON
    header('Content-Type: application/json');

    // Timezone
    date_default_timezone_set('Asia/Jakarta');

    // Connection
    include "../../_Config/Connection.php";

    // Function
    include "../../_Config/SimrsFunction.php";

    // Session
    include "../../_Config/Session.php";

    // =============================================
    // VALIDASI SESSION
    // =============================================
    if (empty($SessionIdAkses)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Sesi akses sudah berakhir, silakan login ulang.'
        ]);
        exit;
    }

    // =============================================
    // VALIDASI METHOD
    // =============================================
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode([
            'status' => 'error',
            'message' => 'Metode request tidak valid.'
        ]);
        exit;
    }

    try {

        // =============================================
        // AMBIL DATA POST
        // =============================================
        $id_setting_google = isset($_POST['id_setting_google']) ? (int) $_POST['id_setting_google'] : 0;
        $credential_env    = isset($_POST['credential_env']) ? trim($_POST['credential_env']) : '';
        $client_id         = isset($_POST['client_id']) ? trim($_POST['client_id']) : '';
        $client_secret     = isset($_POST['client_secret']) ? trim($_POST['client_secret']) : '';
        $status            = isset($_POST['status']) ? 1 : 0;

        // =============================================
        // VALIDASI MANDATORY
        // =============================================
        if (
            empty($id_setting_google) ||
            empty($credential_env) ||
            empty($client_id) ||
            empty($client_secret)
        ) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Semua field wajib diisi.'
            ]);
            exit;
        }

        // =============================================
        // VALIDASI ENUM ENVIRONMENT
        // =============================================
        $allowed_env = ['Production', 'Staging', 'Development'];

        if (!in_array($credential_env, $allowed_env)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Environment tidak valid.'
            ]);
            exit;
        }

        // =============================================
        // VALIDASI DATA EXIST
        // =============================================
        $check = mysqli_prepare($Conn, "SELECT id_setting_google FROM setting_google WHERE id_setting_google=?");
        mysqli_stmt_bind_param($check, "i", $id_setting_google);
        mysqli_stmt_execute($check);
        $result = mysqli_stmt_get_result($check);

        if (mysqli_num_rows($result) == 0) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Data Google Credential tidak ditemukan.'
            ]);
            exit;
        }

        // =============================================
        // TRANSACTION START
        // =============================================
        mysqli_begin_transaction($Conn);

        // =============================================
        // JIKA STATUS AKTIF → NONAKTIFKAN YANG LAIN
        // =============================================
        if ($status == 1) {
            $update_lain = mysqli_prepare(
                $Conn,
                "UPDATE setting_google 
                 SET status='0' 
                 WHERE id_setting_google != ?"
            );

            mysqli_stmt_bind_param($update_lain, "i", $id_setting_google);

            if (!mysqli_stmt_execute($update_lain)) {
                throw new Exception('Gagal menonaktifkan data lain.');
            }

            mysqli_stmt_close($update_lain);
        }

        // =============================================
        // UPDATE DATA
        // =============================================
        $query = "UPDATE setting_google SET
                    credential_env = ?,
                    client_id = ?,
                    client_secret = ?,
                    status = ?
                  WHERE id_setting_google = ?";

        $stmt = mysqli_prepare($Conn, $query);

        if (!$stmt) {
            throw new Exception('Prepare statement gagal.');
        }

        mysqli_stmt_bind_param(
            $stmt,
            "sssii",
            $credential_env,
            $client_id,
            $client_secret,
            $status,
            $id_setting_google
        );

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception('Gagal memperbarui data.');
        }

        mysqli_commit($Conn);

        echo json_encode([
            'status' => 'success',
            'message' => 'Google Credential berhasil diperbarui.'
        ]);

        mysqli_stmt_close($stmt);

    } catch (Exception $e) {

        mysqli_rollback($Conn);

        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
?>