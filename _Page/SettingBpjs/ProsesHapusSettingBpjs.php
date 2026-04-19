<?php
    header('Content-Type: application/json');

    date_default_timezone_set('Asia/Jakarta');

    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

    $response = [
        'status' => 'error',
        'message' => 'Terjadi kesalahan.'
    ];

    // =============================================
    // VALIDASI SESSION
    // =============================================
    if (empty($SessionIdAkses)) {
        $response['message'] = 'Sesi berakhir, silakan login ulang.';
        echo json_encode($response);
        exit;
    }

    // =============================================
    // VALIDASI METHOD
    // =============================================
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $response['message'] = 'Request tidak valid.';
        echo json_encode($response);
        exit;
    }

    try {

        // =============================================
        // AMBIL DATA
        // =============================================
        $id = intval($_POST['id_setting_bpjs'] ?? 0);

        if (empty($id)) {
            $response['message'] = 'ID tidak valid.';
            echo json_encode($response);
            exit;
        }

        // =============================================
        // CEK DATA
        // =============================================
        $cek = $Conn->prepare("SELECT status FROM setting_bpjs WHERE id_setting_bpjs = ?");
        $cek->bind_param("i", $id);
        $cek->execute();
        $result = $cek->get_result();

        if ($result->num_rows == 0) {
            $response['message'] = 'Data tidak ditemukan.';
            echo json_encode($response);
            exit;
        }

        $data = $result->fetch_assoc();

        // =============================================
        // PROTEKSI: JANGAN HAPUS YANG AKTIF
        // =============================================
        if ($data['status'] == 1) {
            $response['message'] = 'Tidak dapat menghapus pengaturan yang sedang aktif.';
            echo json_encode($response);
            exit;
        }

        // =============================================
        // DELETE DATA
        // =============================================
        $stmt = $Conn->prepare("DELETE FROM setting_bpjs WHERE id_setting_bpjs = ?");
        $stmt->bind_param("i", $id);

        if (!$stmt->execute()) {
            throw new Exception("Gagal menghapus data.");
        }

        // =============================================
        // SUCCESS
        // =============================================
        $response['status']  = 'success';
        $response['message'] = 'Data berhasil dihapus.';

        $stmt->close();

    } catch (Exception $e) {
        $response['message'] = $e->getMessage();
    }

    echo json_encode($response);
?>