<?php
    // Koneksi dan Function
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

    // Time Zone
    date_default_timezone_set('Asia/Jakarta');
    $now = date('Y-m-d H:i:s');

    // Validasi Session Akses
    if(empty($_SESSION['id_akses'])){
        echo json_encode([
            'status' => 'error',
            'message' => 'Sesi Akses Sudah Berakhir, Silahkan Login Ulang!'
        ]);
        exit;
    }

    // ==========================
    // AMBIL & SANITASI INPUT
    // ==========================
    $id_setting_radix = isset($_POST['id_setting_radix']) 
        ? (int) $_POST['id_setting_radix'] 
        : 0;

    $setting_name = isset($_POST['setting_name']) 
        ? trim(htmlspecialchars($_POST['setting_name'])) 
        : '';

    $base_url = isset($_POST['base_url']) 
        ? trim(htmlspecialchars($_POST['base_url'])) 
        : '';

    $setting_username = isset($_POST['setting_username']) 
        ? trim(htmlspecialchars($_POST['setting_username'])) 
        : '';

    $setting_password = isset($_POST['setting_password']) 
        ? trim(htmlspecialchars($_POST['setting_password'])) 
        : '';

    $setting_status = isset($_POST['setting_status']) 
        ? (int) $_POST['setting_status'] 
        : 0;

    // ==========================
    // VALIDASI INPUT
    // ==========================

    // ID wajib
    if ($id_setting_radix <= 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'ID setting tidak valid!'
        ]);
        exit;
    }

    // Nama koneksi
    if ($setting_name == '') {
        echo json_encode([
            'status' => 'error',
            'message' => 'Nama koneksi tidak boleh kosong!'
        ]);
        exit;
    }

    // URL
    if ($base_url == '') {
        echo json_encode([
            'status' => 'error',
            'message' => 'URL API tidak boleh kosong!'
        ]);
        exit;
    }

    if (!filter_var($base_url, FILTER_VALIDATE_URL)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Format URL PACS tidak valid!'
        ]);
        exit;
    }

    // Username
    if ($setting_username == '') {
        echo json_encode([
            'status' => 'error',
            'message' => 'Username tidak boleh kosong!'
        ]);
        exit;
    }

    // Password (opsional update)
    if ($setting_password == '') {
        echo json_encode([
            'status' => 'error',
            'message' => 'Password tidak boleh kosong!'
        ]);
        exit;
    }

    // ==========================
    // CEK DATA ADA ATAU TIDAK
    // ==========================
    $check = $Conn->prepare("SELECT id_setting_radix FROM setting_radix WHERE id_setting_radix = ?");
    $check->bind_param("i", $id_setting_radix);
    $check->execute();
    $check->store_result();

    if ($check->num_rows == 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Data setting tidak ditemukan!'
        ]);
        exit;
    }
    $check->close();

    // ==========================
    // TRANSAKSI DATABASE
    // ==========================
    $Conn->begin_transaction();

    try {

        // ==========================
        // NONAKTIFKAN SEMUA KONEKSI LAIN JIKA STATUS = 1
        // ==========================
        if ($setting_status == 1) {
            $sql_deactivate = "UPDATE setting_radix SET status = 0 WHERE id_setting_radix != ?";
            $stmt_deactivate = $Conn->prepare($sql_deactivate);

            if (!$stmt_deactivate) {
                throw new Exception('Gagal menyiapkan query untuk menonaktifkan koneksi lain!');
            }

            $stmt_deactivate->bind_param("i", $id_setting_radix);

            if (!$stmt_deactivate->execute()) {
                throw new Exception('Gagal menonaktifkan koneksi lain!');
            }

            $stmt_deactivate->close();
        }

        // ==========================
        // UPDATE DATA
        // ==========================
        $sql_update = "
            UPDATE setting_radix 
            SET 
                setting_name = ?,
                base_url = ?,
                username = ?,
                password = ?,
                status = ?
            WHERE id_setting_radix = ?
        ";

        $stmt_update = $Conn->prepare($sql_update);

        if (!$stmt_update) {
            throw new Exception('Gagal menyiapkan query update!');
        }

        $stmt_update->bind_param(
            "ssssii",
            $setting_name,
            $base_url,
            $setting_username,
            $setting_password,
            $setting_status,
            $id_setting_radix
        );

        if (!$stmt_update->execute()) {
            throw new Exception('Gagal memperbarui data ke database!');
        }

        $stmt_update->close();

        // Commit jika sukses
        $Conn->commit();

        echo json_encode([
            'status' => 'success',
            'message' => 'Koneksi berhasil diperbarui.'
        ]);

    } catch (Exception $e) {

        // Rollback jika error
        $Conn->rollback();

        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
?>
