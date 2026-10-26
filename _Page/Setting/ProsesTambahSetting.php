<?php
    header('Content-Type: application/json');
    date_default_timezone_set('Asia/Jakarta');

    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

    $respond = static function (string $status, string $message): void {
        echo json_encode(['status' => $status, 'message' => $message]);
        exit;
    };

    if (empty($SessionIdAkses)) {
        $respond('error', 'Sesi akses sudah berakhir, silakan login ulang.');
    }
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $respond('error', 'Metode request tidak valid.');
    }

    $setting_name = trim($_POST['setting_name'] ?? '');
    $base_url = trim($_POST['base_url'] ?? '');
    $hospital_name = trim($_POST['hospital_name'] ?? '');
    $hospital_address = trim($_POST['hospital_address'] ?? '');
    $hospital_contact = trim($_POST['hospital_contact'] ?? '');
    $hospital_email = trim($_POST['hospital_email'] ?? '');
    $hospital_code = trim($_POST['hospital_code'] ?? '');
    $hospital_manager = trim($_POST['hospital_manager'] ?? '');
    $status = isset($_POST['aktivasi_setting']) ? 1 : 0;
    $environments = ['Development', 'Staging', 'Production'];

    if (!in_array($setting_name, $environments, true)) {
        $respond('error', 'Lingkungan pengaturan tidak valid.');
    }
    foreach ([$base_url, $hospital_name, $hospital_address, $hospital_contact, $hospital_email] as $required) {
        if ($required === '') {
            $respond('error', 'Masih ada data wajib yang belum diisi.');
        }
    }
    if (
        filter_var($base_url, FILTER_VALIDATE_URL) === false ||
        filter_var($hospital_email, FILTER_VALIDATE_EMAIL) === false
    ) {
        $respond('error', 'Base URL atau email tidak valid.');
    }
    foreach ([$base_url, $hospital_name, $hospital_address, $hospital_contact, $hospital_email, $hospital_code, $hospital_manager] as $value) {
        if (mb_strlen($value, 'UTF-8') > 255) {
            $respond('error', 'Panjang data tidak boleh melebihi 255 karakter.');
        }
    }

    if (!isset($_FILES['logo']) || $_FILES['logo']['error'] !== UPLOAD_ERR_OK) {
        $respond('error', 'Logo faskes wajib diunggah.');
    }
    $allowedExtensions = ['ico', 'png', 'jpg', 'jpeg', 'gif'];
    $logoFile = $_FILES['logo'];
    $extension = strtolower(pathinfo($logoFile['name'], PATHINFO_EXTENSION));
    if ($logoFile['size'] > 1024 * 1024 || !in_array($extension, $allowedExtensions, true)) {
        $respond('error', 'Logo harus berformat ICO, PNG, JPG, JPEG, atau GIF dan maksimal 1 MB.');
    }

    $uploadDirectory = __DIR__ . '/../../assets/img/logo/';
    if (!is_dir($uploadDirectory) && !mkdir($uploadDirectory, 0775, true) && !is_dir($uploadDirectory)) {
        $respond('error', 'Direktori penyimpanan logo tidak dapat dibuat.');
    }
    $logoName = bin2hex(random_bytes(16)) . '.' . $extension;
    if (!move_uploaded_file($logoFile['tmp_name'], $uploadDirectory . $logoName)) {
        $respond('error', 'Logo gagal diunggah.');
    }

    $lockAcquired = false;
    if ($status === 1) {
        $lockResult = $Conn->query("SELECT GET_LOCK(CONCAT(DATABASE(), ':simrs_setting_active'), 10) AS acquired");
        $lockData = $lockResult ? $lockResult->fetch_assoc() : null;
        $lockAcquired = isset($lockData['acquired']) && (int) $lockData['acquired'] === 1;
        if (!$lockAcquired) {
            unlink($uploadDirectory . $logoName);
            $respond('error', 'Pengaturan aktif sedang diproses. Silakan coba kembali.');
        }
    }

    $Conn->begin_transaction();
    $saved = true;
    if ($status === 1) {
        $deactivate = $Conn->prepare("UPDATE setting SET status = 0 WHERE status = 1");
        $saved = $deactivate->execute();
        $deactivate->close();
    }

    if ($saved) {
        $stmt = $Conn->prepare("
            INSERT INTO setting (
                setting_name, base_url, hospital_name, hospital_address, hospital_contact,
                hospital_email, hospital_code, hospital_manager, logo, status
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param(
            "sssssssssi",
            $setting_name,
            $base_url,
            $hospital_name,
            $hospital_address,
            $hospital_contact,
            $hospital_email,
            $hospital_code,
            $hospital_manager,
            $logoName,
            $status
        );
        $saved = $stmt->execute();
        $stmt->close();
    }

    if ($saved) {
        $Conn->commit();
    } else {
        $Conn->rollback();
        unlink($uploadDirectory . $logoName);
    }
    if ($lockAcquired) {
        $Conn->query("SELECT RELEASE_LOCK(CONCAT(DATABASE(), ':simrs_setting_active'))");
    }

    if (!$saved) {
        $respond('error', 'Gagal menyimpan data pengaturan.');
    }
    $respond('success', 'Tambah pengaturan berhasil.');
?>
