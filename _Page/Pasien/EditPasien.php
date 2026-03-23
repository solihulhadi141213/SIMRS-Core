<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <?php
                            if(empty($_GET['id'])){
                                echo '<div class="card">';
                                echo '  <div class="card-body">';
                                echo '      <div class="row">';
                                echo '          <div class="col-md-12 text-center text-danger">';
                                echo '              ID Pasien Tidak Boleh Kosong!';
                                echo '          </div>';
                                echo '      </div>';
                                echo '  </div>';
                                echo '</div>';
                            }else{
                                include "_Config/SimrsFunction.php"; 
                                $id_pasien=$_GET['id'];
                                if(empty($_SESSION['UrlBackPasien'])){
                                    $UrlBack='index.php?Page=Pasien';
                                }else{
                                    $UrlBack=$_SESSION['UrlBackPasien'];
                                }
                                //Buka Data Pasien
                                $id_ihs=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'id_ihs');
                                $tanggal_daftar=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'tanggal_daftar');
                                $nik=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'nik');
                                $no_bpjs=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'no_bpjs');
                                $nama=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'nama');
                                $gender=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'gender');
                                $tempat_lahir=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'tempat_lahir');
                                $tanggal_lahir=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'tanggal_lahir');
                                $propinsi=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'propinsi');
                                $kabupaten=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'kabupaten');
                                $kecamatan=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'kecamatan');
                                $desa=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'desa');
                                $alamat=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'alamat');
                                $kontak=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'kontak');
                                $kontak_darurat=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'kontak_darurat');
                                $penanggungjawab=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'penanggungjawab');
                                $golongan_darah=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'golongan_darah');
                                $perkawinan=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'perkawinan');
                                $pekerjaan=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'pekerjaan');
                                $gambar=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'gambar');
                                $status=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'status');
                                $id_pasien_relasi=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'id_pasien_relasi');
                                $status_relasi=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'status_relasi');
                                $updatetime=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'updatetime');
                                //Format Tanggal Daftar
                                $strtotime=strtotime($tanggal_daftar);
                                $TanggalDaftarFormat=date('Y-m-d',$strtotime);
                                $JamDaftarFormat=date('H:i',$strtotime);
                        ?>
                            <form action="javascript:void(0);" id="ProsesEditPasien">
                                <input type="hidden"  name="UrlForBack" id="UrlForBack" value="<?php echo $UrlBack;?>">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row mb-2">
                                            <div class="col-md-10 mb-2">
                                                <h4><i class="ti ti-pencil-alt"></i> Edit Data Pasien</h4>
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <a href="<?php echo $UrlBack; ?>" class="btn btn-sm btn-secondary btn-block" title="Kembali Ke Halaman Sebelumnya">
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
                                                <input type="text" readonly class="form-control" name="id_pasien" id="id_pasien" value="<?php echo $id_pasien;?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="id_pasien">2. Nomor KTP (NIK)</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="nik" id="nik" value="<?php echo $nik;?>">
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
                                                <input type="text" class="form-control" name="no_bpjs" id="no_bpjs" value="<?php echo $no_bpjs;?>">
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
                                                <input type="text" class="form-control" name="id_ihs" id="id_ihs" value="<?php echo $id_ihs;?>">
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
                                                <input type="date" name="tanggal_daftar" id="tanggal_daftar" value="<?php echo $TanggalDaftarFormat; ?>" class="form-control" >
                                                <small>Tanggal Daftar</small>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="time" name="jam_daftar" id="jam_daftar" value="<?php echo $JamDaftarFormat; ?>" class="form-control" >
                                                <small>Jam Daftar</small>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="tanggal_daftar">6. Status Pasien</label>
                                            </div>
                                            <div class="col-md-9">
                                                <select id="status" name="status" class="form-control" required>
                                                    <option <?php if($status==""){echo "selected";} ?> value="">Pilih</option>
                                                    <option <?php if($status=="Aktiv"){echo "selected";} ?> value="Aktiv">Aktiv</option>
                                                    <option <?php if($status=="Non-Aktiv"){echo "selected";} ?> value="Non-Aktiv">Non-Aktiv</option>
                                                    <option <?php if($status=="Meninggal"){echo "selected";} ?> value="Meninggal">Meninggal</option>
                                                </select>
                                            </div>
                                        </div>
                                        <h4 class="sub-title"><dt>Data Diri Pasien</dt></h4>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="nama">1. Nama Pasien (Sesuai Identitas)</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="nama" id="nama" value="<?php echo $nama; ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="gender">2. Gender</label>
                                            </div>
                                            <div class="col-md-9">
                                                <select id="gender" name="gender" class="form-control" >
                                                    <option <?php if($gender==""){echo "selected";} ?> value="">Pilih</option>
                                                    <option <?php if($gender=="Laki-laki"){echo "selected";} ?> value="Laki-laki">Laki-laki</option>
                                                    <option <?php if($gender=="Perempuan"){echo "selected";} ?> value="Perempuan">Perempuan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="tempat_lahir">3. Tempat Lahir</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" value="<?php echo $tempat_lahir; ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="tempat_lahir">4. Tanggal Lahir</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="<?php echo $tanggal_lahir; ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="golongan_darah">5. Golongan Darah</label>
                                            </div>
                                            <div class="col-md-9">
                                                <select id="golongan_darah" name="golongan_darah" class="form-control">
                                                    <option <?php if($golongan_darah==""){echo "selected";} ?> value="">Pilih</option>
                                                    <option <?php if($golongan_darah=="A"){echo "selected";} ?> value="A">A</option>
                                                    <option <?php if($golongan_darah=="B"){echo "selected";} ?> value="B">B</option>
                                                    <option <?php if($golongan_darah=="AB"){echo "selected";} ?> value="AB">AB</option>
                                                    <option <?php if($golongan_darah=="O"){echo "selected";} ?> value="O">O</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="perkawinan">6. Status Pernikahan</label>
                                            </div>
                                            <div class="col-md-9">
                                                <select id="perkawinan" name="perkawinan" class="form-control">
                                                    <option <?php if($perkawinan==""){echo "selected";} ?> value="">Pilih</option>
                                                    <option <?php if($perkawinan=="Lajang"){echo "selected";} ?> value="Lajang">Lajang</option>
                                                    <option <?php if($perkawinan=="Menikah"){echo "selected";} ?> value="Menikah">Menikah</option>
                                                    <option <?php if($perkawinan=="Janda"){echo "selected";} ?> value="Janda">Janda</option>
                                                    <option <?php if($perkawinan=="Duda"){echo "selected";} ?> value="Duda">Duda</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="pekerjaan">7. Pekerjaan</label>
                                            </div>
                                            <div class="col-md-9">
                                                <select id="pekerjaan" name="pekerjaan" class="form-control">
                                                    <option <?php if($pekerjaan==""){echo "selected";} ?> value="">Pilih</option>
                                                    <option <?php if($pekerjaan=="Tidak Bekerja"){echo "selected";} ?> value="Tidak Bekerja">Tidak Bekerja</option>
                                                    <option <?php if($pekerjaan=="Karyawan Swasta"){echo "selected";} ?> value="Karyawan Swasta">Karyawan Swasta</option>
                                                    <option <?php if($pekerjaan=="PNS"){echo "selected";} ?> value="PNS">PNS/TNI/Polri</option>
                                                    <option <?php if($pekerjaan=="Wirausaha"){echo "selected";} ?> value="Wirausaha">Wirausaha</option>
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
                                                            $ProvinsiList= $DataPropinsi['propinsi'];
                                                            if($ProvinsiList==$propinsi){
                                                                echo '<option selected value="'.$ProvinsiList.'">'.$ProvinsiList.'</option>';
                                                            }else{
                                                                echo '<option value="'.$ProvinsiList.'">'.$ProvinsiList.'</option>';
                                                            }
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
                                                    <?php
                                                        //Arraykan Kabupaten
                                                        $QryKabupaten = mysqli_query($Conn, "SELECT*FROM wilayah WHERE kategori='Kabupaten' AND propinsi='$propinsi' ORDER BY kabupaten ASC");
                                                        while ($DataKabupaten = mysqli_fetch_array($QryKabupaten)) {
                                                            $KabupatenList= $DataKabupaten['kabupaten'];
                                                            if($KabupatenList==$kabupaten){
                                                                echo '<option selected value="'.$KabupatenList.'">'.$KabupatenList.'</option>';
                                                            }else{
                                                                echo '<option value="'.$KabupatenList.'">'.$KabupatenList.'</option>';
                                                            }
                                                        }
                                                    ?>
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
                                                    <?php
                                                        //Arraykan Kecamatan
                                                        $QryKecamatan = mysqli_query($Conn, "SELECT*FROM wilayah WHERE kategori='Kecamatan' AND kabupaten='$kabupaten' ORDER BY kecamatan ASC");
                                                        while ($DataKecamatan = mysqli_fetch_array($QryKecamatan)) {
                                                            $KecamatanList= $DataKecamatan['kecamatan'];
                                                            if($KecamatanList==$kecamatan){
                                                                echo '<option selected value="'.$KecamatanList.'">'.$KecamatanList.'</option>';
                                                            }else{
                                                                echo '<option value="'.$KecamatanList.'">'.$KecamatanList.'</option>';
                                                            }
                                                        }
                                                    ?>
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
                                                    <?php
                                                        //Arraykan Desa
                                                        $QryDesa = mysqli_query($Conn, "SELECT*FROM wilayah WHERE kategori='desa' AND kecamatan='$kecamatan' ORDER BY desa ASC");
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
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="alamat">5. RT/RW Jalan</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" name="alamat" id="alamat" class="form-control" value="<?php echo $alamat ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="kontak">6. Kontak (No.HP)</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" name="kontak" id="kontak" class="form-control" placeholder="+62" value="<?php echo $kontak ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="kontak_darurat">7. Kontak Darurat</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" name="kontak_darurat" id="kontak_darurat" class="form-control" placeholder="+62" value="<?php echo $kontak_darurat ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="alamat">8. Penanggung Jawab</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" name="penanggungjawab" id="penanggungjawab" class="form-control" value="<?php echo $penanggungjawab ?>">
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
                                            <div class="col-md-12" id="NotifikasiEditPasien">
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
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>