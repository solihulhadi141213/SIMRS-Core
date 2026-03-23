<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="ti ti-plus"></i> Form Tambah Akun Pasien</a>
                    </h5>
                    <p class="m-b-0">Tambah akun akses pasien pada website.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-xl-12 col-md-12">
                        <form action="javascript:void(0);" id="ProsesTambahPasien">
                            <div class="card table-card">
                                <div class="card-header border-info">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <dt>Form Tambah Akun Akses Pasien</dt>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="index.php?Page=WebAksesPasien" class="btn btn-sm btn-block btn-secondary">
                                                <i class="ti ti-angle-left"></i> Kembali
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label for="id_pasien">No.RM</label>
                                            <input type="text" name="id_pasien" id="id_pasien" class="form-control">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="nik">NIK</label>
                                            <input type="text" name="nik" id="nik" class="form-control">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="bpjs">No.BPJS</label>
                                            <input type="text" name="bpjs" id="bpjs" class="form-control">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="tanggal_daftar">Tanggal Daftar</label>
                                            <input type="date" name="tanggal_daftar" id="tanggal_daftar" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label for="nama">Nama Lengkap</label>
                                            <input type="text" name="nama" id="nama" class="form-control">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="kontak">Kontak</label>
                                            <input type="text" name="kontak" id="kontak" class="form-control">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" id="email" class="form-control">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="password">Password</label>
                                            <input type="password" name="password" id="password" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label for="propinsi"><dt>Propinsi</dt></label>
                                            <select id="propinsi" name="propinsi" class="form-control">
                                                <option value="">Pilih</option>
                                                <?php
                                                    //Arraykan propinsi
                                                    $QryPropinsi = mysqli_query($Conn, "SELECT*FROM wilayah WHERE kategori='Propinsi' ORDER BY propinsi ASC");
                                                    while ($DataPropinsi = mysqli_fetch_array($QryPropinsi)) {
                                                        $propinsi= $DataPropinsi['propinsi'];
                                                        echo '<option value="'.$propinsi.'">'.$propinsi.'</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="kabupaten"><dt>Kabupaten/Kota</dt></label>
                                            <select id="kabupaten" name="kabupaten" class="form-control">
                                                <option value="">Pilih</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="kecamatan"><dt>Kecamatan</dt></label>
                                            <select id="kecamatan" name="kecamatan" class="form-control">
                                                <option value="">Pilih</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="desa"><dt>Desa/Kelurahan</dt></label>
                                            <select id="desa" name="desa" class="form-control">
                                                <option value="">Pilih</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="alamat">Alamat Selengkapnya</label>
                                            <input type="text" name="alamat" id="alamat" class="form-control">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="tepat_lahir">Tempat Lahir</label>
                                            <input type="text" name="tepat_lahir" id="tepat_lahir" class="form-control">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="tanggal_lahir">Tanggal Lahir</label>
                                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label for="gol_darah">Golongan Darah</label>
                                            <select id="gol_darah" name="gol_darah" class="form-control">
                                                <option value="">Pilih</option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="AB">AB</option>
                                                <option value="O">O</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="sex">Jenis Kelamin</label>
                                            <select id="sex" name="sex" class="form-control" required>
                                                <option value="">Pilih</option>
                                                <option value="Laki-laki">Laki-laki</option>
                                                <option value="Perempuan">Perempuan</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="pekerjaan">Pekerjaan</label>
                                            <select id="pekerjaan" name="pekerjaan" class="form-control">
                                                <option value="">Pilih</option>
                                                <option value="Tidak Bekerja">Tidak Bekerja</option>
                                                <option value="Karyawan Swasta">Karyawan Swasta</option>
                                                <option value="PNS">PNS/TNI/Polri</option>
                                                <option value="Wirausaha">Wirausaha</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="perkawinan">Status Perkawinan</label>
                                            <select id="perkawinan" name="perkawinan" class="form-control">
                                                <option value="">Pilih</option>
                                                <option value="Lajang">Lajang</option>
                                                <option value="Menikah">Menikah</option>
                                                <option value="Janda">Janda</option>
                                                <option value="Duda">Duda</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label for="status">Status Akun</label>
                                            <select id="status" name="status" class="form-control">
                                                <option value="">Pilih</option>
                                                <option value="Active">Active</option>
                                                <option value="Pending">Pending</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="token">Token</label>
                                            <input type="text" name="token" id="token" class="form-control">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="foto_profile">Foto</label>
                                            <input type="file" name="foto_profile" id="foto_profile" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col col-md-12 mb-3">
                                            <span class="text-primary" id="NotifikasiTambahPasien">Pastikan semua data Artikel sudah terisi dengan benar</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-md btn-primary">
                                        <i class="ti ti-save"></i> Simpan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>