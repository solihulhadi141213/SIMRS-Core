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
    // AMBIL INPUT
    // ===============================
    $nama_setting_sirs_online = isset($_POST['nama_setting_sirs_online']) ? trim($_POST['nama_setting_sirs_online']) : '';
    $url_sirs_online          = isset($_POST['url_sirs_online']) ? trim($_POST['url_sirs_online']) : '';
    $id_rs                    = isset($_POST['id_rs']) ? trim($_POST['id_rs']) : '';
    $password_sirs_online     = isset($_POST['password_sirs_online']) ? trim($_POST['password_sirs_online']) : '';
    $status                   = isset($_POST['status']) ? 1 : 0;

    // ===============================
    // VALIDASI WAJIB
    // ===============================
    if (empty($nama_setting_sirs_online)) {
        $response["message"] = "Profil pengaturan tidak boleh kosong.";
        echo json_encode($response); exit;
    }

    if (empty($url_sirs_online)) {
        $response["message"] = "URL SIRS Online tidak boleh kosong.";
        echo json_encode($response); exit;
    }

    if (!filter_var($url_sirs_online, FILTER_VALIDATE_URL)) {
        $response["message"] = "Format URL tidak valid.";
        echo json_encode($response); exit;
    }

    if (empty($id_rs)) {
        $response["message"] = "ID Rumah Sakit tidak boleh kosong.";
        echo json_encode($response); exit;
    }

    if (empty($password_sirs_online)) {
        $response["message"] = "Password tidak boleh kosong.";
        echo json_encode($response); exit;
    }

    // ===============================
    // CEK DUPLIKASI NAMA (PREPARED)
    // ===============================
    $stmtCek = mysqli_prepare($Conn, "
        SELECT id_setting_sirs_online 
        FROM setting_sirs_online 
        WHERE nama_setting_sirs_online = ?
    ");

    mysqli_stmt_bind_param($stmtCek, "s", $nama_setting_sirs_online);
    mysqli_stmt_execute($stmtCek);
    $resultCek = mysqli_stmt_get_result($stmtCek);

    if (mysqli_num_rows($resultCek) > 0) {
        $response["message"] = "Nama profil sudah digunakan.";
        echo json_encode($response);
        exit;
    }
    mysqli_stmt_close($stmtCek);

    // ===============================
    // JIKA STATUS AKTIF → NONAKTIFKAN YANG LAIN
    // ===============================
    if ($status == 1) {
        $updateNonAktif = mysqli_prepare($Conn, "UPDATE setting_sirs_online SET status = 0");
        mysqli_stmt_execute($updateNonAktif);
        mysqli_stmt_close($updateNonAktif);
    }

    // ===============================
    // INSERT DATA (PREPARED)
    // ===============================
    $stmtInsert = mysqli_prepare($Conn, "
        INSERT INTO setting_sirs_online 
        (nama_setting_sirs_online, url_sirs_online, id_rs, password_sirs_online, status)
        VALUES (?, ?, ?, ?, ?)
    ");

    if (!$stmtInsert) {
        $response["message"] = "Gagal prepare statement.";
        echo json_encode($response);
        exit;
    }

    mysqli_stmt_bind_param(
        $stmtInsert,
        "ssssi",
        $nama_setting_sirs_online,
        $url_sirs_online,
        $id_rs,
        $password_sirs_online,
        $status
    );

    $insert = mysqli_stmt_execute($stmtInsert);

    // ===============================
    // RESPONSE
    // ===============================
    if ($insert) {
        $response["status"]  = "success";
        $response["message"] = "Data berhasil disimpan.";
    } else {
        $response["message"] = "Gagal menyimpan data.";
    }

    mysqli_stmt_close($stmtInsert);

    echo json_encode($response);
?>