<?php
date_default_timezone_set('Asia/Jakarta');

include "../../_Config/Connection.php";
include "../../_Config/SimrsFunction.php";
include "../../_Config/Session.php";

// ===================================
// VALIDASI SESSION
// ===================================
if (empty($SessionIdAkses)) {
    echo '
        <tr>
            <td align="center" colspan="6">
                <small class="text-danger">Sesi Akses Berakhir! Silahkan Login Ulang!</small>
            </td>
        </tr>
        <script>
            $("#page_info").html("0/0");
            $("#previous_page").prop("disabled", true);
            $("#next_page").prop("disabled", true);
        </script>
    ';
    exit;
}

// ===================================
// INPUT FILTER
// ===================================
$keyword_by = trim($_POST['keyword_by'] ?? '');
$keyword    = trim($_POST['keyword'] ?? '');
$batas      = (int) ($_POST['batas'] ?? 10);
$page       = (int) ($_POST['page'] ?? 1);
$ShortBy    = strtoupper($_POST['ShortBy'] ?? 'DESC');
$OrderBy    = $_POST['OrderBy'] ?? 'id_akses_entitas';

// ===================================
// VALIDASI
// ===================================
$batas = in_array($batas, [5,10,25,50,100,250,500]) ? $batas : 10;
$page  = max(1, $page);
$posisi = ($page - 1) * $batas;

$allowed_order = ['id_akses_entitas', 'akses', 'deskripsi'];
$allowed_sort  = ['ASC', 'DESC'];
$allowed_search = ['akses', 'deskripsi'];

$OrderBy = in_array($OrderBy, $allowed_order) ? $OrderBy : 'id_akses_entitas';
$ShortBy = in_array($ShortBy, $allowed_sort) ? $ShortBy : 'DESC';

// ===================================
// BUILD WHERE
// ===================================
$where = "";
$params = [];
$types = "";

if (!empty($keyword)) {
    $keyword_like = "%{$keyword}%";

    if (!empty($keyword_by) && in_array($keyword_by, $allowed_search)) {
        $where = " WHERE ae.$keyword_by LIKE ?";
        $params[] = $keyword_like;
        $types .= "s";
    } else {
        $where = " WHERE (ae.akses LIKE ? OR ae.deskripsi LIKE ?)";
        $params[] = $keyword_like;
        $params[] = $keyword_like;
        $types .= "ss";
    }
}

// ===================================
// COUNT TOTAL DATA
// ===================================
$sql_count = "
    SELECT COUNT(*) as total
    FROM akses_entitas ae
    $where
";

$stmt_count = mysqli_prepare($Conn, $sql_count);

if (!empty($params)) {
    mysqli_stmt_bind_param($stmt_count, $types, ...$params);
}

mysqli_stmt_execute($stmt_count);
$result_count = mysqli_stmt_get_result($stmt_count);
$row_count = mysqli_fetch_assoc($result_count);

$jml_data = $row_count['total'];

if ($jml_data == 0) {
    echo '
        <tr>
            <td colspan="6" class="text-center">
                <small class="text-danger">Data Tidak Ditemukan</small>
            </td>
        </tr>
        <script>
            $("#page_info").html("0/0");
            $("#previous_page").prop("disabled", true);
            $("#next_page").prop("disabled", true);
        </script>
    ';
    exit;
}

$JmlHalaman = ceil($jml_data / $batas);
$no = $posisi + 1;

// ===================================
// QUERY DATA OPTIMAL
// ===================================
$sql = "
    SELECT 
        ae.*,

        COALESCE(p.total_pengguna, 0) as jumlah_pengguna,
        COALESCE(f.total_fitur, 0) as jumlah_fitur

    FROM akses_entitas ae

    LEFT JOIN (
        SELECT 
            id_akses_entitas,
            COUNT(*) as total_pengguna
        FROM akses
        GROUP BY id_akses_entitas
    ) p ON ae.id_akses_entitas = p.id_akses_entitas

    LEFT JOIN (
        SELECT 
            id_akses_entitas,
            COUNT(*) as total_fitur
        FROM akses_entitas_acc
        GROUP BY id_akses_entitas
    ) f ON ae.id_akses_entitas = f.id_akses_entitas

    $where

    ORDER BY ae.$OrderBy $ShortBy
    LIMIT ?, ?
";

$stmt = mysqli_prepare($Conn, $sql);

// bind dynamic
if (!empty($params)) {
    $bindParams = $params;
    $bindParams[] = $posisi;
    $bindParams[] = $batas;

    $bindTypes = $types . "ii";

    mysqli_stmt_bind_param($stmt, $bindTypes, ...$bindParams);
} else {
    mysqli_stmt_bind_param($stmt, "ii", $posisi, $batas);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// ===================================
// RENDER DATA
// ===================================
while ($data = mysqli_fetch_assoc($result)) {

    $id_akses_entitas = $data['id_akses_entitas'];
    $akses            = htmlspecialchars($data['akses']);
    $deskripsi        = htmlspecialchars($data['deskripsi']);
    $jumlah_pengguna  = $data['jumlah_pengguna'];
    $jumlah_fitur     = $data['jumlah_fitur'];

    echo '
        <tr>
            <td class="text-center"><small class="text-muted">'.$no.'</small></td>
            <td><small class="text-muted">'.$akses.'</small></td>
            <td><small class="text-muted">'.$deskripsi.'</small></td>

            <td class="text-center">
                <a href="javascript:void(0);" class="p-1 bg-secondary-subtle modal_daftar_fitur" data-id="'.$id_akses_entitas.'">
                    <small class="text-secondary">'.$jumlah_fitur.' Fitur</small>
                </a>
            </td>

            <td class="text-center">
                <a href="javascript:void(0);" class="p-1 bg-secondary-subtle modal_daftar_pengguna" data-id="'.$id_akses_entitas.'">
                    <small class="text-secondary">'.$jumlah_pengguna.' Orang</small>
                </a>
            </td>

            <td class="text-center">
                <a href="javascript:void(0);" class="btn-floating btn-sm" data-bs-toggle="dropdown">
                    <i class="bi bi-three-dots-vertical"></i>
                </a>

                <ul class="dropdown-menu shadow">
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item modal_daftar_fitur" data-id="'.$id_akses_entitas.'">
                            <i class="bi bi-list-check"></i> Daftar Fitur
                        </a>
                    </li>

                    <li>
                        <a href="javascript:void(0);" class="dropdown-item modal_daftar_pengguna" data-id="'.$id_akses_entitas.'">
                            <i class="bi bi-people"></i> Daftar Pengguna
                        </a>
                    </li>

                    <li>
                        <a href="javascript:void(0);" class="dropdown-item modal_edit_entitas" data-id="'.$id_akses_entitas.'">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                    </li>

                    <li>
                        <a href="javascript:void(0);" class="dropdown-item modal_hapus_entitas" data-id="'.$id_akses_entitas.'">
                            <i class="bi bi-trash"></i> Delete
                        </a>
                    </li>
                </ul>
            </td>
        </tr>
    ';

    $no++;
}
?>

<script>
    let page_count = <?= $JmlHalaman ?>;
    let current_page = <?= $page ?>;

    $('#page_info').html(current_page + ' / ' + page_count);
    $('#previous_page').prop('disabled', current_page <= 1);
    $('#next_page').prop('disabled', current_page >= page_count);
</script>