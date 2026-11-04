<?php
    // =========================================================
    // ERROR REPORTING
    // =========================================================
    error_reporting(0);
    ini_set('display_errors', 0);

    // =========================================================
    // CONNECTION
    // =========================================================
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";

    // =========================================================
    // TANGKAP keyword_by DARI FORM
    // =========================================================
    $keyword_by = isset($_POST['keyword_by']) ? trim($_POST['keyword_by']) : '';

    // =========================================================
    // episode_category -> SELECT OPTION (DISTINCT)
    // =========================================================
    if ($keyword_by === 'episode_category') {

        echo '<select name="keyword" id="keyword_form" class="form-control">';
        echo '<option value="">Pilih Kategori</option>';

        $sql = "SELECT DISTINCT episode_category FROM episode_perawatan_kode ORDER BY episode_category ASC";
        $stmt = mysqli_prepare($Conn, $sql);
        if ($stmt) {
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            while ($data = mysqli_fetch_assoc($result)) {
                $kategori = trim($data['episode_category'] ?? '');
                if ($kategori !== '') {
                    echo '<option value="' . htmlspecialchars($kategori, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($kategori, ENT_QUOTES, 'UTF-8') . '</option>';
                }
            }

            mysqli_stmt_close($stmt);
        } else {
            echo '<option value="">Gagal memuat data</option>';
        }

        echo '</select>';
        exit;
    }

    // =========================================================
    // episode_name, episode_display, episode_code, episode_system -> INPUT TEXT
    // =========================================================
    if (in_array($keyword_by, ['episode_name', 'episode_display', 'episode_code', 'episode_system'])) {
        echo '<input type="text" name="keyword" id="keyword_form" class="form-control">';
        exit;
    }

    // =========================================================
    // status -> SELECT OPTION 0=Inactive | 1=Active
    // =========================================================
    if ($keyword_by === 'status') {

        echo '<select name="keyword" id="keyword_form" class="form-control">';
        echo '<option value="">Pilih</option>';

        $sql = "SELECT DISTINCT status FROM episode_perawatan_kode ORDER BY status ASC";
        $stmt = mysqli_prepare($Conn, $sql);
        if ($stmt) {
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            while ($data = mysqli_fetch_assoc($result)) {
                $status = isset($data['status']) ? trim($data['status']) : '0';
                $status = ($status === '1') ? 1 : 0;
                $label_status = ($status === 1) ? 'Active' : 'Inactive';
                echo '<option value="' . $status . '">' . htmlspecialchars($label_status, ENT_QUOTES, 'UTF-8') . '</option>';
            }

            mysqli_stmt_close($stmt);
        } else {
            echo '<option value="">Gagal memuat data</option>';
        }

        echo '</select>';
        exit;
    }

    // =========================================================
    // DEFAULT -> INPUT TEXT
    // =========================================================
    echo '<input type="text" name="keyword" id="keyword_form" class="form-control">';
?>

