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
                        <small>Silahkan Pilih ID Ruangan Terlebih Dulu!</small>
                    </div>
                </div>
            </div>
        ';
        exit;
    }

    // Buat Variabel Dan Sanitasi
    $id_ruang_rawat = validateAndSanitizeInput($_POST['id_ruang_rawat']);

    // Buka dtaa Ruangan Dengan Prepared Statment
    $stmt = $Conn->prepare("SELECT * FROM rr_ruang_rawat WHERE id_ruang_rawat = ?");
    $stmt->bind_param("i", $id_ruang_rawat);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo '
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-danger text-center">
                        <small>Data Kelas Yang Anda Pilih Tidak Ditemukan Pada Database!</small>
                    </div>
                </div>
            </div>
        ';
        exit;
    }

    // Tampilkan Data Dan Buat Variabelnya
    $Data           = $result->fetch_assoc();
    $id_kelas_rawat = $Data['id_kelas_rawat'];
    $ruang_rawat    = $Data['ruang_rawat'];
    $updatetime     = $Data['updatetime'];
    $status         = $Data['status'];

    // Routing Label Status
    if(!empty($status)){
        $label_status = "checked";
    }else{
        $label_status = "";
    }

    // Tutup Statment
    $stmt->close();
?>

<!-- ID Kelas Rawat -->
 <input type="hidden" name="id_ruang_rawat" id="id_ruang_rawat" value="<?php echo $id_ruang_rawat; ?>">
 <input type="hidden" name="id_kelas_rawat" id="id_kelas_rawat" value="<?php echo $id_kelas_rawat; ?>">

 <!-- Nama Ruangan -->
<div class="row mb-3">
    <div class="col-12">
        <label for="nama_ruangan_edit"><small>Nama Ruangan</small></label>
        <input type="text" id="nama_ruangan_edit" name="nama_ruangan" class="form-control" value="<?php echo $ruang_rawat;  ?>" required>
    </div>
</div>

<!-- Status -->
<div class="row mb-3">
    <div class="col-12">
        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" id="status_ruangan_edit" name="status" value="1" <?php echo  $label_status; ?> >
            <label class="form-check-label" for="status_ruangan_edit">
                <small>Status Ruangan Aktif</small>
            </label>
        </div>
    </div>
</div>