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
        "SELECT * FROM antrian
        WHERE id_antrian = ?
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

?>
<!-- Hidden input -->
 <input type="hidden" name="id_antrian" value="<?php echo $queue['id_antrian']; ?>">
<!-- IDENTITAS -->
<div class="row mb-2">
    <div class="col-12">
        <small><b>A. Nomor Identitas</b></small>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="nik_pasien"><small>NIK (KTP)</small></label>
        <input type="text" name="nik" id="nik_pasien" class="form-control" value="<?php echo $queue['nik']; ?>">
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="id_ihs_pasien"><small>ID IHS (SATUSEHAT)</small></label>
        <div class="input-group">
            <input type="text" name="id_ihs" id="id_ihs_pasien" class="form-control">
            <span class="input-group-text cari_ihs_pasien_satusehat" title="Cari Dari Resource SATUSEHAT">
                <i class="bi bi-search"></i>
            </span>
        </div>
        <small class="text-danger" id="notifikasi_cari_pasien_by_ihs"></small>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12 mb-3">
        <label for="no_bpjs"><small>No.BPJS</small></label>
        <div class="input-group">
            <input type="text" name="no_bpjs" id="no_bpjs" class="form-control" value="<?php echo $queue['no_bpjs']; ?>">
            <span class="input-group-text cari_no_bpjs" title="Cari Dari Resource Bridging BPJS">
                <small>Ambil Data</small>
            </span>
        </div>
        <small class="text-danger" id="notifikasi_cari_no_bpjs"></small>
    </div>
</div>
<hr>

<!-- INFORMASI UTAMA -->
<div class="row mb-2">
    <div class="col-12">
        <small><b>C. Informasi Utama</b></small>
    </div>
</div>

<!-- Nama -->
<div class="row mb-3">
    <div class="col-12">
        <label for="nama_pasien"><small>* Nama Lengkap</small></label>
        <input type="text" name="nama" id="nama_pasien" class="form-control" value="<?php echo $queue['nama_pasien']; ?>" required>
    </div>
</div>

<!-- Gender -->
<div class="row mb-3">
    <div class="col-12">
        <label for="gender"><small>* Gender (Jenis Kelamin)</small></label>
        <select name="gender" id="gender" class="form-control" required>
            <option <?php if(empty($queue['gender'])){echo 'selected';} ?> value="">Pilih</option>
            <option <?php if($queue['gender']=='Laki-laki'){echo 'selected';} ?> value="Laki-laki">Laki-laki</option>
            <option <?php if($queue['gender']=='Perempuan'){echo 'selected';} ?> value="Perempuan">Perempuan</option>
        </select>
    </div>
</div>

<!-- Nama -->
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="tempat_lahir"><small>Tempat Lahir</small></label>
        <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control">
    </div>
    <div class="col-md-6 mb-3">
        <label for="tanggal_lahir"><small>Tanggal Lahir</small></label>
        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control">
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-12 mb-3">
        <b><small>D. Alamat Tempat Tinggal</small></b>
    </div>
</div>
<!-- Alamat -->
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="province"><small>* Provinsi</small></label>
        <select name="province" id="province" class="form-control" required>
            <option value="">Pilih</option>
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="regency"><small>* Kabupaten/Kota</small></label>
        <select name="regency" id="regency" class="form-control" required>
            <option value="">Pilih</option>
        </select>
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="subdistrict"><small>* Kecamatan</small></label>
        <select name="subdistrict" id="subdistrict" class="form-control" required>
            <option value="">Pilih</option>
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="village"><small>* Desa/Kelurahan</small></label>
        <select name="village" id="village" class="form-control" required>
            <option value="">Pilih</option>
        </select>
    </div>
</div>
<div class="row">
    <div class="col-md-12 mb-3">
        <label for="street"><small>Jalan, Nomor Rumah, RT/RW</small></label>
        <input type="text" id="street" name="street" class="form-control">
    </div>
</div>
<div class="row">
    <div class="col-md-12 mb-3">
        <label for="postal_code"><small>Kode POS</small></label>
        <input type="text" id="postal_code" name="postal_code" class="form-control">
    </div>
</div>
<div class="row">
    <div class="col-md-12 mb-3">
        <label for="kontak"><small>Nomor Kontak Pasien</small></label>
        <input type="text" id="kontak" name="kontak" class="form-control" placeholder="62">
    </div>
</div>
<hr>

<!-- INFORMASI PENDUKUNG -->
<div class="row mb-2">
    <div class="col-12">
        <small><b>E. Informasi Pendukung Lainnya</b></small>
    </div>
</div>

<!-- Golongan Darah -->
<div class="row">
    <div class="col-md-12 mb-3">
        <label for="golongan_darah"><small>Golongan Darah</small></label>
        <select name="golongan_darah" id="golongan_darah" class="form-control">
            <option value="">Pilih</option>
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="AB">AB</option>
            <option value="O">O</option>
        </select>
    </div>
</div>

<!-- Pernikahan -->
<div class="row">
    <div class="col-md-12 mb-3">
        <label for="pernikahan"><small>Status Pernikahan</small></label>
        <select name="pernikahan" id="pernikahan" class="form-control">
            <option value="">Pilih</option>
            <option value="Lajang">Belum Menikah</option>
            <option value="Menikah">Menikah</option>
            <option value="Janda">Janda</option>
            <option value="Duda">Duda</option>
        </select>
    </div>
</div>

<!-- Pekerjaan -->
<div class="row">
    <div class="col-md-12 mb-3">
        <label for="pekerjaan"><small>Pekerjaan</small></label>
        <select name="pekerjaan" id="pekerjaan" class="form-control">
            <option value="">Pilih</option>
            <option value="Tidak Bekerja">Tidak Bekerja</option>
            <option value="Karyawan Swasta">Karyawan Swasta</option>
            <option value="Wirausaha">Wirausaha</option>
            <option value="PNS">ASN TNI/POLRI</option>
        </select>
    </div>
</div>

    <!-- Tanggal Pendaftaran -->
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="registered_date"><small>* Tanggal Pendaftaran</small></label>
        <input type="date" name="registered_date" id="registered_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="registered_time"><small>* Jam Pendaftaran</small></label>
        <input type="time" name="registered_time" id="registered_time" class="form-control" value="<?php echo date('H:i'); ?>" required>
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
                        Saya menyatakan bahwa seluruh data dan informasi pasien yang saya input telah sesuai dengan dokumen dan kondisi sebenarnya. Saya juga memahami serta berkomitmen untuk menjaga kerahasiaan data pasien sesuai dengan ketentuan etika dan peraturan perundang-undangan yang berlaku.
                    </small>
                </label>
            </div>
        </div>
    </div>
</div>
