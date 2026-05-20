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

            tr.id_tindakan_referensi,
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

    // TINDAKAN REFERENSI
    $id_tindakan_referensi = $Data['id_tindakan_referensi'];
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

    // Routing radiobutton
    $radio_reson_1 = ''; 
    $radio_reson_2 = ''; 
    if($Data['reson_reference']=='ICD10'){
        $radio_reson_1 = 'checked'; 
        $radio_reson_2 = ''; 
    }
    if($Data['reson_reference']=='ICD11'){
        $radio_reson_1 = ''; 
        $radio_reson_2 = 'checked'; 
    }

    // Keterangan
    $post_tindakan   = $Data['post_tindakan'];

    // Routing Data Kosong
    if(empty($id_encounter)){
        $id_encounter = '-';
    }
?>
<input type="hidden" name="id_tindakan" value="<?php echo $id_tindakan; ?>">
<div class="row mb-2">
    <div class="col-12">
        <small>
            <b>A. Informasi Tindakan</b>
        </small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-12" id="form_tindakan_referensi_edit">
        <label for="id_tindakan_referensi_edit"><small>Cari Data Tindakan</small></label>
        <select name="id_tindakan_referensi" id="id_tindakan_referensi_edit"  class="form-select">
            <option value="">Pilih</option>
            <?php
                echo '<option selected value="'.$id_tindakan_referensi.'">'.$nama_tindakan.'</option>';
            ?>
        </select>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-12">
        <label for="kategori_tindakan_edit"><small>Kategori <i>(Category Code System)</i></small></label>
        <input type="text" name="kategori_tindakan" id="kategori_tindakan_edit" class="form-control" value="<?php echo $kategori_tindakan; ?>">
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="nama_tindakan_edit"><small>Nama / Jenis <i>(Procedure)</i></small></label>
        <input type="text" name="nama_tindakan" id="nama_tindakan_edit" class="form-control" value="<?php echo $nama_tindakan; ?>">
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="lokasi_tubuh_edit"><small>Lokasi Tubuh <i>(Body Site)</i></small></label>
        <input type="text" name="lokasi_tubuh" id="lokasi_tubuh_edit" class="form-control" value="<?php echo $lokasi_tubuh; ?>">
    </div>
</div>

<div class="row mb-3">
    <div class="col-12" id="form_icd9_code">
        <label for="icd9_code_edit"><small>Referensi ICD 9</small></label>
        <input type="hidden" name="icd9_description" id="icd9_description_edit" value="<?php echo $icd9_description; ?>">
        <select name="icd9_code" id="icd9_code_edit" class="form-select">
            <option value="">Pilih</option>
            <?php
                if(!empty($Data['icd9_code'])){
                    echo '<option selected value="'.$icd9_code.'">'.$icd9_code.'-'.$icd9_description.'</option>';
                }
            ?>
        </select>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="date_start_edit"><small>Waktu Mulai Tindakan</small></label>
        <div class="input-group">
            <input type="date" name="date_start" id="date_start_edit" class="form-control" value="<?php echo date('Y-m-d', strtotime($datetime_start)); ?>">
            <input type="time" name="time_start" id="time_start_edit" class="form-control" value="<?php echo date('H:i', strtotime($datetime_start)); ?>">
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="date_end_edit"><small>Waktu Selesai Tindakan</small></label>
        <div class="input-group">
            <input type="date" name="date_end" id="date_end_edit" class="form-control" value="<?php echo date('Y-m-d', strtotime($datetime_end)); ?>">
            <input type="time" name="time_end" id="time_end_edit" class="form-control" value="<?php echo date('H:i', strtotime($datetime_end)); ?>">
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12" id="form_reson_code_edit">
        <label for="reson_code_edit">
            <small>Diagnosis / Alasan Pemberian Tindakan <i>(Reason Code)</i></small>
        </label>
        <input type="hidden" name="reson_display" id="reson_display_edit" value="<?php echo $reson_display; ?>">
        <select name="reson_code" id="reson_code_edit" class="form-select">
            <option value="">Pilih</option>
            <?php
                if(!empty($Data['reson_code'])){
                    echo '<option selected value="'.$reson_code.'">'.$reson_code.'-'.$reson_display.'</option>';
                }
            ?>
        </select>
        <div class="d-flex flex-wrap gap-3 mb-4">
            <div class="form-check form-check-inline">
                <input class="form-check-input" <?php echo $radio_reson_1; ?> type="radio" name="reson_reference" id="reson_reference_edit_icd10" value="ICD10" checked="">
                <label class="form-check-label" for="reson_reference_edit_icd10">
                    <small>ICD 10</small>
                </label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" <?php echo $radio_reson_2; ?> type="radio" name="reson_reference" id="reson_reference_edit_icd11" value="ICD11">
                <label class="form-check-label" for="reson_reference_edit_icd11">
                    <small>ICD 11</small>
                </label>
            </div>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="post_tindakan_edit"><small>Keterangan (Post Tindakan)</small></label>
        <textarea name="post_tindakan" id="post_tindakan_edit" class="form-control" ><?php echo $post_tindakan; ?></textarea>
    </div>
</div>