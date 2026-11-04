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
    // HELPER
    // =========================================================
    function limitText($text, $max = 30) {
        $text = trim((string)$text);

        if ($text === '') {
            return '-';
        }

        return (mb_strlen($text) > $max)
            ? mb_substr($text, 0, $max) . '...'
            : $text;
    }

    // =========================================================
    // VALIDASI SESSION
    // =========================================================
    if (empty($SessionIdAkses)) {
        echo '
            <tr data-page-count="1" data-current-page="1">
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

    // =========================================================
    // VALIDASI PAGE & LIMIT
    // =========================================================
    if ($page <= 0) {
        $page = 1;
    }

    if ($limit <= 0) {
        $limit = 10;
    }

    $offset = ($page - 1) * $limit;

    // =========================================================
    // VALIDASI ORDER BY
    // =========================================================
    $allowed_columns = [
        'episode_category',
        'episode_name',
        'episode_display',
        'episode_code',
        'episode_system',
        'status'
    ];

    if (!in_array($OrderBy, $allowed_columns)) {
        $OrderBy = 'episode_category';
    }

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
    if ($keyword !== '' && $keyword_by !== '' && in_array($keyword_by, $allowed_columns)) {
        if ($keyword_by == 'status') {
            if ($keyword === '0' || $keyword === '1') {
                $where .= " AND status = ?";
                $params[] = $keyword;
                $types .= 's';
            }
        } else {
            $where .= " AND $keyword_by LIKE CONCAT('%', ?, '%')";
            $params[] = $keyword;
            $types .= 's';
        }
    }

    // =========================================================
    // QUERY COUNT
    // =========================================================
    $queryCount = "
        SELECT COUNT(*) AS total
        FROM episode_perawatan_kode
        $where
    ";

    $stmtCount = mysqli_prepare($Conn, $queryCount);

    if (!$stmtCount) {
        echo '
            <tr data-page-count="1" data-current-page="1">
                <td colspan="8" class="text-center text-danger">
                    Terjadi Kesalahan Query Count
                </td>
            </tr>
        ';
        exit;
    }

    if (!empty($params)) {
        mysqli_stmt_bind_param(
            $stmtCount,
            $types,
            ...$params
        );
    }

    mysqli_stmt_execute($stmtCount);
    $resultCount = mysqli_stmt_get_result($stmtCount);
    $dataCount = mysqli_fetch_assoc($resultCount);
    $totalData = (int)($dataCount['total'] ?? 0);

    mysqli_stmt_close($stmtCount);

    // =========================================================
    // TOTAL PAGE
    // =========================================================
    $totalPage = ($totalData > 0)
        ? ceil($totalData / $limit)
        : 1;

    // =========================================================
    // VALIDASI PAGE BERLEBIH
    // =========================================================
    if ($page > $totalPage) {
        $page = $totalPage;

        if ($page <= 0) {
            $page = 1;
        }

        $offset = ($page - 1) * $limit;
    }

    // =========================================================
    // QUERY DATA
    // =========================================================
    $query = "
        SELECT
            id_episode_perawatan_kode,
            episode_category,
            episode_name,
            episode_display,
            episode_code,
            episode_system,
            status
        FROM episode_perawatan_kode
        $where
        ORDER BY $OrderBy $ShortBy
        LIMIT ?, ?
    ";

    $stmt = mysqli_prepare($Conn, $query);

    if (!$stmt) {
        echo '
            <tr data-page-count="1" data-current-page="1">
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

    mysqli_stmt_bind_param(
        $stmt,
        $types_query,
        ...$params_query
    );

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // =========================================================
    // NO DATA
    // =========================================================
    if (mysqli_num_rows($result) == 0) {
        echo '
            <tr data-page-count="'.$totalPage.'" data-current-page="'.$page.'">
                <td colspan="8" class="text-center text-muted">
                    Tidak Ada Data Episode Perawatan
                </td>
            </tr>
        ';

        mysqli_stmt_close($stmt);
        exit;
    }

    // =========================================================
    // LOOPING DATA
    // =========================================================
    $no = $offset + 1;

    while ($row = mysqli_fetch_assoc($result)) {
        $id_episode_perawatan_kode = $row['id_episode_perawatan_kode'] ?? '';

        $episode_category = $row['episode_category'] ?? '-';
        $episode_name     = $row['episode_name'] ?? '-';
        $episode_display  = $row['episode_display'] ?? '-';
        $episode_code     = $row['episode_code'] ?? '-';
        $episode_system   = $row['episode_system'] ?? '-';
        $status           = $row['status'] ?? '0';

        // Limit Text
        $episode_category_limit = limitText($episode_category);
        $episode_name_limit     = limitText($episode_name);
        $episode_display_limit  = limitText($episode_display);
        $episode_code_limit     = limitText($episode_code);
        $episode_system_limit   = limitText($episode_system);

        // Status Label & Tombol
        if ($status == '1') {
            $label_status = '
                <a href="javascript:void(0);" class="modal_hapus" data-id="'.$id_episode_perawatan_kode.'">
                    <small class="text-success">
                        <i class="bi bi-check-circle"></i> Active
                    </small>
                </a>
            ';

            $tombol_status = '
                <li>
                    <a href="javascript:void(0);" class="dropdown-item modal_hapus" data-id="'.$id_episode_perawatan_kode.'">
                        <i class="bi bi-x"></i> Hapus
                    </a>
                </li>
            ';
        } else {
            $label_status = '
                <a href="javascript:void(0);" class="modal_recovery" data-id="'.$id_episode_perawatan_kode.'">
                    <small class="text-danger">
                        <i class="bi bi-trash"></i> Deleted
                    </small>
                </a>
            ';

            $tombol_status = '
                <li>
                    <a href="javascript:void(0);" class="dropdown-item modal_recovery" data-id="'.$id_episode_perawatan_kode.'">
                        <i class="bi bi-repeat"></i> Recovery
                    </a>
                </li>
            ';
        }

        // Render Baris Tabel (Atribut data-page-count dan data-current-page wajib ada di baris pertama agar dibaca jQuery)
        echo '
            <tr data-page-count="'.$totalPage.'" data-current-page="'.$page.'">
                <td>'.$no.'</td>
                <td>'.$episode_category_limit.'</td>
                <td>
                    <a href="javascript:void(0);" class="text-primary modal_detail" data-id="'.$id_episode_perawatan_kode.'">
                        '.$episode_name_limit.'
                    </a>
                </td>
                <td>
                    <span class="text-muted">'.$episode_display_limit.'</span>
                </td>
                <td>
                    <span class="text-muted">'.$episode_code_limit.'</span>
                </td>
                <td>
                    <span class="text-muted">'.$episode_system_limit.'</span>
                </td>
                <td class="text-center icon-btn">'.$label_status.'</td>
                <td class="text-center icon-btn">
                    <button type="button" class="btn btn-sm btn-outline-dark btn-floating" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></button>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <li class="dropdown-header text-start"><h6>Option</h6></li>
                        <li><a href="javascript:void(0)" class="dropdown-item modal_detail" data-id="'.$id_episode_perawatan_kode.'"><i class="bi bi-info-circle"></i> Detail</a></li>
                        <li><a href="javascript:void(0)" class="dropdown-item modal_edit" data-id="'.$id_episode_perawatan_kode.'"><i class="bi bi-pencil"></i> Edit</a></li>
                        <li><a href="javascript:void(0)" class="dropdown-item modal_hapus" data-id="'.$id_episode_perawatan_kode.'"><i class="bi bi-trash"></i> Hapus</a></li>
                    </ul>
                </td>
            </tr>
        ';

        $no++;
    }

    mysqli_stmt_close($stmt);
?>