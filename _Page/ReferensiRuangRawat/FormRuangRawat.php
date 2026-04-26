<?php
    // Zona Waktu
    date_default_timezone_set('Asia/Jakarta');

    // Koneksi Function dan Session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // Validasi Sesi
    if (empty($SessionIdAkses)) {
        echo '
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-danger text-center">
                        <small>Sesi Akses Sudah Berakhir! Silahkan Login Ulang!</small>
                    </div>
                </div>
            </div>
        ';
        exit;
    }

    // Validasi ID Kelas Rawat
    if (empty($_POST['id_kelas_rawat'])) {
        echo '
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-danger text-center">
                        <small>Silahkan Pilih ID Kelas Terlebih Dulu!</small>
                    </div>
                </div>
            </div>
        ';
        exit;
    }

    $id_kelas_rawat = intval($_POST['id_kelas_rawat']);

    // Ambil data kelas rawat dengan prepared statement
    $stmt_kelas = $Conn->prepare("SELECT * FROM rr_kelas_rawat WHERE id_kelas_rawat = ?");
    $stmt_kelas->bind_param("i", $id_kelas_rawat);
    $stmt_kelas->execute();
    $result_kelas = $stmt_kelas->get_result();

    if ($result_kelas->num_rows == 0) {
        echo '
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-danger text-center">
                        <small>Data Kelas Yang Anda Pilih Tidak Ditemukan Pada Database!</small>
                    </div>
                </div>
            </div>
        ';
        $stmt_kelas->close();
        exit;
    }

    $DataKelas = $result_kelas->fetch_assoc();
    $kode_kelas = htmlspecialchars($DataKelas['kode_kelas']);
    $kelas      = htmlspecialchars($DataKelas['kelas']);
    $updatetime = $DataKelas['updatetime'];
    $status     = $DataKelas['status'];
    $stmt_kelas->close();

    // Ambil semua ruangan dalam kelas ini
    $stmt_ruangan = $Conn->prepare("SELECT * FROM rr_ruang_rawat WHERE id_kelas_rawat = ? ORDER BY ruang_rawat ASC");
    $stmt_ruangan->bind_param("i", $id_kelas_rawat);
    $stmt_ruangan->execute();
    $result_ruangan = $stmt_ruangan->get_result();
    $ruangan_list = [];
    while ($row = $result_ruangan->fetch_assoc()) {
        $ruangan_list[] = $row;
    }
    $jumlah_ruangan = count($ruangan_list);
    $stmt_ruangan->close();

    // --- OPTIMASI: Ambil semua agregat tempat tidur dalam 1 query ---
    $stmt_tt = $Conn->prepare("
        SELECT 
            id_ruang_rawat,
            SUM(pria) AS total_pria,
            SUM(wanita) AS total_wanita,
            SUM(bebas) AS total_bebas,
            COUNT(*) AS total_tt
        FROM rr_tempat_tidur
        WHERE id_kelas_rawat = ?
        GROUP BY id_ruang_rawat
    ");
    $stmt_tt->bind_param("i", $id_kelas_rawat);
    $stmt_tt->execute();
    $result_tt = $stmt_tt->get_result();
    $tt_counts = [];
    while ($row = $result_tt->fetch_assoc()) {
        $tt_counts[$row['id_ruang_rawat']] = [
            'pria'   => (int)$row['total_pria'],
            'wanita' => (int)$row['total_wanita'],
            'bebas'  => (int)$row['total_bebas'],
            'total'  => (int)$row['total_tt']
        ];
    }
    $stmt_tt->close();

    // --- OPTIMASI: Ambil semua data pasien (total & pending) per ruangan ---
    $ruangan_names = array_column($ruangan_list, 'ruang_rawat');
    $total_pasien_per_ruangan = [];
    $eksis_pasien_per_ruangan = [];

    if (!empty($ruangan_names)) {
        // Escape dan buat placeholder untuk IN
        $placeholders = implode(',', array_fill(0, count($ruangan_names), '?'));
        $types = str_repeat('s', count($ruangan_names));

        // Total pasien (semua status)
        $sql_total = "SELECT ruangan, COUNT(*) AS jml FROM kunjungan_utama WHERE ruangan IN ($placeholders) GROUP BY ruangan";
        $stmt_total = $Conn->prepare($sql_total);
        $stmt_total->bind_param($types, ...$ruangan_names);
        $stmt_total->execute();
        $res_total = $stmt_total->get_result();
        while ($row = $res_total->fetch_assoc()) {
            $total_pasien_per_ruangan[$row['ruangan']] = (int)$row['jml'];
        }
        $stmt_total->close();

        // Pasien dengan status 'Pending'
        $sql_eksis = "SELECT ruangan, COUNT(*) AS jml FROM kunjungan_utama WHERE ruangan IN ($placeholders) AND status = 'Pending' GROUP BY ruangan";
        $stmt_eksis = $Conn->prepare($sql_eksis);
        $stmt_eksis->bind_param($types, ...$ruangan_names);
        $stmt_eksis->execute();
        $res_eksis = $stmt_eksis->get_result();
        while ($row = $res_eksis->fetch_assoc()) {
            $eksis_pasien_per_ruangan[$row['ruangan']] = (int)$row['jml'];
        }
        $stmt_eksis->close();
    }

    // Hitung total keseluruhan (untuk baris footer)
    $total_tt_pria    = 0;
    $total_tt_wanita  = 0;
    $total_tt_bebas   = 0;
    $total_tt_ruangan = 0;
    $total_pasien     = 0;
    $total_eksis      = 0;

    // Label status kelas
    $label_status = ($status == 1)
        ? '<span class="px-2 py-2 bg-success-subtle rounded-1" title="Active"><i class="bi bi-check"></i> Active</span>'
        : '<span class="px-2 py-2 bg-secondary-subtle rounded-1" title="No Active"><i class="bi bi-check"></i> No Active</span>';

    $updatetime_format = date('d/m/Y H:i', strtotime($updatetime));
?>
<!-- Tampilkan detail kelas -->
<div class="row mb-2">
    <div class="col-md-6">
        <div class="row mb-2">
            <div class="col-5"><small>Kode Kelas</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6"><small class="text text-muted"><?php echo $kode_kelas; ?></small></div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small>Nama Kelas</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6"><small class="text text-muted"><?php echo $kelas; ?></small></div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small>Updatetime</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6"><small class="text text-muted"><?php echo $updatetime_format; ?></small></div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row mb-2">
            <div class="col-5"><small>Ruangan</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6"><small class="text text-muted"><?php echo $jumlah_ruangan; ?> Ruangan</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small>Tempat Tidur</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6"><small class="text text-muted">
                <?php 
                    // Hitung total TT keseluruhan dari array agregat
                    $total_tt_all = array_sum(array_column($tt_counts, 'total'));
                    echo $total_tt_all . ' TT';
                ?>
            </small></div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small>Status</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6"><small class="text text-muted"><?php echo $label_status; ?></small></div>
        </div>
    </div>
</div>

<hr>
<div class="row mb-3">
    <div class="col-md-9"></div>
    <div class="col-md-3 text-end">
        <button class="btn btn-md py-2 px-2 bg-primary-subtle text-primary rounded-2 w-100 modal_tambah_ruangan" data-id="<?php echo $id_kelas_rawat; ?>">
            <i class="bi bi-plus"></i> Tambah Ruangan
        </button>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="table table-responsive">
            <table class="table table-hover table-bordered table-sm">
                <thead>
                    <tr>
                        <td align="center" valign="middle" class="align-middle" rowspan="2"><small><b>No</b></small></td>
                        <td align="left" valign="middle" class="align-middle" rowspan="2"><small><b>Nama Ruangan</b></small></td>
                        <td align="center" valign="middle" class="align-middle" colspan="4"><small><b>Tempat Tidur</b></small></td>
                        <td align="center" valign="middle" class="align-middle" colspan="2"><small><b>Pasien</b></small></td>
                        <td align="center" valign="middle" class="align-middle" rowspan="2"><small><b>Updatetime</b></small></td>
                        <td align="center" valign="middle" class="align-middle" rowspan="2"><small><b>Status</b></small></td>
                        <td align="center" valign="middle" class="align-middle" rowspan="2"><small><b>Option</b></small></td>
                    </tr>
                    <tr>
                        <td align="center" valign="middle" class="align-middle"><small><b>Pria</b></small></td>
                        <td align="center" valign="middle" class="align-middle"><small><b>Wanita</b></small></td>
                        <td align="center" valign="middle" class="align-middle"><small><b>Bebas</b></small></td>
                        <td align="center" valign="middle" class="align-middle"><small><b>Jumlah</b></small></td>
                        <td align="center" valign="middle" class="align-middle"><small><b>Total Pasien</b></small></td>
                        <td align="center" valign="middle" class="align-middle"><small><b>Pasien Sekarang</b></small></td>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($ruangan_list)): ?>
                        <tr>
                            <td colspan="11" class="text-center">
                                <small class="text-muted">Tidak Ada Data Ruangan Untuk Kelas Rawat Ini</small>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php 
                        $no = 1;
                        foreach ($ruangan_list as $ruang):
                            $id_ruang_rawat   = $ruang['id_ruang_rawat'];
                            $ruang_rawat      = htmlspecialchars($ruang['ruang_rawat']);
                            $status_ruangan   = $ruang['status'];
                            $updatetime_ruang = $ruang['updatetime'];
                            $updatetime_format_ruang = date('d/m/Y H:i:s', strtotime($updatetime_ruang));

                            // Ambil data TT dari hasil agregat
                            $jml_pria   = $tt_counts[$id_ruang_rawat]['pria'] ?? 0;
                            $jml_wanita = $tt_counts[$id_ruang_rawat]['wanita'] ?? 0;
                            $jml_bebas  = $tt_counts[$id_ruang_rawat]['bebas'] ?? 0;
                            $jml_total_tt = $tt_counts[$id_ruang_rawat]['total'] ?? 0;

                            // Ambil data pasien
                            $total_pasien_ruang = $total_pasien_per_ruangan[$ruang_rawat] ?? 0;
                            $eksis_pasien_ruang = $eksis_pasien_per_ruangan[$ruang_rawat] ?? 0;

                            // Akumulasi untuk footer
                            $total_tt_pria    += $jml_pria;
                            $total_tt_wanita  += $jml_wanita;
                            $total_tt_bebas   += $jml_bebas;
                            $total_tt_ruangan += $jml_total_tt;
                            $total_pasien     += $total_pasien_ruang;
                            $total_eksis      += $eksis_pasien_ruang;

                            $label_status_ruangan = ($status_ruangan == 1)
                                ? '<span class="px-2 py-2 bg-success-subtle rounded-1" title="Active"><i class="bi bi-check"></i></span>'
                                : '<span class="px-2 py-2 bg-secondary-subtle rounded-1" title="No Active"><i class="bi bi-check"></i></span>';
                        ?>
                            <tr>
                                <td align="center"><small class="text-muted"><?php echo $no; ?></small></td>
                                <td class="text-left">
                                    <small>
                                        <a href="javascript:void(0);" class="text-primary modal_tempat_tidur" data-id="<?php echo $id_ruang_rawat; ?>">
                                            <?php echo $ruang_rawat; ?>
                                        </a>
                                    </small>
                                </td>
                                <td class="text-center"><small class="text-muted"><?php echo $jml_pria; ?></small></td>
                                <td class="text-center"><small class="text-muted"><?php echo $jml_wanita; ?></small></td>
                                <td class="text-center"><small class="text-muted"><?php echo $jml_bebas; ?></small></td>
                                <td class="text-center"><small class="text-muted"><?php echo $jml_total_tt; ?> TT</small></td>
                                <td class="text-center"><small class="text-muted"><?php echo $total_pasien_ruang; ?> Pasien</small></td>
                                <td class="text-center"><small class="text-muted"><?php echo $eksis_pasien_ruang; ?> Pasien</small></td>
                                <td class="text-center"><small class="text-muted"><?php echo $updatetime_format_ruang; ?></small></td>
                                <td align="center"><?php echo $label_status_ruangan; ?></td>
                                <td align="center">
                                    <a href="javascript:void(0);" class="btn-sm btn-floating" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </a>
                                    <ul class="dropdown-menu shadow">
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item modal_edit_ruangan" data-id="<?php echo $id_ruang_rawat; ?>">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item modal_hapus_ruangan" data-id="<?php echo $id_ruang_rawat; ?>">
                                                <i class="bi bi-trash"></i> Hapus
                                            </a>
                                        </li>
                                        <hr>
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item modal_tempat_tidur" data-id="<?php echo $id_ruang_rawat; ?>">
                                                <i class="bi bi-list"></i> Tempat Tidur
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        <?php 
                            $no++;
                        endforeach; 
                        ?>
                        <!-- Baris TOTAL -->
                        <tr>
                            <td></td>
                            <td><b>JUMLAH</b></td>
                            <td align="center"><small><b><?php echo $total_tt_pria; ?></b></small></td>
                            <td align="center"><small><b><?php echo $total_tt_wanita; ?></b></small></td>
                            <td align="center"><small><b><?php echo $total_tt_bebas; ?></b></small></td>
                            <td align="center"><small><b><?php echo $total_tt_ruangan; ?></b></small></td>
                            <td align="center"><small><b><?php echo $total_pasien; ?> Pasien</b></small></td>
                            <td align="center"><small><b><?php echo $total_eksis; ?> Pasien</b></small></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>