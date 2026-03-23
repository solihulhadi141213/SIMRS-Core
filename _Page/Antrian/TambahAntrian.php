<?php
    date_default_timezone_set('Asia/Jakarta');
    include "_Config/SimrsFunction.php"; 
    //Menangkap id_pasien
    if(empty($_GET['id'])){
        echo '<div class="card">';
        echo '  <div class="card-boday">';
        echo '      <div class="row">';
        echo '          <div class="col-md-12 text-center text-danger">';
        echo '              ID Pasien Tidak Boleh Kosong!';
        echo '          </div>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $GetIdPasien = $_GET['id'];
        $id_pasien=getDataDetail($Conn,"pasien",'id_pasien',$GetIdPasien,'id_pasien');
        $nama=getDataDetail($Conn,"pasien",'id_pasien',$GetIdPasien,'nama');
        $nik=getDataDetail($Conn,"pasien",'id_pasien',$GetIdPasien,'nik');
        $no_bpjs=getDataDetail($Conn,"pasien",'id_pasien',$GetIdPasien,'no_bpjs');
        $kontak=getDataDetail($Conn,"pasien",'id_pasien',$GetIdPasien,'kontak');
        //Buka data pasien
        if(empty($id_pasien)){
            echo '<div class="card">';
            echo '  <div class="card-boday">';
            echo '      <div class="row">';
            echo '          <div class="col-md-12 text-center text-danger">';
            echo '              ID Pasien Tidak Terdaftar (Tidak Valid)!';
            echo '          </div>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            if(empty($_SESSION['UrlBack'])){
                $UrlBack="index.php?Page=Antrian";
            }else{
                $UrlBack=$_SESSION['UrlBack'];
            }
?>
    <form action="javascript:void(0);" id="ProsesTambahAntrianManual" autocomplete="off">
        <div class="card">   
            <div class="card-header"> 
                <div class="row">
                    <div class="col-md-10 mb-2">
                        <h4><i class="ti ti-plus"></i> Form Tambah Antrian (Manual)</h4> 
                    </div>
                    <div class="col-md-2 mb-2">
                        <a href="<?php echo "$UrlBack"; ?>" class="btn btn-sm btn-secondary btn-block">
                            <i class="ti ti-arrow-circle-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div> 
            <div class="card-body"> 
                <h4 class="sub-title"><dt>Informasi Pasien</dt></h4>
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label for="id_pasien">No.RM Pasien</label><br>
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#ModalAddAntrianManual" class="text-primary">
                            <small><i class="ti ti-search"></i> Ganti / Cari Pasien Lainnya</small>
                        </a>
                    </div>
                    <div class="col-md-8">
                        <div class="input-group">
                            <input type="text" readonly name="id_pasien" id="id_pasien" class="form-control" value="<?php echo "$id_pasien";?>" required>
                            <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalGetDetailPasien" title="Lihat Detail Pasien Berdasarkan Nomor RM">
                                <i class="ti ti-info-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label for="id_kunjungan">ID.REG/Kunjungan</label><br>
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#ModalCariKunjungan" class="text-primary">
                            <small><i class="ti ti-search"></i> Cari Kunjungan</small>
                        </a>
                    </div>
                    <div class="col-md-8">
                        <div class="input-group">
                            <input type="text" name="id_kunjungan" id="id_kunjungan" class="form-control">
                            <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalGetDetailKunjungan" title="Lihat Detail Kunjungan">
                                <i class="ti ti-info-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label for="nik">No.KTP (NIK)</label>
                    </div>
                    <div class="col-md-8">
                        <div class="input-group">
                            <input type="text" name="nik" id="nik" class="form-control" value="<?php echo "$nik";?>">
                            <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalDetailNik" title="Lihat Detail Pasien Berdasarkan NIK">
                                <i class="ti ti-info-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label for="nama">Nama Lengkap</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="nama" id="nama" class="form-control" value="<?php echo $nama;?>" required>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label for="notelp">No.Kontak</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="notelp" id="notelp" class="form-control" value="<?php echo $kontak;?>">
                    </div>
                </div>
                <h4 class="sub-title"><dt>Informasi Kunjungan</dt></h4>
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label for="poliklinik">Poliklinik</label>
                    </div>
                    <div class="col-md-8">
                        <select name="poliklinik" id="poliklinik" class="form-control">
                            <option value="">Pilih Poliklinik</option>
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
                </div>
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label for="dokter">Dokter</label>
                    </div>
                    <div class="col-md-8">
                        <select name="dokter" id="dokter" class="form-control">
                            <option value="">Pilih Dokter</option>
                        </select>
                        <small>Berdasarkan Poliklinik</small>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label for="tanggal1">Tanggal Kunjungan</label>
                    </div>
                    <div class="col-md-8">
                        <input type="date" name="tanggal1" id="tanggal1" class="form-control">
                        <small>Tanggal Kunjungan</small>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label for="jam">Jam Kunjungan</label>
                    </div>
                    <div class="col-md-8">
                        <select name="jam" id="jam" class="form-control">
                            <option value="">Pilih Jadwal</option>
                        </select>
                        <small>Berdasarkan Jadwal Poli</small>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label for="keluhan">Keluhan/Tujuan Kunjungan</label>
                    </div>
                    <div class="col-md-8">
                        <input type="keluhan" name="keluhan" id="keluhan" class="form-control">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label for="nik">Metode Pembayaran</label>
                    </div>
                    <div class="col-md-8">
                        <select name="metode_pembayaran" id="metode_pembayaran" class="form-control" required>
                            <option value="">Pilih</option>
                            <option value="BPJS">BPJS</option>
                            <option value="UMUM">UMUM</option>
                        </select>
                    </div>
                </div>
                <h4 class="sub-title"><dt>Informasi JKN/BPJS</dt></h4>
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label for="nomorkartu">No.BPJS</label>
                    </div>
                    <div class="col-md-8">
                        <div class="input-group">
                            <input type="text" readonly name="nomorkartu" id="nomorkartu" class="form-control" value="<?php echo "$no_bpjs";?>">
                            <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalDetailBpjs" title="Lihat Detail Pasien Berdasarkan Nomor Kartu BPJS">
                                <i class="ti ti-info-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label for="jeniskunjungan">Jenis Kunjungan</label>
                    </div>
                    <div class="col-md-8">
                        <select disabled name="jeniskunjungan" id="jeniskunjungan" class="form-control">
                            <option value="">Pilih</option>
                            <option value="1">Rujukan FKTP</option>
                            <option value="2">Rujukan Internal</option>
                            <option value="3">Kontrol</option>
                            <option value="4">Rujukan Antar RS</option>
                        </select>
                        <small>Hanya Untuk Pasien BPJS</small>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label for="nomorreferensi">No.Referensi</label><br>
                        <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalCariRujukan">
                            <small><i class="ti ti-search"></i> Cari Referensi/Rujukan</small>
                        </a>
                    </div>
                    <div class="col-md-8">
                        <input type="text" disabled name="nomorreferensi" id="nomorreferensi" class="form-control">
                        <small>Hanya Untuk Pasien BPJS</small>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-4"></div>
                    <div class="col-8">
                        <input type="checkbox" name="KirimKeWsBpjs" id="KirimKeWsBpjs" value="1">
                        <label for="KirimKeWsBpjs" class="text-dark">Kirim Ke WS BPJS</label>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-12" id="NotifikasTambahAntrianManual">
                        <span class="text-info">Pastikan data pendaftaran antrian manual yang anda masukan sudah benar.</span>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-sm btn-primary mb-3">
                    <i class="fa fa-save"></i> Simpan Antrian
                </button>
                <a href="<?php echo "$UrlBack"; ?>" class="btn btn-sm btn-secondary ml-2 mb-3">
                    <i class="ti ti-arrow-circle-left"></i> Kembali
                </a>
            </div>
        </div>
    </form>
<?php }} ?>