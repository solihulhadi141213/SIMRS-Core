<?php
    header('Content-Type: application/json');

    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

    $response = [
        'status' => 'error',
        'message' => 'Terjadi kesalahan'
    ];

    if (empty($SessionIdAkses)) {
        $response['message'] = 'Session habis';
        echo json_encode($response);
        exit;
    }

    try {

        $Conn->begin_transaction();

        // =============================
        // INPUT
        // =============================
        $id_akses          = (int) ($_POST['id_akses'] ?? 0);
        $nama              = trim($_POST['nama'] ?? '');
        $nik               = trim($_POST['nik'] ?? '');
        $ihs               = trim($_POST['ihs'] ?? '');
        $email             = trim($_POST['email'] ?? '');
        $kontak            = trim($_POST['kontak'] ?? '');
        $id_akses_entitas  = (int) ($_POST['id_akses_entitas'] ?? 0);
        $password          = $_POST['password'] ?? '';

        if (
            empty($id_akses) ||
            empty($nama) ||
            empty($nik) ||
            empty($email) ||
            empty($kontak) ||
            empty($id_akses_entitas)
        ) {
            throw new Exception('Data wajib tidak boleh kosong');
        }

        // =============================
        // CEK DATA LAMA
        // =============================
        $stmtOld = $Conn->prepare("SELECT gambar, id_akses_entitas FROM akses WHERE id_akses=?");
        $stmtOld->bind_param("i", $id_akses);
        $stmtOld->execute();
        $oldData = $stmtOld->get_result()->fetch_assoc();
        $stmtOld->close();

        if (!$oldData) {
            throw new Exception('Data tidak ditemukan');
        }

        $gambar_lama = $oldData['gambar'];
        $entitas_lama = $oldData['id_akses_entitas'];

        // =============================
        // VALIDASI DUPLIKAT
        // =============================
        function cekDuplikat($Conn, $field, $value, $id_akses){
            $stmt = $Conn->prepare("SELECT id_akses FROM akses WHERE $field = ? AND id_akses != ?");
            $stmt->bind_param("si", $value, $id_akses);
            $stmt->execute();
            $stmt->store_result();
            $ada = $stmt->num_rows > 0;
            $stmt->close();
            return $ada;
        }

        if (cekDuplikat($Conn, 'nik', $nik, $id_akses)) {
            throw new Exception('NIK sudah digunakan');
        }

        if (!empty($ihs) && cekDuplikat($Conn, 'ihs', $ihs, $id_akses)) {
            throw new Exception('IHS sudah digunakan');
        }

        if (cekDuplikat($Conn, 'email', $email, $id_akses)) {
            throw new Exception('Email sudah digunakan');
        }

        if (cekDuplikat($Conn, 'kontak', $kontak, $id_akses)) {
            throw new Exception('Kontak sudah digunakan');
        }

        // =============================
        // AMBIL ROLE
        // =============================
        $stmtRole = $Conn->prepare("SELECT akses FROM akses_entitas WHERE id_akses_entitas=?");
        $stmtRole->bind_param("i", $id_akses_entitas);
        $stmtRole->execute();
        $role = $stmtRole->get_result()->fetch_assoc();
        $stmtRole->close();

        if (!$role) {
            throw new Exception('Entitas tidak valid');
        }

        $akses = $role['akses'];

        // =============================
        // HANDLE GAMBAR
        // =============================
        $nama_file_gambar = $gambar_lama;

        if (!empty($_FILES['gambar']['name'])) {

            $file = $_FILES['gambar'];

            $ext  = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $mime = mime_content_type($file['tmp_name']);

            $allowedExt  = ['jpg','jpeg','png','gif'];
            $allowedMime = ['image/jpeg','image/png','image/gif'];

            if (!in_array($ext, $allowedExt)) {
                throw new Exception('Format gambar tidak valid');
            }

            if (!in_array($mime, $allowedMime)) {
                throw new Exception('Mime type tidak valid');
            }

            if ($file['size'] > 2 * 1024 * 1024) {
                throw new Exception('Ukuran gambar maksimal 2MB');
            }

            $nama_file_gambar = bin2hex(random_bytes(16)) . '.' . $ext;
            $path = "../../assets/images/user/" . $nama_file_gambar;

            if (!move_uploaded_file($file['tmp_name'], $path)) {
                throw new Exception('Gagal upload gambar');
            }

            if (!empty($gambar_lama) && file_exists("../../assets/images/user/".$gambar_lama)) {
                unlink("../../assets/images/user/".$gambar_lama);
            }
        }

        $ihs = !empty($ihs) ? $ihs : NULL;
        $updatetime = date('Y-m-d H:i:s');

        // =============================
        // UPDATE AKSES
        // =============================
        if (!empty($password)) {

            if (strlen($password) < 8 || strlen($password) > 20) {
                throw new Exception('Password harus 8-20 karakter');
            }

            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $Conn->prepare("
                UPDATE akses SET
                    nama=?,
                    nik=?,
                    ihs=?,
                    email=?,
                    kontak=?,
                    id_akses_entitas=?,
                    akses=?,
                    password=?,
                    gambar=?,
                    updatetime=?
                WHERE id_akses=?
            ");

            $stmt->bind_param(
                "ssssssssssi",
                $nama,
                $nik,
                $ihs,
                $email,
                $kontak,
                $id_akses_entitas,
                $akses,
                $password_hash,
                $nama_file_gambar,
                $updatetime,
                $id_akses
            );

        } else {

            $stmt = $Conn->prepare("
                UPDATE akses SET
                    nama=?,
                    nik=?,
                    ihs=?,
                    email=?,
                    kontak=?,
                    id_akses_entitas=?,
                    akses=?,
                    gambar=?,
                    updatetime=?
                WHERE id_akses=?
            ");

            $stmt->bind_param(
                "sssssssssi",
                $nama,
                $nik,
                $ihs,
                $email,
                $kontak,
                $id_akses_entitas,
                $akses,
                $nama_file_gambar,
                $updatetime,
                $id_akses
            );
        }

        if (!$stmt->execute()) {
            throw new Exception('Gagal update data');
        }

        $stmt->close();

        // =============================
        // JIKA ENTITAS BERUBAH → RESET AKSES
        // =============================
        if ($entitas_lama != $id_akses_entitas) {

            // Hapus akses lama
            $stmtDel = $Conn->prepare("DELETE FROM akses_acc WHERE id_akses=?");
            $stmtDel->bind_param("i", $id_akses);
            $stmtDel->execute();
            $stmtDel->close();

            // Ambil akses default dari entitas
            $stmtFitur = $Conn->prepare("
                SELECT id_akses_fitur 
                FROM akses_entitas_acc 
                WHERE id_akses_entitas=?
            ");
            $stmtFitur->bind_param("i", $id_akses_entitas);
            $stmtFitur->execute();
            $resultFitur = $stmtFitur->get_result();

            if ($resultFitur->num_rows > 0) {

                $stmtInsert = $Conn->prepare("
                    INSERT INTO akses_acc (id_akses, id_akses_fitur)
                    VALUES (?, ?)
                ");

                while ($row = $resultFitur->fetch_assoc()) {
                    $id_fitur = $row['id_akses_fitur'];

                    $stmtInsert->bind_param("ii", $id_akses, $id_fitur);

                    if (!$stmtInsert->execute()) {
                        throw new Exception('Gagal set ulang akses fitur');
                    }
                }

                $stmtInsert->close();
            }

            $stmtFitur->close();
        }

        $Conn->commit();

        $response['status']  = 'success';
        $response['message'] = 'Data berhasil diperbarui';

    } catch (Exception $e) {

        $Conn->rollback();
        $response['message'] = $e->getMessage();
    }

    echo json_encode($response);