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
    $id_setting = $_POST['id_setting'] ?? '';

    if (empty($id_setting)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'ID setting tidak valid.'
        ]);
        exit;
    }

    // =====================================
    // AMBIL DATA FORM
    // =====================================
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

    // =====================================
    // VALIDASI FIELD WAJIB
    // =====================================
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
                'message' => 'Masih ada field wajib yang kosong.'
            ]);
            exit;
        }
    }

    // =====================================
    // VALIDASI PANJANG KARAKTER
    // =====================================
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

    // =====================================
    // PROSES KEYWORD → JSON
    // =====================================
    $keywordArray = array_map('trim', explode(',', $aplication_keyword));
    $keywordArray = array_filter($keywordArray);

    if (count($keywordArray) > 5) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Keyword maksimal 5.'
        ]);
        exit;
    }

    $keywordJson = json_encode(array_values($keywordArray));

    // =====================================
    // AMBIL DATA LAMA
    // =====================================
    $stmtOld = $Conn->prepare("SELECT favicon, logo FROM setting WHERE id_setting = ?");
    $stmtOld->bind_param("i", $id_setting);
    $stmtOld->execute();
    $resultOld = $stmtOld->get_result();
    $dataOld = $resultOld->fetch_assoc();

    if (!$dataOld) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Data setting tidak ditemukan.'
        ]);
        exit;
    }

    $faviconOld = $dataOld['favicon'];
    $logoOld = $dataOld['logo'];

    $uploadDir = "../../_File/Setting/";
    $allowedExt = ['ico', 'png', 'jpg', 'jpeg', 'gif'];
    $maxSize = 1024 * 1024;

    // =====================================
    // FUNCTION UPLOAD FILE
    // =====================================
    function uploadReplaceFile($file, $oldFile, $uploadDir, $allowedExt, $maxSize)
    {
        if (empty($file['name'])) {
            return $oldFile;
        }

        if ($file['size'] > $maxSize) {
            return false;
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowedExt)) {
            return false;
        }

        $newName = bin2hex(random_bytes(16)) . '.' . $ext;
        $destination = $uploadDir . $newName;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (move_uploaded_file($file['tmp_name'], $destination)) {

            // hapus file lama
            if (!empty($oldFile) && file_exists($uploadDir . $oldFile)) {
                unlink($uploadDir . $oldFile);
            }

            return $newName;
        }

        return false;
    }

    // =====================================
    // HANDLE FAVICON
    // =====================================
    $faviconNew = $faviconOld;

    if (isset($_FILES['favicon']) && !empty($_FILES['favicon']['name'])) {
        $faviconNew = uploadReplaceFile(
            $_FILES['favicon'],
            $faviconOld,
            $uploadDir,
            $allowedExt,
            $maxSize
        );

        if ($faviconNew === false) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Upload favicon gagal.'
            ]);
            exit;
        }
    }

    // =====================================
    // HANDLE LOGO
    // =====================================
    $logoNew = $logoOld;

    if (isset($_FILES['logo']) && !empty($_FILES['logo']['name'])) {
        $logoNew = uploadReplaceFile(
            $_FILES['logo'],
            $logoOld,
            $uploadDir,
            $allowedExt,
            $maxSize
        );

        if ($logoNew === false) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Upload logo gagal.'
            ]);
            exit;
        }
    }

    // =====================================
    // JIKA STATUS 1 → NONAKTIFKAN LAIN
    // =====================================
    if ($status == 1) {
        $stmtNonaktif = $Conn->prepare("UPDATE setting SET status = 0 WHERE id_setting != ?");
        $stmtNonaktif->bind_param("i", $id_setting);
        $stmtNonaktif->execute();
    }

    // =====================================
    // UPDATE DATA
    // =====================================
    $stmt = $Conn->prepare("
        UPDATE setting SET
            setting_name = ?,
            aplication_name = ?,
            aplication_description = ?,
            aplication_keyword = ?,
            aplication_author = ?,
            base_url = ?,
            hospital_name = ?,
            hospital_address = ?,
            hospital_contact = ?,
            hospital_email = ?,
            hospital_code = ?,
            hospital_manager = ?,
            favicon = ?,
            logo = ?,
            status = ?
        WHERE id_setting = ?
    ");

    $stmt->bind_param(
        "ssssssssssssssii",
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
        $faviconNew,
        $logoNew,
        $status,
        $id_setting
    );

    $execute = $stmt->execute();

    // =====================================
    // RESPONSE
    // =====================================
    if ($execute) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Edit setting berhasil.'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal update data.'
        ]);
    }
?>