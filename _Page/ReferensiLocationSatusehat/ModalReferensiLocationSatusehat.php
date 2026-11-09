<?php 
    // Dapat kan id organisasi
    $id_org = getDataDetail($Conn,'setting_satusehat','status_setting_satusehat',1,'organization_id');
?>

<!-- filter -->
<div class="modal fade" id="ModalFilter" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesFilter" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-search"></i> Filter Location
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- PilDasar Pencarian Location -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="keyword_by"><small>Dasar Pencarian</small></label>
                            <select name="keyword_by" id="keyword_by" class="form-control">
                                <option value="organization_id">ID Organization</option>
                                <option value="location_id">ID Location</option>
                                <option value="location_name">Location Name</option>
                            </select>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="keyword_form"><small>Kata Kunci</small></label>
                            <input type="text" name="keyword" id="keyword_form" class="form-control" value="<?php echo $id_org; ?>">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded">
                        <i class="bi bi-search"></i> Filter
                    </button>
                    <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- MODAL TAMBAH -->
<div class="modal fade" id="ModalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambah" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-plus"></i> Tambah Location
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <!-- Form Tambah Location -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="name">Nama Lokasi</label>
                            <input type="text" name="name" id="name" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="mode">Mode Lokasi</label>
                            <select name="mode" id="mode" class="form-control">
                                <option value="instance|Instance">Lokasi spesifik yang dapat diidentifikasi secara individual.</option>
                                <option value="kind|Kind">Kategori atau kelompok dari suatu jenis lokasi.</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="type">Tipe Lokasi</label>
                            <select name="type" id="type" class="form-control">
                                <option value="si|Site">Area kompleks atau kawasan</option>
                                <option value="bu|Building">Bangunan</option>
                                <option value="wi|Wing">Sayap atau bagian gedung</option>
                                <option value="wa|Ward">Areal Bangsal Perawat</option>
                                <option value="lvl|Level">Tingkat atau lantai</option>
                                <option value="co|Corridor">Koridor</option>
                                <option value="ro|Room">Ruangan</option>
                                <option value="bd|Bed">Area Tempat Tidur</option>
                                <option value="ve|Vehicle">Kendaraan</option>
                                <option value="ho|House">Rumah Atau Hunian</option>
                                <option value="ca|Cabinet">Lemari Atau Tempat Penyimpanan</option>
                                <option value="rd|Road">Jalan</option>
                                <option value="area|Area">Area</option>
                                <option value="jdn|Jurisdiction">Wilayah kewenangan</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="description">Deskripsi</label>
                            <textarea name="description" id="description" class="form-control"></textarea>
                        </div>
                    </div>

                    <!-- Notifikasi Tambah Location -->
                    <div class="row mb-3">
                        <div class="col-12" id="NotifikasiTambah">
                            <!-- Notifikasi Tambah Location Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded" id="ButtonTambah">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL DETAIL LOCATION -->
<div class="modal fade" id="ModalDetail" tabindex="-1" aria-labelledby="ModalDetailLocationTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalDetailLocationTitle">
                    <i class="bi bi-info-circle"></i> Detail Location SATUSEHAT
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12" id="FormDetail">
                        <!-- Detail Location ditampilkan melalui AJAX. -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EDIT -->
<div class="modal fade" id="ModalEdit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEdit" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-pencil"></i> Edit Location
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <!-- Form Edit Location -->
                    <div class="row mb-3">
                        <div class="col-12" id="FormEdit">
                            <!-- Form Edit Location Akan Muncul Disini -->
                        </div>
                    </div>

                    <!-- Notifikasi Edit Location -->
                    <div class="row mb-3">
                        <div class="col-12" id="NotifikasiEdit">
                            <!-- Notifikasi Edit Location Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded" id="ButtonEdit">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL STATUS -->
<div class="modal fade" id="ModalStatus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesStatus" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-pencil"></i> Edit Status Location
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <!-- Form status Location -->
                    <div class="row mb-3">
                        <div class="col-12" id="FormStatus">
                            <!-- Form status Location Akan Muncul Disini -->
                        </div>
                    </div>

                    <!-- Notifikasi status Location -->
                    <div class="row mb-3">
                        <div class="col-12" id="NotifikasiStatus">
                            <!-- Notifikasi status Location Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded" id="ButtonStatus">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL DEFAULT -->
<div class="modal fade" id="ModalDefault" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesDefault" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-arrow-clockwise"></i> Update Default
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <!-- Form Default Location -->
                    <div class="row mb-3">
                        <div class="col-12" id="FormDefault">
                            <!-- Form status Location Akan Muncul Disini -->
                        </div>
                    </div>

                    <!-- Notifikasi Default Location -->
                    <div class="row mb-3">
                        <div class="col-12" id="NotifikasiDefault">
                            <!-- Notifikasi Default Location Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded" id="ButtonDefault">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>