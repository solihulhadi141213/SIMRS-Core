<?php
// Inisialisasi
date_default_timezone_set('Asia/Jakarta');

// Connection
include "../../_Config/Connection.php";
include "../../_Config/SimrsFunction.php";
include "../../_Config/Session.php";

// Validasi session
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

// ===============================
// INPUT FILTER
// ===============================
$keyword_by = isset($_POST['keyword_by']) ? trim($_POST['keyword_by']) : '';
$keyword    = isset($_POST['keyword']) ? trim($_POST['keyword']) : '';
$batas      = isset($_POST['batas']) ? (int) $_POST['batas'] : 10;
$page       = isset($_POST['page']) ? (int) $_POST['page'] : 1;
$ShortBy    = isset($_POST['ShortBy']) ? strtoupper($_POST['ShortBy']) : 'DESC';
$OrderBy    = isset($_POST['OrderBy']) ? $_POST['OrderBy'] : 'id_akses_fitur';

// validasi pagination
$batas = in_array($batas, [5,10,25,50,100,250,500]) ? $batas : 10;
$page  = ($page > 0) ? $page : 1;
$posisi = ($page - 1) * $batas;

// ===============================
// VALIDASI ORDER BY
// ===============================
$allowed_order = ['id_akses_fitur', 'nama_fitur', 'kategori', 'kode'];
$allowed_sort  = ['ASC', 'DESC'];
$allowed_search = ['nama_fitur', 'kategori', 'kode'];

if (!in_array($OrderBy, $allowed_order)) {
    $OrderBy = 'id_akses_fitur';
}

if (!in_array($ShortBy, $allowed_sort)) {
    $ShortBy = 'DESC';
}

// ===============================
// BUILD WHERE
// ===============================
$where = "";
$params = [];
$types = "";

if (!empty($keyword)) {
    $keyword_like = "%$keyword%";

    if (!empty($keyword_by) && in_array($keyword_by, $allowed_search)) {
        $where = " WHERE $keyword_by LIKE ?";
        $params[] = $keyword_like;
        $types .= "s";
    } else {
        $where = " WHERE nama_fitur LIKE ? 
                   OR kategori LIKE ? 
                   OR kode LIKE ?";
        $params = [$keyword_like, $keyword_like, $keyword_like];
        $types = "sss";
    }
}

// ===============================
// COUNT TOTAL DATA
// ===============================
$sql_count = "SELECT COUNT(*) as total FROM akses_fitur $where";
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
$no = 1 + $posisi;

// ===============================
// QUERY DATA + JUMLAH PENGGUNA
// ===============================
$sql = "
    SELECT 
        af.*,
        COUNT(aa.id_akses_acc) as jumlah_pengguna
    FROM akses_fitur af
    LEFT JOIN akses_acc aa 
        ON af.id_akses_fitur = aa.id_akses_fitur
    $where
    GROUP BY af.id_akses_fitur
    ORDER BY $OrderBy $ShortBy
    LIMIT ?, ?
";

$stmt = mysqli_prepare($Conn, $sql);

// bind parameter dinamis
if (!empty($params)) {
    $params[] = $posisi;
    $params[] = $batas;
    $types .= "ii";
    mysqli_stmt_bind_param($stmt, $types, ...$params);
} else {
    mysqli_stmt_bind_param($stmt, "ii", $posisi, $batas);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// ===============================
// RENDER DATA
// ===============================
while ($data = mysqli_fetch_assoc($result)) {
    $id_akses_fitur = $data['id_akses_fitur'];
    $nama_fitur = htmlspecialchars($data['nama_fitur']);
    $kategori = htmlspecialchars($data['kategori']);
    $kode = htmlspecialchars($data['kode']);
    $JumlahPengguna = $data['jumlah_pengguna'];

    echo "
        <tr>
            <td class='text-center'><small class='text-muted'>{$no}</small></td>
            <td>
                <a href='javascript:void(0);' class='text-decoration-underline text-primary modal_detail' data-id='{$id_akses_fitur}'>
                    <small>{$nama_fitur}</small>
                </a>
            </td>
            <td><small class='text-muted'>{$kategori}</small></td>
            <td><small class='text-muted'>{$kode}</small></td>
            <td class='text-center'>
                <a href='javascript:void(0);' class='modal_akses_pengguna p-1 bg-body-secondary' data-id='{$id_akses_fitur}'>
                    <small class='text-muted'>{$JumlahPengguna}</small>
                </a>
            </td>
            <td class='text-center'>
                <a href='javascript:void(0);' class='btn-floating btn-sm' data-bs-toggle='dropdown'>
                    <i class='bi bi-three-dots-vertical'></i>
                </a>
                <ul class='dropdown-menu shadow'>
                    <li>
                        <a href='javascript:void(0);' class='dropdown-item modal_detail' data-id='{$id_akses_fitur}'>
                            <i class='bi bi-info-circle'></i> Detail
                        </a>
                    </li>
                    <li>
                        <a href='javascript:void(0);' class='dropdown-item modal_edit' data-id='{$id_akses_fitur}'>
                            <i class='bi bi-pencil'></i> Edit
                        </a>
                    </li>
                    <li>
                        <a href='javascript:void(0);' class='dropdown-item modal_hapus' data-id='{$id_akses_fitur}'>
                            <i class='bi bi-trash'></i> Hapus
                        </a>
                    </li>
                </ul>
            </td>
        </tr>
    ";

    $no++;
}
?>

<script>
    var page_count = <?php echo $JmlHalaman; ?>;
    var curent_page = <?php echo $page; ?>;

    $('#page_info').html(curent_page + ' / ' + page_count);
    $('#previous_page').prop('disabled', curent_page == 1);
    $('#next_page').prop('disabled', curent_page >= page_count);
</script>