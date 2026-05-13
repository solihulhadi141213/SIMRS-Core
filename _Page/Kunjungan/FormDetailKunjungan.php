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
        <input type="hidden" name="id_kunjungan" id="put_id_kunjungan" value="'.$id_kunjungan.'">

        <div class="row mb-2">
            <div class="col-12"><small><b>A. Identitas Pasien</b></small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>No.RM</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$id_pasien.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Nama Pasien</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$nama_pasien.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>NIK / KTP</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$nik.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Nomor (BPJS)</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$no_bpjs.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>ID IHS (SATUSEHAT)</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$id_ihs.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Gender</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$gender.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Tempat, Tgl Lahir</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$tempat_lahir.', '.$tanggal_lahir.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Usia Saat Pelayanan</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$usia_pelayanan.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Usia Sekarang</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$usia_sekarang.'</small></div>
        </div>

        <hr>

        <div class="row mb-3 mt-3">
            <div class="col-12"><small><b>B. Informasi Kunjungan</b></small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>ID Kunjungan</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$id_kunjungan.'</small></div>
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
        <div class="row mb-2">
            <div class="col-4"><small><i>ID Encounter</i></small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$id_encounter.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small><i>SEP (Surat Eligibilitas Peserta)</i></small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$sep.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Keluhan / Klini Saat Datang</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$keluhan.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Metode Pembayaran</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$pembayaran_metode.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Penanggung</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$pembayaran_penanggung.'</small></div>
        </div>
        
        <hr>

        <div class="row mb-2 mt-2">
            <div class="col-12"><small><b>C. Dokter Penerima & DPJP</b></small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Dokter Penerima</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$dokter.' ('.$kode_dokter.')</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Dokter DPJP</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$dpjp_nama.' ('.$dpjp_kode.')</small></div>
        </div>

        <hr>
        
        <div class="row mb-2 mt-2">
            <div class="col-12"><small><b>D. Poliklinik, Kelas, Ruang, Tempat Tidur</b></small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Poliklinik</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$poliklinik.' ('.$kode_poliklinik.')</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Kelas</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$kelas.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Ruang Rawat</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$ruang_rawat.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Tempat Tidur</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$tempat_tidur.'</small></div>
        </div>

        <hr>

        <div class="row mb-2 mt-2">
            <div class="col-12"><small><b>E. Kontak Darurat</b></small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Nama Kontak</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$kontak_darurat_nama.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Nomor Kontak</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$kontak_darurat_nomor.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Hubungan</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$kontak_darurat_hubungan.'</small></div>
        </div>

        <hr>

        <div class="row mb-2 mt-2">
            <div class="col-12"><small><b>F. Waktu Pelayanan</b></small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Waktu Pendaftaran</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$datetime_daftar.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Waktu Pelayanan</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$datetime_pelayanan.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Waktu Selesai</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$datetime_selesai.'</small></div>
        </div>

        <hr>

        <div class="row mb-2 mt-2">
            <div class="col-12"><small><b>F. Informasi Lainnya</b></small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Petugas Pendaftaran</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$petugas_nama.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Status Pelayanan</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$status.'</small></div>
        </div>
    ';
?>

<script>
    $('#ButtonDetailKunjunganSelengkapnya').prop('disabled', false);
</script>