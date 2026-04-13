<?php
    // Koneksi
    include "../../_Config/Connection.php";

    // Ambil input
    $keyword_by = isset($_POST['keyword_by']) ? trim($_POST['keyword_by']) : '';

    // Default input text
    if (empty($keyword_by)) {
        echo '<input type="text" name="keyword" id="keyword" class="form-control">';
        exit;
    }

    // Jika filter kategori -> tampilkan dropdown
    if ($keyword_by === "kategori") {

        echo '<select name="keyword" id="keyword" class="form-control">';
        echo '<option value="">Pilih</option>';

        // Prepared Statement
        $sql = "SELECT DISTINCT kategori 
                FROM akses_fitur 
                ORDER BY kategori ASC";

        $stmt = mysqli_prepare($Conn, $sql);

        if ($stmt) {
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            while ($data = mysqli_fetch_assoc($result)) {
                $kategori = htmlspecialchars($data['kategori']);
                echo '<option value="' . $kategori . '">' . $kategori . '</option>';
            }

            mysqli_stmt_close($stmt);
        } else {
            echo '<option value="">Gagal memuat data</option>';
        }

        echo '</select>';

    } else {
        echo '<input type="text" name="keyword" id="keyword" class="form-control">';
    }
?>