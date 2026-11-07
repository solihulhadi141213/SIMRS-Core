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
    $where = !empty($keyword) ? " AND (id_pasien LIKE ? OR nama LIKE ?)" : "";
    $searchPattern = '%' . $keyword . '%';

    // HITUNG TOTAL DATA
    // Prepared Statement: count patients matching the optional search.
    $stmtCount = mysqli_prepare($Conn, "SELECT COUNT(*) as total FROM pasien WHERE 1=1$where");
    if (!empty($keyword)) {
        mysqli_stmt_bind_param($stmtCount, 'ss', $searchPattern, $searchPattern);
    }
    mysqli_stmt_execute($stmtCount);
    $queryCount = mysqli_stmt_get_result($stmtCount);
    $dataCount  = mysqli_fetch_assoc($queryCount);
    $totalData  = $dataCount['total'];
    mysqli_stmt_close($stmtCount);
    $pageCount  = ($totalData > 0) ? ceil($totalData / $limit) : 0;

    /// AMBIL DATA
    // Prepared Statement: fetch the paginated patient list.
    $stmt = mysqli_prepare($Conn, "SELECT * FROM pasien WHERE 1=1$where ORDER BY id_pasien DESC LIMIT ?, ?");
    if (!empty($keyword)) {
        mysqli_stmt_bind_param($stmt, 'ssii', $searchPattern, $searchPattern, $offset, $limit);
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
            $id_pasien = $row['id_pasien'];
            $nama = $row['nama'];
            $nik = $row['nik'];
            $gender = $row['gender'];
            $id_ihs = $row['id_ihs'];
            $tanggal_lahir = $row['tanggal_lahir'];

            $html .= '
                <tr class="current_pasien" data-id_pasien="'.$id_pasien.'" data-nama="'.$nama.'" data-id_ihs="'.$id_ihs.'" data-gender="'.$gender.'" data-tanggal_lahir="'.$tanggal_lahir.'" style="cursor: pointer;">
                    <td><small class="text-muted">'.$no.'</small></td>
                    <td><small class="text-muted">'.$id_pasien.'</small></td>
                    <td><small class="text-muted">'.$nama.'</small></td>
                    <td><small class="text-muted">'.$gender.'</small></td>
                    <td><small class="text-muted">'.$tanggal_lahir.'</small></td>
                    <td><small class="text-muted">'.$id_ihs.'</small></td>
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