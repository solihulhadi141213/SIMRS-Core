<?php
    // ==========================================
    // FormDetail.php - Detail Episode Perawatan
    // ==========================================

    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";

    // Validasi Session Login
    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger">
                <small>Sesi akses sudah berakhir! Silahkan login ulang.</small>
            </div>
        ';
        exit;
    }

    // Validasi ID Episode Perawatan
    if (empty($_POST['id_episode_perawatan'])) {
        echo '
            <div class="alert alert-danger">
                <small>ID Episode Perawatan tidak boleh kosong!</small>
            </div>
        ';
        exit;
    }

    $id_episode_perawatan = trim($_POST['id_episode_perawatan']);
    if (!ctype_digit($id_episode_perawatan)) {
        echo '
            <div class="alert alert-danger">
                <small>ID Episode Perawatan tidak valid!</small>
            </div>
        ';
        exit;
    }
    $id_episode_perawatan = (int) $id_episode_perawatan;

    // Query Detail Episode Perawatan beserta Relasi Pasien, Dokter, dan Diagnosis
    $query = "
        SELECT 
            e.*, 
            p.nama AS nama_pasien, 
            p.id_ihs, 
            p.nik, 
            p.no_bpjs, 
            p.gender, 
            p.tempat_lahir, 
            p.tanggal_lahir,
            d.nama AS nama_dokter,
            d.kategori AS kategori_dokter,
            dg.icd_kode,
            dg.icd_deskripsi
        FROM episode_perawatan e
        LEFT JOIN pasien p ON p.id_pasien = e.id_pasien
        LEFT JOIN dokter d ON d.id_dokter = e.id_dokter
        LEFT JOIN diagnosis dg ON dg.id_diagnosis = e.id_diagnosis
        WHERE e.id_episode_perawatan = ?
        LIMIT 1
    ";

    $stmt = mysqli_prepare($Conn, $query);

    if (!$stmt) {
        echo '
            <div class="alert alert-danger">
                <small>Gagal mempersiapkan query : ' . mysqli_error($Conn) . '</small>
            </div>
        ';
        exit;
    }

    mysqli_stmt_bind_param($stmt, "i", $id_episode_perawatan);

    if (!mysqli_stmt_execute($stmt)) {
        echo '
            <div class="alert alert-danger">
                <small>Gagal menjalankan query : ' . mysqli_stmt_error($stmt) . '</small>
            </div>
        ';
        exit;
    }

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 0) {
        echo '
            <div class="alert alert-danger">
                <small>Data episode perawatan tidak ditemukan!</small>
            </div>
        ';
        exit;
    }

    $row = mysqli_fetch_assoc($result);

    // Helper Empty Value
    function showValue($value){
        return (!empty($value)) ? htmlspecialchars($value) : '-';
    }

    // Format Tanggal Lahir Pasien
    $tanggal_lahir = '-';
    if (!empty($row['tanggal_lahir']) && $row['tanggal_lahir'] != '0000-00-00') {
        $dt = DateTime::createFromFormat('Y-m-d', $row['tanggal_lahir']);
        $tanggal_lahir = $dt ? $dt->format('d/m/Y') : $row['tanggal_lahir'];
    }

    // Format Tanggal Mulai Perawatan
    $date_start = '-';
    if (!empty($row['date_start']) && $row['date_start'] != '0000-00-00') {
        $dt = DateTime::createFromFormat('Y-m-d', $row['date_start']);
        $date_start = $dt ? $dt->format('d/m/Y') : $row['date_start'];
    }

    // Format Tanggal Selesai Perawatan
    $date_end = '-';
    if (!empty($row['date_end']) && $row['date_end'] != '0000-00-00') {
        $dt = DateTime::createFromFormat('Y-m-d', $row['date_end']);
        $date_end = $dt ? $dt->format('d/m/Y') : $row['date_end'];
    }

    // Format Datetime Pembuatan
    $creat_at = '-';
    if (!empty($row['creat_at'])) {
        $dt = DateTime::createFromFormat('Y-m-d H:i:s', $row['creat_at']);
        $creat_at = $dt ? $dt->format('d/m/Y H:i') : $row['creat_at'];
    }

    // Badge status FHIR EpisodeOfCare
    $badge_status = [
        'planned'          => 'secondary',
        'waitlist'         => 'info',
        'active'           => 'success',
        'onhold'           => 'warning',
        'finished'         => 'primary',
        'cancelled'        => 'danger',
        'entered-in-error' => 'dark'
    ];
    $badge = $badge_status[$row['status']] ?? 'secondary';

    // Output Tampilan Detail
    echo '
        <div class="row mb-2">
            <div class="col-12"><small><b>A. Informasi Pasien</b></small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Nama Pasien</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-primary fw-bold">' . showValue($row['nama_pasien']) . '</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>ID IHS SATUSEHAT</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">' . showValue($row['id_ihs']) . '</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>NIK / No. KTP</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">' . showValue($row['nik']) . '</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>No. BPJS</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">' . showValue($row['no_bpjs']) . '</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Jenis Kelamin</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">' . showValue($row['gender']) . '</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Tempat Lahir</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">' . showValue($row['tempat_lahir']) . '</small></div>
        </div>
        <div class="row mb-2 mb-3">
            <div class="col-4"><small>Tanggal Lahir</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">' . $tanggal_lahir . '</small></div>
        </div>
        <hr>

        <div class="row mb-2 mt-3">
            <div class="col-12"><small><b>B. Informasi Episode Perawatan</b></small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Kode Episode</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small><code>' . showValue($row['kode_episode_perawatan']) . '</code></small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Nama Episode</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">' . showValue($row['episode_name']) . '</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Display Episode</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">' . showValue($row['episode_display']) . '</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Kode Sistem</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">' . showValue($row['episode_code']) . '</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Diagnosis Pasien</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">';
            if (!empty($row['icd_kode'])) {
                echo '<span class="badge bg-light text-dark border">[' . htmlspecialchars($row['icd_kode']) . ']</span> ' . htmlspecialchars($row['icd_deskripsi']);
            } else {
                echo '-';
            }
    echo '  </small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Dokter DPJP</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">' . showValue($row['nama_dokter']) . ' <span class="text-secondary">(' . showValue($row['kategori_dokter']) . ')</span></small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Tanggal Mulai</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">' . $date_start . '</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Tanggal Selesai</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">' . $date_end . '</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Status Perawatan</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small><span class="badge bg-' . $badge . '">' . showValue($row['status']) . '</span></small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>ID EpisodeOfCare</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted"><em>' . showValue($row['IdEpisodeOfCare']) . '</em></small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Dibuat Oleh</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">' . showValue($row['creat_by_name']) . ' pada ' . $creat_at . '</small></div>
        </div>
    ';

    // Close statement
    mysqli_stmt_close($stmt);
?>