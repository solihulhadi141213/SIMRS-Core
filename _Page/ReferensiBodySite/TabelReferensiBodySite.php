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
                <td colspan="7" class="text-center text-danger">
                    Sesi Akses Sudah Berakhir, Silahkan Login Ulang
                </td>
            </tr>
        ';

        exit;
    }

    // =========================================================
    // TANGKAP FILTER (dari ModalReferensiBodySite.php)
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
        'body_site_category',
        'body_site_nama',
        'body_site_display',
        'body_site_code',
        'body_site_system',
        'id_body_site'
    ];

    // Default ORDER BY
    if (!in_array($OrderBy, $allowed_columns)) {
        $OrderBy = 'id_body_site';
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
        $where .= " AND (LOWER(body_site_category) LIKE ? OR LOWER(body_site_nama) LIKE ? OR LOWER(body_site_display) LIKE ? OR LOWER(body_site_code) LIKE ? OR LOWER(body_site_system) LIKE ?)";
        $search = '%' . strtolower($keyword) . '%';
        $params = [$search, $search, $search, $search, $search];
        $types  = 'sssss';

    } elseif ($keyword !== '' && in_array($keyword_by, $allowed_columns)) {

        $where .= " AND LOWER($keyword_by) LIKE ?";
        $params[] = '%' . strtolower($keyword) . '%';
        $types   .= 's';

    }

    // =========================================================
    // QUERY COUNT
    // =========================================================
    $queryCount = "
        SELECT COUNT(*) AS total
        FROM body_site
        $where
    ";

    $stmtCount = mysqli_prepare($Conn, $queryCount);

    if (!$stmtCount) {

        echo '
            <tr data-page-count="0" data-current-page="0">
                <td colspan="7" class="text-center text-danger">
                    Terjadi Kesalahan Query Count
                </td>
            </tr>
        ';

        exit;
    }

    // =========================================================
    // BIND COUNT
    // =========================================================
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
    $pageCount = ($totalData > 0)
        ? ceil($totalData / $limit)
        : 1;

    // =========================================================
    // VALIDASI PAGE BERLEBIH
    // =========================================================
    if ($page > $pageCount) {

        $page = $pageCount;

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
            id_body_site,
            body_site_category,
            body_site_nama,
            body_site_display,
            body_site_code,
            body_site_system,
            datetime_creat,
            author_name
        FROM body_site
        $where
        ORDER BY $OrderBy $ShortBy
        LIMIT ?, ?
    ";

    $stmt = mysqli_prepare($Conn, $query);

    if (!$stmt) {

        echo '
            <tr data-page-count="0" data-current-page="0">
                <td colspan="7" class="text-center text-danger">
                    Terjadi Kesalahan Query Data
                </td>
            </tr>
        ';

        exit;
    }

    // =========================================================
    // PARAMETER QUERY
    // =========================================================
    $params_query = $params;

    $params_query[] = $offset;
    $params_query[] = $limit;

    $types_query = $types . 'ii';

    mysqli_stmt_bind_param(
        $stmt,
        $types_query,
        ...$params_query
    );

    // =========================================================
    // EXECUTE
    // =========================================================
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    // =========================================================
    // OUTPUT
    // =========================================================
    $no = $offset + 1;

    if (mysqli_num_rows($result) > 0) {

        while ($row = mysqli_fetch_assoc($result)) {

            $id_body_site         = (int)$row['id_body_site'];
            $body_site_category   = htmlspecialchars((string)($row['body_site_category'] ?? '-'));
            $body_site_nama       = htmlspecialchars((string)($row['body_site_nama'] ?? '-'));
            $body_site_display    = htmlspecialchars((string)($row['body_site_display'] ?? '-'));
            $body_site_code       = htmlspecialchars((string)($row['body_site_code'] ?? '-'));
            $body_site_system     = htmlspecialchars((string)($row['body_site_system'] ?? '-'));
            $author_name          = htmlspecialchars((string)($row['author_name'] ?? '-'));
            $datetime_creat       = !empty($row['datetime_creat'])
                ? date('d/m/Y H:i', strtotime((string)$row['datetime_creat']))
                : '-';

            $paging_attribute = ($no == ($offset + 1))
                ? ' data-page-count="'.$pageCount.'" data-current-page="'.$page.'"'
                : '';

            echo '
            <tr'.$paging_attribute.'>
                <td class="text-center"><small class="text-muted">'.$no.'</small></td>
                <td><small class="text-muted">'.$body_site_category.'</small></td>
                <td>
                    <a href="javascript:void(0);" class="modal_detail" data-id="'.$id_body_site.'">
                        <small class="text-primary text-decoration-underline">'.$body_site_nama.'</small>
                    </a>
                </td>
                <td><small class="text-muted">'.$body_site_display.'</small></td>
                <td><small class="text-muted">'.$body_site_code.'</small></td>
                <td><small class="text-muted">'.$body_site_system.'</small></td>
                <td class="text-center icon-btn">

                    <button
                        type="button"
                        class="btn btn-sm btn-outline-dark btn-floating"
                        data-bs-toggle="dropdown"
                    >
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">

                        <li class="dropdown-header text-start">
                            <h6>Option</h6>
                        </li>

                        <li>
                            <a class="dropdown-item modal_detail" href="javascript:void(0);" data-id="'.$id_body_site.'">
                                <i class="bi bi-info-circle"></i> Detail
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item modal_edit" href="javascript:void(0);" data-id="'.$id_body_site.'">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item modal_hapus" href="javascript:void(0);" data-id="'.$id_body_site.'">
                                <i class="bi bi-trash"></i> Hapus
                            </a>
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
            <td colspan="7" align="center">
                <small class="text-muted">Tidak ada data referensi body site</small>
            </td>
        </tr>
        ';
    }

    // =========================================================
    // CLOSE
    // =========================================================
    mysqli_stmt_close($stmt);
?>

