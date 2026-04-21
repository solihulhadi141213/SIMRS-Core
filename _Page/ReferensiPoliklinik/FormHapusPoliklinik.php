<?php
    date_default_timezone_set('Asia/Jakarta');

    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger text-center">
                <small>Sesi akses sudah berakhir, silakan login ulang.</small>
            </div>
        ';
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo '<div class="alert alert-danger">Metode request tidak valid.</div>';
        exit;
    }

    if (empty($_POST['id_poliklinik'])) {
        echo '<div class="alert alert-danger">ID poliklinik tidak boleh kosong.</div>';
        exit;
    }

    $id_poliklinik = (int) $_POST['id_poliklinik'];

    $stmt = mysqli_prepare(
        $Conn,
        "SELECT
            p.*,
            COALESCE(dokter.jumlah_dokter, 0) AS jumlah_dokter,
            COALESCE(jadwal.jumlah_jadwal, 0) AS jumlah_jadwal
         FROM poliklinik p
         LEFT JOIN (
            SELECT id_poliklinik, COUNT(DISTINCT id_dokter) AS jumlah_dokter
            FROM jadwal_dokter
            GROUP BY id_poliklinik
         ) dokter ON p.id_poliklinik = dokter.id_poliklinik
         LEFT JOIN (
            SELECT id_poliklinik, COUNT(*) AS jumlah_jadwal
            FROM jadwal_dokter
            GROUP BY id_poliklinik
         ) jadwal ON p.id_poliklinik = jadwal.id_poliklinik
         WHERE p.id_poliklinik = ?"
    );

    if (!$stmt) {
        echo '<div class="alert alert-danger">Gagal prepare query.</div>';
        exit;
    }

    mysqli_stmt_bind_param($stmt, "i", $id_poliklinik);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result || mysqli_num_rows($result) == 0) {
        mysqli_stmt_close($stmt);
        echo '<div class="alert alert-warning">Data poliklinik tidak ditemukan.</div>';
        exit;
    }

    $data = mysqli_fetch_assoc($result);

    $status_badge = ((int) ($data['status'] ?? 0) === 1)
        ? '<span class="badge bg-success">Aktif</span>'
        : '<span class="badge bg-secondary">Tidak Aktif</span>';

    $updatetime = !empty($data['updatetime']) ? date('d/m/Y H:i', strtotime($data['updatetime'])) : '-';
?>
    <input type="hidden" name="id_poliklinik" value="<?php echo $id_poliklinik; ?>">

    <div class="row mb-2">
        <div class="col-4"><small>ID</small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text-muted"><?php echo (int) $data['id_poliklinik']; ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small>Nama Poliklinik</small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text-muted"><?php echo htmlspecialchars($data['poliklinik'] ?? ''); ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small>Kode Poli</small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text-muted"><?php echo htmlspecialchars($data['kode'] ?? '-'); ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small>Jumlah Dokter</small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text-muted"><?php echo (int) ($data['jumlah_dokter'] ?? 0); ?> Dokter</small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small>Jumlah Jadwal</small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text-muted"><?php echo (int) ($data['jumlah_jadwal'] ?? 0); ?> Jadwal</small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small>Updated At</small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><small class="text-muted"><?php echo $updatetime; ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-4"><small>Status</small></div>
        <div class="col-1"><small>:</small></div>
        <div class="col-7"><?php echo $status_badge; ?></div>
    </div>
    <div class="row mt-4">
        <div class="col-12">
            <div class="alert alert-danger text-center mb-0">
                <b>PENTING!</b><br>
                <small>
                    Data poliklinik ini akan dihapus permanen dari sistem.<br>
                    Jadwal dokter yang terhubung dengan poliklinik ini juga akan ikut terhapus.<br>
                    <b>Apakah Anda yakin akan menghapus data ini?</b>
                </small>
            </div>
        </div>
    </div>
<?php
    mysqli_stmt_close($stmt);
?>
