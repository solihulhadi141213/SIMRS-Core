<?php
    error_reporting(0);
    ini_set('display_errors', 0);

    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";

    $keyword_by = isset($_POST['keyword_by']) ? trim($_POST['keyword_by']) : '';

    if ($keyword_by === 'status') {
        echo '<select name="keyword" id="keyword" class="form-control">';
        echo '<option value="">Pilih</option>';
        echo '<option value="1">Aktif</option>';
        echo '<option value="0">Tidak Aktif</option>';
        echo '</select>';
        exit;
    }

    echo '<input type="text" name="keyword" id="keyword" class="form-control">';
?>

