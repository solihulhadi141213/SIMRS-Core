<?php
    // Koneksi
    include "../../_Config/Connection.php";

    // Function
    include "../../_Config/SimrsFunction.php";

    $keyword_by = isset($_POST['keyword_by']) ? trim($_POST['keyword_by']) : '';

   
    // Default
    if (empty($keyword_by) || $keyword_by === "id_pasien" || $keyword_by === "nama") {
        echo '<input type="text" name="keyword" id="keyword_form" class="form-control">';
        exit;
    }
    if($keyword_by === "datetime_observation") {
        echo '<input type="date" name="keyword" id="keyword_form" class="form-control">';
        exit;
    }


    // category_name
    if ($keyword_by === "category_name") {

        echo '<select name="keyword" id="keyword_form" class="form-control">';
        echo '<option value="">Pilih</option>';

        // 🔥 Ambil langsung id + akses (tanpa query tambahan)
        $sql = "SELECT DISTINCT category_name FROM observation_reference ORDER BY category_name ASC";
        $stmt = mysqli_prepare($Conn, $sql);
        if ($stmt) {
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            while ($data = mysqli_fetch_assoc($result)) {
                $category_name = $data['category_name'];
                echo '<option value="' . htmlspecialchars($category_name) . '">'. htmlspecialchars($category_name) .'</option>';
            }

            mysqli_stmt_close($stmt);
        } else {
            echo '<option value="">Gagal memuat data</option>';
        }

        echo '</select>';
        exit;
    }

    // observation_name
    if ($keyword_by === "observation_name") {

        echo '<select name="keyword" id="keyword_form" class="form-control">';
        echo '<option value="">Pilih</option>';

        // 🔥 Ambil langsung id + akses (tanpa query tambahan)
        $sql = "SELECT DISTINCT observation_name FROM observation_reference ORDER BY observation_name ASC";
        $stmt = mysqli_prepare($Conn, $sql);
        if ($stmt) {
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            while ($data = mysqli_fetch_assoc($result)) {
                $observation_name = $data['observation_name'];
                echo '<option value="' . htmlspecialchars($observation_name) . '">'. htmlspecialchars($observation_name) .'</option>';
            }

            mysqli_stmt_close($stmt);
        } else {
            echo '<option value="">Gagal memuat data</option>';
        }

        echo '</select>';
        exit;
    }

    // petugas_id
    if ($keyword_by === "petugas_id") {

        echo '<select name="keyword" id="keyword_form" class="form-control">';
        echo '<option value="">Pilih</option>';

        // 🔥 Ambil langsung id + akses (tanpa query tambahan)
        $sql = "SELECT DISTINCT id_akses, nama FROM akses ORDER BY nama ASC";
        $stmt = mysqli_prepare($Conn, $sql);
        if ($stmt) {
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            while ($data = mysqli_fetch_assoc($result)) {
                $id_akses = $data['id_akses'];
                $nama = $data['nama'];
                echo '<option value="' . htmlspecialchars($id_akses) . '">'. htmlspecialchars($nama) .'</option>';
            }

            mysqli_stmt_close($stmt);
        } else {
            echo '<option value="">Gagal memuat data</option>';
        }

        echo '</select>';
        exit;
    }
    
    
?>