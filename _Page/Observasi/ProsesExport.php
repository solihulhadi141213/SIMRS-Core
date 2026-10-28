<?php
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

ob_start();
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('max_execution_time', '300');
ini_set('memory_limit', '512M');

include "../../_Config/Connection.php";
include "../../_Config/Session.php";
require '../../vendor/autoload.php';

function stopObservasiExport(string $message, int $status = 400): void
{
    if (ob_get_level() > 0 && ob_get_length() !== false) {
        ob_clean();
    }
    http_response_code($status);
    header('Content-Type: text/plain; charset=utf-8');
    echo $message;
    exit;
}

function observasiExportLocalDateTime($value, DateTimeZone $timezone): string
{
    $value = trim((string) ($value ?? ''));
    if ($value === '') {
        return '';
    }
    try {
        return (new DateTimeImmutable($value, new DateTimeZone('UTC')))
            ->setTimezone($timezone)
            ->format('d/m/Y H:i:s T');
    } catch (Throwable $exception) {
        return $value;
    }
}

function observasiExportCodedLabel($json, string $value): string
{
    $options = json_decode((string) ($json ?? ''), true);
    if (is_array($options)) {
        foreach ($options as $option) {
            if (is_array($option) && (string) ($option['value'] ?? '') === $value) {
                return (string) ($option['label'] ?? $value);
            }
        }
    }
    return $value;
}

if (empty($SessionIdAkses)) {
    stopObservasiExport('Sesi akses berakhir. Silakan login kembali.', 401);
}
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'GET') {
    stopObservasiExport('Metode request tidak valid.', 405);
}
if (($_GET['confirm_export'] ?? '') !== '1') {
    stopObservasiExport('Konfirmasi export belum diberikan.', 400);
}

$expectedCount = filter_var(
    $_GET['expected_count'] ?? null,
    FILTER_VALIDATE_INT,
    ['options' => ['min_range' => 1]]
);
if ($expectedCount === false || $expectedCount === null) {
    stopObservasiExport('Jumlah data konfirmasi tidak valid.', 400);
}

$countResult = mysqli_query($Conn, 'SELECT COUNT(*) AS total FROM observation');
if (!$countResult) {
    error_log('Observasi export: gagal menghitung ulang data: ' . mysqli_error($Conn));
    stopObservasiExport('Gagal memeriksa jumlah data observasi.', 500);
}
$currentCount = (int) (mysqli_fetch_assoc($countResult)['total'] ?? 0);
mysqli_free_result($countResult);
if ($currentCount < 1) {
    stopObservasiExport('Tidak ada data observasi yang dapat diekspor.', 404);
}
if ($currentCount !== (int) $expectedCount) {
    stopObservasiExport('Jumlah data berubah setelah konfirmasi. Buka kembali modal export untuk memeriksa jumlah terbaru.', 409);
}

$sql = 'SELECT
            o.id_observation,
            o.id_observation_reference,
            o.observation_id,
            o.id_pasien,
            o.id_kunjungan,
            o.id_praktisi,
            o.nama_praktisi AS nama_praktisi_snapshot,
            o.observation_value,
            o.datetime_observation,
            o.datetime_entry,
            o.petugas_id,
            o.petugas_nama,
            p.nama AS nama_pasien,
            k.jenis_kunjungan,
            k.datetime_daftar,
            pr.nama_praktisi,
            pr.profesi_praktisi,
            r.category_name,
            r.category_code,
            r.category_display,
            r.category_system,
            r.observation_name,
            r.observation_code,
            r.observation_display,
            r.observation_system,
            r.unit_name,
            r.unit_code,
            r.unit_display,
            r.unit_system,
            r.result_type,
            r.result_coded
        FROM observation o
        LEFT JOIN pasien p ON p.id_pasien = o.id_pasien
        LEFT JOIN kunjungan k ON k.id_kunjungan = o.id_kunjungan
        LEFT JOIN praktisi pr ON pr.id_praktisi = o.id_praktisi
        LEFT JOIN observation_reference r ON r.id_observation_reference = o.id_observation_reference
        ORDER BY o.datetime_observation ASC, o.id_observation ASC';
