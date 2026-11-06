<?php
    // ==========================================================
    // FormFilter.php
    // Routing tipe input "Kata Kunci" berdasarkan keyword_by.
    // Hasilnya dimasukkan jQuery ke dalam #FormFilter.
    // Semua input memakai name="keyword" & id="keyword_form"
    // agar cocok dengan TabelEpisodePerawatan.php dan autofocus.
    // ==========================================================

    // Load konfigurasi & helper
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // ------------------------------------------------------
    // 1. VALIDASI SESSION
    // Form ini membaca data dari database, jadi wajib login
    // ------------------------------------------------------
    if (empty($SessionIdAkses)) {
        echo '<small class="text-danger">Sesi login berakhir. Silakan login kembali.</small>';
        exit;
    }

    // ------------------------------------------------------
    // 2. AMBIL PARAMETER
    // keyword_by hanya dibandingkan dengan nilai tetap (switch),
    // tidak pernah dimasukkan ke dalam query SQL
    // ------------------------------------------------------
    $keyword_by = $_POST['keyword_by'] ?? '';

    // ------------------------------------------------------
    // 3. ROUTING FORM BERDASARKAN keyword_by
    // ------------------------------------------------------
    switch ($keyword_by) {

        // --------------------------------------------------
        // A. DOKTER -> select option (distinct dari episode_perawatan)
        // Value = id_dokter (diterima TabelEpisodePerawatan.php),
        // label = nama dokter dari tabel dokter
        // --------------------------------------------------
        case 'id_dokter':
            $sql = "
                SELECT DISTINCT d.id_dokter, d.nama
                FROM episode_perawatan e
                INNER JOIN dokter d ON d.id_dokter = e.id_dokter
                ORDER BY d.nama ASC
            ";
            $result = $Conn->execute_query($sql);

            echo '<select name="keyword" id="keyword_form" class="form-control">';
            echo '  <option value="">Pilih</option>';
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . (int) $row['id_dokter'] . '">' . htmlspecialchars($row['nama']) . '</option>';
                }
            }
            echo '</select>';
            break;

        // --------------------------------------------------
        // B. STATUS -> select option (distinct dari episode_perawatan)
        // Hanya status yang benar-benar dipakai data yang tampil
        // --------------------------------------------------
        case 'status':
            $sql    = "SELECT DISTINCT status FROM episode_perawatan ORDER BY status ASC";
            $result = $Conn->execute_query($sql);

            echo '<select name="keyword" id="keyword_form" class="form-control">';
            echo '  <option value="">Pilih</option>';
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $status = htmlspecialchars($row['status']);
                    echo '<option value="' . $status . '">' . $status . '</option>';
                }
            }
            echo '</select>';
            break;

        // --------------------------------------------------
        // C. TANGGAL MULAI -> input date (format YYYY-MM-DD)
        // --------------------------------------------------
        case 'date_start':
            echo '<input type="date" name="keyword" id="keyword_form" class="form-control">';
            break;

        // --------------------------------------------------
        // D. DEFAULT -> input text
        // Berlaku untuk: id_pasien, nama, episode_name,
        // IdEpisodeOfCare, dan saat keyword_by kosong / tidak dikenal
        // --------------------------------------------------
        default:
            echo '<input type="text" name="keyword" id="keyword_form" class="form-control">';
            break;
    }
?>