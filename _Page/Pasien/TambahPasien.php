<?php
    if(!empty($_GET['id_pasien_relasi'])){
        $id_pasien_relasi=$_GET['id_pasien_relasi'];
    }else{
        $id_pasien_relasi="";
    }
?>
<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <form action="javascript:void(0);" id="ProsesTambahPasien">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row mb-2">
                                        <div class="col-md-10 mb-2">
                                            <h4><i class="icofont-patient-file"></i> Tambah Pasien Baru</h4>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <a href="index.php?Page=Pasien" class="btn btn-sm btn-secondary btn-block">
                                                <i class="ti ti-angle-left"></i> Kembali
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h4 class="sub-title"><dt>Identitas Pasien</dt></h4>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="id_pasien">1. Nomor RM</label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="id_pasien" id="GetIdpasien">
                                                <button type="button" class="btn btn-sm btn-outline-secondary" id="ReloadIdPasien">
                                                    <i class="ti ti-reload"></i> Generate
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="id_pasien">2. Nomor KTP (NIK)</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="nik" id="nik">
                                            <a href="javascript:void(0);" class="text-primary mr-3" data-toggle="modal" data-target="#ModalCekNikBpjs">
                                                <small><i class="ti ti-new-window"></i> Cek Dari Service BPJS</small>
                                            </a>
                                            <a href="javascript:void(0);" class="text-primary mr-3" data-toggle="modal" data-target="#ModalCekNikSatuSehat">
                                                <small><i class="ti ti-new-window"></i> Cek Dari Service Satu Sehat</small>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="no_bpjs">3. Nomor Kartu BPJS</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="no_bpjs" id="no_bpjs">
                                            <a href="javascript:void(0);" class="text-primary mr-3" data-toggle="modal" data-target="#ModalCekNokaBpjs">
                                                <small><i class="ti ti-new-window"></i> Cek Kartu Dari Service BPJS</small>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="id_pasien">4. Nomor IHS</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="id_ihs" id="id_ihs">
                                            <a href="javascript:void(0);" class="text-primary mr-3" data-toggle="modal" data-target="#ModalCekIhs">
                                                <small><i class="ti ti-new-window"></i> Cek IHS</small>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="tanggal_daftar">5. Tanggal Daftar</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="date" name="tanggal_daftar" id="tanggal_daftar" value="<?php echo date ('Y-m-d'); ?>" class="form-control" >
                                            <small>Tanggal Daftar</small>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="time" name="jam_daftar" id="jam_daftar" value="<?php echo date ('H:i'); ?>" class="form-control" >
                                            <small>Jam Daftar</small>
                                        </div>
                                    </div>
                                    <h4 class="sub-title"><dt>Data Diri Pasien</dt></h4>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="nama">1. Nama Pasien (Sesuai Identitas)</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="nama" id="nama">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="gender">2. Gender</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select id="gender" name="gender" class="form-control" >
                                                <option value="">Pilih</option>
                                                <option value="Laki-laki">Laki-laki</option>
                                                <option value="Perempuan">Perempuan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="tempat_lahir">3. Tempat Lahir</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="tempat_lahir">4. Tanggal Lahir</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="golongan_darah">5. Golongan Darah</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select id="golongan_darah" name="golongan_darah" class="form-control">
                                                <option value="">Pilih</option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="AB">AB</option>
                                                <option value="O">O</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="perkawinan">6. Status Pernikahan</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select id="perkawinan" name="perkawinan" class="form-control">
                                                <option value="">Pilih</option>
                                                <option value="Lajang">Lajang</option>
                                                <option value="Menikah">Menikah</option>
                                                <option value="Janda">Janda</option>
                                                <option value="Duda">Duda</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="pekerjaan">7. Pekerjaan</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select id="pekerjaan" name="pekerjaan" class="form-control">
                                                <option value="">Pilih</option>
                                                <option value="Tidak Bekerja">Tidak Bekerja</option>
                                                <option value="Karyawan Swasta">Karyawan Swasta</option>
                                                <option value="PNS">PNS/TNI/Polri</option>
                                                <option value="Wirausaha">Wirausaha</option>
                                            </select>
                                        </div>
                                    </div>
                                    <h4 class="sub-title"><dt>Alamat & Kontak</dt></h4>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="propinsi">1. Provinsi</label>
                                        </div>
                                        <div class="col-md-9">
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
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="propinsi">2. Kabupaten/Kota</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select id="kabupaten" name="kabupaten" class="form-control">
                                                <option value="">Pilih</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="kecamatan">3. Kecamatan</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select id="kecamatan" name="kecamatan" class="form-control">
                                                <option value="">Pilih</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="desa">4. Desa/Kelurahan</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select id="desa" name="desa" class="form-control">
                                                <option value="">Pilih</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="alamat">5. RT/RW Jalan</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" name="alamat" id="alamat" class="form-control" >
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="kontak">6. Kontak (No.HP)</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" name="kontak" id="kontak" class="form-control" placeholder="+62">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="kontak_darurat">7. Kontak Darurat</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" name="kontak_darurat" id="kontak_darurat" class="form-control" placeholder="+62">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="alamat">8. Penanggung Jawab</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" name="penanggungjawab" id="penanggungjawab" class="form-control">
                                            <small>Saran: Nama pemilik nomor darurat</small>
                                        </div>
                                    </div>
                                    <h4 class="sub-title"><dt>Pasien Relasi</dt></h4>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="propinsi">1. No.RM Ibu</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" name="id_pasien_relasi" id="id_pasien_relasi" class="form-control" value="<?php echo $id_pasien_relasi;?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" id="NotifikasiTambahPasien">
                                            <span class="text-primary">Pastikan data yang anda input sudah benar.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-sm btn-primary">
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