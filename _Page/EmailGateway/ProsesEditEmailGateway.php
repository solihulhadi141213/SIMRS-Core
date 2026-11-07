<?php
    header('Content-Type: application/json');
    date_default_timezone_set('Asia/Jakarta');

    // Connection
    include "../../_Config/Connection.php";

    // Simrs Function
    include "../../_Config/SimrsFunction.php";

    // Session
    include "../../_Config/Session.php";

    // =====================================
    // VALIDASI SESSION
    // =====================================
    if (empty($SessionIdAkses)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Sesi akses sudah berakhir, silakan login ulang.'
        ]);
        exit;
    }

    // =====================================
    // VALIDASI METHOD
    // =====================================
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode([
            'status' => 'error',
            'message' => 'Metode request tidak valid.'
        ]);
        exit;
    }

    // =====================================
    // VALIDASI ID
    // =====================================
    $id_setting_email_gateway = (int) ($_POST['id_setting_email_gateway'] ?? 0);

    if (empty($id_setting_email_gateway)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'ID Email Gateway tidak boleh kosong.'
        ]);
        exit;
    }

    // =====================================
    // AMBIL DATA FORM
    // =====================================
    $email_gateway    = isset($_POST['email_gateway']) ? trim($_POST['email_gateway']) : '';
    $password_gateway = isset($_POST['password_gateway']) ? trim($_POST['password_gateway']) : '';
    $url_provider     = isset($_POST['url_provider']) ? trim($_POST['url_provider']) : '';
    $port_gateway     = isset($_POST['port_gateway']) ? trim($_POST['port_gateway']) : '';
    $nama_pengirim    = isset($_POST['nama_pengirim']) ? trim($_POST['nama_pengirim']) : '';
    $url_service      = isset($_POST['url_service']) ? trim($_POST['url_service']) : '';
    $status           = isset($_POST['status']) ? 1 : 0;

    // =====================================
    // VALIDASI FIELD WAJIB
    // =====================================
    $mandatory = [
        $email_gateway,
        $password_gateway,
        $url_provider,
        $port_gateway,
        $nama_pengirim,
        $url_service
    ];

    foreach ($mandatory as $item) {
        if (empty($item)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Masih ada field wajib yang kosong.'
            ]);
            exit;
        }
    }

    // =====================================
    // VALIDASI FORMAT
    // =====================================
    if (!filter_var($email_gateway, FILTER_VALIDATE_EMAIL)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Format email tidak valid.'
        ]);
        exit;
    }

    if (!filter_var($url_service, FILTER_VALIDATE_URL)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'URL Service tidak valid.'
        ]);
        exit;
    }

    if (!is_numeric($port_gateway)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Port Gateway harus berupa angka.'
        ]);
        exit;
    }

    // =====================================
    // CEK DATA ADA
    // =====================================
    // Prepared Statement: verify that the Email Gateway record exists.
    $stmtCheck = mysqli_prepare(
        $Conn,
        "SELECT id_setting_email_gateway 
        FROM setting_email_gateway 
        WHERE id_setting_email_gateway=?"
    );
    mysqli_stmt_bind_param($stmtCheck, 'i', $id_setting_email_gateway);
    mysqli_stmt_execute($stmtCheck);
    $cek = mysqli_stmt_get_result($stmtCheck);

    if (mysqli_num_rows($cek) == 0) {
        mysqli_stmt_close($stmtCheck);
        echo json_encode([
            'status' => 'error',
            'message' => 'Data Email Gateway tidak ditemukan.'
        ]);
        exit;
    }
    mysqli_stmt_close($stmtCheck);

    // =====================================
    // JIKA STATUS AKTIF -> NONAKTIFKAN YANG LAIN
    // =====================================
    if ($status == 1) {
        // Prepared Statement: deactivate every other Email Gateway record.
        $stmtDeactivate = mysqli_prepare(
            $Conn,
            "UPDATE setting_email_gateway SET status='0' WHERE id_setting_email_gateway != ?"
        );
        mysqli_stmt_bind_param($stmtDeactivate, 'i', $id_setting_email_gateway);
        mysqli_stmt_execute($stmtDeactivate);
        mysqli_stmt_close($stmtDeactivate);
    }

    // =====================================
    // UPDATE DATA
    // =====================================
    $query = "UPDATE setting_email_gateway SET
                email_gateway=?,
                password_gateway=?,
                url_provider=?,
                port_gateway=?,
                nama_pengirim=?,
                url_service=?,
                status=?
            WHERE id_setting_email_gateway=?";

    // Prepared Statement: update the Email Gateway record.
    $stmt = mysqli_prepare($Conn, $query);

    mysqli_stmt_bind_param(
        $stmt,
        "sssissii",
        $email_gateway,
        $password_gateway,
        $url_provider,
        $port_gateway,
        $nama_pengirim,
        $url_service,
        $status,
        $id_setting_email_gateway
    );

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Data Email Gateway berhasil diperbarui.'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal memperbarui data.'
        ]);
    }

    mysqli_stmt_close($stmt);
?>