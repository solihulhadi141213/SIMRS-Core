<?php
    date_default_timezone_set('Asia/Jakarta');

    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    if (empty($SessionIdAkses)) {
        echo '
            <tr data-page-count="0" data-current-page="0">
                <td align="center" colspan="7">
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
    $OrderBy    = trim($_POST['OrderBy'] ?? 'id_dokter');

    $batas = in_array($batas, [5, 10, 25, 50, 100, 250, 500]) ? $batas : 10;
    $page  = max(1, $page);
    $posisi = ($page - 1) * $batas;

    $allowed_order = ['id_dokter', 'nama', 'kode', 'id_ihs_practitioner', 'status'];
    $allowed_sort = ['ASC', 'DESC'];
    $allowed_search = ['nama', 'kode', 'id_ihs_practitioner', 'status'];

    $OrderBy = in_array($OrderBy, $allowed_order) ? $OrderBy : 'id_dokter';
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
                    $where = " WHERE d.status = ?";
                    $params[] = 1;
                    $types .= "i";
                } elseif (in_array($keyword_lower, ['0', 'tidak aktif', 'nonaktif', 'inactive', 'tidak', 'no'])) {
                    $where = " WHERE d.status = ?";
                    $params[] = 0;
                    $types .= "i";
                } else {
                    $where = " WHERE d.status LIKE ?";
                    $params[] = $keyword_like;
                    $types .= "s";
                }
            } else {
                $where = " WHERE d.$keyword_by LIKE ?";
                $params[] = $keyword_like;
                $types .= "s";
            }
        } else {
            $where = " WHERE (
                d.nama LIKE ?
                OR d.kode LIKE ?
                OR d.id_ihs_practitioner LIKE ?
                OR CASE
                    WHEN d.status = 1 THEN 'Aktif'
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
        FROM dokter d
        $where
    ";

    $stmt_count = mysqli_prepare($Conn, $sql_count);

    if (!$stmt_count) {
        echo '
            <tr data-page-count="0" data-current-page="0">
                <td align="center" colspan="7">
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
                <td align="center" colspan="7">
                    <small class="text-danger">Data dokter tidak ditemukan</small>
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
            d.*,
            COALESCE(layanan.jumlah_jadwal, 0) AS jumlah_jadwal
        FROM dokter d
        LEFT JOIN (
            SELECT
                id_dokter,
                COUNT(DISTINCT id_poliklinik) AS jumlah_jadwal
            FROM jadwal_dokter
            GROUP BY id_dokter
        ) layanan ON d.id_dokter = layanan.id_dokter
        $where
        ORDER BY d.$OrderBy $ShortBy
        LIMIT ?, ?
    ";

    $stmt = mysqli_prepare($Conn, $sql);

    if (!$stmt) {
        echo '
            <tr data-page-count="0" data-current-page="0">
                <td align="center" colspan="7">
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
        $id_dokter = (int) $data['id_dokter'];
        $nama = htmlspecialchars($data['nama'] ?? '');
        $kode = htmlspecialchars($data['kode'] ?? '-');
        $id_ihs_practitioner = htmlspecialchars($data['id_ihs_practitioner'] ?? '-');
        $jumlah_jadwal = (int) ($data['jumlah_jadwal'] ?? 0);
        $status = (int) ($data['status'] ?? 0);

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

        // Routing ID Practitioner
        if(empty($data['id_ihs_practitioner'])){
            $label_practitioner = '
                <small class="py-1 px-2 bg-secondary-subtle rounded-1"><small>None</small></small>
            ';
        }else{
            $label_practitioner = '
                <a href="javascript:void(0);" class="py-1 px-2 bg-info-subtle rounded-1 modal_detail_ihs" data-id="' . $id_ihs_practitioner . '">
                    <small>' . $id_ihs_practitioner . '</small>
                </a>
            ';
        }

        // Routing Jadwal
        if(empty($jumlah_jadwal)){
            $label_jadwal = '
                <a href="javascript:void(0);" class="py-1 px-2 bg-secondary-subtle modal_jadwal" data-id="' . $id_dokter . '">
                    <small>None</small>
                </a>
            ';
        }else{
            $label_jadwal = '
                <a href="javascript:void(0);" class="py-1 px-2 bg-success-subtle modal_jadwal" data-id="' . $id_dokter . '">
                    <small>'.$jumlah_jadwal.' Sesi</small>
                </a>
            ';
        }
        // Menghitung Jumlah Layanan DPJP
        $jumlah_layanan_dpjp =  mysqli_num_rows(mysqli_query($Conn, "SELECT id_kunjungan FROM kunjungan_utama WHERE id_dokter='$id_dokter'"));

        echo '
            <tr data-page-count="' . $JmlHalaman . '" data-current-page="' . $page . '">
                <td class="text-center">
                    <small class="text-muted">' . $no . '</small>
                </td>
                <td>
                    <small>
                        <a href="javascript:void(0);" class="text-primary modal_detail" data-id="' . $id_dokter . '">
                            ' . $nama . '
                        </a>
                    </small>
                </td>
                <td>
                    <small class="text-muted">' . $kode . '</small>
                </td>
                <td>' . $label_practitioner . '</td>
                <td>' . $label_jadwal . '</td>
                <td>
                    <small class="text-muted">' . $jumlah_layanan_dpjp . '</small>
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
                            <a href="javascript:void(0);" class="dropdown-item modal_detail" data-id="' . $id_dokter . '">
                                <i class="bi bi-info-circle"></i> Detail
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_edit" data-id="' . $id_dokter . '">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_hapus" data-id="' . $id_dokter . '">
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
