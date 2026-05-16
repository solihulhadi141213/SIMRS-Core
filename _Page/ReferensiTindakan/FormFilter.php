<?php
    // Koneksi
    include "../../_Config/Connection.php";

    // Function
    include "../../_Config/SimrsFunction.php";

    $keyword_by = isset($_POST['keyword_by']) ? trim($_POST['keyword_by']) : '';

    // kategori_tindakan
    if ($keyword_by === "kategori_tindakan") {
        echo '<select name="keyword" id="keyword_form" class="form-control">';
        echo '<option value="">Pilih</option>';
        // LIST DISTINCT
        $sql = "SELECT DISTINCT kategori_tindakan FROM tindakan_referensi ORDER BY kategori_tindakan ASC";
        $stmt = mysqli_prepare($Conn, $sql);
        if ($stmt) {
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            while ($data = mysqli_fetch_assoc($result)) {
                $kategori_tindakan = $data['kategori_tindakan'];
                echo '<option value="' . $kategori_tindakan . '">'. $kategori_tindakan .'</option>';
            }
            mysqli_stmt_close($stmt);
        } else {
            echo '<option value="">Gagal memuat data</option>';
        }
        echo '</select>';

        exit;
    }

    // status
    if ($keyword_by === "status") {
        echo '<select name="keyword" id="keyword_form" class="form-control">';
        echo '<option value="">Pilih</option>';
        // LIST DISTINCT
        $sql = "SELECT DISTINCT status FROM tindakan_referensi ORDER BY status ASC";
        $stmt = mysqli_prepare($Conn, $sql);
        if ($stmt) {
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            while ($data = mysqli_fetch_assoc($result)) {
                if(empty($data['status'])){
                    $status = 0;
                    $label_status = "Deleted";
                }else{
                    $status = 1;
                    $label_status = "Active";
                }
                echo '<option value="' . $status . '">'. $label_status .'</option>';
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