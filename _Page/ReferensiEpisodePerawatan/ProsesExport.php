<?php
    // =========================================================
    // EXPORT DATA EPISODE PERAWATAN KE EXCEL
    // =========================================================
    // error_reporting(E_ALL);
    // ini_set('display_errors', 0);
    ob_start();
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";
    require '../../vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Style\Alignment;
    use PhpOffice\PhpSpreadsheet\Style\Border;
    use PhpOffice\PhpSpreadsheet\Style\Fill;
    use PhpOffice\PhpSpreadsheet\Cell\DataType;

    function stopExport($message){
        if (ob_get_length()) { ob_end_clean(); }
        echo $message;
        exit;
    }

    if (empty($SessionIdAkses)) { stopExport('Sesi akses sudah berakhir!'); }

    // =========================================================
    // AMBIL PARAMETER FILTER (jika ada)
    // =========================================================
    $status_filter   = isset($_POST['status']) && $_POST['status'] !== '' ? (int) $_POST['status'] : null;
    $category_filter = isset($_POST['episode_category']) && !empty($_POST['episode_category'])
        ? validateAndSanitizeInput($_POST['episode_category'])
        : '';

    // =========================================================
    // QUERY DATA EPISODE PERAWATAN
    // =========================================================
    $sql = "
        SELECT
            e.id_episode_perawatan_kode,
            e.episode_category,
            e.episode_name,
            e.episode_display,
            e.episode_code,
            e.episode_system,
            e.source,
            e.status,
            a.nama AS creat_by_name,
            DATE_FORMAT(e.creat_at, '%d-%m-%Y %H:%i:%s') AS creat_at_formatted
        FROM episode_perawatan_kode e
        LEFT JOIN akses a ON e.creat_by_id = a.id_akses
        WHERE 1=1
    ";

    $params = [];
    $types  = '';

    if ($status_filter !== null && in_array($status_filter, [0, 1], true)) {
        $sql .= " AND e.status = ?";
        $params[] = $status_filter;
        $types   .= 'i';
    }

    if ($category_filter !== '') {
        $sql .= " AND e.episode_category LIKE ?";
        $params[] = '%' . $category_filter . '%';
        $types   .= 's';
    }

    $sql .= " ORDER BY e.creat_at DESC";

    // =========================================================
    // EXECUTE QUERY
    // =========================================================
    $stmt = mysqli_prepare($Conn, $sql);
    if (!$stmt) {
        stopExport('Gagal menyiapkan query: ' . mysqli_error($Conn));
    }

    if (!empty($params)) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }

    if (!mysqli_stmt_execute($stmt)) {
        stopExport('Gagal menjalankan query: ' . mysqli_stmt_error($stmt));
    }

    $result = mysqli_stmt_get_result($stmt);
    if ($result === false) {
        stopExport('Gagal mengambil hasil query: ' . mysqli_stmt_error($stmt));
    }

    // =========================================================
    // HELPER: escape formula injection pada Excel
    // =========================================================
    function safeExcelValue($value) {
        if (is_string($value) && $value !== '' && in_array($value[0], ['=', '+', '-', '@', "\t", "\r"], true)) {
            return "'" . $value;
        }
        return $value;
    }

    // =========================================================
    // CREATE SPREADSHEET
    // =========================================================
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Episode Perawatan');

    // =========================================================
    // SET HEADER COLUMN
    // =========================================================
    $headers = [
        'No',
        'Kategori Episode',
        'Nama Episode (Lokal)',
        'Nama Episode (Standar)',
        'Kode Episode',
        'System Referensi',
        'Sumber Data',
        'Status',
        'Dibuat Oleh',
        'Tanggal Dibuat'
    ];

    $headerRow = 1;
    $totalCols = count($headers);

    foreach ($headers as $colIndex => $header) {
        $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex + 1);
        $sheet->setCellValue($colLetter . $headerRow, $header);

        $sheet->getStyle($colLetter . $headerRow)->applyFromArray([
            'font' => [
                'bold'  => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '435f66'],
            ],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ]);
    }

    $row = $headerRow + 1;
    $no  = 1;

    // =========================================================
    // LOOP DATA
    // =========================================================
    while ($data = mysqli_fetch_assoc($result)) {
        $cols = [
            $no,
            $data['episode_category'] ?? '',
            $data['episode_name']     ?? '',
            $data['episode_display']  ?? '',
            $data['episode_code']     ?? '',
            $data['episode_system']   ?? '',
            $data['source']           ?? '',
            ((int) ($data['status'] ?? 0) === 1 ? 'Active' : 'Inactive'),
            $data['creat_by_name']    ?? '',
            $data['creat_at_formatted'] ?? '',
        ];

        foreach ($cols as $colIndex => $colValue) {
            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex + 1);

            // Tulis sebagai string eksplisit untuk kolom kode/kategori (cegah interpretasi angka/desimal)
            $sheet->setCellValueExplicit(
                $colLetter . $row,
                safeExcelValue((string) $colValue),
                DataType::TYPE_STRING
            );

            $isCenter = in_array($colIndex, [0, 7], true); // No & Status

            $sheet->getStyle($colLetter . $row)->applyFromArray([
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                'alignment' => [
                    'vertical'   => Alignment::VERTICAL_TOP,
                    'horizontal' => $isCenter ? Alignment::HORIZONTAL_CENTER : Alignment::HORIZONTAL_LEFT,
                    'wrapText'   => true,
                ],
            ]);
        }

        $row++;
        $no++;
    }
    mysqli_stmt_close($stmt);

    // =========================================================
    // RANGE DATA
    // =========================================================
    $firstDataRow = $headerRow + 1;
    $lastRow      = $row - 1;
    $lastColLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($totalCols);

    // =========================================================
    // BORDER DATA (jika ada data)
    // =========================================================
    if ($lastRow >= $firstDataRow) {
        $sheet->getStyle('A' . $firstDataRow . ':' . $lastColLetter . $lastRow)->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ]);
    }

    // =========================================================
    // AUTO SIZE COLUMN
    // =========================================================
    foreach (range(1, $totalCols) as $colIndex) {
        $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
        $sheet->getColumnDimension($colLetter)->setAutoSize(true);
    }

    // =========================================================
    // FREEZE HEADER (baris 1)
    // =========================================================
    $sheet->freezePane('A' . ($headerRow + 1));

    // =========================================================
    // CATAT LOG EKSPOR
    // =========================================================
    $utcNow         = (new DateTimeImmutable('now', new DateTimeZone('UTC')))->format('Y-m-d H:i:s');
    $category_log   = 'ReferensiEpisodePerawatan';
    $logTitle       = 'Mengexport data episode perawatan';
    $jumlahData     = $lastRow - $headerRow; // jumlah baris data sebenarnya
    if ($jumlahData < 0) { $jumlahData = 0; }

    $metadataLog = json_encode([
        'jumlah_data'     => $jumlahData,
        'status_filter'   => $status_filter,
        'category_filter' => $category_filter,
    ]);

    $stmtAudit = mysqli_prepare($Conn, "
        INSERT INTO log (id_akses, datetime_log, nama_petugas, category_log, title_log, metadata_log)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    if ($stmtAudit && $metadataLog !== false) {
        mysqli_stmt_bind_param(
            $stmtAudit,
            'isssss',
            $SessionIdAkses,
            $utcNow,
            $SessionNama,
            $category_log,
            $logTitle,
            $metadataLog
        );
        mysqli_stmt_execute($stmtAudit);
        mysqli_stmt_close($stmtAudit);
    }

    // =========================================================
    // NAMA FILE (pakai UTC agar konsisten dengan audit log)
    // =========================================================
    $filename = 'Episode_Perawatan_' . (new DateTimeImmutable('now', new DateTimeZone('UTC')))->format('YmdHis') . '.xlsx';

    // =========================================================
    // BERSIHKAN OUTPUT BUFFER
    // =========================================================
    if (ob_get_length()) {
        ob_end_clean();
    }

    // =========================================================
    // HEADER DOWNLOAD
    // =========================================================
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    header('Expires: 0');
    header('Pragma: public');

    // =========================================================
    // OUTPUT EXCEL
    // =========================================================
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');

    exit;