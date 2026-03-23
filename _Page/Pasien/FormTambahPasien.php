<?php 
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //Membuat RM Terbaru
    $Qry=mysqli_query($Conn, "SELECT max(id_pasien) as maksimal FROM pasien")or die(mysqli_error($Conn));
    while($Hasil=mysqli_fetch_array($Qry)){
        $NilaiMaxRm=$Hasil['maksimal'];
    }
    $MaxRm=$NilaiMaxRm+1;
?>
<form action="javascript:void(0);" id="ProsesTambahPasien">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-4 mt-3">
                <label for="id_pasien">
                        <dt>
                            No.RM
                            <a href="javascript:void(0);" class="btn-mini text-info" id="ReloadIdPasien">
                                <i class="ti-reload"></i> Reload
                            </a>
                        </dt>
                </label>
                <input type="text" name="id_pasien" id="GetIdpasien" class="form-control" value="<?php echo "$MaxRm";?>" required>
                <small id="NotifikasiIdPasien">No RM Terbaru</small>
            </div>
            <div class="col-md-4 mt-3">
                <label for="nik">
                    <dt>
                        No.KTP (NIK)
                        <a href="javascript:void(0);" class="btn-mini text-info" id="CekNikBpjs">
                            <i class="ti-search"></i> Cek
                        </a>
                    </dt>
                </label>
                <input type="text" name="nik" id="nik" class="form-control">
            </div>
            <div class="col-md-4 mt-3">
                <label for="no_bpjs">
                    <dt>
                        No.BPJS
                        <a href="javascript:void(0);" class="btn-mini text-info" id="CekNoKartuBpjs">
                            <i class="ti-search"></i> Cek
                        </a>
                    </dt>
                </label>
                <input type="text" name="no_bpjs" id="no_bpjs" class="form-control">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12" id="HasilCekPeserta">

            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mt-3">
                <label for="tanggal_daftar"><dt>Tgl.Daftar</dt></label>
                <input type="date" name="tanggal_daftar" id="tanggal_daftar" value="<?php echo date ('Y-m-d'); ?>" class="form-control" required>
            </div>
            <div class="col-md-8 mt-3">
                <label for="nama"><dt>Nama Pasien</dt></label>
                <input type="text" name="nama" id="nama" class="form-control" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mt-3">
                <label for="gender"><dt>Gender</dt></label>
                <select id="gender" name="gender" class="form-control" required>
                    <option value="">Pilih</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            <div class="col-md-4 mt-3">
                <label for="tempat_lahir"><dt>Tmp.Lahir</dt></label>
                <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control">
            </div>
            <div class="col-md-4 mt-3">
                <label for="tanggal_lahir"><dt>Tgl.Lahir</dt></label>
                <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mt-3">
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
            <div class="col-md-4 mt-3">
                <label for="kabupaten"><dt>Kabupaten/Kota</dt></label>
                <select id="kabupaten" name="kabupaten" class="form-control">
                    <option value="">Pilih</option>
                </select>
            </div>
            <div class="col-md-4 mt-3">
                <label for="kecamatan"><dt>Kecamatan</dt></label>
                <select id="kecamatan" name="kecamatan" class="form-control">
                    <option value="">Pilih</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mt-3">
                <label for="desa"><dt>Desa/Kelurahan</dt></label>
                <select id="desa" name="desa" class="form-control">
                    <option value="">Pilih</option>
                </select>
            </div>
            <div class="col-md-8 mt-3">
                <label for="alamat"><dt>Alamat</dt></label>
                <input type="text" name="alamat" id="alamat" class="form-control" required>
                <small>Keterangan Alamat Lengkap</small>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mt-3">
                <label for="kontak"><dt>No.Kontak Pasien</dt></label>
                <input type="text" name="kontak" id="kontak" class="form-control" placeholder="+62">
            </div>
            <div class="col-md-4 mt-3">
                <label for="kontak_darurat"><dt>No.Kontak (Darurat)</dt></label>
                <input type="text" name="kontak_darurat" id="kontak_darurat" class="form-control" placeholder="+62">
            </div>
            <div class="col-md-4 mt-3">
                <label for="penanggungjawab"><dt>Penanggung Jawab</dt></label>
                <input type="text" name="penanggungjawab" id="penanggungjawab" class="form-control">
                <small>Saran: Nama pemilik nomor darurat</small>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mt-3">
                <label for="golongan_darah"><dt>Golongan Darah</dt></label>
                <select id="golongan_darah" name="golongan_darah" class="form-control">
                    <option value="">Pilih</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="AB">AB</option>
                    <option value="O">O</option>
                </select>
            </div>
            <div class="col-md-4 mt-3">
                <label for="perkawinan"><dt>Status Pernikahan</dt></label>
                <select id="perkawinan" name="perkawinan" class="form-control">
                    <option value="">Pilih</option>
                    <option value="Lajang">Lajang</option>
                    <option value="Menikah">Menikah</option>
                    <option value="Janda">Janda</option>
                    <option value="Duda">Duda</option>
                </select>
            </div>
            <div class="col-md-4 mt-3">
                <label for="pekerjaan"><dt>Pekerjaan</dt></label>
                <select id="pekerjaan" name="pekerjaan" class="form-control">
                    <option value="">Pilih</option>
                    <option value="Tidak Bekerja">Tidak Bekerja</option>
                    <option value="Karyawan Swasta">Karyawan Swasta</option>
                    <option value="PNS">PNS/TNI/Polri</option>
                    <option value="Wirausaha">Wirausaha</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mt-3">
                <label for="gambar"><dt>Foto</dt></label>
                <input type="file" name="gambar" id="gambar" class="form-control">
            </div>
            <div class="col-md-4 mt-3">
                <label for="status"><dt>Status Data</dt></label>
                <select id="status" name="status" class="form-control" required>
                    <option value="">Pilih</option>
                    <option value="Aktiv">Aktiv</option>
                    <option value="Non-Aktiv">Non-Aktiv</option>
                    <option value="Meninggal">Meninggal</option>
                </select>
            </div>
            <div class="col-md-4 mt-3">
                <label for="updatetime"><dt>Updatetime</dt></label>
                <input type="text" readonly name="updatetime" id="updatetime" class="form-control" value="<?php echo date('Y-m-d H:i'); ?>" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mt-3" id="NotifikasiTambahPasien">
                <dt>Keterangan :</dt>
                Pastikan data yang anda input sudah benar.
            </div>
        </div>
    </div>
    <div class="modal-footer bg-primary">
        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-md btn-inverse mt-2 mr-2">
                    <i class=""></i> Simpan
                </button>
                <button type="button" class="btn btn-md btn-light mt-2 mr-2" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</form>