<?php
    date_default_timezone_set('Asia/Jakarta');

    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    if (empty($SessionIdAkses)) {
        echo '
            <tr data-page-count="0" data-current-page="0">
                <td align="center" colspan="8">
                    <small class="text-danger">Sesi akses berakhir! Silakan login ulang!</small>
                </td>
            </tr>
        ';
        exit;
    }

    $keyword_by = trim($_POST['keyword_by'] ?? '');
    $keyword    = trim($_POST['keyword'] ?? '');
    $batas      = (int) ($_POST['batas'] ?? 10);
    $page       = (int) ($_POST['page'] ?? 1);
    $ShortBy    = strtoupper(trim($_POST['ShortBy'] ?? 'DESC'));
    $OrderBy    = trim($_POST['OrderBy'] ?? 'id_poliklinik');

    $batas = in_array($batas, [5, 10, 25, 50, 100, 250, 500]) ? $batas : 10;
    $page  = max(1, $page);
    $posisi = ($page - 1) * $batas;

    $allowed_order = ['id_poliklinik', 'poliklinik', 'kode', 'status', 'updatetime'];
    $allowed_sort  = ['ASC', 'DESC'];
    $allowed_search = ['poliklinik', 'kode', 'status', 'updatetime'];

    $OrderBy = in_array($OrderBy, $allowed_order) ? $OrderBy : 'id_poliklinik';
    $ShortBy = in_array($ShortBy, $allowed_sort) ? $ShortBy : 'DESC';

    $where = "";
    $params = [];
    $types = "";

    if ($keyword !== '') {
        $keyword_like = "%" . $keyword . "%";

        if ($keyword_by !== '' && in_array($keyword_by, $allowed_search)) {
            if ($keyword_by === 'status') {
                $keyword_lower = strtolower($keyword);
                if (in_array($keyword_lower, ['1', 'aktif', 'active', 'ya', 'yes'])) {
                    $where = " WHERE p.status = ?";
                    $params[] = 1;
                    $types .= "i";
                } elseif (in_array($keyword_lower, ['0', 'tidak aktif', 'nonaktif', 'inactive', 'tidak', 'no'])) {
                    $where = " WHERE p.status = ?";
                    $params[] = 0;
                    $types .= "i";
                } else {
                    $where = " WHERE p.status LIKE ?";
                    $params[] = $keyword_like;
                    $types .= "s";
                }
            } else {
                $where = " WHERE p.$keyword_by LIKE ?";
                $params[] = $keyword_like;
                $types .= "s";
            }
        } else {
            $where = " WHERE (
                p.poliklinik LIKE ?
                OR p.kode LIKE ?
                OR p.updatetime LIKE ?
                OR CASE
                    WHEN p.status = 1 THEN 'Aktif'
                    ELSE 'Tidak Aktif'
                  END LIKE ?
            )";
            $params[] = $keyword_like;
            $params[] = $keyword_like;
            $params[] = $keyword_like;
            $params[] = $keyword_like;
            $types .= "ssss";
        }
    }

    $sql_count = "
        SELECT COUNT(*) AS total
        FROM poliklinik p
        $where
    ";

    $stmt_count = mysqli_prepare($Conn, $sql_count);

    if (!$stmt_count) {
        echo '
            <tr data-page-count="0" data-current-page="0">
                <td align="center" colspan="8">
                    <small class="text-danger">Gagal menyiapkan query hitung data.</small>
                </td>
            </tr>
        ';
        exit;
    }

    if (!empty($params)) {
        mysqli_stmt_bind_param($stmt_count, $types, ...$params);
    }

    mysqli_stmt_execute($stmt_count);
    $result_count = mysqli_stmt_get_result($stmt_count);
    $row_count = mysqli_fetch_assoc($result_count);
    $jml_data = (int) ($row_count['total'] ?? 0);
    mysqli_stmt_close($stmt_count);

    if ($jml_data === 0) {
        echo '
            <tr data-page-count="0" data-current-page="0">
                <td align="center" colspan="8">
                    <small class="text-danger">Data poliklinik tidak ditemukan</small>
                </td>
            </tr>
        ';
        exit;
    }

    $JmlHalaman = (int) ceil($jml_data / $batas);
    if ($page > $JmlHalaman) {
        $page = $JmlHalaman;
        $posisi = ($page - 1) * $batas;
    }

    $no = $posisi + 1;

    $sql = "
        SELECT
            p.*,
            COALESCE(dokter.jumlah_dokter, 0) AS jumlah_dokter,
            COALESCE(layanan.jumlah_layanan, 0) AS jumlah_layanan
        FROM poliklinik p
        LEFT JOIN (
            SELECT
                id_poliklinik,
                COUNT(DISTINCT id_dokter) AS jumlah_dokter
            FROM jadwal_dokter
            GROUP BY id_poliklinik
        ) dokter ON p.id_poliklinik = dokter.id_poliklinik
        LEFT JOIN (
            SELECT
                id_poliklinik,
                COUNT(*) AS jumlah_layanan
            FROM jadwal_dokter
            GROUP BY id_poliklinik
        ) layanan ON p.id_poliklinik = layanan.id_poliklinik
        $where
        ORDER BY p.$OrderBy $ShortBy
        LIMIT ?, ?
    ";

    $stmt = mysqli_prepare($Conn, $sql);

    if (!$stmt) {
        echo '
            <tr data-page-count="0" data-current-page="0">
                <td align="center" colspan="8">
                    <small class="text-danger">Gagal menyiapkan query data.</small>
                </td>
            </tr>
        ';
        exit;
    }

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

    while ($data = mysqli_fetch_assoc($result)) {
        $id_poliklinik   = (int) $data['id_poliklinik'];
        $nama_poliklinik = htmlspecialchars($data['poliklinik'] ?? '');
        $kode            = htmlspecialchars($data['kode'] ?? '-');
        $jumlah_dokter   = (int) ($data['jumlah_dokter'] ?? 0);
        $jumlah_layanan  = (int) ($data['jumlah_layanan'] ?? 0);
        $updatetime      = !empty($data['updatetime']) ? date('d/m/Y H:i', strtotime($data['updatetime'])) : '-';
        $status          = (int) ($data['status'] ?? 0);

        if ($status === 1) {
            $label_status = '
                <span class="px-2 py-1 bg-success-subtle text-success rounded-1" title="Active">
                    <i class="bi bi-check"></i>
                </span>
            ';
        } else {
            $label_status = '
                <span class="px-2 py-1 bg-danger-subtle text-danger rounded-1" title="No Active">
                    <i class="bi bi-x-circle"></i>
                </span>
            ';
        }

        echo '
            <tr data-page-count="' . $JmlHalaman . '" data-current-page="' . $page . '">
                <td class="text-center">
                    <small class="text-muted">' . $no . '</small>
                </td>
                <td>
                    <a href="javascript:void(0);" class="modal_detail" data-id="' . $id_poliklinik . '">
                        <small class="text-primary">' . $nama_poliklinik . '</small>
                    </a>
                </td>
                <td>
                    <small class="text-muted">' . $kode . '</small>
                </td>
                <td>
                    <small class="text-muted">' . $jumlah_dokter . ' Dokter</small>
                </td>
                <td>
                    <small class="text-muted">' . $jumlah_layanan . ' Jadwal</small>
                </td>
                <td>
                    <small class="text-muted">' . $updatetime . '</small>
                </td>
                <td class="text-center">
                    <small>' . $label_status . '</small>
                </td>
                <td class="text-center">
                    <a href="javascript:void(0);" class="btn-sm btn-floating" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                    </a>
                    <ul class="dropdown-menu shadow">
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_detail" data-id="' . $id_poliklinik . '">
                                <i class="bi bi-info-circle"></i> Detail
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_edit" data-id="' . $id_poliklinik . '">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_hapus" data-id="' . $id_poliklinik . '">
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
