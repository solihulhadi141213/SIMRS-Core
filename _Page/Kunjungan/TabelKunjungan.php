<?php
header('Content-Type: text/html; charset=utf-8');

// Koneksi
include "../../_Config/Connection.php";
include "../../_Config/SimrsFunction.php";

// ==============================
// PAGINATION
// ==============================
$page   = (!empty($_POST['page_filter'])) ? (int)$_POST['page_filter'] : 1;
$limit  = (!empty($_POST['batas'])) ? (int)$_POST['batas'] : 10;

if ($page < 1) {
    $page = 1;
}

$offset = ($page - 1) * $limit;

// ==============================
// FILTER
// ==============================
$keyword       = trim($_POST['keyword'] ?? '');
$keyword_by    = trim($_POST['keyword_by'] ?? '');
$orderBy       = trim($_POST['OrderBy'] ?? 'datetime_daftar');
$shortBy       = trim($_POST['ShortBy'] ?? 'DESC');

// ==============================
// VALIDASI ORDER BY
// ==============================
$allowedOrder = [
    'id_pasien'         => 'k.id_pasien',
    'nama'              => 'p.nama',
    'prioritas'         => 'k.prioritas',
    'jenis_kunjungan'   => 'k.jenis_kunjungan',
    'dpjp_nama'         => 'k.dpjp_nama',
    'kode_poliklinik'   => 'k.kode_poliklinik',
    'poliklinik'        => 'k.poliklinik',
    'kelas'             => 'k.kelas',
    'pembayaran_metode' => 'k.pembayaran_metode',
    'datetime_daftar'   => 'k.datetime_daftar',
    'status'            => 'k.status'
];

$orderColumn = $allowedOrder[$orderBy] ?? 'k.datetime_daftar';

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

        case 'id_pasien':
            $where[] = "k.id_pasien LIKE ?";
            $params[] = "%$keyword%";
            $types .= 's';
        break;

        case 'nama':
            $where[] = "p.nama LIKE ?";
            $params[] = "%$keyword%";
            $types .= 's';
        break;

        case 'prioritas':
            $where[] = "k.prioritas LIKE ?";
            $params[] = "%$keyword%";
            $types .= 's';
        break;

        case 'jenis_kunjungan':
            $where[] = "k.jenis_kunjungan LIKE ?";
            $params[] = "%$keyword%";
            $types .= 's';
        break;

        case 'dpjp_nama':
            $where[] = "k.dpjp_nama LIKE ?";
            $params[] = "%$keyword%";
            $types .= 's';
        break;

        case 'poliklinik':
            $where[] = "k.poliklinik LIKE ?";
            $params[] = "%$keyword%";
            $types .= 's';
        break;

        case 'kelas':
            $where[] = "k.kelas LIKE ?";
            $params[] = "%$keyword%";
            $types .= 's';
        break;

        case 'pembayaran_metode':
            $where[] = "k.pembayaran_metode LIKE ?";
            $params[] = "%$keyword%";
            $types .= 's';
        break;
        
        case 'status':
            $where[] = "k.status LIKE ?";
            $params[] = "%$keyword%";
            $types .= 's';
        break;

        case 'datetime_daftar':
            $where[] = "DATE(k.datetime_daftar) = ?";
            $params[] = $keyword;
            $types .= 's';
        break;

        default:
            $where[] = "(
                p.nama LIKE ? OR
                k.id_pasien LIKE ? OR
                k.status LIKE ? OR
                DATE_FORMAT(k.datetime_daftar, '%Y-%m-%d') LIKE ?
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
    FROM kunjungan k
    LEFT JOIN pasien p ON k.id_pasien = p.id_pasien
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
    SELECT
        k.*,
        p.nama as nama_pasien,
        poli.kode as kode_poli,
        d.kode as kode_dpjp
    FROM kunjungan k
    LEFT JOIN pasien p ON k.id_pasien = p.id_pasien
    LEFT JOIN poliklinik poli ON k.id_poliklinik = poli.id_poliklinik
    LEFT JOIN dokter d ON k.dpjp_id = d.id_dokter
    $whereSql
    ORDER BY $orderColumn $shortBy
    LIMIT ?, ?
