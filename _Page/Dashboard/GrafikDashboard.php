<?php
    // Header JSON
    header('Content-Type: application/json');

    // Koneksi & timezone
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";

    // Ambil input dengan default
    $periode = !empty($_POST['periode']) ? $_POST['periode'] : "Tahunan";
    $tahun   = !empty($_POST['tahun']) ? (int) $_POST['tahun'] : (int) date('Y');
    $bulan   = !empty($_POST['bulan']) ? (int) $_POST['bulan'] : (int) date('m');

    // Inisialisasi
    $kategori = [];
    $data = [];

    $colTanggal = "datetime_daftar";

    // ================= BULANAN =================
    if ($periode == "Bulanan") {

        $query = mysqli_query($Conn, "
            SELECT 
                DAY($colTanggal) as hari,
                COUNT(*) as jumlah
            FROM kunjungan
            WHERE YEAR($colTanggal) = '$tahun'
            AND MONTH($colTanggal) = '$bulan'
            GROUP BY DAY($colTanggal)
            ORDER BY DAY($colTanggal)
        ");

        if (!$query) {
            echo json_encode([
                "status" => "error",
                "message" => mysqli_error($Conn)
            ]);
            exit;
        }

        while ($row = mysqli_fetch_assoc($query)) {
            $kategori[] = $row['hari'];
            $data[] = (int)$row['jumlah'];
        }
    }

    // ================= TAHUNAN =================
    elseif ($periode == "Tahunan") {

        $query = mysqli_query($Conn, "
            SELECT 
                MONTH($colTanggal) as bulan,
                COUNT(*) as jumlah
            FROM kunjungan
            WHERE YEAR($colTanggal) = '$tahun'
            GROUP BY MONTH($colTanggal)
            ORDER BY MONTH($colTanggal)
        ");

        if (!$query) {
            echo json_encode([
                "status" => "error",
                "message" => mysqli_error($Conn)
            ]);
            exit;
        }

        while ($row = mysqli_fetch_assoc($query)) {
            $kategori[] = date('M', mktime(0, 0, 0, $row['bulan'], 1));
            $data[] = (int)$row['jumlah'];
        }
    }

    // ================= OUTPUT =================
    echo json_encode([
        "status" => "success",
        "periode" => $periode,
        "tahun" => $tahun,
        "bulan" => $bulan,
        "kategori" => $kategori,
        "data" => $data
    ]);
?>