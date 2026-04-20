<?php
    header('Content-Type: application/json');

    // Zona waktu
    date_default_timezone_set('Asia/Jakarta');

    // Koneksi & Session
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

    // Default response
    $response = [
        "status" => "error",
        "message" => "Terjadi kesalahan."
    ];

    // ===============================
    // VALIDASI SESSION
    // ===============================
    if (empty($SessionIdAkses)) {
        $response["message"] = "Sesi akses berakhir, silahkan login ulang.";
        echo json_encode($response);
        exit;
    }

    // ===============================
    // VALIDASI METHOD
    // ===============================
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $response["message"] = "Metode request tidak valid.";
        echo json_encode($response);
        exit;
    }

    // ===============================
    // AMBIL DATA
    // ===============================
    $id_setting_sirs_online   = isset($_POST['id_setting_sirs_online']) ? (int)$_POST['id_setting_sirs_online'] : 0;
    $nama_setting_sirs_online = isset($_POST['nama_setting_sirs_online']) ? trim($_POST['nama_setting_sirs_online']) : '';
    $url_sirs_online          = isset($_POST['url_sirs_online']) ? trim($_POST['url_sirs_online']) : '';
    $id_rs                    = isset($_POST['id_rs']) ? trim($_POST['id_rs']) : '';
    $password_sirs_online     = isset($_POST['password_sirs_online']) ? trim($_POST['password_sirs_online']) : '';
    $status                   = isset($_POST['status']) ? 1 : 0;

    // ===============================
    // VALIDASI WAJIB
    // ===============================
    if (empty($id_setting_sirs_online)) {
        $response["message"] = "ID tidak valid.";
        echo json_encode($response);
        exit;
    }

    if (empty($nama_setting_sirs_online)) {
        $response["message"] = "Profil pengaturan tidak boleh kosong.";
        echo json_encode($response);
        exit;
    }

    if (empty($url_sirs_online)) {
        $response["message"] = "URL tidak boleh kosong.";
        echo json_encode($response);
        exit;
    }

    if (!filter_var($url_sirs_online, FILTER_VALIDATE_URL)) {
        $response["message"] = "Format URL tidak valid.";
        echo json_encode($response);
        exit;
    }

    if (empty($id_rs)) {
        $response["message"] = "ID RS tidak boleh kosong.";
        echo json_encode($response);
        exit;
    }

    if (empty($password_sirs_online)) {
        $response["message"] = "Password tidak boleh kosong.";
        echo json_encode($response);
        exit;
    }

    // ===============================
    // CEK DATA EXIST
    // ===============================
    $stmtCheck = mysqli_prepare($Conn, "SELECT id_setting_sirs_online FROM setting_sirs_online WHERE id_setting_sirs_online=?");
    mysqli_stmt_bind_param($stmtCheck, "i", $id_setting_sirs_online);
    mysqli_stmt_execute($stmtCheck);
    $resultCheck = mysqli_stmt_get_result($stmtCheck);

    if (mysqli_num_rows($resultCheck) == 0) {
        $response["message"] = "Data tidak ditemukan.";
        echo json_encode($response);
        exit;
    }
    mysqli_stmt_close($stmtCheck);

    // ===============================
    // CEK DUPLIKASI NAMA (KECUALI DIRI SENDIRI)
    // ===============================
    $stmtDup = mysqli_prepare($Conn, "
        SELECT id_setting_sirs_online 
        FROM setting_sirs_online 
        WHERE nama_setting_sirs_online=? 
        AND id_setting_sirs_online != ?
    ");

    mysqli_stmt_bind_param($stmtDup, "si", $nama_setting_sirs_online, $id_setting_sirs_online);
    mysqli_stmt_execute($stmtDup);
    $resultDup = mysqli_stmt_get_result($stmtDup);

    if (mysqli_num_rows($resultDup) > 0) {
        $response["message"] = "Nama profil sudah digunakan.";
        echo json_encode($response);
        exit;
    }
    mysqli_stmt_close($stmtDup);

    // ===============================
    // OPTIONAL: JIKA STATUS AKTIF → NONAKTIFKAN YANG LAIN
    // ===============================
    if ($status == 1) {
        mysqli_query($Conn, "UPDATE setting_sirs_online SET status=0 WHERE id_setting_sirs_online != $id_setting_sirs_online");
    }

    // ===============================
    // UPDATE DATA (PREPARED)
    // ===============================
    $stmtUpdate = mysqli_prepare($Conn, "
        UPDATE setting_sirs_online SET
            nama_setting_sirs_online = ?,
            url_sirs_online          = ?,
            id_rs                    = ?,
            password_sirs_online     = ?,
            status                   = ?
        WHERE id_setting_sirs_online = ?
    ");

    if (!$stmtUpdate) {
        $response["message"] = "Gagal prepare statement.";
        echo json_encode($response);
        exit;
    }

    mysqli_stmt_bind_param(
        $stmtUpdate,
        "ssssii",
        $nama_setting_sirs_online,
        $url_sirs_online,
        $id_rs,
        $password_sirs_online,
        $status,
        $id_setting_sirs_online
    );

    $update = mysqli_stmt_execute($stmtUpdate);

    if ($update) {
        $response["status"]  = "success";
        $response["message"] = "Data berhasil diperbarui.";
    } else {
        $response["message"] = "Gagal update data.";
    }

    mysqli_stmt_close($stmtUpdate);

    // ===============================
    // OUTPUT
    // ===============================
    echo json_encode($response);
?>