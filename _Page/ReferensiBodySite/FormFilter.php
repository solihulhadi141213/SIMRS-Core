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

    // =========================================================
    // TANGKAP keyword_by
    // =========================================================
    $keyword_by = isset($_POST['keyword_by']) ? trim($_POST['keyword_by']) : '';

    // =========================================================
    // body_site_category -> select option dari enum
    // =========================================================
    if ($keyword_by === 'body_site_category') {

        echo '<select name="keyword" id="keyword_form" class="form-control">';
        echo '<option value="">Pilih Kategori</option>';

        $query = "SHOW COLUMNS FROM body_site WHERE Field = 'body_site_category'";
        $result = mysqli_query($Conn, $query);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $type = $row['Type'] ?? '';

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

            foreach ($enum_values as $value) {
                echo '<option value="' . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . '</option>';
            }
        }

        echo '</select>';
        exit;
    }

    // =========================================================
    // body_site_nama, body_site_display, body_site_code, body_site_system -> text
    // =========================================================
    if (in_array($keyword_by, ['body_site_nama', 'body_site_display', 'body_site_code', 'body_site_system'])) {
        echo '<input type="text" name="keyword" id="keyword_form" class="form-control">';
        exit;
    }

    // =========================================================
    // DEFAULT -> text
    // =========================================================
    echo '<input type="text" name="keyword" id="keyword_form" class="form-control">';
?>

