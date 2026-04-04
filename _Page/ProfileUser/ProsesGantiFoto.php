<?php
    header('Content-Type: application/json');

    //Zona Waktu
    date_default_timezone_set('Asia/Jakarta');

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

    // Path upload
    $path_upload = "../../assets/images/user/" . $namabaru;

    // Upload file
    if (!move_uploaded_file($tmp_gambar, $path_upload)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Upload file gagal.'
        ]);
        exit;
    }

    // Simpan nama gambar lama
    $path_gambar_lama = "../../assets/images/user/" . $SessionGambar;

    // Update database
    $stmt = mysqli_prepare($Conn, "UPDATE akses SET gambar=? WHERE id_akses=?");

    if (!$stmt) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal mempersiapkan query.'
        ]);
        exit;
    }

    mysqli_stmt_bind_param($stmt, "si", $namabaru, $SessionIdAkses);

    if (mysqli_stmt_execute($stmt)) {

        // Hapus foto lama jika ada dan bukan default
        if (!empty($SessionGambar) && file_exists($path_gambar_lama)) {
            @unlink($path_gambar_lama);
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