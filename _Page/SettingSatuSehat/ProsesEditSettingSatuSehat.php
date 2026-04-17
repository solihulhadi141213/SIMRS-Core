<?php
    header('Content-Type: application/json');
    date_default_timezone_set('Asia/Jakarta');

    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

    $response = [
        'status' => 'error',
        'message' => 'Terjadi kesalahan.'
    ];

    // Validasi session
    if (empty($SessionIdAkses)) {
        $response['message'] = 'Sesi berakhir.';
        echo json_encode($response);
        exit;
    }

    // Validasi method
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $response['message'] = 'Request tidak valid.';
        echo json_encode($response);
        exit;
    }

    try {

        // Ambil data
        $id         = $_POST['id_setting_satusehat'] ?? '';
        $nama       = trim($_POST['nama_setting_satusehat'] ?? '');
        $url        = trim($_POST['url_satusehat'] ?? '');
        $org        = trim($_POST['organization_id'] ?? '');
        $client     = trim($_POST['client_key'] ?? '');
        $secret     = trim($_POST['secret_key'] ?? '');
        $status     = isset($_POST['status']) ? 1 : 0;

        // Validasi
        if (empty($id) || empty($nama) || empty($url) || empty($org) || empty($client) || empty($secret)) {
            $response['message'] = 'Semua field wajib diisi.';
            echo json_encode($response);
            exit;
        }

        // Cek duplikat nama (selain dirinya sendiri)
        $stmtCheck = $Conn->prepare("
            SELECT id_setting_satusehat 
            FROM setting_satusehat 
            WHERE nama_setting_satusehat = ? AND id_setting_satusehat != ?
        ");
        $stmtCheck->bind_param("si", $nama, $id);
        $stmtCheck->execute();
        $stmtCheck->store_result();

        if ($stmtCheck->num_rows > 0) {
            $response['message'] = 'Nama sudah digunakan.';
            echo json_encode($response);
            exit;
        }
        $stmtCheck->close();

        // =============================
        // TRANSACTION (AMAN)
        // =============================
        $Conn->begin_transaction();

        // Jika aktif → nonaktifkan yang lain
        if ($status == 1) {
            $stmtNonaktif = $Conn->prepare("
                UPDATE setting_satusehat 
                SET status_setting_satusehat = 0
                WHERE id_setting_satusehat != ?
            ");
            $stmtNonaktif->bind_param("i", $id);
            $stmtNonaktif->execute();
            $stmtNonaktif->close();
        }

        // Update data
        $stmt = $Conn->prepare("
            UPDATE setting_satusehat SET
                nama_setting_satusehat = ?,
                url_satusehat = ?,
                organization_id = ?,
                client_key = ?,
                secret_key = ?,
                status_setting_satusehat = ?
            WHERE id_setting_satusehat = ?
        ");

        $stmt->bind_param(
            "sssssii",
            $nama,
            $url,
            $org,
            $client,
            $secret,
            $status,
            $id
        );

        if ($stmt->execute()) {

            $Conn->commit();

            $response['status']  = 'success';
            $response['message'] = 'Berhasil diupdate.';

        } else {
            $Conn->rollback();
            $response['message'] = 'Gagal update.';
        }

        $stmt->close();

    } catch (Exception $e) {
        $Conn->rollback();
        $response['message'] = $e->getMessage();
    }

    echo json_encode($response);