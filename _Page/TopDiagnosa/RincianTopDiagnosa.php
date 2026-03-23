<?php
    // Koneksi ke database
    include "../../_Config/Connection.php";

    // Validasi parameter
    $required = ['tujuan', 'periode_1', 'periode_2', 'kategori', 'kode'];
    foreach ($required as $key) {
        if (empty($_GET[$key])) {
            echo "<div class='kopsurat'>
                    <div class='title_halaman bold'>PARAMETER '$key' TIDAK DAPAT DITANGKAP</div>
                    <div class='title_halaman italic'>Hubungi Admin Untuk Kesalahan Ini!!</div>
                </div>";
            exit;
        }
    }

    $tujuan       = $_GET['tujuan'];
    $PeriodeAwal  = $_GET['periode_1'];
    $PeriodeAkhir = $_GET['periode_2'];
    $kategori = $_GET['kategori'];
    $Kode         = $_GET['kode'];

    // Ambil nama diagnosa
    $QryDiagnosa = mysqli_query($Conn, "SELECT diagnosis FROM diagnosis_pasien WHERE kode='$Kode' LIMIT 1");
    if (!$QryDiagnosa) {
        die("Query Error Diagnosa: " . mysqli_error($Conn));
    }
    $DataDiagnosa = mysqli_fetch_assoc($QryDiagnosa); // ← baris ini yang hilang
    $short_d = $DataDiagnosa['diagnosis'] ?? 'Tidak Diketahui';
    // Inisialisasi variabel rekap
    $rekap = [
        'L06'=>0,'L28'=>0,'L29'=>0,'L4'=>0,'L14'=>0,'L15'=>0,'L25'=>0,'L45'=>0,'L64'=>0,
        'P06'=>0,'P28'=>0,'P29'=>0,'P4'=>0,'P14'=>0,'P15'=>0,'P25'=>0,'P45'=>0,'P64'=>0,
        'LBaru'=>0,'PBaru'=>0,'Meninggal'=>0
    ];

    // Fungsi kategori usia
    function kategori_usia($gender, $tgl_lahir, $tgl_kunjungan) {
        $birth = new DateTime($tgl_lahir);
        $visit = new DateTime($tgl_kunjungan);
        $diff = $visit->diff($birth);

        $y = $diff->y;
        $m = $diff->m;
        $d = $diff->d;
        $umur_lengkap = "$y Tahun $m Bulan $d Hari";

        $prefix = strtolower($gender) == 'laki-laki' ? 'L' : 'P';
        if ($y == 0 && $m == 0 && $d <= 6) return ['label' => $prefix . '06', 'umur' => $umur_lengkap];
        if ($y == 0 && $m == 0 && $d <= 28) return ['label' => $prefix . '28', 'umur' => $umur_lengkap];
        if ($y == 0) return ['label' => $prefix . '29', 'umur' => $umur_lengkap];
        if ($y <= 4) return ['label' => $prefix . '4', 'umur' => $umur_lengkap];
        if ($y <= 14) return ['label' => $prefix . '14', 'umur' => $umur_lengkap];
        if ($y <= 24) return ['label' => $prefix . '15', 'umur' => $umur_lengkap];
        if ($y <= 44) return ['label' => $prefix . '25', 'umur' => $umur_lengkap];
        if ($y <= 64) return ['label' => $prefix . '45', 'umur' => $umur_lengkap];
        return ['label' => $prefix . '64', 'umur' => $umur_lengkap];
    }

    // Ambil data utama
    $q = "
    SELECT 
        dp.*, 
        ku.tanggal AS tanggal_kunjungan, 
        ku.pembayaran, 
        ku.dokter, 
        ku.status AS status_pasien, 
        ku.poliklinik AS poli,
        p.nik, 
        p.gender, 
        p.tanggal_lahir, 
        p.tanggal_daftar AS tanggal_register 
    FROM diagnosis_pasien dp
    JOIN kunjungan_utama ku ON dp.id_kunjungan = ku.id_kunjungan
    JOIN pasien p ON dp.id_pasien = p.id_pasien
    WHERE 
        dp.kategori = '$kategori' 
        AND dp.kode = '$Kode'
        AND ku.tujuan = '$tujuan'
        AND STR_TO_DATE(dp.tanggal, '%Y-%m-%d %H:%i:%s') 
            BETWEEN '$PeriodeAwal 00:00:00' AND '$PeriodeAkhir 23:59:59'
    ORDER BY ku.tanggal DESC
    ";
    $result = mysqli_query($Conn, $q);
    if (!$result) {
        die("Query Error Data Utama: " . mysqli_error($Conn));
    }
