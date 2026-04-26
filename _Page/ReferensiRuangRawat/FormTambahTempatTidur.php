<?php
     // Zona Waktu
    date_default_timezone_set('Asia/Jakarta');

    // Koneksi Function dan Session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    
    // Tangkap Data
    if(empty($_POST['id_ruang_rawat'])){
        echo '
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-danger text-center">
                        <small>ID Ruang Rawat Tidak Boleh Kosong!</small>
                    </div>
                </div>
            </div>
        ';
        exit;
    }

    // Buat Variabel Dan Sanitasi
    $id_ruang_rawat = validateAndSanitizeInput($_POST['id_ruang_rawat']);
?>

<!-- ID Kelas Rawat -->
 <input type="hidden" name="id_ruang_rawat" id="id_ruang_rawat" value="<?php echo $id_ruang_rawat; ?>">

<!-- Nama Tempat Tidur -->
<div class="row mb-3">
    <div class="col-12">
        <label for="tempat_tidur"><small>Nama/Kode Tempat Tidur</small></label>
        <input type="text" id="tempat_tidur" name="tempat_tidur" class="form-control" required>
        <small class="text text-muted">Gunakan Nama / Kode Tempat Tidur Yang Unik</small>
    </div>
</div>

<!-- Kategori Tempat Tidur -->
<div class="row mb-3">
    <div class="col-12">
        <label for=""><small>Kategori Tempat Tidur</small></label>
        <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="kategori_tempat_tidur" id="pria" value="pria">
            <label for="pria"><small>Pria</small></label>
        </div>
        <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="kategori_tempat_tidur" id="wanita" value="wanita">
            <label for="wanita"><small>Wanita</small></label>
        </div>
        <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="kategori_tempat_tidur" id="bebas" value="bebas">
            <label for="bebas"><small>Bebas</small></label>
        </div>
    </div>
</div>

<!-- Status -->
<div class="row mb-3">
    <div class="col-12">
        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" id="status_tempat_tidur" name="status" value="1" checked="">
            <label class="form-check-label" for="status_tempat_tidur">
                <small>Status Tempat Tidur Aktif</small>
            </label>
        </div>
    </div>
</div>