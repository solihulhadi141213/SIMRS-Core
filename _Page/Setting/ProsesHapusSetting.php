<?php
    header('Content-Type: application/json');
    date_default_timezone_set('Asia/Jakarta');

    // Connection
    include "../../_Config/Connection.php";

    // Session
    include "../../_Config/Session.php";

    // ======================================
    // VALIDASI SESSION
    // ======================================
    if (empty($SessionIdAkses)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Sesi akses sudah berakhir.'
        ]);
        exit;
    }
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode([
            'status' => 'error',
            'message' => 'Metode request tidak valid.'
        ]);
        exit;
    }

    // ======================================
    // VALIDASI ID
    // ======================================
    $id_setting = filter_input(INPUT_POST, 'id_setting', FILTER_VALIDATE_INT);
    if (!$id_setting || $id_setting < 1) {
        echo json_encode([
            'status' => 'error',
            'message' => 'ID setting tidak valid.'
        ]);
        exit;
    }

    // ======================================
    // AMBIL DATA FILE LAMA
    // ======================================
    $stmt = $Conn->prepare("SELECT logo FROM setting WHERE id_setting = ?");
    $stmt->bind_param("i", $id_setting);
    $stmt->execute();

    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if (!$data) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Data setting tidak ditemukan.'
        ]);
        exit;
    }

    $logo = $data['logo'] ?? '';

    $stmt->close();

    // ======================================
    // HAPUS DATABASE
    // ======================================
    $stmtDelete = $Conn->prepare("DELETE FROM setting WHERE id_setting = ?");
    $stmtDelete->bind_param("i", $id_setting);

    $delete = $stmtDelete->execute();

    if ($delete) {
        if (!empty($logo)) {
            $logoName = basename((string) $logo);
            foreach ([
                __DIR__ . '/../../assets/img/logo/' . $logoName,
                __DIR__ . '/../../assets/images/' . $logoName,
                __DIR__ . '/../../_File/Setting/' . $logoName,
            ] as $logoPath) {
                if (is_file($logoPath)) {
                    unlink($logoPath);
                }
            }
        }

        echo json_encode([
            'status' => 'success',
            'message' => 'Data berhasil dihapus.'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal menghapus data.'
        ]);
    }
?>