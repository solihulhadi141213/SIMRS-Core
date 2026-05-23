<?php
    // Connection, Function & Session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // VALIDASI SESSION
    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger">
                <small>Sesi akses sudah berakhir! Silahkan login ulang.</small>
            </div>
        ';
        exit;
    }

    // VALIDASI ID ALERGI
    if (empty($_POST['id_alergi'])) {
        echo '
            <div class="alert alert-danger">
                <small>ID Tindakan tidak boleh kosong!</small>
            </div>
        ';
        exit;
    }

    // SANITASI INPUT
    $id_alergi = validateAndSanitizeInput($_POST['id_alergi']);

    // =========================================================
    // DETAIL TINDAKAN
    // =========================================================
    $sql = "
        SELECT 
            ag.*,

            -- KUNJUNGAN
            k.id_kunjungan,
            k.id_dokter,
            k.jenis_kunjungan,
            k.datetime_daftar,
            k.id_encounter,
            k.status AS status_kunjungan,

            -- PASIEN
            p.id_pasien,
            p.nama AS nama_pasien,
            p.nik,
            p.no_bpjs,
            p.id_ihs,
            p.gender,
            p.tanggal_lahir,
            p.status AS status_pasien,

            -- REFERENSI ALERGEN
            aa.kategori_alergen AS kategori_alergen_ref,
            aa.nama_alergen AS nama_alergen_ref,

            -- PRAKTISI
            pr.nama_praktisi,

            -- AKSES/PETUGAS
            ak.nama AS nama_petugas_input

        FROM alergi ag

        LEFT JOIN kunjungan k
            ON ag.id_kunjungan = k.id_kunjungan

        LEFT JOIN pasien p
            ON ag.id_pasien = p.id_pasien

        LEFT JOIN alergi_alergen aa
            ON ag.id_alergi_alergen = aa.id_alergi_alergen

        LEFT JOIN praktisi pr
            ON ag.id_praktisi = pr.id_praktisi

        LEFT JOIN akses ak
            ON ag.author_id = ak.id_akses

        WHERE ag.id_alergi = ?
    ";

    $stmt = $Conn->prepare($sql);
    $stmt->bind_param("s", $id_alergi);
    $stmt->execute();

    $result = $stmt->get_result();
    $Data   = $result->fetch_assoc();

    // VALIDASI DATA
    if (empty($Data)) {

        echo '
            <div class="alert alert-danger">
                <small>Data tindakan tidak ditemukan!</small>
            </div>
        ';
        exit;
    }

    // =========================================================
    // MAPPING DATA
    // =========================================================

    // INFORMASI UMUM
    $AllergyIntolerance  = $Data['AllergyIntolerance'] ?? null;
    $clinical_status     = $Data['clinical_status'] ?? null;
    $verification_status = $Data['verification_status'] ?? null;
    $keterangan_alergi   = $Data['keterangan_alergi'] ?? null;
    $datetime_creat      = $Data['datetime_creat'] ?? null;

    // PASIEN
    $id_pasien = $Data['id_pasien'] ?? null;
    $nama      = $Data['nama_pasien'] ?? null;
    $gender    = $Data['gender'] ?? null;
    $id_ihs    = $Data['id_ihs'] ?? null;

    // KUNJUNGAN
    $id_kunjungan    = $Data['id_kunjungan'] ?? null;
    $id_encounter    = $Data['id_encounter'] ?? null;
    $jenis_kunjungan = $Data['jenis_kunjungan'] ?? null;
    $datetime_daftar = $Data['datetime_daftar'] ?? null;

    // =========================================================
    // INFORMASI ALERGEN
    // PRIORITAS:
    // 1. tabel alergi_alergen
    // 2. tabel alergi
    // =========================================================
    if (!empty($Data['id_alergi_alergen'])) {
        $kategori_alergen = $Data['kategori_alergen_ref'] ?? '-';
        $nama_alergen     = $Data['nama_alergen_ref'] ?? '-';
    } else {
        $kategori_alergen = $Data['kategori_alergen'] ?? '-';
        $nama_alergen     = $Data['nama_alergen'] ?? '-';
    }

    // =========================================================
    // INFORMASI PERFORMER
    // PRIORITAS:
    // 1. tabel praktisi
    // 2. tabel alergi
    // =========================================================
    if (!empty($Data['id_praktisi'])) {
        $nama_praktisi = $Data['nama_praktisi'] ?? '-';
    } else {
        $nama_praktisi = $Data['nama_praktisi'] ?? '-';
    }

    // =========================================================
    // PETUGAS INPUT
    // PRIORITAS:
    // 1. tabel akses
    // 2. tabel alergi
    // =========================================================
    if (!empty($Data['author_id'])) {
        $petugas_input = $Data['nama_petugas_input'] ?? '-';
    } else {
        $petugas_input = $Data['author_name'] ?? '-';
    }
  
  
?>
<div class="row mb-2 mt-3">
    <div class="col-12">
        <small><b>A. Informasi Pasien</b></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>ID Pasien (RM)</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo $id_pasien; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>ID IHS</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo $id_ihs; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Nama Pasien</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo $nama; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Gender</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo $gender; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>ID Kunjungan</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo $id_kunjungan; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>ID Encounter</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo $id_encounter; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Tanggal Daftar</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo $datetime_daftar; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-4"><small>Tujuan</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo $jenis_kunjungan; ?></small>
    </div>
</div>
<div class="row mb-2 mt-4">
    <div class="col-12">
        <small><b>B. Informasi Alergi</b></small>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>Kategori Alergen</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo $kategori_alergen; ?></small>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>Nama Alergen</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted"><?php echo $nama_alergen; ?></small>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>Status Klinis</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted">
            <?php echo ucfirst($clinical_status); ?>
        </small>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>Status Verifikasi</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted">
            <?php echo ucwords(str_replace('-', ' ', $verification_status)); ?>
        </small>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>Reaksi/Keterangan</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted">
            <?php echo !empty($keterangan_alergi) ? $keterangan_alergi : '-'; ?>
        </small>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>Tanggal Input</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted">
            <?php echo $datetime_creat; ?>
        </small>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>Pemeriksa</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted">
            <?php echo $nama_praktisi; ?>
        </small>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4"><small>Petugas Input</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <small class="text-muted">
            <?php echo $petugas_input; ?>
        </small>
    </div>
</div>