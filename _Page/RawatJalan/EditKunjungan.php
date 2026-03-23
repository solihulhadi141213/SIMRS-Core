<?php
    include "_Config/SimrsFunction.php";
?>
<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php
                            //Tangkap ID
                            if(empty($_GET['id'])){
                                echo '<div class="card">';
                                echo '  <div class="card-body">';
                                echo '      <span class="text-danger">ID Kunjungan Tidak Boleh Kosong!</span>';
                                echo '  </div>';
                                echo '</div>';
                            }else{
                                $id_kunjungan=$_GET['id'];
                                //Membuka data Kunjungan
                                $id_encounter=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_encounter');
                                $id_pasien=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_pasien');
                                $no_antrian=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'no_antrian');
                                $nik=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'nik');
                                $no_bpjs=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'no_bpjs');
                                $sep=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'sep');
                                $noRujukan=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'noRujukan');
                                $skdp=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'skdp');
                                $nama=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'nama');
                                $tanggal=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'tanggal');
                                $propinsi=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'propinsi');
                                $kabupaten=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'kabupaten');
                                $kecamatan=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'kecamatan');
                                $desa=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'desa');
                                $alamat=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'alamat');
                                $keluhan=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'keluhan');
                                $tujuan=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'tujuan');
                                $id_dokter=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_dokter');
                                $dokter=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'dokter');
                                $id_poliklinik=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_poliklinik');
                                $poliklinik=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'poliklinik');
                                $kelas=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'kelas');
                                $ruangan=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'ruangan');
                                $id_kasur=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_kasur');
                                $DiagAwal=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'DiagAwal');
                                $rujukan_dari=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'rujukan_dari');
                                $rujukan_ke=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'rujukan_ke');
                                $pembayaran=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'pembayaran');
                                $cara_keluar=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'cara_keluar');
                                $tanggal_keluar=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'tanggal_keluar');
                                $status=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'status');
                                $id_akses=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_akses');
                                $nama_petugas=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'nama_petugas');
                                $updatetime=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'updatetime');
                                
                                //Pecah jam kunjungan
                                $strtotime=strtotime($tanggal);
                                $TanggalKunjungan=date('Y-m-d',$strtotime);
                                $JamKunjungan=date('H:i',$strtotime);
                                //Cari ID Antrian
                                $id_antrian=getDataDetail($Conn,"antrian",'id_kunjungan',$id_kunjungan,'id_antrian');
                                $no_antrian=getDataDetail($Conn,"antrian",'id_kunjungan',$id_kunjungan,'no_antrian');
                        ?>
                            <form action="javascript:void(0);" id="ProsesEditKunjungan" autocomplete="off">
                                <input type="hidden" name="id_kunjungan" id="id_kunjungan" value="<?php echo "$id_kunjungan"; ?>">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-md-10 mb-2">
                                                <h4>
                                                    <i class="ti ti-plus"></i> Form Edit Kunjungan
                                                </h4>
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <a href="index.php?Page=RawatJalan&Sub=DetailKunjungan&id=<?php echo "$id_kunjungan"; ?>" class="btn btn-sm btn-secondary btn-block">
                                                    <i class="ti ti-angle-left"></i> Kembali
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <dt>NO.RM</dt>
                                                <a href="javascript:void(0);" class="text-info" data-toggle="modal" data-target="#ModalTambahRajal" title="Cari Data Pasien">
                                                    <small>
                                                        <i class="ti ti-search"></i> Cari Data Pasien
                                                    </small>
                                                </a>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    <input type="text" id="id_pasien" name="id_pasien" class="form-control" value="<?php echo $id_pasien;?>">
                                                    <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalDetailPasien" data-id="<?php echo "$id_pasien"; ?>" title="Lihat Detail Pasien">
                                                        <i class="ti ti-info-alt"></i> Cek
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3"><dt>Nama Pasien</dt></div>
                                            <div class="col-md-9">
                                                <input type="text" id="nama" name="nama" class="form-control" value="<?php echo $nama;?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <dt>ID Encounter</dt>
                                                <a href="javascript:void(0);" class="text-info" data-toggle="modal" data-target="#ModalCariEncounter" title="Cari ID Encounter Dari NIK">
                                                    <small><i class="ti ti-search"></i> Cari Encounter</small>
                                                </a>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" id="id_encounter" name="id_encounter" class="form-control" value="<?php echo $id_encounter;?>">
                                                <small>*Apabila Sudah Terhubung Dengan Service Encounter (Satu Sehat)</small>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3"><dt>NIK Pasien</dt></div>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    <input type="text" id="nik" name="nik" class="form-control" value="<?php echo $nik; ?>">
                                                    <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalDetailNik2">
                                                        <i class="ti ti-info-alt"></i> Cek
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3"><dt>Nomor BPJS</dt></div>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    <input type="text" id="no_bpjs" name="no_bpjs" class="form-control" value="<?php echo $no_bpjs; ?>">
                                                    <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalDetailBpjs2" title="Cek Nomor Kartu Tersebut">
                                                        <i class="ti ti-info-alt"></i> Cek
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <dt>ID Antrian</dt>
                                                <a href="javascript:void(0);" class="text-info" data-toggle="modal" data-target="#ModalCariAntrian" title="Cari Antrian Pasien">
                                                    <small><i class="ti ti-search"></i> Cari Antrian Dari No.RM</small>
                                                </a>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    <input type="text" id="id_antrian" name="id_antrian" class="form-control" value="<?php echo $id_antrian; ?>">
                                                    <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalCekIdAntrian" title="Cek ID Antrian">
                                                        <i class="ti ti-info-alt"></i> Cek
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <dt>Nomor Antrian</dt>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" id="no_antrian" name="no_antrian" class="form-control" value="<?php echo $no_antrian; ?>">
                                                <small>*Diisi Apabila sudah Terhubung Dengan Antrian</small>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <dt>Nomor SEP</dt>
                                                <small>*Apabila Sudah Dibuatkan SEP Pada Vclaim</small><br>
                                                <a href="javascript:void(0);" class="text-info" data-toggle="modal" data-target="#ModalCariSep">
                                                    <small><i class="ti ti-search"></i> Cari SEP Dari No.BPJS</small>
                                                </a>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    <input type="text" id="sep" name="sep" class="form-control" value="<?php echo $sep; ?>">
                                                    <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalCekNomorSep" title="Cek Nomor SEP Tersebut">
                                                        <i class="ti ti-info-alt"></i> Cek
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <dt>Nomor Rujukan</dt>
                                                <small>*Apabila Kunjungan Berasal Dari Rujukan Faskes Lain</small><br>
                                                <a href="javascript:void(0);" class="text-info" data-toggle="modal" data-target="#ModalCariRujukan" title="Cari Rujukan Berdasarkan Nomor kartu">
                                                    <small>
                                                        <i class="ti ti-search"></i> Cari Rujukan
                                                    </small>
                                                </a>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    <input type="text" id="noRujukan" name="noRujukan" class="form-control" value="<?php echo $noRujukan; ?>">
                                                    <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalCekRujukan" title="Cek Nomor Rujukan Tersebut">
                                                        <i class="ti ti-info-alt"></i> Cek
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <dt>Kode PPK Asal Rujukan</dt>
                                                <a href="javascript:void(0);" class="text-info" data-toggle="modal" data-target="#ModalPPKAsal" title="Lihat Detail Rujukan">
                                                    <small>
                                                        <i class="ti ti-search"></i> Cari PPK
                                                    </small>
                                                </a>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" name="rujukan_dari" id="rujukan_dari" value="<?php echo $rujukan_dari; ?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <dt>No.SKDP/SPRI</dt>
                                                <small>*Apabila Memiliki Data Rencana Kontrol</small><br>
                                                <a href="javascript:void(0);" class="text-info" data-toggle="modal" data-target="#ModalCriSuratKontrol" title="Cari Surat Kontrol Dari Nomor kartu">
                                                    <small>
                                                        <i class="ti ti-search"></i> Cari Surat Kontrol
                                                    </small>
                                                </a>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    <input type="text" id="skdp" name="skdp" class="form-control" value="<?php echo $skdp; ?>">
                                                    <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalCekSkdp" title="Lihat SKDP/SPRI Tersebut">
                                                        <i class="ti ti-info-alt"></i> Cek 
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3 mb-3"><dt>Tanggal/Waktu Layanan</dt></div>
                                            <div class="col-md-6 mb-3">
                                                <input type="date" name="tanggal" id="tanggal" value="<?php echo $TanggalKunjungan; ?>" class="form-control">
                                                <small>Tanggal</small>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <input type="time" name="waktu" id="waktu" value="<?php echo $JamKunjungan; ?>" class="form-control">
                                                <small>Waktu/Jam</small>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <dt>Diagnosa Awal</dt>
                                                <a href="javascript:void(0);" class="text-info" data-toggle="modal" data-target="#ModalCariDiagnosa" title="Cari Referensi Diagnosa">
                                                    <small>
                                                        <i class="ti ti-search"></i> Cari Referensi Diagnosa
                                                    </small>
                                                </a>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" id="DiagAwal" name="DiagAwal" class="form-control" value="<?php echo $DiagAwal; ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3"><dt>Keluhan Pasien</dt></div>
                                            <div class="col-md-9">
                                                <input type="text" id="keluhan" name="keluhan" class="form-control" value="<?php echo $keluhan; ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3"><dt>Tujuan Kunjungan</dt></div>
                                            <div class="col-md-9">
                                                <select name="tujuan" id="tujuan" class="form-control" required>
                                                    <option <?php if($tujuan==""){echo "selected";} ?> value="">Pilih</option>
                                                    <option <?php if($tujuan=="Rajal"){echo "selected";} ?> value="Rajal">Rajal</option>
                                                    <option <?php if($tujuan=="Ranap"){echo "selected";} ?> value="Ranap">Ranap</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3"><dt>Poliklinik</dt></div>
                                            <div class="col-md-9">
                                                <select name="id_poliklinik" id="id_poliklinik" class="form-control">
                                                    <option value="">Pilih</option>
                                                    <?php
                                                        //menamilkan dari database
                                                        $query = mysqli_query($Conn, "SELECT*FROM poliklinik");
                                                        while ($data = mysqli_fetch_array($query)) {
                                                            $IdPoliklinik= $data['id_poliklinik'];
                                                            $nama= $data['nama'];
                                                            $kode= $data['kode'];
                                                            if($id_poliklinik==$IdPoliklinik){
                                                                echo '<option selected value="'.$IdPoliklinik.'">'.$nama.'</option>';
                                                            }else{
                                                                echo '<option value="'.$IdPoliklinik.'">'.$nama.'</option>';
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3"><dt>Kelas/Ruangan</dt></div>
                                            <div class="col-md-9">
                                                <select name="id_kasur" id="id_kasur" class="form-control">
                                                    <option value="">Pilih</option>
                                                    <?php
                                                        //menamilkan dari database
                                                        $query = mysqli_query($Conn, "SELECT*FROM ruang_rawat WHERE kategori='bed'");
                                                        while ($data = mysqli_fetch_array($query)) {
                                                            $id_ruang_rawat= $data['id_ruang_rawat'];
                                                            $kelas= $data['kelas'];
                                                            $ruangan= $data['ruangan'];
                                                            $bed= $data['bed'];
                                                            if($id_kasur==$id_ruang_rawat){
                                                                echo '<option selected value="'.$id_ruang_rawat.'">'.$kelas.'/'.$bed.'</option>';
                                                            }else{
                                                                echo '<option value="'.$id_ruang_rawat.'">'.$kelas.'/'.$bed.'</option>';
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3"><dt>Dokter</dt></div>
                                            <div class="col-md-9">
                                                <select name="id_dokter" id="id_dokter" class="form-control">
                                                    <option value="">Pilih</option>
                                                    <?php
                                                        //menamilkan dari database
                                                        $query = mysqli_query($Conn, "SELECT*FROM dokter");
                                                        while ($data = mysqli_fetch_array($query)) {
                                                            $IdDokter= $data['id_dokter'];
                                                            $nama= $data['nama'];
                                                            $kodedokter= $data['kode'];
                                                            if($id_dokter==$IdDokter){
                                                                    echo '<option selected value="'.$IdDokter.'">'.$nama.'</option>';
                                                            }else{
                                                                    echo '<option value="'.$IdDokter.'">'.$nama.'</option>';
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3"><dt>Metode Pembayaran</dt></div>
                                            <div class="col-md-9">
                                                <select name="pembayaran" id="pembayaran" class="form-control">
                                                    <option <?php if($pembayaran==""){echo "selected";} ?> value="">Pilih</option>
                                                    <option <?php if($pembayaran=="UMUM"){echo "selected";} ?> value="UMUM">UMUM</option>
                                                    <option <?php if($pembayaran=="BPJS PBI"){echo "selected";} ?> value="BPJS PBI">BPJS PBI</option>
                                                    <option <?php if($pembayaran=="BPJS NON PBI"){echo "selected";} ?> value="BPJS NON PBI">BPJS NON PBI</option>
                                                    <option <?php if($pembayaran=="JAMPERSAL"){echo "selected";} ?> value="JAMPERSAL">JAMPERSAL</option>
                                                    <option <?php if($pembayaran=="JAMKESDA"){echo "selected";} ?> value="JAMKESDA">JAMKESDA</option>
                                                    <option <?php if($pembayaran=="ASKES"){echo "selected";} ?> value="ASKES">ASKES</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3"><dt>Status Kunjungan</dt></div>
                                            <div class="col-md-9">
                                                <select name="status" id="status" class="form-control">
                                                    <option <?php if($status=="Terdaftar"){echo "selected";} ?> value="Terdaftar">Terdaftar</option>
                                                    <option <?php if($status=="Pulang"){echo "selected";} ?> value="Pulang">Pulang</option>
                                                    <option <?php if($status=="Meninggal"){echo "selected";} ?> value="Meninggal">Meninggal</option>
                                                    <option <?php if($status=="Batal"){echo "selected";} ?> value="Batal">Batal</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-12" id="NotifikasiEditKunjunganRajal">
                                                <span class="text-primary">
                                                    <dt>Keterangan : </dt> Pastikan Data Pendaftaran Yang Anda Input Sudah Benar!
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="ti-save"></i> Simpan Kunjungan
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