<?php
    // Header Connection dan Session
    header('Content-Type: text/html; charset=utf-8');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

    function observasiDetailMessage(string $message, int $status = 200): void
    {
        http_response_code($status);
        echo '<div class="alert alert-' . ($status >= 400 ? 'danger' : 'secondary') . ' mb-0">'
            . htmlspecialchars($message, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')
            . '</div>';
        exit;
    }

    function observasiDetailEscape($value): string
    {
        return htmlspecialchars((string) ($value ?? '-'), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    function observasiDetailRow(string $label, $value): string
    {
        $displayValue = trim((string) ($value ?? ''));
        if ($displayValue === '') {
            $displayValue = '-';
        }

        return '<div class="row mb-2">'
            . '<div class="col-4"><small>' . observasiDetailEscape($label) . '</small></div>'
            . '<div class="col-1"><small>:</small></div>'
            . '<div class="col-7"><small class="text-muted">' . observasiDetailEscape($displayValue) . '</small></div>'
            . '</div>';
    }

    function observasiDetailSection(string $title): string
    {
        return '<div class="row mb-2"><div class="col-12"><small><b>'
            . observasiDetailEscape($title)
            . '</b></small></div></div>';
    }

    if (empty($SessionIdAkses)) {
        observasiDetailMessage('Sesi akses berakhir. Silakan login kembali.', 401);
    }
    if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
        observasiDetailMessage('Metode request tidak valid.', 405);
    }

    $idObservation = filter_var(
        $_POST['id_observation'] ?? null,
        FILTER_VALIDATE_INT,
        ['options' => ['min_range' => 1]]
    );
    if ($idObservation === false || $idObservation === null) {
        observasiDetailMessage('ID observasi tidak valid.');
    }

    $stmt = mysqli_prepare(
        $Conn,
        'SELECT
            o.id_observation,
            o.observation_id,
            o.id_pasien,
            o.id_kunjungan,
            o.id_praktisi,
            o.nama_praktisi,
            o.observation_value,
            o.datetime_observation,
            o.datetime_entry,
            o.petugas_id,
            o.petugas_nama,
            p.nama AS nama_pasien,
            k.jenis_kunjungan,
            k.datetime_daftar,
            pr.profesi_praktisi,
            r.category_name,
            r.category_code,
            r.category_display,
            r.observation_name,
            r.observation_code,
            r.observation_display,
            r.unit_name,
            r.unit_code,
            r.unit_display,
            r.result_type,
            r.result_coded
        FROM observation o
        LEFT JOIN pasien p ON p.id_pasien = o.id_pasien
        LEFT JOIN kunjungan k ON k.id_kunjungan = o.id_kunjungan
        LEFT JOIN praktisi pr ON pr.id_praktisi = o.id_praktisi
        LEFT JOIN observation_reference r ON r.id_observation_reference = o.id_observation_reference
        WHERE o.id_observation = ?
        LIMIT 1'
    );
    if (!$stmt) {
        error_log('Observasi detail: gagal menyiapkan query: ' . mysqli_error($Conn));
        observasiDetailMessage('Gagal menyiapkan data detail observasi.', 500);
    }

    $idObservation = (int) $idObservation;
    mysqli_stmt_bind_param($stmt, 'i', $idObservation);
    if (!mysqli_stmt_execute($stmt)) {
        error_log('Observasi detail: gagal mengambil data: ' . mysqli_stmt_error($stmt));
        mysqli_stmt_close($stmt);
        observasiDetailMessage('Gagal mengambil detail observasi.', 500);
    }
    $result = mysqli_stmt_get_result($stmt);
    $observation = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$observation) {
        observasiDetailMessage('Data observasi tidak ditemukan.', 404);
    }

    // Timestamp di database disimpan sebagai UTC; tampilkan dalam zona waktu sesi pengguna.
    $timezoneName = trim((string) ($SessionUserTimezone ?? ''));
    if (preg_match('/^UTC([+-])(\d{2}):(\d{2})$/', $timezoneName, $timezoneOffset)) {
        $timezoneName = $timezoneOffset[1] . $timezoneOffset[2] . ':' . $timezoneOffset[3];
    }
    try {
        $userTimezone = new DateTimeZone($timezoneName !== '' ? $timezoneName : 'UTC');
    } catch (Throwable $exception) {
        $userTimezone = new DateTimeZone('UTC');
    }
    $utcTimezone = new DateTimeZone('UTC');
    $formatDateTime = static function ($value) use ($utcTimezone, $userTimezone): string {
        if (trim((string) ($value ?? '')) === '') {
            return '-';
        }
        try {
            return (new DateTimeImmutable((string) $value, $utcTimezone))
                ->setTimezone($userTimezone)
                ->format('d/m/Y H:i T');
        } catch (Throwable $exception) {
            return '-';
        }
    };

    $categoryName = $observation['category_display'] ?: $observation['category_name'];
    $observationName = $observation['observation_display'] ?: $observation['observation_name'];
    $unitName = $observation['unit_display'] ?: $observation['unit_name'];
    $valueDisplay = (string) $observation['observation_value'];

    if ($observation['result_type'] === 'Coded') {
        $codedOptions = json_decode((string) ($observation['result_coded'] ?? ''), true);
        if (is_array($codedOptions)) {
            foreach ($codedOptions as $option) {
                if (is_array($option) && (string) ($option['value'] ?? '') === $valueDisplay) {
                    $valueDisplay = (string) ($option['label'] ?? $valueDisplay);
                    break;
                }
            }
        }
    } elseif ($observation['result_type'] === 'Boolean' && in_array($valueDisplay, ['0', '1'], true)) {
        $valueDisplay = $valueDisplay === '1' ? '1 (Ya)' : '0 (Tidak)';
    }

    echo observasiDetailSection('A. Informasi Pasien Dan Kunjungan')
        . observasiDetailRow('No. RM', $observation['id_pasien'])
        . observasiDetailRow('ID Kunjungan', $observation['id_kunjungan'])
        . observasiDetailRow('Nama pasien', $observation['nama_pasien'])
        . observasiDetailRow('Jenis kunjungan', $observation['jenis_kunjungan'])
        . observasiDetailRow('Tanggal kunjungan', $formatDateTime($observation['datetime_daftar']))
        . '<hr>'
        . observasiDetailSection('B. Informasi Observasi')
        . observasiDetailRow('Kategori', $categoryName)
        . observasiDetailRow('Kode kategori', $observation['category_code'])
        . observasiDetailRow('Jenis observasi', $observationName)
        . observasiDetailRow('Kode observasi', $observation['observation_code'])
        . observasiDetailRow('Hasil', $valueDisplay)
        . observasiDetailRow('Satuan', $unitName)
        . observasiDetailRow('Kode satuan', $observation['unit_code'])
        . observasiDetailRow('Tipe hasil', $observation['result_type'])
        . observasiDetailRow('Waktu observasi', $formatDateTime($observation['datetime_observation']))
        . '<hr>'
        . observasiDetailSection('C. Petugas Pemeriksa')
        . observasiDetailRow('Nama Petugas', $observation['nama_praktisi'])
        . observasiDetailRow('Profesi Petugas', $observation['profesi_praktisi'])
        . '<hr>'
        . observasiDetailSection('D. Informasi Pencatatan')
        . observasiDetailRow('Petugas input', $observation['petugas_nama'])
        . observasiDetailRow('Waktu input', $formatDateTime($observation['datetime_entry']))
        . observasiDetailRow('ID SATUSEHAT', $observation['observation_id']);
?>