$stmt = mysqli_prepare($Conn, $sql);
if (!$stmt) {
    error_log('Observasi export: gagal menyiapkan query: ' . mysqli_error($Conn));
    stopObservasiExport('Gagal menyiapkan data observasi untuk export.', 500);
}
if (!mysqli_stmt_execute($stmt)) {
    error_log('Observasi export: gagal mengambil data: ' . mysqli_stmt_error($stmt));
    mysqli_stmt_close($stmt);
    stopObservasiExport('Gagal mengambil data observasi untuk export.', 500);
}
$result = mysqli_stmt_get_result($stmt);
if (!$result) {
    error_log('Observasi export: hasil query tidak tersedia: ' . mysqli_stmt_error($stmt));
    mysqli_stmt_close($stmt);
    stopObservasiExport('Gagal membaca data observasi untuk export.', 500);
}

$timezoneName = trim((string) ($SessionUserTimezone ?? ''));
if (preg_match('/^UTC([+-])(\d{2}):(\d{2})$/', $timezoneName, $timezoneOffset)) {
    $timezoneName = $timezoneOffset[1] . $timezoneOffset[2] . ':' . $timezoneOffset[3];
}
try {
    $userTimezone = new DateTimeZone($timezoneName !== '' ? $timezoneName : 'UTC');
} catch (Throwable $exception) {
    $userTimezone = new DateTimeZone('UTC');
}
$timezoneLabel = $userTimezone->getName();

$headers = [
    'No',
    'ID Observasi Lokal',
    'ID Referensi Observasi',
    'ID Observation SATUSEHAT',
    'No. RM',
    'Nama Pasien',
    'ID Kunjungan',
    'Jenis Kunjungan',
    'Waktu Kunjungan (Database)',
    'ID Praktisi',
    'Nama Praktisi',
    'Nama Petugas Pemeriksa (Snapshot)',
    'Profesi Praktisi',
    'Kategori',
    'Kode Kategori',
    'Display Kategori',
    'System Kategori',
    'Jenis Observasi',
    'Kode Observasi',
    'Display Observasi',
    'System Observasi',
    'Hasil (Database)',
    'Hasil Tampilan',
    'Tipe Hasil',
    'Nama Satuan',
    'Kode Satuan',
    'Display Satuan',
    'System Satuan',
    'Waktu Observasi (' . $timezoneLabel . ')',
    'ID Petugas Input',
    'Nama Petugas Input',
    'Waktu Input (' . $timezoneLabel . ')',
];
$lastColumn = Coordinate::stringFromColumnIndex(count($headers));

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Data Observasi');
$sheet->mergeCells('A1:' . $lastColumn . '1');
$sheet->setCellValue('A1', 'DATA OBSERVASI PASIEN');
$sheet->mergeCells('A2:' . $lastColumn . '2');
$sheet->setCellValue('A2', 'Jumlah data: ' . number_format($currentCount, 0, ',', '.') . ' | Diekspor: ' . (new DateTimeImmutable('now', $userTimezone))->format('d/m/Y H:i:s T'));
$sheet->fromArray($headers, null, 'A4', true);

$sheet->getStyle('A1:' . $lastColumn . '1')->applyFromArray([
    'font' => ['bold' => true, 'size' => 15, 'color' => ['argb' => 'FFFFFFFF']],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1F4E78']],
]);
$sheet->getStyle('A2:' . $lastColumn . '2')->applyFromArray([
    'font' => ['italic' => true, 'color' => ['argb' => 'FF555555']],
    'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
]);
$sheet->getStyle('A4:' . $lastColumn . '4')->applyFromArray([
    'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF4472C4']],
    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
]);
$sheet->getRowDimension(1)->setRowHeight(25);
$sheet->getRowDimension(4)->setRowHeight(34);
$sheet->freezePane('A5');

