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

    $id_setting = filter_input(INPUT_POST, 'id_setting', FILTER_VALIDATE_INT);
    if (!$id_setting || $id_setting < 1) {
        $respond('error', 'ID pengaturan tidak valid.');
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

    $stmtOld = $Conn->prepare("SELECT logo FROM setting WHERE id_setting = ?");
    $stmtOld->bind_param("i", $id_setting);
    $stmtOld->execute();
    $resultOld = $stmtOld->get_result();
    $oldData = $resultOld->fetch_assoc();
    $stmtOld->close();
    if (!$oldData) {
        $respond('error', 'Data pengaturan tidak ditemukan.');
    }
    $oldLogo = $oldData['logo'];
    $logoName = $oldLogo;
    $newLogoPath = null;
    $uploadDirectory = __DIR__ . '/../../assets/img/logo/';

    if (isset($_FILES['logo']) && $_FILES['logo']['error'] !== UPLOAD_ERR_NO_FILE) {
        if ($_FILES['logo']['error'] !== UPLOAD_ERR_OK) {
            $respond('error', 'Logo gagal diunggah.');
        }
        $logoFile = $_FILES['logo'];
        $extension = strtolower(pathinfo($logoFile['name'], PATHINFO_EXTENSION));
        if (
            $logoFile['size'] > 1024 * 1024 ||
            !in_array($extension, ['ico', 'png', 'jpg', 'jpeg', 'gif'], true)
        ) {
            $respond('error', 'Logo harus berformat ICO, PNG, JPG, JPEG, atau GIF dan maksimal 1 MB.');
        }
        if (!is_dir($uploadDirectory) && !mkdir($uploadDirectory, 0775, true) && !is_dir($uploadDirectory)) {
            $respond('error', 'Direktori penyimpanan logo tidak dapat dibuat.');
        }
        $logoName = bin2hex(random_bytes(16)) . '.' . $extension;
        $newLogoPath = $uploadDirectory . $logoName;
        if (!move_uploaded_file($logoFile['tmp_name'], $newLogoPath)) {
            $respond('error', 'Logo gagal diunggah.');
        }
    }

    $lockAcquired = false;
    if ($status === 1) {
        $lockResult = $Conn->query("SELECT GET_LOCK(CONCAT(DATABASE(), ':simrs_setting_active'), 10) AS acquired");
        $lockData = $lockResult ? $lockResult->fetch_assoc() : null;
        $lockAcquired = isset($lockData['acquired']) && (int) $lockData['acquired'] === 1;
        if (!$lockAcquired) {
            if ($newLogoPath !== null) {
                unlink($newLogoPath);
            }
            $respond('error', 'Pengaturan aktif sedang diproses. Silakan coba kembali.');
        }
    }

    $Conn->begin_transaction();
    $saved = true;
    if ($status === 1) {
        $deactivate = $Conn->prepare("UPDATE setting SET status = 0 WHERE status = 1 AND id_setting != ?");
        $deactivate->bind_param("i", $id_setting);
        $saved = $deactivate->execute();
        $deactivate->close();
    }

    if ($saved) {
        $stmt = $Conn->prepare("
            UPDATE setting SET
                setting_name = ?,
                base_url = ?,
                hospital_name = ?,
                hospital_address = ?,
                hospital_contact = ?,
                hospital_email = ?,
                hospital_code = ?,
                hospital_manager = ?,
                logo = ?,
                status = ?
            WHERE id_setting = ?
        ");
        $stmt->bind_param(
            "sssssssssii",
            $setting_name,
            $base_url,
            $hospital_name,
            $hospital_address,
            $hospital_contact,
            $hospital_email,
            $hospital_code,
            $hospital_manager,
            $logoName,
            $status,
            $id_setting
        );
        $saved = $stmt->execute();
        $stmt->close();
    }

    if ($saved) {
        $Conn->commit();
        if ($newLogoPath !== null && !empty($oldLogo)) {
            $oldLogoName = basename((string) $oldLogo);
            foreach ([
                $uploadDirectory . $oldLogoName,
                __DIR__ . '/../../assets/images/' . $oldLogoName,
                __DIR__ . '/../../_File/Setting/' . $oldLogoName,
            ] as $oldLogoPath) {
                if (is_file($oldLogoPath)) {
                    unlink($oldLogoPath);
                }
            }
        }
    } else {
        $Conn->rollback();
        if ($newLogoPath !== null) {
            unlink($newLogoPath);
        }
    }
    if ($lockAcquired) {
        $Conn->query("SELECT RELEASE_LOCK(CONCAT(DATABASE(), ':simrs_setting_active'))");
    }

    if (!$saved) {
        $respond('error', 'Gagal memperbarui data pengaturan.');
    }
    $respond('success', 'Edit pengaturan berhasil.');
?>
