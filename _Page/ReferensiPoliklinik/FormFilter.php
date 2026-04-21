<?php
    // Koneksi
    include "../../_Config/Connection.php";

    // Function
    include "../../_Config/SimrsFunction.php";

    $keyword_by = isset($_POST['keyword_by']) ? trim($_POST['keyword_by']) : '';

    // Default
    if (empty($keyword_by)) {
        echo '<input type="text" name="keyword" id="keyword" class="form-control">';
        exit;
    }

    // Dropdown akses entitas
    if ($keyword_by === "status") {

        echo '<select name="keyword" id="keyword" class="form-control">';
        echo '<option value="">Pilih</option>';

        // 🔥 Ambil langsung id + akses (tanpa query tambahan)
        $sql = "SELECT DISTINCT status FROM poliklinik ORDER BY status ASC";

        $stmt = mysqli_prepare($Conn, $sql);

        if ($stmt) {
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            while ($data = mysqli_fetch_assoc($result)) {
                $status = $data['status'];
                if(empty($data['status'])){
                    $label_status = "Tidak Aktif";
                }else{
                    $label_status = "Aktif";
                }

                echo '<option value="' . htmlspecialchars($status) . '">'
                    . htmlspecialchars($label_status) .
                    '</option>';
            }

            mysqli_stmt_close($stmt);
        } else {
            echo '<option value="">Gagal memuat data</option>';
        }

        echo '</select>';

    } else {

        if ($keyword_by === "tanggal" || $keyword_by === "updatetime") {
            echo '<input type="date" name="keyword" id="keyword" class="form-control">';
        } else {
            echo '<input type="text" name="keyword" id="keyword" class="form-control">';
        }

    }
?>