<?php
    include "../../_Config/Connection.php";

    // ================== PARAMETER ==================
    $page       = isset($_POST['page']) ? (int)$_POST['page'] : 1;
    $batas      = isset($_POST['batas']) ? (int)$_POST['batas'] : 10;
    $OrderBy    = $_POST['OrderBy'] ?? '';
    $ShortBy    = $_POST['ShortBy'] ?? 'DESC';
    $keyword_by = $_POST['keyword_by'] ?? '';
    $keyword    = $_POST['keyword'] ?? '';

    $page   = ($page < 1) ? 1 : $page;
    $batas  = ($batas < 1) ? 10 : $batas;
    $offset = ($page - 1) * $batas;

    // ================== VALIDASI ORDER ==================
    $allowedOrder = ['province', 'regency', 'subdistrict', 'village'];
    $OrderBy = in_array($OrderBy, $allowedOrder) ? $OrderBy : 'id_wilayah';

    $ShortBy = strtoupper($ShortBy) === 'ASC' ? 'ASC' : 'DESC';

    // ================== FILTER ==================
    $where = "WHERE 1=1";
    $params = [];
    $types  = "";

    if (!empty($keyword) && !empty($keyword_by) && in_array($keyword_by, $allowedOrder)) {
        $where .= " AND $keyword_by LIKE ?";
        $params[] = "%$keyword%";
        $types .= "s";
    }

    // ================== HITUNG TOTAL ==================
    $countQuery = "SELECT COUNT(*) as total FROM wilayah $where";
    $stmtCount = $Conn->prepare($countQuery);

    if (!empty($params)) {
        $stmtCount->bind_param($types, ...$params);
    }

    $stmtCount->execute();
    $totalData = $stmtCount->get_result()->fetch_assoc()['total'];

    $pageCount = ($totalData > 0) ? ceil($totalData / $batas) : 0;

    // ================== QUERY DATA ==================
    $query = "
        SELECT *
        FROM wilayah
        $where
        ORDER BY $OrderBy $ShortBy
        LIMIT ?, ?
    ";

    $stmt = $Conn->prepare($query);

    // gabungkan parameter
    $paramsData = $params;
    $typesData  = $types;

    $paramsData[] = $offset;
    $paramsData[] = $batas;
    $typesData   .= "ii";

    $stmt->bind_param($typesData, ...$paramsData);
    $stmt->execute();
    $result = $stmt->get_result();

    // ================== OUTPUT ==================
    $no = $offset + 1;

    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {

            echo '
            <tr data-page-count="'.$pageCount.'" data-current-page="'.$page.'">
                <td align="center"><small class="text-muted">'.$no.'</small></td>
                <td align="left">
                    <small class="text-primary" data-bs-toggle="dropdown">
                        <a href="javascript:void(0);" class="text-primary">
                            '.$row['kode_mendagri_1'].' | '.$row['province'].'
                        </a>
                    </small>
                   <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <li>
                            <a class="dropdown-item modal_edit_provinsi" href="javascript:void(0)" data-bs-toggle="modal" data-id="'.$row['id_wilayah'].'">
                                <i class="bi bi-pencil"></i> Edit Provinsi
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item modal_hapus_provinsi" href="javascript:void(0)" data-bs-toggle="modal" data-id="'.$row['id_wilayah'].'">
                                <i class="bi bi-x"></i> Hapus Provinsi
                            </a>
                        </li>
                    </ul>
                </td>
                <td><small class="text-muted">'.$row['tipe_level2'].'</small></td>
                <td align="left">
                    <small class="text-info" data-bs-toggle="dropdown">
                        <a href="javascript:void(0);" class="text-info">
                            '.$row['kode_mendagri_2'].' | '.$row['regency'].'
                        </a>
                   </small>
                   <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <li>
                            <a class="dropdown-item modal_edit_kabupaten" href="javascript:void(0)" data-bs-toggle="modal" data-id="'.$row['id_wilayah'].'">
                                <i class="bi bi-pencil"></i> Edit Kabupatan/Kota
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item modal_hapus_kabupaten" href="javascript:void(0)" data-bs-toggle="modal" data-id="'.$row['id_wilayah'].'">
                                <i class="bi bi-x"></i> Hapus Kabupatan/Kota
                            </a>
                        </li>
                    </ul>
                </td>
                <td align="left">
                    <small class="text-warning" data-bs-toggle="dropdown">
                        <a href="javascript:void(0);" class="text-warning">
                            '.$row['kode_mendagri_3'].' | '.$row['subdistrict'].'
                        </a>
                   </small>
                   <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <li>
                            <a class="dropdown-item modal_edit_kecamatan" href="javascript:void(0)" data-bs-toggle="modal" data-id="'.$row['id_wilayah'].'">
                                <i class="bi bi-pencil"></i> Edit Kecamatan
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item modal_hapus_kecamatan" href="javascript:void(0)" data-bs-toggle="modal" data-id="'.$row['id_wilayah'].'">
                                <i class="bi bi-x"></i> Hapus Kecamatan
                            </a>
                        </li>
                    </ul>
                </td>
                <td><small class="text-muted">'.$row['tipe_level4'].'</small></td>
                <td align="left">
                    <small class="text-dark" data-bs-toggle="dropdown">
                        <a href="javascript:void(0);" class="text-dark">
                            '.$row['kode_mendagri_4'].' | '.$row['village'].'
                        </a>
                   </small>
                   <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <li>
                            <a class="dropdown-item modal_edit_desa" href="javascript:void(0)" data-bs-toggle="modal" data-id="'.$row['id_wilayah'].'">
                                <i class="bi bi-pencil"></i> Edit Desa/Kelurahan
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item modal_hapus_desa" href="javascript:void(0)" data-bs-toggle="modal" data-id="'.$row['id_wilayah'].'">
                                <i class="bi bi-x"></i> Hapus Desa/Kelurahan
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
            <td colspan="7" align="center">
                <small class="text-muted">Tidak ada data</small>
            </td>
        </tr>
        ';
    }