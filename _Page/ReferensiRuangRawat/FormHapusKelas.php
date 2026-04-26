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
    $updatetime = $Data['updatetime'];
    $status     = $Data['status'];

    // Routing Label Status
    $label_status = ($status == 1)
            ? '<span class="px-2 py-2 bg-success-subtle rounded-1" title="Active"><i  class="bi bi-check"></i> Active</span>'
            : '<span class="px-2 py-2 bg-secondary-subtle rounded-1" title="No Active"><i  class="bi bi-check"></i> No Active</span>';

    // Tutup Statment
    $stmt->close();
?>

<!-- ID Kelas Rawat -->
 <input type="hidden" name="id_kelas_rawat" id="id_kelas_rawat" value="<?php echo $id_kelas_rawat; ?>">

<!-- Kode Kelas -->
<div class="row mb-3">
    <div class="col-4"><small>Kode Kelas</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text text-muted"><?php echo  $kode_kelas; ?></small></div>
</div>

<!-- Nama Kelas -->
<div class="row mb-3">
    <div class="col-4"><small>Nama Kelas</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text text-muted"><?php echo  $kelas; ?></small></div>
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

<div class="row">
    <div class="col-12">
        <div class="alert alert-danger text-center">
            <small>
                <b>PENTING!</b><br>
                Menghapus kelas rawat inap, akan menghapus ruangan dan tempat tidur yang ada didalamnya.<br>
                <b>Apakah anda yakin akan menghapus data kelas tersebut?</b>
            </small>
        </div>
    </div>
</div>
