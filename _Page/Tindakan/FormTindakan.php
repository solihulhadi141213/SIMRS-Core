<?php
    // Connection, Function & Session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // VALIDASI SESSION
    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger">
                <small>Sesi akses sudah berakhir! Silahkan login ulang.</small>
            </div>
        ';
        exit;
    }

    // VALIDASI ID KUNJUNGAN
    if (empty($_POST['id_kunjungan'])) {
        echo '
            <div class="alert alert-danger">
                <small>ID Kunjungan tidak boleh kosong!</small>
            </div>
        ';
        exit;
    }

    // SANITASI INPUT
    $id_kunjungan = validateAndSanitizeInput($_POST['id_kunjungan']);

    // DETAIL KUNJUNGAN & PASIEN
    $sql = "
        SELECT 
            k.*,
            k.status AS status_kunjungan,

            p.id_pasien,
            p.nama,
            p.nik,
            p.no_bpjs,
            p.id_ihs,
            p.gender,
            p.status AS status_pasien

        FROM kunjungan k

        LEFT JOIN pasien p 
            ON k.id_pasien = p.id_pasien

        WHERE k.id_kunjungan = ?
    ";

    $stmt = $Conn->prepare($sql);
    $stmt->bind_param("i", $id_kunjungan);
    $stmt->execute();
    $result = $stmt->get_result();
    $Data   = $result->fetch_assoc();
    if (empty($Data)) {
        echo '
            <div class="alert alert-danger">
                <small>Data kunjungan tidak ditemukan!</small>
            </div>
        ';
        exit;
    }

    /// MAPPING DATA PASIEN
    $id_pasien       = $Data['id_pasien'] ?? null;
    $nama            = $Data['nama'] ?? null;
    $gender          = $Data['gender'] ?? null;
    $id_ihs          = $Data['id_ihs'] ?? null;
    

    // MAPPING DATA KUNJUNGAN
    $jenis_kunjungan = $Data['jenis_kunjungan'] ?? null;
    $datetime_daftar = $Data['datetime_daftar'] ?? null;
    $id_encounter = $Data['id_encounter'] ?? null;

    // Close
    $stmt->close();

    // FORMAT TANGGAL DAFTAR
    if (!empty($datetime_daftar)) {
        $datetime_daftar = date('d/m/Y H:i', strtotime($datetime_daftar));
    }

    
?>

<!-- ===================================================== -->
<!-- INFORMASI PASIEN & KUNJUNGAN -->
<!-- ===================================================== -->
 <input type="hidden" id="put_id_kunjungan" value="<?php echo $id_kunjungan; ?>">
<div class="row mb-3">

    <div class="col-md-6">

        <b class="mb-2">A. Informasi Pasien</b>

        <div class="row mb-2">
            <div class="col-4"><small>No.RM</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">
                    <?php echo $id_pasien; ?>
                </small>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-4"><small>Nama Pasien</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">
                    <?php echo $nama; ?>
                </small>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-4"><small>Gender</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">
                    <?php echo $gender; ?>
                </small>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-4"><small>ID IHS</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">
                    <?php echo $id_ihs; ?>
                </small>
            </div>
        </div>

    </div>

    <div class="col-md-6">

        <b class="mb-2">B. Informasi Kunjungan</b>

        <div class="row mb-2">
            <div class="col-4"><small>No.REG</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">
                    <?php echo $id_kunjungan; ?>
                </small>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-4"><small>Tujuan/Jenis</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">
                    <?php echo $jenis_kunjungan; ?>
                </small>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-4"><small>Tanggal Daftar</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">
                    <?php echo $datetime_daftar; ?>
                </small>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>ID Encounter</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">
                    <?php echo $id_encounter; ?>
                </small>
            </div>
        </div>

    </div>

</div>

<hr>
<div class="row mb-3">
    <div class="col-12">
        <button type="button" class="btn btn-md btn-primary w-100 rounded-2 modal_tambah_tindakan" data-id="<?php echo $id_kunjungan; ?>">
            <i class="bi bi-plus"></i> Tambah Tindakan
        </button>
    </div>
</div>

<?php
    $jumlah_tindakan = mysqli_num_rows(mysqli_query($Conn, "SELECT id_tindakan FROM tindakan WHERE id_kunjungan='$id_kunjungan'"));
    // Apabila Data Belum Ada
    if(empty($jumlah_tindakan)){
        echo '
            <div class="alert alert-warning text-center mt-3">
                <small>
                    <b>BELUM ADA TINDAKAN</b><br>
                    Belum ada data tindakan untuk kunjungan pasien ini.
                </small>
            </div>
        ';
        exit;
    }
?>

