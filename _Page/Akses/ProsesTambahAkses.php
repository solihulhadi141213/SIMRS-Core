<?php
header('Content-Type: application/json; charset=UTF-8');

include "../../_Config/Connection.php";
include "../../_Config/Session.php";
include "AksesHelper.php";

$response = ['status' => 'error', 'message' => 'Data akses gagal ditambahkan.'];
$transactionStarted = false;
$uploadedImage = '';

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

    $nama = $readString('nama');
    $nik = $readString('nik');
    $ihs = $readString('ihs');
    $email = $readString('email');
    $kontak = $readString('kontak');
    $idEntitas = filter_var($_POST['id_akses_entitas'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    $password = $_POST['password'] ?? null;

    if (!is_string($password)) {
        throw new InvalidArgumentException('Password tidak valid.');
    }
    if ($nama === '' || $nik === '' || $email === '' || $kontak === '' || !$idEntitas || $password === '') {
        throw new InvalidArgumentException('Semua field wajib diisi.');
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new InvalidArgumentException('Alamat email tidak valid.');
    }
    if (strlen($password) < 8 || strlen($password) > 20) {
        throw new InvalidArgumentException('Password harus 8-20 karakter.');
    }
    if (strlen($nama) > 255 || strlen($nik) > 255 || strlen($ihs) > 255 || strlen($email) > 255 || strlen($kontak) > 255) {
        throw new InvalidArgumentException('Salah satu data melebihi panjang yang diizinkan.');
    }

    $duplicateExists = static function ($field, $value) use ($Conn) {
        $allowedFields = ['nik', 'ihs', 'email', 'kontak'];
        if (!in_array($field, $allowedFields, true)) {
            throw new LogicException('Kolom validasi duplikat tidak diizinkan.');
        }

        $stmt = $Conn->prepare("SELECT id_akses FROM akses WHERE {$field} = ? LIMIT 1");
        if (!$stmt) {
            throw new RuntimeException('Gagal menyiapkan validasi data pengguna.');
        }
        $stmt->bind_param('s', $value);
        if (!$stmt->execute()) {
            $stmt->close();
            throw new RuntimeException('Gagal memvalidasi data pengguna.');
        }
        $stmt->store_result();
        $exists = $stmt->num_rows > 0;
        $stmt->close();
        return $exists;
    };

    foreach (['nik' => 'NIK sudah terdaftar.', 'email' => 'Email sudah terdaftar.', 'kontak' => 'Kontak sudah digunakan.'] as $field => $message) {
        if ($duplicateExists($field, $$field)) {
            throw new InvalidArgumentException($message);
        }
    }
    if ($ihs !== '' && $duplicateExists('ihs', $ihs)) {
        throw new InvalidArgumentException('IHS sudah digunakan.');
    }

    if (!isset($_FILES['gambar']) || !is_array($_FILES['gambar'])) {
        throw new InvalidArgumentException('Foto profil wajib diunggah.');
    }
    $uploadedImage = aksesStoreUploadedImage($_FILES['gambar']);

    if (!$Conn->begin_transaction()) {
        throw new RuntimeException('Gagal memulai penyimpanan data akses.');
    }
    $transactionStarted = true;

    $stmtEntitas = $Conn->prepare('SELECT akses FROM akses_entitas WHERE id_akses_entitas = ?');
    if (!$stmtEntitas) {
        throw new RuntimeException('Gagal menyiapkan validasi entitas akses.');
    }
    $stmtEntitas->bind_param('i', $idEntitas);
    if (!$stmtEntitas->execute()) {
        $stmtEntitas->close();
        throw new RuntimeException('Gagal memvalidasi entitas akses.');
    }
    $dataEntitas = $stmtEntitas->get_result()->fetch_assoc();
    $stmtEntitas->close();
    if (!$dataEntitas) {
        throw new InvalidArgumentException('Entitas akses tidak valid.');
    }

    $now = (new DateTimeImmutable('now', new DateTimeZone('UTC')))->format('Y-m-d H:i:s');
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    if ($passwordHash === false) {
        throw new RuntimeException('Password gagal diproses.');
    }

    $stmtInsert = $Conn->prepare(
        'INSERT INTO akses (
            id_akses_entitas, tanggal, nama, nik, ihs, email, kontak,
            password, akses, gambar, updatetime
         ) VALUES (?, ?, ?, ?, NULLIF(?, \'\'), ?, ?, ?, ?, ?, ?)'
    );
    if (!$stmtInsert) {
        throw new RuntimeException('Gagal menyiapkan data akses.');
    }
    $stmtInsert->bind_param(
        'issssssssss',
        $idEntitas,
        $now,
        $nama,
        $nik,
        $ihs,
        $email,
        $kontak,
        $passwordHash,
        $dataEntitas['akses'],
        $uploadedImage,
        $now
    );
    if (!$stmtInsert->execute()) {
        $stmtInsert->close();
        throw new RuntimeException('Gagal menyimpan data akses.');
    }
    $newAccessId = $stmtInsert->insert_id;
    $stmtInsert->close();

    $stmtCopy = $Conn->prepare(
        'INSERT INTO akses_acc (id_akses, id_akses_fitur)
         SELECT ?, id_akses_fitur FROM akses_entitas_acc WHERE id_akses_entitas = ?'
    );
    if (!$stmtCopy) {
        throw new RuntimeException('Gagal menyiapkan izin akses awal.');
    }
    $stmtCopy->bind_param('ii', $newAccessId, $idEntitas);
    if (!$stmtCopy->execute()) {
        $stmtCopy->close();
        throw new RuntimeException('Gagal menyalin izin akses entitas.');
    }
    $stmtCopy->close();

    aksesWriteAuditLog($Conn, (int) $SessionIdAkses, (string) $SessionNama, 'Menambahkan akses pengguna', [
        'id_akses' => $newAccessId,
    ]);

    if (!$Conn->commit()) {
        throw new RuntimeException('Gagal menyelesaikan penyimpanan akses.');
    }
    $transactionStarted = false;
    $response = ['status' => 'success', 'message' => 'Data berhasil ditambahkan.'];
} catch (InvalidArgumentException $error) {
    $response['message'] = $error->getMessage();
} catch (Throwable $error) {
    error_log('Akses tambah: ' . $error->getMessage());
} finally {
    if ($transactionStarted) {
        $Conn->rollback();
    }
    if ($response['status'] !== 'success' && $uploadedImage !== '') {
        aksesRemoveImage($uploadedImage);
    }
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
