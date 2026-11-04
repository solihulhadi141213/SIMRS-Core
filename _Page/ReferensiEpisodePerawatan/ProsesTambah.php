<?php
    // Header JSON
    header('Content-Type: application/json');

    // Connection, Function & Session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // Validasi Session
    if (empty($SessionIdAkses)) {
        echo json_encode([
            "status"  => "error",
            "message" => "Sesi akses sudah berakhir. Silahkan login ulang."
        ]);
        exit;
    }

    // Tangkap Data
    $episode_category  = validateAndSanitizeInput($_POST['episode_category'] ?? '');
    $episode_name      = validateAndSanitizeInput($_POST['episode_name'] ?? '');
    $episode_display   = validateAndSanitizeInput($_POST['episode_display'] ?? '');
    $episode_code      = validateAndSanitizeInput($_POST['episode_code'] ?? '');
    $episode_system    = validateAndSanitizeInput($_POST['episode_system'] ?? '');
    $source            = validateAndSanitizeInput($_POST['source'] ?? '');
    $status            = $_POST['status'] ?? '0';

    // Validasi Mandatory
    if (empty($episode_category)) {
        echo json_encode([
            "status"  => "error",
            "message" => "Kategori Episode Perawatan Tidak Boleh Kosong!"
        ]);
        exit;
    }

    if (empty($episode_name)) {
        echo json_encode([
            "status"  => "error",
            "message" => "Nama Episode Perawatan Tidak Boleh Kosong!"
        ]);
        exit;
    }

    if (empty($episode_display)) {
        echo json_encode([
            "status"  => "error",
            "message" => "Display Episode Perawatan Tidak Boleh Kosong!"
        ]);
        exit;
    }

    if (empty($episode_system)) {
        echo json_encode([
            "status"  => "error",
            "message" => "Referensi (System) Episode Perawatan Tidak Boleh Kosong!"
        ]);
        exit;
    }

    if (empty($source)) {
        echo json_encode([
            "status"  => "error",
            "message" => "Sumber Referensi Tidak Boleh Kosong!"
        ]);
        exit;
    }

    // Validasi Panjang Karakter (Maksimal 255)
    if (strlen($episode_category) > 255 || strlen($episode_name) > 255 || strlen($episode_display) > 255 || strlen($episode_code) > 255 || strlen($episode_system) > 255 || strlen($source) > 255) {
        echo json_encode([
            "status"  => "error",
            "message" => "Panjang karakter melebihi batas maksimal kolom database (255 karakter)!"
        ]);
        exit;
    }

    // Validasi Duplikat Data
    $checkDuplicate = mysqli_prepare($Conn, "
        SELECT id_episode_perawatan_kode
        FROM episode_perawatan_kode
        WHERE episode_name = ? AND episode_display = ? AND episode_code = ?
    ");
    
    if ($checkDuplicate) {
        mysqli_stmt_bind_param($checkDuplicate, "sss", $episode_name, $episode_display, $episode_code);
        mysqli_stmt_execute($checkDuplicate);
        $resultDuplicate = mysqli_stmt_get_result($checkDuplicate);
        $isDuplicate = mysqli_fetch_assoc($resultDuplicate);
        mysqli_stmt_close($checkDuplicate);

        if ($isDuplicate) {
            echo json_encode([
                "status"  => "error",
                "message" => "Data Episode Perawatan tersebut sudah terdaftar!"
            ]);
            exit;
        }
    }

    // Status (Integer 1 atau 0)
    $status = ($status === '1') ? 1 : 0;

    // Datetime & Session Data
    $creat_at      = date('Y-m-d H:i:s');
    $creat_by_id   = (int)$SessionIdAkses;
    $creat_by_name = validateAndSanitizeInput($SessionNama ?? 'Unknown');

    // ==========================
    // MULAI TRANSACTION
    // ==========================
    mysqli_begin_transaction($Conn);

    try {
        // PREPARE STATEMENT SESUAI STRUKTUR TABEL BARU
        $query = "INSERT INTO episode_perawatan_kode (
            episode_category,
            episode_name,
            episode_display,
            episode_code,
            episode_system,
            source,
            status,
            creat_by_id,
            creat_by_name,
            creat_at
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($Conn, $query);

        if (!$stmt) {
            throw new Exception('Prepare statement episode_perawatan_kode gagal: ' . mysqli_error($Conn));
        }

        // Binding parameter: s=string, i=integer
        mysqli_stmt_bind_param(
            $stmt,
            "ssssssiiss",
            $episode_category,
            $episode_name,
            $episode_display,
            $episode_code,
            $episode_system,
            $source,
            $status,
            $creat_by_id,
            $creat_by_name,
            $creat_at
        );

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception('Gagal insert data ke episode_perawatan_kode: ' . mysqli_stmt_error($stmt));
        }

        mysqli_stmt_close($stmt);

        // COMMIT TRANSACTION
        mysqli_commit($Conn);

        // Log aktivitas penambahan data (Menyesuaikan dengan kolom category_log pada tabel log)
        if (function_exists('SaveLog')) {
            SaveLog(
                $Conn,
                $creat_by_id,
                $creat_by_name,
                'Referensi Episode Perawatan', // category_log
                'Tambah Referensi Episode Perawatan', // title_log
                [
                    'episode_category' => $episode_category,
                    'episode_name'     => $episode_name,
                    'episode_display'  => $episode_display,
                    'episode_code'     => $episode_code,
                    'episode_system'   => $episode_system,
                    'source'           => $source
                ]
            );
        }

        echo json_encode([
            "status"  => "success",
            "message" => "Tambah Referensi Episode Perawatan Berhasil!"
        ]);

    } catch (Exception $e) {
        // ROLLBACK TRANSACTION JIKA ADA ERROR
        mysqli_rollback($Conn);

        echo json_encode([
            "status"  => "error",
            "message" => $e->getMessage()
        ]);
    }
?>