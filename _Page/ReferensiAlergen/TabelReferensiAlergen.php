<?php
    // Error reporting
    error_reporting(0);
    ini_set('display_errors', 0);

    // Load config
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // Limit text
    function limitText($text, $max = 30) {
        $text = trim((string)$text);
        return ($text === '') ? '-' : ((mb_strlen($text) > $max) ? mb_substr($text, 0, $max) . '...' : $text);
    }

    // Validasi session
    if (empty($SessionIdAkses)) {
        echo '<tr><td colspan="8" class="text-center text-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang</td></tr>';
        exit;
    }

    // Ambil filter
    $keyword_by = validateAndSanitizeInput($_POST['keyword_by'] ?? '');
    $keyword    = validateAndSanitizeInput($_POST['keyword'] ?? '');
    $OrderBy    = validateAndSanitizeInput($_POST['OrderBy'] ?? '');
    $ShortBy    = strtoupper(validateAndSanitizeInput($_POST['ShortBy'] ?? 'DESC'));
    $limit      = max(1, (int)($_POST['batas'] ?? 10));
    $page       = max(1, (int)($_POST['page_filter'] ?? 1));
    $offset     = ($page - 1) * $limit;

    // Validasi order
    $allowed_columns = ['id_alergi_alergen', 'kategori_alergen', 'nama_alergen', 'code_alergen', 'display_alergen', 'author_name', 'status'];
    if (!in_array($OrderBy, $allowed_columns)) { $OrderBy = 'id_alergi_alergen'; }
    if (!in_array($ShortBy, ['ASC', 'DESC'])) { $ShortBy = 'DESC'; }

    // Query builder
    $where = "WHERE 1=1";
    $params = [];
    $types = '';

    // Global search
    if ($keyword !== '' && empty($keyword_by)) {
        $where .= " AND (LOWER(kategori_alergen) LIKE ? OR LOWER(nama_alergen) LIKE ? OR LOWER(code_alergen) LIKE ? OR LOWER(display_alergen) LIKE ?)";
        $search = '%' . strtolower($keyword) . '%';
        $params = [$search, $search, $search, $search];
        $types = 'ssss';
    }

    // Specific search
    elseif ($keyword !== '' && in_array($keyword_by, $allowed_columns)) {

        // Status search
        if ($keyword_by == 'status') {
            $keyword_lower = strtolower($keyword);

            if (in_array($keyword_lower, ['aktif', 'active', '1'])) { $where .= " AND status = ?"; $params[] = 1; $types .= 'i'; }
            elseif (in_array($keyword_lower, ['nonaktif', 'inactive', '0'])) { $where .= " AND status = ?"; $params[] = 0; $types .= 'i'; }
            else { $where .= " AND 1=0"; }
        }

        // ENUM search
        elseif ($keyword_by == 'kategori_alergen') {
            $where .= " AND kategori_alergen = ?";
            $params[] = strtolower($keyword);
            $types .= 's';
        }

        // Text search
        else {
            $where .= " AND LOWER($keyword_by) LIKE ?";
            $params[] = '%' . strtolower($keyword) . '%';
            $types .= 's';
        }
    }

    // Count query
    $queryCount = "SELECT COUNT(*) AS total FROM alergi_alergen $where";
    $stmtCount = mysqli_prepare($Conn, $queryCount);

    if (!$stmtCount) {
        echo '<tr><td colspan="8" class="text-center text-danger">Terjadi Kesalahan Query Count</td></tr>';
        exit;
    }

    if (!empty($params)) { mysqli_stmt_bind_param($stmtCount, $types, ...$params); }

    mysqli_stmt_execute($stmtCount);
    $resultCount = mysqli_stmt_get_result($stmtCount);
    $dataCount = mysqli_fetch_assoc($resultCount);
    $totalData = (int)($dataCount['total'] ?? 0);

    mysqli_stmt_close($stmtCount);

    // Total page
    $totalPage = ($totalData > 0) ? ceil($totalData / $limit) : 1;

    if ($page > $totalPage) {
        $page = max(1, $totalPage);
        $offset = ($page - 1) * $limit;
    }

    // Data query
    $query = "SELECT * FROM alergi_alergen $where ORDER BY $OrderBy $ShortBy LIMIT ?, ?";
    $stmt = mysqli_prepare($Conn, $query);

    if (!$stmt) {
        echo '<tr><td colspan="8" class="text-center text-danger">Terjadi Kesalahan Query Data</td></tr>';
        exit;
    }

    // Bind query
    $params_query = array_merge($params, [$offset, $limit]);
    mysqli_stmt_bind_param($stmt, $types . 'ii', ...$params_query);

    // Execute
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // No data
    if (mysqli_num_rows($result) == 0) {
        echo '<tr data-page-count="'.$totalPage.'" data-current-page="'.$page.'"><td colspan="8" class="text-center text-muted">Data Alergen Tidak Ditemukan</td></tr>';
        mysqli_stmt_close($stmt);
        exit;
    }

    // Mapping kategori
    $no = $offset + 1;
    $kategori_map = ['food' => 'Makanan', 'medication' => 'Obat', 'environment' => 'Lingkungan', 'biologic' => 'Biologis'];

    // Loop data
    while ($row = mysqli_fetch_assoc($result)) {

        // Data row
        $id_alergi_alergen = $row['id_alergi_alergen'] ?? '';
        $kategori_alergen  = $row['kategori_alergen'] ?? '';
        $nama_alergen      = $row['nama_alergen'] ?? '';
        $code_alergen      = $row['code_alergen'] ?? '';
        $display_alergen   = $row['display_alergen'] ?? '';
        $system_alergen   = $row['system_alergen'] ?? '';
        $status            = $row['status'] ?? '0';

        // Label kategori & status
        $label_kategori = $kategori_map[$kategori_alergen] ?? $kategori_alergen;
        $label_status = ($status == '1')
            ? '<span class="px-2 py-1 bg-success-subtle text-success rounded-2"><i class="bi bi-check"></i></span>'
            : '<span class="px-2 py-1 bg-danger-subtle text-danger rounded-2"><i class="bi bi-x"></i></span>';

        // Paging attribute
        $paging_attribute = ($no == ($offset + 1)) ? ' data-page-count="'.$totalPage.'" data-current-page="'.$page.'"' : '';

        // Render row
        echo '<tr'.$paging_attribute.'>
            <td class="text-center"><small class="text-muted">'.$no.'</small></td>
            <td class="text-start">
                <a href="javascript:void(0);" class="modal_detail" data-id="'.$id_alergi_alergen.'">
                    <small class="text-primary text-decoration-underline">'.htmlspecialchars(html_entity_decode(limitText($nama_alergen, 50), ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8').'</small>
                </a>
            </td>
            <td class="text-start"><small class="text-muted"><i>'.$label_kategori.'</i></small></td>
            <td class="text-start"><small class="text-muted">'.htmlspecialchars(html_entity_decode(limitText($code_alergen, 40), ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8').'</small></td>
            <td class="text-start"><small class="text-muted">'.htmlspecialchars(html_entity_decode(limitText($display_alergen, 60), ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8').'</small></td>
            <td class="text-start"><small class="text-muted">'.htmlspecialchars(html_entity_decode(limitText($system_alergen, 60), ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8').'</small></td>
            <td class="text-center">'.$label_status.'</td>
            <td class="text-center icon-btn">
                <button type="button" class="btn btn-sm btn-outline-dark btn-floating" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></button>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start"><h6>Option</h6></li>
                    <li><a href="javascript:void(0)" class="dropdown-item modal_detail" data-id="'.$id_alergi_alergen.'"><i class="bi bi-info-circle"></i> Detail</a></li>
                    <li><a href="javascript:void(0)" class="dropdown-item modal_edit" data-id="'.$id_alergi_alergen.'"><i class="bi bi-pencil"></i> Edit</a></li>
                    <li><a href="javascript:void(0)" class="dropdown-item modal_hapus" data-id="'.$id_alergi_alergen.'"><i class="bi bi-trash"></i> Hapus</a></li>
                </ul>
            </td>
        </tr>';
        $no++;
    }

    // Close
    mysqli_stmt_close($stmt);
?>