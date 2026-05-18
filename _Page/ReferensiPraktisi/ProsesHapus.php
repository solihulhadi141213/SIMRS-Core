<?php
    // =========================================================================
    // HEADER JSON
    // =========================================================================
    header('Content-Type: application/json');

    // =========================================================================
    // TIMEZONE
    // =========================================================================
    date_default_timezone_set('Asia/Jakarta');

    // =========================================================================
    // CONNECTION, FUNCTION & SESSION
    // =========================================================================
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // =========================================================================
    // DEFAULT RESPONSE
    // =========================================================================
    $response = [
        'status'  => 'error',
        'message' => 'Terjadi kesalahan.'
    ];

    // =========================================================================
    // VALIDASI SESSION
    // =========================================================================
    if (empty($SessionIdAkses)) {

        $response['message'] = 'Sesi akses berakhir, silakan login ulang.';

        echo json_encode($response);
        exit;
    }

    // =========================================================================
    // VALIDASI METHOD
    // =========================================================================
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

        $response['message'] = 'Metode request tidak valid.';

        echo json_encode($response);
        exit;
    }

    // =========================================================================
    // VALIDASI ID PRAKTISI
    // =========================================================================
    if (empty($_POST['id_praktisi'])) {

        $response['message'] = 'ID Praktisi tidak boleh kosong.';

        echo json_encode($response);
        exit;
    }

    $id_praktisi = (int) $_POST['id_praktisi'];

    // =========================================================================
    // CEK DATA PRAKTISI
    // =========================================================================
    $stmt = mysqli_prepare($Conn, "
        SELECT id_praktisi
        FROM praktisi
        WHERE id_praktisi=?
        LIMIT 1
    ");

    if (!$stmt) {

        $response['message'] = 'Gagal menyiapkan query database.';

        echo json_encode($response);
        exit;
    }

    mysqli_stmt_bind_param($stmt, "i", $id_praktisi);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (!$result || mysqli_num_rows($result) == 0) {

        mysqli_stmt_close($stmt);

        $response['message'] = 'Data praktisi tidak ditemukan.';

        echo json_encode($response);
        exit;
    }

    mysqli_stmt_close($stmt);

    // =========================================================================
    // HAPUS DATA
    // =========================================================================
    $stmtDelete = mysqli_prepare($Conn, "
        DELETE FROM praktisi
        WHERE id_praktisi=?
    ");

    if (!$stmtDelete) {

        $response['message'] = 'Gagal menyiapkan proses hapus data.';

        echo json_encode($response);
        exit;
    }

    mysqli_stmt_bind_param($stmtDelete, "i", $id_praktisi);

    $delete = mysqli_stmt_execute($stmtDelete);

    // =========================================================================
    // RESULT
    // =========================================================================
    if ($delete) {

        $response['status'] = 'success';
        $response['message'] = 'Data praktisi berhasil dihapus.';

    } else {

        $response['message'] = 'Gagal menghapus data praktisi.';
    }

    mysqli_stmt_close($stmtDelete);

    // =========================================================================
    // OUTPUT JSON
    // =========================================================================
    echo json_encode($response);
?>