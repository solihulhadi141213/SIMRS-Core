<?php
    // Connection, Function & Session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    function safeEditValue($value) {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }

    // VALIDASI SESSION
    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger">
                <small>Sesi akses sudah berakhir! Silahkan login ulang.</small>
            </div>
        ';
        exit;
    }

    // VALIDASI id_tindakan_referensi
    if (empty($_POST['id_tindakan_referensi'])) {
        echo '
            <div class="alert alert-danger">
                <small>ID Referensi Tindakan tidak boleh kosong!</small>
            </div>
        ';
        exit;
    }

    // SANITASI INPUT
    $id_tindakan_referensi = validateAndSanitizeInput($_POST['id_tindakan_referensi']);

    // Buka Data Referensi Tindakan
    $sql  = "SELECT * FROM tindakan_referensi WHERE id_tindakan_referensi = ?";
    $stmt = $Conn->prepare($sql);
    $stmt->bind_param("i", $id_tindakan_referensi);
    $stmt->execute();
    $result = $stmt->get_result();
    $Data   = $result->fetch_assoc();

    if (empty($Data)) {
        echo '
            <div class="alert alert-danger">
                <small>Data Referensi Tindakan Tidak Ditemukan!</small>
            </div>
        ';
        exit;
    }

    // Tutup Statment
     $stmt->close();

    // MAPPING DATA
    $id_tindakan_referensi     = $Data['id_tindakan_referensi'] ?? null;
    $kategori_tindakan         = $Data['kategori_tindakan'] ?? '-';
    $kategori_tindakan_code    = $Data['kategori_tindakan_code'] ?? '-';
    $kategori_tindakan_display = $Data['kategori_tindakan_display'] ?? '-';
    $kategori_tindakan_system  = $Data['kategori_tindakan_system'] ?? '-';
    $nama_tindakan             = $Data['nama_tindakan'] ?? '-';
    $nama_tindakan_code        = $Data['nama_tindakan_code'] ?? '-';
    $nama_tindakan_display     = $Data['nama_tindakan_display'] ?? '-';
    $nama_tindakan_system      = $Data['nama_tindakan_system'] ?? '-';
    $lokasi_tubuh              = $Data['lokasi_tubuh'] ?? '-';
    $lokasi_tubuh_code         = $Data['lokasi_tubuh_code'] ?? '-';
    $lokasi_tubuh_display      = $Data['lokasi_tubuh_display'] ?? '-';
    $lokasi_tubuh_system       = $Data['lokasi_tubuh_system'] ?? '-';
    $icd9_code                 = $Data['icd9_code'] ?? '-';
    $icd9_description          = $Data['icd9_description'] ?? '-';
    $status                    = $Data['status'] ?? '-';
    $datetime_creat            = $Data['datetime_creat'] ?? '-';
    $author_id                 = $Data['author_id'] ?? '-';
    $author_name               = $Data['author_name'] ?? '-';

?>

<input type="hidden" name="id_tindakan_referensi" value="<?php echo safeEditValue($id_tindakan_referensi); ?>">

<div class="form_kategori_tindakan_edit mb-3">
    <div class="row mb-2">
        <div class="col-12">
            <small><b>A. Kategori Tindakan</b></small>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-5"><label for="kategori_tindakan_edit"><small>Kategori Tindakan</small></label></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-6">
            <select name="kategori_tindakan" id="kategori_tindakan_edit" class="form-control" required>
                <option selected value="<?php echo safeEditValue($kategori_tindakan); ?>"><?php echo safeEditValue($kategori_tindakan); ?></option>
            </select>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-5"><label for="kategori_tindakan_code_edit"><small><i>Code</i></small></label></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-6">
            <input type="text" name="kategori_tindakan_code" id="kategori_tindakan_code_edit" class="form-control" value="<?php echo safeEditValue($kategori_tindakan_code); ?>">
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-5"><label for="kategori_tindakan_display_edit"><small><i>Display</i></small></label></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-6">
            <input type="text" name="kategori_tindakan_display" id="kategori_tindakan_display_edit" class="form-control" value="<?php echo safeEditValue($kategori_tindakan_display); ?>">
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-5"><label for="kategori_tindakan_system_edit"><small><i>System</i></small></label></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-6">
            <input type="text" name="kategori_tindakan_system" id="kategori_tindakan_system_edit" class="form-control" value="<?php echo safeEditValue($kategori_tindakan_system); ?>">
        </div>
    </div>