?>

<html>
    <head>
        <title>Laporan Top Diagnosa</title>
        <style>
            body { font-family: Arial; color: black; }
            .kopsurat, .title_halaman { text-align: center; }
            .bold { font-weight: bold; }
            .italic { font-style: italic; }
            table.hasil { border-collapse: collapse; width: 100%; }
            table.hasil th, table.hasil td { border: 1px solid #999; padding: 4px; }
        </style>
    </head>
    <body>
        <div class="kopsurat">
            <div class="bold">LAPORAN TOP DIAGNOSA PELAYANAN <?php echo strtoupper($tujuan); ?></div>
            <div><?php echo $short_d; ?></div>
            <div>PERIODE <?php echo "$PeriodeAwal s/d $PeriodeAkhir"; ?></div>
        </div>
        <br>
        <table class="hasil">
            <tr>
                <th>No</th>
                <th>No.RM</th>
                <th>No.REG</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Tgl.Lahir</th>
                <th>Tanggal</th>
                <th>Gender</th>
                <th>Umur</th>
                <th>Pembayaran</th>
                <th>Lama/Baru</th>
                <th>Poli</th>
                <th>Dokter</th>
                <th>Status</th>
            </tr>
            <?php
            $no = 1;
            while ($data = mysqli_fetch_assoc($result)) {
                $umur = kategori_usia($data['gender'], $data['tanggal_lahir'], $data['tanggal_kunjungan']);
                $label = $umur['label'];

                $rekap[$label]++;

                $lamaBaru = $data['tanggal_register'] == $data['tanggal_kunjungan'] ? 'Baru' : 'Lama';
                if ($lamaBaru == 'Baru') {
                    $rekap[$data['gender'] == 'laki-laki' ? 'LBaru' : 'PBaru']++;
                }

                if ($data['status_pasien'] == 'Meninggal') {
                    $rekap['Meninggal']++;
                }

                echo "<tr>
                    <td>{$no}</td>
                    <td>{$data['id_pasien']}</td>
                    <td>{$data['id_kunjungan']}</td>
                    <td>{$data['nik']}</td>
                    <td>{$data['nama_pasien']}</td>
                    <td>{$data['tanggal_lahir']}</td>
                    <td>{$data['tanggal_kunjungan']}</td>
                    <td>{$data['gender']}</td>
                    <td>{$umur['umur']}</td>
                    <td>{$data['pembayaran']}</td>
                    <td>$lamaBaru</td>
                    <td>{$data['poli']}</td>
                    <td>{$data['dokter']}</td>
                    <td>{$data['status_pasien']}</td>
                </tr>";
                $no++;
            }
            ?>
        </table>

        <br><b>REKAPITULASI</b><br>
        <table class="hasil">
            <tr>
                <th>No</th>
                <th>Kriteria</th>
                <th>Laki-Laki</th>
                <th>Perempuan</th>
                <th>Jumlah</th>
            </tr>
            <?php
                $kategori_usia = [
                    '0 - 6hr'     => ['L06','P06'],
                    '7 - 28hr'    => ['L28','P28'],
                    '29hr - 1Th'  => ['L29','P29'],
                    '1 - 4Th'     => ['L4','P4'],
                    '5 - 14Th'    => ['L14','P14'],
                    '15 - 24Th'   => ['L15','P15'],
                    '25 - 44Th'   => ['L25','P25'],
                    '45 - 64Th'   => ['L45','P45'],
                    '> 64Th'      => ['L64','P64'],
                    'Kasus Baru'  => ['LBaru','PBaru'],
                ];
                $i = 1;
                foreach ($kategori_usia as $label => $keys) {
                    $l = $rekap[$keys[0]];
                    $p = $rekap[$keys[1]];
                    echo "<tr>
                            <td align='center'>{$i}</td>
                            <td>{$label}</td>
                            <td align='center'>{$l}</td>
                            <td align='center'>{$p}</td>
                            <td align='center'>".($l + $p)."</td>
                        </tr>";
                    $i++;
                }
            ?>
            <tr>
                <td align="center"><?php echo $i; ?></td>
                <td>Meninggal</td>
                <td align="center" colspan="3"><?php echo $rekap['Meninggal']; ?></td>
            </tr>
        </table>
    </body>
</html>
