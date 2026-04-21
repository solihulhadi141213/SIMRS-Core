<?php
    date_default_timezone_set('Asia/Jakarta');

    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger text-center">
                <small>Sesi akses sudah berakhir, silakan login ulang.</small>
            </div>
        ';
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo '
            <div class="alert alert-danger text-center">
                <small>Metode request tidak valid.</small>
            </div>
        ';
        exit;
    }

    if (empty($_POST['id_poliklinik'])) {
        echo '
            <div class="alert alert-danger text-center">
                <small>ID poliklinik tidak boleh kosong.</small>
            </div>
        ';
        exit;
    }

    $id_poliklinik = (int) $_POST['id_poliklinik'];

    $stmt = mysqli_prepare(
        $Conn,
        "SELECT
            p.*,
            COALESCE(dokter.jumlah_dokter, 0) AS jumlah_dokter,
            COALESCE(jadwal.jumlah_jadwal, 0) AS jumlah_jadwal
         FROM poliklinik p
         LEFT JOIN (
            SELECT id_poliklinik, COUNT(DISTINCT id_dokter) AS jumlah_dokter
            FROM jadwal_dokter
            GROUP BY id_poliklinik
         ) dokter ON p.id_poliklinik = dokter.id_poliklinik
         LEFT JOIN (
            SELECT id_poliklinik, COUNT(*) AS jumlah_jadwal
            FROM jadwal_dokter
            GROUP BY id_poliklinik
         ) jadwal ON p.id_poliklinik = jadwal.id_poliklinik
         WHERE p.id_poliklinik = ?"
    );

    if (!$stmt) {
        echo '
            <div class="alert alert-danger text-center">
                <small>Gagal menyiapkan query data poliklinik.</small>
            </div>
        ';
        exit;
    }

    mysqli_stmt_bind_param($stmt, "i", $id_poliklinik);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result || mysqli_num_rows($result) == 0) {
        mysqli_stmt_close($stmt);
        echo '
            <div class="alert alert-warning text-center">
                <small>Data poliklinik tidak ditemukan.</small>
            </div>
        ';
        exit;
    }

    $data = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    $status_badge = ((int) ($data['status'] ?? 0) === 1)
        ? '<span class="badge bg-success">Aktif</span>'
        : '<span class="badge bg-secondary">Tidak Aktif</span>';

    $updatetime = !empty($data['updatetime']) ? date('d/m/Y H:i', strtotime($data['updatetime'])) : '-';

    $stmtJadwal = mysqli_prepare(
        $Conn,
        "SELECT
            d.nama,
            jd.hari,
            jd.jam_mulai,
            jd.jam_selesai
         FROM jadwal_dokter jd
         INNER JOIN dokter d ON jd.id_dokter = d.id_dokter
         WHERE jd.id_poliklinik = ?
         ORDER BY
            d.nama ASC,
            FIELD(jd.hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'),
            jd.jam_mulai ASC"
    );

    $jadwal_by_dokter = [];

    if ($stmtJadwal) {
        mysqli_stmt_bind_param($stmtJadwal, "i", $id_poliklinik);
        mysqli_stmt_execute($stmtJadwal);
        $resultJadwal = mysqli_stmt_get_result($stmtJadwal);

        while ($row = mysqli_fetch_assoc($resultJadwal)) {
            $nama_dokter = $row['nama'] ?? 'Dokter';
            $jadwal_by_dokter[$nama_dokter][] = [
                'hari' => $row['hari'] ?? '-',
                'jam_mulai' => !empty($row['jam_mulai']) ? date('H:i', strtotime($row['jam_mulai'])) : '-',
                'jam_selesai' => !empty($row['jam_selesai']) ? date('H:i', strtotime($row['jam_selesai'])) : '-'
            ];
        }

        mysqli_stmt_close($stmtJadwal);
    }
?>
<div class="row mb-2">
    <div class="col-12">
        <small><b># Detail Poliklinik</b></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>ID</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo (int) $data['id_poliklinik']; ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Nama Poliklinik</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo htmlspecialchars($data['poliklinik'] ?? ''); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Kode Poli</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo htmlspecialchars($data['kode'] ?? '-'); ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Jumlah Dokter</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo (int) ($data['jumlah_dokter'] ?? 0); ?> Dokter</small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Jumlah Jadwal</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo (int) ($data['jumlah_jadwal'] ?? 0); ?> Jadwal</small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Updated At</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text-muted"><?php echo $updatetime; ?></small></div>
</div>
<div class="row mb-3">
    <div class="col-4"><small>Status</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><?php echo $status_badge; ?></div>
</div>

<div class="row mt-4 mb-2">
    <div class="col-12">
        <small><b># Jadwal Dokter</b></small>
    </div>
</div>

<?php if (empty($jadwal_by_dokter)) { ?>
    <div class="alert alert-warning text-center mb-0">
        <small>Belum ada jadwal dokter untuk poliklinik ini.</small>
    </div>
<?php } else { ?>
    <div class="table-responsive">
        <table class="table table-bordered table-sm table-hover mb-0">
            <thead>
                <tr>
                    <td class="text-center"><small><b>No</b></small></td>
                    <td><small><b>Nama Dokter</b></small></td>
                    <td><small><b>Hari dan Jam Praktik</b></small></td>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($jadwal_by_dokter as $nama_dokter => $items) { ?>
                    <tr>
                        <td class="text-center">
                            <small class="text-muted"><?php echo $no; ?></small>
                        </td>
                        <td>
                            <small class="text-muted"><?php echo htmlspecialchars($nama_dokter); ?></small>
                        </td>
                        <td>
                            <?php foreach ($items as $item) { ?>
                                <div class="mb-1">
                                    <small class="text-muted">
                                        <?php echo htmlspecialchars($item['hari']); ?> :
                                        <?php echo htmlspecialchars($item['jam_mulai']); ?> - <?php echo htmlspecialchars($item['jam_selesai']); ?>
                                    </small>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>
                <?php $no++; } ?>
            </tbody>
        </table>
    </div>
<?php } ?>
