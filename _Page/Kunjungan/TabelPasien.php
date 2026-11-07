<?php
    // HEADER JSON / HTML
    header('Content-Type: text/html; charset=utf-8');

    // KONEKSI
    include "../../_Config/Connection.php";

    // ==============================
    // PARAMETER FILTER & PAGINATION
    // ==============================
    $page       = !empty($_POST['page_pasien']) ? (int)$_POST['page_pasien'] : 1;
    $limit      = 100;
    $offset     = ($page - 1) * $limit;

    // Optional filter (kalau nanti ada form filter)
    $keyword    = !empty($_POST['keyword_pasien']) ? $_POST['keyword_pasien'] : "";

    // ==============================
    // KONDISI WHERE
    // ==============================
    $where = !empty($keyword) ? " AND (
        nama LIKE ? OR
        nik LIKE ? OR
        no_bpjs LIKE ? OR
        gender LIKE ? OR
        status LIKE ? OR
        registered_at LIKE ? OR
        id_ihs LIKE ?
    )" : "";
    $searchPattern = '%' . $keyword . '%';

    // ==============================
    // HITUNG TOTAL DATA
    // ==============================
    // Prepared Statement: count patients matching the optional search.
    $stmtCount = mysqli_prepare($Conn, "SELECT COUNT(*) as total FROM pasien WHERE 1=1$where");
    if (!empty($keyword)) {
        mysqli_stmt_bind_param($stmtCount, 'sssssss', $searchPattern, $searchPattern, $searchPattern, $searchPattern, $searchPattern, $searchPattern, $searchPattern);
    }
    mysqli_stmt_execute($stmtCount);
    $queryCount = mysqli_stmt_get_result($stmtCount);
    $dataCount  = mysqli_fetch_assoc($queryCount);
    $totalData  = $dataCount['total'];
    mysqli_stmt_close($stmtCount);

    $pageCount  = ($totalData > 0) ? ceil($totalData / $limit) : 0;

    // ==============================
    // AMBIL DATA
    // ==============================
    // Prepared Statement: fetch the paginated patient list.
    $stmt = mysqli_prepare($Conn, "
        SELECT *
        FROM pasien
        WHERE 1=1$where
        ORDER BY id_pasien DESC
        LIMIT ?, ?
    ");
    if (!empty($keyword)) {
        mysqli_stmt_bind_param($stmt, 'sssssssii', $searchPattern, $searchPattern, $searchPattern, $searchPattern, $searchPattern, $searchPattern, $searchPattern, $offset, $limit);
    } else {
        mysqli_stmt_bind_param($stmt, 'ii', $offset, $limit);
    }
    mysqli_stmt_execute($stmt);
    $query = mysqli_stmt_get_result($stmt);

    // ==============================
    // TAMPILKAN DATA
    // ==============================
    $no = $offset + 1;

    if ($totalData > 0) {

        $first = true;

        while ($row = mysqli_fetch_assoc($query)) {

            // Variabel id_pasien
            $id_pasien = $row['id_pasien'];
            $nama      = $row['nama'];
            $id_ihs    = $row['id_ihs'];
            $nik       = $row['nik'];
            $no_bpjs   = $row['no_bpjs'];

            // Alamat
            $street      = $row['street'];
            $village     = $row['village'];
            $subdistrict = $row['subdistrict'];
            $regency     = $row['regency'];

            // STATUS BADGE
            $status = $row['status'];
            $badge = '<span class="badge bg-secondary">Unknown</span>';

            if ($status == "Active") {
                $tombol = "";
                $badge = '<span class="badge bg-success">Active</span>';
            } elseif ($status == "Inactive") {
                $tombol = "disabled";
                $badge = '<span class="badge bg-warning text-dark">Inactive</span>';
            } elseif ($status == "Deceased") {
                $tombol = "disabled";
                $badge = '<span class="badge bg-danger">Deceased</span>';
            }

            // FORMAT TANGGAL
            $tgl_lahir = (!empty($row['registered_at'])) 
                ? date('d/m/Y', strtotime($row['registered_at'])) 
                : '-';

            // GENDER SINGKAT
            $gender = '-';
            if ($row['gender'] == 'Laki-laki') {
                $gender = '<span class="px-2 py-1 bg-info-subtle text-info rounded-2">L</span>';
            } elseif ($row['gender'] == 'Perempuan') {
                $gender = '<span class="px-2 py-1 bg-danger-subtle text-danger rounded-2">P</span>';
            }

            // ======================
            // BARIS PERTAMA ADA DATA PAGE
            // ======================
            if ($first) {
                echo '<tr data-page-count="'.$pageCount.'" data-current-page="'.$page.'">';
                $first = false;
            } else {
                echo '<tr>';
            }

            // Routing NIK
            if(empty($row['nik'])){
                $nik_label    = '-';
            }else{
                $nik_label = $row['nik'];
            }

            // Routing BPJS
            if(empty($row['no_bpjs'])){
                $no_bpjs_label    = '-';
            }else{
                $no_bpjs_label    = $row['no_bpjs'];
            }

            echo '
                <td align="center"><small>'.$no.'</small></td>
                <td><small class="text-muted">'.$nama.'</small></td>
                <td><small class="text-dark">'.$id_pasien.'</small></td>
                <td><small class="text-dark">'.$nik_label.'</small></td>
                <td><small class="text-dark">'.$no_bpjs_label.'</small></td>
                <td><small>'.$gender.'</small></td>
                <td>
                    <small class="text-muted">
                        '.$village.' | '.$subdistrict.'
                    </small>
                </td>
                <td><small>'.$badge.'</small></td>
                <td class="text-center">
                    <button type="button" '.$tombol.' class="btn btn-sm btn-primary btn-round pilih_pasien" data-id="'.$id_pasien.'" data-nama="'.$nama.'" data-no_bpjs="'.$no_bpjs.'" data-nik="'.$nik.'" data-id_ihs="'.$id_ihs.'">
                        <i class="bi bi-pencil"></i> Daftarkan
                    </button>
                </td>
            </tr>
            ';

            $no++;
        }
        mysqli_stmt_close($stmt);

    } else {
        mysqli_stmt_close($stmt);

        echo '
        <tr data-page-count="0" data-current-page="0">
            <td colspan="11" align="center">
                <small class="text-muted">Pasien Tidak Ditemukan</small><br>
            </td>
        </tr>
        ';
    }
?>