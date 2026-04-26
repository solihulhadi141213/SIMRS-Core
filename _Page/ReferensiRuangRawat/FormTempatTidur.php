<?php
    // Zona Waktu
    date_default_timezone_set('Asia/Jakarta');

    // Koneksi Function dan Session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // Melakukan Validasi Sesi Akses Dan Menampilkan Pemberitahuan Secara Jelas, Explisit dan Relevan
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

    // Tangkap Data
    if(empty($_POST['id_ruang_rawat'])){
        echo '
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-danger text-center">
                        <small>Silahkan Pilih ID Ruang Rawat Terlebih Dulu!</small>
                    </div>
                </div>
            </div>
        ';
        exit;
    }

    // Buat Variabel Dan Sanitasi
    $id_ruang_rawat = validateAndSanitizeInput($_POST['id_ruang_rawat']);

    // Menampilkan Detail Kelas Dengan Prepared Statment
    $stmt = $Conn->prepare("SELECT * FROM rr_ruang_rawat WHERE id_ruang_rawat = ?");
    $stmt->bind_param("i", $id_ruang_rawat);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo '
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-danger text-center">
                        <small>Data Ruang Rawat Yang Anda Pilih Tidak Ditemukan Pada Database!</small>
                    </div>
                </div>
            </div>
        ';
        exit;
    }

    // Tampilkan Data Dan Buat Variabelnya
    $Data           = $result->fetch_assoc();
    $id_kelas_rawat = $Data['id_kelas_rawat'];
    $ruang_rawat    = $Data['ruang_rawat'];
    $status         = $Data['status'];
    $updatetime     = $Data['updatetime'];

    // Menghitung Jumlah Ruangan Dan Tempat Tidur
    $jumlah_tt      = mysqli_num_rows(mysqli_query($Conn, "SELECT id_tempat_tidur FROM rr_tempat_tidur WHERE id_ruang_rawat='$id_ruang_rawat'"));

    // Label Status
    $label_status = ($status == 1)
            ? '<span class="px-2 py-2 bg-success-subtle rounded-1" title="Active"><i  class="bi bi-check"></i> Active</span>'
            : '<span class="px-2 py-2 bg-secondary-subtle rounded-1" title="No Active"><i  class="bi bi-check"></i> No Active</span>';

    $updatetime_format = date('d/m/Y H:i', strtotime($updatetime));
    $stmt->close();

    // Buka Kelas Dan Kode Kelas
    $kode_kelas = getDataDetail_v2($Conn, 'rr_kelas_rawat', 'id_kelas_rawat', $id_kelas_rawat, 'kode_kelas');
    $kelas      = getDataDetail_v2($Conn, 'rr_kelas_rawat', 'id_kelas_rawat', $id_kelas_rawat, 'kelas');

    // Menampilkan Detail
    echo '
        <div class="row mb-2">

            <div class="col-md-6">
                <div class="row mb-2">
                    <div class="col-5"><small>Kode Kelas</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><small class="text text-muted">'.$kode_kelas.'</small></div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>Nama Kelas</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><small class="text text-muted">'.$kelas.'</small></div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>Ruang Rawat</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><small class="text text-muted">'.$ruang_rawat.'</small></div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="row mb-2">
                    <div class="col-5"><small>Tempat Tidur</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><small class="text text-muted">'.$jumlah_tt.' TT</small></div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>Updatetime</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><small class="text text-muted">'.$updatetime_format.'</small></div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>Status</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><small class="text text-muted">'.$label_status.'</small></div>
                </div>
            </div>

        </div>
    ';

    // Menampilkan Tempat Tidur Menggunakan Prepared Statment
?>
<hr>
<div class="row mb-3">
    <div class="col-md-9"></div>
    <div class="col-md-3 text-end">
        <button class="btn btn-md py-2 px-2 bg-info-subtle text-info rounded-2 w-100 modal_tambah_tempat_tidur" data-id="<?php echo $id_ruang_rawat; ?>">
            <i class="bi bi-plus"></i> Tambah Tempat Tidur
        </button>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-12">
        <div class="table table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <td align="center"><small><b>No</b></small></td>
                        <td align="left"><small><b>Tempat Tidur</b></small></td>
                        <td align="center"><small><b>Pria</b></small></td>
                        <td align="center"><small><b>Wanita</b></small></td>
                        <td align="center"><small><b>Bebas</b></small></td>
                        <td align="left"><small><b>Updatetime</b></small></td>
                        <td align="center"><small><b>Status</b></small></td>
                        <td align="center"><small><b>Option</b></small></td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(empty($jumlah_tt)){
                            echo '
                                <tr>
                                    <td colspan="8" class="text-center">
                                        <small class="text-muted">Tidak Ada Data Tempat Tidur Untuk Ruang Rawat Ini</small>
                                    </td>
                                </tr>
                            ';
                            exit;
                        }

                        // Menampilkan Baris Ruangan
                        $no = 1;
                        $query = mysqli_query($Conn, "SELECT*FROM rr_tempat_tidur WHERE id_ruang_rawat='$id_ruang_rawat'");
                        while ($data = mysqli_fetch_array($query)) {
                            $id_tempat_tidur = $data['id_tempat_tidur'];
                            $tempat_tidur    = $data['tempat_tidur'];
                            $pria            = $data['pria'];
                            $wanita          = $data['wanita'];
                            $bebas           = $data['bebas'];
                            $status_tt       = $data['status'];
                            $updatetime     = $data['updatetime'];

                            // Format Updatetime
                            $updatetime_format     = date('d/m/Y H:i:s', strtotime($data['updatetime']));
                            
                            // Routing Label Ruangan
                            $label_status_tt = ($status_tt == 1)
                                ? '<span class="px-2 py-2 bg-success-subtle rounded-1" title="Active"><i  class="bi bi-check"></i></span>'
                                : '<span class="px-2 py-2 bg-secondary-subtle rounded-1" title="No Active"><i  class="bi bi-check"></i></span>';
                            echo '
                                <tr>
                                    <td align="center"><small class="text-muted">'.$no.'</small></td>
                                    <td class="text-left"><small class="text-muted">'.$tempat_tidur.'</small></td>
                                    <td class="text-center">'.$pria.'</td>
                                    <td class="text-center">'.$wanita.'</td>
                                    <td class="text-center">'.$bebas.'</td>
                                    <td class="text-left"><small class="text-muted">'.$updatetime_format.'</small></td>
                                    <td align="center">'.$label_status_tt.'</td>
                                    <td align="center">
                                        <a href="javascript:void(0);" class="btn-sm btn-floating" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </a>
                                        <ul class="dropdown-menu shadow">
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item modal_edit_tempat_tidur" data-id="' . $id_tempat_tidur . '">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item modal_hapus_tempat_tidur" data-id="' . $id_tempat_tidur . '">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            ';

                            $no++;
                        }

                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>