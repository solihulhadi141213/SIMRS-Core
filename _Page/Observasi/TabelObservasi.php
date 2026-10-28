<?php
// Menyediakan baris tabel observasi sesuai filter, urutan, dan pagination dari modal.
include "../../_Config/Connection.php";
include "../../_Config/Session.php";

/** Menampilkan satu baris pesan yang tetap dapat dibaca pengendali pagination. */
function observasiTableMessage(string $message, string $variant = 'muted'): void
{
    echo '<tr data-page-count="0" data-current-page="0">'
        . '<td colspan="9" class="text-center text-' . $variant . '">'
        . '<small>' . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . '</small>'
        . '</td></tr>';
}

// Endpoint tabel hanya menerima request POST dari sesi yang aktif.
if (empty($SessionIdAkses)) {
    http_response_code(401);
    observasiTableMessage('Sesi akses berakhir. Silakan login kembali.', 'danger');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    observasiTableMessage('Metode request tidak valid.', 'danger');
    exit;
}

// Batasi nilai pagination dan urutan pada daftar yang dapat digunakan oleh query.
$keywordBy = trim((string) ($_POST['keyword_by'] ?? ''));
$keyword   = trim((string) ($_POST['keyword'] ?? ''));
$limit     = (int) ($_POST['batas'] ?? 10);
$page      = max(1, (int) ($_POST['page_filter'] ?? 1));
$sort      = strtoupper(trim((string) ($_POST['ShortBy'] ?? 'DESC')));
$orderBy   = trim((string) ($_POST['OrderBy'] ?? 'datetime_observation'));
$limit     = in_array($limit, [5, 10, 25, 50, 100, 250, 500], true) ? $limit : 10;
$sort      = in_array($sort, ['ASC', 'DESC'], true) ? $sort : 'DESC';

$allowedOrder = [
    'id_pasien'            => 'o.id_pasien',
    'nama'                 => 'p.nama',
    'datetime_observation' => 'o.datetime_observation',
    'category_name'        => 'r.category_name',
    'observation_name'     => 'r.observation_name',
    'petugas_id'           => 'o.petugas_id',
];
$orderColumn = $allowedOrder[$orderBy] ?? 'o.datetime_observation';

// Susun kondisi pencarian memakai placeholder agar nilai pengguna tidak menjadi bagian SQL.
$where = [];
$params = [];
$types = '';
if ($keyword !== '') {
    if ($keywordBy === 'datetime_observation') {
        $date = DateTime::createFromFormat('!Y-m-d', $keyword);
        if ($date && $date->format('Y-m-d') === $keyword) {
            $where[] = 'o.datetime_observation >= ? AND o.datetime_observation < ?';
            $params[] = $date->format('Y-m-d 00:00:00');
            $params[] = $date->modify('+1 day')->format('Y-m-d 00:00:00');
            $types .= 'ss';
        } else {
            observasiTableMessage('Pilih tanggal yang valid untuk filter.', 'danger');
            exit;
        }
    } elseif (isset($allowedOrder[$keywordBy])) {
        $where[] = $allowedOrder[$keywordBy] . ' LIKE ?';
        $params[] = '%' . $keyword . '%';
        $types .= 's';
    } else {
        $where[] = '(CAST(o.id_pasien AS CHAR) LIKE ? OR p.nama LIKE ? OR '
            . 'r.category_code LIKE ? OR r.category_name LIKE ? OR '
            . 'r.observation_name LIKE ? OR o.petugas_nama LIKE ? OR '
            . 'CAST(o.petugas_id AS CHAR) LIKE ?)';
        $search = '%' . $keyword . '%';
        array_push($params, $search, $search, $search, $search, $search, $search, $search);
        $types .= 'sssssss';
    }
}
$whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

// Hitung hasil lebih dahulu agar jumlah halaman dan offset selalu akurat.
$fromSql = 'FROM observation o '
    . 'INNER JOIN observation_reference r ON r.id_observation_reference = o.id_observation_reference '
    . 'LEFT JOIN pasien p ON p.id_pasien = o.id_pasien ';
$stmtCount = mysqli_prepare($Conn, 'SELECT COUNT(*) AS total ' . $fromSql . $whereSql);
if (!$stmtCount) {
    error_log('Observasi tabel: gagal menyiapkan query hitung: ' . mysqli_error($Conn));
    http_response_code(500);
    observasiTableMessage('Gagal menyiapkan pencarian observasi.', 'danger');
    exit;
}
if ($params) {
    mysqli_stmt_bind_param($stmtCount, $types, ...$params);
}
if (!mysqli_stmt_execute($stmtCount)) {
    error_log('Observasi tabel: gagal menghitung data: ' . mysqli_stmt_error($stmtCount));
    mysqli_stmt_close($stmtCount);
    http_response_code(500);
    observasiTableMessage('Gagal mengambil jumlah data observasi.', 'danger');
    exit;
}
$countResult = mysqli_stmt_get_result($stmtCount);
$total = (int) (mysqli_fetch_assoc($countResult)['total'] ?? 0);
mysqli_stmt_close($stmtCount);
if ($total === 0) {
    observasiTableMessage('Data observasi tidak ditemukan.');
    exit;
}

$pageCount = (int) ceil($total / $limit);
$page = min($page, $pageCount);
$offset = ($page - 1) * $limit;

