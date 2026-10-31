<?php
    error_reporting(0);
    ini_set('display_errors', 0);

    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    if (empty($SessionIdAkses)) {
        echo '
            <tr data-page-count="0" data-current-page="0">
                <td colspan="10" class="text-center text-danger">
                    Sesi Akses Sudah Berakhir, Silahkan Login Ulang
                </td>
            </tr>
        ';
        exit;
    }

    $keyword_by = validateAndSanitizeInput($_POST['keyword_by'] ?? '');
    $keyword    = trim(validateAndSanitizeInput($_POST['keyword'] ?? ''));

    $OrderBy = validateAndSanitizeInput($_POST['OrderBy'] ?? '');
    $ShortBy = strtoupper(validateAndSanitizeInput($_POST['ShortBy'] ?? 'DESC'));

    $limit = (int)($_POST['batas'] ?? 10);
    $page  = (int)($_POST['page_filter'] ?? 1);

    if ($page <= 0) { $page = 1; }
    if ($limit <= 0) { $limit = 10; }
    $offset = ($page - 1) * $limit;

    $column_map = [
        'id_pasien'          => 'k.id_pasien',
        'nama'               => 'p.nama',
        'id_ihs'             => 'p.id_ihs',
        'datetime_pelayanan' => 'k.datetime_pelayanan',
        'jenis_kunjungan'    => 'k.jenis_kunjungan',
        'dpjp_nama'          => 'k.dpjp_nama',
        'status'             => 'k.status',
        'id_encounter'       => 'k.id_encounter'
    ];

    $allowed_keys = array_keys($column_map);

    if (!isset($column_map[$OrderBy])) {
        $OrderBy = 'k.id_kunjungan';
    } else {
        $OrderBy = $column_map[$OrderBy];
    }

    if (!in_array($ShortBy, ['ASC', 'DESC'])) {
        $ShortBy = 'DESC';
    }

    $where = "WHERE 1=1";
    $params = [];
    $types  = '';

    if ($keyword !== '' && empty($keyword_by)) {
        $where .= " AND (
            CAST(k.id_pasien AS CHAR) LIKE ? OR
            LOWER(p.nama) LIKE ? OR
            LOWER(p.id_ihs) LIKE ? OR
            CAST(k.datetime_pelayanan AS CHAR) LIKE ? OR
            LOWER(k.jenis_kunjungan) LIKE ? OR
            LOWER(k.dpjp_nama) LIKE ? OR
            LOWER(k.status) LIKE ? OR
            LOWER(k.id_encounter) LIKE ?
        )";
        $search = '%' . strtolower($keyword) . '%';
        $params = [$search, $search, $search, $search, $search, $search, $search, $search];
        $types  = 'ssssssss';
    } elseif ($keyword !== '' && in_array($keyword_by, $allowed_keys)) {
        $col = $column_map[$keyword_by];
        $where .= " AND LOWER(CAST($col AS CHAR)) LIKE ?";
        $params[] = '%' . strtolower($keyword) . '%';
        $types   .= 's';
    }

    $queryCount = "
        SELECT COUNT(*) AS total
        FROM kunjungan k
        LEFT JOIN pasien p ON k.id_pasien = p.id_pasien
        $where
    ";

    $stmtCount = mysqli_prepare($Conn, $queryCount);
    if (!$stmtCount) {
        echo '
            <tr data-page-count="0" data-current-page="0">
                <td colspan="10" class="text-center text-danger">
                    Terjadi Kesalahan Query Count
                </td>
            </tr>
        ';
        exit;
    }

    if (!empty($params)) {
        mysqli_stmt_bind_param($stmtCount, $types, ...$params);
    }

    mysqli_stmt_execute($stmtCount);
    $resultCount = mysqli_stmt_get_result($stmtCount);
    $dataCount = mysqli_fetch_assoc($resultCount);
    $totalData = (int)($dataCount['total'] ?? 0);
    mysqli_stmt_close($stmtCount);

    $pageCount = ($totalData > 0) ? ceil($totalData / $limit) : 1;

    if ($page > $pageCount) {
        $page = $pageCount;
        if ($page <= 0) { $page = 1; }
        $offset = ($page - 1) * $limit;
    }

    // =========================================================
    // QUERY DATA
    // =========================================================
    $query = "
        SELECT
            k.id_kunjungan,
            k.id_pasien,
            p.nama AS nama_pasien,
            p.id_ihs,
            k.datetime_pelayanan,
            k.jenis_kunjungan,
            k.dpjp_nama,
            k.status,
            k.id_encounter
        FROM kunjungan k
        LEFT JOIN pasien p ON k.id_pasien = p.id_pasien
        $where
        ORDER BY $OrderBy $ShortBy
        LIMIT ?, ?
    ";

    $stmt = mysqli_prepare($Conn, $query);
    if (!$stmt) {
        echo '
            <tr data-page-count="0" data-current-page="0">
                <td colspan="10" class="text-center text-danger">
                    Terjadi Kesalahan Query Data
                </td>
            </tr>
        ';
        exit;
    }

    $params_query = $params;
    $params_query[] = $offset;
    $params_query[] = $limit;
    $types_query = $types . 'ii';

    mysqli_stmt_bind_param($stmt, $types_query, ...$params_query);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // =========================================================
    // OUTPUT
    // =========================================================
    $no = $offset + 1;

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $id_kunjungan       = (int)$row['id_kunjungan'];
            $id_pasien          = $row['id_pasien'] ?? '';
            $nama_pasien        = htmlspecialchars((string)($row['nama_pasien'] ?? '-'));
            $id_ihs             = htmlspecialchars((string)($row['id_ihs'] ?? '-'));
            $datetime_pelayanan = !empty($row['datetime_pelayanan']) ? date('d/m/Y H:i', strtotime((string)$row['datetime_pelayanan'])) : '-';
            $jenis_kunjungan    = htmlspecialchars((string)($row['jenis_kunjungan'] ?? '-'));
            $dpjp_nama          = htmlspecialchars((string)($row['dpjp_nama'] ?? '-'));
            $status             = (string)($row['status'] ?? '');
            

            $label_status = ($status !== '' && strtolower($status) !== 'batal')
                ? '<span class="text-success"><small><b>' . htmlspecialchars($status) . '</b></small></span>'
                : '<span class="text-secondary"><small><b>' . htmlspecialchars($status) . '</b></small></span>';

            $paging_attribute = ($no == ($offset + 1)) ? ' data-page-count="'.$pageCount.'" data-current-page="'.$page.'"' : '';

            // Routing ID Encounter
            if(empty($row['id_encounter'])){
                $label_encounter = '
                    <a href="javascript:void(0);" class="px-2 py-1 bg-danger-subtle text-danger rounded-2 modal_tambah" data-id="'.$id_kunjungan.'">
                        <i class="bi bi-send"></i> Kirim
                    </a>
                ';
            }else{
                $id_encounter = htmlspecialchars((string)($row['id_encounter']));
                $id_encounter_short = (strlen($id_encounter) > 10) ? substr($id_encounter, 0, 10) . '***' : $id_immunization;
                $label_encounter = '
                    <a href="javascript:void(0);" class="px-2 py-1 bg-info-subtle text-info rounded-2 modal_detail" data-id="'.$id_encounter.'">
                        <i class="bi bi-arrow-up-right-square"></i> '.$id_encounter_short.'
                    </a>
                ';
            }
            echo '
            <tr'.$paging_attribute.'>
                <td class="text-center"><small class="text-muted">'.$no.'</small></td>
                <td><small class="text-muted">'.$id_pasien.'</small></td>
                <td><small class="text-dark">'.$nama_pasien.'</small></td>
                <td><small class="text-muted">'.$id_ihs.'</small></td>
                <td><small class="text-muted">'.$datetime_pelayanan.'</small></td>
                <td><small class="text-muted">'.$jenis_kunjungan.'</small></td>
                <td><small class="text-muted">'.$dpjp_nama.'</small></td>
                <td class="text-center">'.$label_status.'</td>
                <td>'.$label_encounter.'</td>
                <td class="text-center icon-btn">
                    <button type="button" class="btn btn-sm btn-outline-dark btn-floating" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></button>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <li class="dropdown-header text-start"><h6>Option</h6></li>
                        <li><a class="dropdown-item modal_detail" href="javascript:void(0);" data-id="'.$id_kunjungan.'"><i class="bi bi-info-circle"></i> Detail</a></li>
                        <li><a class="dropdown-item modal_edit" href="javascript:void(0);" data-id="'.$id_kunjungan.'"><i class="bi bi-pencil"></i> Edit</a></li>
                        <li><a class="dropdown-item modal_hapus" href="javascript:void(0);" data-id="'.$id_kunjungan.'"><i class="bi bi-trash"></i> Hapus</a></li>
                    </ul>
                </td>
            </tr>
            ';
            $no++;
        }
    } else {
        echo '
        <tr data-page-count="0" data-current-page="0">
            <td colspan="10" align="center">
                <small class="text-muted">Tidak ada data encounter</small>
            </td>
        </tr>
        ';
    }

    mysqli_stmt_close($stmt);
?>

