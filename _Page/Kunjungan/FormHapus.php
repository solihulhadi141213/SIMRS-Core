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

    // Validasi form
    if (empty($_POST['from'])) {
        echo '
            <div class="alert alert-danger">
                <small>Asal Permintaan Perubahan Tidak Boleh Kosong!</small>
            </div>
        ';
        exit;
    }

    // Sanitasi Input
    $id_kunjungan = validateAndSanitizeInput($_POST['id_kunjungan']);
    $from         = validateAndSanitizeInput($_POST['from']);


    // Buka Data Dengan Prepared Statement + JOIN
    $sql = "
        SELECT 
            kunjungan.*,

            pasien.nama AS nama_pasien,
            pasien.nik,
            pasien.id_ihs,
            pasien.no_bpjs,
            pasien.gender,
            pasien.tempat_lahir,
            pasien.tanggal_lahir

        FROM kunjungan
        LEFT JOIN pasien 
            ON kunjungan.id_pasien = pasien.id_pasien

        WHERE kunjungan.id_kunjungan = ?
    ";

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

    // Pasien
    $nama_pasien   = $Data['nama_pasien'] ?? null;
    $nik           = $Data['nik'] ?? null;
    $id_ihs        = $Data['id_ihs'] ?? null;
    $no_bpjs       = $Data['no_bpjs'] ?? null;
    $gender        = $Data['gender'] ?? null;
    $tempat_lahir  = $Data['tempat_lahir'] ?? null;
    $tanggal_lahir = $Data['tanggal_lahir'] ?? null;

    // Hitung Usia
    $usia_sekarang = hitungUsia($tanggal_lahir);
    $usia_pelayanan = hitungUsia($tanggal_lahir, $datetime_daftar);

    // Waktu Pelayanan
    if(!empty($datetime_daftar)){
        $datetime_daftar = date('d/m/Y H:i', strtotime($datetime_daftar));
    }else{
        $datetime_daftar = "-";
    }
    if(!empty($datetime_pelayanan)){
        $datetime_pelayanan = date('d/m/Y H:i', strtotime($datetime_pelayanan));
    }else{
        $datetime_pelayanan = "-";
    }

    if(!empty($datetime_selesai)){
        $datetime_selesai = date('d/m/Y H:i', strtotime($datetime_selesai));
    }else{
        $datetime_selesai = "-";
    }


    // Tutup statement
    $stmt->close();

    echo '
        <input type="hidden" name="id_kunjungan" value="'.$id_kunjungan.'">
        <input type="hidden" name="from" id="from" value="'.$from.'">

        <div class="row mb-2">
            <div class="col-4"><small>No.RM</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$id_pasien.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>ID Kunjungan</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$id_kunjungan.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Nama Pasien</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$nama_pasien.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Tanggal Kunjungan</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.date('d/m/Y H:i', strtotime($datetime_daftar)).'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Skala Prioritas</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$prioritas.'</small></div>
        </div>
    ';
?>

<div class="row">
    <div class="col-12">
        <div class="alert alert-danger text-center">
            <small>
                <b>PENTING!</b><br>
                Data yang sudah dihapus tidak akan bisa dikembalikan lagi. Periksa kembali data yang anda pilih.
            </small>
        </div>
    </div>
</div>

<script>
    $('#ButtonHapus').prop('disabled', false);
</script>