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
<div class="row mb-2 mt-3">
    <div class="col-12">
        <small><b>A. Informasi Pasien</b></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>ID Pasien (RM)</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo $id_pasien; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>ID IHS</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo $id_ihs; ?></small>
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
    <div class="col-4"><small>Gender</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo $gender; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>ID Kunjungan</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo $id_kunjungan; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>ID Encounter</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo $id_encounter; ?></small>
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

<div class="row mb-2">
    <div class="col-12">
        <small><b>B. Metadata Tindakan</b></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>ID Tindakan</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo $id_tindakan; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><small><i>ID Procedure (SATUSEHAT)</i></small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo $id_procedure; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Tanggal & Waktu (<i>Entry</i>)</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo $datetime_creat; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Tanggal & Waktu (<i>Update</i>)</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo $datetime_update; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Petugas (<i>Entry</i>)</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo $petugas_nama; ?></small>
    </div>
</div>

<div class="row mt-3 mb-2">
    <div class="col-12">
        <small><b>C. Kategori Tindakan</b></small>
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
    <div class="col-4"><small><i>Code & Display</i></small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo "$kategori_tindakan_code - $kategori_tindakan_display"; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><small><i>System</i></small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo $kategori_tindakan_system; ?></small>
    </div>
</div>

<div class="row mt-3 mb-2">
    <div class="col-12">
        <small><b>D. Nama/Jenis Tindakan</b></small>
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
    <div class="col-4"><small><i>Code & Display</i></small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo "$nama_tindakan_code - $nama_tindakan_display"; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><small><i>System</i></small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo $nama_tindakan_system; ?></small>
    </div>
</div>

<div class="row mt-3 mb-2">
    <div class="col-12">
        <small><b>E. Lokasi Tubuh (<i>Body Site</i>)</b></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Lokasi Tubuh</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo $lokasi_tubuh; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><small><i>Code & Display</i></small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo "$lokasi_tubuh_code - $lokasi_tubuh_display"; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><small><i>System</i></small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo $lokasi_tubuh_system; ?></small>
    </div>
</div>

<div class="row mt-3 mb-2">
    <div class="col-12">
        <small><b>F. ICD9 (<i>Procedure</i>)</b></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><small><i>Code</i></small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo "$icd9_code"; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><small><i>Description</i></small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo $icd9_description; ?></small>
    </div>
</div>

<div class="row mt-3 mb-2">
    <div class="col-12">
        <small><b>G. Waktu Pelaksanaan</b></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Tanggal & Jam Mulai</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo "$datetime_start"; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Tanggal & Jam Selesai</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo $datetime_end; ?></small>
    </div>
</div>

<div class="row mt-3 mb-2">
    <div class="col-12">
        <small><b>H. Alasan Tindakan (<i>Reason Code</i>)</b></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Referensi</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo "$reson_reference"; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><small><i>Code</i></small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo $reson_code; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><small><i>Display</i></small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo $reson_display; ?></small>
    </div>
</div>

<div class="row mt-3 mb-2">
    <div class="col-12">
        <small><b>I. Keterangan (Post Tindakan)</b></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Keterangan</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo "$post_tindakan"; ?></small>
    </div>
</div>

<div class="row mt-3 mb-2">
    <div class="col-12">
        <small><b>I. Pelaksana (Performer)</b></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-12">
        <div class="table table-responsive">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <td class="text-center"><small><b>No</b></small></td>
                        <td class="text-left"><small><b><i>Type</i></b></small></td>
                        <td class="text-left"><small><b>Nama</b></small></td>
                        <td class="text-left"><small><b>Catatan</b></small></td>
                    </tr>
                </thead>
                <tbody>
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
                                <tr>
                                    <td colspan="4" class="text-center"><small class="text-danger">Belum Ada Performer</small></td>
                                </tr>
                            ';
                        }else{
                            $no = 1;
                            while($Performer = $result_performer->fetch_assoc()) {
                                echo '
                                    <tr>
                                        <td class="text-center"><small class="text-muted">'.$no.'</small></td>
                                        <td class="text-left"><small class="text-muted">'.$Performer['performer_type'].'</small></td>
                                        <td class="text-left"><small class="text-muted">'.$Performer['performer_nama'].'</small></td>
                                        <td class="text-left"><small class="text-muted">'.$Performer['performer_notes'].'</small></td>
                                    </tr>
                                ';
                                $no++;
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>