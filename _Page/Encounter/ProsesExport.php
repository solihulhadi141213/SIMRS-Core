<?php
    ob_start();

    // Load konfigurasi database, session, helper, dan PhpSpreadsheet.
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    require "../../vendor/autoload.php";

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Cell\DataType;
    use PhpOffice\PhpSpreadsheet\Style\Alignment;
    use PhpOffice\PhpSpreadsheet\Style\Border;

    // Baca parameter scalar dari request POST atau GET.
    $getRequestValue = static function ($key, $default = '') {
        $value = $_POST[$key] ?? $_GET[$key] ?? $default;
        return is_scalar($value) ? trim((string)$value) : $default;
    };

    $mode = $getRequestValue('mode');

    // Kirim jumlah data sebagai JSON dan hentikan proses.
    $sendCount = static function ($jumlah, $statusCode = 200) {
        if (ob_get_length()) {
            ob_end_clean();
        }
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['jumlah' => (int)$jumlah]);
        exit;
    };

    // Hentikan proses export dengan pesan yang jelas.
    $stopExport = static function ($message, $statusCode = 400) {
        if (ob_get_length()) {
            ob_end_clean();
        }
        http_response_code($statusCode);
        exit($message);
    };

    // Pastikan sesi aktif sebelum menghitung atau mengekspor data.
    if (empty($SessionIdAkses)) {
        if ($mode === 'count') {
            $sendCount(0, 401);
        }
        $stopExport('Sesi akses sudah berakhir. Silakan login ulang.', 401);
    }

    $periodeData = $getRequestValue('periode_data', 'Semua');
    $timezoneName = trim((string)($SessionUserTimezone ?? ''));
    if ($timezoneName === '') {
        $timezoneName = 'UTC';
    }

    // Gunakan zona waktu user untuk memahami pilihan tanggal, lalu filter timestamp UTC database.
    try {
        $userTimezone = new DateTimeZone($timezoneName);
    } catch (Exception $exception) {
        if ($mode === 'count') {
            $sendCount(0, 500);
        }
        $stopExport('Zona waktu pengguna tidak valid.', 500);
    }
    $utcTimezone = new DateTimeZone('UTC');

    $where = [
        'k.id_kunjungan IS NOT NULL',
        'k.id_kunjungan > 0',
        'k.id_encounter IS NOT NULL',
        "TRIM(k.id_encounter) <> ''"
    ];
    $params = [];
    $types = '';
    $startUtc = null;
    $endUtc = null;

    // Susun rentang tanggal periode berdasarkan waktu pendaftaran kunjungan.
    if ($periodeData === 'Tahun' || $periodeData === 'Bulan') {
        $tahun = $getRequestValue('tahun');
        if (!preg_match('/^\d{4}$/', $tahun) || (int)$tahun < 1) {
            if ($mode === 'count') {
                $sendCount(0);
            }
            $stopExport('Tahun tidak valid.');
        }

        if ($periodeData === 'Bulan') {
            $bulan = $getRequestValue('bulan');
            if (!preg_match('/^(0[1-9]|1[0-2])$/', $bulan)) {
                if ($mode === 'count') {
                    $sendCount(0);
                }
                $stopExport('Bulan tidak valid.');
            }
            $startLocal = DateTimeImmutable::createFromFormat(
                '!Y-m-d',
                $tahun . '-' . $bulan . '-01',
                $userTimezone
            );
            $endLocal = $startLocal ? $startLocal->modify('+1 month') : false;
        } else {
            $startLocal = DateTimeImmutable::createFromFormat(
                '!Y-m-d',
                $tahun . '-01-01',
                $userTimezone
            );
            $endLocal = $startLocal ? $startLocal->modify('+1 year') : false;
        }

        if (!$startLocal || !$endLocal) {
            if ($mode === 'count') {
                $sendCount(0);
            }
            $stopExport('Periode tidak valid.');
        }

        $startUtc = $startLocal->setTimezone($utcTimezone);
        $endUtc = $endLocal->setTimezone($utcTimezone);
    } elseif ($periodeData === 'Periodik') {
        $awal = $getRequestValue('periode_awal');
        $akhir = $getRequestValue('periode_akhir');
        $startLocal = DateTimeImmutable::createFromFormat('!Y-m-d', $awal, $userTimezone);
        $endLocal = DateTimeImmutable::createFromFormat('!Y-m-d', $akhir, $userTimezone);

        if (
            !$startLocal ||
            !$endLocal ||
            $startLocal->format('Y-m-d') !== $awal ||
            $endLocal->format('Y-m-d') !== $akhir
        ) {
            if ($mode === 'count') {
                $sendCount(0);
            }
            $stopExport('Format periode tidak valid.');
        }

        if ($startLocal > $endLocal) {
            if ($mode === 'count') {
                $sendCount(0);
            }
            $stopExport('Periode awal tidak boleh lebih besar dari periode akhir.');
        }

        $startUtc = $startLocal->setTimezone($utcTimezone);
        $endUtc = $endLocal->modify('+1 day')->setTimezone($utcTimezone);
    } elseif ($periodeData !== 'Semua') {
        if ($mode === 'count') {
            $sendCount(0);
        }
        $stopExport('Periode data tidak valid.');
    }

    if ($startUtc && $endUtc) {
        $where[] = 'k.datetime_daftar >= ? AND k.datetime_daftar < ?';
        $params[] = $startUtc->format('Y-m-d H:i:s');
        $params[] = $endUtc->format('Y-m-d H:i:s');
        $types .= 'ss';
    }
    $whereSql = 'WHERE ' . implode(' AND ', $where);

    // Hitung kunjungan yang memenuhi filter periode untuk indikator pada modal export.
    if ($mode === 'count') {
        $stmtCount = mysqli_prepare(
            $Conn,
            "SELECT COUNT(*) AS total FROM kunjungan k $whereSql"
        );
        if (!$stmtCount) {
            $sendCount(0, 500);
        }
        if ($params && !mysqli_stmt_bind_param($stmtCount, $types, ...$params)) {
            mysqli_stmt_close($stmtCount);
            $sendCount(0, 500);
        }
        if (!mysqli_stmt_execute($stmtCount)) {
            mysqli_stmt_close($stmtCount);
            $sendCount(0, 500);
        }
        $resultCount = mysqli_stmt_get_result($stmtCount);
        $dataCount = $resultCount ? mysqli_fetch_assoc($resultCount) : null;
        mysqli_stmt_close($stmtCount);
        if (!$dataCount) {
            $sendCount(0, 500);
        }
        $sendCount($dataCount['total'] ?? 0);
    }

    // Hanya request POST yang dapat menghasilkan berkas export.
    if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
        $stopExport('Metode request tidak valid.', 405);
    }

    // Ambil data kunjungan dan identitas pasien untuk spreadsheet.
    $query = "
        SELECT
            k.id_kunjungan,
            k.id_encounter,
            k.id_pasien,
            p.nama AS nama_pasien,
            p.id_ihs,
            k.datetime_daftar,
            k.datetime_pelayanan,
            k.datetime_selesai,
            k.jenis_kunjungan,
            k.prioritas,
            k.keluhan,
            k.dokter,
            k.dpjp_nama,
            k.poliklinik,
            k.kelas,
            k.ruang_rawat,
            k.tempat_tidur,
            k.pembayaran_metode,
            k.pembayaran_penanggung,
            k.status,
            k.petugas_nama
        FROM kunjungan k
        LEFT JOIN pasien p ON p.id_pasien = k.id_pasien
        $whereSql
        ORDER BY k.id_kunjungan ASC
    ";

    $stmt = mysqli_prepare($Conn, $query);
    if (!$stmt) {
        $stopExport('Gagal menyiapkan query export.', 500);
    }
    if ($params && !mysqli_stmt_bind_param($stmt, $types, ...$params)) {
        mysqli_stmt_close($stmt);
        $stopExport('Gagal mengikat parameter filter export.', 500);
    }
    if (!mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        $stopExport('Gagal mengambil data kunjungan untuk export.', 500);
    }
    $result = mysqli_stmt_get_result($stmt);
    if (!$result) {
        mysqli_stmt_close($stmt);
        $stopExport('Gagal membaca hasil query export.', 500);
    }

    // Siapkan kolom spreadsheet.
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Data Encounter');
    $headers = [
        'No',
        'ID Kunjungan',
        'ID Encounter',
        'No. RM',
        'Nama Pasien',
        'ID IHS Pasien',
        'Waktu Daftar',
        'Waktu Pelayanan',
        'Waktu Selesai',
        'Jenis Kunjungan',
        'Prioritas',
        'Keluhan',
        'Dokter',
        'Dokter DPJP',
        'Poliklinik',
        'Kelas',
        'Ruang Rawat',
        'Tempat Tidur',
        'Metode Pembayaran',
        'Penanggung Pembayaran',
        'Status',
        'Petugas Pendaftaran'
    ];
    $lastColumn = 'V';

    $columns = range('A', $lastColumn);
    foreach ($headers as $index => $header) {
        $sheet->setCellValue($columns[$index] . '1', $header);
    }

    $sheet->getStyle('A1:' . $lastColumn . '1')->applyFromArray([
        'font' => ['bold' => true],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER
        ],
        'borders' => [
            'allBorders' => ['borderStyle' => Border::BORDER_THIN]
        ]
    ]);

    // Tulis data sebagai teks agar nilai dari database tidak dianggap formula Excel.
    $textColumns = [
        'B' => 'id_kunjungan',
        'C' => 'id_encounter',
        'D' => 'id_pasien',
        'E' => 'nama_pasien',
        'F' => 'id_ihs',
        'J' => 'jenis_kunjungan',
        'K' => 'prioritas',
        'L' => 'keluhan',
        'M' => 'dokter',
        'N' => 'dpjp_nama',
        'O' => 'poliklinik',
        'P' => 'kelas',
        'Q' => 'ruang_rawat',
        'R' => 'tempat_tidur',
        'S' => 'pembayaran_metode',
        'T' => 'pembayaran_penanggung',
        'U' => 'status',
        'V' => 'petugas_nama'
    ];
    $rowNumber = 2;
    $number = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $sheet->setCellValue('A' . $rowNumber, $number);
        foreach ($textColumns as $column => $field) {
            $value = (string)($row[$field] ?? '');
            $sheet->setCellValueExplicit(
                $column . $rowNumber,
                $value,
                DataType::TYPE_STRING
            );
        }

        foreach ([
            'G' => 'datetime_daftar',
            'H' => 'datetime_pelayanan',
            'I' => 'datetime_selesai'
        ] as $column => $field) {
            $dateValue = $row[$field] ?? '';
            if ($dateValue !== '') {
                $dateTime = DateTimeImmutable::createFromFormat(
                    '!Y-m-d H:i:s',
                    (string)$dateValue,
                    $utcTimezone
                );
                $dateErrors = DateTimeImmutable::getLastErrors();
                if (
                    $dateTime &&
                    ($dateErrors === false || ($dateErrors['warning_count'] === 0 && $dateErrors['error_count'] === 0)) &&
                    $dateTime->format('Y-m-d H:i:s') === (string)$dateValue
                ) {
                    $dateValue = $dateTime->setTimezone($userTimezone)->format('d/m/Y H:i:s T');
                }
            }
            $sheet->setCellValueExplicit(
                $column . $rowNumber,
                (string)$dateValue,
                DataType::TYPE_STRING
            );
        }

        $sheet->getStyle('A' . $rowNumber . ':' . $lastColumn . $rowNumber)->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);
        $rowNumber++;
        $number++;
    }
    mysqli_stmt_close($stmt);

    // Sesuaikan lebar kolom dan pertahankan header saat menggulir.
    foreach (range('A', $lastColumn) as $column) {
        $sheet->getColumnDimension($column)->setAutoSize(true);
    }
    $sheet->freezePane('A2');

    // Siapkan nama file sesuai filter periode yang dipilih.
    $suffix = 'Semua';
    if ($periodeData === 'Tahun') {
        $suffix = $getRequestValue('tahun');
    } elseif ($periodeData === 'Bulan') {
        $suffix = $getRequestValue('tahun') . $getRequestValue('bulan');
    } elseif ($periodeData === 'Periodik') {
        $suffix = $getRequestValue('periode_awal') . '_sd_' . $getRequestValue('periode_akhir');
    }
    $filename = 'Data_Encounter_' . $suffix . '_' . date('YmdHis') . '.xlsx';

    // Kirim workbook sebagai file XLSX.
    if (ob_get_length()) {
        ob_end_clean();
    }
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    header('Pragma: public');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
?>
