<?php
    header('Content-Type: application/json');
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
        $email_gateway    = isset($_POST['email_gateway']) ? trim($_POST['email_gateway']) : '';
        $password_gateway = isset($_POST['password_gateway']) ? trim($_POST['password_gateway']) : '';
        $url_provider     = isset($_POST['url_provider']) ? trim($_POST['url_provider']) : '';
        $port_gateway     = isset($_POST['port_gateway']) ? trim($_POST['port_gateway']) : '';
        $nama_pengirim    = isset($_POST['nama_pengirim']) ? trim($_POST['nama_pengirim']) : '';
        $url_service      = isset($_POST['url_service']) ? trim($_POST['url_service']) : '';
        $status           = isset($_POST['status']) ? 1 : 0;

        // Validasi input
        if (
            empty($email_gateway) ||
            empty($password_gateway) ||
            empty($url_provider) ||
            empty($port_gateway) ||
            empty($nama_pengirim) ||
            empty($url_service)
        ) {
            $response["message"] = "Semua field wajib diisi.";
            echo json_encode($response);
            exit;
        }

        // Validasi email
        if (!filter_var($email_gateway, FILTER_VALIDATE_EMAIL)) {
            $response["message"] = "Format email tidak valid.";
            echo json_encode($response);
            exit;
        }

        if (!filter_var($url_service, FILTER_VALIDATE_URL)) {
            $response["message"] = "URL Service tidak valid.";
            echo json_encode($response);
            exit;
        }

        // Validasi port
        if (!is_numeric($port_gateway)) {
            $response["message"] = "Port Gateway harus berupa angka.";
            echo json_encode($response);
            exit;
        }

        // Jika status aktif, nonaktifkan data lain terlebih dahulu
        if ($status == 1) {
            mysqli_query($Conn, "UPDATE setting_email_gateway SET status='0'");
        }

        // Simpan data
        $query = "INSERT INTO setting_email_gateway (
                    email_gateway,
                    password_gateway,
                    url_provider,
                    port_gateway,
                    nama_pengirim,
                    url_service,
                    status
                ) VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($Conn, $query);

        mysqli_stmt_bind_param(
            $stmt,
            "sssissi",
            $email_gateway,
            $password_gateway,
            $url_provider,
            $port_gateway,
            $nama_pengirim,
            $url_service,
            $status
        );

        if (mysqli_stmt_execute($stmt)) {
            $response["status"] = "success";
            $response["message"] = "Data Email Gateway berhasil disimpan.";
        } else {
            $response["message"] = "Gagal menyimpan data.";
        }

        mysqli_stmt_close($stmt);

    } catch (Exception $e) {
        $response["message"] = "Error: " . $e->getMessage();
    }

    echo json_encode($response);
?>