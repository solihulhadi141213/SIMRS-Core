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

    // Buka Data Dengan Prepared Statment
    $sql = "
        SELECT 
            k.*,
            k.status AS status_kunjungan,

            p.id_pasien,
            p.nama,
            p.nik,
            p.no_bpjs,
            p.id_ihs,
            p.gender,
            p.status AS status_pasien

        FROM kunjungan k
        LEFT JOIN pasien p ON k.id_pasien = p.id_pasien
        WHERE k.id_kunjungan = ?
    ";

    // Prepare statement
    $stmt = $Conn->prepare($sql);

    // Bind parameter
    $stmt->bind_param("i", $id_kunjungan);

    // Eksekusi
    $stmt->execute();

    // Ambil hasil
    $result = $stmt->get_result();
    $Data   = $result->fetch_assoc();

    // Mapping data
    $id_pasien       = $Data['id_pasien'] ?? null;
    $nama            = $Data['nama'] ?? null;
    $nik             = $Data['nik'] ?? null;
    $no_bpjs         = $Data['no_bpjs'] ?? null;
    $id_ihs          = $Data['id_ihs'] ?? null;
    $gender          = $Data['gender'] ?? null;

    $id_encounter    = $Data['id_encounter'] ?? null;
    $sep             = $Data['sep'] ?? null;
    $prioritas       = $Data['prioritas'] ?? null;
    $jenis_kunjungan = $Data['jenis_kunjungan'] ?? null;
    $keluhan         = $Data['keluhan'] ?? null;
    $datetime_daftar = $Data['datetime_daftar'] ?? null;

    // Status dibedakan
    $status_kunjungan = $Data['status_kunjungan'] ?? null;
    $status_pasien    = $Data['status_pasien'] ?? null;

    // Tutup statement
    $stmt->close();

    // Poliklinik
    $id_poliklinik   = $Data['id_poliklinik'] ?? null;
    $kode_poliklinik = $Data['kode_poliklinik'] ?? null;
    $poliklinik      = $Data['poliklinik'] ?? null;

    // Kelas Ruangan Dan Tempat Tidur
    $kelas        = $Data['kelas'] ?? null;
    $ruang_rawat  = $Data['ruang_rawat'] ?? null;
    $tempat_tidur = $Data['tempat_tidur'] ?? null;

    // Dokter Penerima
    $id_dokter   = $Data['id_dokter'] ?? null;
    $kode_dokter = $Data['kode_dokter'] ?? null;
    $dokter      = $Data['dokter'] ?? null;

    // Dokter DPJP
    $dpjp_id   = $Data['dpjp_id'] ?? null;
    $dpjp_kode = $Data['dpjp_kode'] ?? null;
    $dpjp_nama = $Data['dpjp_nama'] ?? null;

    // Kontak Darurat
    $kontak_darurat_nomor    = $Data['kontak_darurat_nomor'] ?? null;
    $kontak_darurat_nama     = $Data['kontak_darurat_nama'] ?? null;
    $kontak_darurat_hubungan = $Data['kontak_darurat_hubungan'] ?? null;

    // Pembayaran / Penjamin
    $pembayaran_metode     = $Data['pembayaran_metode'] ?? null;
    $pembayaran_penanggung = $Data['pembayaran_penanggung'] ?? null;
    $sep                   = $Data['sep'] ?? null;

    // Petugas Pendaftaran
    $petugas_id   = $Data['petugas_id'] ?? null;
    $petugas_nama = $Data['petugas_nama'] ?? null;
?>

