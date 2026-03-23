<?php
    if(empty($_SESSION['UrlBackRad'])){
        $UrlBack="index.php?Page=Radiologi";
    }else{
        $UrlBack=$_SESSION['UrlBackRad'];
    }
    //Apabila memperoleh parameter Get id_kunjungan
    if(!empty($_GET['id_kunjungan'])){
        $id_kunjungan=$_GET['id_kunjungan'];
        $id_pasien=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_pasien');
        $NamaPasien=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'nama');
        $TujuanKunjungan=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'tujuan');
    }else{
        $id_kunjungan="";
        $id_pasien="";
        $NamaPasien="";
        $TujuanKunjungan="";
    }
?>

<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-xl-12 col-md-12">
                        <form action="javascript:void(0);" id="ProsesPendaftaranRadiologi">
                            <div class="card table-card">
                                <div class="card-header border-info">
                                    <div class="row">
                                        <div class="col-md-8 mb-3">
                                            <h4 class="text-dark">
                                                <i class="icofont-prescription"></i> Form Pendaftaran Pemeriksaan Radiologi
                                            </h4>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <a href="<?php echo "$UrlBack"; ?>" class="btn btn-sm btn-block btn-secondary" title="Kembali Ke Halaman Data Radiologi">
                                                <i class="ti ti-angle-left"></i> Kembali
                                            </a>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <button type="button" class="btn btn-sm btn-block btn-primary" data-toggle="modal" data-target="#ModalPilihDataKunjungan" title="Pilih Kunjungan Pasien">
                                                <i class="ti ti-search"></i> Pasien
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-4">
                                        <div class="col-md-3">
                                            <label for="id_pasien"><dt>No.RM (Nomor Rekam Medis)</dt></label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" readonly name="id_pasien" id="id_pasien" class="form-control" data-toggle="modal" data-target="#ModalPilihDataKunjungan" placeholder="Nomor RM" value="<?php echo "$id_pasien"; ?>">
                                        </div>
                                    </div>
                                     <div class="row mb-4">
                                        <div class="col-md-3">
                                            <label for="id_pasien"><dt>ID REG (Nomor Kunjungan)</dt></label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <input type="text" readonly name="id_kunjungan" id="id_kunjungan" class="form-control" placeholder="ID Kunjungan" data-toggle="modal" data-target="#ModalPilihDataKunjungan" value="<?php echo "$id_kunjungan"; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-3">
                                            <label for="nama"><dt>Nama Lengkap Pasien</dt></label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" readonly name="nama" id="nama" data-toggle="modal" data-target="#ModalPilihDataKunjungan" class="form-control" value="<?php echo "$NamaPasien"; ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-3 mb-2">
                                            <label for="tanggal"><dt>Tanggal & Waktu Permintaan</dt></label>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <input type="date" readonly name="tanggal" id="tanggal" value="<?php echo date('Y-m-d'); ?>" class="form-control">
                                            <small>Tanggal</small>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <input type="time" readonly name="jam" id="jam" class="form-control" value="<?php echo date('H:i'); ?>">
                                            <small>Waktu/Jam</small>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-3">
                                            <label for="tujuan_kunjungan"><dt>Kategori Kunjungan</dt></label>
                                        </div>
                                        <div class="col-md-9">
                                            <select name="tujuan_kunjungan" id="tujuan_kunjungan" class="form-control">
                                                <option value="">Pilih</option>
                                                <option value="Rajal">Rajal</option>
                                                <option value="Ranap">Ranap</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-3">
                                            <label for="asal_kiriman"><dt>Asal Kiriman</dt></label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" name="asal_kiriman" id="asal_kiriman" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-3">
                                            <label for="jenis_pembayaran"><dt>Metode Pembayaran</dt></label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" name="jenis_pembayaran" id="jenis_pembayaran" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-3">
                                            <label for="dokter_pengirim"><dt>Dokter Pengirim</dt></label>
                                        </div>
                                        <div class="col-md-9">
                                            <select name="dokter_pengirim" id="dokter_pengirim" class="form-control">
                                                <option value="">Pilih</option>
                                                <?php
                                                    //menampilkan list dokter
                                                    $QryDokter = mysqli_query($Conn, "SELECT id_dokter, nama FROM dokter ORDER BY nama ASC");
                                                    while ($DataDokter = mysqli_fetch_array($QryDokter)) {
                                                        if(!empty($DataDokter['nama'])){
                                                            echo '<option value="'.$DataDokter['id_dokter'].'">'.$DataDokter['nama'].'</option>';
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-3">
                                            <label for="priority"><dt><i>Priority</i></dt></label>
                                        </div>
                                        <div class="col-md-9">
                                            <select name="priority" id="priority" class="form-control">
                                                <option value="">Pilih</option>
                                                <?php
                                                    $priority_list = [
                                                        'routine' => 'Biasa',
                                                        'urgent'  => 'Segera',
                                                        'stat'    => 'Gawat'
                                                    ];
                                                    foreach($priority_list as $kode_p => $nama_p){
                                                        echo '<option value="'.$kode_p.'">'.$nama_p.'</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-3">
                                            <label for="alat_pemeriksa"><dt>Alat/Pesawat (Modality)</dt></label>
                                        </div>
                                        <div class="col-md-9">
                                            <select name="alat_pemeriksa" id="alat_pemeriksa" class="form-control">
                                                <option value="">Pilih</option>
                                                <?php
                                                    $nama_modalitas = [
                                                        'XR' => 'X-Ray',
                                                        'CT' => 'CT-Scan',
                                                        'US' => 'USG',
                                                        'MR' => 'MRI',
                                                        'NM' => 'Nuclear Medicine (Kedokteran Nuklir)',
                                                        'PT' => 'PET Scan',
                                                        'DX' => 'Digital Radiography',
                                                        'CR' => 'Computed Radiography'
                                                    ];
                                                    foreach($nama_modalitas as $kode => $nama){
                                                        echo '<option value="'.$kode.'">'.$nama.'</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-3">
                                            <label for="permintaan_pemeriksaan"><dt>Permintaan Pemeriksaan</dt></label>
                                        </div>
                                        <div class="col-md-9">
                                            <select name="permintaan_pemeriksaan" id="permintaan_pemeriksaan" data-toggle="modal" data-target="#ModalPilihPermintaanPemeriksaan" class="form-control">
                                                <option value="">Pilih</option>
                                            </select>
                                            <input type="hidden" id="permintaan_pemeriksaan_value" name="permintaan_pemeriksaan_value" value="">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-3">
                                            <label for="select_klinis"><dt>Klinis Pasien</dt></label>
                                        </div>
                                        <div class="col-md-9">
                                            <select name="klinis" id="select_klinis" data-toggle="modal" data-target="#ModalKlinis" class="form-control">
                                                <option value="">Pilih</option>
                                            </select>
                                            <input type="hidden" id="klinis_value" name="klinis_value" value="">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-3">
                                            <label for="keterangan"><dt>Keterangan Lainnya</dt></label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" name="keterangan" id="keterangan" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 col-form-label"></div>
                                        <div class="col-md-9">
                                            <div class="form-check">
                                                <input type="checkbox" checked name="pernyataan" id="pernyataan" value="Ya" class="form-check-input" required>
                                                <label for="pernyataan" class="form-check-label text-muted">
                                                    Dengan ini saya menyatakan bahwa seluruh data pasien yang tercantum 
                                                    dalam formulir permintaan pemeriksaan radiologi telah diisi secara 
                                                    benar, lengkap, dan sesuai dengan kebutuhan pemeriksaan pasien.
                                                </label>
                                            </div>
                                            <div class="invalid-feedback">
                                                Anda harus menyetujui pernyataan ini sebelum melanjutkan.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col-md-3 col-form-label"></div>
                                        <div class="col-md-9" id="NotifikasiPendaftaranRadiologi">
                                            <!-- Notifikasi Proses Akan Muncul Disini -->
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-md btn-primary mb-3" id="TombolSimpanRadiologi">
                                        <i class="ti ti-save"></i> Simpan
                                    </button>
                                    <button type="reset" class="btn btn-md btn-inverse mb-3">
                                        <i class="ti ti-reload"></i> Reset
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
<?php
    //Hancurkan Session
    $_SESSION['UrlBackRad']="";
?>