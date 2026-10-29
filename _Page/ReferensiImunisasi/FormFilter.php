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
    include "../../_Config/Session.php";

    // =========================================================
    // VALIDASI SESSION
    // =========================================================
    if (empty($SessionIdAkses)) {

        echo '
            <div class="alert alert-danger mb-0">
                <small>Sesi Akses Sudah Berakhir, Silahkan Login Ulang</small>
            </div>
        ';

        exit;
    }

    // =========================================================
    // TANGKAP TIPE PENCARIAN
    // =========================================================
    $keyword_by = validateAndSanitizeInput($_POST['keyword_by'] ?? '');

    // =========================================================
    // KOLOM YANG MENGGUNAKAN INPUT TEXT
    // =========================================================
    $text_columns = [
        'nama_vaksin',
        'kode_cvx',
        'kode_kemenkes',
        'display_vaksin',
        'system_vaksin',
        'target_penyakit'
    ];

    // =========================================================
    // OUTPUT FORM PENCARIAN BERDASARKAN TIPE
    // =========================================================
    if (in_array($keyword_by, $text_columns)) {

        echo '
            <input
                type="text"
                name="keyword"
                id="keyword_form"
                class="form-control"
                placeholder="Masukkan kata kunci"
            >
        ';

    } elseif ($keyword_by === 'status') {

        echo '
            <select
                name="keyword"
                id="keyword_form"
                class="form-control"
            >
                <option value="">Pilih Status</option>
                <option value="1">Aktif</option>
                <option value="0">Non-aktif</option>
            </select>
        ';

    } else {

        // Default: input text untuk kolom yang tidak dikenali
        echo '
            <input
                type="text"
                name="keyword"
                id="keyword_form"
                class="form-control"
                placeholder="kata kunci..."
            >
        ';
    }
?>
