<?php
// Koneksi
$servername = "localhost";
$username = "root";
$password = "arunaparasilvanursari";
$db = "simrs";
$Conn = new mysqli($servername, $username, $password, $db);
if ($Conn->connect_error) {
    die("Connection failed: " . $Conn->connect_error);
}

$id_dokter_baru = 15;

if (!empty($_GET['clear_data'])) {
    // Looping Data Kunjungan Dengan Pencarian
    $keyword = 'Yati R';
    $nama_dokter_baru = "dr. Hj Yati Rochdiyawati Hadiyat";

    $query = mysqli_query($Conn, "SELECT id_kunjungan, id_dokter, dokter FROM kunjungan WHERE dokter LIKE '%$keyword%' ORDER BY id_kunjungan DESC");
    while ($data = mysqli_fetch_array($query)) {
        $id_kunjungan = $data['id_kunjungan'];
        $id_dokter = $data['id_dokter'];
        $dokter = $data['dokter'];

        $UpdateDokter = mysqli_query($Conn, "UPDATE kunjungan SET id_dokter='$id_dokter_baru', dokter='$nama_dokter_baru' WHERE id_kunjungan='$id_kunjungan'");
        if ($UpdateDokter) {
            $NotifUpdate = "Berhasil Update";
        } else {
            $NotifUpdate = "Gagal Update";
        }

        echo $id_kunjungan . " - ([" . $id_dokter . "]-" . $dokter . " - " . $NotifUpdate . ")<br>";
    }
}

// Optimasi: 1 query agregasi untuk seluruh periode 2020-2025 (tetap pakai LIKE karena tanggal varchar)
$rekapSql = "SELECT
                SUBSTRING(tanggal, 1, 4) AS tahun,
                SUBSTRING(tanggal, 6, 2) AS bulan,
                SUM(CASE WHEN tujuan='Rajal' THEN 1 ELSE 0 END) AS jml_rajal,
                SUM(CASE WHEN tujuan='Ranap' THEN 1 ELSE 0 END) AS jml_ranap
            FROM kunjungan
            WHERE id_dokter = ?
              AND (tujuan='Rajal' OR tujuan='Ranap')
              AND (
                  tanggal LIKE ? OR tanggal LIKE ? OR tanggal LIKE ?
                  OR tanggal LIKE ? OR tanggal LIKE ? OR tanggal LIKE ?
              )
            GROUP BY SUBSTRING(tanggal, 1, 4), SUBSTRING(tanggal, 6, 2)";
$rekapStmt = $Conn->prepare($rekapSql);
if (!$rekapStmt) {
    die("Prepare rekap gagal: " . $Conn->error);
}

$like2020 = "%2020-%";
$like2021 = "%2021-%";
$like2022 = "%2022-%";
$like2023 = "%2023-%";
$like2024 = "%2024-%";
$like2025 = "%2025-%";
$rekapStmt->bind_param("issssss", $id_dokter_baru, $like2020, $like2021, $like2022, $like2023, $like2024, $like2025);
$rekapStmt->execute();
$resultRekap = $rekapStmt->get_result();

$rekapAll = [];
while ($rowRekap = $resultRekap->fetch_assoc()) {
    $tahunInt = (int) $rowRekap['tahun'];
    $bulanInt = (int) $rowRekap['bulan'];
    if (!isset($rekapAll[$tahunInt])) {
        $rekapAll[$tahunInt] = [];
    }
    $rekapAll[$tahunInt][$bulanInt] = [
        'rajal' => (int) $rowRekap['jml_rajal'],
        'ranap' => (int) $rowRekap['jml_ranap']
    ];
}
?>
<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Rekap Dokter</title>
        <style>
            body {
                margin: 16px;
                background: #f5f7fb;
                font-family: "Segoe UI", Tahoma, sans-serif;
                color: #1f2937;
            }

            .table-wrap {
                width: 100%;
                overflow-x: auto;
                margin: 16px 0;
                border: 1px solid #dbe2ea;
                border-radius: 12px;
                background: #fff;
            }

            .table-modern {
                width: 100%;
                border-collapse: collapse;
                min-width: 720px;
                font-size: 14px;
                color: #1f2937;
            }

            .table-modern th,
            .table-modern td {
                border-bottom: 1px solid #edf2f7;
                padding: 11px 14px;
                text-align: left;
                vertical-align: middle;
            }

            .table-modern thead th {
                background: #0f766e;
                color: #fff;
                font-weight: 600;
                letter-spacing: 0.2px;
                position: sticky;
                top: 0;
                z-index: 1;
            }

            .table-modern tbody tr:nth-child(even) {
                background: #f8fafc;
            }

            .table-modern tbody tr:hover {
                background: #ecfeff;
                transition: background 0.2s ease;
            }

            .table-title {
                font-weight: 700;
                text-align: center;
                background: #e6fffb;
            }
        </style>
    </head>
    <body>
    <?php for ($tahun = 2025; $tahun >= 2020; $tahun--) { ?>
        <div class="table-wrap">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th class="table-title" colspan="5">TAHUN : <?php echo $tahun; ?></th>
                    </tr>
                    <tr>
                        <th>NO</th>
                        <th>BULAN</th>
                        <th>RAWAT JALAN</th>
                        <th>RAWAT INAP</th>
                        <th>JUMLAH</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $namaBulan = [
                        1 => 'Januari',
                        2 => 'Februari',
                        3 => 'Maret',
                        4 => 'April',
                        5 => 'Mei',
                        6 => 'Juni',
                        7 => 'Juli',
                        8 => 'Agustus',
                        9 => 'September',
                        10 => 'Oktober',
                        11 => 'November',
                        12 => 'Desember'
                    ];
                    $jml_total = 0;
                    $jml_total_rajal = 0;
                    $jml_total_ranap = 0;
                    $rekapPerBulan = isset($rekapAll[$tahun]) ? $rekapAll[$tahun] : [];

                    for ($i = 1; $i <= 12; $i++) {
                        $jml_data_rajal = isset($rekapPerBulan[$i]) ? $rekapPerBulan[$i]['rajal'] : 0;
                        $jml_data_ranap = isset($rekapPerBulan[$i]) ? $rekapPerBulan[$i]['ranap'] : 0;
                        $jumlah_rajal_ranap = $jml_data_ranap + $jml_data_rajal;
                        
                        // rekapitulasi
                        $jml_total       = $jml_total + $jumlah_rajal_ranap;
                        $jml_total_rajal = $jml_total_rajal + $jml_data_rajal;
                        $jml_total_ranap = $jml_total_ranap + $jml_data_ranap;

                        // Tampilkan Baris Tabel
                        echo '<tr>';
                        echo '<td>' . $i . '</td>';
                        echo '<td>' . $namaBulan[$i] . '</td>';
                        echo '<td>' . $jml_data_rajal . '</td>';
                        echo '<td>' . $jml_data_ranap . '</td>';
                        echo '<td>' . $jumlah_rajal_ranap . '</td>';
                        echo '</tr>';
                    }
                    echo '
                        <tr>
                            <td></td>
                            <td>JUMLAH TOTAL</td>
                            <td>'. $jml_total_rajal.'</td>
                            <td>'. $jml_total_ranap.'</td>
                            <td>'. $jml_total.'</td>
                        </tr>
                    ';
                ?>
                </tbody>
            </table>
        </div>
    <?php } ?>
    </body>
</html>
<?php
$rekapStmt->close();
$Conn->close();
?>
