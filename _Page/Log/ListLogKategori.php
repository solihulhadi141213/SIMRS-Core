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
    $orderBy     = trim($_POST['OrderBy'] ?? 'jumlah_log');
    $shortBy     = trim($_POST['ShortBy'] ?? 'DESC');

    // ==============================
    // VALIDASI ORDER BY
    // ==============================
    $allowedOrder = [
        'jumlah_log'   => 'jumlah_log',
        'category_log' => 'category_log'
    ];

    $orderColumn = $allowedOrder[$orderBy] ?? 'jumlah_log';

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
            case 'category_log':
                $where[] = "category_log LIKE ?";
                $params[] = "%$keyword%";
                $types .= 's';
                break;
            default:
                $where[] = "category_log LIKE ?";
                $params[] = "%$keyword%";
                $types .= 's';
                break;
        }
    }

    $whereSql = '';
    if (!empty($where)) {
        $whereSql = "WHERE " . implode(' AND ', $where);
    }

    // ==============================
    // TOTAL DATA KATEGORI (DISTINCT)
    // ==============================
    $sqlCount = "
        SELECT COUNT(DISTINCT category_log) as total
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
    // QUERY DATA REKAPITULASI KATEGORI + LOG TERAKHIR
    // ==============================
    $sql = "
        SELECT 
            l.category_log, 
            COUNT(l.id_log) as jumlah_log,
            MAX(l.datetime_log) as max_datetime
        FROM log l
        $whereSql
        GROUP BY l.category_log
        ORDER BY $orderColumn $shortBy
        LIMIT ?, ?
    ";

    $stmt = mysqli_prepare($Conn, $sql);

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
            $category_log = $row['category_log'] ?? 'Umum';
            $jumlah_log   = $row['jumlah_log'] ?? 0;
            $max_datetime = $row['max_datetime'] ?? '';

            // Ambil detail log terakhir (title) berdasarkan kategori dan max_datetime
            $sqlDetail = "SELECT title_log FROM log WHERE category_log = ? AND datetime_log = ? LIMIT 1";
            $stmtDetail = mysqli_prepare($Conn, $sqlDetail);
            mysqli_stmt_bind_param($stmtDetail, "ss", $category_log, $max_datetime);
            mysqli_stmt_execute($stmtDetail);
            $resDetail = mysqli_stmt_get_result($stmtDetail);
            $rowDetail = mysqli_fetch_assoc($resDetail);
            $last_title = $rowDetail['title_log'] ?? '-';

            // Format Tanggal Log Terakhir
            $formatted_datetime = '-';
            if (!empty($max_datetime)) {
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
                    $dt = new DateTimeImmutable((string)$max_datetime, new DateTimeZone('UTC'));
                    $formatted_datetime = $dt->setTimezone($userTimezone)->format('d/m/Y H:i');
                } catch (Throwable $e) {
                    $formatted_datetime = date('d/m/Y H:i', strtotime((string)$max_datetime));
                }
            }

            // Baris pertama menyertakan atribut paginasi agar dibaca oleh fungsi AJAX di Log.js
            if ($first) {
                echo '<tr data-page-count="'.$pageCount.'" data-current-page="'.$page.'">';
                $first = false;
            } else {
                echo '<tr>';
            }

            echo '
                <td align="center" valign="middle">
                    <span class="text-muted">'.$no.'</span>
                </td>
                
                <td align="left" valign="middle">
                    <span class="text-dark font-weight-bold">'.htmlspecialchars($category_log).'</span><br>
                    <small class="text-muted">'.$formatted_datetime.'</small>
                </td>

                <td align="left" valign="middle">
                    <span class="badge bg-secondary text-white">'.$jumlah_log.' Log</span>
                </td>
            </tr>
            ';

            $no++;
        }
    } else {
        echo '
        <tr data-page-count="0" data-current-page="0">
            <td colspan="3" align="center">
                <small class="text-muted">Tidak ada data log kategori ditemukan</small>
            </td>
        </tr>
        ';
    }
?>