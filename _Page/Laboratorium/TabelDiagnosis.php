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
    $keyword    = !empty($_POST['keyword']) ? mysqli_real_escape_string($Conn, $_POST['keyword']) : "";

   // KONDISI WHERE
    $where = "WHERE 1=1";

    if (!empty($keyword)) {
        $where .= " AND (kode LIKE '%$keyword%' OR long_des LIKE '%$keyword%' OR short_des LIKE '%$keyword%')";
    }

    // HITUNG TOTAL DATA
    $queryCount = mysqli_query($Conn, "SELECT COUNT(*) as total FROM dokter $where");
    $dataCount  = mysqli_fetch_assoc($queryCount);
    $totalData  = $dataCount['total'];
    $pageCount  = ($totalData > 0) ? ceil($totalData / $limit) : 0;

    /// AMBIL DATA
    $query = mysqli_query($Conn, "SELECT * FROM icd $where ORDER BY kode DESC LIMIT $offset, $limit");

    // TAMPILKAN DATA
    $no = $offset + 1;

    if ($totalData > 0) {
        while ($row = mysqli_fetch_assoc($query)) {

            // Variabel id_pasien
            $kode      = $row['kode'];
            $long_des  = $row['long_des'];
            $short_des = $row['short_des'];

            $html .= '
                <tr class="current_diagnosis" data-kode="'.$kode.'" data-nama="'.$long_des.'" data-short_des="'.$short_des.'" style="cursor: pointer;">
                    <td><small class="text-muted">'.$no.'</small></td>
                    <td><small class="text-muted">'.$kode.'</small></td>
                    <td><small class="text-muted">'.$short_des.'</small></td>
                    <td><small class="text-muted">'.$long_des.'</small></td>
                </tr>
            ';
            $no++;
        }
        echo json_encode([
            "status"     => "success",
            "html"       => $html,
            "page"       => $page,
            "total_page" => $pageCount,
            "total_data" => $totalData
        ]);
        exit;
    } else {

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