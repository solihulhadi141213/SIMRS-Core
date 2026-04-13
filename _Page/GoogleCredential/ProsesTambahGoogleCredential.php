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

        // Ambil data dari form
        $credential_env = isset($_POST['credential_env']) ? trim($_POST['credential_env']) : '';
        $client_id      = isset($_POST['client_id']) ? trim($_POST['client_id']) : '';
        $client_secret  = isset($_POST['client_secret']) ? trim($_POST['client_secret']) : '';
        $status         = isset($_POST['status']) ? 1 : 0;

        // Validasi input
        if (
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

        // Jika status aktif, nonaktifkan data lain terlebih dahulu
        if ($status == 1) {
            mysqli_query($Conn, "UPDATE setting_google SET status='0'");
        }

        // Simpan data
        $query = "INSERT INTO setting_google (
            credential_env,
            client_id,
            client_secret,
            status
        ) VALUES (?, ?, ?, ?)";

        $stmt = mysqli_prepare($Conn, $query);
        if (!$stmt) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Prepare statement gagal: ' . mysqli_error($Conn)
            ]);
            exit;
        }

        mysqli_stmt_bind_param(
            $stmt,
            "sssi",
            $credential_env,
            $client_id,
            $client_secret,
            $status
        );

        if (mysqli_stmt_execute($stmt)) {
            $response["status"] = "success";
            $response["message"] = "Data Google Credential berhasil disimpan.";
        } else {
            $response["message"] = "Gagal menyimpan data.";
        }

        mysqli_stmt_close($stmt);

    } catch (Exception $e) {
        $response["message"] = "Error: " . $e->getMessage();
    }

    echo json_encode($response);
?>