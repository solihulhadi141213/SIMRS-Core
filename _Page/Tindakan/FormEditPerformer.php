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

    // Performer type selected
    $performer_type_selected_1 = "";
    $performer_type_selected_2 = "";
    if($performer_type=="Utama"){
        $performer_type_selected_1 = "selected";
        $performer_type_selected_2 = "";
    }
    if($performer_type=="Pendamping"){
        $performer_type_selected_1 = "";
        $performer_type_selected_2 = "selected";
    }
?>
<input type="hidden" name="id_tindakan_performer" value="<?php echo $id_tindakan_performer; ?>">

<div class="row mb-3">
    <div class="col-12">
        <label for="performer_type_edit">
            <small>*Tipe Pelaksana</small>
        </label>
        <select name="performer_type" id="performer_type_edit" class="form-control" required>
            <option value="">Pilih</option>
            <option <?php echo $performer_type_selected_1; ?> value="Utama">Utama</option>
            <option <?php echo $performer_type_selected_2; ?> value="Pendamping">Pendamping</option>
        </select>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12" id="PilihPraktisiEdit">
        <label for="id_praktisi_edit">
            <small>Pilih Pelaksana (<i>Performer</i>)</small>
        </label>
        <select name="id_praktisi" id="id_praktisi_edit" class="form-select">
            <?php
                if(!empty($Data['id_praktisi'])){
                    echo '<option selected value="'.$id_praktisi.'">'.$performer_nama.'</option>';
                }
            ?>
            <option value="">Pilih</option>
        </select>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="performer_nama_edit">
            <small>Nama Lengkap</small>
        </label>
        <input type="text" name="performer_nama" id="performer_nama_edit" class="form-control" value="<?php echo $performer_nama; ?>">
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="performer_ihs_edit">
            <small>ID IHS (SATUSEHAT)</small>
        </label>
        <input type="text" name="performer_ihs" id="performer_ihs_edit" class="form-control" value="<?php echo $performer_ihs; ?>">
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="performer_nik_edit">
            <small>Nomor NIK / KTP</small>
        </label>
        <input type="text" name="performer_nik" id="performer_nik_edit" class="form-control" value="<?php echo $performer_nik; ?>">
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="performer_notes_edit">
            <small>Catatan Dari Pelaksana</small>
        </label>
        <textarea name="performer_notes" id="performer_notes_edit" class="form-control"><?php echo $performer_notes; ?></textarea>
    </div>
</div>