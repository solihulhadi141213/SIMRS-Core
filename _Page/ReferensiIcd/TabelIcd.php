<?php
    // Connection, Function dan session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // Potong Karakter
    function limitText($text, $limit = 50) {
        $text = trim($text);

        if (mb_strlen($text) <= $limit) {
            return $text;
        }

        return mb_substr($text, 0, $limit) . '...';
    }

    // Default Time Zone
    date_default_timezone_set("Asia/Jakarta");

    // ===================== VALIDASI AKSES =====================
    if (empty($SessionIdAkses)) {
        echo '
            <tr data-page-count="0" data-current-page="0">
                <td align="center" colspan="6">
                    <small class="text-danger">Sesi Akses Berakhir! Silahkan Login Ulang!</small>
                </td>
            </tr>
        ';
        exit;
    }

    // ===================== VALIDASI INPUT =====================
    if (empty($_POST['icd_version'])) {
        echo '
            <tr data-page-count="0" data-current-page="0">
                <td align="center" colspan="6">
                    <small class="text-danger">Versi ICD Tidak Boleh Kosong!</small>
                </td>
            </tr>
        ';
        exit;
    }

    $icd_version = $_POST['icd_version'];

    // ===================== FILTER =====================
    $keyword     = $_POST['keyword'] ?? '';
    $keyword     = trim($keyword);

    $batas       = (int)($_POST['batas'] ?? 10);
    $page        = (int)($_POST['page'] ?? 1);
    $posisi      = ($page - 1) * $batas;

    // ===================== VALIDASI ORDER =====================
    $allowedOrder = ['kode','long_des','short_des','id_icd'];
    $allowedSort  = ['ASC','DESC'];

    $OrderBy = in_array($_POST['OrderBy'] ?? '', $allowedOrder) 
        ? $_POST['OrderBy'] 
        : 'id_icd';

    $ShortBy = in_array($_POST['ShortBy'] ?? '', $allowedSort) 
        ? $_POST['ShortBy'] 
        : 'DESC';

    // ===================== VALIDASI KEYWORD BY =====================
    $allowedKeyword = ['kode','long_des','short_des'];

    $keyword_by = in_array($_POST['keyword_by'] ?? '', $allowedKeyword) 
        ? $_POST['keyword_by'] 
        : '';

    // ===================== BUILD WHERE =====================
    $where  = "WHERE icd = ?";
    $params = [$icd_version];
    $types  = "s";

    if (!empty($keyword)) {
        if (!empty($keyword_by)) {
            $where .= " AND $keyword_by LIKE ?";
            $params[] = "%$keyword%";
            $types .= "s";
        } else {
            $where .= " AND (kode LIKE ? OR long_des LIKE ? OR short_des LIKE ?)";
            $params[] = "%$keyword%";
            $params[] = "%$keyword%";
            $params[] = "%$keyword%";
            $types .= "sss";
        }
    }

    // ===================== HITUNG TOTAL DATA =====================
    $sql_count = "SELECT COUNT(*) as total FROM icd $where";
    $stmt = mysqli_prepare($Conn, $sql_count);
    mysqli_stmt_bind_param($stmt, $types, ...$params);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    $jml_data = $row['total'] ?? 0;

    if ($jml_data == 0) {
        echo '
            <tr data-page-count="0" data-current-page="0">
                <td align="center" colspan="6">
                    <small class="text-danger">Data Tidak Ditemukan!</small>
                </td>
            </tr>
        ';
        exit;
    }

    // ===================== PAGINATION =====================
    $JmlHalaman = ceil($jml_data / $batas);
    $no = 1 + $posisi;

    // ===================== QUERY DATA =====================
    $sql = "SELECT * FROM icd $where ORDER BY $OrderBy $ShortBy LIMIT ?, ?";
    $stmt = mysqli_prepare($Conn, $sql);

    // tambah limit ke parameter
    $params_query = $params;
    $params_query[] = $posisi;
    $params_query[] = $batas;

    $types_query = $types . "ii";

    mysqli_stmt_bind_param($stmt, $types_query, ...$params_query);
    mysqli_stmt_execute($stmt);
    $query = mysqli_stmt_get_result($stmt);

    // ===================== OUTPUT =====================
    $first = true;

    while ($data = mysqli_fetch_assoc($query)) {

        $id_icd    = $data['id_icd'];
        $kode      = htmlspecialchars($data['kode']);
        $long_des  = htmlspecialchars(limitText($data['long_des'], 60));
        $short_des = htmlspecialchars(limitText($data['short_des'], 60));
        $icd       = htmlspecialchars($data['icd']);

        // hanya baris pertama yang bawa info pagination
        $attr = '';
        if ($first) {
            $attr = 'data-page-count="'.$JmlHalaman.'" data-current-page="'.$page.'"';
            $first = false;
        }

        echo '
            <tr '.$attr.'>
                <td align="center"><small class="text-muted">'.$no.'</small></td>
                <td align="center"><small class="text-muted">'.$icd.'</small></td>
                <td align="left"><small class="text-muted">'.$kode.'</small></td>
                <td align="left">
                    <a href="javascript:void(0)" class="modal_detail text-decoration-underline" data-id="'.$id_icd.'">
                        <small class="text-muted">'.$short_des.'</small>
                    </a>
                </td>
                <td align="left">
                    <a href="javascript:void(0)" class="modal_detail text-decoration-underline" data-id="'.$id_icd.'">
                        <small class="text-muted">'.$long_des.'</small>
                    </a>
                </td>
                <td class="icon-btn">
                    <button type="button" class="btn btn-sm btn-outline-dark btn-floating" data-bs-toggle="dropdown">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <li class="dropdown-header text-start">
                            <h6>Option</h6>
                        </li>
                        <li>
                            <a class="dropdown-item modal_detail" href="javascript:void(0)" data-bs-toggle="modal" data-id="'.$id_icd.'">
                                <i class="bi bi-info-circle"></i> Detail
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item modal_edit" href="javascript:void(0)" data-bs-toggle="modal" data-id="'.$id_icd.'">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item modal_delete" href="javascript:void(0)" data-bs-toggle="modal" data-id="'.$id_icd.'">
                                <i class="bi bi-x"></i> Hapus
                            </a>
                        </li>
                    </ul>
                </td>
            </tr>
        ';

        $no++;
    }

    // ===================== CLEANUP =====================
    mysqli_stmt_close($stmt);
?>