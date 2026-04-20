<?php
date_default_timezone_set('Asia/Jakarta');

include "../../_Config/Connection.php";
include "../../_Config/SimrsFunction.php";
include "../../_Config/Session.php";

// ===============================
// VALIDASI SESSION
// ===============================
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

// Default
$JmlHalaman = 0;

// ===============================
// INPUT
// ===============================
$keyword_by = $_POST['keyword_by'] ?? '';
$keyword    = $_POST['keyword'] ?? '';
$batas      = (int) ($_POST['batas'] ?? 10);
$page       = (int) ($_POST['page'] ?? 1);
$ShortBy    = strtoupper($_POST['ShortBy'] ?? 'DESC');
$OrderBy    = $_POST['OrderBy'] ?? 'id_akses_laporan';

// ===============================
// VALIDASI
// ===============================
$batas = in_array($batas, [5,10,25,50,100,250,500]) ? $batas : 10;
$page  = ($page > 0) ? $page : 1;
$posisi = ($page - 1) * $batas;

// mapping order
$order_map = [
    'id_akses_laporan' => 'a.id_akses_laporan',
    'id_akses'         => 'a.id_akses',
    'tanggal'          => 'a.tanggal',
    'judul'            => 'a.judul',
    'status'           => 'a.status'
];
$OrderBy = $order_map[$OrderBy] ?? 'a.id_akses_laporan';

$ShortBy = in_array($ShortBy, ['ASC','DESC']) ? $ShortBy : 'DESC';

// ===============================
// WHERE
// ===============================
$where = "";
$params = [];
$types = "";

if (!empty($keyword)) {

    if ($keyword_by === 'id_akses') {
        $where = " WHERE a.id_akses LIKE ?";
        $params[] = "%$keyword%";
        $types .= "s";

    } elseif ($keyword_by === 'judul') {
        $where = " WHERE a.judul LIKE ?";
        $params[] = "%$keyword%";
        $types .= "s";

    } elseif ($keyword_by === 'tanggal') {
        $where = " WHERE DATE(a.tanggal) = ?";
        $params[] = $keyword;
        $types .= "s";

    } elseif ($keyword_by === 'status') {
        $where = " WHERE a.status LIKE ?";
        $params[] = "%$keyword%";
        $types .= "s";

    } elseif ($keyword_by === 'nama') {
        $where = " WHERE b.nama LIKE ?";
        $params[] = "%$keyword%";
        $types .= "s";

    } else {
        $where = " WHERE 
            a.id_akses LIKE ? OR 
            a.judul LIKE ? OR 
            a.tanggal LIKE ? OR 
            a.status LIKE ? OR
            b.nama LIKE ?";

        $params = ["%$keyword%", "%$keyword%", "%$keyword%", "%$keyword%", "%$keyword%"];
        $types = "sssss";
    }
}

// ===============================
// COUNT
// ===============================
$sql_count = "SELECT COUNT(*) as total 
              FROM akses_laporan a
              LEFT JOIN akses b ON a.id_akses = b.id_akses
              $where";

$stmt_count = mysqli_prepare($Conn, $sql_count);

if (!empty($params)) {
    mysqli_stmt_bind_param($stmt_count, $types, ...$params);
}

mysqli_stmt_execute($stmt_count);
$result_count = mysqli_stmt_get_result($stmt_count);
$row_count = mysqli_fetch_assoc($result_count);
$jml_data = $row_count['total'];

