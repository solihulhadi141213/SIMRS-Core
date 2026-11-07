<?php

    // KONEKSI
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // Default Variabel
    $html = "";
    // Validasi Sesi Akses
    if (empty($SessionIdAkses)) {
        echo json_encode([
            "status" => "error",
            "html"   => '
                <tr>
                    <td colspan="8" class="text-center text-danger">
                        <small>Sesi akses sudah berakhir. Silakan login ulang.</small>
                    </td>
                </tr>
            ',
            "page" => 1,
            "total_page" => 1,
            "total_data" => 0
        ]);
        exit;
    }

   // PARAMETER FILTER & PAGINATION
    $page       = !empty($_POST['page']) ? (int)$_POST['page'] : 1;
    $limit      = !empty($_POST['batas']) ? (int)$_POST['batas'] : 10;
    $offset     = ($page - 1) * $limit;

    // Optional filter (kalau nanti ada form filter)
    $keyword    = !empty($_POST['keyword']) ? $_POST['keyword'] : "";

   // KONDISI WHERE
    $where = !empty($keyword) ? " AND (id_ihs_practitioner LIKE ? OR nama LIKE ? OR kode LIKE ?)" : "";
    $searchPattern = '%' . $keyword . '%';

    // HITUNG TOTAL DATA
    // Prepared Statement: count doctors matching the optional search.
    $stmtCount = mysqli_prepare($Conn, "SELECT COUNT(*) as total FROM dokter WHERE 1=1$where");
    if (!empty($keyword)) {
        mysqli_stmt_bind_param($stmtCount, 'sss', $searchPattern, $searchPattern, $searchPattern);
    }
    mysqli_stmt_execute($stmtCount);
    $queryCount = mysqli_stmt_get_result($stmtCount);
    $dataCount  = mysqli_fetch_assoc($queryCount);
    $totalData  = $dataCount['total'];
    mysqli_stmt_close($stmtCount);
    $pageCount  = ($totalData > 0) ? ceil($totalData / $limit) : 0;

    /// AMBIL DATA
    // Prepared Statement: fetch the paginated doctor list.
    $stmt = mysqli_prepare($Conn, "SELECT * FROM dokter WHERE 1=1$where ORDER BY nama DESC LIMIT ?, ?");
    if (!empty($keyword)) {
        mysqli_stmt_bind_param($stmt, 'sssii', $searchPattern, $searchPattern, $searchPattern, $offset, $limit);
    } else {
        mysqli_stmt_bind_param($stmt, 'ii', $offset, $limit);
    }
    mysqli_stmt_execute($stmt);
    $query = mysqli_stmt_get_result($stmt);

    // TAMPILKAN DATA
    $no = $offset + 1;

    if ($totalData > 0) {
        while ($row = mysqli_fetch_assoc($query)) {

            // Variabel id_pasien
            $id_dokter           = $row['id_dokter'];
            $nama                = $row['nama'];
            $kode                = $row['kode'];
            $id_ihs_practitioner = $row['id_ihs_practitioner'];

            $html .= '
                <tr class="current_dokter" data-id_dokter="'.$id_dokter.'" data-nama="'.$nama.'" data-kode="'.$kode.'" data-id_ihs_practitioner="'.$id_ihs_practitioner.'" style="cursor: pointer;">
                    <td><small class="text-muted">'.$no.'</small></td>
                    <td><small class="text-muted">'.$nama.'</small></td>
                    <td><small class="text-muted">'.$kode.'</small></td>
                    <td><small class="text-muted">'.$id_ihs_practitioner.'</small></td>
                </tr>
            ';
            $no++;
        }
        mysqli_stmt_close($stmt);
        echo json_encode([
            "status"     => "success",
            "html"       => $html,
            "page"       => $page,
            "total_page" => $pageCount,
            "total_data" => $totalData
        ]);
        exit;
    } else {
        mysqli_stmt_close($stmt);

         echo json_encode([
            "status" => "error",
            "html"   => '
                <tr>
                    <td colspan="8" class="text-center text-danger">
                        <small>Tidak Ada Data Data Yang Ditampilkan.</small>
                    </td>
                </tr>
            ',
            "page" => 1,
            "total_page" => 1,
            "total_data" => 0
        ]);
        exit;
    }
?>