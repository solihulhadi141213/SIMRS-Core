<?php
    // Menyiapkan data antrean dan riwayat status untuk ditampilkan pada modal detail.
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

    // Validasi sesi, metode request, dan ID sebelum membaca data.
    if (empty($SessionIdAkses)) {
        http_response_code(401);
        echo '<div class="alert alert-danger">Sesi berakhir. Silakan login kembali.</div>';
        exit;
    }
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo '<div class="alert alert-danger">Metode request tidak valid.</div>';
        exit;
    }
    $idAntrian = (int) ($_POST['id_antrian'] ?? 0);
    if (!$idAntrian) {
        http_response_code(400);
        echo '<div class="alert alert-danger">ID antrian tidak valid.</div>';
        exit;
    }

    // Ambil antrean beserta informasi rekam medis, kunjungan, poliklinik, dokter, dan jadwal.
    $stmt = mysqli_prepare(
        $Conn,
        "SELECT a.*, 
                p.id_pasien AS pasien_terdaftar, 
                p.id_ihs AS ihs_pasien, 
                k.id_kunjungan AS kunjungan_terdaftar,
                poli.id_poliklinik AS poliklinik_terdaftar, 
                poli.poliklinik AS nama_poliklinik, 
                poli.kode AS kode_poliklinik, 
                d.id_dokter AS dokter_terdaftar,
                d.kode AS kode_dokter,
                d.nama AS nama_dokter,
                jd.jam_mulai, 
                jd.jam_selesai
        FROM antrian a
        LEFT JOIN pasien p ON p.id_pasien = a.id_pasien
        LEFT JOIN kunjungan k ON k.id_kunjungan = a.id_kunjungan
        LEFT JOIN poliklinik poli ON poli.id_poliklinik = a.id_poliklinik
        LEFT JOIN dokter d ON d.id_dokter = a.id_dokter
        LEFT JOIN jadwal_dokter jd ON jd.id_jadwal = a.id_jadwal
        WHERE a.id_antrian = ?
        LIMIT 1"
    );
    if (!$stmt) {
        http_response_code(500);
        echo '<div class="alert alert-danger">Gagal menyiapkan detail antrian.</div>';
        exit;
    }
    mysqli_stmt_bind_param($stmt, 'i', $idAntrian);
    if (!mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        http_response_code(500);
        echo '<div class="alert alert-danger">Gagal mengambil detail antrian.</div>';
        exit;
    }
    $result = mysqli_stmt_get_result($stmt);
    $queue = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    if (!$queue) {
        http_response_code(404);
        echo '<div class="alert alert-warning">Data antrian tidak ditemukan.</div>';
        exit;
    }

    // Siapkan nilai waktu, label status.
    try {
        $timezoneUser = new DateTimeZone($SessionUserTimezone ?: 'UTC');
    } catch (Throwable $error) {
        $timezoneUser = new DateTimeZone('UTC');
    }
   
    // Menentukan Waktu Sekarang
    $tanggal_waktu_pendaftaran = new DateTimeImmutable('now', new DateTimeZone('UTC'));

    // Ubah waktu sekarang menjadi zona waktu lokal
    $tanggal_waktu_pendaftaran_lokal = $tanggal_waktu_pendaftaran->setTimezone($timezoneUser);

    // Pecah Tanggal Dan Waktu Pendaftaran
    $tanggal_daftar = $tanggal_waktu_pendaftaran_lokal->format('Y-m-d');
    $jam_daftar     = $tanggal_waktu_pendaftaran_lokal->format('H:i');

?>
<input type="hidden" name="id_antrian" value="<?php echo $queue['id_antrian']; ?>">
<div class="row mb-3">
    <div class="col-12">
        <small><b>A. Identitas Pasien (Rekam Medis)</b></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-md-4">
        <label><small>* Nomor Rekam Medis (RM)</small></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="id_pasien" class="form-control" value="<?php echo $queue['id_pasien']; ?>" readonly>
    </div>
</div>

<div class="row mb-2">
    <div class="col-md-4">
        <label><small>* Nama Pasien</small></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="nama" class="form-control" value="<?php echo $queue['nama_pasien']; ?>" readonly>
    </div>
</div>

<div class="row mb-2">
    <div class="col-md-4">
        <label><small>NIK (Nomor KTP)</small></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="nik" class="form-control" value="<?php echo $queue['nik']; ?>" readonly>
    </div>
</div>

<div class="row mb-2">
    <div class="col-md-4">
        <label><small>Nomor Kartu BPJS</small></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="no_bpjs" class="form-control" value="<?php echo $queue['no_bpjs']; ?>" readonly>
    </div>
</div>

<div class="row mb-2">
    <div class="col-md-4">
        <label for="id_ihs"><small><i>IHS (Indonesia Health Services)</i></small></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="id_ihs" id="id_ihs" class="form-control" value="<?php echo $queue['ihs_pasien']; ?>" readonly>
    </div>
</div>

<hr>

