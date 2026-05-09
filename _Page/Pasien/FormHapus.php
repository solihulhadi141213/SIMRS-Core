<?php
    // Connection, Function & Session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // Validasi Session
    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger">
                <small>Sesi akses sudah berakhir! Silahkan login ulang.</small>
            </div>
        ';
        exit;
    }

    // Validasi ID Pasien
    if (empty($_POST['id_pasien'])) {
        echo '
            <div class="alert alert-danger">
                <small>ID pasien tidak boleh kosong!</small>
            </div>
        ';
        exit;
    }

    // Sanitasi Input
    $id_pasien = validateAndSanitizeInput($_POST['id_pasien']);

    // Query Detail Pasien
    $query = "
        SELECT 
            pasien.*,
            akses.nama AS nama_petugas
        FROM pasien
        LEFT JOIN akses ON pasien.id_akses = akses.id_akses
        WHERE pasien.id_pasien = ?
        LIMIT 1
    ";

    $stmt = mysqli_prepare($Conn, $query);

    // Debug Query Prepare
    if (!$stmt) {
        echo '
            <div class="alert alert-danger">
                <small>Gagal mempersiapkan query : '.mysqli_error($Conn).'</small>
            </div>
        ';
        exit;
    }

    mysqli_stmt_bind_param($stmt, "i", $id_pasien);

    // Debug Execute
    if (!mysqli_stmt_execute($stmt)) {
        echo '
            <div class="alert alert-danger">
                <small>Gagal menjalankan query : '.mysqli_stmt_error($stmt).'</small>
            </div>
        ';
        exit;
    }

    $result = mysqli_stmt_get_result($stmt);

    // Validasi Data
    if (mysqli_num_rows($result) == 0) {
        echo '
            <div class="alert alert-danger">
                <small>Data pasien tidak ditemukan!</small>
            </div>
        ';
        exit;
    }

    // Fetch Data
    $row = mysqli_fetch_assoc($result);

    // Helper Empty Value
    function showValue($value){
        return (!empty($value)) ? htmlspecialchars($value) : '-';
    }

    // Format Tanggal Lahir
    $tanggal_lahir = '-';
    if (!empty($row['tanggal_lahir']) && $row['tanggal_lahir'] != '0000-00-00') {
        $tanggal_lahir = date('d/m/Y', strtotime($row['tanggal_lahir']));
    }

    // Format Datetime
    $registered_at = '-';
    if (!empty($row['registered_at'])) {
        $registered_at = date('d/m/Y H:i', strtotime($row['registered_at']));
    }

    $updated_at = '-';
    if (!empty($row['updated_at'])) {
        $updated_at = date('d/m/Y H:i', strtotime($row['updated_at']));
    }

    // Alamat Lengkap
    $alamat = trim(
        showValue($row['street']).', '.
        showValue($row['village']).', '.
        showValue($row['subdistrict']).', '.
        showValue($row['regency']).', '.
        showValue($row['province']).' '.
        showValue($row['postal_code'])
    );

    echo '
        <input type="hidden" name="id_pasien" value="'.$id_pasien.'">
        <div class="row mb-2">
            <div class="col-4"><small>Nomor RM</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.showValue($row['id_pasien']).'</small></div>
        </div>

        <div class="row mb-2">
            <div class="col-4"><small>Nama Pasien</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.showValue($row['nama']).'</small></div>
        </div>

        <div class="row mb-2">
            <div class="col-4"><small>ID IHS SATUSEHAT</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.showValue($row['id_ihs']).'</small></div>
        </div>

        <div class="row mb-2">
            <div class="col-4"><small>NIK / No. KTP</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.showValue($row['nik']).'</small></div>
        </div>

        <div class="row mb-2">
            <div class="col-4"><small>No. BPJS</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.showValue($row['no_bpjs']).'</small></div>
        </div>

        <div class="row mb-2">
            <div class="col-4"><small>Jenis Kelamin</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.showValue($row['gender']).'</small></div>
        </div>

        <div class="row mb-2">
            <div class="col-4"><small>Status Pasien</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.showValue($row['status']).'</small></div>
        </div>
    ';

    // Close
    mysqli_stmt_close($stmt);
?>
<div class="row mb-3 mt-3">
    <div class="col-12">
        <div class="alert alert-danger">
            <small class="mb-4">
                <b>PENTING!!</b><br>
                Menghapus data pasien akan menghapus seluruh informasi turunannya secara permanen. 
                Pastikan data pasien yang akan dihapus sudah sesuai. 
                Setiap proses berbahaya akan dicatat dan disimpan sebagai arsip pengawasan yang ketat.<br>
            </small>
            <hr>
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="pernyataan_petugas_penghapus" name="pernyataan_petugas_penghapus" value="1">
                <label class="form-check-label" for="pernyataan_petugas_penghapus">
                    <small>
                        <b>Pernyataan Petugas Pendaftaran</b><br>
                        Saya telah membaca informasi penting tentang penghapusan data pasien pada sistem dan saya bersedia menerima konsekuensi apapun atas tindakan yang saya buat.
                    </small>
                </label>
            </div>
        </div>
    </div>
</div>