";

$stmt = mysqli_prepare($Conn, $sql);

// parameter pagination
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

        $id_kunjungan = $row['id_kunjungan'];
        $id_pasien = $row['id_pasien'];

        // ==========================
        // BADGE JENIS KUNJUNGAN
        // ==========================
        $badge_jenis = '<span class="px-2 py-1 bg-secondary rounded-2"><small>UNK</small></span>';

        if ($row['jenis_kunjungan'] == "Rajal") {
            $badge_jenis = '<span class="px-2 py-1 bg-primary rounded-2"><small>RJL</small></span>';
        }

        if ($row['jenis_kunjungan'] == "Ranap") {
            $badge_jenis = '<span class="px-2 py-1 bg-info rounded-2"><small>RNP</small></span>';
        }

        // ==========================
        // FORMAT TANGGAL
        // ==========================
        $datetime_daftar = '-';

        if (!empty($row['datetime_daftar'])) {
            $datetime_daftar = date('d/m/Y', strtotime($row['datetime_daftar']));
        }

        // ==========================
        // LABEL POLI
        // ==========================
        if (!empty($row['kode_poli'])) {

            $label_kode_poli = '
                <a href="javascript:void(0);" class="text-primary modal_detail_poliklinik" data-id="'.$row['id_poliklinik'].'">
                    <small class="text-primary">'.$row['kode_poli'].'</small>
                </a>
            ';

        } else {

            $label_kode_poli = '
                <a href="javascript:void(0);" class="text-muted">
                    <small class="text-muted">-</small>
                </a>
            ';
        }

        // ==========================
        // LABEL DPJP
        // ==========================
        if (!empty($row['kode_dpjp'])) {

            $label_dpjp = '
                <a href="javascript:void(0);" class="text-primary modal_detail_dokter" data-id="'.$row['id_kunjungan'].'">
                    <small class="text-primary">'.$row['kode_dpjp'].'</small>
                </a>
            ';

        } else {
            $label_dpjp = '
                <a href="javascript:void(0);" class="text-muted">
                    <small class="text-muted">-</small>
                </a>
            ';
        }

        // ==========================
        // LABEL PEMBAYARAN
        // ==========================
        if ($row['pembayaran_metode'] == "UMUM") {

            $label_pembayaran = '<small class="text-success">UMM</small>';

        } else {

            $label_pembayaran = '<small class="text-secondary">ASR</small>';
        }

        // ==========================
        // LABEL KELAS
        // ==========================
        if (empty($row['kelas'])) {
            $label_kelas = '<small class="text-muted">-</small>';
        } else {
            $label_kelas = '
                <a href="javascript:void(0);" class="modal_detail_kelas" data-id="'.$id_kunjungan.'">
                    <small class="text-primary">'.$row['kelas'].'</small>
                </a>
            ';
        }
        
        // ==========================
        // LABEL PRIORITAS
        // ==========================
        $prioritas = $row['prioritas'];
        if($prioritas=="Normal"){
            $label_prioritas = '
                <span class="px-2 py-1 bg-success rounded-2">
                    <small class="text text-white">NMR</small>
                </span>
            ';
        }
        if($prioritas=="Urgent"){
            $label_prioritas = '
                <span class="px-2 py-1 bg-warning rounded-2">
                    <small class="text text-white">URG</small>
                </span>
            ';
        }
        if($prioritas=="Emergency"){
            $label_prioritas = '
                <span class="px-2 py-1 bg-danger rounded-2">
                    <small class="text text-white">EMR</small>
                </span>
            ';
        }

        // ==========================
        // LABEL STATUS
        // ==========================
        $label_status = '<span class="px-2 py-1 bg-secondary-subtle text-secondary rounded-2" title="Tidak Diketahui">NON</span>';

        if ($row['status'] == "Terdaftar") {
            $label_status = '<span class="px-2 py-1 bg-warning-subtle text-warning rounded-2" title="Terdaftar">REG</span>';
        }

        if ($row['status'] == "Selesai") {
            $label_status = '<span class="px-2 py-1 bg-success-subtle text-success rounded-2" title="Selesai">DON</span>';
        }

        if ($row['status'] == "Batal") {
            $label_status = '<span class="px-2 py-1 bg-danger-subtle text-danger rounded-2" title="Batal">CNL</span>';
        }

        if ($row['status'] == "Meninggal") {
            $label_status = '<span class="px-2 py-1 bg-dark-subtle rounded-2" title="Meninggal">PMD</span>';
        }

        // ==========================
        // ROW PERTAMA
        // ==========================
        if ($first) {

            echo '<tr data-page-count="'.$pageCount.'" data-current-page="'.$page.'">';
            $first = false;

        } else {

            echo '<tr>';
        }

        echo '
            <td align="center"><small>'.$no.'</small></td>

            <td>
                <a href="javascript:void(0);" class="text-primary text-decoration-underline modal_detail" data-id="'.$id_kunjungan.'">
                    <small>'.$row['nama_pasien'].'</small>
                </a>
            </td>
            <td>
                <a href="javascript:void(0);" class="text-primary modal_detail_pasien" data-id="'.$id_pasien.'">
                    <small>'.$id_pasien.'</small>
                </a>
            </td>

            <td>
                <small class="text-muted">'.$datetime_daftar.'</small>
            </td>

            <td>'.$badge_jenis.'</td>

            <td>'.$label_kode_poli.'</td>

            <td>'.$label_kelas.'</td>

            <td>'.$label_dpjp.'</td>

            <td><small>'.$label_pembayaran.'</small></td>
            <td align="center"><small>'.$label_prioritas.'</small></td>

            <td align="center">
                <a href="javascript:void(0);" class="modal_detail_status" data-id="'.$id_kunjungan.'">
                    '.$label_status.'
                </a>
            </td>

            <td align="center" class="icon-btn">
                <button class="btn btn-sm btn-floating" data-bs-toggle="dropdown">
                    <i class="bi bi-three-dots-vertical"></i>
                </button>

                <ul class="dropdown-menu shadow">

                    <li>
                        <a href="javascript:void(0);" class="dropdown-item modal_detail" data-id="'.$id_kunjungan.'">
                            <i class="bi bi-info-circle"></i> Detail Kunjungan
                        </a>
                    </li>

                    <hr>

                    <li>
                        <a href="javascript:void(0);" class="dropdown-item modal_edit" data-id="'.$id_kunjungan.'" data-from="tabel">
                            <i class="bi bi-pencil"></i> Edit Kunjungan
                        </a>
                    </li>

                    <li>
                        <a href="javascript:void(0);" class="dropdown-item modal_update_status" data-id="'.$id_kunjungan.'" data-from="tabel">
                            <i class="bi bi-tag"></i> Update Status
                        </a>
                    </li>

                    <li>
                        <a href="javascript:void(0);" class="dropdown-item modal_hapus" data-id="'.$id_kunjungan.'" data-from="tabel">
                            <i class="bi bi-trash"></i> Hapus Kunjungan
                        </a>
                    </li>

                    <hr>

                    <li>
                        <a href="javascript:void(0);" class="dropdown-item modal_cetak_label" data-id="'.$id_kunjungan.'">
                            <i class="bi bi-printer"></i> Cetak Label
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
        <td colspan="12" align="center">
            <small class="text-muted">Tidak ada data kunjungan</small>
        </td>
    </tr>
    ';
}
?>