if ($jml_data == 0) {

    $JmlHalaman = 0;
    $page = 0;

    echo '
        <tr>
            <td colspan="6" class="text-center">
                <small class="text-danger">Data Tidak Ditemukan</small>
            </td>
        </tr>
    ';

}else{

    $JmlHalaman = ceil($jml_data / $batas);
    $no = 1 + $posisi;

    // ===============================
    // QUERY DATA
    // ===============================
    $sql = "SELECT a.*, b.nama 
            FROM akses_laporan a
            LEFT JOIN akses b ON a.id_akses = b.id_akses
            $where 
            ORDER BY $OrderBy $ShortBy 
            LIMIT ?, ?";

    $stmt = mysqli_prepare($Conn, $sql);

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
    // RENDER
    // ===============================
    while ($data = mysqli_fetch_assoc($result)) {

        $id_akses_laporan = $data['id_akses_laporan'];
        $id_akses = htmlspecialchars($data['id_akses'] ?? '');
        $nama = htmlspecialchars($data['nama'] ?? '');
        $judul = htmlspecialchars($data['judul'] ?? '');
        $tanggal = date('d/m/Y H:i', strtotime($data['tanggal']));
        $status = htmlspecialchars($data['status'] ?? '');

        // Label Status
        if($status=="Terkirim"){
            $label_status = '<span class="py-1 px-2 bg-danger-subtle btn-outline-danger rounded-2"><small>Terkirim</small></span>';
        }else{
            if($status=="Dibaca"){
                $label_status = '<span class="py-1 px-2 bg-warning-subtle btn-outline-warning rounded-2"><small>Dibaca</small></span>';
            }else{
                if($status=="Selesai"){
                    $label_status = '<span class="py-1 px-2 bg-success-subtle btn-outline-success rounded-2"><small>Selesai</small></span>';
                }else{
                    if($status=="Draft"){
                        $label_status = '<span class="py-1 px-2 bg-secondary-subtle btn-secondary-success text-white rounded-2"><small>Draft</small></span>';
                    }else{
                        $label_status = '<span class="py-1 px-2 bg-dark rounded-2"><small>None</small></span>';
                    }
                }
            }
        }

        // Tombol Opsi Lanjutan
        $tombol_opsi_lanjutan = "";
        if($status=="Terkirim"){

            // Apabila Terkirim Maka Opsi Tandai Sudah Dibaca + Kirim Response
            $tombol_opsi_lanjutan = '
                <li>
                    <a href="javascript:void(0);" class="dropdown-item modal_tandai_baca" data-id="'.$id_akses_laporan.'">
                        <i class="bi bi-eye"></i> Tandai Dibaca
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0);" class="dropdown-item modal_response" data-id="'.$id_akses_laporan.'">
                        <i class="bi bi-send"></i> Kirim Response
                    </a>
                </li>
            ';
        }else{

            // Apabila Dibaca Maka Opsi Kirim Response
            if($status=="Dibaca"){
                $tombol_opsi_lanjutan = '
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item modal_response" data-id="'.$id_akses_laporan.'">
                            <i class="bi bi-send"></i> Kirim Response
                        </a>
                    </li>
                ';
            }else{
                $tombol_opsi_lanjutan = "";
            }
        }

        echo "
            <tr>
                <td class='text-center'><small class='text-muted'>{$no}</small></td>
                <td class='text-left'><small class='text-muted'>{$nama}</small></td>
                <td><small class='text-muted'>{$tanggal}</small></td>
                <td>
                    <a href='javascript:void(0);' class='text-primary modal_detail' data-id='{$id_akses_laporan}'>
                        <small>{$judul}</small>
                    </a>
                </td>
                <td class='text-center'>{$label_status}</td>
                <td class='text-center'>
                    <a href='javascript:void(0);' class='btn-floating btn-sm' data-bs-toggle='dropdown'>
                        <i class='bi bi-three-dots-vertical'></i>
                    </a>
                    <ul class='dropdown-menu shadow'>
                        <li>
                            <a href='javascript:void(0);' class='dropdown-item modal_detail' data-id='{$id_akses_laporan}'>
                                <i class='bi bi-info-circle'></i> Detail
                            </a>
                        </li>
                        {$tombol_opsi_lanjutan}
                        <li>
                            <a href='javascript:void(0);' class='dropdown-item modal_hapus' data-id='{$id_akses_laporan}'>
                                <i class='bi bi-trash'></i> Hapus
                            </a>
                        </li>
                    </ul>
                </td>
            </tr>
        ";

        $no++;
    }
}
?>

<script>
var keyword = '<?php echo $keyword; ?>';
var keyword_by = '<?php echo $keyword_by; ?>';
var page_count = <?php echo isset($JmlHalaman) ? $JmlHalaman : 0; ?>;
var curent_page = <?php echo $page; ?>;

$('#page_info').html(curent_page + ' / ' + page_count);
$('#previous_page').prop('disabled', curent_page == 1 || curent_page == 0);
$('#next_page').prop('disabled', curent_page >= page_count);

// Reset highlight
$('.stat-card').removeClass('bg-secondary-subtle');

if (keyword_by === 'status') {
    if (keyword === 'Terkirim') {
        $('#jumlah_terkirim').closest('.stat-card').addClass('bg-secondary-subtle');
    }
    if (keyword === 'Dibaca') {
        $('#jumlah_dibaca').closest('.stat-card').addClass('bg-secondary-subtle');
    }
    if (keyword === 'Selesai') {
        $('#jumlah_selesai').closest('.stat-card').addClass('bg-secondary-subtle');
    }
    if (keyword === '') {
        $('#jumlah_total').closest('.stat-card').addClass('bg-secondary-subtle');
    }
}
</script>