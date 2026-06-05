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
            <tr>
                <td colspan="6" class="text-center text-danger">
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
    $OrderBy    = validateAndSanitizeInput($_POST['OrderBy'] ?? '');
    $ShortBy    = strtoupper(validateAndSanitizeInput($_POST['ShortBy'] ?? 'DESC'));
    $limit      = (int)($_POST['batas'] ?? 10);
    $page       = (int)($_POST['page_filter'] ?? 1);

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
        'id_observation_reference',
        'category_name',
        'category_code',
        'category_display',
        'category_system',
        'observation_name',
        'observation_code',
        'observation_display',
        'observation_system',
        'unit_name',
        'unit_code',
        'unit_display',
        'unit_system',
        'result_type'
    ];

    // Default ORDER BY
    if (!in_array($OrderBy, $allowed_columns)) {
        $OrderBy = 'id_observation_reference';
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
    if ($keyword !== '' && in_array($keyword_by, $allowed_columns)) {

        // FILTER STATUS
        if ($keyword_by == 'status') {

            // HANYA IZINKAN 0 / 1
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
        FROM observation_reference
        $where
    ";
    $stmtCount = mysqli_prepare($Conn, $queryCount);
    if (!$stmtCount) {
        echo '
            <tr>
                <td colspan="6" class="text-center text-danger">
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
        SELECT * FROM observation_reference
        $where
        ORDER BY $OrderBy $ShortBy
        LIMIT ?, ?
    ";
    $stmt = mysqli_prepare($Conn, $query);
    if (!$stmt) {
        echo '
            <tr>
                <td colspan="6" class="text-center text-danger">
                    Terjadi Kesalahan Query Data
                </td>
            </tr>
        ';
        exit;
    }

    // =========================================================
    // PARAMETER QUERY
      // =========================================================
    $params_query   = $params;
    $params_query[] = $offset;
    $params_query[] = $limit;
    $types_query    = $types . 'ii';
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
    // NO DATA
    // =========================================================
    if (mysqli_num_rows($result) == 0) {

        echo '
            <tr
                data-page-count="'.$totalPage.'"
                data-current-page="'.$page.'"
            >
                <td colspan="6" class="text-center text-muted">
                    Tidak Ada Data Referensi Observasi
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
        $id_observation_reference = $row['id_observation_reference'] ?? '';
        $category_name            = $row['category_name'] ?? '';
        $category_display         = $row['category_display'] ?? '';
        $observation_name         = $row['observation_name'] ?? '';
        $observation_display      = $row['observation_display'] ?? '';
        $unit_name                = $row['unit_name'] ?? '';
        $unit_display             = $row['unit_display'] ?? '';
        $result_type              = $row['result_type'] ?? '';
        if(empty($row['unit_name'])){
            $unit_name = "-";
        }
        // =====================================================
        // ATRIBUT PAGING
        // =====================================================
        $paging_attribute = '';
        if ($no == ($offset + 1)) {
            $paging_attribute = '
                data-page-count="'.$totalPage.'"
                data-current-page="'.$page.'"
            ';
        }

        // =====================================================
        // TAMPILKAN DATA
        // =====================================================
        echo '
            <tr '.$paging_attribute.'>
                <td class="text-center">
                    <small class="text-muted">'.$no.'</small>
                </td>
                <td>
                    
                        <small class="text-primary text-decoration-underline">
                            <a href="javascript:void(0);" class="text-primary modal_detail" data-id="'.$id_observation_reference.'">
                            '.$observation_name.'
                            </a>
                        </small>
                    
                </td>
                <td>
                    <small class="text-muted">
                        '.$category_name.'
                        (<i>'.$category_display.'</i>)
                    </small>
                </td>

                <td class="text-center">
                    <small class="text-muted">'.$result_type.'</small>
                </td>
                <td>
                    <small class="text-muted">
                        '.$unit_name.'
                    </small>
                </td>
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
                            <a
                                class="dropdown-item modal_detail"
                                href="javascript:void(0)"
                                data-id="'.$id_observation_reference.'"
                                data-kategori="All"
                            >
                                <i class="bi bi-info-circle"></i> Detail
                            </a>
                        </li>

                        <li>
                            <a
                                class="dropdown-item modal_edit"
                                href="javascript:void(0)"
                                data-id="'.$id_observation_reference.'"
                            >
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                        </li>

                        <li>
                            <a
                                class="dropdown-item modal_hapus"
                                href="javascript:void(0)"
                                data-id="'.$id_observation_reference.'"
                            >
                                <i class="bi bi-trash"></i> Hapus
                            </a>
                        </li>
                        

                    </ul>

                </td>

            </tr>
        ';

        $no++;
    }

    // =========================================================
    // CLOSE
    // =========================================================
    mysqli_stmt_close($stmt);
?>