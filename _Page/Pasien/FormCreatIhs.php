<?php 
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    if(empty($_POST['id_pasien'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center text-dange">';
        echo '          Data ID Pasien Tidak Boleh Kosong!.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer bg-success">';
        echo '  <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">';
        echo '      <i class="ti-close"></i> Tutup';
        echo '  </button>';
        echo '</div>';
    }else{
        $id_pasien=$_POST['id_pasien'];
        //Buka data Pasien
        $QryPasien = mysqli_query($Conn,"SELECT * FROM pasien WHERE id_pasien='$id_pasien'")or die(mysqli_error($Conn));
        $DataPasien = mysqli_fetch_array($QryPasien);
        if(empty($DataPasien['nik'])){
            echo '<div class="modal-body">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-center text-dange">';
            echo '          Setidaknya pasien harus memiliki NIK untuk dibuatkan ID IHS';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
            echo '<div class="modal-footer bg-success">';
            echo '  <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">';
            echo '      <i class="ti-close"></i> Tutup';
            echo '  </button>';
            echo '</div>';
        }else{
            $nik= $DataPasien['nik'];
            $nama= $DataPasien['nama'];
            if(!empty($DataPasien['gender'])){
                $gender= $DataPasien['gender'];
            }else{
                $gender="";
            }
            if(!empty($DataPasien['tanggal_lahir'])){
                $tanggal_lahir= $DataPasien['tanggal_lahir'];
            }else{
                $tanggal_lahir="";
            }
            if(!empty($DataPasien['kontak'])){
                $kontak= $DataPasien['kontak'];
            }else{
                $kontak="";
            }
            if(!empty($DataPasien['alamat'])){
                $alamat= $DataPasien['alamat'];
            }else{
                $alamat="";
            }
            if(!empty($DataPasien['kontak_darurat'])){
                $kontak_darurat= $DataPasien['kontak_darurat'];
            }else{
                $kontak_darurat="";
            }
            if(!empty($DataPasien['penanggungjawab'])){
                $penanggungjawab= $DataPasien['penanggungjawab'];
            }else{
                $penanggungjawab="";
            }
            //Mencari Kode Provinsi
            if(!empty($DataPasien['propinsi'])){
                $propinsi= $DataPasien['propinsi'];
                $QryWilayah = mysqli_query($Conn,"SELECT * FROM wilayah_mendagri WHERE kategori='Provinsi' AND nama='$propinsi'")or die(mysqli_error($Conn));
                $DataWilayah = mysqli_fetch_array($QryWilayah);
                if(!empty($DataWilayah['kode'])){
                    $KodePropinsi= $DataWilayah['kode'];
                    //Cari Kode Kabupaten
                    if(!empty($DataPasien['kabupaten'])){
                        $kabupaten= $DataPasien['kabupaten'];
                        $QryWilayah = mysqli_query($Conn,"SELECT * FROM wilayah_mendagri WHERE kategori='Kota Kabupaten' AND nama='$kabupaten'")or die(mysqli_error($Conn));
                        $DataWilayah = mysqli_fetch_array($QryWilayah);
                        if(!empty($DataWilayah['kode'])){
                            $KodeKabupaten= $DataWilayah['kode'];
                            //Cari Kode Kecamatan
                            if(!empty($DataPasien['kecamatan'])){
                                $kecamatan= $DataPasien['kecamatan'];
                                $QryWilayahKecamatan = mysqli_query($Conn,"SELECT * FROM wilayah_mendagri WHERE kategori='Kecamatan' AND nama='$kecamatan'")or die(mysqli_error($Conn));
                                $DataWilayahKecamatan = mysqli_fetch_array($QryWilayahKecamatan);
                                if(!empty($DataWilayahKecamatan['kode'])){
                                    $KodeKecamatan= $DataWilayahKecamatan['kode'];
                                    //Mencari Kode Desa
                                    if(!empty($DataPasien['desa'])){
                                        $desa= $DataPasien['desa'];
                                        $QryWilayah = mysqli_query($Conn,"SELECT * FROM wilayah_mendagri WHERE kategori='Kelurahan' AND nama='$desa'")or die(mysqli_error($Conn));
                                        $DataWilayah = mysqli_fetch_array($QryWilayah);
                                        if(!empty($DataWilayah['kode'])){
                                            $KodeDesa= $DataWilayah['kode'];
                                        }else{
                                            $KodeDesa="";
                                        }
                                    }else{
                                        $KodeDesa="";
                                    }
                                }else{
                                    $KodeKecamatan="";
                                    $KodeDesa="";
                                }
                            }else{
                                $KodeKecamatan="";
                                $KodeDesa="";
                            }
                        }else{
                            $KodeKabupaten="";
                            $KodeKecamatan="";
                            $KodeDesa="";
                        }
                    }else{
                        $KodeKabupaten="";
                        $KodeKecamatan="";
                        $KodeDesa="";
                    }
                }else{
                    $KodePropinsi="";
                    $KodeKabupaten="";
                    $KodeKecamatan="";
                    $KodeDesa="";
                }
            }else{
                $propinsi="";
                $KodeKabupaten="";
                $KodeKecamatan="";
                $KodeDesa="";
            }
?>
    <form action="javascript:void(0);" id="ProsesCreatIhs">
        <input type="hidden" name="id_pasien" id="id_pasien" value="<?php echo $id_pasien;?>">
        <div class="modal-body">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="nik">Nomor KTP (NIK)</label>
                </div>
                <div class="col-md-8">
                    <input type="text" readonly name="nik" id="nik" class="form-control" value="<?php echo $nik;?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="nama">Nama Lengkap</label>
                </div>
                <div class="col-md-8">
                    <input type="text" readonly name="nama" id="nama" class="form-control" value="<?php echo $nama;?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="nik">Jenis Kelamin</label>
                </div>
                <div class="col-md-8">
                    <select id="gender" name="gender" class="form-control" required>
                        <option <?php if($gender==""){echo "selected";} ?> value="">Pilih</option>
                        <option <?php if($gender=="Laki-laki"){echo "selected";} ?> value="male">Laki-laki</option>
                        <option <?php if($gender=="Perempuan"){echo "selected";} ?> value="female">Perempuan</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="tanggal_lahir">Tanggal Lahir</label>
                </div>
                <div class="col-md-8">
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="<?php echo $tanggal_lahir;?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="email">Email</label>
                </div>
                <div class="col-md-8">
                    <input type="email" name="email" id="email" class="form-control" placeholder="alamatemail@domain.com">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="kontak">Kontak</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="kontak" id="kontak" class="form-control" placeholder="+62" value="<?php echo $kontak;?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="kontak_darurat">Kontak Darurat</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="kontak_darurat" id="kontak_darurat" class="form-control" placeholder="+62" value="<?php echo $kontak_darurat; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="nama_kerabat">Nama Kerabat</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="nama_kerabat" id="nama_kerabat" class="form-control" value="<?php echo $penanggungjawab; ?>">
                    <small>Nama Kontak Darurat</small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="propinsi_ihs">Provinsi</label>
                </div>
                <div class="col-md-8">
                    <select id="propinsi_ihs" name="propinsi_ihs" class="form-control">
                        <option value="">Pilih</option>
                        <?php
                            //Arraykan propinsi
                            $QryPropinsi = mysqli_query($Conn, "SELECT*FROM wilayah_mendagri WHERE kategori='Provinsi' ORDER BY nama ASC");
                            while ($DataPropinsi = mysqli_fetch_array($QryPropinsi)) {
                                $nama_wilayah= $DataPropinsi['nama'];
                                $kode= $DataPropinsi['kode'];
                                if($KodePropinsi==$kode){
                                    echo '<option selected value="'.$kode.'">'.$nama_wilayah.'</option>';
                                }else{
                                    echo '<option value="'.$kode.'">'.$nama_wilayah.'</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="kabupaten_ihs">Kabupaten/Kota</label>
                </div>
                <div class="col-md-8">
                    <select id="kabupaten_ihs" name="kabupaten_ihs" class="form-control">
                        <option value="">Pilih</option>
                        <?php
                            if(!empty($KodePropinsi)){
                                //Arraykan Kabupaten
                                $QryKabupaten = mysqli_query($Conn, "SELECT*FROM wilayah_mendagri WHERE kategori='Kota Kabupaten' AND kode like '%$KodePropinsi%' ORDER BY nama ASC");
                                while ($DataKabupaten = mysqli_fetch_array($QryKabupaten)) {
                                    $nama_wilayah= $DataKabupaten['nama'];
                                    $kode= $DataKabupaten['kode'];
                                    if($KodeKabupaten==$kode){
                                        echo '<option selected value="'.$kode.'">'.$nama_wilayah.'</option>';
                                    }else{
                                        echo '<option value="'.$kode.'">'.$nama_wilayah.'</option>';
                                    }
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="kecamatan_ihs">Kecamatan</label>
                </div>
                <div class="col-md-8">
                    <select id="kecamatan_ihs" name="kecamatan_ihs" class="form-control">
                        <option value="">Pilih</option>
                        <?php
                            if(!empty($KodeKabupaten)){
                                //Arraykan Kecamatan
                                $QryKecamatan = mysqli_query($Conn, "SELECT*FROM wilayah_mendagri WHERE kategori='Kecamatan' AND kode like '%$KodeKabupaten%' ORDER BY nama ASC");
                                while ($DataKecamatan = mysqli_fetch_array($QryKecamatan)) {
                                    $nama_wilayah= $DataKecamatan['nama'];
                                    $kode= $DataKecamatan['kode'];
                                    if($KodeKecamatan==$kode){
                                        echo '<option selected value="'.$kode.'">'.$nama_wilayah.'</option>';
                                    }else{
                                        echo '<option value="'.$kode.'">'.$nama_wilayah.'</option>';
                                    }
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="desa_ihs">Desa/Kelurahan</label>
                </div>
                <div class="col-md-8">
                    <select id="desa_ihs" name="desa_ihs" class="form-control">
                        <option value="">Pilih</option>
                        <?php
                            if(!empty($KodeDesa)){
                                //Arraykan Desa
                                $QryDesa = mysqli_query($Conn, "SELECT*FROM wilayah_mendagri WHERE kategori='Kelurahan' AND kode like '%$KodeDesa%' ORDER BY nama ASC");
                                while ($DataDesa = mysqli_fetch_array($QryDesa)) {
                                    $nama_wilayah= $DataDesa['nama'];
                                    $kode= $DataDesa['kode'];
                                    if($KodeDesa==$kode){
                                        echo '<option selected value="'.$kode.'">'.$nama_wilayah.'</option>';
                                    }else{
                                        echo '<option value="'.$kode.'">'.$nama_wilayah.'</option>';
                                    }
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="alamat">Jalan/RT/RW</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="alamat" id="alamat" class="form-control" value="<?php echo $alamat;?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="kode_pos">Kode POS</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="kode_pos" id="kode_pos" class="form-control">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="perkawinan">Status Pernikahan</label>
                </div>
                <div class="col-md-8">
                    <select id="perkawinan" name="perkawinan" class="form-control">
                        <option value="">Pilih</option>
                        <option value="A">Annulled</option>
                        <option value="D">Divorced</option>
                        <option value="I">Interlocutory</option>
                        <option value="L">Legally Separated</option>
                        <option value="M">Married</option>
                        <option value="C">Common Law</option>
                        <option value="P">Polygamous</option>
                        <option value="T">Domestic partner</option>
                        <option value="U">Unmarried</option>
                        <option value="S">Never Married</option>
                        <option value="W">Widowed</option>
                    </select>
                    <a href="https://terminology.hl7.org/5.1.0/CodeSystem-v3-MaritalStatus.html" class="text-success" target="_blank">
                        <small>Referensi Terminology <i class="ti ti-new-window"></i></small>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mt-3" id="NotifikasiCreatIhsPasien">
                    <span class="text-primary">Pastikan Informasi pasien Yang Anda Input Sudah Sesuai.</span>
                </div>
            </div>
        </div>
        <div class="modal-footer bg-success">
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-sm btn-inverse mr-2">
                        <i class="ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </form>
<?php }} ?>