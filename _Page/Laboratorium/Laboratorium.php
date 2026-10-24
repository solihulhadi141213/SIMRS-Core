<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="bi bi-file-earmark-medical"></i> Laboratorium</a>
                    </h5>
                    <p class="m-b-0">Kelola Data Permintaan Pemeriksaan Laboratorium</p>
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
                                            <button type="button" class="btn btn-md btn-icon btn-outline-primary" data-bs-toggle="modal" data-bs-target="#ModalFilter" title="Filter Data">
                                                <i class="bi bi-filter"></i>
                                            </button>
                                            <button type="button" class="btn btn-md btn-icon btn-primary tambah_laboratorium" title="Buat Permintaan">
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
                                                    <td align="left"><small><b>No.RM</b></small></td>
                                                    <td align="left"><small><b>Nama</b></small></td>
                                                    <td align="left"><small><b>Tgl. Diminta</b></small></td>
                                                    <td align="left"><small><b>Dokter Pengirim</b></small></td>
                                                    <td align="center"><small><b>Perioritas</b></small></td>
                                                    <td align="center"><small><b>Status</b></small></td>
                                                    <td align="center"><small><b>Opsi</b></small></td>
                                                </tr>
                                            </thead>
                                            <tbody id="tabel_laboratorium">
                                                <!-- Baris Tabel Akan Tampil Disini -->
                                                <tr>
                                                    <td align="center" colspan="8">
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
                                            <button type="button" class="btn btn-sm btn-icon btn-outline-secondary" id="prev_button">
                                                <i class="bi bi-chevron-left"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-icon btn-outline-secondary" id="next_button">
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
                            <form action="javascript:void(0);" id="ProsesTambahLaboratorium" autocomplete="off">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="card-title">
                                                    <i class="bi bi-plus"></i> Pendaftaran Laboratorium
                                                </div>
                                            </div>
                                            <div class="col-4 icon-btn text-end">
                                                <button type="button" class="btn btn-md btn-dark btn-icon back_to_table_view">
                                                    <i class="bi bi-chevron-left"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">

                                        <div class="row mb-3">
                                            <div class="col-10">
                                                <small><b>A. Identitas Pasien (Rekam Medis)</b></small>
                                            </div>
                                            <div class="col-2 text-end">
                                                <a href="javascript:void(0);" class="pilih-pasien text-primary">
                                                   <i class="bi bi-search"></i> Cari
                                                </a>
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
                                                <label for="gender"><small>* Gender</small></label>
                                            </div>
                                            <div class="col-md-8">
                                                <select name="gender" id="gender" class="form-control" required>
                                                    <option value="">Pilih</option>
                                                    <option value="Perempuan">Perempuan</option>
                                                    <option value="Laki-laki">Laki-laki</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <label for="tanggal_lahir"><small>Tanggal Lahir</small></label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control">
                                            </div>
                                        </div>

                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <label for="ihs_pasien"><small><i>IHS (Indonesia Health Services)</i></small></label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="ihs_pasien" id="ihs_pasien" class="form-control">
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row mb-3 mt-3">
                                            <div class="col-10">
                                                <small><b>B. Informasi Kunjungan</b></small>
                                            </div>
                                            <div class="col-2 text-end">
                                                <a href="javascript:void(0);" class="pilih-kunjungan text-primary">
                                                   <i class="bi bi-search"></i> Cari
                                                </a>
                                            </div>
                                        </div>

                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <label for="id_kunjungan"><small>* ID Kunjungan (No.Reg)</small></label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="id_kunjungan" id="id_kunjungan" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <label for="tujuan"><small>* Tujuan Kunjungan</small></label>
                                            </div>
                                            <div class="col-md-8">
                                               <select name="tujuan" id="tujuan" class="form-control" required>
                                                    <option value="">Pilih</option>
                                                    <option value="Rajal">Rajal</option>
                                                    <option value="Ranap">Ranap</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <label for="pembayaran"><small>* Metode Pembayaran</small></label>
                                            </div>
                                            <div class="col-md-8">
                                               <input type="text" name="pembayaran" id="pembayaran" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <label for="fakses"><small>* Nama Faskes</small></label>
                                            </div>
                                            <div class="col-md-8">
                                               <input type="text" name="fakses" id="fakses" class="form-control" required value="<?php echo $hospital_name; ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <label for="unit"><small>* Unit/Instalasi/Ruangan</small></label>
                                            </div>
                                            <div class="col-md-8">
                                               <input type="text" name="unit" id="unit" class="form-control" required>
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
                                            <div class="col-10">
                                                <small><b>C. Dokter Pengirim</b></small>
                                            </div>
                                            <div class="col-2 text-end">
                                                <a href="javascript:void(0);" class="pilih-dokter text-primary">
                                                   <i class="bi bi-search"></i> Cari
                                                </a>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="nama_dokter_pengirim"><small>* Nama Dokter</small></label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="nama_dokter_pengirim" id="nama_dokter_pengirim" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <label for="kode_dokter_pengirim"><small>Kode Dokter (HFIS)</small></label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="kode_dokter_pengirim" id="kode_dokter_pengirim" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="ihs_dokter_pengirim"><small>IHS Dokter</small></label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="ihs_dokter_pengirim" id="ihs_dokter_pengirim" class="form-control">
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row mb-3 mt-3">
                                            <div class="col-10">
                                                <small><b>D. Alasan Permintaan (<i>Reson Code</i>)</b></small>
                                            </div>
                                            <div class="col-2 text-end">
                                                <a href="javascript:void(0);" class="pilih-diagnosis text-primary">
                                                   <i class="bi bi-search"></i> Cari
                                                </a>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <label for="nama_diagnosis"><small>Diagnosis</small></label>
                                            </div>
                                            <div class="col-md-8">
                                               <input type="text" name="nama_diagnosis" id="nama_diagnosis" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <label for="kode_diagnosis"><small>Kode Diagnosis</small></label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="kode_diagnosis" id="kode_diagnosis" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="system_diagnosis"><small>Reference System</small></label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="system_diagnosis" id="system_diagnosis" class="form-control">
                                            </div>
                                        </div>
                                        

                                        <hr>

                                        <div class="row mb-3 mt-3">
                                            <div class="col-12">
                                                <small><b>E. Permintaan Pemeriksaan</b></small>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="keterangan"><small>Keterangan Permintaan</small></label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="keterangan" id="keterangan" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <label for="priority"><small>* <i>Priority</i></small></label>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="d-flex flex-wrap gap-3 mb-4 mt-2">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="priority" id="prioritas_normal" value="routine" checked="">
                                                        <label class="form-check-label" for="prioritas_normal">
                                                            <small>Normal</small>
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="priority" id="prioritas_urgent" value="urgent">
                                                        <label class="form-check-label" for="prioritas_urgent">
                                                            <small>Urgent</small>
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="priority" id="prioritas_emergency" value="stat">
                                                        <label class="form-check-label" for="prioritas_emergency">
                                                            <small>Emergency</small>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3 mt-3">
                                            <div class="col-12">
                                                <div class="table table-responsive">
                                                    <table class="table table-bordered table-sm">
                                                        <thead>
                                                            <tr>
                                                                <th align="center"><b><small>No</small></b></th>
                                                                <th colspan="2"><b><small>Nama Pemeriksaan</small></b></th>
                                                                <th><b><small>Display</small></b></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tabel_referensi_pemeriksaan">
                                                            <tr>
                                                                <td colspan="4" class="text-center">
                                                                    <small>No Data</small>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row mb-3 mt-3">
                                            <div class="col-12">
                                                <small><b>E. Pernyataan Petugas</b></small>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <div class="alert alert-info">
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" id="pernyataan_petugas" name="pernyataan_petugas" value="1">
                                                        <label class="form-check-label" for="pernyataan_petugas">
                                                            <small>
                                                                <b>Pernyataan Pemohon</b><br>
                                                                Saya menyatakan bahwa seluruh data dan informasi pasien yang saya input telah sesuai dengan dokumen dan kondisi sebenarnya. 
                                                                Saya juga memahami serta berkomitmen untuk menjaga kerahasiaan data pasien sesuai dengan ketentuan etika dan peraturan perundang-undangan yang berlaku.
                                                            </small>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-2">
                                            <div class="col-12" id="NotifikasiTambahLaboratorium"></div>
                                        </div>

                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-md btn-primary rounded-2" id="ButtonTambahLaboratorium">
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
                                                <i class="bi bi-info-circle"></i> Detail Laboratorium
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
