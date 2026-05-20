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

    // VALIDASI ID TINDAKAN
    if (empty($_POST['id_tindakan'])) {
        echo '
            <div class="alert alert-danger">
                <small>ID Tindakan tidak boleh kosong!</small>
            </div>
        ';
        exit;
    }

    // SANITASI INPUT
    $id_tindakan = validateAndSanitizeInput($_POST['id_tindakan']);

    // =========================================================
    // DETAIL TINDAKAN
    // =========================================================
    $sql = "
        SELECT 
            t.*,

            k.id_kunjungan,
            k.id_dokter,
            k.jenis_kunjungan,
            k.datetime_daftar,
            k.id_encounter,
            k.status AS status_kunjungan,

            p.id_pasien,
            p.nama,
            p.nik,
            p.no_bpjs,
            p.id_ihs,
            p.gender,
            p.tanggal_lahir,
            p.status AS status_pasien,

            tr.kategori_tindakan,
            tr.kategori_tindakan_code,
            tr.kategori_tindakan_display,
            tr.kategori_tindakan_system,

            tr.nama_tindakan,
            tr.nama_tindakan_code,
            tr.nama_tindakan_display,
            tr.nama_tindakan_system,

            tr.lokasi_tubuh,
            tr.lokasi_tubuh_code,
            tr.lokasi_tubuh_display,
            tr.lokasi_tubuh_system,

            tr.icd9_code,
            tr.icd9_description,

            a.nama AS petugas_input_nama

        FROM tindakan t

        LEFT JOIN kunjungan k
            ON t.id_kunjungan = k.id_kunjungan

        LEFT JOIN pasien p
            ON t.id_pasien = p.id_pasien

        LEFT JOIN tindakan_referensi tr
            ON t.id_tindakan_referensi = tr.id_tindakan_referensi

        LEFT JOIN akses a
            ON t.petugas_id = a.id_akses

        WHERE t.id_tindakan = ?
    ";

    $stmt = $Conn->prepare($sql);
    $stmt->bind_param("i", $id_tindakan);
    $stmt->execute();

    $result = $stmt->get_result();
    $Data   = $result->fetch_assoc();

    // VALIDASI DATA
    if (empty($Data)) {

        echo '
            <div class="alert alert-danger">
                <small>Data tindakan tidak ditemukan!</small>
            </div>
        ';
        exit;
    }

    // =========================================================
    // MAPPING DATA
    // =========================================================
    // INFORMASI UMUM
    $id_procedure     = $Data['id_procedure'] ?? null;
    $datetime_creat     = $Data['datetime_creat'] ?? null;
    $datetime_update     = $Data['datetime_update'] ?? null;
    $petugas_nama     = $Data['petugas_nama'] ?? null;

    // PASIEN
    $id_pasien     = $Data['id_pasien'] ?? null;
    $nama          = $Data['nama'] ?? null;
    $gender        = $Data['gender'] ?? null;
    $id_ihs        = $Data['id_ihs'] ?? null;

    // KUNJUNGAN
    $id_kunjungan  = $Data['id_kunjungan'] ?? null;
    $id_encounter  = $Data['id_encounter'] ?? null;
    $jenis_kunjungan  = $Data['jenis_kunjungan'] ?? null;
    $datetime_daftar  = $Data['datetime_daftar'] ?? null;

    // TINDAKAN
    $datetime_start = $Data['datetime_start'] ?? null;
    $datetime_end   = $Data['datetime_end'] ?? null;
    $reson_code     = $Data['reson_code'] ?? null;
    $reson_display  = $Data['reson_display'] ?? null;
    $reson_display  = $Data['reson_display'] ?? null;

    // REFERENSI
    $nama_tindakan         = $Data['nama_tindakan'];
    $nama_tindakan_code    = $Data['nama_tindakan_code'];
    $nama_tindakan_display = $Data['nama_tindakan_display'];
    $nama_tindakan_system  = $Data['nama_tindakan_system'];

    // KATEGORI
    $kategori_tindakan         = $Data['kategori_tindakan'];
    $kategori_tindakan_code    = $Data['kategori_tindakan_code'];
    $kategori_tindakan_display = $Data['kategori_tindakan_display'];
    $kategori_tindakan_system  = $Data['kategori_tindakan_system'];

    //LOKASI TUBUH
    $lokasi_tubuh         = $Data['lokasi_tubuh'];
    $lokasi_tubuh_code    = $Data['lokasi_tubuh_code'];
    $lokasi_tubuh_display = $Data['lokasi_tubuh_display'];
    $lokasi_tubuh_system  = $Data['lokasi_tubuh_system'];

    // ICD9
    $icd9_code        = $Data['icd9_code'];
    $icd9_description = $Data['icd9_description'];

    // WAKTU PELAKSANAAN TINDAKAN
    $datetime_start = $Data['datetime_start'];
    $datetime_end   = $Data['datetime_end'];

    // REASON CODE
    $reson_reference = $Data['reson_reference'];
    $reson_code      = $Data['reson_code'];
    $reson_display   = $Data['reson_display'];

    // Keterangan
    $post_tindakan   = $Data['post_tindakan'];

    // Routing Data Kosong
    if(empty($id_encounter)){
        $id_encounter = '-';
    }