<div class="row mb-3 mt-3">
    <div class="col-12">
        <small><b>B. Informasi Kunjungan</b></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-md-4">
        <label for="prioritas"><small>* Prioritas Tindakan</small></label>
    </div>
    <div class="col-md-8">
        <div class="d-flex flex-wrap gap-3 mb-4 mt-2">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="prioritas" id="prioritas_normal" value="Normal" checked="">
                <label class="form-check-label" for="prioritas_normal">
                    <small>Normal</small>
                </label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="prioritas" id="prioritas_urgent" value="Urgent">
                <label class="form-check-label" for="prioritas_urgent">
                    <small>Urgent</small>
                </label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="prioritas" id="prioritas_emergency" value="Emergency">
                <label class="form-check-label" for="prioritas_emergency">
                    <small>Emergency</small>
                </label>
            </div>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-4">
        <label for="keluhan"><small>* Keluhan Utama (<i>Chief Complaint</i>)</small></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="keluhan" id="keluhan" class="form-control" value="<?php echo $queue['keluhan']; ?>" required>
        <small>
            <small class="text-muted">Jelaskan secara singkat padat dan lengkap mengenai keluhan utama pasien saat mendaftar.</small>
        </small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-md-4">
        <label for="datetime_daftar"><small>* Tanggal & Waktu Pendaftaran</small></label>
    </div>
    <div class="col-md-8">
        <div class="input-group">
            <input type="date" class="form-control" name="date_daftar" id="date_daftar" value="<?php echo $tanggal_daftar; ?>" required>
            <input type="time" class="form-control" name="time_daftar" id="time_daftar" value="<?php echo $jam_daftar; ?>" required>
        </div>
    </div>
</div>

<hr>

<div class="row mb-3 mt-3">
    <div class="col-12">
        <small><b>C. Poliklinik & Dokter</b></small>
    </div>
</div>

<div class="row mb-2">
    <div class="col-md-4">
        <label><small>* Kode Poliklinik (BPJS)</small></label>
    </div>
    <div class="col-md-8">
        <input type="text" readonly name="kode_poliklinik" class="form-control" value="<?php echo $queue['kode_poliklinik']  ?>">
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label><small>* Nama Poliklinik</small></label>
    </div>
    <div class="col-md-8">
        <input type="text" readonly name="poliklinik" class="form-control" value="<?php echo $queue['nama_poliklinik']  ?>">
    </div>
</div>
<div class="row mb-2">
    <div class="col-md-4">
        <label for="kode_dokter"><small>* Kode Dokter (HFIS)</small></label>
    </div>
    <div class="col-md-8">
        <input type="text" readonly name="kode_dokter" id="kode_dokter" class="form-control" value="<?php echo $queue['kode_dokter']; ?>">
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="dokter"><small>* Nama Dokter</small></label>
    </div>
    <div class="col-md-8">
        <input type="text" readonly name="dokter" id="dokter" class="form-control" value="<?php echo $queue['nama_dokter']; ?>">
    </div>
</div>

<hr>

<div class="row mb-3 mt-3">
    <div class="col-12">
        <small><b>D. Pembayaran Dan Penjaminan</b></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-md-4">
        <label for="pembayaran_metode"><small>* Metode Pembayaran</small></label>
    </div>
    <div class="col-md-8">
        <div class="d-flex flex-wrap gap-3 mb-4 mt-2">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="pembayaran_metode" id="pembayaran_metode_umum" value="UMUM" <?php if($queue['pembayaran']=='UMUM'){echo 'checked';}  ?> >
                <label class="form-check-label" for="pembayaran_metode_umum">
                    <small>UMUM</small>
                </label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="pembayaran_metode" id="pembayaran_metode_asuransi" value="ASURANSI" <?php if($queue['pembayaran']!=='UMUM'){echo 'checked';}  ?>>
                <label class="form-check-label" for="pembayaran_metode_asuransi">
                    <small>ASURANSI</small>
                </label>
            </div>
        </div>
    </div>
</div>
<div class="row mb-2">
    <div class="col-md-4">
        <label for="pembayaran_penanggung"><small>Penanggung Pembayaran</small></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="pembayaran_penanggung" id="pembayaran_penanggung" class="form-control">
        <small>
            <small class="text-muted">Khusus untuk pasien umum, diisi dengan nama penjamin pembayaran</small>
        </small>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-4">
        <label for="sep"><small>SEP (Surat Eligibilitas Peserta)</small></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="sep" id="sep" class="form-control">
        <small><small class="text-muted">hanya jika sebelumnya sudah dibuatkan SEP</small></small>
    </div>
</div>

<hr>

<div class="row mb-3 mt-3">
    <div class="col-12">
        <small><b>E. Kontak Darurat</b></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-md-4">
        <label for="kontak_darurat_nomor"><small>Nomor Kontak</small></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="kontak_darurat_nomor" id="kontak_darurat_nomor" class="form-control" placeholder="+62">
    </div>
</div>
<div class="row mb-2">
    <div class="col-md-4">
        <label for="kontak_darurat_nama"><small>Nama Pemilik Kontak</small></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="kontak_darurat_nama" id="kontak_darurat_nama" class="form-control">
    </div>
</div>
<div class="row mb-2">
    <div class="col-md-4">
        <label for="kontak_darurat_hubungan"><small>Hubungan Dengan Pasien</small></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="kontak_darurat_hubungan" id="kontak_darurat_hubungan" class="form-control" placeholder="Ayah, Ibu, Kakak, DLL">
        <small>
            <small class="text-muted">
                Jika pasien tidak memiliki kontak darurat lainnya : 
            </small>
        </small>
    </div>
</div>

<hr>

<div class="row mb-3 mt-3">
    <div class="col-12">
        <small><b>F. Pernyataan Petugas</b></small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-12">
        <div class="alert alert-info">
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="pernyataan_petugas" name="pernyataan_petugas" value="1">
                <label class="form-check-label" for="pernyataan_petugas">
                    <small>
                        <b>Pernyataan Petugas Pendaftaran</b><br>
                        Saya menyatakan bahwa seluruh data dan informasi pasien yang saya input telah sesuai dengan dokumen dan kondisi sebenarnya. 
                        Saya juga memahami serta berkomitmen untuk menjaga kerahasiaan data pasien sesuai dengan ketentuan etika dan peraturan perundang-undangan yang berlaku.
                    </small>
                </label>
            </div>
        </div>
    </div>
</div>