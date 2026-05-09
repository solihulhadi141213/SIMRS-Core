<?php
    // =========================================================
    // HEADER JSON
    // =========================================================
    header('Content-Type: application/json');

    // =========================================================
    // CONNECTION, FUNCTION & SESSION
    // =========================================================
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // =========================================================
    // RESPONSE DEFAULT
    // =========================================================
    $response = [
        'status'  => 'error',
        'message' => 'Terjadi kesalahan.'
    ];

    // =========================================================
    // VALIDASI SESSION
    // =========================================================
    if (empty($SessionIdAkses)) {

        $response['message'] = 'Sesi akses sudah berakhir. Silahkan login ulang.';
        echo json_encode($response);
        exit;
    }

    // =========================================================
    // VALIDASI ID PASIEN
    // =========================================================
    if (empty($_POST['id_pasien'])) {

        $response['message'] = 'ID pasien tidak boleh kosong.';
        echo json_encode($response);
        exit;
    }

    // =========================================================
    // VALIDASI CHECKLIST PERNYATAAN
    // =========================================================
    if (empty($_POST['pernyataan_petugas_penghapus'])) {

        $response['message'] = 'Checklist pernyataan petugas wajib dicentang.';
        echo json_encode($response);
        exit;
    }

    // =========================================================
    // SANITASI INPUT
    // =========================================================
    $id_pasien = validateAndSanitizeInput($_POST['id_pasien']);

    // =========================================================
    // CEK DATA PASIEN
    // =========================================================
    $query_pasien = "
        SELECT *
        FROM pasien
        WHERE id_pasien = ?
        LIMIT 1
    ";

    $stmt_pasien = mysqli_prepare($Conn, $query_pasien);

    if (!$stmt_pasien) {

        $response['message'] = 'Gagal mempersiapkan query pasien.';
        echo json_encode($response);
        exit;
    }

    mysqli_stmt_bind_param($stmt_pasien, "i", $id_pasien);

    if (!mysqli_stmt_execute($stmt_pasien)) {

        $response['message'] = 'Gagal menjalankan query pasien.';
        echo json_encode($response);
        exit;
    }

    $result_pasien = mysqli_stmt_get_result($stmt_pasien);

    // =========================================================
    // VALIDASI DATA PASIEN
    // =========================================================
    if (mysqli_num_rows($result_pasien) == 0) {

        $response['message'] = 'Data pasien tidak ditemukan.';
        echo json_encode($response);
        exit;
    }

    // =========================================================
    // FETCH DATA PASIEN
    // =========================================================
    $data_pasien = mysqli_fetch_assoc($result_pasien);

    // =========================================================
    // CONVERT JSON METADATA
    // =========================================================
    $metadata_log = json_encode(
        $data_pasien,
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
    );

    // =========================================================
    // MULAI TRANSACTION
    // =========================================================
    mysqli_begin_transaction($Conn);

    try {

        // =====================================================
        // SIMPAN LOG
        // =====================================================
        $title_log   = "Hapus Data Pasien {$id_pasien}";
        $datetime_log = date('Y-m-d H:i:s');

        $query_log = "
            INSERT INTO log (
                id_akses,
                datetime_log,
                nama_petugas,
                title_log,
                metadata_log
            ) VALUES (?, ?, ?, ?, ?)
        ";

        $stmt_log = mysqli_prepare($Conn, $query_log);

        if (!$stmt_log) {
            throw new Exception('Gagal mempersiapkan query log.');
        }

        mysqli_stmt_bind_param(
            $stmt_log,
            "issss",
            $SessionIdAkses,
            $datetime_log,
            $SessionNama,
            $title_log,
            $metadata_log
        );

        if (!mysqli_stmt_execute($stmt_log)) {
            throw new Exception('Gagal menyimpan log penghapusan.');
        }

        // =====================================================
        // HAPUS DATA PASIEN
        // =====================================================
        $query_delete = "
            DELETE FROM pasien
            WHERE id_pasien = ?
        ";

        $stmt_delete = mysqli_prepare($Conn, $query_delete);

        if (!$stmt_delete) {
            throw new Exception('Gagal mempersiapkan query hapus pasien.');
        }

        mysqli_stmt_bind_param($stmt_delete, "i", $id_pasien);

        if (!mysqli_stmt_execute($stmt_delete)) {
            throw new Exception('Gagal menghapus data pasien.');
        }

        // =====================================================
        // VALIDASI ROW AFFECTED
        // =====================================================
        if (mysqli_stmt_affected_rows($stmt_delete) == 0) {
            throw new Exception('Data pasien gagal dihapus.');
        }

        // =====================================================
        // COMMIT
        // =====================================================
        mysqli_commit($Conn);

        $response = [
            'status'  => 'success',
            'message' => 'Data pasien berhasil dihapus.'
        ];

    } catch (Exception $e) {

        // =====================================================
        // ROLLBACK
        // =====================================================
        mysqli_rollback($Conn);

        $response = [
            'status'  => 'error',
            'message' => $e->getMessage()
        ];
    }

    // =========================================================
    // CLOSE
    // =========================================================
    if (!empty($stmt_pasien)) {
        mysqli_stmt_close($stmt_pasien);
    }

    if (!empty($stmt_log)) {
        mysqli_stmt_close($stmt_log);
    }

    if (!empty($stmt_delete)) {
        mysqli_stmt_close($stmt_delete);
    }

    // =========================================================
    // OUTPUT JSON
    // =========================================================
    echo json_encode($response);
?>