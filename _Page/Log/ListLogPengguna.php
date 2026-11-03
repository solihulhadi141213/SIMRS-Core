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
        'jumlah_log' => 'jumlah_log',
        'nama'       => 'nama',
        'email'      => 'email'
    ];

    $orderColumn = $allowedOrder[$orderBy] ?? 'jumlah_log';

    $shortBy = strtoupper($shortBy);
    $shortBy = ($shortBy == 'ASC') ? 'ASC' : 'DESC';

    // ==============================
    // WHERE (Untuk tabel akses / log)
    // ==============================
    $where = [];
    $params = [];
    $types  = '';

    if (!empty($keyword)) {
        switch ($keyword_by) {
            case 'nama':
                $where[] = "a.nama LIKE ?";
                $params[] = "%$keyword%";
                $types .= 's';
                break;
            case 'email':
                $where[] = "a.email LIKE ?";
                $params[] = "%$keyword%";
                $types .= 's';
                break;
            default:
                $where[] = "(a.nama LIKE ? OR a.email LIKE ?)";
                $params[] = "%$keyword%";
                $params[] = "%$keyword%";
                $types .= 'ss';
                break;
        }
    }

    $whereSql = '';
    if (!empty($where)) {
        $whereSql = "WHERE " . implode(' AND ', $where);
    }

    // ==============================
    // TOTAL DATA PENGGUNA
    // ==============================
    $sqlCount = "
        SELECT COUNT(DISTINCT a.id_akses) as total
        FROM akses a
        LEFT JOIN log l ON a.id_akses = l.id_akses
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
    // QUERY DATA PENGGUNA & JUMLAH LOG
    // ==============================
    $sql = "
        SELECT a.id_akses, a.nama, a.email, COUNT(l.id_log) as jumlah_log
        FROM akses a
        LEFT JOIN log l ON a.id_akses = l.id_akses
        $whereSql
        GROUP BY a.id_akses, a.nama, a.email
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
            $nama       = $row['nama'] ?? '-';
            $email      = $row['email'] ?? '-';
            $jumlah_log = $row['jumlah_log'] ?? 0;

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
                        <span class="text-dark font-weight-bold">'.htmlspecialchars($nama).'</span><br>
                        <small class="text-muted">'.htmlspecialchars($email).'</small>
                    </td>

                    <td align="left" valign="middle">
                        <span class="badge bg-primary text-white">'.$jumlah_log.' Log</span>
                    </td>
                </tr>
            ';

            $no++;
        }
    } else {
        echo '
            <tr data-page-count="0" data-current-page="0">
                <td colspan="3" align="center">
                    <small class="text-muted">Tidak ada data riwayat aktivitas pengguna ditemukan</small>
                </td>
            </tr>
        ';
    }
?>