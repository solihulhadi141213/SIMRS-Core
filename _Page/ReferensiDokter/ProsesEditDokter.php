<?php
header('Content-Type: application/json');
date_default_timezone_set('Asia/Jakarta');

// Debug MySQL biar error kebaca jelas
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

include "../../_Config/Connection.php";
include "../../_Config/SimrsFunction.php";
include "../../_Config/Session.php";

// ========================
// DEFAULT RESPONSE
// ========================
$response = [
    'status' => 'error',
    'message' => 'Terjadi kesalahan.'
];

// ========================
// VALIDASI SESSION
// ========================
if (empty($SessionIdAkses)) {
    exit(json_encode(['status'=>'error','message'=>'Sesi berakhir, login ulang']));
}

// ========================
// VALIDASI METHOD
// ========================
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit(json_encode(['status'=>'error','message'=>'Request tidak valid']));
}

// ========================
// AMBIL INPUT
// ========================
$id_dokter           = (int) ($_POST['id_dokter'] ?? 0);
$id_ihs_practitioner = trim($_POST['id_ihs_practitioner'] ?? '');
$kode                = trim($_POST['kode'] ?? '');
$nama                = trim($_POST['nama'] ?? '');
$gender              = trim($_POST['gender'] ?? '');
$tanggal_lahir       = trim($_POST['tanggal_lahir'] ?? '');
$kategori            = trim($_POST['kategori'] ?? '');
$no_identitas        = trim($_POST['no_identitas'] ?? '');
$alamat              = trim($_POST['alamat'] ?? '');
$kontak              = trim($_POST['kontak'] ?? '');
$email               = trim($_POST['email'] ?? '');
$SIP                 = trim($_POST['SIP'] ?? '');
$status              = isset($_POST['status']) ? 1 : 0;

// ========================
// VALIDASI
// ========================
if ($id_dokter <= 0) {
    exit(json_encode(['status'=>'error','message'=>'ID tidak valid']));
}

if ($kode === '') {
    exit(json_encode(['status'=>'error','message'=>'Kode tidak boleh kosong']));
}

if ($nama === '') {
    exit(json_encode(['status'=>'error','message'=>'Nama tidak boleh kosong']));
}

if ($gender === '') {
    exit(json_encode(['status'=>'error','message'=>'Gender wajib']));
}

if ($tanggal_lahir === '') {
    exit(json_encode(['status'=>'error','message'=>'Tanggal lahir wajib']));
}

if ($kategori === '') {
    exit(json_encode(['status'=>'error','message'=>'Kategori wajib']));
}

if ($no_identitas === '') {
    exit(json_encode(['status'=>'error','message'=>'Identitas wajib']));
}

if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit(json_encode(['status'=>'error','message'=>'Email tidak valid']));
}

try {

    // ========================
    // AMBIL DATA LAMA
    // ========================
    $stmt = mysqli_prepare($Conn, "SELECT foto FROM dokter WHERE id_dokter=?");
    mysqli_stmt_bind_param($stmt, "i", $id_dokter);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result || mysqli_num_rows($result) == 0) {
        exit(json_encode(['status'=>'error','message'=>'Data tidak ditemukan']));
    }

    $old = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    $oldFoto = $old['foto'];

    // ========================
    // CEK DUPLIKAT KODE
    // ========================
    $stmt = mysqli_prepare($Conn, "SELECT id_dokter FROM dokter WHERE kode=? AND id_dokter!=?");
    mysqli_stmt_bind_param($stmt, "si", $kode, $id_dokter);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        exit(json_encode(['status'=>'error','message'=>'Kode sudah digunakan']));
    }
    mysqli_stmt_close($stmt);

    // ========================
    // CEK DUPLIKAT IHS
    // ========================
    if ($id_ihs_practitioner !== '') {
        $stmt = mysqli_prepare($Conn, "SELECT id_dokter FROM dokter WHERE id_ihs_practitioner=? AND id_dokter!=?");
        mysqli_stmt_bind_param($stmt, "si", $id_ihs_practitioner, $id_dokter);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            exit(json_encode(['status'=>'error','message'=>'ID Practitioner sudah digunakan']));
        }
        mysqli_stmt_close($stmt);
    } else {
        $id_ihs_practitioner = null;
    }

    // ========================
    // HANDLE FOTO
    // ========================
    $foto = $oldFoto;

    if (!empty($_FILES['foto']['name'])) {

        $fileTmp  = $_FILES['foto']['tmp_name'];
        $fileSize = $_FILES['foto']['size'];

        if ($fileSize > 2 * 1024 * 1024) {
            exit(json_encode(['status'=>'error','message'=>'Max foto 2MB']));
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime  = finfo_file($finfo, $fileTmp);
        finfo_close($finfo);

        $allowed = [
            'image/jpeg'=>'jpg',
            'image/png'=>'png',
            'image/gif'=>'gif'
        ];

        if (!isset($allowed[$mime])) {
            exit(json_encode(['status'=>'error','message'=>'Format file tidak valid']));
        }

        $ext  = $allowed[$mime];
        $foto = bin2hex(random_bytes(16)) . '.' . $ext;

        $path = "../../assets/images/Dokter/" . $foto;

        if (!move_uploaded_file($fileTmp, $path)) {
            exit(json_encode(['status'=>'error','message'=>'Upload gagal']));
        }

        // hapus foto lama
        if (!empty($oldFoto)) {
            $oldPath = "../../assets/images/Dokter/" . $oldFoto;
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }
    }

    // ========================
    // UPDATE
    // ========================
    $kategori_identitas = "KTP";

    $stmt = mysqli_prepare($Conn, "
        UPDATE dokter SET
            id_ihs_practitioner = ?,
            kode = ?,
            nama = ?,
            gender = ?,
            tanggal_lahir = ?,
            kategori = ?,
            kategori_identitas = ?,
            no_identitas = ?,
            alamat = ?,
            kontak = ?,
            email = ?,
            SIP = ?,
            status = ?,
            foto = ?
        WHERE id_dokter = ?
    ");

    if (!$stmt) {
        throw new Exception('Prepare gagal: ' . mysqli_error($Conn));
    }

    // TYPE: 12 string + 1 int + 1 string + 1 int = 15
    mysqli_stmt_bind_param(
        $stmt,
        "ssssssssssssisi",
        $id_ihs_practitioner,
        $kode,
        $nama,
        $gender,
        $tanggal_lahir,
        $kategori,
        $kategori_identitas,
        $no_identitas,
        $alamat,
        $kontak,
        $email,
        $SIP,
        $status,
        $foto,
        $id_dokter
    );

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    echo json_encode([
        'status' => 'success',
        'message' => 'Data berhasil diupdate'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}