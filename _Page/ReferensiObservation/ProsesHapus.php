<?php
    // HEADER JSON
    header('Content-Type: application/json; charset=utf-8');

    // DEFAULT RESPONSE
    $response = [
        'status'  => 'error',
        'message' => 'Terjadi kesalahan'
    ];

    try {

        // LOAD Connection, Function anda Session
        include "../../_Config/Connection.php";
        include "../../_Config/SimrsFunction.php";
        include "../../_Config/Session.php";

        // VALIDASI SESSION
        if (empty($SessionIdAkses)) {
            $response['message'] = 'Sesi akses sudah berakhir';
            echo json_encode($response);
            exit;
        }

        // VALIDASI KONEKSI
        if (empty($Conn)) {
            $response['message'] = 'Koneksi database gagal';
            echo json_encode($response);
            exit;
        }

        // TANGKAP ID
        $id_observation_reference = validateAndSanitizeInput($_POST['id_observation_reference'] ?? '');

        // VALIDASI ID
        if (empty($id_observation_reference)) {
            $response['message'] = 'ID Referensi Observation Tidak Valid';
            echo json_encode($response);
            exit;
        }

        // CEK DATA
        $queryCheck = "SELECT id_observation_reference FROM observation_reference WHERE id_observation_reference = ? LIMIT 1";
        $stmtCheck = mysqli_prepare($Conn, $queryCheck);
        if (!$stmtCheck) {
            $response['message'] = 'Gagal prepare query pengecekan data';
            echo json_encode($response);
            exit;
        }

        mysqli_stmt_bind_param($stmtCheck,"s",$id_observation_reference);
        mysqli_stmt_execute($stmtCheck);
        $resultCheck = mysqli_stmt_get_result($stmtCheck);

        if (mysqli_num_rows($resultCheck) == 0) {
            mysqli_stmt_close($stmtCheck);
            $response['message'] = 'Data referensi Observation tidak ditemukan';
            echo json_encode($response);
            exit;
        }
        mysqli_stmt_close($stmtCheck);
        
        $query_delete = "DELETE FROM observation_reference WHERE id_observation_reference = ?";
        $stmt_delete = mysqli_prepare($Conn, $query_delete);
        if (!$stmt_delete) {
            $response["message"] = "Gagal mempersiapkan query hapus.";
            echo json_encode($response);
            exit;
        }
        mysqli_stmt_bind_param($stmt_delete, "i", $id_observation_reference);

        if (!mysqli_stmt_execute($stmt_delete)) {
            mysqli_stmt_close($stmt_delete);
            $response["message"] = "Gagal menghapus data referensi Observation.";
            echo json_encode($response);
            exit;
        }

        mysqli_stmt_close($stmt_delete);

        // ======================================================
        // SUCCESS RESPONSE
        // ======================================================
        $response = [
            "status"  => "success",
            "message" => "Data referensi Observation berhasil dihapus."
        ];

        echo json_encode($response);
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