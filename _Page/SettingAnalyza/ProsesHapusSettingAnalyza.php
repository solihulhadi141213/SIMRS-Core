<?php
    header('Content-Type: application/json');

    date_default_timezone_set('Asia/Jakarta');

    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    $response = [
        'status' => 'error',
        'message' => 'Terjadi kesalahan.'
    ];

    if (empty($SessionIdAkses)) {
        $response['message'] = 'Sesi akses berakhir, silakan login ulang.';
        echo json_encode($response);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $response['message'] = 'Metode request tidak valid.';
        echo json_encode($response);
        exit;
    }

    $id_setting_analyza = (int) ($_POST['id_setting_analyza'] ?? 0);

    if (empty($id_setting_analyza)) {
        $response['message'] = 'ID setting Analyza tidak valid.';
        echo json_encode($response);
        exit;
    }

    $stmtCheck = mysqli_prepare(
        $Conn,
        "SELECT id_setting_analyza
         FROM setting_analyza
         WHERE id_setting_analyza = ?"
    );

    if (!$stmtCheck) {
        $response['message'] = 'Gagal menyiapkan query validasi data.';
        echo json_encode($response);
        exit;
    }

    mysqli_stmt_bind_param($stmtCheck, "i", $id_setting_analyza);
    mysqli_stmt_execute($stmtCheck);
    $resultCheck = mysqli_stmt_get_result($stmtCheck);

    if (!$resultCheck || mysqli_num_rows($resultCheck) == 0) {
        mysqli_stmt_close($stmtCheck);
        $response['message'] = 'Data setting Analyza tidak ditemukan.';
        echo json_encode($response);
        exit;
    }

    mysqli_stmt_close($stmtCheck);

    $stmtDelete = mysqli_prepare(
        $Conn,
        "DELETE FROM setting_analyza
         WHERE id_setting_analyza = ?"
    );

    if (!$stmtDelete) {
        $response['message'] = 'Gagal menyiapkan query hapus data.';
        echo json_encode($response);
        exit;
    }

    mysqli_stmt_bind_param($stmtDelete, "i", $id_setting_analyza);

    if (mysqli_stmt_execute($stmtDelete)) {
        $response['status'] = 'success';
        $response['message'] = 'Data setting Analyza berhasil dihapus.';
    } else {
        $response['message'] = 'Gagal menghapus data setting Analyza.';
    }

    mysqli_stmt_close($stmtDelete);

    echo json_encode($response);
?>
