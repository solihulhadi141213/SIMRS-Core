<?php
    // Koneksi
    include "../../_Config/Connection.php";

    // Function
    include "../../_Config/SimrsFunction.php";

    $keyword_by = isset($_POST['keyword_by']) ? trim($_POST['keyword_by']) : '';

    // Default
    if (empty($keyword_by) || $keyword_by === "id_pasien" || $keyword_by === "id_ihs" || $keyword_by === "nik" || $keyword_by === "no_bpjs" || $keyword_by === "nama") {
        echo '<input type="text" name="keyword" id="keyword_form" class="form-control">';
        exit;
    }

    // Gender
    if ($keyword_by === "registered_at") {

        echo '<input type="date" name="keyword" id="keyword_form" class="form-control">';
        exit;
    }

    // Gender
    if ($keyword_by === "gender") {

        echo '<select name="keyword" id="keyword_form" class="form-control">';
        echo '<option value="">Pilih</option>';

        // 🔥 Ambil langsung id + akses (tanpa query tambahan)
        $sql = "SELECT DISTINCT gender FROM pasien ORDER BY gender ASC";
        $stmt = mysqli_prepare($Conn, $sql);
        if ($stmt) {
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            while ($data = mysqli_fetch_assoc($result)) {
                $gender = $data['gender'];
                echo '<option value="' . htmlspecialchars($gender) . '">'. htmlspecialchars($gender) .'</option>';
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

        // 🔥 Ambil langsung id + akses (tanpa query tambahan)
        $sql = "SELECT DISTINCT status FROM pasien ORDER BY status ASC";
        $stmt = mysqli_prepare($Conn, $sql);
        if ($stmt) {
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            while ($data = mysqli_fetch_assoc($result)) {
                $status = $data['status'];
                echo '<option value="' . htmlspecialchars($status) . '">'. htmlspecialchars($status) .'</option>';
            }

            mysqli_stmt_close($stmt);
        } else {
            echo '<option value="">Gagal memuat data</option>';
        }

        echo '</select>';
        exit;
    }
    
    
?>