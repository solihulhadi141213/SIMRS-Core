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

    // RM Relasi
    if (!empty($row['id_pasien_relasi'])) {
        $id_pasien_relasi = $row['id_pasien_relasi'];
        $nama_pasien_relasi = getDataDetail_v2($Conn, 'pasien', 'id_pasien', $id_pasien_relasi, 'nama');
    }else{
        $id_pasien_relasi = "-";
        $nama_pasien_relasi = "-";
    }

    echo '
        <div class="row mb-2">
            <div class="col-12"><small><b>A. Rekam Medis</b></small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Nomor RM Pasien</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.showValue($row['id_pasien']).'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Nomor RM Relasi (RM Ibu)</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$id_pasien_relasi.' <small>('.$nama_pasien_relasi.')</small></small></div>
        </div>
        <div class="row mb-2 mb-3">
            <div class="col-4"><small>Status Pasien</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.showValue($row['status']).'</small></div>
        </div>
        <hr>

        <div class="row mb-2 mt-3">
            <div class="col-12"><small><b>B. Identitas Umum</b></small></div>
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
            <div class="col-4"><small>Tempat Lahir</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.showValue($row['tempat_lahir']).'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Tanggal Lahir</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$tanggal_lahir.'</small></div>
        </div>
        <hr>

        <div class="row mb-2">
            <div class="col-12"><small><b>C. Alamat & Kontak</b></small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Provinsi</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.showValue($row['province']).'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Kabupaten/Kota</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.showValue($row['regency']).'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Kecamatan</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.showValue($row['subdistrict']).'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Kelurahan/Desa</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.showValue($row['village']).'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Jalan, No, RT/RW</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.showValue($row['street']).'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Kode Pos</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.showValue($row['postal_code']).'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Nomor Kontak</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.showValue($row['kontak']).'</small></div>
        </div>
         <hr>

        <div class="row mb-2">
            <div class="col-12"><small><b>D. Informasi Tambahan</b></small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Golongan Darah</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.showValue($row['golongan_darah']).'</small></div>
        </div>

        <div class="row mb-2">
            <div class="col-4"><small>Status Pernikahan</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.showValue($row['pernikahan']).'</small></div>
        </div>

        <div class="row mb-2">
            <div class="col-4"><small>Pekerjaan</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.showValue($row['pekerjaan']).'</small></div>
        </div>
        <hr>
        <div class="row mb-2 mt-3">
            <div class="col-12"><small><b>E. Informasi Pendaftaran</b></small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Petugas Pendaftaran</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.showValue($row['petugas_pendaftaran']).'</small></div>
        </div>

        <div class="row mb-2">
            <div class="col-4"><small>User Input</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.showValue($row['nama_petugas']).'</small></div>
        </div>

        <div class="row mb-2">
            <div class="col-4"><small>Terdaftar Sejak</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$registered_at.'</small></div>
        </div>

        <div class="row mb-2">
            <div class="col-4"><small>Terakhir Update</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$updated_at.'</small></div>
        </div>
    ';

    // Close
    mysqli_stmt_close($stmt);
?>