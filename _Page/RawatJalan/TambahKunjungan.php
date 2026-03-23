<?php
    include "_Config/SimrsFunction.php"; 
    if(empty($_SESSION['UrlBackKunjungan'])){
        $UrlBack='index.php?Page=RawatJalan';
    }else{
        $UrlBack=$_SESSION['UrlBackKunjungan'];
    }
    //Tangkap ID
    if(empty($_GET['id'])){
        echo '<span class="text-danger">Belum Ada data Pasien Yang Dipilih</span>';
    }else{
        $id_pasien=$_GET['id'];
        if(empty($_GET['antrian'])){
            $antrian="";
        }else{
            $antrian=$_GET['antrian'];
        }
        if(empty($_GET['id_antrian'])){
            $id_antrian="";
        }else{
            $id_antrian=$_GET['id_antrian'];
        }
        //Membuka data antrian
        $id_antrian=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'id_antrian');
        $no_antrian=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'no_antrian');
        $kode_dokter=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'kode_dokter');
        $nama_dokter=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'nama_dokter');
        $kodepoli=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'kodepoli');
        $namapoli=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'namapoli');
        $tanggal_kunjungan=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'tanggal_kunjungan');
        $jam_kunjungan=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'jam_kunjungan');
        $keluhan=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'keluhan');
        //Pecah jam kunjungan
        $pecah=explode('-',$jam_kunjungan);
        $JamMulai=$pecah['0'];
        //Membuka data
        $QryPasien = mysqli_query($Conn,"SELECT * FROM pasien WHERE id_pasien='$id_pasien'")or die(mysqli_error($Conn));
        $DataPasien = mysqli_fetch_array($QryPasien);
        $id_pasien=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'id_pasien');
        $tanggal_daftar=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'tanggal_daftar');
        $nik=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'nik');
        $no_bpjs=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'no_bpjs');
        $nama=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'nama');
        //Tanggal sekarang
        $tanggal=date('Y-m-d');
        $jam=date('H:i');
