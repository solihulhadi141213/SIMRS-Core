<?php
    session_start();
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";

    $TanggalPengajuan = date('Y-m-d H:i:s');

    // Validasi Session
    if (empty($_SESSION["code"])) {
        echo '<span class="text-danger">Sesi Berakhir, Silahkan Reload Halaman Terlebih Dulu!</span>';
        exit;
    }

    // Validasi Input Form
    $errors = [];

    if (empty($_POST['nama'])) {
        $errors[] = 'Nama tidak boleh kosong.';
    } else {
        $nama = filter_var($_POST['nama'], FILTER_SANITIZE_STRING);
        if ($nama === "") {
            $errors[] = 'Karakter nama Anda tidak valid.';
        }
    }

    if (empty($_POST['email'])) {
        $errors[] = 'Email tidak boleh kosong.';
    } else {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Format email tidak valid.';
        }
    }

    if (empty($_POST['kontak'])) {
        $errors[] = 'Nomor kontak tidak boleh kosong.';
    } elseif (!preg_match("/^[0-9]+$/", $_POST['kontak'])) {
        $errors[] = 'Kontak hanya boleh terdiri dari angka.';
    } else {
        $kontak = $_POST['kontak'];
    }

    if (empty($_POST['nik'])) {
        $errors[] = 'NIK tidak boleh kosong.';
    } elseif (!preg_match("/^[0-9]+$/", $_POST['nik'])) {
        $errors[] = 'NIK hanya boleh terdiri dari angka.';
    } else {
        $nik = $_POST['nik'];
    }

    if (empty($_POST['alamat'])) {
        $errors[] = 'Alamat tidak boleh kosong.';
    } else {
        $alamat = filter_var($_POST['alamat'], FILTER_SANITIZE_STRING);
        if ($alamat === "" || strlen($alamat) > 200) {
            $errors[] = 'Alamat maksimal 200 karakter.';
        }
    }

    if (empty($_POST['deskripsi'])) {
        $errors[] = 'Deskripsi tidak boleh kosong.';
    } else {
        $deskripsi = filter_var($_POST['deskripsi'], FILTER_SANITIZE_STRING);
        if ($deskripsi === "" || strlen($deskripsi) > 200) {
            $errors[] = 'Deskripsi maksimal 200 karakter.';
        }
    }

    if (empty($_POST['captcha'])) {
        $errors[] = 'Kode captcha tidak boleh kosong.';
    } elseif (md5($_POST['captcha']) !== $_SESSION["code"]) {
        $errors[] = 'Kode captcha yang Anda masukkan tidak valid.';
    }

    // Validasi Foto
    if (empty($_FILES['foto']['name'])) {
        $errors[] = 'Pas foto tidak boleh kosong.';
    } else {
        $nama_gambar = $_FILES['foto']['name'];
        $ukuran_gambar = $_FILES['foto']['size'];
        $tipe_gambar = $_FILES['foto']['type'];
        $tmp_gambar = $_FILES['foto']['tmp_name'];

        // Validasi ukuran file
        if ($ukuran_gambar > 2000000) {
            $errors[] = 'Ukuran file foto tidak boleh lebih dari 2 MB.';
        }

        // Validasi tipe file
        $allowed_types = ["image/jpeg", "image/jpg", "image/png", "image/gif"];
        if (!in_array($tipe_gambar, $allowed_types)) {
            $errors[] = 'Tipe file foto tidak sesuai (hanya jpeg, jpg, png, gif).';
        }

        // Buat nama file baru
        $ext = pathinfo($nama_gambar, PATHINFO_EXTENSION);
        $NamaFileBaru = uniqid() . '.' . $ext;
        $path = "../../assets/images/PengajuanAkses/" . $NamaFileBaru;
    }

    // Jika ada error, tampilkan
    if (!empty($errors)) {
        echo '<span class="text-danger">' . implode('<br>', $errors) . '</span>';
        exit;
    }

    // Validasi email dan NIK unik
    $stmt = $Conn->prepare("SELECT * FROM akses_pengajuan WHERE email = ? OR nik = ?");
    $stmt->bind_param("ss", $email, $nik);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo '<span class="text-danger">Email atau NIK telah digunakan untuk pengajuan.</span>';
        exit;
    }

    // Upload file
    if (!move_uploaded_file($tmp_gambar, $path)) {
        echo '<span class="text-danger">Gagal mengupload file foto.</span>';
        exit;
    }

    // Simpan Data ke Database
    $stmt = $Conn->prepare("INSERT INTO akses_pengajuan (
        tanggal, nik, nama, kontak, email, alamat, deskripsi, foto, status, keterangan
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Pending', '')");
    $stmt->bind_param(
        "ssssssss",
        $TanggalPengajuan,
        $nik,
        $nama,
        $kontak,
        $email,
        $alamat,
        $deskripsi,
        $NamaFileBaru
    );
    if ($stmt->execute()) {
        $_SESSION['NotifikasiSwal'] = "Tambah Pengajuan Akses Berhasil";
        echo '<span class="text-success" id="NotifikasiPengajuanAksesBerhasil">Success</span>';
    } else {
        echo '<span class="text-danger">Gagal menyimpan data pengajuan.</span>';
    }
?>
