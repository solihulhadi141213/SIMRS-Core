<?php
    header('Content-Type: application/json');
    date_default_timezone_set('Asia/Jakarta');

    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

    $response = [
        'status' => 'error',
        'message' => 'Terjadi kesalahan.'
    ];

    if (empty($SessionIdAkses)) {
        $response['message'] = 'Sesi berakhir.';
        echo json_encode($response);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $response['message'] = 'Request tidak valid.';
        echo json_encode($response);
        exit;
    }

    try {

        // ==============================
        // MULAI TRANSACTION
        // ==============================
        $Conn->begin_transaction();

        // ==============================
        // INPUT
        // ==============================
        $nama       = trim($_POST['nama'] ?? '');
        $nik        = trim($_POST['nik'] ?? '');
        $ihs        = trim($_POST['ihs'] ?? '');
        $email      = trim($_POST['email'] ?? '');
        $kontak     = trim($_POST['kontak'] ?? '');
        $id_entitas = $_POST['id_akses_entitas'] ?? '';
        $password   = $_POST['password'] ?? '';

        if (
            empty($nama) || empty($nik) || empty($email) ||
            empty($kontak) || empty($id_entitas) || empty($password)
        ) {
            throw new Exception('Semua field wajib diisi.');
        }

        if (strlen($password) < 8 || strlen($password) > 20) {
            throw new Exception('Password harus 8-20 karakter.');
        }

        // ==============================
        // VALIDASI DUPLIKAT (ringkas)
        // ==============================
        function cek($Conn, $field, $value){
            $stmt = $Conn->prepare("SELECT id_akses FROM akses WHERE $field=?");
            $stmt->bind_param("s", $value);
            $stmt->execute();
            $stmt->store_result();
            $ada = $stmt->num_rows > 0;
            $stmt->close();
            return $ada;
        }

        if (cek($Conn, 'nik', $nik)) throw new Exception('NIK sudah terdaftar.');
        if (!empty($ihs) && cek($Conn, 'ihs', $ihs)) throw new Exception('IHS sudah digunakan.');
        if (cek($Conn, 'email', $email)) throw new Exception('Email sudah terdaftar.');
        if (cek($Conn, 'kontak', $kontak)) throw new Exception('Kontak sudah digunakan.');

        // ==============================
        // ENTITAS
        // ==============================
        $stmtEntitas = $Conn->prepare("SELECT akses FROM akses_entitas WHERE id_akses_entitas=?");
        $stmtEntitas->bind_param("i", $id_entitas);
        $stmtEntitas->execute();
        $dataEntitas = $stmtEntitas->get_result()->fetch_assoc();
        $stmtEntitas->close();

        if (!$dataEntitas) {
            throw new Exception('Entitas akses tidak valid.');
        }

        $akses = $dataEntitas['akses'];

        // ==============================
        // UPLOAD GAMBAR
        // ==============================
        if (!isset($_FILES['gambar']) || $_FILES['gambar']['error'] !== 0) {
            throw new Exception('Upload gambar gagal.');
        }

        $file = $_FILES['gambar'];
        $ext  = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        $newFileName = bin2hex(random_bytes(10)) . '.' . $ext;
        $uploadPath  = "../../assets/images/user/" . $newFileName;

        if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
            throw new Exception('Gagal upload file.');
        }

        // ==============================
        // INSERT AKSES
        // ==============================
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $now = date('Y-m-d H:i:s');

        $stmt = $Conn->prepare("
            INSERT INTO akses (
                id_akses_entitas, tanggal, nama, nik, ihs,
                email, kontak, password, akses, gambar, updatetime
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "issssssssss",
            $id_entitas, $now, $nama, $nik, $ihs,
            $email, $kontak, $passwordHash, $akses, $newFileName, $now
        );

        if (!$stmt->execute()) {
            throw new Exception('Gagal insert akses.');
        }

        $id_akses_baru = $stmt->insert_id;
        $stmt->close();

        // ==============================
        // COPY AKSES (SUPER OPTIMAL)
        // ==============================
        $stmtCopy = $Conn->prepare("
            INSERT INTO akses_acc (id_akses, id_akses_fitur)
            SELECT ?, id_akses_fitur
            FROM akses_entitas_acc
            WHERE id_akses_entitas = ?
        ");

        $stmtCopy->bind_param("ii", $id_akses_baru, $id_entitas);

        if (!$stmtCopy->execute()) {
            throw new Exception('Gagal copy akses.');
        }

        $stmtCopy->close();

        // ==============================
        // COMMIT
        // ==============================
        $Conn->commit();

        $response['status']  = 'success';
        $response['message'] = 'Data berhasil ditambahkan.';

    } catch (Exception $e) {

        // ==============================
        // ROLLBACK
        // ==============================
        $Conn->rollback();

        // OPTIONAL: hapus file kalau sudah terupload
        if (!empty($newFileName) && file_exists("../../assets/images/user/" . $newFileName)) {
            unlink("../../assets/images/user/" . $newFileName);
        }

        $response['message'] = $e->getMessage();
    }

    echo json_encode($response);