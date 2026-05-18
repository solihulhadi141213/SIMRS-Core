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
                <td colspan="9" class="text-center">
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
    $OrderBy    = trim($_POST['OrderBy'] ?? 'id_praktisi');

    $allowed_order = [
        'id_praktisi',
        'id_practitioner',
        'tipe_praktisi',
        'profesi_praktisi',
        'nama_praktisi',
        'nik_praktisi',
        'id_akses',
        'id_dokter'
    ];

    $allowed_search = $allowed_order;

    $allowed_sort = ['ASC', 'DESC'];

    $batas = in_array($batas, [5,10,25,50,100,250,500]) ? $batas : 10;
    $page  = max(1, $page);

    $OrderBy = in_array($OrderBy, $allowed_order) ? $OrderBy : 'id_praktisi';
    $ShortBy = in_array($ShortBy, $allowed_sort) ? $ShortBy : 'DESC';

    $posisi = ($page - 1) * $batas;

    // =========================================================================
    // WHERE
    // =========================================================================
    $where = " WHERE 1=1 ";
    $params = [];
    $types = '';

    if (!empty($keyword)) {

        $keyword_like = "%$keyword%";

        if (!empty($keyword_by) && in_array($keyword_by, $allowed_search)) {

            $where .= " AND p.$keyword_by LIKE ? ";
            $params[] = $keyword_like;
            $types .= "s";

        } else {

            $where .= " AND (
                p.id_practitioner LIKE ?
                OR p.tipe_praktisi LIKE ?
                OR p.profesi_praktisi LIKE ?
                OR p.nama_praktisi LIKE ?
                OR p.nik_praktisi LIKE ?
            ) ";

            for ($i=0; $i<5; $i++) {
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
        FROM praktisi p
        $where
    ";

    $stmt_count = mysqli_prepare($Conn, $sql_count);

    if (!empty($params)) {
        mysqli_stmt_bind_param($stmt_count, $types, ...$params);
    }

    mysqli_stmt_execute($stmt_count);

    $result_count = mysqli_stmt_get_result($stmt_count);
    $data_count = mysqli_fetch_assoc($result_count);

    $jml_data = (int) ($data_count['total'] ?? 0);

    mysqli_stmt_close($stmt_count);

    // =========================================================================
    // NO DATA
    // =========================================================================
    if ($jml_data == 0) {

        echo '
            <tr data-page-count="0" data-current-page="0">
                <td colspan="9" class="text-center">
                    <small class="text-danger">
                        Tidak ada data praktisi
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
        SELECT
            p.*,
            a.nama as nama_akses,
            a.akses as level_akses,
            d.id_dokter as iddokter,
            d.nama as nama_dokter
        FROM praktisi p
        LEFT JOIN akses a ON p.id_akses = a.id_akses
        LEFT JOIN dokter d ON p.id_dokter = d.id_dokter
        $where
        ORDER BY p.$OrderBy $ShortBy
        LIMIT ?, ?
    ";

    $stmt = mysqli_prepare($Conn, $sql);

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

    // =========================================================================
    // LOOPING
    // =========================================================================
    while ($data = mysqli_fetch_assoc($result)) {

        $id_praktisi       = $data['id_praktisi'];
        $nama_praktisi     = htmlspecialchars($data['nama_praktisi'] ?? '-');
        $tipe_praktisi     = htmlspecialchars($data['tipe_praktisi'] ?? '-');
        $profesi_praktisi  = htmlspecialchars($data['profesi_praktisi'] ?? '-');
        $id_practitioner   = htmlspecialchars($data['id_practitioner'] ?? '-');

        if(empty($data['id_dokter'])){
            $label_dokter = '
                <button type="button" disabled class="btn btn-sm btn-secondary">
                    <i class="bi bi-eye"></i> Detail
                </button>
            ';
        }else{
            $label_dokter = '
                <button type="button" class="btn btn-sm btn-info modal_detail_dokter" data-id="'.$data['id_dokter'].'">
                    <i class="bi bi-eye"></i> Detail
                </button>
            ';
        }

        if(empty($data['id_akses'])){
            $label_akses = '
                <button type="button" disabled class="btn btn-sm btn-secondary">
                    <i class="bi bi-eye"></i> Detail
                </button>
            ';
        }else{
            $label_akses = '
                <button type="button" class="btn btn-sm btn-info modal_detail_akses" data-id="'.$data['id_akses'].'">
                    <i class="bi bi-eye"></i> Detail
                </button>
            ';
        }

        if(!empty($data['nik_praktisi'])){
            $nik_praktisi      = htmlspecialchars($data['nik_praktisi'] ?? '-');
            $nik_praktisi = substr($nik_praktisi, -6);
            $nik_praktisi_mask = "** $nik_praktisi";
        }else{
            $nik_praktisi_mask = "-";
        }

        $nama_praktisi = (mb_strlen($nama_praktisi) > 30)
        ? mb_substr($nama_praktisi, 0, 30) . '...'
        : $nama_praktisi;

        echo '
            <tr data-page-count="'.$JmlHalaman.'" data-current-page="'.$page.'">
                <td class="text-center">
                    <small class="text-muted">'.$no.'</small>
                </td>
                <td>
                    <small>
                        <a href="javascript:void(0);" class="text-primary modal_detail" data-id="'.$id_praktisi.'">
                            '.$nama_praktisi.'
                        </a>
                    </small>
                </td>
                <td><small class="text-muted">'.$tipe_praktisi.'</small></td>
                <td><small class="text-muted">'.$profesi_praktisi.'</small></td>
                <td><small class="text-muted">'.$nik_praktisi_mask.'</small></td>
                <td><small class="text-muted">'.$id_practitioner.'</small></td>
                <td class="text-center">'.$label_dokter.'</td>
                <td class="text-center">'.$label_akses.'</td>
                <td class="text-center icon-btn">
                    <button type="button" class="btn btn-sm btn-floating" data-bs-toggle="dropdown">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow">
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_detail"data-id="'.$id_praktisi.'">
                                <i class="bi bi-info-circle"></i> Detail
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_edit" data-id="'.$id_praktisi.'">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_hapus" data-id="'.$id_praktisi.'">
                                <i class="bi bi-trash"></i> Hapus
                            </a>
                        </li>
                    </ul>
                </td>
            </tr>
        ';

        $no++;
    }

    mysqli_stmt_close($stmt);
?>