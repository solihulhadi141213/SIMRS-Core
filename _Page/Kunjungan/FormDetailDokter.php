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

    // Validasi ID Kunjungan
    if (empty($_POST['id_kunjungan'])) {
        echo '
            <div class="alert alert-danger">
                <small>ID Kunjungan tidak boleh kosong!</small>
            </div>
        ';
        exit;
    }

    // Sanitasi Input
    $id_kunjungan = validateAndSanitizeInput($_POST['id_kunjungan']);

    // Buka Data Dengan Prepared Statement + JOIN
    $sql = "SELECT * FROM kunjungan WHERE kunjungan.id_kunjungan = ?";
    $stmt = $Conn->prepare($sql);

    // Bind parameter
    $stmt->bind_param("i", $id_kunjungan);

    // Eksekusi
    $stmt->execute();

    // Ambil hasil
    $result = $stmt->get_result();
    $Data   = $result->fetch_assoc();

    // Simpan hasil ke variabel
    $id_pasien               = $Data['id_pasien'] ?? null;
    $id_encounter            = $Data['id_encounter'] ?? null;
    $sep                     = $Data['sep'] ?? null;
    $prioritas               = $Data['prioritas'] ?? null;
    $keluhan                 = $Data['keluhan'] ?? null;
    $jenis_kunjungan         = $Data['jenis_kunjungan'] ?? null;
    $id_dokter               = $Data['id_dokter'] ?? null;
    $kode_dokter             = $Data['kode_dokter'] ?? null;
    $dokter                  = $Data['dokter'] ?? null;
    $dpjp_id                 = $Data['dpjp_id'] ?? null;
    $dpjp_kode               = $Data['dpjp_kode'] ?? null;
    $dpjp_nama               = $Data['dpjp_nama'] ?? null;
    $id_poliklinik           = $Data['id_poliklinik'] ?? null;
    $kode_poliklinik         = $Data['kode_poliklinik'] ?? null;
    $poliklinik              = $Data['poliklinik'] ?? null;
    $kelas                   = $Data['kelas'] ?? null;
    $ruang_rawat             = $Data['ruang_rawat'] ?? null;
    $tempat_tidur            = $Data['tempat_tidur'] ?? null;
    $pembayaran_metode       = $Data['pembayaran_metode'] ?? null;
    $pembayaran_penanggung   = $Data['pembayaran_penanggung'] ?? null;
    $kontak_darurat_nomor    = $Data['kontak_darurat_nomor'] ?? null;
    $kontak_darurat_nama     = $Data['kontak_darurat_nama'] ?? null;
    $kontak_darurat_hubungan = $Data['kontak_darurat_hubungan'] ?? null;
    $cara_keluar             = $Data['cara_keluar'] ?? null;
    $status                  = $Data['status'] ?? null;
    $petugas_id              = $Data['petugas_id'] ?? null;
    $petugas_nama            = $Data['petugas_nama'] ?? null;
    $datetime_daftar         = $Data['datetime_daftar'] ?? null;
    $datetime_pelayanan      = $Data['datetime_pelayanan'] ?? null;
    $datetime_selesai        = $Data['datetime_selesai'] ?? null;

    // Tutup statement
    $stmt->close();

    echo '
        <div class="row mb-2">
            <div class="col-4"><small>ID Dokter</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$dpjp_id.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Kode Dokter</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$dpjp_kode.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Nama Dokter</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$dpjp_nama.'</small></div>
        </div>
    ';
?>
