<?php
    date_default_timezone_set('Asia/Jakarta');

    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // Validasi session
    if (empty($SessionIdAkses)) {
        echo '<div class="alert alert-danger text-center">Sesi akses berakhir.</div>';
        exit;
    }

    // Validasi ID
    if (empty($_POST['id_jadwal'])) {
        echo '<div class="alert alert-danger text-center">ID jadwal tidak valid.</div>';
        exit;
    }

    $id_jadwal = (int) $_POST['id_jadwal'];

    // Ambil data utama
    $query = "SELECT * FROM jadwal_dokter WHERE id_jadwal = ?";
    $stmt = mysqli_prepare($Conn, $query);

    if (!$stmt) {
        echo '<div class="alert alert-danger text-center">Gagal memproses data.</div>';
        exit;
    }

    mysqli_stmt_bind_param($stmt, "i", $id_jadwal);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 0) {
        echo '<div class="alert alert-danger text-center">Data tidak ditemukan.</div>';
        exit;
    }

    $data = mysqli_fetch_assoc($result);

    $id_dokter     = $data['id_dokter'];
    $id_poliklinik = $data['id_poliklinik'];
    $hari          = $data['hari'];
    $jam_mulai     = $data['jam_mulai'];
    $jam_selesai   = $data['jam_selesai'];
    $kuota_jkn     = $data['kuota_jkn'];
    $kuota_non_jkn = $data['kuota_non_jkn'];
    $time_max      = $data['time_max'];
    $status        = $data['status'];

    if(empty($status)){
        $label_status = '<span class="px-1 py-1 bg-secondary-subtle text-secondary rounded-1" title="No Active"><small>No Active</small></span>';
    }else{
        $label_status = '<span class="px-1 py-1 bg-success-subtle text-success rounded-1" title="Active"><small>Active</small></span>';
    }

    // Ambil relasi
    $nama_dokter = getDataDetail_v2($Conn, 'dokter', 'id_dokter', $id_dokter, 'nama');
    $poliklinik  = getDataDetail_v2($Conn, 'poliklinik', 'id_poliklinik', $id_poliklinik, 'poliklinik');

    mysqli_stmt_close($stmt);
?>

<div class="row mb-2">
    <div class="col-4"><small>Dokter</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text text-muted"><?php echo $nama_dokter; ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Poliklinik</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text text-muted"><?php echo $poliklinik; ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Jam Mulai</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text text-muted"><?php echo $jam_mulai; ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Jam Selesai</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text text-muted"><?php echo $jam_selesai; ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Kuota BPJS</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text text-muted"><?php echo $kuota_jkn ?: 0; ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Kuota Umum</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><small class="text text-muted"><?php echo $kuota_non_jkn ?: 0; ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Batas Pendaftaran</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text text-muted">
            <?php
                if ($time_max >= 1440) {
                    echo ($time_max / 1440) . " Hari";
                } elseif ($time_max >= 60) {
                    echo ($time_max / 60) . " Jam";
                } else {
                    echo $time_max . " Menit";
                }
            ?>
        </small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Status</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7"><?php echo $label_status; ?></div>
</div>
