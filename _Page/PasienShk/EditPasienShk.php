<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-xl-12 col-md-12">
                        <?php
                            if(empty($_GET['id_pasien_shk'])){
                                echo '<div class="card mb-2">';
                                echo '  <div class="card-body">';
                                echo '      ID Pasien SHK Tidak Boleh Kosong';
                                echo '  </div>';
                                echo '</div>';
                            }else{
                                $id_pasien_shk=$_GET['id_pasien_shk'];
                                //Validasi hanya boleh angka
                                if(!preg_match("/^[0-9]*$/", $id_pasien_shk)){
                                    echo '<div class="card mb-2">';
                                    echo '  <div class="card-body">';
                                    echo '      ID Pasien SHK Tidak Valid';
                                    echo '  </div>';
                                    echo '</div>';
                                }else{
                                    include "_Config/SimrsFunction.php";
                                    include "_Config/FungsiSirsOnline.php";
                                    //Bukka Atribut SHK
                                    $id_pasien_shk=getDataDetail($Conn,'pasien_shk','id_pasien_shk',$id_pasien_shk,'id_pasien_shk');
                                    if(empty($id_pasien_shk)){
                                        echo '<div class="card mb-2">';
                                        echo '  <div class="card-body">';
                                        echo '      ID Pasien SHK Tidak Valid Atau Tidak Ditemukan Pada Database';
                                        echo '  </div>';
                                        echo '</div>';
                                    }else{
                                        $id_shk=getDataDetail($Conn,'pasien_shk','id_pasien_shk',$id_pasien_shk,'id_shk');
                                        $id_pasien_ibu=getDataDetail($Conn,'pasien_shk','id_shk',$id_shk,'id_pasien_ibu');
                                        $nik_ibu=getDataDetail($Conn,'pasien_shk','id_shk',$id_shk,'nik_ibu');
                                        $nama_ibu=getDataDetail($Conn,'pasien_shk','id_shk',$id_shk,'nama_ibu');
                                        $id_pasien_anak=getDataDetail($Conn,'pasien_shk','id_shk',$id_shk,'id_pasien_anak');
                                        $nik_anak=getDataDetail($Conn,'pasien_shk','id_shk',$id_shk,'nik_anak');
                                        $nama_anak=getDataDetail($Conn,'pasien_shk','id_shk',$id_shk,'nama_anak');
                                        $tgllahir=getDataDetail($Conn,'pasien_shk','id_shk',$id_shk,'tgllahir');
                                        $gender_anak=getDataDetail($Conn,'pasien_shk','id_shk',$id_shk,'gender_anak');
                                        $alamat=getDataDetail($Conn,'pasien_shk','id_shk',$id_shk,'alamat');
                                        $provinsi=getDataDetail($Conn,'pasien_shk','id_shk',$id_shk,'provinsi');
                                        $kabkota=getDataDetail($Conn,'pasien_shk','id_shk',$id_shk,'kabkota');
                                        $kecamatan=getDataDetail($Conn,'pasien_shk','id_shk',$id_shk,'kecamatan');
                                        $tgl_ambil_sampel=getDataDetail($Conn,'pasien_shk','id_shk',$id_shk,'tgl_ambil_sampel');
                                        $tgl_kirim_sampel=getDataDetail($Conn,'pasien_shk','id_shk',$id_shk,'tgl_kirim_sampel');
                                        $tgl_lapor=getDataDetail($Conn,'pasien_shk','id_shk',$id_shk,'tgl_lapor');
                                        $kode_perujuk=getDataDetail($Conn,'pasien_shk','id_shk',$id_shk,'kode_perujuk');
                                        $nama_fayankes_perujuk=getDataDetail($Conn,'pasien_shk','id_shk',$id_shk,'nama_fayankes_perujuk');
                                        $jenis_fasyankes=getDataDetail($Conn,'pasien_shk','id_shk',$id_shk,'jenis_fasyankes');
                                        $id_akses=getDataDetail($Conn,'pasien_shk','id_shk',$id_shk,'id_akses');
                                        //Buka Nama Petugas
                                        $NamaPetugas=getDataDetail($Conn,'akses','id_akses',$id_akses,'nama');
                                        //Buka Wilayah
                                        $provinsi=getDataDetail($Conn,'wilayah_mendagri ','kode',$provinsi,'nama');
                                        $kabkota=getDataDetail($Conn,'wilayah_mendagri ','kode',$kabkota,'nama');
                                        $kecamatan=getDataDetail($Conn,'wilayah_mendagri ','kode',$kecamatan,'nama');
                        ?>
                            <form action="javascript:void(0);" id="ProsesEditPasienShk">
                                <input type="hidden" name="id_pasien_shk" value="<?php echo "$id_pasien_shk"; ?>">
                                <div class="card mb-2">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-md-10 mb-3">
                                                <h4>
                                                    <i class="ti ti-pencil"></i> Edit Pasien SHK
                                                </h4>
                                            </div>
                                            <div class="col-md-2">
                                                <a href="index.php?Page=PasienShk&&Sub=DetailPasienShk&id=<?php echo "$id_pasien_shk"; ?>" class="btn btn-md btn-block btn-secondary">
                                                    <i class="ti ti-arrow-circle-left"></i> Kembali
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-md-12 sub-title">
                                                <dt>
                                                    1. Identias Ibu 
                                                    <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalCariPasienIbu">
                                                        (Cari <i class="ti ti-search"></i>)
                                                    </a>
                                                </dt>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="id_pasien_ibu">No.RM Ibu</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" name="id_pasien_ibu" id="id_pasien_ibu" class="form-control" value="<?php echo "$id_pasien_ibu"; ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="nama_ibu">Nama Ibu</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" name="nama_ibu" id="nama_ibu" class="form-control" value="<?php echo "$nama_ibu"; ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="nik_ibu">NIK Ibu</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" name="nik_ibu" id="nik_ibu" class="form-control" value="<?php echo "$nik_ibu"; ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12 sub-title">
                                                <dt>
                                                    2. Identias Anak 
                                                    <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalCariPasienAnak">
                                                        (Cari <i class="ti ti-search"></i>)
                                                    </a>
                                                </dt>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="id_pasien_anak">No.RM Anak</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" name="id_pasien_anak" id="id_pasien_anak" class="form-control" value="<?php echo "$id_pasien_anak"; ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="nama_anak">Nama Anak</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" name="nama_anak" id="nama_anak" class="form-control" value="<?php echo "$nama_anak"; ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="nik_anak">NIK Anak</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" name="nik_anak" id="nik_anak" class="form-control" value="<?php echo "$nik_anak"; ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="tgllahir">Tanggal Lahir</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="date" name="tgllahir" id="tgllahir" class="form-control" value="<?php echo "$tgllahir"; ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="gender">Gender</label>
                                            </div>
                                            <div class="col-md-9">
                                                <select name="gender" id="gender" class="form-control">
                                                    <option <?php if($gender_anak==""){echo "selected";} ?> value="">Pilih</option>
                                                    <option <?php if($gender_anak=="Laki-Laki"){echo "selected";} ?> value="Laki-Laki">Laki-Laki</option>
                                                    <option <?php if($gender_anak=="Perempuan"){echo "selected";} ?> value="Perempuan">Perempuan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12 sub-title">
                                                <dt>
                                                    3. Alamat/Domisili 
                                                    <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalCekAlamatPasien">
                                                        (Cek Alamat <i class="ti ti-info-alt"></i>)
                                                    </a>
                                                </dt>
                                                <small>
                                                    Kode wilayah dalam form ini menggunakan data mendagri yang diperbaharui secara mandiri dan berbeda dengan penamaan wilayah pada sistem
                                                </small>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="dom_alamat">Alamat</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" name="dom_alamat" id="dom_alamat" class="form-control" placeholder="Jl.Anggrek 4 RT 20 RW 04" value="<?php echo "$alamat"; ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="provinsi">Provinsi</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" name="provinsi" id="provinsi" class="form-control" list="list_provinsi" autocomplete="off" value="<?php echo "$provinsi"; ?>">
                                                <datalist id="list_provinsi">
                                                    <?php
                                                        $query = mysqli_query($Conn, "SELECT*FROM wilayah_mendagri WHERE kategori='Provinsi' ORDER BY nama ASC");
                                                        while ($data = mysqli_fetch_array($query)) {
                                                            $nama = $data['nama'];
                                                            $kode= $data['kode'];
                                                            echo '<option value="'.$nama.'">';
                                                        }
                                                    ?>
                                                </datalist>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="kabkota">Kabupaten/Kota</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" name="kabkota" id="kabkota" class="form-control" list="list_kabupaten" autocomplete="off" value="<?php echo "$kabkota"; ?>">
                                                <datalist id="list_kabupaten">
                                                    <!-- Hanya tampil saat ada yang diketik -->
                                                </datalist>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="kecamatan">Kecamatan</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" name="kecamatan" id="kecamatan" class="form-control" list="list_kecamatan" autocomplete="off" value="<?php echo "$kecamatan"; ?>">
                                                <datalist id="list_kecamatan">
                                                    <!-- Hanya tampil saat ada yang diketik -->
                                                </datalist>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12 sub-title">
                                                <dt>4. Informasi Sample</dt>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="tgl_ambil_sampel">Tgl Ambil Sample</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="date" name="tgl_ambil_sampel" id="tgl_ambil_sampel" class="form-control"  value="<?php echo "$tgl_ambil_sampel"; ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="tgl_kirim_sampel">Tgl Kirim Sample</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="date" name="tgl_kirim_sampel" id="tgl_kirim_sampel" class="form-control"  value="<?php echo "$tgl_kirim_sampel"; ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="tgl_lapor">Tgl Laporan</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="date" name="tgl_lapor" id="tgl_lapor" class="form-control"  value="<?php echo "$tgl_lapor"; ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12 sub-title">
                                                <dt>5. Informasi Perujuk</dt>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="jenis_fasyankes">Jenis Fasyankes</label>
                                            </div>
                                            <div class="col-md-9">
                                                <select name="jenis_fasyankes" id="jenis_fasyankes" class="form-control">
                                                    <option <?php if($jenis_fasyankes=="1"){echo "selected";} ?> value="1">Puskesmas</option>
                                                    <option <?php if($jenis_fasyankes=="2"){echo "selected";} ?> value="2">Rumah Sakit</option>
                                                    <option <?php if($jenis_fasyankes=="3"){echo "selected";} ?> value="3">Klinik</option>
                                                    <option <?php if($jenis_fasyankes=="4"){echo "selected";} ?> value="4">Praktek Mandiri</option>
                                                    <option <?php if($jenis_fasyankes=="5"){echo "selected";} ?> value="5">Bukan Pasien Rujukan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="kode_perujuk">Kode Perujuk</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" name="kode_perujuk" id="kode_perujuk" class="form-control" value="<?php echo "$kode_perujuk"; ?>">
                                                <small>
                                                    * Cari Faskes perujuk <a href="javascript:void(0);" class="text-success" data-toggle="modal" data-target="#ModalCariFaskes">di sini</a>
                                                </small>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="nama_fayankes_perujuk">Nama Faskes Perujuk</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" name="nama_fayankes_perujuk" id="nama_fayankes_perujuk" class="form-control" value="<?php echo "$nama_fayankes_perujuk"; ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="id_shk">ID SHK (SIRS Online)</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" name="id_shk" id="id_shk" class="form-control" value="<?php echo "$id_shk"; ?>">
                                                <ul>
                                                    <li>
                                                        <input type="radio" checked name="update_sisrs_online" id="update_sisrs_online_ya" value="Ya"> 
                                                        <label for="update_sisrs_online_ya">Update Ke SIRS Online</label>
                                                    </li>
                                                    <li>
                                                        <input type="radio" name="update_sisrs_online" id="update_sisrs_online_no" value="No"> 
                                                        <label for="update_sisrs_online_no">Jangan Update Ke SIRS Online</label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <dt>Keterangan</dt>
                                            </div>
                                            <div class="col-md-9" id="NotifikasiEditPasienShk">
                                                Pastikan Data Pasien SHK Yang Anda Input Sudah Benar
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-white">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <button type="submit" class="btn btn-md btn-primary">
                                                    <i class="ti ti-save"></i> Simpan
                                                </button>
                                                <a href="index.php?Page=PasienShk&&Sub=DetailPasienShk&id=<?php echo "$id_pasien_shk"; ?>" class="btn btn-md btn-secondary">
                                                    <i class="ti ti-arrow-circle-left"></i> Kembali
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        <?php }}} ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>