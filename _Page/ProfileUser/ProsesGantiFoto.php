<?php
    header('Content-Type: application/json');

    // Connection
    include "../../_Config/Connection.php";
    
    // Simrs Function
    include "../../_Config/SimrsFunction.php";

    // Session
    include "../../_Config/Session.php";

    // Validasi session
    if (empty($SessionIdAkses)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Sesi akses sudah berakhir, silakan login ulang.'
        ]);
        exit;
    }

    // Validasi file kosong
    if (empty($_FILES['foto']['name'])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Foto tidak boleh kosong.'
        ]);
        exit;
    }

    // Data file
    $nama_gambar   = $_FILES['foto']['name'];
    $ukuran_gambar = $_FILES['foto']['size'];
    $tipe_gambar   = $_FILES['foto']['type'];
    $tmp_gambar    = $_FILES['foto']['tmp_name'];

    // Validasi ukuran file
    if ($ukuran_gambar > 2000000) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Ukuran file tidak boleh lebih dari 2 MB.'
        ]);
        exit;
    }

    // Validasi tipe file
    $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];

    if (!in_array($tipe_gambar, $allowed_types)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Format file harus JPG, JPEG, PNG, atau GIF.'
        ]);
        exit;
    }

    // Generate nama file baru
    $ext = strtolower(pathinfo($nama_gambar, PATHINFO_EXTENSION));
    $namabaru = round(microtime(true) * 1000) . '.' . $ext;

    // Simpan foto profil baru pada folder aset UI.
    $folder_foto = __DIR__ . "/../../assets/img/user";
    $path_upload = $folder_foto . "/" . $namabaru;

    // Upload file
    if (!move_uploaded_file($tmp_gambar, $path_upload)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Upload file gagal.'
        ]);
        exit;
    }

    // Periksa lokasi foto lama saat ini dan lokasi legacy sebelum mengganti file.
    $nama_gambar_lama = basename((string) $SessionGambar);
    $path_gambar_lama = $folder_foto . "/" . $nama_gambar_lama;
    $path_gambar_legacy = __DIR__ . "/../../assets/images/user/" . $nama_gambar_lama;

    // Update database
    $updatetimeUtc = (new DateTimeImmutable('now', new DateTimeZone('UTC')))->format('Y-m-d H:i:s');
    $stmt = mysqli_prepare($Conn, "UPDATE akses SET gambar=?, updatetime=? WHERE id_akses=?");

    if (!$stmt) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal mempersiapkan query.'
        ]);
        exit;
    }

    mysqli_stmt_bind_param($stmt, "ssi", $namabaru, $updatetimeUtc, $SessionIdAkses);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['NotifikasiSwal'] = 'Foto Profile Berhasil Diperbarui';

        // Hapus foto lama jika ada dan bukan default
        if ($nama_gambar_lama !== '' && $nama_gambar_lama !== 'No-Image.png' && is_file($path_gambar_lama)) {
            @unlink($path_gambar_lama);
        } elseif ($nama_gambar_lama !== '' && $nama_gambar_lama !== 'No-Image.png' && is_file($path_gambar_legacy)) {
            @unlink($path_gambar_legacy);
        }

        echo json_encode([
            'status' => 'success',
            'message' => 'Foto profile berhasil diperbarui.',
            'filename' => $namabaru
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal memperbarui database.'
        ]);
    }

    mysqli_stmt_close($stmt);
?>