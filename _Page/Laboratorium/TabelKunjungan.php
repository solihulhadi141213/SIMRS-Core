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

    // Validasi id_pasien Tidak Boleh Kosong
    if(empty($_POST['id_pasien'])){
        echo json_encode([
            "status" => "error",
            "html"   => '
                <tr>
                    <td colspan="8" class="text-center text-danger">
                        <small>ID Pasien (RM Pasien) Tidak Boleh Kosong</small>
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
    $id_pasien = (int)$_POST['id_pasien'];
    $page      = !empty($_POST['page']) ? (int)$_POST['page'] : 1;
    $limit     = !empty($_POST['batas']) ? (int)$_POST['batas'] : 10;
    $offset    = ($page - 1) * $limit;

    // HITUNG TOTAL DATA
    $queryCount = mysqli_query($Conn, "SELECT COUNT(*) as total FROM kunjungan WHERE id_pasien='$id_pasien'");
    $dataCount  = mysqli_fetch_assoc($queryCount);
    $totalData  = $dataCount['total'];
    $pageCount  = ($totalData > 0) ? ceil($totalData / $limit) : 0;

    /// AMBIL DATA
    $query = mysqli_query($Conn, "SELECT id_kunjungan, id_encounter, jenis_kunjungan, pembayaran_metode, poliklinik, ruang_rawat, datetime_daftar FROM kunjungan WHERE id_pasien='$id_pasien' ORDER BY id_kunjungan DESC LIMIT $offset, $limit");

    // Nomor Baris
    $no = $offset + 1;

    // Jika data Kosong
    if(empty($totalData)){
        echo json_encode([
            "status" => "error",
            "html"   => '
                <tr>
                    <td colspan="8" class="text-center text-danger">
                        <small>Tidak Ada Data Data Kunjungan Untuk RM Pasien <b>'.$id_pasien.'</b>.</small>
                    </td>
                </tr>
            ',
            "page" => 1,
            "total_page" => 1,
            "total_data" => 0
        ]);
        exit;
    }
    while ($row = mysqli_fetch_assoc($query)) {

        // Variabel id_pasien
        $id_kunjungan      = $row['id_kunjungan'];
        $id_encounter      = $row['id_encounter'];
        $tujuan            = $row['jenis_kunjungan'];
        $pembayaran_metode = $row['pembayaran_metode'];
        $poliklinik        = $row['poliklinik'];
        $ruang_rawat       = $row['ruang_rawat'];
        $tanggal           = date('d/m/Y', strtotime($row['datetime_daftar']));

        // Routing Unit instalasi
        if($tujuan=="Rajal"){
            $unit_instalasi = $poliklinik;
        }else{
            $unit_instalasi = $ruang_rawat;
        }


        $html .= '
            <tr class="current_kunjungan" data-id_kunjungan="'.$id_kunjungan.'" data-id_encounter="'.$id_encounter.'" data-tujuan="'.$tujuan.'" data-pembayaran_metode="'.$pembayaran_metode.'" data-unit_instalasi="'.$unit_instalasi.'" style="cursor: pointer;">
                <td><small class="text-muted">'.$no.'</small></td>
                <td><small class="text-muted">'.$tanggal.'</small></td>
                <td><small class="text-muted">'.$id_kunjungan.'</small></td>
                <td><small class="text-muted">'.$tujuan.'</small></td>
                <td><small class="text-muted">'.$pembayaran_metode.'</small></td>
                <td><small class="text-muted">'.$unit_instalasi.'</small></td>
                <td><small class="text-muted">'.$id_encounter.'</small></td>
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
?>