</div>

<div class="form_jenis_tindakan mb-3">
    <div class="row mb-2">
        <div class="col-12">
            <small><b>B. Nama/Jenis Tindakan</b></small>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-5"><label for="nama_tindakan_edit"><small>Nama Tindakan</small></label></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-6">
            <input type="text" name="nama_tindakan" id="nama_tindakan_edit" class="form-control" value="<?php echo safeEditValue($nama_tindakan); ?>" required>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-5"><label for="nama_tindakan_code_edit"><small><i>Code</i></small></label></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-6">
            <input type="text" name="nama_tindakan_code" id="nama_tindakan_code_edit" value="<?php echo safeEditValue($nama_tindakan_code); ?>" class="form-control">
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-5"><label for="nama_tindakan_display_edit"><small><i>Display</i></small></label></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-6">
            <input type="text" name="nama_tindakan_display" id="nama_tindakan_display_edit" value="<?php echo safeEditValue($nama_tindakan_display); ?>" class="form-control">
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-5"><label for="nama_tindakan_system_edit"><small><i>System</i></small></label></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-6">
            <input type="text" name="nama_tindakan_system" id="nama_tindakan_system_edit" class="form-control" value="<?php echo safeEditValue($nama_tindakan_system); ?>">
        </div>
    </div>
</div>

<div class="form_lokasi_tubuh mb-3">
    <div class="row mb-2">
        <div class="col-12">
            <small><b>C. Lokasi Tubuh (<i>Body Site</i>)</b></small>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-5"><label for="lokasi_tubuh_edit"><small>Nama Lokasi Tubuh (<i>Body Site</i>)</small></label></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-6">
            <select name="lokasi_tubuh" id="lokasi_tubuh_edit" class="form-control" required>
                <option selected value="<?php echo safeEditValue($lokasi_tubuh); ?>"><?php echo safeEditValue($lokasi_tubuh); ?></option>
            </select>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-5"><label for="lokasi_tubuh_code_edit"><small><i>Code</i></small></label></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-6">
            <input type="text" name="lokasi_tubuh_code" id="lokasi_tubuh_code_edit" class="form-control" value="<?php echo safeEditValue($lokasi_tubuh_code); ?>">
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-5"><label for="lokasi_tubuh_display_edit"><small><i>Display</i></small></label></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-6">
            <input type="text" name="lokasi_tubuh_display" id="lokasi_tubuh_display_edit" class="form-control" value="<?php echo safeEditValue($lokasi_tubuh_display); ?>">
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-5"><label for="lokasi_tubuh_system_edit"><small><i>System</i></small></label></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-6">
            <input type="text" name="lokasi_tubuh_system" id="lokasi_tubuh_system_edit" class="form-control" value="<?php echo safeEditValue($lokasi_tubuh_system); ?>">
        </div>
    </div>
</div>

<div class="form_icd9 mb-3">
    <div class="row mb-2">
        <div class="col-12">
            <small><b>D. ICD9</b></small>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-5"><label for="icd9_code_edit"><small>ICD9 Code</small></label></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-6">
            <select name="icd9_code" id="icd9_code_edit" class="form-control" required>
                <option selected value="<?php echo safeEditValue($icd9_code); ?>"><?php echo safeEditValue($icd9_code); ?></option>
            </select>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-5"><label for="icd9_description_edit"><small><i>ICD9 Description</i></small></label></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-6">
            <input type="text" name="icd9_description" id="icd9_description_edit" class="form-control" value="<?php echo safeEditValue($icd9_description); ?>">
        </div>
    </div>
</div>
