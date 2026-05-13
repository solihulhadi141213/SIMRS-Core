<?php
    // HEADER JSON / HTML
    header('Content-Type: text/html; charset=utf-8');

    // KONEKSI
    include "../../_Config/Connection.php";

    // ==============================
    // PARAMETER FILTER & PAGINATION
    // ==============================
    $page       = !empty($_POST['page_filter']) ? (int)$_POST['page_filter'] : 1;
    $limit      = !empty($_POST['batas']) ? (int)$_POST['batas'] : 10;
    $offset     = ($page - 1) * $limit;

    // Optional filter (kalau nanti ada form filter)
    $keyword    = !empty($_POST['keyword']) ? mysqli_real_escape_string($Conn, $_POST['keyword']) : "";

    // ==============================
    // KONDISI WHERE
    // ==============================
    $where = "WHERE 1=1";

    if (!empty($keyword)) {
        $where .= " AND (
            id_pasien LIKE '%$keyword%' OR
            nama LIKE '%$keyword%' OR
            nik LIKE '%$keyword%' OR
            no_bpjs LIKE '%$keyword%' OR
            gender LIKE '%$keyword%' OR
            status LIKE '%$keyword%' OR
            registered_at LIKE '%$keyword%' OR
            id_ihs LIKE '%$keyword%'
        )";
    }

    // ==============================
    // HITUNG TOTAL DATA
    // ==============================
    $queryCount = mysqli_query($Conn, "SELECT COUNT(*) as total FROM pasien $where");
    $dataCount  = mysqli_fetch_assoc($queryCount);
    $totalData  = $dataCount['total'];

    $pageCount  = ($totalData > 0) ? ceil($totalData / $limit) : 0;

    // ==============================
    // AMBIL DATA
    // ==============================
    $query = mysqli_query($Conn, "
        SELECT *
        FROM pasien
        $where
        ORDER BY id_pasien DESC
        LIMIT $offset, $limit
    ");

    // ==============================
    // TAMPILKAN DATA
    // ==============================
    $no = $offset + 1;

    if ($totalData > 0) {

        $first = true;

        while ($row = mysqli_fetch_assoc($query)) {

            // Variabel id_pasien
            $id_pasien = $row['id_pasien'];

            // STATUS BADGE
            $status = $row['status'];
            $badge = '<span class="badge bg-secondary">Unknown</span>';

            if ($status == "Active") {
                $badge = '<span class="badge bg-success">Active</span>';
            } elseif ($status == "Inactive") {
                $badge = '<span class="badge bg-warning text-dark">Inactive</span>';
            } elseif ($status == "Deceased") {
                $badge = '<span class="badge bg-danger">Deceased</span>';
            }

            // FORMAT TANGGAL
            $tgl_lahir = (!empty($row['registered_at'])) 
                ? date('d/m/Y', strtotime($row['registered_at'])) 
                : '-';

            // GENDER SINGKAT
            $gender = '-';
            if ($row['gender'] == 'Laki-laki') {
                $gender = '<span class="px-2 py-1 bg-warning-subtle text-warning rounded-2">L</span>';
            } elseif ($row['gender'] == 'Perempuan') {
                $gender = '<span class="px-2 py-1 bg-success-subtle text-success rounded-2">P</span>';
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
                $nik_label    = '
                    <a href="javascript:void(0);" class="px-2 py-1 bg-danger-subtle rounded-2 modal_edit_identitas_pasien" data-field="nik" data-id="'.$id_pasien.'" title="Cari No NIK Dari BPJS">
                        <small><i class="bi bi-plus"></i> Ubah</small>
                    </a>
                ';
            }else{
                $nik = $row['nik'];
                $nik_mask = substr($nik, -4);
                $nik_label    = '
                    <a href="javascript:void(0);" class="px-2 py-1 bg-primary-subtle rounded-2 modal_detail_nik" data-id="'.$nik.'" title="Lihat Detail NIK">
                        <small>*** '.$nik_mask.'</small>
                    </a>
                ';
            }

            // Routing BPJS
            if(empty($row['no_bpjs'])){
                $no_bpjs_label    = '
                    <a href="javascript:void(0);" class="px-2 py-1 bg-danger-subtle rounded-2 modal_edit_identitas_pasien" data-field="no_bpjs" data-id="'.$id_pasien.'" title="Cari No NIK Dari BPJS">
                        <small><i class="bi bi-plus"></i> Ubah</small>
                    </a>
                ';
                
            }else{
                $no_bpjs    = $row['no_bpjs'];
                $no_bpjs_mask = substr($row['no_bpjs'], -4);
                $no_bpjs_label    = '
                    <a href="javascript:void(0);" class="px-2 py-1 bg-primary-subtle rounded-2 modal_detail_bpjs" data-id="'.$no_bpjs.'" title="Lihat Detail BPJS">
                        <small>*** '.$no_bpjs_mask.'</small>
                    </a>
                ';
            }

            // Routing IHS
            if(empty($row['id_ihs'])){
                $id_ihs_label    = '
                    <a href="javascript:void(0);" class="px-2 py-1 bg-danger-subtle rounded-2 modal_edit_identitas_pasien" data-field="id_ihs" data-id="'.$id_pasien.'" title="Cari No NIK Dari BPJS">
                        <small><i class="bi bi-plus"></i> Ubah</small>
                    </a>
                ';
                
            }else{
                $id_ihs      = $row['id_ihs'];
                $id_ihs_mask = substr($row['id_ihs'], -4);
                $id_ihs_label      = '
                    <a href="javascript:void(0);" class="px-2 py-1 bg-primary-subtle rounded-2 modal_detail_ihs" data-id="'.$id_ihs.'" title="Lihat Detail IHS">
                        <small>*** '.$id_ihs_mask.'</small>
                    </a>
                ';
            }

            echo '
                <td align="center"><small>'.$no.'</small></td>
                <td>
                    <small>
                        <a href="javascript:void(0);" class="text-primary modal_detail" data-id="'.$row['id_pasien'].'">
                            '.$row['nama'].'
                        </a>
                    </small>
                </td>
                <td>
                    <small class="text-dark">
                        '.$id_pasien.'
                    </small>
                </td>
                <td>'.$nik_label.'</td>
                <td>'.$no_bpjs_label.'</td>
                <td>'.$id_ihs_label.'</td>
                <td><small>'.$gender.'</small></td>
                <td><small>'.$tgl_lahir.'</small></td>
                <td align="center">
                    <a href="javascript:void(0);" class="modal_ubah_status" data-id="'.$row['id_pasien'].'">
                        '.$badge.'
                    </a>
                </td>
                <td align="center" class="icon-btn">
                    <button class="btn btn-sm btn-floating" data-bs-toggle="dropdown">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu shadow">
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_detail" data-id="'.$row['id_pasien'].'">
                                <i class="bi bi-info-circle"></i> Detail Pasien
                            </a>
                        </li>
                        <hr>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_edit" data-id="'.$row['id_pasien'].'">
                                <i class="bi bi-pencil"></i> Edit Pasien
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_ubah_status" data-id="'.$row['id_pasien'].'">
                                <i class="bi bi-tag"></i> Ubah Status
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_hapus" data-id="'.$row['id_pasien'].'">
                                <i class="bi bi-trash"></i> Hapus Pasien
                            </a>
                        </li>
                        <hr>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_riwayat_kunjungan" data-id="'.$row['id_pasien'].'">
                                <i class="bi bi-clock-history"></i> Riwayat Kunjungan
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
            <td colspan="10" align="center">
                <small class="text-muted">Tidak ada data pasien</small>
            </td>
        </tr>
        ';
    }
?>