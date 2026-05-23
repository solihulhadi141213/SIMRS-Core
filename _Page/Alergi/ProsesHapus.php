<?php
    header('Content-Type: application/json');

    // Connection, Function & Session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // Time Zone
    date_default_timezone_set('Asia/Jakarta');

    // Default Response
    $response = [
        'status' => 'error',
        'message' => 'Terjadi kesalahan!',
    ];

    try {

        // =========================================================
        // VALIDASI SESSION
        // =========================================================
        if (empty($SessionIdAkses)) {
            throw new Exception("Sesi akses sudah berakhir! Silahkan login ulang.");
        }

        // =========================================================
        // VALIDASI ID ALERGI
        // =========================================================
        if (empty($_POST['id_alergi'])) {
            throw new Exception("ID alergi tidak boleh kosong!");
        }

        // =========================================================
        // SANITASI INPUT
        // =========================================================
        $id_alergi = validateAndSanitizeInput($_POST['id_alergi']);

        // =========================================================
        // CEK DATA ALERGI
        // =========================================================
        $stmt = $Conn->prepare("
            SELECT 
                id_alergi,
                id_kunjungan
            FROM alergi
            WHERE id_alergi = ?
        ");

        if (!$stmt) {
            throw new Exception("Prepare statement gagal: " . $Conn->error);
        }

        $stmt->bind_param("s", $id_alergi);

        if (!$stmt->execute()) {
            throw new Exception("Execute statement gagal: " . $stmt->error);
        }

        $result = $stmt->get_result();
        $Data   = $result->fetch_assoc();

        // Tutup statement
        $stmt->close();

        // Validasi Data
        if (empty($Data)) {
            throw new Exception("Data alergi tidak ditemukan!");
        }

        // Mapping
        $id_kunjungan = $Data['id_kunjungan'];

        // =========================================================
        // HAPUS DATA
        // =========================================================
        $stmt_delete = $Conn->prepare("
            DELETE FROM alergi
            WHERE id_alergi = ?
        ");

        if (!$stmt_delete) {
            throw new Exception("Prepare delete gagal: " . $Conn->error);
        }

        $stmt_delete->bind_param("s", $id_alergi);

        if (!$stmt_delete->execute()) {
            throw new Exception("Gagal menghapus data: " . $stmt_delete->error);
        }

        // Validasi apakah benar-benar terhapus
        if ($stmt_delete->affected_rows <= 0) {
            throw new Exception("Data alergi gagal dihapus!");
        }

        // Tutup statement
        $stmt_delete->close();

        // =========================================================
        // RESPONSE SUCCESS
        // =========================================================
        $response = [
            'status'        => 'success',
            'message'       => 'Data alergi berhasil dihapus.',
            'id_kunjungan'  => $id_kunjungan
        ];

    } catch (Exception $e) {

        // =========================================================
        // RESPONSE ERROR
        // =========================================================
        $response = [
            'status' => 'error',
            'message' => $e->getMessage()
        ];
    }

    // =========================================================
    // OUTPUT JSON
    // =========================================================
    echo json_encode($response, JSON_PRETTY_PRINT);
?>