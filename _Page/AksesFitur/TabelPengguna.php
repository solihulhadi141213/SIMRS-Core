<?php
// Inisialisasi
date_default_timezone_set('Asia/Jakarta');

// Connection
include "../../_Config/Connection.php";
include "../../_Config/SimrsFunction.php";
include "../../_Config/Session.php";

$JmlHalaman = 0;
$page       = 0;
$batas      = 10;

// Fungsi Helper untuk Response Error (Mengurangi redundansi kode)
function sendErrorResponse($message) {
    echo '
        <tr>
            <td align="center" colspan="6">
                <small class="text-danger">' . $message . '</small>
            </td>
        </tr>
        <script>
            $("#page_info_pengguna").html("0/0");
            $("#previous_page_pengguna").prop("disabled", true);
            $("#next_page_pengguna").prop("disabled", true);
        </script>
    ';
    exit;
}

// Validasi Akses
if (empty($SessionIdAkses)) {
    sendErrorResponse("Sesi Akses Berakhir! Silahkan Login Ulang!");
}

// Validasi id_akses_fitur
if (empty($_POST['id_akses_fitur'])) {
    sendErrorResponse("Akses Fitur Tidak Boleh Kosong!");
}

$id_akses_fitur = $_POST['id_akses_fitur'];
$keyword = $_POST['keyword'] ?? "";
$page = $_POST['page'] ?? 1;
$posisi = ($page - 1) * $batas;

// Parameter Sorting (Whitelist untuk mencegah SQL Injection pada ORDER BY)
$OrderBy = "nama";
$ShortBy = "ASC";

// 1. Menghitung Jumlah Data dengan Prepared Statement
if (empty($keyword)) {
    $stmtCount = $Conn->prepare("SELECT COUNT(id_akses) FROM akses");
} else {
    $queryCount = "SELECT COUNT(id_akses) FROM akses WHERE nama LIKE ? OR email LIKE ?";
    $stmtCount = $Conn->prepare($queryCount);
    $likeKeyword = "%$keyword%";
    $stmtCount->bind_param("ss", $likeKeyword, $likeKeyword);
}

$stmtCount->execute();
$resCount = $stmtCount->get_result();
$jml_data = $resCount->fetch_row()[0];
$stmtCount->close();

if ($jml_data == 0) {
    sendErrorResponse("Data Tidak Ditemukan");
}

// Mengatur Halaman
$JmlHalaman = ceil($jml_data / $batas);
$no = 1 + $posisi;

// 2. Query Ambil Data dengan Prepared Statement
if (empty($keyword)) {
    // Order By tidak bisa diparameterisasi dengan bind_param, pastikan variabel aman
    $sqlData = "SELECT * FROM akses ORDER BY $OrderBy $ShortBy LIMIT ?, ?";
    $stmtData = $Conn->prepare($sqlData);
    $stmtData->bind_param("ii", $posisi, $batas);
} else {
    $sqlData = "SELECT * FROM akses WHERE nama LIKE ? OR email LIKE ? ORDER BY $OrderBy $ShortBy LIMIT ?, ?";
    $stmtData = $Conn->prepare($sqlData);
    $likeKeyword = "%$keyword%";
    $stmtData->bind_param("ssii", $likeKeyword, $likeKeyword, $posisi, $batas);
}

$stmtData->execute();
$query = $stmtData->get_result();

while ($data = $query->fetch_assoc()) {
    $id_akses = $data['id_akses'];
    $id_akses_entitas = $data['id_akses_entitas'];
    $nama = $data['nama'];
    $email = $data['email'];

    // Ambil Nama Akses/Entitas
    $akses = (!empty($id_akses_entitas)) ? getDataDetail_v2($Conn, 'akses_entitas', 'id_akses_entitas', $id_akses_entitas, 'akses') : "-";

    // 3. Cek Ijin Akses dengan Prepared Statement
    $stmtIjin = $Conn->prepare("SELECT id_akses_acc FROM akses_acc WHERE id_akses = ? AND id_akses_fitur = ?");
    $stmtIjin->bind_param("ss", $id_akses, $id_akses_fitur);
    $stmtIjin->execute();
    $ijin_akses = $stmtIjin->get_result()->num_rows;
    $stmtIjin->close();

    if ($ijin_akses == 0) {
        $button_opsi = '
            <button type="button" class="btn btn-sm btn-outline-danger ubah_status" data-id_akses="'.$id_akses.'" data-id_akses_fitur="'.$id_akses_fitur.'" data-status="add" title="Aktifkan">
                <i class="bi bi-check"></i>
            </button>';
    } else {
        $button_opsi = '
            <button type="button" class="btn btn-sm btn-success ubah_status" data-id_akses="'.$id_akses.'" data-id_akses_fitur="'.$id_akses_fitur.'" data-status="remove" title="Hapus Ijin">
                <i class="bi bi-check"></i>
            </button>';
    }

    echo '
        <tr>
            <td class="text-center"><small class="text-muted">'.$no.'</small></td>
            <td><small class="text-muted">'.$nama.'</small></td>
            <td><small class="text-muted">'.$email.'</small></td>
            <td class="text-center"><small class="text-muted">'.$akses.'</small></td>
            <td class="text-center">'.$button_opsi.'</td>
        </tr>';
    $no++;
}
$stmtData->close();
?>

<script>
    var page_count = <?php echo $JmlHalaman; ?>;
    var curent_page = <?php echo $page; ?>;
    
    $('#page_info_pengguna').html(curent_page + ' / ' + page_count);
    
    $('#previous_page_pengguna').prop('disabled', curent_page <= 1);
    $('#next_page_pengguna').prop('disabled', curent_page >= page_count);
</script>