$columnWidths = [
    'A' => 8, 'B' => 18, 'C' => 22, 'D' => 28, 'E' => 14, 'F' => 28,
    'G' => 16, 'H' => 20, 'I' => 23, 'J' => 16, 'K' => 28, 'L' => 30,
    'M' => 22, 'N' => 24, 'O' => 20, 'P' => 28, 'Q' => 40, 'R' => 28,
    'S' => 20, 'T' => 28, 'U' => 40, 'V' => 24, 'W' => 30, 'X' => 16,
    'Y' => 20, 'Z' => 18, 'AA' => 28, 'AB' => 40, 'AC' => 25, 'AD' => 18,
    'AE' => 28, 'AF' => 25,
];
foreach ($columnWidths as $column => $width) {
    $sheet->getColumnDimension($column)->setWidth($width);
}

$rowNumber = 5;
$number = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $rawValue = trim((string) ($row['observation_value'] ?? ''));
    $displayValue = $rawValue;
    if (($row['result_type'] ?? '') === 'Coded') {
        $displayValue = observasiExportCodedLabel($row['result_coded'] ?? '', $rawValue);
    } elseif (($row['result_type'] ?? '') === 'Boolean' && in_array($rawValue, ['0', '1'], true)) {
        $displayValue = $rawValue === '1' ? '1 (Ya)' : '0 (Tidak)';
    }

    $values = [
        $number,
        (string) ($row['id_observation'] ?? ''),
        (string) ($row['id_observation_reference'] ?? ''),
        (string) ($row['observation_id'] ?? ''),
        (string) ($row['id_pasien'] ?? ''),
        (string) ($row['nama_pasien'] ?? ''),
        (string) ($row['id_kunjungan'] ?? ''),
        (string) ($row['jenis_kunjungan'] ?? ''),
        (string) ($row['datetime_daftar'] ?? ''),
        (string) ($row['id_praktisi'] ?? ''),
        (string) ($row['nama_praktisi'] ?? ''),
        (string) ($row['nama_praktisi_snapshot'] ?? ''),
        (string) ($row['profesi_praktisi'] ?? ''),
        (string) ($row['category_name'] ?? ''),
        (string) ($row['category_code'] ?? ''),
        (string) ($row['category_display'] ?? ''),
        (string) ($row['category_system'] ?? ''),
        (string) ($row['observation_name'] ?? ''),
        (string) ($row['observation_code'] ?? ''),
        (string) ($row['observation_display'] ?? ''),
        (string) ($row['observation_system'] ?? ''),
        $rawValue,
        $displayValue,
        (string) ($row['result_type'] ?? ''),
        (string) ($row['unit_name'] ?? ''),
        (string) ($row['unit_code'] ?? ''),
        (string) ($row['unit_display'] ?? ''),
        (string) ($row['unit_system'] ?? ''),
        observasiExportLocalDateTime($row['datetime_observation'] ?? '', $userTimezone),
        (string) ($row['petugas_id'] ?? ''),
        (string) ($row['petugas_nama'] ?? ''),
        observasiExportLocalDateTime($row['datetime_entry'] ?? '', $userTimezone),
    ];

    foreach ($values as $index => $value) {
        $column = Coordinate::stringFromColumnIndex($index + 1);
        if ($index === 0) {
            $sheet->setCellValue($column . $rowNumber, $value);
        } else {
            // Simpan seluruh nilai database sebagai teks agar ID/teks tidak dibulatkan atau diperlakukan sebagai formula.
            $sheet->setCellValueExplicit($column . $rowNumber, $value, DataType::TYPE_STRING);
        }
    }
    $rowNumber++;
    $number++;
}
mysqli_stmt_close($stmt);

$exportedCount = $rowNumber - 5;
if ($exportedCount !== $currentCount) {
    stopObservasiExport('Jumlah data berubah saat export. Buka kembali modal dan ulangi konfirmasi.', 409);
}

$lastDataRow = max(4, $rowNumber - 1);
$sheet->setAutoFilter('A4:' . $lastColumn . $lastDataRow);

if (ob_get_level() > 0 && ob_get_length() !== false) {
    ob_clean();
}
$filename = 'Data_Observasi_' . (new DateTimeImmutable('now', $userTimezone))->format('Ymd_His') . '.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');
header('Pragma: public');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
$spreadsheet->disconnectWorksheets();
exit;
