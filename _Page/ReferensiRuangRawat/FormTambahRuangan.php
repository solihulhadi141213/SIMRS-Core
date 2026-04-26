<?php
     // Zona Waktu
    date_default_timezone_set('Asia/Jakarta');

    // Koneksi Function dan Session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    
    // Tangkap Data
    if(empty($_POST['id_kelas_rawat'])){
        echo '
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-danger text-center">
                        <small>Silahkan Pilih ID Kelas Terlebih Dulu!</small>
                    </div>
                </div>
            </div>
        ';
        exit;
    }

    // Buat Variabel Dan Sanitasi
    $id_kelas_rawat = validateAndSanitizeInput($_POST['id_kelas_rawat']);
?>

<!-- ID Kelas Rawat -->
 <input type="hidden" name="id_kelas_rawat" id="id_kelas_rawat" value="<?php echo $id_kelas_rawat; ?>">

 <!-- Nama Ruangan -->
<div class="row mb-3">
    <div class="col-12">
        <label for="nama_ruangan"><small>Nama Ruangan</small></label>
        <input type="text" id="nama_ruangan" name="nama_ruangan" class="form-control" required>
    </div>
</div>

<!-- Status -->
<div class="row mb-3">
    <div class="col-12">
        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" id="status_ruangan" name="status" value="1" checked="">
            <label class="form-check-label" for="status_ruangan">
                <small>Status Ruangan Aktif</small>
            </label>
        </div>
    </div>
</div>