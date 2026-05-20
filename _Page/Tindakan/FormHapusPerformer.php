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

    // VALIDASI 'id_tindakan_performer'
    if (empty($_POST['id_tindakan_performer'])) {
        echo '
            <div class="alert alert-danger">
                <small>ID Performer tidak boleh kosong!</small>
            </div>
        ';
        exit;
    }

    // SANITASI INPUT
    $id_tindakan_performer = validateAndSanitizeInput($_POST['id_tindakan_performer']);

    // DETAIL KUNJUNGAN & PASIEN
    $sql = "SELECT * FROM tindakan_performer WHERE id_tindakan_performer = ?";
    $stmt = $Conn->prepare($sql);
    $stmt->bind_param("i", $id_tindakan_performer);
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
    $id_tindakan_performer = $Data['id_tindakan_performer'];
    $id_praktisi           = $Data['id_praktisi'];
    $performer_type        = $Data['performer_type'];
    $performer_nama        = $Data['performer_nama'];
    $performer_ihs         = $Data['performer_ihs'];
    $performer_nik         = $Data['performer_nik'];
    $performer_notes       = $Data['performer_notes'];

    // Close
    $stmt->close();

    echo '
        <div class="row mb-2">
            <div class="col-4"><small>Nama Pelaksana</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">'.$performer_nama.'</small>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-4"><small>Tipe Pelaksana</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">'.$performer_type.'</small>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-4"><small>ID Practitioner</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">'.$performer_ihs.'</small>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-4"><small>NIK</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">'.$performer_nik.'</small>
            </div>
        </div>
    ';
?>
<input type="hidden" name="id_tindakan_performer" value="<?php echo $id_tindakan_performer; ?>">
<div class="row">
    <div class="col-12">
        <div class="alert alert-danger text-center">
            <small>
                <b>PENTING!!</b><br>
                Apakah Anda Yakin Akan Menghapus Data Pelaksana Tindakan Tersebut?
            </small>
        </div>
    </div>
</div>