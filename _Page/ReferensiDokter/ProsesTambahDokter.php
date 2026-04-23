<?php
    header('Content-Type: application/json');
    date_default_timezone_set('Asia/Jakarta');

    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    $response = [
        'status' => 'error',
        'message' => 'Terjadi kesalahan.'
    ];

    // Validasi session
    if (empty($SessionIdAkses)) {
        $response['message'] = 'Sesi akses berakhir, silakan login ulang.';
        echo json_encode($response);
        exit;
    }

    // Validasi method
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $response['message'] = 'Metode request tidak valid.';
        echo json_encode($response);
        exit;
    }

    // Ambil input
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

    // VALIDASI
    if ($kode === '') {
        exit(json_encode(['status'=>'error','message'=>'Kode dokter tidak boleh kosong']));
    }

    if ($nama === '') {
        exit(json_encode(['status'=>'error','message'=>'Nama dokter tidak boleh kosong']));
    }

    if ($gender === '') {
        exit(json_encode(['status'=>'error','message'=>'Gender tidak boleh kosong']));
    }

    if ($tanggal_lahir === '') {
        exit(json_encode(['status'=>'error','message'=>'Tanggal lahir tidak boleh kosong']));
    }

    if ($kategori === '') {
        exit(json_encode(['status'=>'error','message'=>'Kategori tidak boleh kosong']));
    }

    if ($no_identitas === '') {
        exit(json_encode(['status'=>'error','message'=>'Nomor identitas tidak boleh kosong']));
    }

    if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        exit(json_encode(['status'=>'error','message'=>'Format email tidak valid']));
    }

    try {

        // CEK DUPLIKAT KODE
        $stmt = mysqli_prepare($Conn, "SELECT id_dokter FROM dokter WHERE kode=?");
        mysqli_stmt_bind_param($stmt, "s", $kode);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            exit(json_encode(['status'=>'error','message'=>'Kode dokter sudah digunakan']));
        }
        mysqli_stmt_close($stmt);

        // CEK DUPLIKAT IHS
        if ($id_ihs_practitioner !== '') {
            $stmt = mysqli_prepare($Conn, "SELECT id_dokter FROM dokter WHERE id_ihs_practitioner=?");
            mysqli_stmt_bind_param($stmt, "s", $id_ihs_practitioner);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result && mysqli_num_rows($result) > 0) {
                exit(json_encode(['status'=>'error','message'=>'ID Practitioner sudah digunakan']));
            }
            mysqli_stmt_close($stmt);
        } else {
            $id_ihs_practitioner = null;
        }

        // =============================
        // UPLOAD FOTO (OPTIONAL)
        // =============================
        $foto = null;

        if (!empty($_FILES['foto']['name'])) {

            $fileTmp  = $_FILES['foto']['tmp_name'];
            $fileSize = $_FILES['foto']['size'];

            // Max 2MB
            if ($fileSize > 2 * 1024 * 1024) {
                exit(json_encode(['status'=>'error','message'=>'Ukuran foto maksimal 2MB']));
            }

            // Validasi MIME TYPE (AMAN)
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime  = finfo_file($finfo, $fileTmp);
            finfo_close($finfo);

            $allowedMime = [
                'image/jpeg' => 'jpg',
                'image/png'  => 'png',
                'image/gif'  => 'gif'
            ];

            if (!array_key_exists($mime, $allowedMime)) {
                exit(json_encode(['status'=>'error','message'=>'Format file tidak valid']));
            }

            // Generate nama file random
            $ext  = $allowedMime[$mime];
            $foto = bin2hex(random_bytes(16)) . '.' . $ext;

            $uploadPath = "../../assets/images/Dokter/" . $foto;

            if (!move_uploaded_file($fileTmp, $uploadPath)) {
                exit(json_encode(['status'=>'error','message'=>'Gagal upload foto']));
            }
        }

        // =============================
        // INSERT DATA
        // =============================
        $kategori_identitas ="KTP";
        $stmt = mysqli_prepare($Conn, "
            INSERT INTO dokter (
                id_ihs_practitioner,
                kode,
                nama,
                gender,
                tanggal_lahir,
                kategori,
                kategori_identitas,
                no_identitas,
                alamat,
                kontak,
                email,
                SIP,
                status,
                foto
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        if (!$stmt) {
            throw new Exception('Gagal prepare insert');
        }

        mysqli_stmt_bind_param(
            $stmt,
            "ssssssssssssis",
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
            $foto
        );

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception('Gagal menyimpan data dokter');
        }

        mysqli_stmt_close($stmt);

        echo json_encode([
            'status' => 'success',
            'message' => 'Data dokter berhasil disimpan'
        ]);

    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }