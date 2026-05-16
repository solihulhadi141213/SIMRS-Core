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
                body_site_nama,
                body_site_display,
                body_site_code,
                body_site_system
            FROM body_site
            WHERE body_site_nama LIKE CONCAT('%', ?, '%')
                OR body_site_display LIKE CONCAT('%', ?, '%')
                OR body_site_code LIKE CONCAT('%', ?, '%')
            ORDER BY body_site_nama ASC
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
            $body_site_nama = trim($row['body_site_nama'] ?? '');

            if (empty($body_site_nama)) {
                continue;
            }

            $results[] = [
                "id"      => $body_site_nama,
                "text"    => $body_site_nama,
                "code"    => trim($row['body_site_code'] ?? ''),
                "display" => trim($row['body_site_display'] ?? ''),
                "system"  => trim($row['body_site_system'] ?? 'http://snomed.info/sct')
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
