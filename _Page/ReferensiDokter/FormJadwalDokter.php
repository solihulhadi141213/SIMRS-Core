<?php
    // Koneksi, Function dan Session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // menangkap ID Dokter
    if(empty($_POST['id_dokter'])){
        echo '
            <div class="row mb-3">
                <div class="col-12">
                    <div class="alert alert-danger text-center">
                        <b>Opss!</b>
                        <small>ID Dokter Tidak Boleh Kosong!</small>
                    </div>
                </div>
            </div>
        ';
        exit;
    }

    // Validasi Sesi Akses
        if (empty($SessionIdAkses)) {
        echo '
            <div class="row mb-3">
                <div class="col-12">
                    <div class="alert alert-danger text-center">
                        <b>Opss!</b>
                        <small>Sesi akses sudah berakhir! Silahkan Login Ulang.</small>
                    </div>
                </div>
            </div>
        ';
        exit;
    }

    // Buat Variabel
    $id_dokter = $_POST['id_dokter'];

    // Helper function (ANTI KOSONG + XSS SAFE)
    function val($data) {
        return (!empty($data) && trim($data) !== '') 
            ? htmlspecialchars($data) 
            : '-';
    }

    // Ambil data dokter
    $stmt = mysqli_prepare($Conn, "SELECT * FROM dokter WHERE id_dokter = ?");
    mysqli_stmt_bind_param($stmt, "i", $id_dokter);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result || mysqli_num_rows($result) == 0) {
        echo '<div class="alert alert-danger">Data dokter tidak ditemukan</div>';
        exit;
    }

    $data = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    // Ambil data (pakai helper)
    $nama                = val($data['nama'] ?? '');
    $kode                = val($data['kode'] ?? '');
    $kategori            = val($data['kategori'] ?? '');
?>
<div class="row mb-2">
    <div class="col-4"><small>Nama Dokter</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-7">
        <small class="text text-muted"><?php echo $nama; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Kode Dokter</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-7">
        <small class="text text-muted"><?php echo $kode; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Kategori</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-7">
        <small class="text text-muted"><?php echo $kategori; ?></small>
    </div>
</div>

<div class="row mb-2 mt-4">
    <div class="col-12">
        <div class="table table-responsive">
            <table class="table table-bordered table-hover table-responsive-sm">
                <thead>
                    <tr>
                        <td class="text-center"><small><b>No</b></small></td>
                        <td class="text-center"><small><b>Hari</b></small></td>
                        <td class="text-center"><small><b>Poliklinik</b></small></td>
                        <td class="text-center"><small><b>Mulai</b></small></td>
                        <td class="text-center"><small><b>Selesai</b></small></td>
                        <td class="text-center"><small><b>BPJS</b></small></td>
                        <td class="text-center"><small><b>Umum</b></small></td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Query jadwal + join poliklinik
                        $stmtJadwal = mysqli_prepare($Conn, "
                            SELECT 
                                jd.hari,
                                jd.jam_mulai,
                                jd.jam_selesai,
                                jd.kuota_jkn,
                                jd.kuota_non_jkn,
                                p.poliklinik
                            FROM jadwal_dokter jd
                            LEFT JOIN poliklinik p ON jd.id_poliklinik = p.id_poliklinik
                            WHERE jd.id_dokter = ?
                            ORDER BY FIELD(
                                jd.hari,
                                'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'
                            ), jd.jam_mulai ASC
                        ");

                        mysqli_stmt_bind_param($stmtJadwal, "i", $id_dokter);
                        mysqli_stmt_execute($stmtJadwal);
                        $resultJadwal = mysqli_stmt_get_result($stmtJadwal);

                        if ($resultJadwal && mysqli_num_rows($resultJadwal) > 0) {

                            $no = 1;
                            while ($row = mysqli_fetch_assoc($resultJadwal)) {

                                $hari         = val($row['hari']);
                                $poli         = val($row['poliklinik']);
                                $mulai        = val(substr($row['jam_mulai'],0,5));
                                $selesai      = val(substr($row['jam_selesai'],0,5));
                                $kuota_jkn    = val($row['kuota_jkn']);
                                $kuota_nonjkn = val($row['kuota_non_jkn']);

                                echo "
                                    <tr>
                                        <td class='text-center'><small>{$no}</small></td>
                                        <td class='text-center'><small>{$hari}</small></td>
                                        <td><small>{$poli}</small></td>
                                        <td class='text-center'><small>{$mulai}</small></td>
                                        <td class='text-center'><small>{$selesai}</small></td>
                                        <td class='text-center'><small>{$kuota_jkn}</small></td>
                                        <td class='text-center'><small>{$kuota_nonjkn}</small></td>
                                    </tr>
                                ";

                                $no++;
                            }

                        } else {
                            echo '
                                <tr>
                                    <td colspan="7" class="text-center">
                                        <small>Tidak Ada Jadwal</small>
                                    </td>
                                </tr>
                            ';
                        }

                        mysqli_stmt_close($stmtJadwal);
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>