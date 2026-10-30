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
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // =========================================================
    // VALIDASI SESSION
    // =========================================================
    if (empty($SessionIdAkses)) {
        echo '<option value="">Sesi berakhir</option>';
        exit;
    }

    // =========================================================
    // AMBIL ENUM body_site_category
    // =========================================================
    $query = "SHOW COLUMNS FROM body_site WHERE Field = 'body_site_category'";
    $result = mysqli_query($Conn, $query);

    if (!$result) {
        echo '<option value="">Gagal memuat data</option>';
        exit;
    }

    $row = mysqli_fetch_assoc($result);
    $type = $row['Type'] ?? '';

    // Parse enum values
    $enum_values = [];
    if (preg_match("/^enum\((.*)\)$/i", $type, $matches)) {
        $values = str_getcsv($matches[1], ',', "'", '');
        foreach ($values as $value) {
            $value = trim($value, " '");
            if ($value !== '') {
                $enum_values[] = $value;
            }
        }
    }

    // Output option list
    foreach ($enum_values as $value) {
        echo '<option value="' . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . '</option>';
    }
?>

