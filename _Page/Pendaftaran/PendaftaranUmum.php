<?php
    if(empty($_GET['kategori'])){
        $kategori="baru";
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
        $kategori=$_GET['kategori'];
        if($kategori!=="baru"&&$kategori!=="lama"){
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
            if($kategori=="baru"){
?>
    <form action="javascript:void(0);" method="POST" id="ProsesPendaftaranPasienBaru" autocomplete="off">
        <input type="hidden" name="kategori" id="kategori" value="<?php echo $kategori;?>">
        <input type="hidden" name="metode_pembayaran" id="metode_pembayaran" value="UMUM">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <dt>Pendaftaran Pasien Umum (Pendaftaran Baru)</dt>
                    <p class="text-muted">
                        <i>
                            <b>
                                <i class="ti ti-info-alt"></i>
                                Informasi Pendaftaran :<br>
                                Pastikan anda memiliki nomor KTP (NIK) yang valid untuk mendaftar sebagai pasien baru.
                            </b>
                        </i>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mt-4">
                    <label for="nik"><dt>No.KTP (NIK)</dt></label>
                    <input type="text" name="nik" id="nik" class="form-control" required>
                </div>
                <div class="col-md-6 mt-4">
                    <label for="nik"><dt>Nama Lengkap</dt></label>
                    <input type="text" name="nama" id="nama" class="form-control" required>
                    <small id="NotifikasiPasien">Nama lengkap pasien</small>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mt-4">
                    <label for="notelp"><dt>No.Kontak</dt></label>
                    <input type="text" name="notelp" id="notelp" class="form-control">
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
            <div class="row m-t-25 text-left">
                <div class="col-12" id="NotifikasiPendaftaranPasienBaru">
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
                    <a href="Pendaftaran.php?page=PasienBpjsUmum&kategori=<?php echo $kategori;?>" class="btn btn-default btn-md btn-block waves-effect waves-light text-center m-b-20">
                        <i class="ti ti-arrow-circle-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </form>
<?php
    }else{
?>
    <form action="javascript:void(0);" method="POST" id="ProsesPencarianPasienLama" autocomplete="off">
        <input type="hidden" name="metode_pembayaran" id="metode_pembayaran" value="UMUM">
        <input type="hidden" name="kategori_pendaftaran" id="kategori_pendaftaran" value="<?php echo $kategori;?>">
        <div class="card-body" id="FormPendaftaranPasienUmumLama">
            <div class="row">
                <div class="col-md-12">
                    <dt><i class="ti ti-info-alt"></i> Informasi Pendaftaran Pasien Umum (Pasien Lama)</dt>
                    <small class="text-muted">
                        <i>
                            <ul>
                                <li>
                                    - Berikut ini adalah pendaftaran hanya untuk pasien UMUM yang sudah pernah terdaftar sebelumnya (Pasien Lama).
                                </li>
                                <li>
                                    - Pastikan anda memiliki nomor KTP (NIK) yang valid atau nomor RM pada kartu berobat untuk melanjutkan pendaftaran sebagai pasien lama.
                                </li>
                                <li>
                                    - Untuk kategori pendaftaran pasien baru atau pasien BPJS silahkan klik tombol kembali pada bagian bawah halaman ini.
                                </li>
                            </ul>
                        </i>
                    </small>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mt-4">
                    <label for="kategori_id"><dt>Pilih Kategori Pencarian</dt></label>
                    <select name="kategori_id" id="kategori_id" class="form-control" required>
                        <option value="" selected>Pilih</option>
                        <option value="id_pasien">No RM</option>
                        <option value="nik">No NIK (KTP)</option>
                    </select>
                </div>
                <div class="col-md-6 mt-4">
                    <label for="keyword" id="LabelPencarian"><dt>Keyword Pencarian</dt></label>
                    <input type="text" disabled name="keyword" id="keyword" class="form-control" required>
                </div>
            </div>
            <div class="row m-t-30">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">
                        <i class="ti ti-search"></i> Mulai Pencarian
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <b id="NotifikasiPencarianDataPasien">
                        Pastikan ID yang anda masukan sudah benar!
                    </b>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <a href="Pendaftaran.php?page=PasienBpjsUmum&kategori=<?php echo $kategori;?>" class="btn btn-default btn-md btn-block waves-effect waves-light text-center m-b-20">
                        <i class="ti ti-arrow-circle-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </form>
<?php
    }}}
?>
