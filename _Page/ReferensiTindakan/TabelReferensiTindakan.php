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
            <tr>
                <td colspan="7" class="text-center text-danger">
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
        'kategori_tindakan',
        'kategori_tindakan_code',
        'kategori_tindakan_display',
        'nama_tindakan',
        'nama_tindakan_code',
        'nama_tindakan_display',
        'lokasi_tubuh',
        'lokasi_tubuh_code',
        'lokasi_tubuh_display',
        'icd9_code',
        'icd9_description',
        'status',
        'id_tindakan_referensi'
    ];

    // Default ORDER BY
    if (!in_array($OrderBy, $allowed_columns)) {
        $OrderBy = 'id_tindakan_referensi';
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
        FROM tindakan_referensi
        $where
    ";

    $stmtCount = mysqli_prepare($Conn, $queryCount);

    if (!$stmtCount) {

        echo '
            <tr>
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
            id_tindakan_referensi,
            kategori_tindakan,
            kategori_tindakan_code,
            kategori_tindakan_display,
            nama_tindakan,
            nama_tindakan_code,
            nama_tindakan_display,
            lokasi_tubuh,
            lokasi_tubuh_code,
            lokasi_tubuh_display,
            icd9_code,
            icd9_description,
            status,
            datetime_creat,
            author_name
        FROM tindakan_referensi
        $where
        ORDER BY $OrderBy $ShortBy
        LIMIT ?, ?
    ";

    $stmt = mysqli_prepare($Conn, $query);

    if (!$stmt) {

        echo '
            <tr>
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
    // NO DATA
    // =========================================================
    if (mysqli_num_rows($result) == 0) {

        echo '
            <tr
                data-page-count="'.$totalPage.'"
                data-current-page="'.$page.'"
            >
                <td colspan="7" class="text-center text-muted">
                    Tidak Ada Data Referensi Tindakan
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

        $id_tindakan_referensi = $row['id_tindakan_referensi'] ?? '';

        $kategori_tindakan         = $row['kategori_tindakan'] ?? '-';
        $kategori_tindakan_display = $row['kategori_tindakan_display'] ?? '-';

        $nama_tindakan         = $row['nama_tindakan'] ?? '-';
        $nama_tindakan_display = $row['nama_tindakan_display'] ?? '-';

        $lokasi_tubuh         = $row['lokasi_tubuh'] ?? '-';
        $lokasi_tubuh_display = $row['lokasi_tubuh_display'] ?? '-';

        $icd9_code        = $row['icd9_code'] ?? '-';
        $icd9_description = $row['icd9_description'] ?? '-';

        $status = $row['status'] ?? '0';

        // =====================================================
        // LIMIT TEXT
        // =====================================================
        $kategori_tindakan         = limitText($kategori_tindakan);
        $kategori_tindakan_display = limitText($kategori_tindakan_display);

        $nama_tindakan         = limitText($nama_tindakan);
        $nama_tindakan_display = limitText($nama_tindakan_display);

        $lokasi_tubuh         = limitText($lokasi_tubuh);
        $lokasi_tubuh_display = limitText($lokasi_tubuh_display);

        $icd9_description = limitText($icd9_description);

        // =====================================================
        // STATUS
        // =====================================================
        if ($status == '1') {

            $label_status = '
                <a
                    href="javascript:void(0);"
                    class="modal_hapus"
                    data-id="'.$id_tindakan_referensi.'"
                >
                    <small class="text-success">
                        <i class="bi bi-check-circle"></i> Active
                    </small>
                </a>
            ';

            $tombol_status = '
                <li>
                    <a
                        href="javascript:void(0);"
                        class="dropdown-item modal_hapus"
                        data-id="'.$id_tindakan_referensi.'"
                    >
                        <i class="bi bi-x"></i> Hapus
                    </a>
                </li>
            ';

        } else {

            $label_status = '
                <a
                    href="javascript:void(0);"
                    class="modal_recovery"
                    data-id="'.$id_tindakan_referensi.'"
                >
                    <small class="text-danger">
                        <i class="bi bi-trash"></i> Deleted
                    </small>
                </a>
            ';

            $tombol_status = '
                <li>
                    <a
                        href="javascript:void(0);"
                        class="dropdown-item modal_recovery"
                        data-id="'.$id_tindakan_referensi.'"
                    >
                        <i class="bi bi-repeat"></i> Recovery
                    </a>
                </li>
            ';
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
                    <a
                        href="javascript:void(0);"
                        class="modal_detail"
                        data-id="'.$id_tindakan_referensi.'"
                        data-kategori="kategori_tindakan"
                    >
                        <small class="text-muted text-decoration-underline">
                            '.$kategori_tindakan.'
                        </small>
                        <br>
                        <small class="text-muted">
                            <i>'.$kategori_tindakan_display.'</i>
                        </small>
                    </a>
                </td>

                <td>
                    <a
                        href="javascript:void(0);"
                        class="modal_detail"
                        data-id="'.$id_tindakan_referensi.'"
                        data-kategori="nama_tindakan"
                    >
                        <small class="text-muted text-decoration-underline">
                            '.$nama_tindakan.'
                        </small>
                        <br>
                        <small class="text-muted">
                            <i>'.$nama_tindakan_display.'</i>
                        </small>
                    </a>
                </td>

                <td>
                    <a
                        href="javascript:void(0);"
                        class="modal_detail"
                        data-id="'.$id_tindakan_referensi.'"
                        data-kategori="lokasi_tubuh"
                    >
                        <small class="text-muted text-decoration-underline">
                            '.$lokasi_tubuh.'
                        </small>
                        <br>
                        <small class="text-muted">
                            <i>'.$lokasi_tubuh_display.'</i>
                        </small>
                    </a>
                </td>

                <td>
                    <a
                        href="javascript:void(0);"
                        class="modal_detail"
                        data-id="'.$id_tindakan_referensi.'"
                        data-kategori="icd9"
                    >
                        <small class="text-muted text-decoration-underline">
                            '.$icd9_code.'
                        </small>
                        <br>
                        <small class="text-muted">
                            <i>'.$icd9_description.'</i>
                        </small>
                    </a>
                </td>

                <td class="text-center">
                    '.$label_status.'
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
                                data-id="'.$id_tindakan_referensi.'"
                                data-kategori="All"
                            >
                                <i class="bi bi-info-circle"></i> Detail
                            </a>
                        </li>

                        <li>
                            <a
                                class="dropdown-item modal_edit"
                                href="javascript:void(0)"
                                data-id="'.$id_tindakan_referensi.'"
                            >
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                        </li>

                        '.$tombol_status.'

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