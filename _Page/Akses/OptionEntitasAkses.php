<?php
     // Koneksi
    include "../../_Config/Connection.php";

    // Function
    include "../../_Config/SimrsFunction.php";

    // Tampilkan Option List
    $sql = "SELECT DISTINCT id_akses_entitas, akses FROM akses_entitas ORDER BY akses ASC";
    $stmt = mysqli_prepare($Conn, $sql);
    if ($stmt) {
        echo '<option>Pilih</option>';
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
?>