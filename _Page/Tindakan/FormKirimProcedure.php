<?php
    // Time Zone
    date_default_timezone_set('Asia/Jakarta');

    // Connection, Function And Session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // Validasi Session
    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger text-center">
                <small>Sesi akses sudah berakhir, silakan login ulang.</small>
            </div>
        ';
        exit;
    }

    // Validasi Method
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo '
            <div class="alert alert-danger text-center">
                <small>Metode request tidak valid.</small>
            </div>
        ';
        exit;
    }

    // ID Tindakan
    if (empty($_POST['id_tindakan'])) {
        echo '
            <div class="alert alert-danger text-center">
                <small>ID Praktisi tidak boleh kosong.</small>
            </div>
        ';
        exit;
    }

    // Variabel 'id_tindakan'
    $id_tindakan = (int) $_POST['id_tindakan'];

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
    //Formated
    $datetime_start_iso = date('Y-m-d\TH:i:sP', strtotime($datetime_start));
    $datetime_end_iso   = date('Y-m-d\TH:i:sP', strtotime($datetime_end));

    // REASON CODE
    $reson_reference = $Data['reson_reference'];
    $reson_code      = $Data['reson_code'];
    $reson_display   = $Data['reson_display'];

    // Keterangan
    $post_tindakan   = $Data['post_tindakan'];
    
?>
<input type="hidden" name="id_tindakan" value="<?php echo $id_tindakan; ?>">

<div class="row mb-2">
    <div class="col-12">
        <small><b>A. Tipe & Status (<i>Resource Type & Status</i>)</b></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4">
        <label for="resourceType"><small><i>Resource Type</i></small></label>
    </div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <input type="text" name="resourceType" id="resourceType" class="form-control" required value="Procedure">
    </div>
</div>
<div class="row mb-2">
    <div class="col-4">
        <label for="status"><small><i>Status</i></small></label>
    </div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <select name="status" id="status" class="form-control" required>
            <option value="preparation">Persiapan</option>
            <option value="in-progress">Sedang Dilakukan</option>
            <option selected value="completed">Selesai</option>
            <option value="stopped">Dihentikan</option>
            <option value="not-done">Tidak jadi dilakukan</option>
            <option value="entered-in-error">Salah Input</option>
            <option value="unknown">Tidak Diketahui</option>
        </select>
    </div>
</div>
<hr>

<div class="row mb-2">
    <div class="col-12">
        <small><b>B. Kategori Tindakan <i>(Category)</i></b></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4">
        <label for="category_coding_code"><small><i>Code</i></small></label>
    </div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <input type="text" name="category_coding_code" id="category_coding_code" class="form-control" required value="<?php echo $kategori_tindakan_code ; ?>" required>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4">
        <label for="category_coding_display"><small><i>Display</i></small></label>
    </div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <input type="text" name="category_coding_display" id="category_coding_display" class="form-control" value="<?php echo $kategori_tindakan_display ; ?>" required>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4">
        <label for="category_coding_text"><small><i>Text</i></small></label>
    </div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <input type="text" name="category_coding_text" id="category_coding_text" class="form-control" value="<?php echo $kategori_tindakan ; ?>" required>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4">
        <label for="category_coding_system"><small><i>System</i></small></label>
    </div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <input type="text" name="category_coding_system" id="category_coding_system" class="form-control" value="<?php echo $kategori_tindakan_system ; ?>" required>
    </div>
</div>
<hr>

<div class="row mb-2">
    <div class="col-12">
        <small><b>C. Jenis Tindakan <i>(Procedure)</i></b></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4">
        <label for="code_coding_code"><small><i>Code</i></small></label>
    </div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <input type="text" name="code_coding_code" id="code_coding_code" class="form-control" value="<?php echo $nama_tindakan_code ; ?>" required>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4">
        <label for="code_coding_display"><small><i>Display</i></small></label>
    </div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <input type="text" name="code_coding_display" id="code_coding_display" class="form-control" value="<?php echo $nama_tindakan_display ; ?>" required>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4">
        <label for="code_coding_text"><small><i>Text</i></small></label>
    </div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <input type="text" name="code_coding_text" id="code_coding_text" class="form-control" value="<?php echo $nama_tindakan ; ?>" required>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4">
        <label for="code_coding_system"><small><i>System</i></small></label>
    </div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <input type="text" name="code_coding_system" id="code_coding_system" class="form-control" value="<?php echo $nama_tindakan_system ; ?>" required>
    </div>
</div>
<hr>

<div class="row mb-2">
    <div class="col-12">
        <small><b>D. Informasi Pasien <i>(Subject)</i></b></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4">
        <label for="subject_reference"><small><i>Subject Reference</i></small></label>
    </div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <input type="text" name="subject_reference" id="subject_reference" class="form-control" required value="<?php echo "$id_ihs" ; ?>">
    </div>
</div>
<div class="row mb-2">
    <div class="col-4">
        <label for="subject_display"><small><i>Subject Display</i></small></label>
    </div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <input type="text" name="subject_display" id="subject_display" class="form-control" required value="<?php echo "$nama" ; ?>">
    </div>
