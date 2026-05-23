<?php
    header('Content-Type: text/html; charset=utf-8');

    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";

    // ==============================
    // PAGINATION
    // ==============================
    $page   = (!empty($_POST['page_filter'])) ? (int)$_POST['page_filter'] : 1;
    $limit  = (!empty($_POST['batas'])) ? (int)$_POST['batas'] : 10;
    if ($page < 1) {
        $page = 1;
    }
    $offset = ($page - 1) * $limit;

    // ==============================
    // FILTER
    // ==============================
    $keyword       = trim($_POST['keyword'] ?? '');
    $keyword_by    = trim($_POST['keyword_by'] ?? '');
    $orderBy       = trim($_POST['OrderBy'] ?? 'datetime_daftar');
    $shortBy       = trim($_POST['ShortBy'] ?? 'DESC');

    // ==============================
    // VALIDASI ORDER BY
    // ==============================
    $allowedOrder = [
        'id_pasien'       => 'k.id_pasien',
        'nama'            => 'p.nama',
        'jenis_kunjungan' => 'k.jenis_kunjungan',
        'poliklinik'      => 'k.poliklinik',
        'kelas'           => 'k.kelas',
        'datetime_daftar' => 'k.datetime_daftar'
    ];

    $orderColumn = $allowedOrder[$orderBy] ?? 'k.datetime_daftar';

    $shortBy = strtoupper($shortBy);
    $shortBy = ($shortBy == 'ASC') ? 'ASC' : 'DESC';

    // ==============================
    // WHERE
    // ==============================
    $where = [];
    $params = [];
    $types  = '';

    if (!empty($keyword)) {

        switch ($keyword_by) {

            case 'id_pasien':
                $where[] = "k.id_pasien LIKE ?";
                $params[] = "%$keyword%";
                $types .= 's';
            break;

            case 'nama':
                $where[] = "p.nama LIKE ?";
                $params[] = "%$keyword%";
                $types .= 's';
            break;

            case 'jenis_kunjungan':
                $where[] = "k.jenis_kunjungan LIKE ?";
                $params[] = "%$keyword%";
                $types .= 's';
            break;

            case 'poliklinik':
                $where[] = "k.poliklinik LIKE ?";
                $params[] = "%$keyword%";
                $types .= 's';
            break;

            case 'kelas':
                $where[] = "k.kelas LIKE ?";
                $params[] = "%$keyword%";
                $types .= 's';
            break;

            case 'datetime_daftar':
                $where[] = "DATE(k.datetime_daftar) = ?";
                $params[] = $keyword;
                $types .= 's';
            break;

            default:
                $where[] = "(
                    p.nama LIKE ? OR
                    k.id_pasien LIKE ? OR
                    k.jenis_kunjungan LIKE ? OR
                    k.poliklinik LIKE ? OR
                    k.kelas LIKE ? OR
                    DATE_FORMAT(k.datetime_daftar, '%Y-%m-%d') LIKE ?
                )";

                $params[] = "%$keyword%";
                $params[] = "%$keyword%";
                $params[] = "%$keyword%";
                $params[] = "%$keyword%";

                $types .= 'ssss';
            break;
        }
    }

    $whereSql = '';

    if (!empty($where)) {
        $whereSql = "WHERE " . implode(' AND ', $where);
    }

    // ==============================
    // TOTAL DATA
    // ==============================
    $sqlCount = "SELECT COUNT(*) as total FROM kunjungan k LEFT JOIN pasien p ON k.id_pasien = p.id_pasien $whereSql";
    $stmtCount = mysqli_prepare($Conn, $sqlCount);
    if (!empty($params)) {
        mysqli_stmt_bind_param($stmtCount, $types, ...$params);
    }

    mysqli_stmt_execute($stmtCount);
    $resultCount = mysqli_stmt_get_result($stmtCount);
    $dataCount   = mysqli_fetch_assoc($resultCount);
    $totalData = $dataCount['total'] ?? 0;
    $pageCount = ($totalData > 0) ? ceil($totalData / $limit) : 0;

    // ==============================
    // QUERY DATA
    // ==============================
    $sql = "
        SELECT
            k.*,
            p.nama as nama_pasien,
            poli.kode as kode_poli,
            d.kode as kode_dpjp
        FROM kunjungan k
        LEFT JOIN pasien p ON k.id_pasien = p.id_pasien
        LEFT JOIN poliklinik poli ON k.id_poliklinik = poli.id_poliklinik
        LEFT JOIN dokter d ON k.dpjp_id = d.id_dokter
        $whereSql
        ORDER BY $orderColumn $shortBy
        LIMIT ?, ?
    ";
    $stmt = mysqli_prepare($Conn, $sql);

    // parameter pagination
    $paramsData = $params;
    $typesData  = $types . 'ii';
    $paramsData[] = $offset;
    $paramsData[] = $limit;
    mysqli_stmt_bind_param($stmt, $typesData, ...$paramsData);
    mysqli_stmt_execute($stmt);
    $query = mysqli_stmt_get_result($stmt);

    // ==============================
    // TAMPILKAN DATA
    // ==============================
    $no = $offset + 1;

    if ($totalData > 0) {
        $first = true;
        while ($row = mysqli_fetch_assoc($query)) {
            $id_kunjungan = $row['id_kunjungan'];
            $id_pasien = $row['id_pasien'];

            // Routing Jenis Kunjungan
            $badge_jenis = '<small><small>UNK</small></small>';

            if ($row['jenis_kunjungan'] == "Rajal") {
                $badge_jenis = '<small><small class="text-dark">RJL</small></small>';
            }

            if ($row['jenis_kunjungan'] == "Ranap") {
                $badge_jenis = '<small><small class="text-muted">RNP</small></small>';
            }

            // Rouitng Poliklinik
            if(empty($row['kode_poliklinik'])){
                $kode_poliklinik = '-';
            }else{
                $kode_poliklinik = $row['kode_poliklinik'];
            }

            // Rouitng Kelas
            if(empty($row['kelas'])){
                $kelas = '-';
            }else{
                $kelas = $row['kelas'];
            }


            // Format tanggal Kunjungan
            $datetime_daftar = '-';

            if (!empty($row['datetime_daftar'])) {
                $datetime_daftar = date('d/m/Y', strtotime($row['datetime_daftar']));
            }

            // Menghitung Jumlah Data Alergi
            $jumlah_alergi = mysqli_num_rows(mysqli_query($Conn, "SELECT id_alergi FROM alergi WHERE id_kunjungan = '$id_kunjungan' "));

            // Jumlah Procedure
            $jumlah_AllergyIntolerance = mysqli_num_rows(mysqli_query($Conn, "SELECT AllergyIntolerance FROM alergi WHERE id_kunjungan = '$id_kunjungan' AND AllergyIntolerance!=''"));
            
            // Routing Tombol tINDAKAN Berdasrkan Capaian
            if(empty($jumlah_alergi)){
                $tombol_alergi = '
                    <button type="button" class="btn btn-sm btn-danger show_data_view" data-id="'.$id_kunjungan.'">
                        EMPTY
                    </button>
                ';

                $tombol_AllergyIntolerance = '
                    <button type="button" disabled class="btn btn-sm btn-secondary show_data_view" data-id="'.$id_kunjungan.'">
                        EMPTY
                    </button>
                ';
            }else{
                $tombol_alergi = '
                    <button type="button" class="btn btn-sm btn-info show_data_view" data-id="'.$id_kunjungan.'">
                        '.$jumlah_alergi.' Record
                    </button>
                ';

                if($jumlah_AllergyIntolerance!==$jumlah_alergi){
                    $tombol_AllergyIntolerance = '
                        <button type="button" class="btn btn-sm btn-warning show_data_view" data-id="'.$id_kunjungan.'">
                            '.$jumlah_AllergyIntolerance.' Record
                        </button>
                    ';
                }else{
                    $tombol_AllergyIntolerance = '
                        <button type="button" class="btn btn-sm btn-success show_data_view" data-id="'.$id_kunjungan.'">
                            '.$jumlah_AllergyIntolerance.' Record
                        </button>
                    ';
                }
            }

            

            // ==========================
            // ROW PERTAMA
            // ==========================
            if ($first) {

                echo '<tr data-page-count="'.$pageCount.'" data-current-page="'.$page.'">';
                $first = false;

            } else {

                echo '<tr>';
            }

            // Tampilkan Data
            echo '
                <td align="center"><small>'.$no.'</small></td>

                <td>
                    <a href="javascript:void(0);" class="text-primary text-decoration-underline modal_detail_kunjungan" data-id="'.$id_kunjungan.'">
                        <small>'.$row['nama_pasien'].'</small>
                    </a>
                </td>
                <td>
                    <a href="javascript:void(0);" class="text-primary modal_detail_pasien" data-id="'.$id_pasien.'">
                        <small>'.$id_pasien.'</small>
                    </a>
                </td>

                <td>
                    <small class="text-muted">'.$datetime_daftar.'</small>
                </td>

                <td>'.$badge_jenis.'</td>
                <td>
                    <small class="text-muted">'.$kode_poliklinik.'</small>
                </td>
                <td>
                    <small class="text-muted">'.$kelas.'</small>
                </td>
                <td class="text-center">'.$tombol_alergi.'</td>
                <td class="text-center">'.$tombol_AllergyIntolerance.'</td>

            </tr>
            ';

            $no++;
        }

    } else {

        echo '
            <tr data-page-count="0" data-current-page="0">
                <td colspan="9" align="center">
                    <small class="text-muted">Tidak ada data kunjungan</small>
                </td>
            </tr>
        ';
    }
?>