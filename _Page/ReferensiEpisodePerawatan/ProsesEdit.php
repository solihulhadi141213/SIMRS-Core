<?php
    // =========================================================
    // HEADER & ERROR REPORTING
    // =========================================================
    header('Content-Type: application/json');
    error_reporting(0);
    ini_set('display_errors', 0);

    // =========================================================
    // CONNECTION, FUNCTION & SESSION
    // =========================================================
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // =========================================================
    // VALIDASI SESSION
    // =========================================================
    if (empty($SessionIdAkses)) {
        echo json_encode([
            "status"  => "error",
            "message" => "Sesi akses sudah berakhir. Silahkan login ulang."
        ]);
        exit;
    }

    // =========================================================
    // TANGKAP & SANITASI DATA
    // =========================================================
    $id_episode_perawatan_kode = validateAndSanitizeInput($_POST['id_episode_perawatan_kode'] ?? '');
    $episode_category          = validateAndSanitizeInput($_POST['episode_category'] ?? '');
    $episode_name              = validateAndSanitizeInput($_POST['episode_name'] ?? '');
    $episode_display           = validateAndSanitizeInput($_POST['episode_display'] ?? '');
    $episode_code              = validateAndSanitizeInput($_POST['episode_code'] ?? '');
    $episode_system            = validateAndSanitizeInput($_POST['episode_system'] ?? '');
    $source                    = validateAndSanitizeInput($_POST['source'] ?? '');
    $status                    = $_POST['status'] ?? '0';

    // =========================================================
    // VALIDASI MANDATORY & ID
    // =========================================================
    if (empty($id_episode_perawatan_kode) || !is_numeric($id_episode_perawatan_kode)) {
        echo json_encode([
            "status"  => "error",
            "message" => "ID referensi episode perawatan tidak valid."
        ]);
        exit;
    }

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

    // =========================================================
    // VALIDASI PANJANG KARAKTER (Maksimal 255)
    // =========================================================
    if (strlen($episode_category) > 255 || strlen($episode_name) > 255 || strlen($episode_display) > 255 || strlen($episode_code) > 255 || strlen($episode_system) > 255 || strlen($source) > 255) {
        echo json_encode([
            "status"  => "error",
            "message" => "Panjang karakter melebihi batas maksimal kolom database (255 karakter)!"
        ]);
        exit;
    }

    // =========================================================
    // VALIDASI DUPLIKAT DATA (Kecuali untuk ID yang sedang diedit)
    // =========================================================
    $checkDuplicate = mysqli_prepare($Conn, "
        SELECT id_episode_perawatan_kode
        FROM episode_perawatan_kode
        WHERE episode_name = ? AND episode_display = ? AND episode_code = ? AND id_episode_perawatan_kode != ?
    ");
    
    if ($checkDuplicate) {
        mysqli_stmt_bind_param($checkDuplicate, "sssi", $episode_name, $episode_display, $episode_code, $id_episode_perawatan_kode);
        mysqli_stmt_execute($checkDuplicate);
        $resultDuplicate = mysqli_stmt_get_result($checkDuplicate);
        $isDuplicate = mysqli_fetch_assoc($resultDuplicate);
        mysqli_stmt_close($checkDuplicate);

        if ($isDuplicate) {
            echo json_encode([
                "status"  => "error",
                "message" => "Data Episode Perawatan tersebut sudah terdaftar pada entri lain!"
            ]);
            exit;
        }
    }

    // Status (Integer 1 atau 0)
    $status = ($status === '1') ? 1 : 0;

    // Data Session untuk Log / Auditor
    $user_id   = (int)$SessionIdAkses;
    $user_name = validateAndSanitizeInput($SessionNama ?? 'Unknown');

    // =========================================================
    // MULAI TRANSACTION
    // =========================================================
    mysqli_begin_transaction($Conn);

    try {
        // Query Update Data
        $query = "UPDATE episode_perawatan_kode SET 
            episode_category = ?,
            episode_name = ?,
            episode_display = ?,
            episode_code = ?,
            episode_system = ?,
            source = ?,
            status = ?
        WHERE id_episode_perawatan_kode = ?";

        $stmt = mysqli_prepare($Conn, $query);

        if (!$stmt) {
            throw new Exception('Prepare statement update episode_perawatan_kode gagal: ' . mysqli_error($Conn));
        }

        // Binding parameter: s=string, i=integer
        mysqli_stmt_bind_param(
            $stmt,
            "ssssssii",
            $episode_category,
            $episode_name,
            $episode_display,
            $episode_code,
            $episode_system,
            $source,
            $status,
            $id_episode_perawatan_kode
        );

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception('Gagal memperbarui data ke episode_perawatan_kode: ' . mysqli_stmt_error($stmt));
        }

        mysqli_stmt_close($stmt);

        // COMMIT TRANSACTION
        mysqli_commit($Conn);

        // Log Aktivitas Perubahan Data
        if (function_exists('SaveLog')) {
            SaveLog(
                $Conn,
                $user_id,
                $user_name,
                'Referensi Episode Perawatan', // category_log
                'Ubah Referensi Episode Perawatan', // title_log
                [
                    'id_episode_perawatan_kode' => $id_episode_perawatan_kode,
                    'episode_category'          => $episode_category,
                    'episode_name'              => $episode_name,
                    'episode_display'           => $episode_display,
                    'episode_code'              => $episode_code,
                    'episode_system'            => $episode_system,
                    'source'                    => $source,
                    'status'                    => $status
                ]
            );
        }

        echo json_encode([
            "status"  => "success",
            "message" => "Ubah Referensi Episode Perawatan Berhasil!"
        ]);

    } catch (Exception $e) {
        // ROLLBACK TRANSACTION JIKA TERJADI ERROR
        mysqli_rollback($Conn);

        echo json_encode([
            "status"  => "error",
            "message" => $e->getMessage()
        ]);
    }
?>