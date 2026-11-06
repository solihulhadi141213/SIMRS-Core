<?php
    // ==========================================
    // FormHapus.php - Konfirmasi Hapus Episode Perawatan
    // ==========================================

    date_default_timezone_set('UTC');

    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger text-center">
                <small>Sesi akses sudah berakhir, silakan login ulang.</small>
            </div>
            <script>
                $("#ButtonHapus").prop("disabled", true);
            </script>
        ';
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo '<div class="alert alert-danger">Metode request tidak valid.</div>';
        echo '<script>$("#ButtonHapus").prop("disabled", true);</script>';
        exit;
    }

    if (empty($_POST['id_episode_perawatan'])) {
        echo '<div class="alert alert-danger">ID Episode Perawatan tidak boleh kosong.</div>';
        echo '<script>$("#ButtonHapus").prop("disabled", true);</script>';
        exit;
    }

    $id_episode_perawatan = (int) $_POST['id_episode_perawatan'];

    $stmt = mysqli_prepare(
        $Conn,
        "SELECT 
            e.*, 
            p.nama AS nama_pasien, 
            p.nik, 
            d.nama AS nama_dokter
         FROM episode_perawatan e
         LEFT JOIN pasien p ON p.id_pasien = e.id_pasien
         LEFT JOIN dokter d ON d.id_dokter = e.id_dokter
         WHERE e.id_episode_perawatan = ?
         LIMIT 1"
    );

    if (!$stmt) {
        echo '<div class="alert alert-danger">Gagal prepare query.</div>';
        echo '<script>$("#ButtonHapus").prop("disabled", true);</script>';
        exit;
    }

    mysqli_stmt_bind_param($stmt, "i", $id_episode_perawatan);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result || mysqli_num_rows($result) == 0) {
        mysqli_stmt_close($stmt);
        echo '<div class="alert alert-warning">Data episode perawatan tidak ditemukan.</div>';
        echo '<script>$("#ButtonHapus").prop("disabled", true);</script>';
        exit;
    }

    $data = mysqli_fetch_assoc($result);

    // Format Tanggal Mulai
    $date_start = '-';
    if (!empty($data['date_start']) && $data['date_start'] !== '0000-00-00') {
        $dt = DateTime::createFromFormat('Y-m-d', $data['date_start']);
        $date_start = $dt ? $dt->format('d/m/Y') : $data['date_start'];
    }

    // Badge Status Perawatan (FHIR EpisodeOfCare)
    $badge_status = [
        'planned'          => 'secondary',
        'waitlist'         => 'info',
        'active'           => 'success',
        'onhold'           => 'warning',
        'finished'         => 'primary',
        'cancelled'        => 'danger',
        'entered-in-error' => 'dark'
    ];
    $badgeClass = $badge_status[$data['status'] ?? ''] ?? 'secondary';
    $statusBadge = '<span class="badge bg-' . $badgeClass . '">' . htmlspecialchars($data['status'] ?? '-') . '</span>';

    // Format Waktu Pembuatan (creat_at)
    $creat_at = '-';
    if (!empty($data['creat_at'])) {
        $timezoneName = trim((string)($SessionUserTimezone ?? ''));
        if (preg_match('/^UTC([+-])(\d{2}):(\d{2})$/', $timezoneName, $timezoneOffset)) {
            $timezoneName = $timezoneOffset[1] . $timezoneOffset[2] . ':' . $timezoneOffset[3];
        }
        try {
            $userTimezone = new DateTimeZone($timezoneName !== '' ? $timezoneName : 'UTC');
        } catch (Throwable $e) {
            $userTimezone = new DateTimeZone('UTC');
        }
        try {
            $dt = new DateTimeImmutable((string)$data['creat_at'], new DateTimeZone('UTC'));
            $creat_at = $dt->setTimezone($userTimezone)->format('d/m/Y H:i T');
        } catch (Throwable $e) {
            $creat_at = date('d/m/Y H:i', strtotime((string)$data['creat_at']));
        }
    }
?>
    <input type="hidden" name="id_episode_perawatan" value="<?php echo $id_episode_perawatan; ?>">

    <div class="row mb-2">
        <div class="col-4"><small>ID Episode</small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text-muted"><?php echo (int) $data['id_episode_perawatan']; ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small>Kode Episode</small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small><code><?php echo htmlspecialchars($data['kode_episode_perawatan'] ?? '-'); ?></code></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small>Nama Pasien</small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text-primary fw-bold"><?php echo htmlspecialchars($data['nama_pasien'] ?? '-'); ?> (RM: <?php echo (int) $data['id_pasien']; ?>)</small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small>Nama Episode</small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text-muted"><?php echo htmlspecialchars($data['episode_name'] ?? '-'); ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small>Dokter DPJP</small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text-muted"><?php echo htmlspecialchars($data['nama_dokter'] ?? '-'); ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small>Tanggal Mulai</small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text-muted"><?php echo $date_start; ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small>Status Perawatan</small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><?php echo $statusBadge; ?></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small>Dibuat Pada</small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text-muted"><?php echo $creat_at; ?></small></div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="alert alert-danger text-center mb-0">
                <b>PENTING!</b><br>
                <small>
                    Data episode perawatan ini akan dihapus permanen dari sistem.<br>
                    <b>Apakah Anda yakin akan menghapus data ini?</b>
                </small>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Aktifkan kembali tombol Hapus setelah form detail berhasil dimuat
            $('#ButtonHapus').prop('disabled', false);
        });
    </script>
<?php
    mysqli_stmt_close($stmt);
?>