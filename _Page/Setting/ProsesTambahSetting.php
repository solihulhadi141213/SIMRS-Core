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

    // =============================================
    // AMBIL DATA POST
    // =============================================
    $setting_name           = trim($_POST['setting_name'] ?? '');
    $aplication_name        = trim($_POST['aplication_name'] ?? '');
    $aplication_description = trim($_POST['aplication_description'] ?? '');
    $aplication_keyword     = trim($_POST['aplication_keyword'] ?? '');
    $aplication_author      = trim($_POST['aplication_author'] ?? '');
    $base_url               = trim($_POST['base_url'] ?? '');
    $hospital_name          = trim($_POST['hospital_name'] ?? '');
    $hospital_address       = trim($_POST['hospital_address'] ?? '');
    $hospital_contact       = trim($_POST['hospital_contact'] ?? '');
    $hospital_email         = trim($_POST['hospital_email'] ?? '');
    $hospital_code          = trim($_POST['hospital_code'] ?? '');
    $hospital_manager       = trim($_POST['hospital_manager'] ?? '');
    $status                 = isset($_POST['aktivasi_setting']) ? 1 : 0;

    // =============================================
    // VALIDASI FIELD WAJIB
    // =============================================
    $mandatory = [
        $setting_name,
        $aplication_name,
        $aplication_description,
        $aplication_keyword,
        $aplication_author,
        $base_url,
        $hospital_name,
        $hospital_address,
        $hospital_contact,
        $hospital_email
    ];

    foreach ($mandatory as $item) {
        if (empty($item)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Masih ada data wajib yang belum diisi.'
            ]);
            exit;
        }
    }

    // =============================================
    // VALIDASI PANJANG KARAKTER
    // =============================================
    if (
        strlen($setting_name) > 250 ||
        strlen($aplication_name) > 250 ||
        strlen($aplication_author) > 250 ||
        strlen($base_url) > 250 ||
        strlen($hospital_name) > 250 ||
        strlen($hospital_address) > 250 ||
        strlen($hospital_contact) > 250 ||
        strlen($hospital_email) > 250 ||
        strlen($hospital_code) > 250 ||
        strlen($hospital_manager) > 250
    ) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Ada data yang melebihi batas karakter.'
        ]);
        exit;
    }

    if (strlen($aplication_description) > 500) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Deskripsi maksimal 500 karakter.'
        ]);
        exit;
    }

    // =============================================
    // PROSES KEYWORD
    // =============================================
    $keywordArray = array_map('trim', explode(',', $aplication_keyword));

    // hapus keyword kosong
    $keywordArray = array_filter($keywordArray);

    // maksimal 5 keyword
    if (count($keywordArray) > 5) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Keyword maksimal 5 kata kunci.'
        ]);
        exit;
    }

    $keywordJson = json_encode(array_values($keywordArray));

    // =============================================
    // VALIDASI FILE
    // =============================================
    if (!isset($_FILES['favicon']) || !isset($_FILES['logo'])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'File favicon dan logo wajib diupload.'
        ]);
        exit;
    }

    $allowedExt = ['ico', 'png', 'jpg', 'jpeg', 'gif'];
    $maxSize = 1024 * 1024; // 1MB

    function uploadFileCustom($file, $folder, $allowedExt, $maxSize)
    {
        if ($file['error'] !== 0) {
            return false;
        }

        if ($file['size'] > $maxSize) {
            return false;
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowedExt)) {
            return false;
        }

        $newName = bin2hex(random_bytes(16)) . '.' . $ext;

        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        $destination = $folder . '/' . $newName;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return $newName;
        }

        return false;
    }

    // Menentukan Directory
    $uploadDir   = "../../assets/images";
    $faviconName = uploadFileCustom($_FILES['favicon'], $uploadDir, $allowedExt, $maxSize);
    $logoName    = uploadFileCustom($_FILES['logo'], $uploadDir, $allowedExt, $maxSize);

    if (!$faviconName || !$logoName) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Upload file gagal. Periksa format dan ukuran file.'
        ]);
        exit;
    }

    // =============================================
    // JIKA AKTIF, NONAKTIFKAN YANG LAIN
    // =============================================
    if ($status == 1) {
        mysqli_query($Conn, "UPDATE setting SET status='0'");
    }

    // =============================================
    // INSERT DATABASE
    // =============================================
    $stmt = mysqli_prepare($Conn, "
        INSERT INTO setting (
            setting_name,
            aplication_name,
            aplication_description,
            aplication_keyword,
            aplication_author,
            base_url,
            hospital_name,
            hospital_address,
            hospital_contact,
            hospital_email,
            hospital_code,
            hospital_manager,
            favicon,
            logo,
            status
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    mysqli_stmt_bind_param(
        $stmt,
        "ssssssssssssssi",
        $setting_name,
        $aplication_name,
        $aplication_description,
        $keywordJson,
        $aplication_author,
        $base_url,
        $hospital_name,
        $hospital_address,
        $hospital_contact,
        $hospital_email,
        $hospital_code,
        $hospital_manager,
        $faviconName,
        $logoName,
        $status
    );

    $execute = mysqli_stmt_execute($stmt);

    if ($execute) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Tambah pengaturan berhasil.'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal menyimpan data.'
        ]);
    }
?>