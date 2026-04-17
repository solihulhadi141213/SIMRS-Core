<?php
    header('Content-Type: application/json');

    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

    $response = [
        'status' => 'error',
        'message' => 'Terjadi kesalahan'
    ];

    // ==============================
    // VALIDASI SESSION
    // ==============================
    if (empty($SessionIdAkses)) {
        $response['message'] = 'Session habis';
        echo json_encode($response);
        exit;
    }

    try {

        $id_akses = $_POST['id_akses'] ?? '';
        $fitur    = $_POST['id_akses_fitur'] ?? [];

        if (empty($id_akses)) {
            throw new Exception('ID akses tidak valid');
        }

        // Validasi array fitur
        if (!is_array($fitur) || count($fitur) == 0) {
            throw new Exception('Minimal 1 fitur harus dipilih');
        }

        // ==============================
        // CEK DATA AKSES ADA / TIDAK
        // ==============================
        $stmtCek = $Conn->prepare("SELECT id_akses FROM akses WHERE id_akses=?");
        $stmtCek->bind_param("i", $id_akses);
        $stmtCek->execute();
        $stmtCek->store_result();

        if ($stmtCek->num_rows == 0) {
            throw new Exception('Data akses tidak ditemukan');
        }
        $stmtCek->close();

        // ==============================
        // MULAI TRANSACTION
        // ==============================
        $Conn->begin_transaction();

        // ==============================
        // HAPUS AKSES LAMA
        // ==============================
        $stmtDelete = $Conn->prepare("DELETE FROM akses_acc WHERE id_akses=?");
        $stmtDelete->bind_param("i", $id_akses);

        if (!$stmtDelete->execute()) {
            throw new Exception('Gagal menghapus akses lama');
        }
        $stmtDelete->close();

        // ==============================
        // INSERT AKSES BARU
        // ==============================
        $stmtInsert = $Conn->prepare("
            INSERT INTO akses_acc (id_akses, id_akses_fitur)
            VALUES (?, ?)
        ");

        foreach ($fitur as $id_fitur) {

            // Validasi integer
            if (!is_numeric($id_fitur)) {
                throw new Exception('Data fitur tidak valid');
            }

            $id_fitur = (int)$id_fitur;

            $stmtInsert->bind_param("ii", $id_akses, $id_fitur);

            if (!$stmtInsert->execute()) {
                throw new Exception('Gagal menyimpan akses fitur');
            }
        }

        $stmtInsert->close();

        // ==============================
        // COMMIT
        // ==============================
        $Conn->commit();

        $response['status']  = 'success';
        $response['message'] = 'Ijin akses berhasil diperbarui';

    } catch (Exception $e) {

        // ROLLBACK jika gagal
        if ($Conn->errno === 0) {
            $Conn->rollback();
        }

        $response['message'] = $e->getMessage();
    }

    echo json_encode($response);