<div class="row mb-3">
    <div class="col-12 text-end icon-btn">
        <button type="button" class="btn btn-md btn-dark btn-icon back_to_table_view">
            <i class="bi bi-chevron-left"></i>
        </button>
        <button type="button" class="btn btn-md btn-outline-secondary btn-icon modal_reload_detail_kunjungan" data-id="<?php echo $id_kunjungan; ?>" data-from="data_view">
            <i class="bi bi-repeat"></i>
        </button>
        <button type="button" class="btn btn-md btn-outline-secondary btn-icon modal_edit" data-id="<?php echo $id_kunjungan; ?>" data-from="data_view">
            <i class="bi bi-pencil"></i>
        </button>
        <button type="button" class="btn btn-md btn-outline-secondary btn-icon modal_update_status" data-id="<?php echo $id_kunjungan; ?>" data-from="data_view">
            <i class="bi bi-tag"></i>
        </button>
        <button type="button" class="btn btn-md btn-outline-secondary btn-icon modal_cetak_label" data-id="<?php echo $id_kunjungan; ?>" data-from="data_view">
            <i class="bi bi-printer"></i>
        </button>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-8 mb-3">
        <div class="card">
            <div class="card-header">
                <b class="card-title">
                    <i class="bi bi-info-circle"></i> Detail Kunjungan Pasien
                </b>
            </div>
            <div class="card-body">

                <!-- Identitas Pasien -->
                <div class="row mb-2">
                    <div class="col-8"><b><small>A. Identitas Pasien</small></b></div>
                    <div class="col-4 text-end">
                        <a href="javascript:void(0);" class="modal_detail_pasien" data-id="<?php echo $id_pasien; ?>">
                            <small class="text-primary">(Detail)</small>
                        </a>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4"><small>ID Pasien</small></div>
                    <div class="col-md-8">
                        <small class="text-muted"><?php echo $id_pasien; ?></small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4"><small>Nama Pasien</small></div>
                    <div class="col-md-8">
                        <small class="text-muted"><?php echo $nama; ?></small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4"><small>NIK</small></div>
                    <div class="col-md-8">
                        <small class="text-muted"><?php echo $nik; ?></small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4"><small>Nomor BPJS</small></div>
                    <div class="col-md-8">
                        <small class="text-muted"><?php echo $no_bpjs; ?></small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4"><small>ID IHS</small></div>
                    <div class="col-md-8">
                        <small class="text-muted"><?php echo $id_ihs; ?></small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4"><small>Gender</small></div>
                    <div class="col-md-8">
                        <small class="text-muted"><?php echo $gender; ?></small>
                    </div>
                </div>
                <hr>

                <!-- Informasi Kunjungan -->
                <div class="row mb-2">
                    <div class="col-12"><b><small>B. Informasi Kunjungan</small></b></div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4"><small>ID Kunjungan</small></div>
                    <div class="col-md-8">
                        <small class="text-muted"><?php echo $id_kunjungan; ?></small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4"><small>Tanggal Kunjungan</small></div>
                    <div class="col-md-8">
                        <small class="text-muted"><?php echo $datetime_daftar; ?></small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4"><small>Prioritas</small></div>
                    <div class="col-md-8">
                        <small class="text-muted"><?php echo $prioritas; ?></small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4"><small>Tujuan / Jenis Kunjungan</small></div>
                    <div class="col-md-8">
                        <small class="text-muted"><?php echo $jenis_kunjungan; ?></small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4"><small>Keluhan / Klinis</small></div>
                    <div class="col-md-8">
                        <small class="text-muted"><?php echo $keluhan; ?></small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4"><small>Status Kunjungan</small></div>
                    <div class="col-md-8">
                        <small class="text-muted"><?php echo $status_kunjungan; ?></small>
                    </div>
                </div>
                <hr>

                <!-- Poliklinik -->
                <div class="row mb-2">
                    <div class="col-12"><b><small>C. Poliklinik</small></b></div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4"><small>ID Poliklinik</small></div>
                    <div class="col-md-8">
                        <small class="text-muted"><?php echo $id_poliklinik; ?></small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4"><small>Kode Poliklinik</small></div>
                    <div class="col-md-8">
                        <small class="text-muted"><?php echo $kode_poliklinik; ?></small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4"><small>Poliklinik</small></div>
                    <div class="col-md-8">
                        <small class="text-muted"><?php echo $poliklinik; ?></small>
                    </div>
                </div>
                <hr>

                <!-- Kelas, Ruangan Dan Tempat Tidur -->
                <div class="row mb-2">
                    <div class="col-12"><b><small>D. Kelas, Ruangan & Tempat Tidur</small></b></div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4"><small>Kelas</small></div>
                    <div class="col-md-8">
                        <small class="text-muted"><?php echo $kelas; ?></small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4"><small>Ruang Rawat</small></div>
                    <div class="col-md-8">
                        <small class="text-muted"><?php echo $ruang_rawat; ?></small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4"><small>Tempat Tidur</small></div>
                    <div class="col-md-8">
                        <small class="text-muted"><?php echo $tempat_tidur; ?></small>
                    </div>
                </div>
                <hr>

                <!-- Dokter Penerima-->
                <div class="row mb-2">
                    <div class="col-12"><b><small>E. Dokter Penerima</small></b></div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4"><small>ID Dokter</small></div>
                    <div class="col-md-8">
                        <small class="text-muted"><?php echo $id_dokter; ?></small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4"><small>Kode Dokter</small></div>
                    <div class="col-md-8">
                        <small class="text-muted"><?php echo $kode_dokter; ?></small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4"><small>Nama Dokter</small></div>
                    <div class="col-md-8">
                        <small class="text-muted"><?php echo $dokter; ?></small>
                    </div>
                </div>
                <hr>

                <!-- Dokter DPJP-->
                <div class="row mb-2">
                    <div class="col-12"><b><small>F. Dokter DPJP</small></b></div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4"><small>ID Dokter</small></div>
                    <div class="col-md-8">
                        <small class="text-muted"><?php echo $dpjp_id; ?></small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4"><small>Kode Dokter</small></div>
                    <div class="col-md-8">
                        <small class="text-muted"><?php echo $dpjp_kode; ?></small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4"><small>Nama Dokter</small></div>
                    <div class="col-md-8">
                        <small class="text-muted"><?php echo $dpjp_nama; ?></small>
                    </div>
                </div>
                <hr>

                <!-- Kontak Darurat-->
                <div class="row mb-2">
                    <div class="col-12"><b><small>G. Kontak Darurat</small></b></div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4"><small>Nomor Kontak</small></div>
                    <div class="col-md-8">
                        <small class="text-muted"><?php echo $kontak_darurat_nomor; ?></small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4"><small>Nama Pemilik Kontak</small></div>
                    <div class="col-md-8">
                        <small class="text-muted"><?php echo $kontak_darurat_nama; ?></small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4"><small>Hubungan Dengan Pasien</small></div>
                    <div class="col-md-8">
                        <small class="text-muted"><?php echo $kontak_darurat_hubungan; ?></small>
                    </div>
                </div>
                <hr>

                <!-- Pembayaran Dan Penanggung-->
                <div class="row mb-2">
                    <div class="col-12"><b><small>H. Pembayaran & Penjamin</small></b></div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4"><small>Metode Pembayaran</small></div>
                    <div class="col-md-8">
                        <small class="text-muted"><?php echo $pembayaran_metode; ?></small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4"><small>Penanggung / Penjamin</small></div>
                    <div class="col-md-8">
                        <small class="text-muted"><?php echo $pembayaran_penanggung; ?></small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4"><small>SEP (Surat Eligibilitas Peserta)</small></div>
                    <div class="col-md-8">
                        <small class="text-muted"><?php echo $sep; ?></small>
                    </div>
                </div>
                <hr>

                <!-- Petugas Pendaftaran-->
                <div class="row mb-2">
                    <div class="col-12"><b><small>I. Petugas Pendaftaran</small></b></div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4"><small>ID Akses Petugas</small></div>
                    <div class="col-md-8">
                        <small class="text-muted"><?php echo $petugas_id; ?></small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4"><small>Nama Petugas</small></div>
                    <div class="col-md-8">
                        <small class="text-muted"><?php echo $petugas_nama; ?></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">

        <div class="card mb-3">
            <div class="card-header">
                <b><i class="bi bi-paperclip"></i> Lampiran Kunjungan</b>
            </div>
            <div class="card-body">
                <div class="accordion accordion-flush" id="accordionFlush">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse_1_1" aria-expanded="false" aria-controls="flush-collapse_1_1">
                                <i>General Consent</i>
                            </button>
                        </h2>
                        <div id="flush-collapse_1_1" class="accordion-collapse collapse" data-bs-parent="#accordionFlush" style="">
                            <div class="accordion-body">

                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse_1_2" aria-expanded="false" aria-controls="flush-collapse_1_2">
                                Observasi
                            </button>
                        </h2>
                        <div id="flush-collapse_1_2" class="accordion-collapse collapse" data-bs-parent="#accordionFlush" style="">
                            <div class="accordion-body">

                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse_1_2" aria-expanded="false" aria-controls="flush-collapse_1_2">
                                Diagnosis
                            </button>
                        </h2>
                        <div id="flush-collapse_1_2" class="accordion-collapse collapse" data-bs-parent="#accordionFlush" style="">
                            <div class="accordion-body">

                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse_1_2" aria-expanded="false" aria-controls="flush-collapse_1_2">
                                Tindakan Medis
                            </button>
                        </h2>
                        <div id="flush-collapse_1_2" class="accordion-collapse collapse" data-bs-parent="#accordionFlush" style="">
                            <div class="accordion-body">

                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse_1_2" aria-expanded="false" aria-controls="flush-collapse_1_2">
                                Penunjang
                            </button>
                        </h2>
                        <div id="flush-collapse_1_2" class="accordion-collapse collapse" data-bs-parent="#accordionFlush" style="">
                            <div class="accordion-body">

                            </div>
                        </div>
                    </div>


                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse_1_2" aria-expanded="false" aria-controls="flush-collapse_1_2">
                                Peresepan
                            </button>
                        </h2>
                        <div id="flush-collapse_1_2" class="accordion-collapse collapse" data-bs-parent="#accordionFlush" style="">
                            <div class="accordion-body">

                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse_1_6" aria-expanded="false" aria-controls="flush-collapse_1_6">
                                Resume
                            </button>
                        </h2>
                        <div id="flush-collapse_1_6" class="accordion-collapse collapse" data-bs-parent="#accordionFlush" style="">
                            <div class="accordion-body">

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <b>SATUSEHAT</b>
            </div>
            <div class="card-body">
                <div class="accordion accordion-flush" id="accordionFlush">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse1" aria-expanded="false" aria-controls="flush-collapse1">
                                <i>Encounter</i>
                            </button>
                        </h2>
                        <div id="flush-collapse1" class="accordion-collapse collapse" data-bs-parent="#accordionFlush" style="">
                            <div class="accordion-body">

                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse2" aria-expanded="false" aria-controls="flush-collapse2">
                                <i>Condition</i>
                            </button>
                        </h2>
                        <div id="flush-collapse2" class="accordion-collapse collapse" data-bs-parent="#accordionFlush" style="">
                            <div class="accordion-body">

                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse3" aria-expanded="false" aria-controls="flush-collapse3">
                                <i>Observation</i>
                            </button>
                        </h2>
                        <div id="flush-collapse3" class="accordion-collapse collapse" data-bs-parent="#accordionFlush" style="">
                            <div class="accordion-body">

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>