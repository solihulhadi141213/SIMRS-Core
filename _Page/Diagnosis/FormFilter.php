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

    // datetime_daftar
    if ($keyword_by === "datetime_daftar") {
        echo '<input type="date" name="keyword" id="keyword_form" class="form-control">';
        exit;
    }

    // prioritas
    if ($keyword_by === "prioritas") {

        echo '<select name="keyword" id="keyword_form" class="form-control">';
        echo '<option value="">Pilih</option>';

        // prioritas
        $sql = "SELECT DISTINCT prioritas FROM kunjungan ORDER BY prioritas ASC";
        $stmt = mysqli_prepare($Conn, $sql);
        if ($stmt) {
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            while ($data = mysqli_fetch_assoc($result)) {
                $prioritas = $data['prioritas'];
                echo '<option value="' . htmlspecialchars($prioritas) . '">'. htmlspecialchars($prioritas) .'</option>';
            }
            mysqli_stmt_close($stmt);
        } else {
            echo '<option value="">Gagal memuat data</option>';
        }
        echo '</select>';
        exit;
    }

    // jenis_kunjungan
    if ($keyword_by === "jenis_kunjungan") {

        echo '<select name="keyword" id="keyword_form" class="form-control">';
        echo '<option value="">Pilih</option>';

        // jenis_kunjungan
        $sql = "SELECT DISTINCT jenis_kunjungan FROM kunjungan ORDER BY jenis_kunjungan ASC";
        $stmt = mysqli_prepare($Conn, $sql);
        if ($stmt) {
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            while ($data = mysqli_fetch_assoc($result)) {
                $jenis_kunjungan = $data['jenis_kunjungan'];
                echo '<option value="' . htmlspecialchars($jenis_kunjungan) . '">'. htmlspecialchars($jenis_kunjungan) .'</option>';
            }
            mysqli_stmt_close($stmt);
        } else {
            echo '<option value="">Gagal memuat data</option>';
        }
        echo '</select>';
        exit;
    }

    // dpjp_nama
    if ($keyword_by === "dpjp_nama") {

        echo '<select name="keyword" id="keyword_form" class="form-control">';
        echo '<option value="">Pilih</option>';

        // dpjp_nama
        $sql = "SELECT DISTINCT dpjp_nama FROM kunjungan ORDER BY dpjp_nama ASC";
        $stmt = mysqli_prepare($Conn, $sql);
        if ($stmt) {
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            while ($data = mysqli_fetch_assoc($result)) {
                $dpjp_nama = $data['dpjp_nama'];
                echo '<option value="' . htmlspecialchars($dpjp_nama) . '">'. htmlspecialchars($dpjp_nama) .'</option>';
            }
            mysqli_stmt_close($stmt);
        } else {
            echo '<option value="">Gagal memuat data</option>';
        }
        echo '</select>';
        exit;
    }

    // poliklinik
    if ($keyword_by === "poliklinik") {

        echo '<select name="keyword" id="keyword_form" class="form-control">';
        echo '<option value="">Pilih</option>';

        // poliklinik
        $sql = "SELECT DISTINCT poliklinik FROM kunjungan ORDER BY poliklinik ASC";
        $stmt = mysqli_prepare($Conn, $sql);
        if ($stmt) {
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            while ($data = mysqli_fetch_assoc($result)) {
                if(!empty($data['poliklinik'])){
                    $poliklinik = $data['poliklinik'];
                    echo '<option value="' . htmlspecialchars($poliklinik) . '">'. htmlspecialchars($poliklinik) .'</option>';
                }
            }
            mysqli_stmt_close($stmt);
        } else {
            echo '<option value="">Gagal memuat data</option>';
        }
        echo '</select>';
        exit;
    }

    // Kelas
    if ($keyword_by === "kelas") {

        echo '<select name="keyword" id="keyword_form" class="form-control">';
        echo '<option value="">Pilih</option>';

        // kelas
        $sql = "SELECT DISTINCT kelas FROM kunjungan ORDER BY kelas ASC";
        $stmt = mysqli_prepare($Conn, $sql);
        if ($stmt) {
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            while ($data = mysqli_fetch_assoc($result)) {
                if(!empty($data['kelas'])){
                     $kelas = $data['kelas'];
                    echo '<option value="' . htmlspecialchars($kelas) . '">'. htmlspecialchars($kelas) .'</option>';
                }
            }
            mysqli_stmt_close($stmt);
        } else {
            echo '<option value="">Gagal memuat data</option>';
        }
        echo '</select>';
        exit;
    }

    // Kelas
    if ($keyword_by === "pembayaran_metode") {

        echo '<select name="keyword" id="keyword_form" class="form-control">';
        echo '<option value="">Pilih</option>';

        // pembayaran_metode
        $sql = "SELECT DISTINCT pembayaran_metode FROM kunjungan ORDER BY pembayaran_metode ASC";
        $stmt = mysqli_prepare($Conn, $sql);
        if ($stmt) {
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            while ($data = mysqli_fetch_assoc($result)) {
                if(!empty($data['pembayaran_metode'])){
                    $pembayaran_metode = $data['pembayaran_metode'];
                    echo '<option value="' . htmlspecialchars($pembayaran_metode) . '">'. htmlspecialchars($pembayaran_metode) .'</option>';
                }
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
        $sql = "SELECT DISTINCT status FROM kunjungan ORDER BY status ASC";
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