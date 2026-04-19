<?php
    date_default_timezone_set('Asia/Jakarta');

    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

    header('Content-Type: application/json');

    // Validasi session
    if (empty($SessionIdAkses)) {
        echo json_encode([
            "status" => "error",
            "message" => "Sesi berakhir"
        ]);
        exit;
    }

    // Ambil data
    $id_akses_pengajuan = $_POST['id_akses_pengajuan'] ?? '';
    $nama      = trim($_POST['nama'] ?? '');
    $nik       = trim($_POST['nik'] ?? '');
    $kontak    = trim($_POST['kontak'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $alamat    = trim($_POST['alamat'] ?? '');
    $deskripsi = trim($_POST['deskripsi'] ?? '');

    // ============================
    // VALIDASI WAJIB
    // ============================
    if (empty($id_akses_pengajuan)) {
        echo json_encode(["status"=>"error","message"=>"ID tidak valid"]);
        exit;
    }

    if (empty($nama) || empty($nik) || empty($kontak) || empty($email) || empty($alamat) || empty($deskripsi)) {
        echo json_encode(["status"=>"error","message"=>"Semua field wajib diisi"]);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["status"=>"error","message"=>"Format email tidak valid"]);
        exit;
    }

    // ============================
    // AMBIL DATA LAMA
    // ============================
    $stmt = $Conn->prepare("SELECT * FROM akses_pengajuan WHERE id_akses_pengajuan=?");
    $stmt->bind_param("i", $id_akses_pengajuan);
    $stmt->execute();
    $result = $stmt->get_result();
    $data_lama = $result->fetch_assoc();
    $stmt->close();

    if (!$data_lama) {
        echo json_encode(["status"=>"error","message"=>"Data tidak ditemukan"]);
        exit;
    }

    // ============================
    // VALIDASI DUPLIKAT (jika berubah)
    // ============================
    if ($email != $data_lama['email']) {
        $stmt = $Conn->prepare("SELECT id_akses_pengajuan FROM akses_pengajuan WHERE email=? AND id_akses_pengajuan!=?");
        $stmt->bind_param("si", $email, $id_akses_pengajuan);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            echo json_encode(["status"=>"error","message"=>"Email sudah digunakan"]);
            exit;
        }
        $stmt->close();
    }

    if ($kontak != $data_lama['kontak']) {
        $stmt = $Conn->prepare("SELECT id_akses_pengajuan FROM akses_pengajuan WHERE kontak=? AND id_akses_pengajuan!=?");
        $stmt->bind_param("si", $kontak, $id_akses_pengajuan);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            echo json_encode(["status"=>"error","message"=>"Kontak sudah digunakan"]);
            exit;
        }
        $stmt->close();
    }

    // ============================
    // HANDLE FOTO
    // ============================
    $nama_foto_baru = $data_lama['foto'];

    if (!empty($_FILES['foto']['name'])) {

        $file      = $_FILES['foto'];
        $ext       = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed   = ['jpg','jpeg','png','gif'];
        $size      = $file['size'];
        $tmp       = $file['tmp_name'];

        if (!in_array($ext, $allowed)) {
            echo json_encode(["status"=>"error","message"=>"Format foto tidak valid"]);
            exit;
        }

        if ($size > 2 * 1024 * 1024) {
            echo json_encode(["status"=>"error","message"=>"Ukuran foto maksimal 2MB"]);
            exit;
        }

        // Generate nama baru
        $nama_foto_baru = 'Pengajuan_' . time() . '_' . rand(1000,9999) . '.' . $ext;
        $path_upload = "../../assets/images/PengajuanAkses/" . $nama_foto_baru;

        if (!move_uploaded_file($tmp, $path_upload)) {
            echo json_encode(["status"=>"error","message"=>"Upload foto gagal"]);
            exit;
        }

        // Hapus foto lama
        if (!empty($data_lama['foto'])) {
            $old_path = "../../assets/images/PengajuanAkses/" . $data_lama['foto'];
            if (file_exists($old_path)) {
                unlink($old_path);
            }
        }
    }

    // ============================
    // UPDATE DATA
    // ============================
    $stmt = $Conn->prepare("
        UPDATE akses_pengajuan SET
            nama=?,
            nik=?,
            kontak=?,
            email=?,
            alamat=?,
            deskripsi=?,
            foto=?
        WHERE id_akses_pengajuan=?
    ");

    $stmt->bind_param(
        "sssssssi",
        $nama,
        $nik,
        $kontak,
        $email,
        $alamat,
        $deskripsi,
        $nama_foto_baru,
        $id_akses_pengajuan
    );

    if ($stmt->execute()) {
        echo json_encode([
            "status" => "success"
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Gagal update data"
        ]);
    }

    $stmt->close();
?>