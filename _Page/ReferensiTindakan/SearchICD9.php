<?php
    error_reporting(0);
    ini_set('display_errors', 0);

    header('Content-Type: application/json; charset=utf-8');

    $results = [];

    try {
        include "../../_Config/Connection.php";
        include "../../_Config/SimrsFunction.php";

        if (empty($Conn)) {
            echo json_encode([]);
            exit;
        }

        $search = $_POST['search'] ?? '';

        if (!is_string($search)) {
            $search = '';
        }

        $search = trim($search);

        if (function_exists('validateAndSanitizeInput')) {
            $search = validateAndSanitizeInput($search);
        }

        $query = "
            SELECT DISTINCT
                kode,
                long_des,
                short_des
            FROM icd
            WHERE icd = 'ICD9'
                AND (
                    kode LIKE CONCAT('%', ?, '%')
                    OR long_des LIKE CONCAT('%', ?, '%')
                    OR short_des LIKE CONCAT('%', ?, '%')
                )
            ORDER BY kode ASC
            LIMIT 20
        ";

        $stmt = mysqli_prepare($Conn, $query);

        if (!$stmt) {
            echo json_encode([]);
            exit;
        }

        mysqli_stmt_bind_param($stmt, "sss", $search, $search, $search);

        if (!mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            echo json_encode([]);
            exit;
        }

        $result = mysqli_stmt_get_result($stmt);

        if (!$result) {
            mysqli_stmt_close($stmt);
            echo json_encode([]);
            exit;
        }

        while ($row = mysqli_fetch_assoc($result)) {
            $kode = trim($row['kode'] ?? '');

            if (empty($kode)) {
                continue;
            }

            $description = trim($row['long_des'] ?? '');

            if (empty($description)) {
                $description = trim($row['short_des'] ?? '');
            }

            $results[] = [
                "id"          => $kode,
                "text"        => $kode,
                "description" => $description
            ];
        }

        mysqli_stmt_close($stmt);

        echo json_encode(
            $results,
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );

        exit;
    } catch (Throwable $e) {
        echo json_encode([]);
        exit;
    }
?>
