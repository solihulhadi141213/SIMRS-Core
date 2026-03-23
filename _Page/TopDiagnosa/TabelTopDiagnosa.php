<?php
    // Koneksi Database
    include "../../_Config/Connection.php";

    // Tangkap Data
    if (empty($_POST['periode_1']) || empty($_POST['periode_2']) || empty($_POST['tujuan']) || empty($_POST['kategori'])) {
        echo '<tr><td colspan="7" align="center"><i class="text-danger">Semua field harus diisi!</i></td></tr>';
        exit;
    }

    $periode_1 = $_POST['periode_1'];
    $periode_2 = $_POST['periode_2'];
    $tujuan = $_POST['tujuan'];
    $kategori = $_POST['kategori'];

    // Query untuk ambil data diagnosa grup berdasarkan kode dan deskripsi
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
            STR_TO_DATE(dp.tanggal, '%Y-%m-%d %H:%i:%s') BETWEEN '$periode_1 00:00:00' AND '$periode_2 23:59:59'
        GROUP BY dp.kode, dp.diagnosis
        ORDER BY total DESC
    ";

    $result = mysqli_query($Conn, $query);

    // Cek hasil
    if (mysqli_num_rows($result) <= 0) {
        echo '<tr><td colspan="7" align="center"><i>Tidak ada data diagnosa ditemukan</i></td></tr>';
        exit;
    }

    // Hitung total keseluruhan untuk persentase
    $total_query = "
        SELECT COUNT(*) AS total
        FROM diagnosis_pasien dp
        JOIN kunjungan_utama ku ON dp.id_kunjungan = ku.id_kunjungan
        JOIN pasien p ON dp.id_pasien = p.id_pasien
        WHERE 
            dp.kategori = '$kategori' AND
            ku.tujuan = '$tujuan' AND
            STR_TO_DATE(dp.tanggal, '%Y-%m-%d %H:%i:%s') BETWEEN '$periode_1 00:00:00' AND '$periode_2 23:59:59'
    ";
    $total_result = mysqli_fetch_assoc(mysqli_query($Conn, $total_query));
    $total_semua = $total_result['total'];

    // Inisialisasi total laki/perempuan
    $no = 1;
    $grand_laki = 0;
    $grand_perempuan = 0;
    $grand_total = 0;

    while ($row = mysqli_fetch_assoc($result)) {
        $persentase = ($row['total'] / $total_semua) * 100;
        echo '<tr>';
        echo '<td align="center">' . $no++ . '</td>';
        echo '
            <td align="left">
                <a href="_Page/TopDiagnosa/RincianTopDiagnosa.php?periode_1='.$periode_1.'&periode_2='.$periode_2.'&tujuan='.$tujuan.'&kategori='.$kategori.'&kode=' . htmlspecialchars($row['kode']) . '" target="_blank" class="text-primary">
                    ' . htmlspecialchars($row['kode']) . '
                </a>
            </td>
        ';
        echo '
            <td align="left">
                <a href="_Page/TopDiagnosa/RincianTopDiagnosa.php?periode_1='.$periode_1.'&periode_2='.$periode_2.'&tujuan='.$tujuan.'&kategori='.$kategori.'&kode=' . htmlspecialchars($row['kode']) . '" target="_blank" class="text-primary">
                    ' . htmlspecialchars($row['diagnosis']) . '
                </a>
            </td>
        ';
        echo '<td align="center">' . $row['laki'] . '</td>';
        echo '<td align="center">' . $row['perempuan'] . '</td>';
        echo '<td align="center">' . $row['total'] . '</td>';
        echo '<td align="center">' . number_format($persentase, 2) . ' %</td>';
        echo '</tr>';

        $grand_laki += $row['laki'];
        $grand_perempuan += $row['perempuan'];
        $grand_total += $row['total'];
    }

    // Baris total
    echo '<tr class="table-active font-weight-bold">';
    echo '<td colspan="3" align="center"><b>Total</b></td>';
    echo '<td align="center"><b>' . $grand_laki . '</b></td>';
    echo '<td align="center"><b>' . $grand_perempuan . '</b></td>';
    echo '<td align="center"><b>' . $grand_total . '</b></td>';
    echo '<td align="center"><b>100%</b></td>';
    echo '</tr>';
?>
