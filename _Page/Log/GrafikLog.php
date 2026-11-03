<?php
// _Page/Log/GrafikLog.php - FIXED untuk struktur elsyifa_core

error_reporting(E_ALL);
ini_set('display_errors', 0);
header('Content-Type: application/json; charset=utf-8');

try {
    date_default_timezone_set('Asia/Jakarta');

    $conn_path = "../../_Config/Connection.php";
    $session_path = "../../_Config/Session.php";

    if (!file_exists($conn_path)) throw new Exception("File koneksi tidak ditemukan");
    if (!file_exists($session_path)) throw new Exception("File session tidak ditemukan");

    include $conn_path;
    include $session_path;

    if (!isset($Conn) || !$Conn) throw new Exception("Koneksi database (\$Conn) gagal");

    $id_akses = isset($SessionIdAkses) ? intval($SessionIdAkses) : 0;

    $periode_data = $_POST['periode_data'] ?? 'Tahun';
    $kategori_log = isset($_POST['kategori_log']) ? mysqli_real_escape_string($Conn, $_POST['kategori_log']) : '';
    $tahun_grafik = isset($_POST['tahun_grafik']) ? intval($_POST['tahun_grafik']) : intval(date('Y'));
    $bulan_grafik = isset($_POST['bulan_grafik']) ? intval($_POST['bulan_grafik']) : intval(date('m'));

    $data = [];

    // 1. MODE TAHUN
    if ($periode_data === "Tahun") {
        $BulanList = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
            '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
            '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];
        foreach ($BulanList as $BulanNomor => $BulanNama) {
            $KeywordGrafik = "$tahun_grafik-$BulanNomor";
            $KeywordEsc = mysqli_real_escape_string($Conn, $KeywordGrafik);

            if (empty($kategori_log)) {
                $sql = "SELECT COUNT(*) AS total FROM log WHERE datetime_log LIKE '$KeywordEsc%' AND id_akses='$id_akses'";
            } else {
                $sql = "SELECT COUNT(*) AS total FROM log WHERE title_log='$kategori_log' AND datetime_log LIKE '$KeywordEsc%' AND id_akses='$id_akses'";
            }
            $query = mysqli_query($Conn, $sql);
            if (!$query) throw new Exception("Query Error: " . mysqli_error($Conn) . " | SQL: $sql");
            $row = mysqli_fetch_assoc($query);
            $data[] = ['x' => $BulanNama, 'y' => $row ? intval($row['total']) : 0];
        }
    } 
    // 2. MODE BULAN
    else if ($periode_data === "Bulan") {
        $bulan_nomor = sprintf("%02d", $bulan_grafik);
        $total_hari = cal_days_in_month(CAL_GREGORIAN, $bulan_grafik, $tahun_grafik);

        for ($i = 1; $i <= $total_hari; $i++) {
            $HariNomor = sprintf("%02d", $i);
            $KeywordGrafik = "$tahun_grafik-$bulan_nomor-$HariNomor";
            $KeywordEsc = mysqli_real_escape_string($Conn, $KeywordGrafik);

            if (empty($kategori_log)) {
                $sql = "SELECT COUNT(*) AS total FROM log WHERE datetime_log LIKE '$KeywordEsc%' AND id_akses='$id_akses'";
            } else {
                $sql = "SELECT COUNT(*) AS total FROM log WHERE title_log='$kategori_log' AND datetime_log LIKE '$KeywordEsc%' AND id_akses='$id_akses'";
            }
            $query = mysqli_query($Conn, $sql);
            if (!$query) throw new Exception("Query Error: " . mysqli_error($Conn));
            $row = mysqli_fetch_assoc($query);
            $data[] = ['x' => $HariNomor, 'y' => $row ? intval($row['total']) : 0];
        }
    } 
    // 3. MODE HARI
    else {
        $tanggal_sekarang = date('Y-m-d');
        for ($i = 0; $i < 24; $i++) {
            $JamNomor = sprintf("%02d", $i);
            $KeywordGrafik = "$tanggal_sekarang $JamNomor";
            $KeywordEsc = mysqli_real_escape_string($Conn, $KeywordGrafik);

            if (empty($kategori_log)) {
                $sql = "SELECT COUNT(*) AS total FROM log WHERE datetime_log LIKE '$KeywordEsc%' AND id_akses='$id_akses'";
            } else {
                $sql = "SELECT COUNT(*) AS total FROM log WHERE title_log='$kategori_log' AND datetime_log LIKE '$KeywordEsc%' AND id_akses='$id_akses'";
            }
            $query = mysqli_query($Conn, $sql);
            if (!$query) throw new Exception("Query Error: " . mysqli_error($Conn));
            $row = mysqli_fetch_assoc($query);
            $data[] = ['x' => $JamNomor . ":00", 'y' => $row ? intval($row['total']) : 0];
        }
    }

    echo json_encode($data);
    exit;

} catch (Exception $e) {
    echo json_encode(["error" => true, "message" => $e->getMessage()]);
    exit;
}