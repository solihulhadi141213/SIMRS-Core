<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 0);
    ob_start();

    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    require '../../vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Style\Alignment;
    use PhpOffice\PhpSpreadsheet\Style\Border;
    use PhpOffice\PhpSpreadsheet\Cell\DataType;

    function stopExportAntrian($message) {
        if (ob_get_length()) {
            ob_end_clean();
        }
        echo $message;
        exit;
    }

    if (empty($SessionIdAkses)) {
        stopExportAntrian('Sesi akses sudah berakhir!');
    }

    $mode = (string) ($_POST['mode'] ?? $_GET['mode'] ?? '');
    $periodeData = (string) ($_POST['periode_data'] ?? $_GET['periode_data'] ?? 'Semua');

    function buildAntrianExportWhere($periodeData, &$params, &$types) {
        $where = [];
        $params = [];
        $types = '';

        if ($periodeData === 'Tahun') {
            $tahun = trim((string) ($_POST['tahun'] ?? $_GET['tahun'] ?? ''));
            if ($tahun === '' || !preg_match('/^\d{4}$/', $tahun)) {
                stopExportAntrian('Tahun tidak valid!');
            }
            $where[] = 'YEAR(a.datetime_creat) = ?';
            $params[] = (int) $tahun;
            $types .= 'i';
        } elseif ($periodeData === 'Bulan') {
            $tahun = trim((string) ($_POST['tahun'] ?? $_GET['tahun'] ?? ''));
            $bulan = trim((string) ($_POST['bulan'] ?? $_GET['bulan'] ?? ''));
            if ($tahun === '' || !preg_match('/^\d{4}$/', $tahun)) {
                stopExportAntrian('Tahun tidak valid!');
            }
            if ($bulan === '' || !preg_match('/^(0[1-9]|1[0-2])$/', $bulan)) {
                stopExportAntrian('Bulan tidak valid!');
            }
            $where[] = 'YEAR(a.datetime_creat) = ? AND MONTH(a.datetime_creat) = ?';
            $params[] = (int) $tahun;
            $params[] = (int) $bulan;
            $types .= 'ii';
        } elseif ($periodeData === 'Periodik') {
            $awal = trim((string) ($_POST['periode_awal'] ?? $_GET['periode_awal'] ?? ''));
            $akhir = trim((string) ($_POST['periode_akhir'] ?? $_GET['periode_akhir'] ?? ''));
            $dAwal = DateTime::createFromFormat('Y-m-d', $awal);
            $dAkhir = DateTime::createFromFormat('Y-m-d', $akhir);
            if (!$dAwal || $dAwal->format('Y-m-d') !== $awal || !$dAkhir || $dAkhir->format('Y-m-d') !== $akhir) {
                stopExportAntrian('Format periode tidak valid!');
            }
            if ($dAwal > $dAkhir) {
                stopExportAntrian('Periode awal tidak boleh lebih besar dari periode akhir!');
            }
            $where[] = 'DATE(a.datetime_creat) >= ? AND DATE(a.datetime_creat) <= ?';
            $params[] = $awal;
            $params[] = $akhir;
            $types .= 'ss';
        } elseif ($periodeData !== 'Semua') {
            stopExportAntrian('Periode data tidak valid!');
        }

        return $where ? 'WHERE ' . implode(' AND ', $where) : '';
    }

    $params = [];
    $types = '';
    $whereSql = buildAntrianExportWhere($periodeData, $params, $types);

    // =========================================================
    // MODE COUNT (AJAX)
    // =========================================================
    if ($mode === 'count') {
        header('Content-Type: application/json; charset=utf-8');
        if (ob_get_length()) {
            ob_end_clean();
        }

        $sql = "SELECT COUNT(*) AS total FROM antrian a " . $whereSql;
        $stmt = mysqli_prepare($Conn, $sql);
        if (!$stmt) {
            echo json_encode(['jumlah' => 0, 'error' => mysqli_error($Conn)]);
            exit;
        }
        if ($types !== '') {
            mysqli_stmt_bind_param($stmt, $types, ...$params);
        }
        if (!mysqli_stmt_execute($stmt)) {
            echo json_encode(['jumlah' => 0, 'error' => mysqli_stmt_error($stmt)]);
            mysqli_stmt_close($stmt);
            exit;
        }
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        echo json_encode(['jumlah' => (int) ($row['total'] ?? 0)]);
        exit;
    }

    // =========================================================
    // QUERY DATA
    // =========================================================
    $sql = "
        SELECT
            a.*,
            p.nama AS nama_pasien_join,
            d.nama AS dokter_nama_join,
            pol.poliklinik AS poliklinik_nama_join,
            pol.kode AS kode_poliklinik_join
        FROM antrian a
        LEFT JOIN pasien p ON p.id_pasien = a.id_pasien
        LEFT JOIN dokter d ON d.id_dokter = a.id_dokter
        LEFT JOIN poliklinik pol ON pol.id_poliklinik = a.id_poliklinik
        " . $whereSql . "
        ORDER BY a.datetime_creat DESC
    ";

    $stmt = mysqli_prepare($Conn, $sql);
    if (!$stmt) {
        stopExportAntrian('Gagal menyiapkan query export: ' . mysqli_error($Conn));
    }
    if ($types !== '') {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    if (!mysqli_stmt_execute($stmt)) {
        stopExportAntrian('Gagal mengambil data export: ' . mysqli_stmt_error($stmt));
    }
    $result = mysqli_stmt_get_result($stmt);

    // =========================================================
    // SPREADSHEET
    // =========================================================
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Data Antrian');

    // Header
    $headers = [
        'No', 'ID Antrian', 'No Antrian', 'Kode Booking', 'ID Pasien', 'Nama Pasien',
        'NIK', 'No BPJS', 'Gender', 'Kontak', 'Pembayaran', 'Keluhan', 'Jenis Referensi',
        'Nomor Referensi', 'Nama Dokter', 'Nama Poliklinik', 'Tanggal Kunjungan',
        'Tanggal Daftar (UTC)', 'Status Antrian', 'Sumber Antrian', 'No. Antrian BPJS?'
    ];
    // Actually keep simple columns
    $headers = [
        'No', 'ID Antrian', 'No Antrian', 'Kode Booking', 'ID Pasien', 'Nama Pasien',
        'NIK', 'No BPJS', 'Gender', 'Pembayaran', 'Keluhan', 'Nama Dokter',
        'Nama Poliklinik', 'Tanggal Kunjungan', 'Tanggal Daftar', 'Status Antrian',
        'Sumber Antrian'
    ];

    $col = 'A';
    foreach ($headers as $h) {
        $sheet->setCellValue($col . '4', $h);
        $col++;
    }

    // Style header
    $lastHeaderCol = chr(ord('A') + count($headers) - 1);
    $sheet->getStyle('A4:' . $lastHeaderCol . '4')->applyFromArray([
        'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
        'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '4472C4']],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
    ]);
    // Need Fill import
    // We'll skip Fill if not imported; but imported? not yet. Add use above? We'll handle by removing fill or import.
    // To avoid missing class, use PhpOffice\\PhpSpreadsheet\\Style\\Fill fully qualified.
    $sheet->getStyle('A4:' . $lastHeaderCol . '4')->applyFromArray([
        'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '4472C4']]
    ]);

    $row = 5;
    $no = 1;
    while ($Data = mysqli_fetch_assoc($result)) {
        $rowData = [
            $no,
            $Data['id_antrian'] ?? '-',
            $Data['no_antrian'] ?? '-',
            $Data['kode_booking'] ?? '-',
            $Data['id_pasien'] ?? '-',
            $Data['nama_pasien'] ?? '-',
            $Data['nik'] ?? '-',
            $Data['no_bpjs'] ?? '-',
            $Data['gender'] ?? '-',
            $Data['pembayaran'] ?? '-',
            $Data['keluhan'] ?? '-',
            $Data['nama_dokter'] ?? '-',
            $Data['nama_poliklinik'] ?? '-',
            $Data['tanggal_kunjungan'] ?? '-',
            $Data['datetime_creat'] ?? '-',
            $Data['status_antrian'] ?? '-',
            $Data['sumber_antrian'] ?? '-'
        ];

        $col = 'A';
        foreach ($rowData as $value) {
            $sheet->setCellValueExplicit(
                $col . $row,
                (string) $value,
                DataType::TYPE_STRING
            );
            $col++;
        }
        $row++;
        $no++;
    }

    $stmt->close();

    $lastRow = max($row - 1, 4);

    // Border
    $sheet->getStyle('A4:' . $lastHeaderCol . $lastRow)->applyFromArray([
        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
    ]);

    // Auto size
    foreach (range('A', $lastHeaderCol) as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    // Freeze
    $sheet->freezePane('A5');

    // Filename
    $suffix = date('YmdHis');
    if ($periodeData === 'Tahun') {
        $suffix = ($_POST['tahun'] ?? '') . '_' . $suffix;
    } elseif ($periodeData === 'Bulan') {
        $suffix = ($_POST['tahun'] ?? '') . ($_POST['bulan'] ?? '') . '_' . $suffix;
    } elseif ($periodeData === 'Periodik') {
        $suffix = ($_POST['periode_awal'] ?? '') . '_sd_' . ($_POST['periode_akhir'] ?? '') . '_' . $suffix;
    } else {
        $suffix = 'Semua_' . $suffix;
    }
    $filename = 'Data_Antrian_' . $suffix . '.xlsx';

    if (ob_get_length()) {
        ob_end_clean();
    }

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    header('Expires: 0');
    header('Pragma: public');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
?>

        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        echo json_encode(['jumlah' => (int) ($row['total'] ?? 0)]);
        exit;
    }

    // =========================================================
    // VALIDASI METHOD (EXPORT)
    // =========================================================
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        stopExportAntrian('Metode request tidak valid!');
    }

