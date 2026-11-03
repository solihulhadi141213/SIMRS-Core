<?php
    header('Content-Type: text/html; charset=utf-8');

    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // ==============================
    // PAGINATION
    // ==============================
    $page  = (!empty($_POST['page'])) ? (int)$_POST['page'] : 1;
    $limit = (!empty($_POST['batas'])) ? (int)$_POST['batas'] : 10;

    if ($page < 1) {
        $page = 1;
    }

    $offset = ($page - 1) * $limit;

    // ==============================
    // FILTER
    // ==============================
    $keyword     = trim($_POST['keyword'] ?? '');
    $keyword_by  = trim($_POST['keyword_by'] ?? '');
    $orderBy     = trim($_POST['OrderBy'] ?? 'datetime_log');
    $shortBy     = trim($_POST['ShortBy'] ?? 'DESC');

    // ==============================
    // VALIDASI ORDER BY
    // ==============================
    $allowedOrder = [
        'nama_petugas' => 'nama_petugas',
        'category_log' => 'category_log',
        'title_log'    => 'title_log',
        'datetime_log' => 'datetime_log'
    ];

    $orderColumn = $allowedOrder[$orderBy] ?? 'datetime_log';

    $shortBy = strtoupper($shortBy);
    $shortBy = ($shortBy == 'ASC') ? 'ASC' : 'DESC';

    // ==============================
    // WHERE
    // ==============================
    $where = [];
    $params = [];
    $types  = '';

    if (!empty($keyword)) {

        switch ($keyword_by) {

            case 'nama_petugas':
                $where[] = "nama_petugas LIKE ?";
                $params[] = "%$keyword%";
                $types .= 's';
            break;

            case 'category_log':
                $where[] = "category_log LIKE ?";
                $params[] = "%$keyword%";
                $types .= 's';
            break;

            case 'title_log':
                $where[] = "title_log LIKE ?";
                $params[] = "%$keyword%";
                $types .= 's';
            break;

            case 'datetime_log':
                $where[] = "DATE(datetime_log) = ?";
                $params[] = $keyword;
                $types .= 's';
            break;

            default:
                $where[] = "(
                    nama_petugas LIKE ? OR
                    category_log LIKE ? OR
                    title_log LIKE ? OR
                    DATE_FORMAT(datetime_log, '%Y-%m-%d') LIKE ?
                )";

                $params[] = "%$keyword%";
                $params[] = "%$keyword%";
                $params[] = "%$keyword%";
                $params[] = "%$keyword%";

                $types .= 'ssss';
            break;
        }
    }

    $whereSql = '';

    if (!empty($where)) {
        $whereSql = "WHERE " . implode(' AND ', $where);
    }

    // ==============================
    // TOTAL DATA
    // ==============================
    $sqlCount = "
        SELECT COUNT(*) as total
        FROM log
        $whereSql
    ";

    $stmtCount = mysqli_prepare($Conn, $sqlCount);

    if (!empty($params)) {
        mysqli_stmt_bind_param($stmtCount, $types, ...$params);
    }

    mysqli_stmt_execute($stmtCount);

    $resultCount = mysqli_stmt_get_result($stmtCount);
    $dataCount   = mysqli_fetch_assoc($resultCount);

    $totalData = $dataCount['total'] ?? 0;
    $pageCount = ($totalData > 0) ? ceil($totalData / $limit) : 0;

    // ==============================
    // QUERY DATA
    // ==============================
    $sql = "
        SELECT *
        FROM log
        $whereSql
        ORDER BY $orderColumn $shortBy
        LIMIT ?, ?
    ";

    $stmt = mysqli_prepare($Conn, $sql);

    // Parameter pagination
    $paramsData = $params;
    $typesData  = $types . 'ii';

    $paramsData[] = $offset;
    $paramsData[] = $limit;

    mysqli_stmt_bind_param($stmt, $typesData, ...$paramsData);

    mysqli_stmt_execute($stmt);

    $query = mysqli_stmt_get_result($stmt);

    // ==============================
    // TAMPILKAN DATA
    // ==============================
    $no = $offset + 1;

    if ($totalData > 0) {

        $first = true;

        while ($row = mysqli_fetch_assoc($query)) {

            $id_log       = $row['id_log'];
            $nama_petugas = $row['nama_petugas'] ?? '-';
            $category_log = $row['category_log'] ?? 'Umum';
            $title_log    = $row['title_log'] ?? '-';
            $datetime_log = $row['datetime_log'];

            // ==========================
            // FORMAT TANGGAL LOG
            // ==========================
            $formatted_datetime = '-';

            if (!empty($datetime_log)) {
                $timezoneName = trim((string)($SessionUserTimezone ?? ''));
                if (preg_match('/^UTC([+-])(\d{2}):(\d{2})$/', $timezoneName, $timezoneOffset)) {
                    $timezoneName = $timezoneOffset[1] . $timezoneOffset[2] . ':' . $timezoneOffset[3];
                }
                try {
                    $userTimezone = new DateTimeZone($timezoneName !== '' ? $timezoneName : 'UTC');
                } catch (Throwable $e) {
                    $userTimezone = new DateTimeZone('UTC');
                }
                try {
                    $dt = new DateTimeImmutable((string)$datetime_log, new DateTimeZone('UTC'));
                    $formatted_datetime = $dt->setTimezone($userTimezone)->format('d/m/Y H:i T');
                } catch (Throwable $e) {
                    $formatted_datetime = date('d/m/Y H:i T', strtotime((string)$datetime_log));
                }
            }

            // ==========================
            // BADGE KATEGORI
            // ==========================
            $badge_category = '<span class="px-2 py-1 bg-light text-dark rounded-2"><small>' . htmlspecialchars($category_log) . '</small></span>';

            // ==========================
            // ROW PERTAMA (Untuk Pembacaan Paginasi jQuery)
            // ==========================
            if ($first) {

                echo '<tr data-page-count="'.$pageCount.'" data-current-page="'.$page.'">';
                $first = false;

            } else {

                echo '<tr>';
            }

            echo '
                <td align="center">
                    <span class="text-muted">'.$no.'</span>
                </td>
                
                <td align="left">
                    <span class="text-muted">'.htmlspecialchars($nama_petugas).'</span>
                </td>

                <td align="left">
                    <span class="text-muted">' . htmlspecialchars($category_log) . '</span>
                </td>

                <td align="left">
                    <a href="javascript:void(0);" class="text-info modal_detail_log" data-id="'.$id_log.'">
                        '.(strlen($title_log) > 20 ? substr(htmlspecialchars($title_log), 0, 17) . '...' : htmlspecialchars($title_log)).'
                    </a>
                </td>

                <td align="left">
                    <span class="text-muted">
                        '.$formatted_datetime.'
                    </span>
                </td>
            </tr>
            ';

            $no++;
        }

    } else {

        echo '
        <tr data-page-count="0" data-current-page="0">
            <td colspan="5" align="center">
                <small class="text-muted">Tidak ada data log aktivitas ditemukan</small>
            </td>
        </tr>
        ';
    }
?>