<div class="row">
    <div class="col-md-12">
        <div class="table table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <td class="text-center"><small><b>No</b></small></td>
                        <td class="text-left"><small><b>Tindakan</b></small></td>
                        <td class="text-left"><small><b>Kategori</b></small></td>
                        <td class="text-left"><small><b>Lokasi Tubuh</b></small></td>
                        <td class="text-left"><small><b>Waktu Pelaksanaan</b></small></td>
                        <td class="text-center"><small><b>Performer</b></small></td>
                        <td class="text-center"><small><b><i>ID Procedure</i></b></small></td>
                        <td class="text-center"><small><b>Opsi</b></small></td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $SqlTindakan = "SELECT 
                                t.*,
                                tr.kategori_tindakan,
                                tr.kategori_tindakan_display,
                                tr.nama_tindakan,
                                tr.nama_tindakan_display,
                                tr.lokasi_tubuh,
                                tr.lokasi_tubuh_display,
                                tr.icd9_code,
                                tr.icd9_description
                            FROM tindakan t
                            LEFT JOIN tindakan_referensi tr ON t.id_tindakan_referensi = tr.id_tindakan_referensi
                            WHERE t.id_kunjungan = ?
                            ORDER BY t.datetime_start DESC
                        ";
                        $stmt_tindakan = $Conn->prepare($SqlTindakan);
                        $stmt_tindakan->bind_param("i", $id_kunjungan);
                        $stmt_tindakan->execute();
                        $result_tindakan = $stmt_tindakan->get_result();

                        // Menampilkan Daftar
                        $no = 1;
                        while ($row = $result_tindakan->fetch_assoc()) {
                            $id_tindakan           = $row['id_tindakan'] ?? 0;
                            $id_tindakan_referensi = $row['id_tindakan_referensi'];
                            $id_procedure          = $row['id_procedure'];
                            $datetime_start        = $row['datetime_start'];
                            $datetime_end          = $row['datetime_end'];

                            // From Tindakan Referensi
                            $kategori_tindakan         = $row['kategori_tindakan'];
                            $kategori_tindakan_display = $row['kategori_tindakan_display'];
                            $nama_tindakan             = $row['nama_tindakan'];
                            $nama_tindakan_display     = $row['nama_tindakan_display'];
                            $lokasi_tubuh              = $row['lokasi_tubuh'] ?? '-';
                            $lokasi_tubuh_display      = $row['lokasi_tubuh_display'];

                            // Jumlah Performer
                            $jumlah_performer = mysqli_num_rows(mysqli_query($Conn, "SELECT id_tindakan_performer FROM tindakan_performer WHERE id_tindakan='$id_tindakan'"));
                            if(empty($jumlah_performer)){
                                $performer_button = '
                                    <button type="button" class="btn btn-outline-secondary btn-sm modal_performer" data-id="'.$id_tindakan.'">
                                        <i class="bi bi-exclamation-triangle"></i> Empty
                                    </button>
                                ';
                            }else{
                                $performer_button = '
                                    <button type="button" class="btn btn-info btn-sm modal_performer" data-id="'.$id_tindakan.'">
                                        '.$jumlah_performer.' Record
                                    </button>
                                ';
                            }

                            if(empty($id_procedure)){
                                $procedure_button = '
                                    <button type="button" class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-send"></i> Kirim
                                    </button>
                                ';
                            }else{
                                $procedure_button = '
                                    <button type="button" class="btn btn-info btn-sm">
                                        <i class="bi bi-info-circle"></i> Detail
                                    </button>
                                ';
                            }

                            echo '
                                <tr>
                                    <td class="text-center"><small class="text-muted">'.$no.'</small></td>
                                    
                                    <td class="text-left">
                                        <a href="javascript:void(0);" class="modal_detail" data-id="'.$id_tindakan.'">
                                            <small class="text-primary text-decoration-underline">'.$nama_tindakan.'</small><br>
                                            <small class="text-muted"><i>'.$nama_tindakan_display.'</i></small>
                                        </a>
                                    </td>

                                    <td class="text-left">
                                        <small class="text-muted text-decoration-underline">'.$kategori_tindakan.'</small><br>
                                        <small class="text-muted"><i>'.$kategori_tindakan_display.'</i></small>
                                    </td>

                                    <td class="text-left">
                                        <small class="text-muted text-decoration-underline">'.$lokasi_tubuh.'</small><br>
                                        <small class="text-muted"><i>'.$lokasi_tubuh_display.'</i></small>
                                    </td>

                                    <td class="text-left">
                                        <small class="text-muted text-decoration-underline">'.date('d/m/Y H:i',strtotime($datetime_start)).'</small><br>
                                        <small class="text-muted">'.date('d/m/Y H:i',strtotime($datetime_end)).'</small>
                                    </td>
                                    <td class="text-center">'.$performer_button.'</td>
                                    <td class="text-center">'.$procedure_button.'</td>
                                    <td class="text-center icon-btn">
                                        <button type="button" class="btn btn-floating" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu shadow">
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item modal_detail" data-id="'.$id_tindakan.'">
                                                    <i class="bi bi-info-circle"></i> Detail Tindakan
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item modal_edit" data-id="'.$id_tindakan.'">
                                                    <i class="bi bi-pencil"></i> Ubah
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item modal_hapus" data-id="'.$id_tindakan.'">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            ';

                            $no++;
                        }
                        $result_tindakan->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>