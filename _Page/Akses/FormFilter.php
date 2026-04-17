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
    if ($keyword_by === "id_akses_entitas") {

        echo '<select name="keyword" id="keyword" class="form-control">';
        echo '<option value="">Pilih</option>';

        // 🔥 Ambil langsung id + akses (tanpa query tambahan)
        $sql = "SELECT DISTINCT id_akses_entitas, akses 
                FROM akses_entitas 
                ORDER BY akses ASC";

        $stmt = mysqli_prepare($Conn, $sql);

        if ($stmt) {
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            while ($data = mysqli_fetch_assoc($result)) {
                $id_akses_entitas = $data['id_akses_entitas'];
                $akses            = $data['akses'];

                echo '<option value="' . htmlspecialchars($id_akses_entitas) . '">'
                    . htmlspecialchars($akses) .
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