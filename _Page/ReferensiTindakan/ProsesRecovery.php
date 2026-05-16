<?php
    // =========================================================
    // ERROR REPORTING
    // =========================================================
    error_reporting(0);
    ini_set('display_errors', 0);

    // =========================================================
    // HEADER JSON
    // =========================================================
    header('Content-Type: application/json; charset=utf-8');

    // =========================================================
    // DEFAULT RESPONSE
    // =========================================================
    $response = [
        'status'  => 'error',
        'message' => 'Terjadi kesalahan'
    ];

    try {

        // =====================================================
        // LOAD FILE
        // =====================================================
        include "../../_Config/Connection.php";
        include "../../_Config/SimrsFunction.php";
        include "../../_Config/Session.php";

        // =====================================================
        // VALIDASI SESSION
        // =====================================================
        if (empty($SessionIdAkses)) {

            $response['message'] = 'Sesi akses sudah berakhir';

            echo json_encode($response);
            exit;
        }

        // =====================================================
        // VALIDASI KONEKSI
        // =====================================================
        if (empty($Conn)) {

            $response['message'] = 'Koneksi database gagal';

            echo json_encode($response);
            exit;
        }

        // =====================================================
        // TANGKAP ID
        // =====================================================
        $id_tindakan_referensi = validateAndSanitizeInput(
            $_POST['id_tindakan_referensi'] ?? ''
        );

        // =====================================================
        // VALIDASI ID
        // =====================================================
        if (empty($id_tindakan_referensi)) {

            $response['message'] = 'ID Referensi Tindakan Tidak Valid';

            echo json_encode($response);
            exit;
        }

        // =====================================================
        // CEK DATA
        // =====================================================
        $queryCheck = "
            SELECT 
                id_tindakan_referensi,
                status
            FROM tindakan_referensi
            WHERE id_tindakan_referensi = ?
            LIMIT 1
        ";

        $stmtCheck = mysqli_prepare($Conn, $queryCheck);

        if (!$stmtCheck) {

            $response['message'] = 'Gagal prepare query pengecekan data';

            echo json_encode($response);
            exit;
        }

        mysqli_stmt_bind_param(
            $stmtCheck,
            "s",
            $id_tindakan_referensi
        );

        mysqli_stmt_execute($stmtCheck);

        $resultCheck = mysqli_stmt_get_result($stmtCheck);

        if (mysqli_num_rows($resultCheck) == 0) {

            mysqli_stmt_close($stmtCheck);

            $response['message'] = 'Data referensi tindakan tidak ditemukan';

            echo json_encode($response);
            exit;
        }

        $dataCheck = mysqli_fetch_assoc($resultCheck);

        mysqli_stmt_close($stmtCheck);

        // =====================================================
        // VALIDASI STATUS
        // =====================================================
        if ($dataCheck['status'] == '1') {

            $response['message'] = 'Data referensi tindakan sudah aktif';

            echo json_encode($response);
            exit;
        }

        // =====================================================
        // UPDATE STATUS MENJADI 1
        // =====================================================
        $queryUpdate = "
            UPDATE tindakan_referensi
            SET 
                status = '1'
            WHERE id_tindakan_referensi = ?
        ";

        $stmtUpdate = mysqli_prepare($Conn, $queryUpdate);

        if (!$stmtUpdate) {

            $response['message'] = 'Gagal prepare query recovery';

            echo json_encode($response);
            exit;
        }

        mysqli_stmt_bind_param(
            $stmtUpdate,
            "s",
            $id_tindakan_referensi
        );

        $execute = mysqli_stmt_execute($stmtUpdate);

        if (!$execute) {

            mysqli_stmt_close($stmtUpdate);

            $response['message'] = 'Recovery referensi tindakan gagal';

            echo json_encode($response);
            exit;
        }

        mysqli_stmt_close($stmtUpdate);

        // =====================================================
        // SUCCESS
        // =====================================================
        $response = [
            'status'  => 'success',
            'message' => 'Recovery referensi tindakan berhasil'
        ];

        echo json_encode(
            $response,
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );

        exit;

    } catch (Throwable $e) {

        $response['message'] = $e->getMessage();

        echo json_encode(
            $response,
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );

        exit;
    }
?>