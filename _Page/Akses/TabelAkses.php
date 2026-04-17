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
                <td align="center" colspan="7">
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
    // INPUT
    // ===============================
    $keyword_by = $_POST['keyword_by'] ?? '';
    $keyword    = $_POST['keyword'] ?? '';
    $batas      = (int) ($_POST['batas'] ?? 10);
    $page       = (int) ($_POST['page'] ?? 1);
    $ShortBy    = strtoupper($_POST['ShortBy'] ?? 'DESC');
    $OrderBy    = $_POST['OrderBy'] ?? 'id_akses';


    // ===============================
    // VALIDASI
    // ===============================
    $batas = in_array($batas, [5,10,25,50,100,250,500]) ? $batas : 10;
    $page  = ($page > 0) ? $page : 1;
    $posisi = ($page - 1) * $batas;

    // 🔥 Mapping OrderBy (frontend → database)
    $order_map = [
        'id_akses'          => 'a.id_akses',
        'nama'              => 'a.nama',
        'email'             => 'a.email',
        'id_akses_entitas'  => 'ae.akses',
        'tanggal'           => 'a.tanggal',
        'updatetime'        => 'a.updatetime'
    ];

    $OrderBy = $order_map[$OrderBy] ?? 'a.id_akses';

    // validasi sort
    $ShortBy = in_array($ShortBy, ['ASC','DESC']) ? $ShortBy : 'DESC';

    // ===============================
    // WHERE
    // ===============================
    $where = "";
    $params = [];
    $types = "";

    if (!empty($keyword)) {

        if ($keyword_by === 'nama') {
            $where = " WHERE a.nama LIKE ?";
            $params[] = "%$keyword%";
            $types .= "s";

        } elseif ($keyword_by === 'email') {
            $where = " WHERE a.email LIKE ?";
            $params[] = "%$keyword%";
            $types .= "s";

        } elseif ($keyword_by === 'id_akses_entitas') {
            // 🔥 FIX: filter entitas (exact match, bukan LIKE)
            $where = " WHERE a.id_akses_entitas = ?";
            $params[] = $keyword;
            $types .= "s";

        } elseif ($keyword_by === 'tanggal') {
            $where = " WHERE DATE(a.tanggal) = ?";
            $params[] = $keyword;
            $types .= "s";

        } elseif ($keyword_by === 'updatetime') {
            $where = " WHERE DATE(a.updatetime) = ?";
            $params[] = $keyword;
            $types .= "s";

        } else {
            // fallback search
            $where = " WHERE a.nama LIKE ? OR a.email LIKE ?";
            $params = ["%$keyword%", "%$keyword%"];
            $types = "ss";
        }
    }

    // ===============================
    // COUNT
    // ===============================
    $sql_count = "
        SELECT COUNT(*) as total
        FROM akses a
        LEFT JOIN akses_entitas ae ON a.id_akses_entitas = ae.id_akses_entitas
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
                <td colspan="7" class="text-center">
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
    // QUERY DATA (JOIN FIX N+1)
    // ===============================
    $sql = "
        SELECT 
            a.*,
            ae.akses as nama_akses
        FROM akses a
        LEFT JOIN akses_entitas ae 
            ON a.id_akses_entitas = ae.id_akses_entitas
        $where
        ORDER BY $OrderBy $ShortBy
        LIMIT ?, ?
    ";

    $stmt = mysqli_prepare($Conn, $sql);

    // bind dinamis
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

        $id_akses   = $data['id_akses'];
        $nama       = htmlspecialchars($data['nama'] ?? '');
        $email      = htmlspecialchars($data['email'] ?? '');
        $akses      = htmlspecialchars($data['nama_akses'] ?? '-');

        $tanggal = !empty($data['tanggal']) 
            ? date('d/m/Y H:i', strtotime($data['tanggal'])) 
            : '-';

        $updatetime = !empty($data['updatetime']) 
            ? date('d/m/Y H:i', strtotime($data['updatetime'])) 
            : '-';

        echo "
        <tr>
            <td class='text-center'><small class='text-muted'>{$no}</small></td>
            <td>
                <a href='javascript:void(0);' class='text-decoration-underline text-primary modal_detail' data-id='{$id_akses}'>
                    <small>{$nama}</small>
                </a>
            </td>
            <td><small class='text-muted'>{$email}</small></td>
            <td class='text-center'><small class='text-muted'>{$akses}</small></td>
            <td><small class='text-muted'>{$tanggal}</small></td>
            <td><small class='text-muted'>{$updatetime}</small></td>
            <td class='text-center'>
                <a href='javascript:void(0);' class='btn-floating btn-sm' data-bs-toggle='dropdown'>
                    <i class='bi bi-three-dots-vertical'></i>
                </a>
                <ul class='dropdown-menu shadow'>
                    <li>
                        <a href='javascript:void(0);' class='dropdown-item modal_detail' data-id='{$id_akses}'>
                            <i class='bi bi-info-circle'></i> Detail
                        </a>
                    </li>
                    <li>
                        <a href='javascript:void(0);' class='dropdown-item modal_edit' data-id='{$id_akses}'>
                            <i class='bi bi-pencil'></i> Edit
                        </a>
                    </li>
                    <li>
                        <a href='javascript:void(0);' class='dropdown-item modal_ijin_akses' data-id='{$id_akses}'>
                            <i class='bi bi-list-check'></i> Ijin Akses
                        </a>
                    </li>
                    <li>
                        <a href='javascript:void(0);' class='dropdown-item modal_hapus' data-id='{$id_akses}'>
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