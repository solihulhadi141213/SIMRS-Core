<?php
    // Koneksi
    include "../../_Config/Connection.php";

    // Function
    include "../../_Config/SimrsFunction.php";

    $keyword_by = isset($_POST['keyword_by']) ? trim($_POST['keyword_by']) : '';

    // category_name
    if ($keyword_by === "category_name") {
        echo '<select name="keyword" id="keyword_form" class="form-control">';
        echo '<option value="">Pilih</option>';
        // LIST DISTINCT
        $sql = "SELECT DISTINCT category_name FROM observation_reference ORDER BY category_name ASC";
        $stmt = mysqli_prepare($Conn, $sql);
        if ($stmt) {
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            while ($data = mysqli_fetch_assoc($result)) {
                $category_name = $data['category_name'];
                echo '<option value="' . $category_name . '">'. $category_name .'</option>';
            }
            mysqli_stmt_close($stmt);
        } else {
            echo '<option value="">Gagal memuat data</option>';
        }
        echo '</select>';

        exit;
    }

    // result_type
    if ($keyword_by === "result_type") {
        echo '<select name="keyword" id="keyword_form" class="form-control">';
        echo '<option value="">Pilih</option>';
        // LIST DISTINCT
        $sql = "SELECT DISTINCT result_type FROM observation_reference ORDER BY result_type ASC";
        $stmt = mysqli_prepare($Conn, $sql);
        if ($stmt) {
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            while ($data = mysqli_fetch_assoc($result)) {
                $result_type = $data['result_type'];
                echo '<option value="' . $result_type . '">'. $result_type .'</option>';
            }
            mysqli_stmt_close($stmt);
        } else {
            echo '<option value="">Gagal memuat data</option>';
        }
        echo '</select>';

        exit;
    }

    // Default
    echo '<input type="text" name="keyword" id="keyword_form" class="form-control">';
?>