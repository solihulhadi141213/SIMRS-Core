<form action="javascript:void(0);" id="ProsesTambahEntitas">
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card table-card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-10 mb-3">
                            <h4>Form Tambah Entitas Akses</h4>
                        </div>
                        <div class="col-md-2 mb-3">
                            <a href="index.php?Page=Akses&Sub=EntitasAkses" class="btn btn-sm btn-block btn-secondary">
                                <i class="ti ti-angle-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="akses"><dt>Nama Entitas Akses</dt></label>
                            <input type="text" id="akses" name="akses" class="form-control">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="deskripsi"><dt>Deskripsi/Gambaran Umum</dt></label>
                            <input type="text" id="deskripsi" name="deskripsi" class="form-control">
                        </div>
                    </div>
                    <?php
                        $no=1;
                        $QryKategoriReferensi = mysqli_query($Conn, "SELECT DISTINCT kategori FROM akses_ref");
                        while ($DataKategori = mysqli_fetch_array($QryKategoriReferensi)) {
                            $kategori= $DataKategori['kategori'];
                    ?>
                        <div class="row mb-4">
                            <div class="col-md-12">
                                Atur referensi fitur standar untuk entitas ini.
                                <dt><?php echo "$no. $kategori"; ?></dt>
                            </div>
                            <?php
                                $no2=1;
                                $QryReferensi = mysqli_query($Conn, "SELECT * FROM akses_ref WHERE kategori='$kategori'");
                                while ($DataReferensi = mysqli_fetch_array($QryReferensi)) {
                                    $id_akses_ref= $DataReferensi['id_akses_ref'];
                                    $nama_fitur= $DataReferensi['nama_fitur'];
                                    $kode= $DataReferensi['kode'];
                                    $keterangan= $DataReferensi['keterangan'];
                            ?>
                                <div class="col-md-12 ml-4">
                                    <?php echo "<input type='checkbox' id='Referensi$id_akses_ref' name='Referensi$id_akses_ref' value='Yes'> <label for='Referensi$id_akses_ref'>$no.$no2 $nama_fitur</label>"; ?>
                                </div>
                            <?php $no2++;} ?>
                        </div>
                    <?php $no++;} ?>
                    <div class="row">
                        <div class="col-md-12 mb-4" id="NotifikasiTambahEntitas">
                            <span class="text-primary">Pastikan Data Entitas yang Anda Input Sudah Sesuai</span>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-md btn-success">
                        <i class="ti-save"></i> Simpan
                    </button>
                    <button type="reset" class="btn btn-md btn-danger">
                        <i class="ti ti-reload"></i> Reset
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>