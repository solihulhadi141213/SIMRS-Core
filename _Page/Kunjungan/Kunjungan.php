<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="bi bi-file-earmark-medical"></i> Kunjungan (<i>Encounter</i>)</a>
                    </h5>
                    <p class="m-b-0">Kelola Kunjungan Pasien Rawat Jalan Dan Rawat Inap</p>
                </div>
            </div>
            <div class="col-md-4 text-right">
            </div>
        </div>
    </div>
</div>
<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                
                <!-- TABEL VIEW -->
                <div id="table_view">
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="card w-100">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-4">
                                            
                                        </div>
                                        <div class="col-8 text-end icon-btn">
                                            <button type="button" class="btn btn-md btn-icon btn-outline-secondary" data-bs-toggle="dropdown" title="Export Data">
                                                <i class="bi bi-filetype-xlsx"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                <li>
                                                    <a class="dropdown-item modal_download" href="javascript:void(0)">Download / Export</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item modal_import" href="javascript:void(0)">Upload / Import</a>
                                                </li>
                                            </ul>
                                            <button type="button" class="btn btn-md btn-icon btn-outline-primary" data-bs-toggle="modal" data-bs-target="#ModalFilter" title="Filter Data">
                                                <i class="bi bi-filter"></i>
                                            </button>
                                            <button type="button" class="btn btn-md btn-icon btn-primary" data-bs-toggle="modal" data-bs-target="#ModalPilihPasien" title="Tambah Kunjungan">
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table table-responsive">
                                        <table class="table table-hover table-md">
                                            <thead>
                                                <tr>
                                                    <td align="center"><small><b>No</b></small></td>
                                                    <td align="left"><small><b>Nama</b></small></td>
                                                    <td align="left"><small><b>RM</b></small></td>
                                                    <td align="left"><small><b>Tanggal</b></small></td>
                                                    <td align="left"><small><b>Tujuan</b></small></td>
                                                    <td align="left"><small><b>Poli</b></small></td>
                                                    <td align="left"><small><b>Kelas</b></small></td>
                                                    <td align="left"><small><b>DPJP</b></small></td>
                                                    <td align="left"><small><b>Bayar</b></small></td>
                                                    <td align="center"><small><b>Perioritas</b></small></td>
                                                    <td align="center"><small><b>STTS</b></small></td>
                                                    <td align="center"><small><b>Opsi</b></small></td>
                                                </tr>
                                            </thead>
                                            <tbody id="tabel_kunjungan">
                                                <!-- Baris Tabel Akan Tampil Disini -->
                                                <tr>
                                                    <td align="center" colspan="12">
                                                        <small class="text text-muted">No Data</small>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-6">
                                            <small id="page_info">0 / 0</small>
                                        </div>
                                        <div class="col-6 text-end icon-btn">
                                            <button type="button" class="btn btn-sm btn-icon btn-outline-secondary" id="previous_page">
                                                <i class="bi bi-chevron-left"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-icon btn-outline-secondary" id="next_page">
                                                <i class="bi bi-chevron-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- REGISTRATION VIEW -->
                <div id="registration_view">
                    <div class="row mb-3">
                        <div class="col-12">
                            <form action="javascript:void(0);" id="ProsesTambahKunjungan" autocomplete="off">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="card-title">
                                                    <i class="bi bi-plus"></i> Pendaftaran Kunjungan Pasien
                                                </div>
                                            </div>
                                            <div class="col-6 icon-btn text-end">
                                                <button type="button" class="btn btn-md btn-dark btn-icon back_to_table_view">
                                                    <i class="bi bi-chevron-left"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">

                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <small><b>A. Identitas Pasien (Rekam Medis)</b></small>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <label for="id_pasien"><small>* Nomor Rekam Medis (RM)</small></label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="id_pasien" id="id_pasien" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <label for="nama"><small>* Nama Pasien</small></label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="nama" id="nama" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <label for="nik"><small>NIK (Nomor KTP)</small></label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="nik" id="nik" class="form-control">
                                            </div>
                                        </div>

                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <label for="no_bpjs"><small>Nomor Kartu BPJS</small></label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="no_bpjs" id="no_bpjs" class="form-control">
                                            </div>
                                        </div>

                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <label for="id_ihs"><small><i>IHS (Indonesia Health Services)</i></small></label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="id_ihs" id="id_ihs" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-12">
                                                <div class="alert alert-info">
                                                    <small><b>Penting!</b> Mengubah data ini akan memperbaharui data pasien. Lakukan perubahan data tersebut dengan bijak.</small>
                                                </div>
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

                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <label for="jenis_kunjungan"><small>* Tujuan Kunjungan</small></label>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="d-flex flex-wrap gap-3 mb-4 mt-2">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="jenis_kunjungan" id="jenis_kunjungan_rajal" value="Rajal" checked="">
                                                        <label class="form-check-label" for="jenis_kunjungan_rajal">
                                                            <small>Rawat Jalan (Rajal)</small>
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="jenis_kunjungan" id="jenis_kunjungan_ranap" value="Ranap">
                                                        <label class="form-check-label" for="jenis_kunjungan_ranap">
                                                            <small>Rawat Inap (Ranap)</small>
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
                                                <input type="text" name="keluhan" id="keluhan" class="form-control" required>
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
                                                    <input type="date" class="form-control" name="date_daftar" id="date_daftar" value="<?php echo date('Y-m-d'); ?>" required>
                                                    <input type="time" class="form-control" name="time_daftar" id="time_daftar" value="<?php echo date('H:i'); ?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="id_encounter"><small><i>ID Encounter (SATUSEHAT)</i></small></label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="id_encounter" id="id_encounter" class="form-control">
                                                <small><small class="text-muted">hanya jika sebelumnya sudah dibuatkan ID Encounter</small></small>
                                            </div>
                                        </div>

                                        <hr>
                                        
                                        <div class="row mb-3 mt-3">
                                            <div class="col-12">
                                                <small><b>C. Dokter Penerima</b></small>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <label for="id_dokter"><small>ID Dokter (SIMRS)</small></label>
                                            </div>
                                            <div class="col-md-8">
                                                <select name="id_dokter" id="id_dokter" class="form-control">
                                                    <!-- Load Data Dokter -->
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <label for="kode_dokter"><small>* Kode Dokter (HFIS)</small></label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="kode_dokter" id="kode_dokter" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="dokter"><small>* Nama Dokter</small></label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="dokter" id="dokter" class="form-control">
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row mb-3 mt-3">
                                            <div class="col-12">
                                                <small><b>E. Dokter DPJP</b></small>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <label for="dpjp_id"><small>ID Dokter (SIMRS)</small></label>
                                            </div>
                                            <div class="col-md-8">
                                                <select name="dpjp_id" id="dpjp_id" class="form-control">
                                                    <option value="">Pilih Dokter</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <label for="dpjp_kode"><small>Kode Dokter (HFIS)</small></label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="dpjp_kode" id="dpjp_kode" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="dpjp_nama"><small>Nama Dokter</small></label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="dpjp_nama" id="dpjp_nama" class="form-control">
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row mb-3 mt-3">
                                            <div class="col-12">
                                                <small><b>F. Poliklinik</b></small>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <label for="id_poliklinik"><small>ID Poliklinik (SIMRS)</small></label>
                                            </div>
                                            <div class="col-md-8">
                                                <select name="id_poliklinik" id="id_poliklinik" class="form-control">
                                                    <option value="">Pilih Poliklinik</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <label for="kode_poliklinik"><small>Kode Poliklinik (BPJS)</small></label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="kode_poliklinik" id="kode_poliklinik" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="poliklinik"><small>Nama Poliklinik</small></label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="poliklinik" id="poliklinik" class="form-control">
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row mb-3 mt-3">
                                            <div class="col-12">
                                                <small><b>G. Kelas / Ruang Inap (Pasien Rawat Inap)</b></small>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <label for="kelas"><small>Kelas Inap</small></label>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <input disabled type="text" name="kelas" id="kelas" class="form-control">
                                                    <input type="hidden" name="id_kelas_rawat" id="id_kelas_rawat">
                                                    <span class="input-group-text" data-bs-toggle="modal" data-bs-target="#ModalKelas">
                                                        <i class="bi bi-layers"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <label for="ruang_rawat"><small>Ruangan</small></label>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <input type="hidden" name="id_ruang_rawat" id="id_ruang_rawat">
                                                    <input disabled type="text" name="ruang_rawat" id="ruang_rawat" class="form-control">
                                                    <span class="input-group-text" data-bs-toggle="modal" data-bs-target="#ModalRuangan">
                                                        <i class="bi bi-layers"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <label for="tempat_tidur"><small>Tempat Tidur</small></label>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <input type="hidden" name="id_tempat_tidur" id="id_tempat_tidur">
                                                    <input disabled type="text" name="tempat_tidur" id="tempat_tidur" class="form-control">
                                                    <span class="input-group-text" data-bs-toggle="modal" data-bs-target="#ModalTempatTidur">
                                                        <i class="bi bi-layers"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row mb-3 mt-3">
                                            <div class="col-12">
                                                <small><b>H. Pembayaran Dan Penjaminan</b></small>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <label for="pembayaran_metode"><small>* Metode Pembayaran</small></label>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="d-flex flex-wrap gap-3 mb-4 mt-2">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="pembayaran_metode" id="pembayaran_metode_umum" value="UMUM" checked="">
                                                        <label class="form-check-label" for="pembayaran_metode_umum">
                                                            <small>UMUM</small>
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="pembayaran_metode" id="pembayaran_metode_asuransi" value="ASURANSI">
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
                                                <small><b>I. Kontak Darurat</b></small>
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
                                                <small><b>J. Pernyataan Petugas</b></small>
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

                                        <div class="row mb-2">
                                            <div class="col-12" id="NotifikasiTambahKunjungan"></div>
                                        </div>

                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" disabled class="btn btn-md btn-primary rounded-2" id="ButtonTambahKunjungan">
                                            <i class="bi bi-save"></i> Simpan
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- DETAIL VIEW -->
                <div id="detail_view">
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="card-title">
                                                <i class="bi bi-info-circle"></i> Detail Kunjungan Pasien
                                            </div>
                                        </div>
                                        <div class="col-6 icon-btn text-end">
                                            <button type="button" class="btn btn-md btn-dark btn-icon back_to_table_view">
                                                <i class="bi bi-chevron-left"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
