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
    $query = "SELECT COLUMN_TYPE AS `Type` FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? AND COLUMN_NAME = ?";
    // Prepared Statement: ambil definisi enum kategori body site.
    $stmt = mysqli_prepare($Conn, $query);
    $tableName = 'body_site';
    $columnName = 'body_site_category';
    mysqli_stmt_bind_param($stmt, "ss", $tableName, $columnName);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

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
