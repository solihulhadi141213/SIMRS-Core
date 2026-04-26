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

    // ==============================
    // PARAMETER
    // ==============================
    $keyword_by = trim($_POST['keyword_by'] ?? '');
    $keyword    = trim($_POST['keyword'] ?? '');
    $batas      = (int) ($_POST['batas'] ?? 10);
    $page       = (int) ($_POST['page'] ?? 1);
    $ShortBy    = strtoupper(trim($_POST['ShortBy'] ?? 'DESC'));
    $OrderBy    = trim($_POST['OrderBy'] ?? 'id_kelas_rawat');

    $batas = in_array($batas, [5, 10, 25, 50, 100, 250, 500]) ? $batas : 10;
    $page  = max(1, $page);
    $posisi = ($page - 1) * $batas;

    // ==============================
    // VALIDASI
    // ==============================
    $allowed_order = ['id_kelas_rawat', 'kode_kelas', 'kelas', 'status', 'updatetime'];
    $allowed_sort  = ['ASC', 'DESC'];
    $allowed_search = ['kode_kelas', 'kelas', 'status', 'updatetime'];

    $OrderBy = in_array($OrderBy, $allowed_order) ? $OrderBy : 'id_kelas_rawat';
    $ShortBy = in_array($ShortBy, $allowed_sort) ? $ShortBy : 'DESC';

    // ==============================
    // WHERE
    // ==============================
    $where = "";
    $params = [];
    $types = "";

    if ($keyword !== '') {
        $keyword_like = "%" . $keyword . "%";

        if ($keyword_by !== '' && in_array($keyword_by, $allowed_search)) {

            if ($keyword_by === 'status') {
                $keyword_lower = strtolower($keyword);

                if (in_array($keyword_lower, ['1', 'aktif'])) {
                    $where = " WHERE k.status = ?";
                    $params[] = 1;
                    $types .= "i";
                } elseif (in_array($keyword_lower, ['0', 'tidak aktif'])) {
                    $where = " WHERE k.status = ?";
                    $params[] = 0;
                    $types .= "i";
                }

            } else {
                $where = " WHERE k.$keyword_by LIKE ?";
                $params[] = $keyword_like;
                $types .= "s";
            }

        } else {
            $where = " WHERE (
                k.kode_kelas LIKE ?
                OR k.kelas LIKE ?
                OR k.updatetime LIKE ?
            )";

            $params[] = $keyword_like;
            $params[] = $keyword_like;
            $params[] = $keyword_like;
            $types .= "sss";
        }
    }

    // ==============================
    // COUNT DATA
    // ==============================
    $sql_count = "
        SELECT COUNT(*) AS total
        FROM rr_kelas_rawat k
        $where
    ";

    $stmt_count = mysqli_prepare($Conn, $sql_count);

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
                    <small class="text-muted">Tidak ada data</small>
                </td>
            </tr>
        ';
        exit;
    }

    $JmlHalaman = ceil($jml_data / $batas);

    // ==============================
    // QUERY UTAMA
    // ==============================
    $sql = "
    SELECT 
        k.*,
        COUNT(DISTINCT r.id_ruang_rawat) AS jumlah_ruang,
        COUNT(t.id_tempat_tidur) AS jumlah_tt
    FROM rr_kelas_rawat k
    LEFT JOIN rr_ruang_rawat r ON k.id_kelas_rawat = r.id_kelas_rawat
    LEFT JOIN rr_tempat_tidur t ON r.id_ruang_rawat = t.id_ruang_rawat
    $where
    GROUP BY k.id_kelas_rawat
    ORDER BY k.$OrderBy $ShortBy
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

    // ==============================
    // OUTPUT
    // ==============================
    $no = $posisi + 1;

    while ($data = mysqli_fetch_assoc($result)) {

        $id_kelas_rawat   = $data['id_kelas_rawat'];
        $kelas = htmlspecialchars($data['kelas']);
        $kode  = htmlspecialchars($data['kode_kelas']);
        $ruang = (int)$data['jumlah_ruang'];
        $tt    = (int)$data['jumlah_tt'];
        $status = (int)$data['status'];

        $updatetime = !empty($data['updatetime'])
            ? date('d/m/Y H:i', strtotime($data['updatetime']))
            : '-';

        $label_status = ($status == 1)
            ? '<span class="px-2 py-2 bg-success-subtle rounded-1" title="Active"><i  class="bi bi-check"></i></span>'
            : '<span class="px-2 py-2 bg-secondary-subtle rounded-1" title="No Active"><i  class="bi bi-check"></i></span>';

        echo '
        <tr data-page-count="'.$JmlHalaman.'" data-current-page="'.$page.'">
            <td class="text-center"><small class="text-muted">'.$no.'</small></td>
            <td>
                <small>
                    <a href="javascript:void(0);" class="text-primary modal_ruang_rawat" data-id="' . $id_kelas_rawat . '">
                        '.$kelas.'
                    </a>
                </small>
            </td>
            <td><small class="text-muted">'.$kode.'</small></td>
            <td><small class="text-muted">'.$ruang.' Ruang</small></td>
            <td><small class="text-muted">'.$tt.' Bed</small></td>
            <td><small class="text-muted">'.$updatetime.'</small></td>
            <td class="text-center">'.$label_status.'</td>
            <td class="text-center">
                <a href="javascript:void(0);" class="btn-sm btn-floating" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-three-dots-vertical"></i>
                </a>
                <ul class="dropdown-menu shadow">
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item modal_ruang_rawat" data-id="' . $id_kelas_rawat . '">
                            <i class="bi bi-list"></i> Daftar Ruangan
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item modal_edit_kelas" data-id="' . $id_kelas_rawat . '">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item modal_hapus_kelas" data-id="' . $id_kelas_rawat . '">
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