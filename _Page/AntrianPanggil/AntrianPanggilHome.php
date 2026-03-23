<div class="row">
    <div class="col-md-12">
        <form action="javascript:void(0);" id="ProsesKoneksiMonitorAntrian">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <dt class="card-title"><i class="ti ti-desktop"></i> Setting Monitor Antrian</dt>
                        </div>
                        <div class="col col-md-2 mb-2">
                            <button type="button" class="btn btn-sm btn-info btn-block" data-toggle="modal" data-target="#ModalSettingKoneksiMonitor">
                                <i class="ti ti-settings"></i> Koneksi
                            </button>
                        </div>
                        <div class="col col-md-2 mb-2">
                            <button type="button" class="btn btn-sm btn-success btn-block" data-toggle="modal" data-target="#ModalCredentialMonitor">
                                <i class="ti ti-list-ol"></i> Credential
                            </button>
                        </div>
                        <div class="col col-md-2 mb-2">
                            <button type="button" class="btn btn-sm btn-secondary btn-block form-show">
                                <i class="ti ti-arrow-circle-down"></i> Lanjutan
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body" id="form-body-koneksi">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="kode_akses_get">Kode Akses</label>
                        </div>
                        <div class="col-md-8">
                            <div class="input-group">
                                <input type="text" class="form-control" name="kode_akses" id="kode_akses_get">
                                <button type="button" class="btn btn-sm btn-dark" data-toggle="modal" data-target="#ModalDetailCredential">
                                    Hubungkan <i class="ti ti-angle-double-down"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="title_monitor">Title/Judul</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="title_credential" id="title_monitor" placeholder="Contoh : Poli Dalam">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="sub_title_monitor">Sub title</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="sub_title_credential" id="sub_title_monitor" placeholder="Contoh : dr Laudry Amsal Elfa Gustanar., Sp.PD">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="link_monitor">Link Monitor</label>
                        </div>
                        <div class="col-md-8">
                            <div class="input-group">
                                <input type="text" readonly class="form-control" name="link_monitor" id="link_monitor" placeholder="https://">
                                <button type="button" class="btn btn-sm btn-dark" id="GenerateLinkMonitor">
                                    Generate <i class="ti ti-reload"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-8" id="NotifikasiKoneksiMonitorAntrian">
                            
                        </div>
                    </div>
                </div>
                <div class="card-footer" id="form-footer-koneksi">
                    <button type="submit" class="btn btn-sm btn-primary btn-block" id="ButtonKoneksiMonitorAntrian">
                        <i class="ti ti-save"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card mb-3">
            <form action="javascript:void(0);" id="PencarianAntrianPanggil">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12">
                            <dt><i class="ti ti-view-list"></i> Daftar Antrian Pasien</dt>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!--  Menampilkan Data Antrian Panggil -->
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label for="tanggal">Tanggal Layanan</label>
                        </div>
                        <div class="col-md-8">
                            <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label for="id_poliklinik">Poliklinik</label>
                        </div>
                        <div class="col-md-8">
                            <select name="id_poliklinik" id="id_poliklinik" class="form-control">
                                <option value="">Pilih</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label for="id_dokter">Dokter</label>
                        </div>
                        <div class="col-md-8">
                            <select name="id_dokter" id="id_dokter" class="form-control">
                                <option value="">Pilih</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label for="status">Status Antrian</label>
                        </div>
                        <div class="col-md-8">
                            <select name="status" id="status" class="form-control">
                                <option value="">Pilih</option>
                                <option value="Batal">0. Batal</option>
                                <option value="Terdaftar">1. Terdaftar</option>
                                <option value="Checkin">2. Checkin</option>
                                <option value="Panggil">3. Panggil Admisi</option>
                                <option value="Tunggu Poli">4. Tunggu Poli</option>
                                <option value="Layanan Poli">5. Layanan Poli</option>
                                <option value="Tunggu Farmasi">6. Tunggu Farmasi</option>
                                <option value="Layanan Farmasi">7. Layanan Farmasi</option>
                                <option value="Selesai">8. Selesai</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="kode_loket">Audio Tempat Panggil</label>
                        </div>
                        <div class="col-md-8">
                            <div class="input-group">
                                <select name="kode_loket" id="kode_loket" class="form-control">
                                    <option value="">Pilih</option>
                                    <?php
                                        $directory = "_Page/AntrianPanggil/Audio/Tempat";
                                        if (is_dir($directory)) {
                                            if ($handle = opendir($directory)) {
                                                while (false !== ($file = readdir($handle))) {
                                                    // Abaikan '.' dan '..'
                                                    if ($file != "." && $file != "..") {
                                                        $nama_file=htmlspecialchars($file);
                                                        echo '<option value="'.$nama_file.'">'.$nama_file.'</option>';
                                                    }
                                                }
                                                closedir($handle);
                                            }
                                        }
                                    ?>
                                </select>
                                <button type="button" class="btn btn-sm btn-dark" id="CekSoundTempatPanggil">
                                    Cek Sound
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-md btn-primary btn-block">
                                <i class="ti ti-arrow-circle-down"></i> Tampilkan
                            </button>
                        </div>
                    </div>
                    <div id="MenampilkanDataAntrianPanggil">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <div class="alert alert-secondary" role="alert">
                                    <dt>Belum Ada Data Yang Ditampilkan</dt>
                                    Silahkan Isi Parameter Diatas Terlebih Dulu.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    
                </div>
            </form>
        </div>
    </div>
</div>
