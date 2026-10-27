<?php
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "AksesHelper.php";

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

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo '<tr><td colspan="7" class="text-center text-danger">Metode request tidak valid.</td></tr>';
        exit;
    }

    // ===============================
    // INPUT
    // ===============================
    $keyword_by = isset($_POST['keyword_by']) && is_string($_POST['keyword_by']) ? trim($_POST['keyword_by']) : '';
    $keyword = isset($_POST['keyword']) && is_string($_POST['keyword']) ? trim($_POST['keyword']) : '';
    $batas = filter_var($_POST['batas'] ?? 10, FILTER_VALIDATE_INT);
    $page = filter_var($_POST['page'] ?? 1, FILTER_VALIDATE_INT);
    $ShortBy = isset($_POST['ShortBy']) && is_string($_POST['ShortBy']) ? strtoupper($_POST['ShortBy']) : 'DESC';
    $OrderBy = isset($_POST['OrderBy']) && is_string($_POST['OrderBy']) ? $_POST['OrderBy'] : 'id_akses';


    // ===============================
    // VALIDASI
    // ===============================
    $batas = in_array($batas, [5,10,25,50,100,250,500], true) ? $batas : 10;
    $page  = ($page && $page > 0) ? $page : 1;
    $posisi = ($page - 1) * $batas;

    $allowedKeywordColumns = ['nama', 'email', 'id_akses_entitas', 'tanggal', 'updatetime'];
    if (!in_array($keyword_by, $allowedKeywordColumns, true)) {
        $keyword_by = '';
    }

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
    $ShortBy = in_array($ShortBy, ['ASC','DESC'], true) ? $ShortBy : 'DESC';

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
    if (!$stmt_count) {
        error_log('Akses: gagal menyiapkan jumlah data tabel.');
        http_response_code(500);
        echo '<tr><td colspan="7" class="text-center text-danger">Data akses gagal dimuat.</td></tr>';
        exit;
    }

    if (!empty($params)) {
        if (!mysqli_stmt_bind_param($stmt_count, $types, ...$params)) {
            mysqli_stmt_close($stmt_count);
            error_log('Akses: gagal menyiapkan parameter jumlah data.');
            http_response_code(500);
            echo '<tr><td colspan="7" class="text-center text-danger">Data akses gagal dimuat.</td></tr>';
            exit;
        }
    }
    if (!mysqli_stmt_execute($stmt_count)) {
        mysqli_stmt_close($stmt_count);
        error_log('Akses: gagal menghitung data tabel.');
        http_response_code(500);
        echo '<tr><td colspan="7" class="text-center text-danger">Data akses gagal dimuat.</td></tr>';
        exit;
    }
    $result_count = mysqli_stmt_get_result($stmt_count);
    $row_count = mysqli_fetch_assoc($result_count);
    $jml_data = (int) ($row_count['total'] ?? 0);
    mysqli_stmt_close($stmt_count);

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
    if (!$stmt) {
        error_log('Akses: gagal menyiapkan query tabel.');
        http_response_code(500);
        echo '<tr><td colspan="7" class="text-center text-danger">Data akses gagal dimuat.</td></tr>';
        exit;
    }

    // bind dinamis
    if (!empty($params)) {
        $params[] = $posisi;
        $params[] = $batas;
        $types .= "ii";
        if (!mysqli_stmt_bind_param($stmt, $types, ...$params)) {
            mysqli_stmt_close($stmt);
            error_log('Akses: gagal menyiapkan parameter tabel.');
            http_response_code(500);
            echo '<tr><td colspan="7" class="text-center text-danger">Data akses gagal dimuat.</td></tr>';
            exit;
        }
    } else {
        if (!mysqli_stmt_bind_param($stmt, "ii", $posisi, $batas)) {
            mysqli_stmt_close($stmt);
            error_log('Akses: gagal menyiapkan parameter paginasi.');
            http_response_code(500);
            echo '<tr><td colspan="7" class="text-center text-danger">Data akses gagal dimuat.</td></tr>';
            exit;
        }
    }

    if (!mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        error_log('Akses: gagal memuat data tabel.');
        http_response_code(500);
        echo '<tr><td colspan="7" class="text-center text-danger">Data akses gagal dimuat.</td></tr>';
        exit;
    }
    $result = mysqli_stmt_get_result($stmt);

    // ===============================
    // RENDER
    // ===============================
    while ($data = mysqli_fetch_assoc($result)) {

        $id_akses = (int) $data['id_akses'];
        $nama = aksesEscapeHtml($data['nama'] ?? '');
        $email = aksesEscapeHtml($data['email'] ?? '');
        $akses = aksesEscapeHtml($data['nama_akses'] ?? '-');
        $tanggalIso = aksesUtcDateIso($data['tanggal'] ?? null);
        $updatetimeIso = aksesUtcDateIso($data['updatetime'] ?? null);
        $tanggal = $tanggalIso !== ''
            ? '<time class="js-akses-date" datetime="' . aksesEscapeHtml($tanggalIso) . '" data-utc="' . aksesEscapeHtml($tanggalIso) . '">' . aksesEscapeHtml(aksesUtcDateDisplay($data['tanggal'])) . '</time>'
            : '-';
        $updatetime = $updatetimeIso !== ''
            ? '<time class="js-akses-date" datetime="' . aksesEscapeHtml($updatetimeIso) . '" data-utc="' . aksesEscapeHtml($updatetimeIso) . '">' . aksesEscapeHtml(aksesUtcDateDisplay($data['updatetime'])) . '</time>'
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
    mysqli_stmt_close($stmt);
?>

<script>
    var page_count = <?php echo $JmlHalaman; ?>;
    var curent_page = <?php echo $page; ?>;

    $('#page_info').html(curent_page + ' / ' + page_count);
    $('#previous_page').prop('disabled', curent_page == 1);
    $('#next_page').prop('disabled', curent_page >= page_count);
</script>
