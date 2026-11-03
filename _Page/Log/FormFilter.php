<?php
    // Koneksi
    include "../../_Config/Connection.php";

    // Function
    include "../../_Config/SimrsFunction.php";

    $keyword_by = isset($_POST['keyword_by']) ? trim($_POST['keyword_by']) : '';

    // Default / kosong
    if (empty($keyword_by)) {
        echo '<input type="text" name="keyword" id="keyword_form" class="form-control" placeholder="Masukkan kata kunci">';
        exit;
    }

    // nama_petugas - gunakan input text
    if ($keyword_by === 'nama_petugas') {
        echo '<input type="text" name="keyword" id="keyword_form" class="form-control" placeholder="Masukkan kata kunci">';
        exit;
    }

    // category_log - gunakan select option dengan list category_log dari tabel log secara distinct
    if ($keyword_by === 'category_log') {
        $sql = "SELECT DISTINCT category_log FROM log ORDER BY category_log";
        $stmt = mysqli_prepare($Conn, $sql);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $options = '<option value="">-- Pilih Kategori --</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            $category = htmlspecialchars($row['category_log']);
            $options .= '<option value="' . $category . '">' . $category . '</option>';
        }
        
        echo '<select name="keyword" id="keyword_form" class="form-control">' . $options . '</select>';
        exit;
    }

    // datetime_log - gunakan input date
    if ($keyword_by === 'datetime_log') {
        echo '<input type="date" name="keyword" id="keyword_form" class="form-control">';
        exit;
    }

    // Default - gunakan input text
    echo '<input type="text" name="keyword" id="keyword_form" class="form-control" placeholder="Masukkan kata kunci">';
    exit;
?>