?>
<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="javascript:void(0);" id="ProsesTambahKunjungan" autocomplete="off">
                            <input type="hidden" name="UrlForBack" id="UrlForBack" value="<?php echo "$UrlBack"; ?>">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-10 mb-2">
                                            <h4>
                                                <i class="ti ti-plus"></i> Form Tambah Kunjungan
                                            </h4>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <a href="<?php echo $UrlBack;?>" class="btn btn-sm btn-secondary btn-block">
                                                <i class="ti ti-angle-left"></i> Kembali
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-4">
                                        <div class="col-md-12 sub-title">
                                            <dt class="mb-4">A. Informasi Pasien</dt>
                                            <div class="row mb-3">
                                                <div class="col-md-3">
                                                    NO.RM
                                                    <a href="javascript:void(0);" class="badge badge-primary" data-toggle="modal" data-target="#ModalTambahRajal" title="Cari Data Pasien">
                                                        <i class="ti ti-search"></i>
                                                    </a>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <input type="text" id="id_pasien" name="id_pasien" class="form-control" value="<?php echo $id_pasien;?>">
                                                        <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#ModalDetailPasien" data-id="<?php echo "$id_pasien"; ?>" title="Lihat Detail Pasien">
                                                            <i class="ti ti-layers"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-3">Nama Pasien</div>
                                                <div class="col-md-9">
                                                    <input type="text" id="nama" name="nama" class="form-control" value="<?php echo $nama;?>">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-3">
                                                    ID Encounter
                                                    <a href="javascript:void(0);" class="badge badge-primary" data-toggle="modal" data-target="#ModalCariEncounter" title="Cari ID Encounter Dari NIK">
                                                        <i class="ti ti-search"></i>
                                                    </a>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" id="id_encounter" name="id_encounter" class="form-control">
                                                    <small>*Hanya apabila Sudah Terhubung Dengan Service Encounter (Satu Sehat)</small>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-3">NIK Pasien</div>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <input type="text" id="nik" name="nik" class="form-control" value="<?php echo $nik; ?>">
                                                        <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#ModalDetailNik2">
                                                            <i class="ti ti-layers"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-3">Nomor BPJS</div>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <input type="text" id="no_bpjs" name="no_bpjs" class="form-control" value="<?php echo $no_bpjs; ?>">
                                                        <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#ModalDetailBpjs2" title="Cek Nomor Kartu Tersebut">
                                                            <i class="ti ti-layers"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-12 sub-title">
                                            <dt class="mb-4">B. Antrian</dt>
                                            <?php
                                                //Pencarian Antrian Otomatis
                                                $CekAntrianPasien=getDataDetail($Conn,'antrian','id_pasien',$id_pasien,'id_antrian');
                                                if(!empty($CekAntrianPasien)){
                                                    echo '<div class="row mb-3">';
                                                    echo '  <div class="col-md-12">';
                                                    echo '      <span class="text-danger">*</span>';
                                                    echo '      Sistem menemukan ada data antrian untuk kunjungan ini, silahkan pilih tombol cari untuk informasi selengkapnya';
                                                    echo '  </div>';
                                                    echo '</div>';
                                                }
                                            ?>
                                            <div class="row mb-3">
                                                <div class="col-md-3">
                                                    ID Antrian
                                                    <a href="javascript:void(0);" class="badge badge-primary" data-toggle="modal" data-target="#ModalCariAntrian" title="Cari Antrian Pasien">
                                                        <i class="ti ti-search"></i>
                                                    </a>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <input type="text" id="id_antrian" name="id_antrian" class="form-control" value="<?php echo $id_antrian; ?>">
                                                        <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#ModalCekIdAntrian" title="Cek ID Antrian">
                                                            <i class="ti ti-layers"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-3">
                                                    Nomor Antrian
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" id="no_antrian" name="no_antrian" class="form-control" value="<?php echo $no_antrian; ?>">
                                                    <small>*Diisi Apabila sudah Terhubung Dengan Antrian</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-12 sub-title">
                                            <dt class="mb-4">C. BPJS Kesehatan</dt>
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    *Apabila sebelumnya sudah dibuatkan SEP, Rujukan atau Surat Kontrol pada platform lain, anda tinggal melengkapi parameter berikut ini.
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-3">
                                                    No.SEP
                                                    <a href="javascript:void(0);" class="badge badge-primary" title="Cari Nomor SEP Berdasarkan Nomor Kartu" data-toggle="modal" data-target="#ModalCariSep">
                                                        <i class="ti ti-search"></i>
                                                    </a>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <input type="text" id="sep" name="sep" class="form-control" value="">
                                                        <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#ModalCekNomorSep" title="Cek Nomor SEP Tersebut">
                                                            <i class="ti ti-layers"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-3">
                                                    No.Rujukan Masuk
                                                    <a href="javascript:void(0);" class="badge badge-primary" data-toggle="modal" data-target="#ModalCariRujukan" title="Cari Rujukan Berdasarkan Nomor kartu">
                                                        <i class="ti ti-search"></i>
                                                    </a>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <input type="text" id="noRujukan" name="noRujukan" class="form-control" value="">
                                                        <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#ModalDetailRujukanPendaftaranKunjungan" title="Cek Nomor Rujukan Tersebut">
                                                            <i class="ti ti-layers"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-3">
                                                    Kode PPK Asal Rujukan
                                                    <a href="javascript:void(0);" class="badge badge-primary" data-toggle="modal" data-target="#ModalPPKAsal" title="Cari PPK Rujukan Rujukan">
                                                        <i class="ti ti-search"></i>
                                                    </a>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" name="rujukan_dari" id="rujukan_dari" value="" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-3">
                                                    No.SKDP/SPRI
                                                    <a href="javascript:void(0);" class="badge badge-primary" data-toggle="modal" data-target="#ModalCariSpriSkdpPendaftaranKunjungan" title="Cari SKDP/SPRI Dari Nomor kartu">
                                                        <i class="ti ti-search"></i>
                                                    </a>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <input type="text" id="skdp" name="skdp" class="form-control" value="">
                                                        <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#ModalCekSkdpPendaftaranKunjungan" title="Cek Nomor SKDP/SPRI Tersebut">
                                                            <i class="ti ti-layers"></i> 
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12 mb-4 sub-title">
                                            <dt class="mb-4">D. Informasi Kunjungan</dt>
                                            <div class="row mb-3">
                                                <div class="col-md-3 mb-3">Tanggal Layanan</div>
                                                <div class="col-md-9 mb-3">
                                                    <input type="date" name="tanggal" id="tanggal" value="<?php echo date('Y-m-d'); ?>" class="form-control">
                                                    <small>Tanggal pelayanan atau tanggal dimana pasien melakukan pendaftaran kunjungan</small>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-3 mb-3">Waktu/Jam Layanan</div>
                                                <div class="col-md-9 mb-3">
                                                    <input type="time" name="waktu" id="waktu" value="<?php echo date('H:i'); ?>" class="form-control">
                                                    <small>Jam pelayanan atau waktu dimana pasien melakukan pendaftaran kunjungan</small>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-3">Tujuan Kunjungan</div>
                                                <div class="col-md-9">
                                                    <select name="tujuan" id="tujuan" class="form-control" required>
                                                        <option value="">Pilih</option>
                                                        <option value="Rajal">Rajal</option>
                                                        <option value="Ranap">Ranap</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-12 sub-title">
                                            <dt class="mb-4">E. Assesment Pendaftaran Kunjungan</dt>
                                            <div class="row mb-3">
                                                <div class="col-md-3">
                                                    Diagnosa Awal
                                                    <a href="javascript:void(0);" class="badge badge-primary" data-toggle="modal" data-target="#ModalCariDiagnosa" title="Cari Referensi Diagnosa">
                                                        <i class="ti ti-search"></i>
                                                    </a>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" id="DiagAwal" name="DiagAwal" class="form-control" value="">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-3">Keluhan Pasien</div>
                                                <div class="col-md-9">
                                                    <input type="text" id="keluhan" name="keluhan" class="form-control" value="">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-3">Poliklinik</div>
                                                <div class="col-md-9">
                                                    <select name="id_poliklinik" id="id_poliklinik" class="form-control">
                                                        <option value="">Pilih</option>
                                                        <?php
                                                            //menamilkan dari database
                                                            $query = mysqli_query($Conn, "SELECT*FROM poliklinik");
                                                            while ($data = mysqli_fetch_array($query)) {
                                                                $id_poliklinik= $data['id_poliklinik'];
                                                                $nama= $data['nama'];
                                                                $kode= $data['kode'];
                                                                if($kodepoli==$kode){
                                                                    echo '<option selected value="'.$id_poliklinik.'">'.$nama.'</option>';
                                                                }else{
                                                                    echo '<option value="'.$id_poliklinik.'">'.$nama.'</option>';
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-3">Kelas/Ruangan</div>
                                                <div class="col-md-9">
                                                    <select name="id_kasur" id="id_kasur" class="form-control">
                                                        <option value="">Pilih</option>
                                                        <?php
                                                            //Menampilkan kelas
                                                            $no=1;
                                                            $QryKelas = mysqli_query($Conn, "SELECT kelas FROM ruang_rawat WHERE kategori='kelas' AND status='Aktif'");
                                                            while ($DataKelas = mysqli_fetch_array($QryKelas)) {
                                                                $KelasUtama= $DataKelas['kelas'];
                                                                echo '<optgroup label="'.$no.'. '.$KelasUtama.'">';
                                                                //menamilkan dari database ruangan
                                                                $no2=1;
                                                                $QryRuangan = mysqli_query($Conn, "SELECT kelas, ruangan FROM ruang_rawat WHERE kategori='ruangan' AND kelas='$KelasUtama' AND status='Aktif'");
                                                                while ($DataRuangan = mysqli_fetch_array($QryRuangan)) {
                                                                    $kelas= $DataRuangan['kelas'];
                                                                    $ruangan= $DataRuangan['ruangan'];
                                                                    echo '<optgroup label="&nbsp;&nbsp;'.$no.'.'.$no2.'.'.$ruangan.'">';
                                                                    //menamilkan dari database Bed
                                                                    $QryBed = mysqli_query($Conn, "SELECT * FROM ruang_rawat WHERE kategori='bed' AND kelas='$KelasUtama' AND ruangan='$ruangan' AND status='Aktif'");
                                                                    while ($DataBed = mysqli_fetch_array($QryBed)) {
                                                                        $id_ruang_rawat= $DataBed['id_ruang_rawat'];
                                                                        $bed= $DataBed['bed'];
                                                                        echo '<option value="'.$id_ruang_rawat.'">'.$kelas.'/'.$ruangan.'/'.$bed.'</option>';
                                                                    }
                                                                    echo '</optgroup>';
                                                                    $no2++;
                                                                }
                                                                $no++;
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-3">Dokter DPJP</div>
                                                <div class="col-md-9">
                                                    <select name="id_dokter" id="id_dokter" class="form-control">
                                                        <option value="">Pilih</option>
                                                        <?php
                                                            //menamilkan dari database
                                                            $query = mysqli_query($Conn, "SELECT*FROM dokter");
                                                            while ($data = mysqli_fetch_array($query)) {
                                                                $id_dokter= $data['id_dokter'];
                                                                $nama= $data['nama'];
                                                                $kodedokter= $data['kode'];
                                                                if($kode_dokter==$kodedokter){
                                                                        echo '<option selected value="'.$id_dokter.'">'.$nama.'</option>';
                                                                }else{
                                                                        echo '<option value="'.$id_dokter.'">'.$nama.'</option>';
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-12 sub-title">
                                            <dt class="mb-4">F. Status Kunjungan</dt>
                                            <div class="row mb-3">
                                                <div class="col-md-3">Metode Pembayaran</div>
                                                <div class="col-md-9">
                                                    <select name="pembayaran" id="pembayaran" class="form-control">
                                                        <option value="">Pilih</option>
                                                        <option value="UMUM">UMUM</option>
                                                        <option value="BPJS PBI">BPJS PBI</option>
                                                        <option value="BPJS NON PBI">BPJS NON PBI</option>
                                                        <option value="JAMPERSAL">JAMPERSAL</option>
                                                        <option value="JAMKESDA">JAMKESDA</option>
                                                        <option value="ASKES">ASKES</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-3">Status Kunjungan</div>
                                                <div class="col-md-9">
                                                    <select name="status" id="status" class="form-control">
                                                        <option value="Terdaftar">Terdaftar</option>
                                                        <option value="Pulang">Pulang</option>
                                                        <option value="Meninggal">Meninggal</option>
                                                        <option value="Batal">Batal</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12" id="NotifikasiTambahKunjunganRajal">
                                            <span class="text-primary">Pastikan Data Pendaftaran Yang Anda Input Sudah Benar!</span>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>