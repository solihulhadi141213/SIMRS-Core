<?php
    // =========================================================
    // ERROR REPORTING
    // =========================================================
    error_reporting(0);
    ini_set('display_errors', 0);

    // =========================================================
    // CONNECTION
    // =========================================================
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";

    header('Content-Type: application/json; charset=utf-8');

    // Validasi session
    if (empty($SessionIdAkses)) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Sesi akses sudah berakhir'
        ]);
        exit;
    }

    // =========================================================
    // ZONA WAKTU USER
    // =========================================================
    $timezoneName = trim((string)($SessionUserTimezone ?? ''));
    if (preg_match('/^UTC([+-])(\d{2}):(\d{2})$/', $timezoneName, $timezoneOffset)) {
        $timezoneName = $timezoneOffset[1] . $timezoneOffset[2] . ':' . $timezoneOffset[3];
    }

    try {
        $userTimezone = new DateTimeZone($timezoneName !== '' ? $timezoneName : 'UTC');
    } catch (Throwable $e) {
        $userTimezone = new DateTimeZone('UTC');
    }

    $now = new DateTime('now', new DateTimeZone('UTC'));
    $now->setTimezone($userTimezone);

    echo json_encode([
        'status'  => 'success',
        'tanggal' => $now->format('Y-m-d'),
        'jam'     => $now->format('H:i'),
        'datetime'=> $now->format('Y-m-d H:i:s')
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>

