<?php
    // ===================== USE =====================
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    // ===================== HEADER =====================
    ini_set('max_execution_time', 300);
    ini_set('memory_limit', '512M');

    // ===================== AUTOLOAD =====================
    require '../../vendor/autoload.php';

    // ===================== CONNECTION =====================
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

    // ===================== VALIDASI SESSION =====================
    if (empty($SessionIdAkses)) {
        die("Sesi berakhir."); exit;
    }

    // ===================== AMBIL PARAMETER =====================
    $icd_version = $_GET['icd_version'] ?? '';
    $format      = $_GET['format'] ?? 'excel';
    $limit       = $_GET['limit'] ?? '100';

    // ===================== VALIDASI =====================
    if (empty($icd_version)) {
        die("Versi ICD wajib dipilih."); exit;
    }

    // validasi format
    $allowedFormat = ['excel','csv'];
    if (!in_array($format, $allowedFormat)) {
        $format = 'excel';
    }

    // validasi limit
    $limit_sql = "";
    if ($limit !== 'all') {
        if (!is_numeric($limit) || $limit <= 0) {
            $limit = 100;
        }
        $limit_sql = " LIMIT " . intval($limit);
    }

    // ===================== QUERY =====================
    $sql = "SELECT kode, short_des, long_des, icd 
            FROM icd 
            WHERE icd = ? 
            ORDER BY kode ASC 
            $limit_sql";

    $stmt = mysqli_prepare($Conn, $sql);

    if (!$stmt) {
        die("Prepare gagal: " . mysqli_error($Conn));
    }

    mysqli_stmt_bind_param($stmt, "s", $icd_version);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // ===================== CEK DATA =====================
    if (!$result || mysqli_num_rows($result) == 0) {
        die("Tidak ada data."); exit;
    }

    // ===================== EXPORT CSV =====================
    if ($format == 'csv') {

        ob_clean();

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="ICD_'.$icd_version.'.csv"');

        $output = fopen('php://output', 'w');

        fputcsv($output, ['No', 'Versi', 'Kode', 'Short Description', 'Long Description']);

        $no = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            fputcsv($output, [
                $no++,
                $row['icd'],
                $row['kode'],
                $row['short_des'],
                $row['long_des']
            ]);
        }

        fclose($output);
        exit;
    }

    // ===================== EXPORT EXCEL =====================
    if ($format == 'excel') {

        ob_clean();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $headers = ['No', 'Versi', 'Kode', 'Short Description', 'Long Description'];
        $sheet->fromArray($headers, NULL, 'A1');

        $rowNumber = 2;
        $no = 1;

        while ($row = mysqli_fetch_assoc($result)) {
            $sheet->fromArray([
                $no++,
                $row['icd'],
                $row['kode'],
                $row['short_des'],
                $row['long_des']
            ], NULL, 'A'.$rowNumber);

            $rowNumber++;
        }

        // Auto width
        foreach (range('A','E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Header download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="ICD_'.$icd_version.'.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');

        exit;
    }
?>