?>

<div class="row mb-2">
    <div class="col-md-6">
        <div class="row mb-2">
            <div class="col-4"><small>ID Pasien (RM)</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted"><?php echo $id_pasien; ?></small>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Nama Pasien</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted"><?php echo $nama; ?></small>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Tanggal Daftar</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted"><?php echo $datetime_daftar; ?></small>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Tujuan</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted"><?php echo $jenis_kunjungan; ?></small>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row mb-2">
            <div class="col-4"><small>Tanggal & Waktu</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted"><?php echo $datetime_creat; ?></small>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Kategori</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted"><?php echo $kategori_tindakan; ?></small>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Nama Tindakan</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted"><?php echo $nama_tindakan; ?></small>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Lokasi Tubuh</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted"><?php echo $lokasi_tubuh; ?></small>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="row mb-4">
    <div class="col-12">
        <button type="button" class="btn btn-sm btn-primary btn-round w-100 modal_tambah_perfomrer" data-id="<?php echo $id_tindakan; ?>">
            <i class="bi bi-plus"></i> Tambah Pelaksana (<i>Performer</i>)
        </button>
    </div>
</div>

<?php
    // DATA PERFORMER
    $SqlPerformer = "
        SELECT *
        FROM tindakan_performer
        WHERE id_tindakan = ?
        ORDER BY id_tindakan_performer ASC
    ";

    $stmt_performer = $Conn->prepare($SqlPerformer);
    $stmt_performer->bind_param("i", $id_tindakan);
    $stmt_performer->execute();
    $result_performer = $stmt_performer->get_result();
    $jumlah_performer = $result_performer->num_rows;

    // Jika Kosong
    if(empty($jumlah_performer)){
        echo '
            <div class="alert alert-danger text-center">
                <small>
                    Belum ada informasi Pelaksana (<i>Performer</i>) untuk tindakan ini. Silahkan tambahkan terlebih dulu.
                </small>
            </div>
        ';
    }else{
        $no = 1;
        while($Performer = $result_performer->fetch_assoc()) {
            $id_tindakan_performer = $Performer['id_tindakan_performer'];
            $performer_type        = $Performer['performer_type'];
            $performer_nama        = $Performer['performer_nama'];
            $performer_ihs         = $Performer['performer_ihs'];
            $performer_nik         = $Performer['performer_nik'];
            $performer_notes       = $Performer['performer_notes'];

            // Routing berdasarkan $Performer['id_praktisi']
            if(empty($Performer['id_praktisi'])){
                $label_nama_performer = '
                    <b>'.$no.'. '.$performer_nama.'</b>
                ';
                $opsi_detail = '';
            }else{
                $id_praktisi = $Performer['id_praktisi'];
                $label_nama_performer = '
                    <a href="javascript:void(0);" class="text-primary fw-bold modal_detail_performer" data-id="'.$id_praktisi.'">
                        '.$no.'. '.$performer_nama.'
                    </a>
                ';
                $opsi_detail = '
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item modal_detail_performer" data-id="'.$id_praktisi.'">
                            <i class="bi bi-info-circle"></i> Detail
                        </a>
                    </li>
                ';
            }
            echo '
                <hr>
                <div class="row mt-3">
                    <div class="col-10">
                        <small>'.$label_nama_performer.'</small>
                    </div>
                    <div class="col-2 text-end icon-btn">
                        <button type="button" class="btn-floating" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu shadow">
                            '.$opsi_detail.'
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item modal_edit_performer" data-id="'.$id_tindakan_performer.'">
                                    <i class="bi bi-pencil"></i> Ubah
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item modal_hapus_performer" data-id="'.$id_tindakan_performer.'">
                                    <i class="bi bi-trash"></i> Hapus
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                        <div class="row">
                            <div class="col-5"><small>Tipe Pelaksana</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-6"><small class="text-muted">'.$performer_type.'</small></div>
                        </div>
                        <div class="row">
                            <div class="col-5"><small>ID Practitioner</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-6"><small class="text-muted">'.$performer_ihs.'</small></div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                        <div class="row">
                            <div class="col-5"><small>No.NIK/KTP</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-6"><small class="text-muted">'.$performer_nik.'</small></div>
                        </div>
                        <div class="row">
                            <div class="col-5"><small>Catatan/Keterangan</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-6"><small class="text-muted">'.$performer_notes.'</small></div>
                        </div>
                    </div>
                </div>
            ';
            $no++;
        }
    }
?>