<?php
    // ======================================================
    // KONEKSI & SESSION
    // ======================================================
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

    // Time Zone
    date_default_timezone_set('Asia/Jakarta');

    // ======================================================
    // VALIDASI SESSION
    // ======================================================
    if (empty($_SESSION['id_akses'])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Sesi Akses Sudah Berakhir, Silahkan Login Ulang!'
        ]);
        exit;
    }

    // ======================================================
    // AMBIL & SANITASI INPUT
    // ======================================================
    $id_setting_radix = isset($_POST['id_setting_radix']) 
        ? trim(htmlspecialchars($_POST['id_setting_radix'])) 
        : '';

    // ======================================================
    // VALIDASI INPUT
    // ======================================================
    if ($id_setting_radix == '') {
        echo json_encode([
            'status' => 'error',
            'message' => 'ID Setting tidak boleh kosong!'
        ]);
        exit;
    }

    // ======================================================
    // MULAI TRANSAKSI
    // ======================================================
    $Conn->begin_transaction();

    try {

        // ======================================================
        // CEK DATA ADA ATAU TIDAK
        // ======================================================
        $sql_check = "SELECT id_setting_radix FROM setting_radix WHERE id_setting_radix = ?";
        $stmt_check = $Conn->prepare($sql_check);

        if (!$stmt_check) {
            throw new Exception('Gagal menyiapkan query validasi data!');
        }

        $stmt_check->bind_param("s", $id_setting_radix);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows == 0) {
            throw new Exception('Data tidak ditemukan atau sudah dihapus!');
        }

        $stmt_check->close();

        // ======================================================
        // PROSES DELETE DATA
        // ======================================================
        $sql_delete = "DELETE FROM setting_radix WHERE id_setting_radix = ?";
        $stmt_delete = $Conn->prepare($sql_delete);

        if (!$stmt_delete) {
            throw new Exception('Gagal menyiapkan query hapus data!');
        }

        $stmt_delete->bind_param("s", $id_setting_radix);

        if (!$stmt_delete->execute()) {
            throw new Exception('Gagal menghapus data!');
        }

        $stmt_delete->close();

        // ======================================================
        // COMMIT TRANSAKSI
        // ======================================================
        $Conn->commit();

        echo json_encode([
            'status' => 'success',
            'message' => 'Data berhasil dihapus.'
        ]);

    } catch (Exception $e) {

        // Rollback jika error
        $Conn->rollback();

        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
        exit;
    }
?>
