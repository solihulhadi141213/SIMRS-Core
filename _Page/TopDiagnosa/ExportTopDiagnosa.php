<?php
    // Set header agar browser mengunduh file
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=TopDiagnosa_" . date("Ymd_His") . ".xls");

    // Koneksi database
    include "../../_Config/Connection.php";

    // Ambil parameter dari GET
    $periode_1 = isset($_GET['periode_1']) ? $_GET['periode_1'] : '';
    $periode_2 = isset($_GET['periode_2']) ? $_GET['periode_2'] : '';
    $tujuan = isset($_GET['tujuan']) ? $_GET['tujuan'] : '';
    $kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';

    // Validasi input
    if (empty($periode_1) || empty($periode_2) || empty($tujuan) || empty($kategori)) {
        echo "Semua parameter harus diisi!";
        exit;
    }

    // Ambil total keseluruhan
    $total_query = "
        SELECT COUNT(*) AS total
        FROM diagnosis_pasien dp
        JOIN kunjungan_utama ku ON dp.id_kunjungan = ku.id_kunjungan
        JOIN pasien p ON dp.id_pasien = p.id_pasien
        WHERE 
            dp.kategori = '$kategori' AND
            ku.tujuan = '$tujuan' AND
            STR_TO_DATE(dp.tanggal, '%Y-%m-%d %H:%i:%s') 
                BETWEEN '$periode_1 00:00:00' AND '$periode_2 23:59:59'
    ";
    $total_result = mysqli_fetch_assoc(mysqli_query($Conn, $total_query));
    $total_semua = $total_result['total'];

    // Query data utama
    $query = "
        SELECT 
            dp.kode,
            dp.diagnosis,
            SUM(CASE WHEN p.gender = 'Laki-laki' THEN 1 ELSE 0 END) AS laki,
            SUM(CASE WHEN p.gender = 'Perempuan' THEN 1 ELSE 0 END) AS perempuan,
            COUNT(*) AS total
        FROM diagnosis_pasien dp
        JOIN kunjungan_utama ku ON dp.id_kunjungan = ku.id_kunjungan
        JOIN pasien p ON dp.id_pasien = p.id_pasien
        WHERE 
            dp.kategori = '$kategori' AND
            ku.tujuan = '$tujuan' AND
            STR_TO_DATE(dp.tanggal, '%Y-%m-%d %H:%i:%s') 
                BETWEEN '$periode_1 00:00:00' AND '$periode_2 23:59:59'
        GROUP BY dp.kode, dp.diagnosis
        ORDER BY total DESC
    ";

    $result = mysqli_query($Conn, $query);

    // Cetak header tabel Excel
    echo "<table border='1'>";
    echo "<thead>
    <tr>
        <th>No</th>
        <th>Kode</th>
        <th>Deskripsi</th>
        <th>Laki-laki</th>
        <th>Perempuan</th>
        <th>Jumlah</th>
        <th>Persentase</th>
    </tr>
    </thead>";
    echo "<tbody>";

    $no = 1;
    $grand_laki = 0;
    $grand_perempuan = 0;
    $grand_total = 0;

    while ($row = mysqli_fetch_assoc($result)) {
        $persen = ($row['total'] / $total_semua) * 100;

        echo "<tr>";
        echo "<td align='center'>{$no}</td>";
        echo "<td>{$row['kode']}</td>";
        echo "<td>{$row['diagnosis']}</td>";
        echo "<td align='center'>{$row['laki']}</td>";
        echo "<td align='center'>{$row['perempuan']}</td>";
        echo "<td align='center'>{$row['total']}</td>";
        echo "<td align='center'>" . number_format($persen, 2) . " %</td>";
        echo "</tr>";

        $grand_laki += $row['laki'];
        $grand_perempuan += $row['perempuan'];
        $grand_total += $row['total'];
        $no++;
    }

    // Baris total
    echo "<tr style='font-weight: bold; background-color:#ddd;'>";
    echo "<td colspan='3' align='center'><b>Total</b></td>";
    echo "<td align='center'>{$grand_laki}</td>";
    echo "<td align='center'>{$grand_perempuan}</td>";
    echo "<td align='center'>{$grand_total}</td>";
    echo "<td align='center'>100%</td>";
    echo "</tr>";

    echo "</tbody></table>";
?>
