<?php
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    require_once __DIR__ . '/../../vendor/autoload.php';

    header('Content-Type: application/json');

    // Validasi session
    if (empty($SessionIdAkses)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Sesi berakhir'
        ]);
        exit;
    }

    $id_akses_laporan = $_POST['id_akses_laporan'] ?? '';
    $response         = $_POST['response'] ?? '';

    if (empty($id_akses_laporan)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'ID tidak valid'
        ]);
        exit;
    }

    if (empty($response)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Response kosong'
        ]);
        exit;
    }

    // 🔐 Sanitasi HTML response
    $config = HTMLPurifier_Config::createDefault();
    $purifier = new HTMLPurifier($config);
    $response = $purifier->purify($response);

    // Update
    $stmt = $Conn->prepare("
        UPDATE akses_laporan 
        SET response = ?, status = 'Selesai'
        WHERE id_akses_laporan = ?
    ");
    $stmt->bind_param("si", $response, $id_akses_laporan);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal update data'
        ]);
    }

    $stmt->close();