<?php
// Keluarkan kontrol pencarian yang sesuai dengan kolom yang dipilih pada modal filter.
include "../../_Config/Connection.php";
include "../../_Config/Session.php";
// Endpoint ini hanya dapat dipanggil oleh sesi aktif melalui permintaan POST.
if (empty($SessionIdAkses)) {
    http_response_code(401);
    exit;
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit;
}

$field = (string) ($_POST['keyword_by'] ?? '');
// Kolom teks yang diizinkan memakai input biasa; daftar ini mencegah kolom tak dikenal diproses.
$textFields = [
    'nama_pasien',
    'kode_booking',
    'nama_poliklinik',
    'nama_dokter',
    'jadwal',
    'no_antrian',
    'id_pasien',
    'id_kunjungan',
];

// Pilih tipe kontrol berdasarkan jenis kolom, dan ambil pilihan dari basis data bila diperlukan.
if ($field === 'datetime_creat' || $field === 'tanggal_kunjungan') {
    echo '<input type="date" name="keyword" id="keyword_form" class="form-control" aria-label="Tanggal pencarian">';
} elseif ($field === 'status_antrian') {
    echo '<select name="keyword" id="keyword_form" class="form-control" aria-label="Status antrian"><option value="">Pilih</option>';
    foreach (['Terdaftar', 'Batal', 'Checkin', 'Panggil Admisi', 'Tunggu Poli', 'Layanan Poli', 'Tunggu Farmasi', 'Layanan Farmasi', 'Selesai'] as $status) {
        $value = htmlspecialchars($status, ENT_QUOTES, 'UTF-8');
        echo '<option value="' . $value . '">' . $value . '</option>';
    }
    echo '</select>';
} elseif ($field === 'sumber_antrian') {
    echo '<select name="keyword" id="keyword_form" class="form-control" aria-label="Sumber antrian"><option value="">Pilih</option>';
    $stmtSource = mysqli_prepare(
        $Conn,
        "SELECT DISTINCT sumber_antrian
         FROM antrian
         WHERE sumber_antrian IS NOT NULL AND sumber_antrian <> ''
         ORDER BY sumber_antrian ASC"
    );
    if (!$stmtSource || !mysqli_stmt_execute($stmtSource)) {
        if ($stmtSource) {
            mysqli_stmt_close($stmtSource);
        }
        error_log('Antrian filter: failed to load sources: ' . mysqli_error($Conn));
        http_response_code(500);
        echo '<option value="" disabled>Gagal memuat sumber antrian</option>';
    } else {
        $result = mysqli_stmt_get_result($stmtSource);
        while ($row = mysqli_fetch_assoc($result)) {
            $source = htmlspecialchars((string) $row['sumber_antrian'], ENT_QUOTES, 'UTF-8');
            echo '<option value="' . $source . '">' . $source . '</option>';
        }
        mysqli_stmt_close($stmtSource);
    }
    echo '</select>';
} elseif ($field === '' || in_array($field, $textFields, true)) {
    echo '<input type="text" name="keyword" id="keyword_form" class="form-control" aria-label="Kata kunci pencarian">';
} else {
    // Tolak kolom yang tidak dikenal dan nonaktifkan input sebagai pengamanan tambahan.
    http_response_code(400);
    echo '<input type="text" name="keyword" id="keyword_form" class="form-control" aria-label="Kata kunci pencarian" disabled>';
}
?>
