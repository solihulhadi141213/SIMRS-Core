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
                        <small>ID Kelas Tidak Boleh Kosong!</small>
                    </div>
                </div>
            </div>
        ';
        exit;
    }

    // Buat Variabel Dan Sanitasi
    $id_kelas_rawat = validateAndSanitizeInput($_POST['id_kelas_rawat']);

    // Buka dtaa Ruangan Dengan Prepared Statment
    $stmt = $Conn->prepare("SELECT * FROM rr_kelas_rawat WHERE id_kelas_rawat = ?");
    $stmt->bind_param("i", $id_kelas_rawat);
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
    $Data       = $result->fetch_assoc();
    $kode_kelas = $Data['kode_kelas'];
    $kelas      = $Data['kelas'];
    $status     = $Data['status'];
    $updatetime = $Data['updatetime'];

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
 <input type="hidden" name="id_kelas_rawat" id="id_kelas_rawat" value="<?php echo $id_kelas_rawat; ?>">

<!-- Kode Kelas -->
<div class="row mb-3">
    <div class="col-12">
        <label for="kode_kelas_edit"><small>Kode Kelas</small></label>
        <select 
            name="kode_kelas" 
            id="kode_kelas_edit" 
            class="form-control"
            data-value="<?php echo $kode_kelas; ?>"
            data-text="<?php echo $kode_kelas; ?>"
            required>
        </select>
    </div>
</div>

<!-- Kelas -->
<div class="row mb-3">
    <div class="col-12">
        <label for="kelas_edit"><small>Kelas</small></label>
        <input type="text" id="kelas_edit" name="kelas" class="form-control" value="<?php echo $kelas; ?>" required>
    </div>
</div>

<!-- Status -->
<div class="row mb-3">
    <div class="col-12">
        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" id="status_edit" name="status" value="1" <?php echo $label_status; ?> >
            <label class="form-check-label" for="status_edit">
                <small>Status Kelas Aktif</small>
            </label>
        </div>
    </div>
</div>