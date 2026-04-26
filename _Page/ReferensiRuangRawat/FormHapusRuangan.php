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
    $label_status = ($status == 1)
            ? '<span class="px-2 py-2 bg-success-subtle rounded-1" title="Active"><i  class="bi bi-check"></i></span>'
            : '<span class="px-2 py-2 bg-secondary-subtle rounded-1" title="No Active"><i  class="bi bi-check"></i></span>';

    // Tutup Statment
    $stmt->close();
?>

<!-- ID Kelas Rawat -->
 <input type="hidden" name="id_ruang_rawat" id="id_ruang_rawat" value="<?php echo $id_ruang_rawat; ?>">
 <input type="hidden" name="id_kelas_rawat" id="id_kelas_rawat" value="<?php echo $id_kelas_rawat; ?>">

<!-- Nama Ruangan -->
<div class="row mb-3">
    <div class="col-4"><small>Nama Ruangan</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text text-muted"><?php echo  $ruang_rawat; ?></small></div>
</div>

<!-- Updatetime -->
<div class="row mb-3">
    <div class="col-4"><small>Updatetime</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text text-muted"><?php echo  $updatetime; ?></small></div>
</div>

<!-- Status -->
<div class="row mb-3">
    <div class="col-4"><small>Status</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text text-muted"><?php echo  $label_status; ?></small></div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <div class="alert alert-danger text-center">
            <small>Apakah anda yakin akan menghapus data ruangan tersebut?</small>
        </div>
    </div>
</div>