// Ambil data observasi serta nama pasien dan referensi yang diperlukan untuk setiap baris.
$sql = 'SELECT o.id_observation, o.observation_id, o.id_pasien, o.datetime_observation, o.petugas_id, o.petugas_nama, '
    . 'p.nama AS nama_pasien, r.category_code, r.category_name, r.observation_name '
    . $fromSql . $whereSql
    . " ORDER BY $orderColumn $sort, o.id_observation DESC LIMIT ?, ?";
$stmt = mysqli_prepare($Conn, $sql);
if (!$stmt) {
    error_log('Observasi tabel: gagal menyiapkan query data: ' . mysqli_error($Conn));
    http_response_code(500);
    observasiTableMessage('Gagal menyiapkan daftar observasi.', 'danger');
    exit;
}
$dataParams = $params;
$dataParams[] = $offset;
$dataParams[] = $limit;
mysqli_stmt_bind_param($stmt, $types . 'ii', ...$dataParams);
if (!mysqli_stmt_execute($stmt)) {
    error_log('Observasi tabel: gagal mengambil data: ' . mysqli_stmt_error($stmt));
    mysqli_stmt_close($stmt);
    http_response_code(500);
    observasiTableMessage('Gagal mengambil daftar observasi.', 'danger');
    exit;
}

// Cetak baris tabel; nilai relasi yang kosong diberi penanda agar tetap mudah dibaca.
$escape = static fn($value): string => htmlspecialchars((string) ($value ?? '-'), ENT_QUOTES, 'UTF-8');
$timezoneName = trim((string) ($SessionUserTimezone ?? ''));

// Browser lama dapat mengirim offset UTC, sedangkan DateTimeZone menerima offset tanpa awalan "UTC".
if (preg_match('/^UTC([+-])(\\d{2}):(\\d{2})$/', $timezoneName, $timezoneOffset)) {
    $timezoneName = $timezoneOffset[1] . $timezoneOffset[2] . ':' . $timezoneOffset[3];
}

try {
    $observationTimezone = new DateTimeZone($timezoneName !== '' ? $timezoneName : 'UTC');
} catch (Throwable $exception) {
    // Data timezone lama/tidak valid tidak boleh membuat tabel gagal ditampilkan.
    $observationTimezone = new DateTimeZone('UTC');
}

$utcTimezone = new DateTimeZone('UTC');
$number = $offset + 1;
$first = true;
$result = mysqli_stmt_get_result($stmt);
while ($row = mysqli_fetch_assoc($result)) {
    $attributes = $first
        ? ' data-page-count="' . $pageCount . '" data-current-page="' . $page . '"'
        : '';
    $first = false;
    $category = $row['category_code'] ?: $row['category_name'];
    $petugas = $row['petugas_nama'] ?: (!empty($row['petugas_id']) ? 'ID ' . (int) $row['petugas_id'] : '-');

    if(empty($row['observation_id'])) {
        $observation_id = '
            <a href="javascript:void(0);" class="kirim_observation text-danger" data-id="'.$row['id_observation'].'">
                <small class="mp-2">
                    <i class="bi bi-send"></i> Kirim Observation
                </small>
            </a>
        ';
    }else{
        $observation_id = '
            <a href="javascript:void(0);" class="modal_detail_observation text-primary" data-id="'.$row['observation_id'].'">
                <small><i class="bi bi-info-circle"></i> '.$escape($row['observation_id']).'</small>
            </a>
        ';
    }

    // Nilai database adalah UTC; konversi hanya untuk tampilan sesuai timezone pengguna.
    $datetimeUtc = trim((string) ($row['datetime_observation'] ?? ''));
    if ($datetimeUtc !== '') {
        try {
            $datetime_observation = (new DateTimeImmutable($datetimeUtc, $utcTimezone))
                ->setTimezone($observationTimezone)
                ->format('d/m/Y H:i T');
        } catch (Throwable $exception) {
            $datetime_observation = '-';
        }
    } else {
        $datetime_observation = '-';
    }
    echo '
        <tr' . $attributes . '>
            <td class="text-center">
                <small class="text-muted">' . $number++ . '</small>
            </td>
            <td>
                <a href="javascript:void(0);" class="modal_detail" data-id="'.$row['id_observation'].'">
                    <small class="text-primary">' . (int) $row['id_pasien'] . '</small>
                </a>
            </td>
            <td>
                <small class="text-muted">' . $escape($row['nama_pasien']) . '</small>
            </td>
            <td>
                <small class="text-muted text-nowrap">
                ' . $escape($datetime_observation) . '
                </small>
            </td>
            <td>
                <small class="text-muted">' . $escape($category) . '</small>
            </td>
            <td>
                <small lass="text-muted">' . $escape($row['observation_name']) . '</small>
            </td>
            <td>
                <small class="text-muted">' . $escape($petugas) . '</small>
            </td>
            <td>
                ' . $observation_id . '
            </td>
            <td align="center" class="icon-btn">
                <button class="btn btn-md btn-secondary btn-floating" data-bs-toggle="dropdown">
                    <i class="bi bi-three-dots-vertical"></i>
                </button>
                <ul class="dropdown-menu shadow">
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item modal_detail" data-id="'.$row['id_observation'].'">
                            <i class="bi bi-info-circle"></i> Detail
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item modal_edit" data-id="'.$row['id_observation'].'">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="text-danger dropdown-item modal_hapus" data-id="'.$row['id_observation'].'">
                            <i class="bi bi-trash"></i> Hapus
                        </a>
                    </li>
                </ul>
            </td>
        </tr>
    ';
}
mysqli_stmt_close($stmt);
?>
