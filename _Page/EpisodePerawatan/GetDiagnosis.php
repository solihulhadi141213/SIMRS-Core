<?php
    // ==========================================
    // Endpoint GetDiagnosis.php untuk Select2 AJAX
    // ==========================================

    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";

    header('Content-Type: application/json');

    $keyword   = $_REQUEST['keyword'] ?? '';
    $id_pasien = $_REQUEST['id_pasien'] ?? '';
    $page      = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
    $limit     = 10;
    $offset    = ($page - 1) * $limit;

    // Jika pasien belum dipilih, kembalikan data kosong
    if (empty($id_pasien)) {
        echo json_encode(['results' => [], 'pagination' => ['more' => false]]);
        exit;
    }

    $searchTerm = "%" . trim($keyword) . "%";

    // 1. Hitung total data berdasarkan id_pasien dan keyword pencarian
    $countSql = "SELECT COUNT(*) as total FROM diagnosis WHERE id_pasien = ? AND (icd_kode LIKE ? OR icd_deskripsi LIKE ? OR diagnosis_text LIKE ?)";
    $stmtCount = mysqli_prepare($Conn, $countSql);
    if ($stmtCount) {
        mysqli_stmt_bind_param($stmtCount, "isss", $id_pasien, $searchTerm, $searchTerm, $searchTerm);
        mysqli_stmt_execute($stmtCount);
        $totalResult = mysqli_stmt_get_result($stmtCount);
        $totalRow = mysqli_fetch_assoc($totalResult);
        $totalData = $totalRow['total'] ?? 0;
        mysqli_stmt_close($stmtCount);
    } else {
        $totalData = 0;
    }

    // 2. Ambil data diagnosis berdasarkan id_pasien dengan limit dan offset
    $dataSql = "SELECT id_diagnosis, icd_kode, icd_deskripsi, jenis_diagnosis, status_kasus, dokter_nama FROM diagnosis WHERE id_pasien = ? AND (icd_kode LIKE ? OR icd_deskripsi LIKE ? OR diagnosis_text LIKE ?) ORDER BY datetime_creat DESC LIMIT ? OFFSET ?";
    $stmtData = mysqli_prepare($Conn, $dataSql);

    if ($stmtData) {
        mysqli_stmt_bind_param($stmtData, "isssii", $id_pasien, $searchTerm, $searchTerm, $searchTerm, $limit, $offset);
        mysqli_stmt_execute($stmtData);
        $result = mysqli_stmt_get_result($stmtData);

        $results = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $results[] = [
                'id'              => $row['id_diagnosis'],
                'icd_kode'        => $row['icd_kode'],
                'icd_deskripsi'   => $row['icd_deskripsi'],
                'jenis_diagnosis' => $row['jenis_diagnosis'] ?? '-',
                'status_kasus'    => $row['status_kasus'] ?? '-',
                'dokter_nama'     => $row['dokter_nama'] ?? '-'
            ];
        }
        mysqli_stmt_close($stmtData);
    } else {
        $results = [];
    }

    $more = ($offset + $limit) < $totalData;

    $response = [
        'results'    => $results,
        'pagination' => [
            'more' => $more
        ]
    ];

    echo json_encode($response);
?>