</div>
<hr>

<div class="row mb-2">
    <div class="col-12">
        <small><b>E. Kunjungan <i>(Encounter)</i></b></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4">
        <label for="encounter_reference"><small><i>Encounter Reference</i></small></label>
    </div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <input type="text" name="encounter_reference" id="encounter_reference" class="form-control" value="<?php echo "$id_encounter" ; ?>" required>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4">
        <label for="encounter_display"><small><i>Subject Display</i></small></label>
    </div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <input type="text" name="encounter_display" id="encounter_display" class="form-control" value="<?php echo "Kunjungan $nama pada tanggal $datetime_daftar" ; ?>" required>
    </div>
</div>
<hr>

<div class="row mb-2">
    <div class="col-12">
        <small><b>F. Periode Pelaksanaan <i>(Performed Period)</i></b></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4">
        <label for="performedPeriod_start"><small><i>Performed Period (Start)</i></small></label>
    </div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <input type="text" name="performedPeriod_start" id="performedPeriod_start" class="form-control" value="<?php echo "$datetime_start_iso" ; ?>" required>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4">
        <label for="performedPeriod_end"><small><i>Performed Period (End)</i></small></label>
    </div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <input type="text" name="performedPeriod_end" id="performedPeriod_end" class="form-control" value="<?php echo "$datetime_end_iso" ; ?>" required>
    </div>
</div>
<hr>

<div class="row mb-2">
    <div class="col-12">
        <small><b>G. Diagnosis Tindakan <i>(Reason Code)</i></b></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4">
        <label for="reasonCodeSystem"><small><i>System</i></small></label>
    </div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <input type="text" name="reasonCodeSystem" id="reasonCodeSystem" class="form-control" value="http://hl7.org/fhir/sid/icd-10">
    </div>
</div>
<div class="row mb-2">
    <div class="col-4">
        <label for="reasonCodeCode"><small><i>Code</i></small></label>
    </div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <input type="text" name="reasonCodeCode" id="reasonCodeCode" class="form-control" value="<?php echo "$reson_code" ; ?>">
    </div>
</div>
<div class="row mb-2">
    <div class="col-4">
        <label for="reasonCodeDisplay"><small><i>Display</i></small></label>
    </div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <input type="text" name="reasonCodeDisplay" id="reasonCodeDisplay" class="form-control" value="<?php echo "$reson_display" ; ?>">
    </div>
</div>
<hr>

<div class="row mb-2">
    <div class="col-12">
        <small><b>H. Lokasi Tubuh <i>(Body Site)</i></b></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4">
        <label for="bodySiteSystem"><small><i>System</i></small></label>
    </div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <input type="text" name="bodySiteSystem" id="bodySiteSystem" class="form-control" value="<?php echo "$lokasi_tubuh_system" ; ?>">
    </div>
</div>
<div class="row mb-2">
    <div class="col-4">
        <label for="bodySiteCode"><small><i>Code</i></small></label>
    </div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <input type="text" name="bodySiteCode" id="bodySiteCode" class="form-control" value="<?php echo "$lokasi_tubuh_code" ; ?>">
    </div>
</div>
<div class="row mb-2">
    <div class="col-4">
        <label for="bodySiteDisplay"><small><i>Display</i></small></label>
    </div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <input type="text" name="bodySiteDisplay" id="bodySiteDisplay" class="form-control" value="<?php echo "$lokasi_tubuh_display" ; ?>">
    </div>
</div>
<hr>

<div class="row mb-2">
    <div class="col-12">
        <small><b>I. Pelaksana <i>(Performer)</i></b></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-12">
        <div class="table table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <td class="text-center"><small><b>No</b></small></td>
                        <td class="text-center"><small><b>ID Practitioner</b></small></td>
                        <td class="text-center"><small><b>Nama</b></small></td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // DATA PERFORMER
                        $SqlPerformer = "SELECT * FROM tindakan_performer WHERE id_tindakan = ?";
                        $stmt_performer = $Conn->prepare($SqlPerformer);
                        $stmt_performer->bind_param("i", $id_tindakan);
                        $stmt_performer->execute();
                        $result_performer = $stmt_performer->get_result();
                        $jumlah_performer = $result_performer->num_rows;

                        // Jika Kosong
                        if(empty($jumlah_performer)){
                            echo '
                                <tr>
                                    <td colspan="3" class="text-center">
                                        <small class="text-danger">Belum Ada data Pelaksana Untuk Tindakan Ini</small>
                                    </td>
                                </tr>
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

                                echo '
                                    <tr>
                                        <td class="text-center"><small>'.$no.'</small></td>
                                        <td><input type="text" class="form-control" name="performer_reference[]" value="Practitioner/'.$performer_ihs.'"></td>
                                        <td><input type="text" class="form-control" name="performer_display[]" value="'.$performer_nama.'"></td>
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

<div class="row mb-2">
    <div class="col-12">
        <label for="">
            <small><b>K. Keterangan Post Tindakan</b></small>
        </label>
        <textarea name="note_text" id="note_text" class="form-control"><?php echo $post_tindakan; ?></textarea>
    </div>
</div>
