<?php
    //menangkap data dari form
    if(empty($_GET['kategori'])){
        echo '<div class="card-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 bg-danger">';
        echo '          <h3>Error Page</h3>';
        echo '          <p class="text-light">Kategori Pendaftaran tidak boleh kosong, silahkan kembali ke halaman sebelumnya.</p>';
        echo '      </div>';
        echo '  </div>';
        echo '  <div class="row">';
        echo '      <div class="col-md-12">';
        echo '          <a href="Pendaftaran.php?page=pendaftaran" class="btn btn-default btn-md btn-block waves-effect waves-light text-center m-b-20">';
        echo '              <i class="ti ti-arrow-circle-left"></i> Kembali';
        echo '          </a>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_GET['metode_pembayaran'])){
            echo '<div class="card-body">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12 bg-danger">';
            echo '          <h3>Error Page</h3>';
            echo '          <p class="text-light">Metode Pembayaran tidak boleh kosong, silahkan kembali ke halaman sebelumnya.</p>';
            echo '      </div>';
            echo '  </div>';
            echo '  <div class="row">';
            echo '      <div class="col-md-12">';
            echo '          <a href="Pendaftaran.php?page=pendaftaran" class="btn btn-default btn-md btn-block waves-effect waves-light text-center m-b-20">';
            echo '              <i class="ti ti-arrow-circle-left"></i> Kembali';
            echo '          </a>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            if(empty($_GET['id_pasien'])){
                echo '<div class="card-body">';
                echo '  <div class="row">';
                echo '      <div class="col-md-12 bg-danger">';
                echo '          <h3>Error Page</h3>';
                echo '          <p class="text-light">ID Pasien tidak boleh kosong, silahkan kembali ke halaman sebelumnya.</p>';
                echo '      </div>';
                echo '  </div>';
                echo '  <div class="row">';
                echo '      <div class="col-md-12">';
                echo '          <a href="Pendaftaran.php?page=pendaftaran" class="btn btn-default btn-md btn-block waves-effect waves-light text-center m-b-20">';
                echo '              <i class="ti ti-arrow-circle-left"></i> Kembali';
                echo '          </a>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
            }else{
                $kategori=$_GET['kategori'];
                $metode_pembayaran=$_GET['metode_pembayaran'];
                $id_pasien=$_GET['id_pasien'];
                if($kategori=="lama"){
                    $LabelKategori="Pasien Lama";
                }else{
                    $LabelKategori="Pasien Baru";
                }
                //Koneksi ke database
                include "_Config/Connection.php";
                //Pencarian data pasien
                $sql="SELECT * FROM pasien WHERE id_pasien='$id_pasien'";
                $query=mysqli_query($Conn,$sql);
                $data=mysqli_fetch_assoc($query);
                //Jika data pasien tidak ditemukan
                if(mysqli_num_rows($query)==0){
                    echo '<div class="card-body">';
                    echo '  <div class="row">';
                    echo '      <div class="col-md-12 bg-danger">';
                    echo '          <h3>Error Page</h3>';
                    echo '          <p class="text-light">Data Pasien Tidak Ditemukan.</p>';
                    echo '      </div>';
                    echo '  </div>';
                    echo '  <div class="row">';
                    echo '      <div class="col-md-12">';
                    echo '          <a href="Pendaftaran.php?page=pendaftaran" class="btn btn-default btn-md btn-block waves-effect waves-light text-center m-b-20">';
                    echo '              <i class="ti ti-arrow-circle-left"></i> Kembali';
                    echo '          </a>';
                    echo '      </div>';
                    echo '  </div>';
                    echo '</div>';
                }else{
                    //Data pasien
                    $id_pasien=$data['id_pasien'];
                    $tanggal_daftar=$data['tanggal_daftar'];
                    $nik=$data['nik'];
                    $no_bpjs=$data['no_bpjs'];
                    $gender=$data['gender'];
                    $nama=$data['nama'];
                    $kontak=$data['kontak'];
?>
    <form action="javascript:void(0);" method="POST" id="ProsesPendaftaranPasienLama" autocomplete="off">
        <input type="hidden" name="kategori" id="kategori" value="<?php echo $kategori;?>">
        <div class="card-header">
            <b class="card-title">Form Pendaftaran Pasien Lama</b>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mt-4">
                    <label for="nik"><dt>Kategori Pendaftaran</dt></label>
                    <input type="text" readonly name="label_kategori" id="label_kategori" class="form-control" value="<?php echo "$LabelKategori";?>">
                </div>
                <div class="col-md-4 mt-4">
                    <label for="nik"><dt>Metode Pembayaran</dt></label>
                    <input type="text" readonly name="metode_pembayaran" id="metode_pembayaran" class="form-control" value="<?php echo "$metode_pembayaran";?>">
                </div>
                <div class="col-md-4 mt-4">
                    <label for="nik"><dt>No.RM</dt></label>
                    <input type="text" readonly name="id_pasien" id="id_pasien" class="form-control" value="<?php echo "$id_pasien";?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mt-4">
                    <label for="nik"><dt>No.KTP (NIK)</dt></label>
                    <input type="text" name="nik" id="nik" class="form-control" value="<?php echo $nik;?>">
                </div>
                <?php if($metode_pembayaran=="BPJS"){ ?>
                    <div class="col-md-4 mt-4">
                        <label for="nik"><dt>No.BPJS</dt></label>
                        <input type="text" name="nomorkartu" id="nomorkartu" class="form-control" value="<?php echo $no_bpjs;?>" required>
                    </div>
                <?php } ?>
                <div class="col-md-4 mt-4">
                    <label for="nik"><dt>Nama Lengkap</dt></label>
                    <input type="text" name="nama" id="nama" class="form-control" value="<?php echo $nama;?>" required>
                    <small id="NotifikasiPasien">Nama lengkap pasien</small>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mt-4">
                    <label for="notelp"><dt>No.Kontak</dt></label>
                    <input type="text" name="notelp" id="notelp" class="form-control" value="<?php echo $kontak;?>">
                </div>
                <div class="col-md-4 mt-4">
                    <label for="poliklinik"><dt>Poliklinik</dt></label>
                    <select name="poliklinik" id="poliklinik" class="form-control">
                        <option value="">Pilih</option>
                        <?php 
                            //select option poliklinik
                            $sql = "SELECT * FROM poliklinik";
                            $result = mysqli_query($Conn, $sql);
                            while($row = mysqli_fetch_assoc($result)){
                                echo "<option value='$row[id_poliklinik]'>$row[nama]</option>";
                            }

                        ?>
                    </select>
                </div>
                <div class="col-md-4 mt-4">
                    <label for="dokter"><dt>Dokter</dt></label>
                    <select name="dokter" id="dokter" class="form-control">
                        <option value="">Pilih</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mt-4">
                    <label for="tanggal"><dt>Tgl.Rencana Kunjungan</dt></label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control">
                </div>
                <div class="col-md-4 mt-4">
                    <label for="jam"><dt>Jam Kunjungan</dt></label>
                    <select name="jam" id="jam" class="form-control">
                        <option value="">Pilih</option>
                    </select>
                </div>
                <div class="col-md-4 mt-4">
                    <label for="nik"><dt>Keluhan/Tujuan Kunjungan</dt></label>
                    <input type="keluhan" name="keluhan" id="keluhan" class="form-control">
                </div>
            </div>
            <?php if($metode_pembayaran=="BPJS"){ ?>
                <div class="row">
                    <div class="col-md-4 mt-4">
                        <label for="jeniskunjungan"><dt>Jenis Kunjungan</dt></label>
                        <select name="jeniskunjungan" id="jeniskunjungan" class="form-control">
                            <option value="">Pilih</option>
                            <option value="1">Rujukan FKTP</option>
                            <option value="2">Rujukan Internal</option>
                            <option value="3">Kontrol</option>
                            <option value="4">Rujukan Antar RS</option>
                        </select>
                    </div>
                    <div class="col-md-8 mt-4">
                        <label for="nomorreferensi"><dt>No.Referensi</dt></label>
                        <input type="text" name="nomorreferensi" id="nomorreferensi" class="form-control">
                    </div>
                </div>
            <?php } ?>
            <div class="row m-t-25 text-left">
                <div class="col-12" id="NotifikasiPendaftaranPasienLama">
                    <span class="text-info">Pastikan data pendaftaran yang anda masukan sudah benar.</span>
                </div>
            </div>
            <div class="row m-t-30">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">Simpan Pendaftaran</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <a href="Pendaftaran.php?page=PendaftaranBpjs&kategori=<?php echo $kategori;?>" class="btn btn-default btn-md btn-block waves-effect waves-light text-center m-b-20">
                        <i class="ti ti-arrow-circle-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </form>
<?php
                }
            }
        }
    }
?>