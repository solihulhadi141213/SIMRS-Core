<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Tangkap id_pasien
    if(empty($_POST['id_pasien'])){
        echo '<div class="card-body border-0 pb-0">';
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          Data ID Akses Tidak Dapat didefinisikan.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_pasien=$_POST['id_pasien'];
        //Buka data Pasien
        $QryPasien = mysqli_query($Conn,"SELECT * FROM pasien WHERE id_pasien='$id_pasien'")or die(mysqli_error($Conn));
        $DataPasien = mysqli_fetch_array($QryPasien);
        $id_pasien= $DataPasien['id_pasien'];
        $noRm=sprintf("%07d", $id_pasien);
        $tanggal_daftar= $DataPasien['tanggal_daftar'];
        $nik= $DataPasien['nik'];
        $no_bpjs= $DataPasien['no_bpjs'];
        $nama= $DataPasien['nama'];
        $gender= $DataPasien['gender'];
        $tempat_lahir= $DataPasien['tempat_lahir'];
        $tanggal_lahir= $DataPasien['tanggal_lahir'];
        $propinsi= $DataPasien['propinsi'];
        $kabupaten= $DataPasien['kabupaten'];
        $kecamatan= $DataPasien['kecamatan'];
        $desa= $DataPasien['desa'];
        $alamat= $DataPasien['alamat'];
        $kontak= $DataPasien['kontak'];
        $kontak_darurat= $DataPasien['kontak_darurat'];
        $penanggungjawab= $DataPasien['penanggungjawab'];
        $golongan_darah= $DataPasien['golongan_darah'];
        $perkawinan= $DataPasien['perkawinan'];
        $pekerjaan= $DataPasien['pekerjaan'];
        $status= $DataPasien['status'];
        $gambar= $DataPasien['gambar'];
        $updatetime= $DataPasien['updatetime'];
        //Inisiasi gender 
        if($gender=="Laki-laki"){
            $labelGender='<label class="label label-info">Male</label>';
        }else{
            if($gender=="Perempuan"){
                $labelGender='<label class="label label-primary">Female</label>';
            }else{
                $labelGender='<label class="label label-danger">None</label>';
            }
        }
        if(empty($gambar)){
            $LinkGambar="avatar-blank.jpg";
        }else{
            $LinkGambar="pasien/$gambar";
        }
        //Inisiasi Status
        //Status ada yang aktiv dan meninggal

        if($status=="Aktiv"){
            $LabelData='<label class="label label-success"><i class="ti ti-check-box"></i> Aktiv</label>';
        }else{
            if($status=="Meninggal"){
                $LabelData='<label class="label label-danger"><i class="icofont-close-squared"></i> Meninggal</label>';
            }else{
                $LabelData='<label class="label label-info">'.$status.'</label>';
            }
        }
?>
    <form action="javascript:void(0);" id="ProsesEditPasien">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-4 mt-3">
                    <label for="id_pasien">
                            <dt>
                                No.RM
                            </dt>
                    </label>
                    <input type="text" readonly name="id_pasien" id="GetIdpasien" class="form-control" value="<?php echo "$id_pasien";?>" required>
                </div>
                <div class="col-md-4 mt-3">
                    <label for="nik">
                        <dt>
                            No.KTP (NIK)
                            <a href="javascript:void(0);" class="btn-mini text-info" id="CekNikBpjs2">
                                <i class="ti-search"></i> Cek
                            </a>
                        </dt>
                    </label>
                    <input type="text" name="nik" id="nik" class="form-control" value="<?php echo "$nik"; ?>">
                </div>
                <div class="col-md-4 mt-3">
                    <label for="no_bpjs">
                        <dt>
                            No.BPJS
                            <a href="javascript:void(0);" class="btn-mini text-info" id="CekNoBpjs2">
                                <i class="ti-search"></i> Cek
                            </a>
                        </dt>
                    </label>
                    <input type="text" name="no_bpjs" id="no_bpjs" class="form-control" value="<?php echo "$no_bpjs"; ?>">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12" id="HasilCekPeserta2">

                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mt-3">
                    <label for="tanggal_daftar"><dt>Tgl.Daftar</dt></label>
                    <input type="date" name="tanggal_daftar" id="tanggal_daftar" value="<?php echo "$tanggal_daftar"; ?>" class="form-control" required>
                </div>
                <div class="col-md-8 mt-3">
                    <label for="nama"><dt>Nama Pasien</dt></label>
                    <input type="text" name="nama" id="nama" class="form-control" value="<?php echo "$nama"; ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mt-3">
                    <label for="gender"><dt>Gender</dt></label>
                    <select id="gender" name="gender" class="form-control" required>
                        <option <?php if($gender==""){echo "selected";} ?> value="">Pilih</option>
                        <option <?php if($gender=="Laki-laki"){echo "selected";} ?> value="Laki-laki">Laki-laki</option>
                        <option <?php if($gender=="Perempuan"){echo "selected";} ?> value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="col-md-4 mt-3">
                    <label for="tempat_lahir"><dt>Tmp.Lahir</dt></label>
                    <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" value="<?php echo "$tempat_lahir"; ?>">
                </div>
                <div class="col-md-4 mt-3">
                    <label for="tanggal_lahir"><dt>Tgl.Lahir</dt></label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="<?php echo "$tanggal_lahir"; ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mt-3">
                    <label for="propinsi"><dt>Propinsi</dt></label>
                    <select id="propinsi2" name="propinsi" class="form-control">
                        <option value="">Pilih</option>
                        <?php
                            //Arraykan propinsi
                            $QryPropinsi = mysqli_query($Conn, "SELECT*FROM wilayah WHERE kategori='Propinsi' ORDER BY propinsi ASC");
                            while ($DataPropinsi = mysqli_fetch_array($QryPropinsi)) {
                                $PropinsiList= $DataPropinsi['propinsi'];
                                if($propinsi==$PropinsiList){
                                    echo '<option selected value="'.$PropinsiList.'">'.$PropinsiList.'</option>';
                                }else{
                                    echo '<option value="'.$PropinsiList.'">'.$PropinsiList.'</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="col-md-4 mt-3">
                    <label for="kabupaten"><dt>Kabupaten/Kota</dt></label>
                    <select id="kabupaten2" name="kabupaten" class="form-control">
                        <option value="">Pilih</option>
                        <?php
                            //Arraykan Kabupaten
                            $QryKabupaten = mysqli_query($Conn, "SELECT*FROM wilayah WHERE kategori='Kabupaten' AND propinsi='$propinsi' ORDER BY kabupaten ASC");
                            while ($DataKabupaten = mysqli_fetch_array($QryKabupaten)) {
                                $KabupatenList= $DataKabupaten['kabupaten'];
                                if($kabupaten==$KabupatenList){
                                    echo '<option selected value="'.$KabupatenList.'">'.$KabupatenList.'</option>';
                                }else{
                                    echo '<option value="'.$KabupatenList.'">'.$KabupatenList.'</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="col-md-4 mt-3">
                    <label for="kecamatan"><dt>Kecamatan</dt></label>
                    <select id="kecamatan2" name="kecamatan" class="form-control">
                        <option value="">Pilih</option>
                        <?php
                            //Arraykan Kecamatan
                            $QryKecamatan = mysqli_query($Conn, "SELECT*FROM wilayah WHERE kategori='Kecamatan' AND propinsi='$propinsi' AND kabupaten='$kabupaten' ORDER BY kecamatan ASC");
                            while ($DataKecamatan = mysqli_fetch_array($QryKecamatan)) {
                                $KecamatanList= $DataKecamatan['kecamatan'];
                                if($kecamatan==$KecamatanList){
                                    echo '<option selected value="'.$KecamatanList.'">'.$KecamatanList.'</option>';
                                }else{
                                    echo '<option value="'.$KecamatanList.'">'.$KecamatanList.'</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mt-3">
                    <label for="desa"><dt>Desa/Kelurahan</dt></label>
                    <select id="desa2" name="desa" class="form-control">
                        <option value="">Pilih</option>
                        <?php
                            //Arraykan Desa
                            $QryDesa = mysqli_query($Conn, "SELECT*FROM wilayah WHERE kategori='desa' AND propinsi='$propinsi' AND kabupaten='$kabupaten' AND kecamatan='$kecamatan' ORDER BY desa ASC");
                            while ($DataDesa = mysqli_fetch_array($QryDesa)) {
                                $DesaList= $DataDesa['desa'];
                                if($DesaList==$desa){
                                    echo '<option selected value="'.$DesaList.'">'.$DesaList.'</option>';
                                }else{
                                    echo '<option value="'.$DesaList.'">'.$DesaList.'</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="col-md-8 mt-3">
                    <label for="alamat"><dt>Alamat</dt></label>
                    <input type="text" name="alamat" id="alamat" class="form-control" value="<?php echo "$alamat"; ?>" required>
                    <small>Keterangan Alamat Lengkap</small>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mt-3">
                    <label for="kontak"><dt>No.Kontak Pasien</dt></label>
                    <input type="text" name="kontak" id="kontak" class="form-control" placeholder="+62" value="<?php echo "$kontak"; ?>">
                </div>
                <div class="col-md-4 mt-3">
                    <label for="kontak_darurat"><dt>No.Kontak (Darurat)</dt></label>
                    <input type="text" name="kontak_darurat" id="kontak_darurat" class="form-control" placeholder="+62" value="<?php echo "$kontak_darurat"; ?>">
                </div>
                <div class="col-md-4 mt-3">
                    <label for="penanggungjawab"><dt>Penanggung Jawab</dt></label>
                    <input type="text" name="penanggungjawab" id="penanggungjawab" class="form-control" value="<?php echo "$penanggungjawab"; ?>">
                    <small>Saran: Nama pemilik nomor darurat</small>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mt-3">
                    <label for="golongan_darah"><dt>Golongan Darah</dt></label>
                    <select id="golongan_darah" name="golongan_darah" class="form-control">
                        <option <?php if($golongan_darah==""){echo "selected";} ?> value="">Pilih</option>
                        <option <?php if($golongan_darah=="A"){echo "selected";} ?> value="A">A</option>
                        <option <?php if($golongan_darah=="B"){echo "selected";} ?> value="B">B</option>
                        <option <?php if($golongan_darah=="AB"){echo "selected";} ?> value="AB">AB</option>
                        <option <?php if($golongan_darah=="O"){echo "selected";} ?> value="O">O</option>
                    </select>
                </div>
                <div class="col-md-4 mt-3">
                    <label for="perkawinan"><dt>Status Pernikahan</dt></label>
                    <select id="perkawinan" name="perkawinan" class="form-control">
                        <option <?php if($perkawinan==""){echo "selected";} ?> value="">Pilih</option>
                        <option <?php if($perkawinan=="Lajang"){echo "selected";} ?> value="Lajang">Lajang</option>
                        <option <?php if($perkawinan=="Menikah"){echo "selected";} ?> value="Menikah">Menikah</option>
                        <option <?php if($perkawinan=="Janda"){echo "selected";} ?> value="Janda">Janda</option>
                        <option <?php if($perkawinan=="Duda"){echo "selected";} ?> value="Duda">Duda</option>
                    </select>
                </div>
                <div class="col-md-4 mt-3">
                    <label for="pekerjaan"><dt>Pekerjaan</dt></label>
                    <select id="pekerjaan" name="pekerjaan" class="form-control">
                        <option <?php if($pekerjaan==""){echo "selected";} ?> value="">Pilih</option>
                        <option <?php if($pekerjaan=="Tidak Bekerja"){echo "selected";} ?> value="Tidak Bekerja">Tidak Bekerja</option>
                        <option <?php if($pekerjaan=="Karyawan Swasta"){echo "selected";} ?> value="Karyawan Swasta">Karyawan Swasta</option>
                        <option <?php if($pekerjaan=="PNS"){echo "selected";} ?> value="PNS">PNS/TNI/Polri</option>
                        <option <?php if($pekerjaan=="Wirausaha"){echo "selected";} ?> value="Wirausaha">Wirausaha</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mt-3">
                    <label for="gambar"><dt>Foto</dt></label>
                    <input type="file" name="gambar" id="gambar" class="form-control">
                    <small>File: <a href="assets/images/<?php echo "$LinkGambar"; ?>" target="_blank"><?php echo "$gambar"; ?></a></small>
                </div>
                <div class="col-md-4 mt-3">
                    <label for="status"><dt>Status Data</dt></label>
                    <select id="status" name="status" class="form-control" required>
                        <option <?php if($status==""){echo "selected";} ?> value="">Pilih</option>
                        <option <?php if($status=="Aktiv"){echo "selected";} ?> value="Aktiv">Aktiv</option>
                        <option <?php if($status=="Non-Aktiv"){echo "selected";} ?> value="Non-Aktiv">Non-Aktiv</option>
                        <option <?php if($status=="Meninggal"){echo "selected";} ?> value="Meninggal">Meninggal</option>
                    </select>
                </div>
                <div class="col-md-4 mt-3">
                    <label for="updatetime"><dt>Updatetime</dt></label>
                    <input type="text" readonly name="updatetime" id="updatetime" class="form-control" value="<?php echo date('Y-m-d H:i'); ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mt-3" id="NotifikasiEditPasien">
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
<?php } ?>