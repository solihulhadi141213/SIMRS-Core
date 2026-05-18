<?php
    date_default_timezone_set('Asia/Jakarta');

    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // =========================================================================
    // VALIDASI SESSION
    // =========================================================================
    if (empty($SessionIdAkses)) {

        echo '
            <tr data-page-count="0" data-current-page="0">
                <td colspan="6" class="text-center">
                    <small class="text-danger">
                        Sesi akses berakhir, silakan login ulang.
                    </small>
                </td>
            </tr>
        ';

        exit;
    }

    // =========================================================================
    // FILTER
    // =========================================================================
    $keyword_by = trim($_POST['keyword_by'] ?? '');
    $keyword    = trim($_POST['keyword'] ?? '');
    $batas      = (int) ($_POST['batas'] ?? 10);
    $page       = (int) ($_POST['page'] ?? 1);
    $ShortBy    = strtoupper(trim($_POST['ShortBy'] ?? 'DESC'));
    $OrderBy    = trim($_POST['OrderBy'] ?? 'id_akses');

    // =========================================================================
    // VALIDASI
    // =========================================================================
    $allowed_order = [
        'id_akses',
        'nama',
        'nik',
        'email',
        'kontak',
        'akses'
    ];

    $allowed_search = $allowed_order;

    $allowed_sort = ['ASC', 'DESC'];

    $batas = in_array($batas, [5,10,25,50,100,250,500]) ? $batas : 10;

    $page = max(1, $page);

    $OrderBy = in_array($OrderBy, $allowed_order)
        ? $OrderBy
        : 'id_akses';

    $ShortBy = in_array($ShortBy, $allowed_sort)
        ? $ShortBy
        : 'DESC';

    $posisi = ($page - 1) * $batas;

    // =========================================================================
    // WHERE
    // =========================================================================
    $where = " WHERE 1=1 ";

    $params = [];
    $types  = '';

    if (!empty($keyword)) {

        $keyword_like = "%$keyword%";

        // =========================================================
        // SEARCH SPESIFIK
        // =========================================================
        if (!empty($keyword_by) && in_array($keyword_by, $allowed_search)) {

            $where .= " AND $keyword_by LIKE ? ";

            $params[] = $keyword_like;
            $types .= "s";

        } else {

            // =====================================================
            // SEARCH GLOBAL
            // =====================================================
            $where .= "
                AND (
                    CAST(id_akses AS CHAR) LIKE ?
                    OR nama LIKE ?
                    OR nik LIKE ?
                    OR email LIKE ?
                    OR kontak LIKE ?
                    OR akses LIKE ?
                )
            ";

            for ($i = 0; $i < 6; $i++) {

                $params[] = $keyword_like;
                $types .= "s";
            }
        }
    }

    // =========================================================================
    // COUNT DATA
    // =========================================================================
    $sql_count = "
        SELECT COUNT(*) as total
        FROM akses
        $where
    ";

    $stmt_count = mysqli_prepare($Conn, $sql_count);

    if (!$stmt_count) {

        echo '
            <tr data-page-count="0" data-current-page="0">
                <td colspan="6" class="text-center">
                    <small class="text-danger">
                        Gagal prepare query count.
                    </small>
                </td>
            </tr>
        ';

        exit;
    }

    if (!empty($params)) {

        mysqli_stmt_bind_param(
            $stmt_count,
            $types,
            ...array_values($params)
        );
    }

    mysqli_stmt_execute($stmt_count);

    $result_count = mysqli_stmt_get_result($stmt_count);

    $data_count = mysqli_fetch_assoc($result_count);

    $jml_data = (int) ($data_count['total'] ?? 0);

    mysqli_stmt_close($stmt_count);

    // =========================================================================
    // NO DATA
    // =========================================================================
    if ($jml_data <= 0) {

        echo '
            <tr data-page-count="0" data-current-page="0">
                <td colspan="6" class="text-center">
                    <small class="text-danger">
                        Tidak ada data akses
                    </small>
                </td>
            </tr>
        ';

        exit;
    }

    // =========================================================================
    // PAGING
    // =========================================================================
    $JmlHalaman = ceil($jml_data / $batas);

    if ($page > $JmlHalaman) {

        $page = $JmlHalaman;

        $posisi = ($page - 1) * $batas;
    }

    $no = $posisi + 1;

    // =========================================================================
    // QUERY DATA
    // =========================================================================
    $sql = "
        SELECT *
        FROM akses
        $where
        ORDER BY $OrderBy $ShortBy
        LIMIT ?, ?
    ";

    $stmt = mysqli_prepare($Conn, $sql);

    if (!$stmt) {

        echo '
            <tr data-page-count="0" data-current-page="0">
                <td colspan="6" class="text-center">
                    <small class="text-danger">
                        Gagal prepare query data.
                    </small>
                </td>
            </tr>
        ';

        exit;
    }

    // =========================================================================
    // BIND PARAMETER
    // =========================================================================
    if (!empty($params)) {

        $bindParams = $params;

        $bindParams[] = $posisi;
        $bindParams[] = $batas;

        $bindTypes = $types . "ii";

        mysqli_stmt_bind_param(
            $stmt,
            $bindTypes,
            ...array_values($bindParams)
        );

    } else {

        mysqli_stmt_bind_param($stmt, "ii", $posisi, $batas);
    }

    // =========================================================================
    // EXECUTE
    // =========================================================================
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    // =========================================================================
    // LOOPING
    // =========================================================================
    while ($data = mysqli_fetch_assoc($result)) {
        $id_akses = (int) ($data['id_akses'] ?? 0);
        $ihs = htmlspecialchars($data['ihs'] ?? '');
        $nama = htmlspecialchars($data['nama'] ?? '-');
        $nik = htmlspecialchars($data['nik'] ?? '-');
        $email = htmlspecialchars($data['email'] ?? '-');
        $kontak = htmlspecialchars($data['kontak'] ?? '-');
        $akses = htmlspecialchars($data['akses'] ?? '-');
        if(empty($data['nik'])){$nik = "-";}
        if(empty($data['email'])){$email = "-";}
        if(empty($data['kontak'])){$kontak = "-";}
        echo '
            <tr 
            class="modal_tambah_by_akses" 
            data-id_akses="'.$id_akses.'" 
            data-ihs="'.$data['ihs'].'" 
            data-nama="'.$data['nama'].'" 
            data-nik="'.$data['nik'].'" 
            data-email="'.$data['email'].'" 
            data-kontak="'.$data['kontak'].'" 
            data-akses="'.$data['akses'].'" 
            data-page-count="'.$JmlHalaman.'" 
            data-current-page="'.$page.'" 
            style="cursor:pointer;">
                <td class="text-center"><small class="text-muted">'.$no.'</small></td>
                <td><small class="text-muted">'.$nama.'</small></td>
                <td><small class="text-muted">'.$nik.'</small></td>
                <td><small class="text-muted">'.$email.'</small></td>
                <td><small class="text-muted">'.$kontak.'</small></td>
                <td><small class="text-muted">'.$akses.'</small></td>
            </tr>
        ';
        $no++;
    }

    mysqli_stmt_close($stmt);
?>