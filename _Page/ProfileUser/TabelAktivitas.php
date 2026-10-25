<?php
    date_default_timezone_set('Asia/Jakarta');

    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

    $errorRow = static function (string $message): void {
        echo '<tr><td class="text-center" colspan="4"><small class="text text-danger">'
            . htmlspecialchars($message, ENT_QUOTES, 'UTF-8')
            . '</small></td></tr>';
    };

    if (empty($SessionIdAkses)) {
        $errorRow('Sesi akses berakhir! Silakan login ulang.');
        exit;
    }

    $tahunInput = $_POST['tahun'] ?? '';
    $bulanInput = $_POST['bulan'] ?? '';

    if (!is_string($tahunInput) || !preg_match('/^\d{4}$/D', $tahunInput)
        || (int) $tahunInput < 1000
        || !is_string($bulanInput) || !preg_match('/^(0[1-9]|1[0-2])$/D', $bulanInput)) {
        $errorRow('Tentukan periode tahun dan bulan yang valid.');
        exit;
    }

    $tahun = (int) $tahunInput;
    $bulan = (int) $bulanInput;
    $periodeData = sprintf('%04d-%02d', $tahun, $bulan);
    $startDate = $periodeData . '-01 00:00:00';
    $endDate = (new DateTimeImmutable($startDate))->modify('+1 month')->format('Y-m-d H:i:s');

    $activitySources = [
        ['Pasien', 'Data Master Pasien', 'pasien', 'id_akses', 'registered_at', null],
        ['Kunjungan', 'Kunjungan Rajal/Ranap', 'kunjungan', 'petugas_id', 'datetime_daftar', null],
        ['Kunjungan', 'SEP', 'kunjungan', 'petugas_id', 'datetime_daftar', 'sep'],
        ['Kunjungan', 'Diagnosis', 'diagnosis', 'petugas_id', 'datetime_creat', null],
        ['Kunjungan', 'Tindakan', 'tindakan', 'petugas_id', 'datetime_creat', null],
        ['Pasien', 'Alergi', 'alergi', 'author_id', 'datetime_creat', null],
        ['Kunjungan', 'Observation', 'observation', 'petugas_id', 'datetime_entry', null],
        ['Kunjungan', 'General Consent', 'general_consent', 'petugas_edukasi_id', 'datetime_creat', null]
    ];

    $countQueries = [];
    $bindValues = [];
    $bindTypes = '';

    foreach ($activitySources as [$category, $label, $table, $userColumn, $dateColumn, $requiredColumn]) {
        $countQueries[] = "SELECT '$label' AS label, COUNT(*) AS total
            FROM `$table`
            WHERE `$userColumn` = ? AND `$dateColumn` >= ? AND `$dateColumn` < ?"
            . (isset($requiredColumn) ? " AND `$requiredColumn` IS NOT NULL AND `$requiredColumn` <> ''" : '');
        $bindValues[] = (int) $SessionIdAkses;
        $bindValues[] = $startDate;
        $bindValues[] = $endDate;
        $bindTypes .= 'iss';
    }

    $bindParameters = [];
    foreach ($bindValues as &$bindValue) {
        $bindParameters[] = &$bindValue;
    }
    unset($bindValue);

    try {
        $stmt = $Conn->prepare(implode(' UNION ALL ', $countQueries));
        $stmt->bind_param($bindTypes, ...$bindParameters);
        $stmt->execute();
        $result = $stmt->get_result();
        $activityCounts = [];

        while ($row = $result->fetch_assoc()) {
            $activityCounts[$row['label']] = (int) $row['total'];
        }

        $stmt->close();
    } catch (mysqli_sql_exception $exception) {
        error_log('Gagal memuat ringkasan aktivitas Profile: ' . $exception->getMessage());
        $errorRow('Ringkasan aktivitas gagal dimuat. Silakan coba kembali.');
        exit;
    }

    foreach ($activitySources as $index => [$category, $label]) {
        $categoryAttribute = htmlspecialchars($category, ENT_QUOTES, 'UTF-8');
        $periodAttribute = htmlspecialchars($periodeData, ENT_QUOTES, 'UTF-8');
        $rowClass = in_array($category, ['Pasien', 'Kunjungan'], true) && $index < 2
            ? ' class="modal_detail_aktivitas" data-kategori="' . $categoryAttribute
                . '" data-periode="' . $periodAttribute . '" style="cursor:pointer;"'
            : '';

        echo '<tr' . $rowClass . '>'
            . '<td class="text-center"><small class="text text-muted">' . ($index + 1) . '</small></td>'
            . '<td><small class="text text-muted">' . $categoryAttribute . '</small></td>'
            . '<td><small class="text text-muted">' . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . '</small></td>'
            . '<td class="text-center"><small class="text text-muted">'
            . number_format($activityCounts[$label] ?? 0, 0, ',', '.')
            . '</small></td>'
            . '</tr>';
    }
?>
<script>
    $('.show_modal_filter_aktivitas').text(
        <?php echo json_encode(sprintf('%02d', $bulan)); ?> + ', ' + <?php echo json_encode((string) $tahun); ?>
    );
</script>
