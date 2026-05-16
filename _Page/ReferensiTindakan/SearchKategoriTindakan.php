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
    $results = [];

    try {

        // =====================================================
        // LOAD CONNECTION
        // =====================================================
        include "../../_Config/Connection.php";
        include "../../_Config/SimrsFunction.php";

        // =====================================================
        // VALIDASI KONEKSI
        // =====================================================
        if (empty($Conn)) {

            echo json_encode([]);
            exit;
        }

        // =====================================================
        // TANGKAP SEARCH
        // =====================================================
        $search = $_POST['search'] ?? '';

        // Pastikan string
        if (!is_string($search)) {
            $search = '';
        }

        // Sanitasi
        $search = trim($search);

        if(function_exists('validateAndSanitizeInput')){
            $search = validateAndSanitizeInput($search);
        }

        // =====================================================
        // QUERY
        // =====================================================
        $query = "
            SELECT DISTINCT
                kategori_tindakan,
                kategori_tindakan_code,
                kategori_tindakan_display,
                kategori_tindakan_system
            FROM tindakan_referensi
            WHERE kategori_tindakan LIKE CONCAT('%', ?, '%')
            ORDER BY kategori_tindakan ASC
            LIMIT 20
        ";

        // =====================================================
        // PREPARE
        // =====================================================
        $stmt = mysqli_prepare($Conn, $query);

        // Jika prepare gagal
        if (!$stmt) {

            echo json_encode([]);
            exit;
        }

        // =====================================================
        // BIND
        // =====================================================
        mysqli_stmt_bind_param($stmt, "s", $search);

        // =====================================================
        // EXECUTE
        // =====================================================
        $execute = mysqli_stmt_execute($stmt);

        // Jika execute gagal
        if (!$execute) {

            mysqli_stmt_close($stmt);

            echo json_encode([]);
            exit;
        }

        // =====================================================
        // RESULT
        // =====================================================
        $result = mysqli_stmt_get_result($stmt);

        // Jika result gagal
        if (!$result) {

            mysqli_stmt_close($stmt);

            echo json_encode([]);
            exit;
        }

        // =====================================================
        // LOOP DATA
        // =====================================================
        while ($row = mysqli_fetch_assoc($result)) {

            $kategori_tindakan = $row['kategori_tindakan'];

            // Skip jika kosong
            if (empty($kategori_tindakan)) {
                continue;
            }

            $results[] = [

                "id" => $kategori_tindakan,

                "text" => $kategori_tindakan,

                "code" => trim($row['kategori_tindakan_code'] ?? ''),

                "display" => trim($row['kategori_tindakan_display'] ?? ''),

                "system" => trim(
                    $row['kategori_tindakan_system']
                    ?? 'http://snomed.info/sct'
                )
            ];
        }

        // =====================================================
        // CLOSE
        // =====================================================
        mysqli_stmt_close($stmt);

        // =====================================================
        // OUTPUT
        // =====================================================
        echo json_encode(
            $results,
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );

        exit;

    } catch (Throwable $e) {

        // =====================================================
        // JIKA TERJADI ERROR APAPUN
        // =====================================================
        echo json_encode([]);

        exit;
    }
?>