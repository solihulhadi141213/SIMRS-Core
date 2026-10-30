<?php
    // =========================================================
    // ERROR REPORTING
    // =========================================================
    error_reporting(0);
    ini_set('display_errors', 0);

    // =========================================================
    // CONNECTION
    // =========================================================
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // =========================================================
    // VALIDASI SESSION
    // =========================================================
    if (empty($SessionIdAkses)) {
        echo '
            <tr data-page-count="0" data-current-page="0">
                <td colspan="8" class="text-center text-danger">
                    Sesi Akses Sudah Berakhir, Silahkan Login Ulang
                </td>
            </tr>
        ';
        exit;
    }

    // =========================================================
    // TANGKAP FILTER
    // =========================================================
    $keyword_by = validateAndSanitizeInput($_POST['keyword_by'] ?? '');
    $keyword    = trim(validateAndSanitizeInput($_POST['keyword'] ?? ''));

    $OrderBy = validateAndSanitizeInput($_POST['OrderBy'] ?? '');
    $ShortBy = strtoupper(validateAndSanitizeInput($_POST['ShortBy'] ?? 'DESC'));

    $limit = (int)($_POST['batas'] ?? 10);
    $page  = (int)($_POST['page_filter'] ?? 1);

    if ($page <= 0) { $page = 1; }
    if ($limit <= 0) { $limit = 10; }
    $offset = ($page - 1) * $limit;

    // =========================================================
    // MAPPING KOLOM (modal -> kolom SQL qualified)
    // =========================================================
    $column_map = [
        'id_pasien'          => 'i.id_pasien',
        'nama'               => 'p.nama',
        'tanggal_pemberian'  => 'i.tanggal_pemberian',
        'nama_vaksin'        => 'r.nama_vaksin',
        'body_site_nama'     => 'i.body_site_nama',
        'id_immunization'    => 'i.id_immunization',
        'status'             => 'i.status_imunisasi'
    ];

    $allowed_keys = array_keys($column_map);

    // Default ORDER BY
    if (!isset($column_map[$OrderBy])) {
        $OrderBy = 'i.id_imunisasi';
    } else {
        $OrderBy = $column_map[$OrderBy];
    }

    // Default SORT
    if (!in_array($ShortBy, ['ASC', 'DESC'])) {
        $ShortBy = 'DESC';
    }

    // =========================================================
    // WHERE
    // =========================================================
    $where = "WHERE 1=1";
    $params = [];
    $types  = '';

    // =========================================================
    // FILTER PENCARIAN
    // =========================================================
    if ($keyword !== '' && empty($keyword_by)) {
        // Global search
        $where .= " AND (
            CAST(i.id_pasien AS CHAR) LIKE ? OR
            LOWER(p.nama) LIKE ? OR
            CAST(i.tanggal_pemberian AS CHAR) LIKE ? OR
            LOWER(r.nama_vaksin) LIKE ? OR
            LOWER(i.body_site_nama) LIKE ? OR
            LOWER(i.id_immunization) LIKE ? OR
            LOWER(i.status_imunisasi) LIKE ?
        )";
        $search = '%' . strtolower($keyword) . '%';
        $params = [$search, $search, $search, $search, $search, $search, $search];
        $types  = 'sssssss';
    } elseif ($keyword !== '' && in_array($keyword_by, $allowed_keys)) {
        $col = $column_map[$keyword_by];
        $where .= " AND LOWER(CAST($col AS CHAR)) LIKE ?";
        $params[] = '%' . strtolower($keyword) . '%';
        $types   .= 's';
    }

    // =========================================================
    // QUERY COUNT
    // =========================================================
    $queryCount = "
        SELECT COUNT(*) AS total
        FROM imunisasi i
        LEFT JOIN pasien p ON i.id_pasien = p.id_pasien
        LEFT JOIN imunisasi_referensi r ON i.id_imunisasi_referensi = r.id_imunisasi_referensi
        $where
    ";

    $stmtCount = mysqli_prepare($Conn, $queryCount);
    if (!$stmtCount) {
        echo '
            <tr data-page-count="0" data-current-page="0">
                <td colspan="8" class="text-center text-danger">
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
            i.id_imunisasi,
            i.id_pasien,
            p.nama AS nama_pasien,
            i.tanggal_pemberian,
            r.nama_vaksin,
            i.id_immunization,
            i.status_imunisasi,
            i.body_site_nama
        FROM imunisasi i
        LEFT JOIN pasien p ON i.id_pasien = p.id_pasien
        LEFT JOIN imunisasi_referensi r ON i.id_imunisasi_referensi = r.id_imunisasi_referensi
        $where
        ORDER BY $OrderBy $ShortBy
        LIMIT ?, ?
    ";

    $stmt = mysqli_prepare($Conn, $query);
    if (!$stmt) {
        echo '
            <tr data-page-count="0" data-current-page="0">
                <td colspan="8" class="text-center text-danger">
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
            $id_imunisasi      = (int)$row['id_imunisasi'];
            $id_pasien         = $row['id_pasien'] ?? '';
            $nama_pasien       = htmlspecialchars((string)($row['nama_pasien'] ?? '-'));
            $tanggal_pemberian = !empty($row['tanggal_pemberian']) ? date('d/m/Y', strtotime((string)$row['tanggal_pemberian'])) : '-';
            $nama_vaksin       = htmlspecialchars((string)($row['nama_vaksin'] ?? '-'));
            $id_immunization   = htmlspecialchars((string)($row['id_immunization'] ?? '-'));
            $status            = (string)($row['status_imunisasi'] ?? '');
            $body_site_nama    = htmlspecialchars((string)($row['body_site_nama'] ?? '-'));

            $label_status = ($status !== '' && strtolower($status) !== '0' && strtolower($status) !== 'deleted')
                ? '<span class="px-2 py-1 bg-success-subtle text-success rounded-2"><i class="bi bi-check"></i></span>'
                : '<span class="px-2 py-1 bg-secondary-subtle text-secondary rounded-2"><i class="bi bi-x"></i></span>';

            $paging_attribute = ($no == ($offset + 1)) ? ' data-page-count="'.$pageCount.'" data-current-page="'.$page.'"' : '';

            // Routing 'id_immunization'
            if(empty($row['id_immunization'])){
                $label_id_imunization = '
                    <a href="javascript:void(0);" class="px-2 py-1 bg-danger-subtle text-danger rounded-2 modal_kirim_imunization" data-id="'.$id_imunisasi.'">
                        <small><i class="bi bi-send"></i> Kirim</small>
                    </a>
                ';
            }else{
                $id_immunization   = htmlspecialchars((string)($row['id_immunization']));
                $id_pendek = substr($id_immunization, 0, 6) . '***';
                $label_id_imunization = '
                    <a href="javascript:void(0);" class="px-2 py-1 bg-info-subtle text-info rounded-2 modal_detail_imunization" data-id="'.$id_immunization.'">
                        <small><i class="bi bi-arrow-up-right-square"></i> '.$id_pendek.'</small>
                    </a>
                ';
            }

            // Tampilkan Data
            echo '
                <tr'.$paging_attribute.'>
                    <td class="text-center"><small class="text-muted">'.$no.'</small></td>
                    <td><small class="text-muted">'.$id_pasien.'</small></td>
                    <td>
                        <a href="javascript:void(0);" class="modal_detail" data-id="'.$id_imunisasi.'">
                            <small class="text-primary">'.$nama_pasien.'</small>
                        </a>
                    </td>
                    <td><small class="text-muted">'.$tanggal_pemberian.'</small></td>
                    <td><small class="text-muted">'.$nama_vaksin.'</small></td>
                    <td>'.$label_id_imunization.'</td>
                    <td class="text-center">'.$label_status.'</td>
                    <td class="text-center icon-btn">
                        <button type="button" class="btn btn-sm btn-outline-dark btn-floating" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></button>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start"><h6>Option</h6></li>
                            <li><a class="dropdown-item modal_detail" href="javascript:void(0);" data-id="'.$id_imunisasi.'">
                                <i class="bi bi-info-circle"></i> Detail</a>
                            </li>
                            <li>
                                <a class="dropdown-item modal_edit" href="javascript:void(0);" data-id="'.$id_imunisasi.'"><i class="bi bi-pencil"></i> Edit</a>
                            </li>
                            <li>
                                <a class="dropdown-item modal_hapus" href="javascript:void(0);" data-id="'.$id_imunisasi.'"><i class="bi bi-trash"></i> Hapus</a>
                            </li>
                        </ul>
                    </td>
                </tr>
            ';
            $no++;
        }
    } else {
        echo '
        <tr data-page-count="0" data-current-page="0">
            <td colspan="8" align="center">
                <small class="text-muted">Tidak ada data imunisasi</small>
            </td>
        </tr>
        ';
    }

    mysqli_stmt_close($stmt);
?>



