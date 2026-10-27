<?php
header('Content-Type: application/json; charset=UTF-8');

include "../../_Config/Connection.php";
include "../../_Config/Session.php";
include "AksesHelper.php";

$response = ['status' => 'error', 'message' => 'Data akses gagal diperbarui.'];
$transactionStarted = false;
$uploadedImage = '';
$oldImageToRemove = '';

if (empty($SessionIdAkses)) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Sesi berakhir.'], JSON_UNESCAPED_UNICODE);
    exit;
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Metode request tidak valid.'], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    $readString = static function ($key) {
        $value = $_POST[$key] ?? '';
        if (!is_string($value)) {
            throw new InvalidArgumentException('Format data yang dikirim tidak valid.');
        }
        return trim($value);
    };

    $idAkses = filter_var($_POST['id_akses'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    $idEntitas = filter_var($_POST['id_akses_entitas'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    $nama = $readString('nama');
    $nik = $readString('nik');
    $ihs = $readString('ihs');
    $email = $readString('email');
    $kontak = $readString('kontak');
    $password = $_POST['password'] ?? null;

    if (!$idAkses || !$idEntitas || $nama === '' || $nik === '' || $email === '' || $kontak === '') {
        throw new InvalidArgumentException('Data wajib tidak boleh kosong.');
    }
    if (!is_string($password)) {
        throw new InvalidArgumentException('Password tidak valid.');
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new InvalidArgumentException('Alamat email tidak valid.');
    }
    if (strlen($nama) > 255 || strlen($nik) > 255 || strlen($ihs) > 255 || strlen($email) > 255 || strlen($kontak) > 255) {
        throw new InvalidArgumentException('Salah satu data melebihi panjang yang diizinkan.');
    }
    if ($password !== '' && (strlen($password) < 8 || strlen($password) > 20)) {
        throw new InvalidArgumentException('Password harus 8-20 karakter.');
    }

    $stmtOld = $Conn->prepare('SELECT gambar, id_akses_entitas FROM akses WHERE id_akses = ?');
    if (!$stmtOld) {
        throw new RuntimeException('Gagal menyiapkan data akses.');
    }
    $stmtOld->bind_param('i', $idAkses);
    if (!$stmtOld->execute()) {
        $stmtOld->close();
        throw new RuntimeException('Gagal memuat data akses.');
    }
    $oldData = $stmtOld->get_result()->fetch_assoc();
    $stmtOld->close();
    if (!$oldData) {
        throw new InvalidArgumentException('Data akses tidak ditemukan.');
    }

    $duplicateExists = static function ($field, $value) use ($Conn, $idAkses) {
        $allowedFields = ['nik', 'ihs', 'email', 'kontak'];
        if (!in_array($field, $allowedFields, true)) {
            throw new LogicException('Kolom validasi duplikat tidak diizinkan.');
        }
        $stmt = $Conn->prepare("SELECT id_akses FROM akses WHERE {$field} = ? AND id_akses <> ? LIMIT 1");
        if (!$stmt) {
            throw new RuntimeException('Gagal menyiapkan validasi data pengguna.');
        }
        $stmt->bind_param('si', $value, $idAkses);
        if (!$stmt->execute()) {
            $stmt->close();
            throw new RuntimeException('Gagal memvalidasi data pengguna.');
        }
        $stmt->store_result();
        $exists = $stmt->num_rows > 0;
        $stmt->close();
        return $exists;
    };
    foreach (['nik' => 'NIK sudah digunakan.', 'email' => 'Email sudah digunakan.', 'kontak' => 'Kontak sudah digunakan.'] as $field => $message) {
        if ($duplicateExists($field, $$field)) {
            throw new InvalidArgumentException($message);
        }
    }
    if ($ihs !== '' && $duplicateExists('ihs', $ihs)) {
        throw new InvalidArgumentException('IHS sudah digunakan.');
    }

    $stmtRole = $Conn->prepare('SELECT akses FROM akses_entitas WHERE id_akses_entitas = ?');
    if (!$stmtRole) {
        throw new RuntimeException('Gagal menyiapkan validasi entitas akses.');
    }
    $stmtRole->bind_param('i', $idEntitas);
    if (!$stmtRole->execute()) {
        $stmtRole->close();
        throw new RuntimeException('Gagal memvalidasi entitas akses.');
    }
    $role = $stmtRole->get_result()->fetch_assoc();
    $stmtRole->close();
    if (!$role) {
        throw new InvalidArgumentException('Entitas akses tidak valid.');
    }

    $imageFile = $_FILES['gambar'] ?? null;
    if ($imageFile !== null) {
        if (!is_array($imageFile) || !isset($imageFile['error'])) {
            throw new InvalidArgumentException('File foto tidak valid.');
        }
        if ($imageFile['error'] !== UPLOAD_ERR_NO_FILE) {
            $uploadedImage = aksesStoreUploadedImage($imageFile);
        }
    }
    $imageName = $uploadedImage !== '' ? $uploadedImage : (string) ($oldData['gambar'] ?? '');
    $oldImageToRemove = $uploadedImage !== '' ? (string) ($oldData['gambar'] ?? '') : '';
    $ihsValue = $ihs === '' ? null : $ihs;
    $now = (new DateTimeImmutable('now', new DateTimeZone('UTC')))->format('Y-m-d H:i:s');

    if (!$Conn->begin_transaction()) {
        throw new RuntimeException('Gagal memulai perubahan data akses.');
    }
    $transactionStarted = true;

    if ($password !== '') {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        if ($passwordHash === false) {
            throw new RuntimeException('Password gagal diproses.');
        }
        $stmtUpdate = $Conn->prepare(
            'UPDATE akses SET nama = ?, nik = ?, ihs = ?, email = ?, kontak = ?,
             id_akses_entitas = ?, akses = ?, password = ?, gambar = ?, updatetime = ?
             WHERE id_akses = ?'
        );
        if (!$stmtUpdate) {
            throw new RuntimeException('Gagal menyiapkan perubahan data akses.');
        }
        $stmtUpdate->bind_param(
            'ssssisssssi',
            $nama, $nik, $ihsValue, $email, $kontak,
            $idEntitas, $role['akses'], $passwordHash, $imageName, $now, $idAkses
        );
    } else {
        $stmtUpdate = $Conn->prepare(
            'UPDATE akses SET nama = ?, nik = ?, ihs = ?, email = ?, kontak = ?,
             id_akses_entitas = ?, akses = ?, gambar = ?, updatetime = ?
             WHERE id_akses = ?'
        );
        if (!$stmtUpdate) {
            throw new RuntimeException('Gagal menyiapkan perubahan data akses.');
        }
        $stmtUpdate->bind_param(
            'ssssissssi',
            $nama, $nik, $ihsValue, $email, $kontak,
            $idEntitas, $role['akses'], $imageName, $now, $idAkses
        );
    }
    if (!$stmtUpdate->execute()) {
        $stmtUpdate->close();
        throw new RuntimeException('Gagal memperbarui data akses.');
    }
    $stmtUpdate->close();

    if ((int) $oldData['id_akses_entitas'] !== $idEntitas) {
        $stmtDeleteAccess = $Conn->prepare('DELETE FROM akses_acc WHERE id_akses = ?');
        if (!$stmtDeleteAccess) {
            throw new RuntimeException('Gagal menyiapkan pembaruan izin akses.');
        }
        $stmtDeleteAccess->bind_param('i', $idAkses);
        if (!$stmtDeleteAccess->execute()) {
            $stmtDeleteAccess->close();
            throw new RuntimeException('Gagal menghapus izin akses lama.');
        }
        $stmtDeleteAccess->close();

        $stmtCopyAccess = $Conn->prepare(
            'INSERT INTO akses_acc (id_akses, id_akses_fitur)
             SELECT ?, id_akses_fitur FROM akses_entitas_acc WHERE id_akses_entitas = ?'
        );
        if (!$stmtCopyAccess) {
            throw new RuntimeException('Gagal menyiapkan izin akses entitas.');
        }
        $stmtCopyAccess->bind_param('ii', $idAkses, $idEntitas);
        if (!$stmtCopyAccess->execute()) {
            $stmtCopyAccess->close();
            throw new RuntimeException('Gagal memperbarui izin akses entitas.');
        }
        $stmtCopyAccess->close();
    }

    aksesWriteAuditLog($Conn, (int) $SessionIdAkses, (string) $SessionNama, 'Memperbarui akses pengguna', [
        'id_akses' => $idAkses,
    ]);
    if (!$Conn->commit()) {
        throw new RuntimeException('Gagal menyelesaikan perubahan akses.');
    }
    $transactionStarted = false;
    if ($oldImageToRemove !== '') {
        aksesRemoveImage($oldImageToRemove);
        $uploadedImage = '';
    }
    $response = ['status' => 'success', 'message' => 'Data berhasil diperbarui.'];
} catch (InvalidArgumentException $error) {
    $response['message'] = $error->getMessage();
} catch (Throwable $error) {
    error_log('Akses edit: ' . $error->getMessage());
} finally {
    if ($transactionStarted) {
        $Conn->rollback();
    }
    if ($response['status'] !== 'success' && $uploadedImage !== '') {
        aksesRemoveImage($uploadedImage);
    }
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
