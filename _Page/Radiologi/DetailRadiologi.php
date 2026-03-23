<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-md-8">
                        <?php
                            if(empty($_GET['id'])){
                                echo '  <div class="card table-card">';
                                echo '      <div class="row">';
                                echo '          <div class="col-md-12 text-center text-danger">';
                                echo '              ID Radiologi Tidak Boleh Kosong!';
                                echo '          </div>';
                                echo '      </div>';
                                echo '  </div>';
                            }else{
                                $id_rad=$_GET['id'];
                                if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'id_rad'))){
                                    echo '  <div class="card table-card">';
                                    echo '      <div class="row">';
                                    echo '          <div class="col-md-12 text-center text-danger">';
                                    echo '              ID Radiologi Tidak Valid Atau Tidak Ada Pada Database!';
                                    echo '          </div>';
                                    echo '      </div>';
                                    echo '  </div>';
                                }else{
                                    //Apakah Data Radiologi Ada?
                                    $id_pasien=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'id_pasien');
                                    $id_kunjungan=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'id_kunjungan');
                                    $NamaPasien=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'nama');
                                    $WaktuRadiologi=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'waktu');
                                    if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'asal_kiriman'))){
                                        $AsalKiriman='<small class="text-muted">Tidak Ada</small>';
                                    }else{
                                        $AsalKiriman=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'asal_kiriman');
                                    }
                                    
                                    $PermintaanPemeriksaan=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'permintaan_pemeriksaan');
                                    $AlatPemeriksa=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'alat_pemeriksa');
                                    $StatusPemeriksa=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'status_pemeriksaan');
                                    $JenisPembayaran=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'jenis_pembayaran');
                                    if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'dokter_pengirim'))){
                                        $DokterPengirim='<small class="text-muted">Tidak Ada</small>';
                                    }else{
                                        $DokterPengirim=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'dokter_pengirim');
                                    }
                                    if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'dokter_penerima'))){
                                        $DokterPenerima='<small class="text-muted">Tidak Ada</small>';
                                    }else{
                                        $DokterPenerima=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'dokter_penerima');
                                    }
                                    if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'radiografer'))){
                                        $RadioGrafer='<small class="text-muted">Belum Memperoleh Verifikasi</small>';
                                    }else{
                                        $RadioGrafer=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'radiografer');
                                    }
                                    if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'kesan'))){
                                        $Kesan='<small class="text-muted">Tidak Ada</small>';
                                    }else{
                                        $Kesan=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'kesan');
                                    }
                                    if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'klinis'))){
                                        $KlinisPasien='<small class="text-muted">Tidak Ada</small>';
                                    }else{
                                        $KlinisPasien=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'klinis');
                                    }
                                    if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'selesai'))){
                                        $WaktuSelesai='<small class="text-muted">Belum Diatur</small>';
                                    }else{
                                        $WaktuSelesai=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'selesai');
                                    }
                                    if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'kv'))){
                                        $kv='<small class="text-muted">None</small>';
                                    }else{
                                        $kv=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'kv');
                                    }
                                    if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'ma'))){
                                        $ma='<small class="text-muted">None</small>';
                                    }else{
                                        $ma=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'ma');
                                    }
                                    if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'sec'))){
                                        $sec='<small class="text-muted">None</small>';
                                    }else{
                                        $sec=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'sec');
                                    }
                        ?>
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-12 mb-3 text-center">
                                            <dt>
                                                <h4> <i class="ti ti-info-alt"></i> Detail Pendaftaran Radiologi</h4>
                                            </dt>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <a href="index.php?Page=Radiologi" class="btn btn-md btn-inverse btn-block">
                                                <i class="ti ti-angle-left"></i> Kembali
                                            </a>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="dropdown-info dropdown open btn-block">
                                                <button class="btn btn-md btn-info dropdown-toggle waves-effect waves-light btn-block" type="button" id="dropdown-7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                    Option
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdown-7" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                                    <a href="index.php?Page=Radiologi&Sub=KesanPenyakit&id=<?php echo "$id_rad"; ?>" class="dropdown-item waves-light waves-effect" title="Ubah/Isi Data Kesan Penyakit">
                                                        <i class="icofont-prescription"></i> Kesan Penyakit
                                                    </a>
                                                    <a href="index.php?Page=Radiologi&Sub=KlinisPasien&id=<?php echo "$id_rad"; ?>" class="dropdown-item waves-light waves-effect" title="Ubah/Isi Data Klinis Pasien">
                                                        <i class="icofont-heartbeat"></i> Klinis Pasien
                                                    </a>
                                                    <?php if($StatusPemeriksa=="Selesai"){ ?>
                                                        <a href="index.php?Page=Radiologi&Sub=EditRadiologi&id=<?php echo "$id_rad"; ?>" class="dropdown-item waves-light waves-effect" title="Ubah Data Pendaftaran">
                                                            <i class="icofont-edit"></i> Ubah Data Pendaftaran
                                                        </a>
                                                    <?php } ?>
                                                    <a href="javascript:void(0);" class="dropdown-item waves-light waves-effect" data-toggle="modal" data-target="#ModalHapusRadiologi" data-id="<?php echo "$id_rad"; ?>" title="Hapus Data Radiologi">
                                                        <i class="ti ti-close"></i> Hapus
                                                    </a>
                                                    <a href="javascript:void(0);" class="dropdown-item waves-light waves-effect" data-toggle="modal" data-target="#ModalCetak" data-id="<?php echo "$id_rad"; ?>" title="Cetak Data Radiologi">
                                                        <i class="ti ti-printer"></i> Cetak
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs md-tabs " role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#TabRadiologi" role="tab" aria-expanded="false">
                                                <i class="icofont-xray"></i> Radiologi
                                            </a>
                                            <div class="slide"></div>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#TabRmPasien" role="tab" aria-expanded="false">
                                                <i class="icofont icofont-ui-user "></i> RM Pasien
                                            </a>
                                            <div class="slide"></div>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#TabKunjungan" role="tab" aria-expanded="false">
                                                <i class="icofont-patient-file"></i> Kunjungan
                                            </a>
                                            <div class="slide"></div>
                                        </li>
                                    </ul>
                                    <!-- Tab panes -->
                                    <div class="tab-content card-block">
                                        <div class="tab-pane active" id="TabRadiologi" role="tabpanel" aria-expanded="false">
                                            <div class="row">
                                                <div class="col-md-12 mb-3 mt-3">
                                                    <dt>A. INFORMASI RADIOLOGI</dt>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 table table-responsive mb-3 mt-3">
                                                    <table class="table table-hover">
                                                        <tbody>
                                                            <tr>
                                                                <td>ID.PASIEN</td>
                                                                <td>:</td>
                                                                <td><?php echo "$id_pasien"; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>ID.REG</td>
                                                                <td>:</td>
                                                                <td><?php echo "$id_kunjungan"; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>NAMA</td>
                                                                <td>:</td>
                                                                <td><?php echo "$NamaPasien"; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>TANGGAL</td>
                                                                <td>:</td>
                                                                <td><?php echo "$WaktuRadiologi"; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>PEMERIKSAAN</td>
                                                                <td>:</td>
                                                                <td><?php echo "$PermintaanPemeriksaan"; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>ALAT</td>
                                                                <td>:</td>
                                                                <td><?php echo "$AlatPemeriksa"; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>PEMBAYARAN</td>
                                                                <td>:</td>
                                                                <td><?php echo "$JenisPembayaran"; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>DOKTER PENGIRIM</td>
                                                                <td>:</td>
                                                                <td><?php echo "$DokterPengirim"; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>DOKTER PEMIRIKSA</td>
                                                                <td>:</td>
                                                                <td><?php echo "$DokterPenerima"; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>KV/MA/SEC</td>
                                                                <td>:</td>
                                                                <td><?php echo "$kv/$ma/$sec"; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>RADIOGRAFER</td>
                                                                <td>:</td>
                                                                <td><?php echo "$RadioGrafer"; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>KESAN</td>
                                                                <td>:</td>
                                                                <td><?php echo "$Kesan"; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>KLINIS</td>
                                                                <td>:</td>
                                                                <td><?php echo "$KlinisPasien"; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>WAKTU SELESAI</td>
                                                                <td>:</td>
                                                                <td><?php echo "$WaktuSelesai"; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>STATUS</td>
                                                                <td>:</td>
                                                                <td><?php echo "$StatusPemeriksa"; ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="TabRmPasien" role="tabpanel" aria-expanded="false">
                                            <div class="row">
                                                <div class="col-md-12 mb-3 mt-3">
                                                    <dt>B. INFORMASI PASIEN</dt>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 mb-3 mt-3 table table-responsive">
                                                    <table class="table table-hover">
                                                        <tbody>
                                                            <?php
                                                                //KONDISI KETIKA ID PASIEN TIDAK DITEMUKAN
                                                                if(empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'id_pasien'))){
                                                                    echo '<tr>';
                                                                    echo '  <td colspan="4" class="text-danger">';
                                                                    echo '      ID Pasien Tidak Ditemukan Pada Data RM';
                                                                    echo '  </td>';
                                                                    echo '</tr>';
                                                                }else{
                                                                    $TanggalDaftar=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'tanggal_daftar');
                                                                    if(empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'nik'))){
                                                                        $NikPasien="<span class=''>Tidak Ada</span>";
                                                                    }else{
                                                                        $NikPasien=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'nik');
                                                                    }
                                                                    if(empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'no_bpjs'))){
                                                                        $NomorBpjs="<span class=''>Tidak Ada</span>";
                                                                    }else{
                                                                        $NomorBpjs=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'no_bpjs');
                                                                    }
                                                                    if(empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'nama'))){
                                                                        $NamaPasien="<span class=''>Tidak Ada</span>";
                                                                    }else{
                                                                        $NamaPasien=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'nama');
                                                                    }
                                                                    if(empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'gender'))){
                                                                        $Gender="<span class=''>Tidak Ada</span>";
                                                                    }else{
                                                                        $Gender=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'gender');
                                                                    }
                                                                    if(empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'tempat_lahir'))){
                                                                        $TempatLahir="<span class=''>Tidak Ada</span>";
                                                                    }else{
                                                                        $TempatLahir=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'tempat_lahir');
                                                                    }
                                                                    if(empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'tanggal_lahir'))){
                                                                        $TanggalLahir="<span class=''>Tidak Ada</span>";
                                                                    }else{
                                                                        $TanggalLahir=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'tanggal_lahir');
                                                                    }
                                                                    if(empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'propinsi'))){
                                                                        $propinsi="<span class=''>Tidak Ada</span>";
                                                                    }else{
                                                                        $propinsi=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'propinsi');
                                                                    }
                                                                    if(empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'kabupaten'))){
                                                                        $kabupaten="<span class=''>Tidak Ada</span>";
                                                                    }else{
                                                                        $kabupaten=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'kabupaten');
                                                                    }
                                                                    if(empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'kecamatan'))){
                                                                        $kecamatan="<span class=''>Tidak Ada</span>";
                                                                    }else{
                                                                        $kecamatan=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'kecamatan');
                                                                    }
                                                                    if(empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'desa'))){
                                                                        $desa="<span class=''>Tidak Ada</span>";
                                                                    }else{
                                                                        $desa=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'desa');
                                                                    }
                                                                    if(empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'alamat'))){
                                                                        $alamat="<span class=''>Tidak Ada</span>";
                                                                    }else{
                                                                        $alamat=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'alamat');
                                                                    }
                                                                    if(empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'kontak'))){
                                                                        $kontak="<span class=''>Tidak Ada</span>";
                                                                    }else{
                                                                        $kontak=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'kontak');
                                                                    }
                                                                    if(empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'kontak_darurat'))){
                                                                        $kontak_darurat="<span class=''>Tidak Ada</span>";
                                                                    }else{
                                                                        $kontak_darurat=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'kontak_darurat');
                                                                    }
                                                                    if(empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'penanggungjawab'))){
                                                                        $penanggungjawab="<span class=''>Tidak Ada</span>";
                                                                    }else{
                                                                        $penanggungjawab=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'penanggungjawab');
                                                                    }
                                                                    if(empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'golongan_darah'))){
                                                                        $golongan_darah="<span class=''>Tidak Ada</span>";
                                                                    }else{
                                                                        $golongan_darah=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'golongan_darah');
                                                                    }
                                                                    if(empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'perkawinan'))){
                                                                        $perkawinan="<span class=''>Tidak Ada</span>";
                                                                    }else{
                                                                        $perkawinan=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'perkawinan');
                                                                    }
                                                                    if(empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'gambar'))){
                                                                        $gambar="<span class=''>Tidak Ada</span>";
                                                                    }else{
                                                                        $gambar=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'gambar');
                                                                    }
                                                                    if(empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'pekerjaan'))){
                                                                        $pekerjaan="<span class=''>Tidak Ada</span>";
                                                                    }else{
                                                                        $pekerjaan=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'pekerjaan');
                                                                    }
                                                                    if(empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'status'))){
                                                                        $status="<span class=''>Tidak Ada</span>";
                                                                    }else{
                                                                        $status=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'status');
                                                                    }
                                                                    if(empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'updatetime'))){
                                                                        $updatetime="<span class=''>Tidak Ada</span>";
                                                                    }else{
                                                                        $updatetime=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'updatetime');
                                                                    }
                                                            ?>
                                                                <tr>
                                                                    <td>TANGGAL DAFTAR</td>
                                                                    <td>:</td>
                                                                    <td><?php echo "$TanggalDaftar"; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    
                                                                    <td>NIK</td>
                                                                    <td>:</td>
                                                                    <td><?php echo "$NikPasien"; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    
                                                                    <td>NO.BPJS</td>
                                                                    <td>:</td>
                                                                    <td><?php echo "$NomorBpjs"; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    
                                                                    <td>NAMA PASIEN</td>
                                                                    <td>:</td>
                                                                    <td><?php echo "$NamaPasien"; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    
                                                                    <td>GENDER</td>
                                                                    <td>:</td>
                                                                    <td><?php echo "$Gender"; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    
                                                                    <td>TTL</td>
                                                                    <td>:</td>
                                                                    <td><?php echo "$TempatLahir, $TanggalLahir"; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    
                                                                    <td>PROVINSI</td>
                                                                    <td>:</td>
                                                                    <td><?php echo "$propinsi"; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    
                                                                    <td>KABUPATEN</td>
                                                                    <td>:</td>
                                                                    <td><?php echo "$kabupaten"; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    
                                                                    <td>KECAMATAN</td>
                                                                    <td>:</td>
                                                                    <td><?php echo "$kecamatan"; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    
                                                                    <td>DESA</td>
                                                                    <td>:</td>
                                                                    <td><?php echo "$desa"; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    
                                                                    <td>ALAMAT SELENGKAPNYA</td>
                                                                    <td>:</td>
                                                                    <td><?php echo "$alamat"; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    
                                                                    <td>KONTAK</td>
                                                                    <td>:</td>
                                                                    <td><?php echo "$kontak"; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    
                                                                    <td>KONTAK DARURAT</td>
                                                                    <td>:</td>
                                                                    <td><?php echo "$kontak_darurat"; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    
                                                                    <td>PENANGGUNG JAWAB</td>
                                                                    <td>:</td>
                                                                    <td><?php echo "$penanggungjawab"; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    
                                                                    <td>GOLONGAN DARAH</td>
                                                                    <td>:</td>
                                                                    <td><?php echo "$golongan_darah"; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    
                                                                    <td>PERKAWINAN</td>
                                                                    <td>:</td>
                                                                    <td><?php echo "$perkawinan"; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    
                                                                    <td>PEKERJAAN</td>
                                                                    <td>:</td>
                                                                    <td><?php echo "$pekerjaan"; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    
                                                                    <td>STATUS</td>
                                                                    <td>:</td>
                                                                    <td><?php echo "$status"; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    
                                                                    <td>UPDATE TERAKHIR</td>
                                                                    <td>:</td>
                                                                    <td><?php echo "$updatetime"; ?></td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="tab-pane" id="TabKunjungan" role="tabpanel" aria-expanded="true">
                                            <div class="row">
                                                <div class="col-md-12 mb-3 mt-3">
                                                    <dt>C. INFORMASI KUNJUNGAN</dt>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 mb-3 mt-3 table table-responsive">
                                                    <table class="table table-hover">
                                                        <tbody>
                                                            <?php
                                                                //KONDISI KETIKA KUNJUNGAN TIDAK DITEMUKAN
                                                                if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'id_kunjungan'))){
                                                                    echo '<tr>';
                                                                    echo '  <td colspan="4" class="text-danger">';
                                                                    echo '      ID Pasien Tidak Ditemukan Pada Data RM';
                                                                    echo '  </td>';
                                                                    echo '</tr>';
                                                                }else{
                                                                    $id_kunjungan=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'id_kunjungan');
                                                                    if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'no_antrian'))){
                                                                        $no_antrian="<span class=''>Tidak Ada</span>";
                                                                    }else{
                                                                        $no_antrian=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'no_antrian');
                                                                    }
                                                                    if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'sep'))){
                                                                        $sep="<span class=''>Tidak Ada</span>";
                                                                    }else{
                                                                        $sep=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'sep');
                                                                    }
                                                                    if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'noRujukan'))){
                                                                        $noRujukan="<span class=''>Tidak Ada</span>";
                                                                    }else{
                                                                        $noRujukan=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'noRujukan');
                                                                    }
                                                                    if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'skdp'))){
                                                                        $skdp="<span class=''>Tidak Ada</span>";
                                                                    }else{
                                                                        $skdp=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'skdp');
                                                                    }
                                                                    if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'tanggal'))){
                                                                        $tanggal="<span class=''>Tidak Ada</span>";
                                                                    }else{
                                                                        $tanggal=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'tanggal');
                                                                    }
                                                                    if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'keluhan'))){
                                                                        $keluhan="<span class=''>Tidak Ada</span>";
                                                                    }else{
                                                                        $keluhan=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'keluhan');
                                                                    }
                                                                    if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'tujuan'))){
                                                                        $tujuan="<span class=''>Tidak Ada</span>";
                                                                    }else{
                                                                        $tujuan=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'tujuan');
                                                                    }
                                                                    if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'id_dokter'))){
                                                                        $id_dokter="<span class=''>Tidak Ada</span>";
                                                                    }else{
                                                                        $id_dokter=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'id_dokter');
                                                                    }
                                                                    if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'dokter'))){
                                                                        $dokter="<span class=''>Tidak Ada</span>";
                                                                    }else{
                                                                        $dokter=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'dokter');
                                                                    }
                                                                    if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'id_poliklinik'))){
                                                                        $id_poliklinik="<span class=''>Tidak Ada</span>";
                                                                    }else{
                                                                        $id_poliklinik=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'id_poliklinik');
                                                                    }
                                                                    if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'poliklinik'))){
                                                                        $poliklinik="<span class=''>Tidak Ada</span>";
                                                                    }else{
                                                                        $poliklinik=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'poliklinik');
                                                                    }
                                                                    if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'kelas'))){
                                                                        $kelas="<span class=''>Tidak Ada</span>";
                                                                    }else{
                                                                        $kelas=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'kelas');
                                                                    }
                                                                    if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'ruangan'))){
                                                                        $ruangan="<span class=''>Tidak Ada</span>";
                                                                    }else{
                                                                        $ruangan=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'ruangan');
                                                                    }
                                                                    if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'id_kasur'))){
                                                                        $id_kasur="<span class=''>Tidak Ada</span>";
                                                                    }else{
                                                                        $id_kasur=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'id_kasur');
                                                                    }
                                                                    if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'DiagAwal'))){
                                                                        $DiagAwal="<span class=''>Tidak Ada</span>";
                                                                    }else{
                                                                        $DiagAwal=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'DiagAwal');
                                                                    }
                                                                    if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'rujukan_dari'))){
                                                                        $rujukan_dari="<span class=''>Tidak Ada</span>";
                                                                    }else{
                                                                        $rujukan_dari=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'rujukan_dari');
                                                                    }
                                                                    if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'rujukan_ke'))){
                                                                        $rujukan_ke="<span class=''>Tidak Ada</span>";
                                                                    }else{
                                                                        $rujukan_ke=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'rujukan_ke');
                                                                    }
                                                                    if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'pembayaran'))){
                                                                        $pembayaran="<span class=''>Tidak Ada</span>";
                                                                    }else{
                                                                        $pembayaran=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'pembayaran');
                                                                    }
                                                                    if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'cara_keluar'))){
                                                                        $cara_keluar="<span class=''>Tidak Ada</span>";
                                                                    }else{
                                                                        $cara_keluar=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'cara_keluar');
                                                                    }
                                                                    if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'tanggal_keluar'))){
                                                                        $tanggal_keluar="<span class=''>Tidak Ada</span>";
                                                                    }else{
                                                                        $tanggal_keluar=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'tanggal_keluar');
                                                                    }
                                                                    if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'status'))){
                                                                        $status="<span class=''>Tidak Ada</span>";
                                                                    }else{
                                                                        $status=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'status');
                                                                    }
                                                                    if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'id_akses'))){
                                                                        $id_akses="<span class=''>Tidak Ada</span>";
                                                                    }else{
                                                                        $id_akses=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'id_akses');
                                                                    }
                                                                    if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'nama_petugas'))){
                                                                        $nama_petugas="<span class=''>Tidak Ada</span>";
                                                                    }else{
                                                                        $nama_petugas=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'nama_petugas');
                                                                    }
                                                                    if(empty(getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'updatetime'))){
                                                                        $updatetime="<span class=''>Tidak Ada</span>";
                                                                    }else{
                                                                        $updatetime=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'updatetime');
                                                                    }
                                                            ?>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>NO.REG</td>
                                                                    <td>:</td>
                                                                    <td><?php echo "$id_kunjungan"; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>NO.ANTRIAN</td>
                                                                    <td>:</td>
                                                                    <td><?php echo "$no_antrian"; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>SEP</td>
                                                                    <td>:</td>
                                                                    <td><?php echo "$sep"; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>NO.RUJUKAN</td>
                                                                    <td>:</td>
                                                                    <td><?php echo "$noRujukan"; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>SKDP</td>
                                                                    <td>:</td>
                                                                    <td><?php echo "$skdp"; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>TANGGAL</td>
                                                                    <td>:</td>
                                                                    <td><?php echo "$tanggal"; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>KELUHAN</td>
                                                                    <td>:</td>
                                                                    <td><?php echo "$keluhan"; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>TUJUAN</td>
                                                                    <td>:</td>
                                                                    <td><?php echo "$tujuan"; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>DOKTER</td>
                                                                    <td>:</td>
                                                                    <td><?php echo "$dokter"; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>POLIKLINIK</td>
                                                                    <td>:</td>
                                                                    <td><?php echo "$poliklinik"; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>KELAS</td>
                                                                    <td>:</td>
                                                                    <td><?php echo "$kelas"; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>RUANGAN</td>
                                                                    <td>:</td>
                                                                    <td><?php echo "$ruangan"; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>BED/TT</td>
                                                                    <td>:</td>
                                                                    <td><?php echo "$id_kasur"; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>DIAGNOSA AWAL</td>
                                                                    <td>:</td>
                                                                    <td><?php echo "$DiagAwal"; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>ASAL RUJUKAN</td>
                                                                    <td>:</td>
                                                                    <td><?php echo "$rujukan_dari"; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>TUJUAN RUJUKAN</td>
                                                                    <td>:</td>
                                                                    <td><?php echo "$rujukan_ke"; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>PEMBAYARAN</td>
                                                                    <td>:</td>
                                                                    <td><?php echo "$pembayaran"; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>CARA KELUAR</td>
                                                                    <td>:</td>
                                                                    <td><?php echo "$cara_keluar"; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>TGL.KELUAR</td>
                                                                    <td>:</td>
                                                                    <td><?php echo "$tanggal_keluar"; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>STATUS</td>
                                                                    <td>:</td>
                                                                    <td><?php echo "$status"; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>PETUGAS</td>
                                                                    <td>:</td>
                                                                    <td><?php echo "$nama_petugas"; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>UPDATETIME</td>
                                                                    <td>:</td>
                                                                    <td><?php echo "$updatetime"; ?></td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header text-center">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <a href="index.php?Page=Radiologi&Sub=TambahHasilPemeriksaan&id=<?php echo "$id_rad"; ?>" class="btn btn-md btn-outline-dark btn-block">
                                            <i class="icofont-patient-file"></i> Hasil Pemeriksaan
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body bg-default">
                                <?php  
                                    $JumlahRincian = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM radiologi_rincian WHERE id_rad='$id_rad'"));
                                    if(empty($JumlahRincian)){
                                        echo '<div class="card mb-3">';
                                        echo '  <div class="card-body">';
                                        echo '      <div class="row">';
                                        echo '          <div class="col-md-12 text-center text-danger mb-3">';
                                        echo '              <i class="icofont-sad icofont-5x"></i><br>';
                                        echo '          </div>';
                                        echo '          <div class="col-md-12 text-center text-danger mb-3">';
                                        echo '              Belum Ada Data Hasil Pemeriksaan';
                                        echo '          </div>';
                                        echo '      </div>';
                                        echo '  </div>';
                                        echo '</div>';
                                    }
                                    $QryHasil = mysqli_query($Conn, "SELECT*FROM radiologi_rincian WHERE id_rad='$id_rad'");
                                    while ($DataHasil = mysqli_fetch_array($QryHasil)) {
                                        $id_rincian= $DataHasil['id_rincian'];
                                        if(empty($DataHasil['pemeriksaan'])){
                                            $pemeriksaan='<span class="text-danger">Pemeriksaan Tidak Diketahui</span>';
                                        }else{
                                            $pemeriksaan= $DataHasil['pemeriksaan'];
                                        }
                                        if(empty($DataHasil['hasil'])){
                                            $hasil='<span class="text-danger">Hasil Tidak Ada</span>';
                                            $JumlahKarakter="";
                                        }else{
                                            $hasil= $DataHasil['hasil'];
                                            $JumlahKarakter=strlen($hasil);
                                            if($JumlahKarakter>=200){
                                                $PotongKarakter=substr($hasil,0,200);
                                                $hasil="$PotongKarakter (...)";
                                            }
                                        }
                                ?>
                                <div class="card mb-3">
                                    <div class="card-header text-dark">
                                        <dt class="text-dark">
                                            <a href="javascript:void(0);" data-toggle="modal" data-target="#ModalDetailRincian" data-id="<?php echo "$id_rincian";?>" class="text-success">
                                                <?php echo "<i class='icofont-maximize'></i> $pemeriksaan"; ?>
                                            </a>
                                        </dt>
                                    </div>
                                    <div class="card-body text-dark">
                                        <?php echo "$hasil"; ?>
                                    </div>
                                    <div class="card-footer">
                                        <div class="btn-group">
                                            <a href="index.php?Page=Radiologi&Sub=EditHasilPemeriksaan&id_rad=<?php echo "$id_rad";?>&id_rincian=<?php echo "$id_rincian";?>" class="btn btn-sm btn-outline-dark">
                                                <i class="ti ti-pencil"></i> Edit
                                            </a>
                                            <button class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalHapusRincian" data-id="<?php echo "$id_rincian";?>">
                                                <i class="ti ti-close"></i> Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header text-center">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <button class="btn btn-md btn-outline-dark btn-block" data-toggle="modal" data-target="#ModalTambahFile" data-id="<?php echo "$id_rad";?>">
                                            <i class="ti ti-upload"></i> File Lampiran
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body bg-default">
                                <?php  
                                    $JumlahLampiran = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM radiologi_file WHERE id_rad='$id_rad'"));
                                    if(empty($JumlahLampiran)){
                                        echo '<div class="card mb-3">';
                                        echo '  <div class="card-body">';
                                        echo '      <div class="row">';
                                        echo '          <div class="col-md-12 text-center text-secondary mb-3">';
                                        echo '              <i class="icofont-attachment icofont-5x"></i><br>';
                                        echo '          </div>';
                                        echo '          <div class="col-md-12 text-center text-secondary mb-3">';
                                        echo '              Tidak Ada File Lampiran';
                                        echo '          </div>';
                                        echo '      </div>';
                                        echo '  </div>';
                                        echo '</div>';
                                    }
                                    $QryLampiran = mysqli_query($Conn, "SELECT*FROM radiologi_file WHERE id_rad='$id_rad'");
                                    while ($DataLampiran = mysqli_fetch_array($QryLampiran)) {
                                        $id_radiologi_file=$DataLampiran['id_radiologi_file'];
                                        $id_akses=$DataLampiran['id_akses'];
                                        $tanggal=$DataLampiran['tanggal'];
                                        $internal_eksternal=$DataLampiran['internal_eksternal'];
                                        $title=$DataLampiran['title'];
                                        if(empty($DataLampiran['deskripsi'])){
                                            $deskripsi="";
                                            $LabelDeskripsi="";
                                        }else{
                                            $deskripsi= $DataLampiran['deskripsi'];
                                            $LabelDeskripsi='<span class="label label-inverse"><i class="icofont-ui-text-chat"></i> Deskripsi</span>';
                                        }
                                        if(empty($DataLampiran['filesize'])){
                                            $filesize=0;
                                        }else{
                                            $filesize= $DataLampiran['filesize'];
                                        }
                                        if(empty($DataLampiran['url_file'])){
                                            $url_file="";
                                        }else{
                                            $url_file= $DataLampiran['url_file'];
                                        }
                                        if(empty($DataLampiran['filename'])){
                                            $filename="";
                                        }else{
                                            $filename= $DataLampiran['filename'];
                                        }
                                        //Ukuran file
                                        $filesize=formatSizeUnits($filesize);
                                        //Format Tanggal
                                        $StrtotimeTanggal=strtotime($tanggal);
                                        $FormatTanggalLampiran=date('d/m/Y H:i',$StrtotimeTanggal);
                                        //Apakah dari internal atau eksternal
                                        if($internal_eksternal=="Internal"){
                                            $LabelFile='<span class="text-primary"><i class="icofont-file-image"></i> Internal File</span>';
                                            $UrlFile="assets/images/Radiologi/$filename";
                                        }else{
                                            $UrlFile="$url_file";
                                            $LabelFile='<span class="text-success"><i class="icofont-external-link"></i> Eksternal File</span>';
                                        }
                                ?>
                                <div class="card">
                                    <div class="card-header">
                                        <dt>
                                            <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalDetailLampiranRadiologi" data-id="<?php echo "$id_radiologi_file";?>">
                                                <i class="icofont-maximize"></i> <?php echo "$title"; ?>
                                            </a>
                                        </dt>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <img src="<?php echo $UrlFile;?>" width="100px" height="100px" class="img img-radius">
                                            </div>
                                            <div class="col-md-8 text-dark">
                                                <?php 
                                                    echo "<i class='icofont-history'></i> $FormatTanggalLampiran <br>"; 
                                                    echo "<i class='ti ti-file'></i> $filesize <br>"; 
                                                    echo '<a href="'.$UrlFile.'" target="_blank">'.$LabelFile.'</a> <br>'; 
                                                    echo "$LabelDeskripsi <br>"; 
                                                ?>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="card-footer">
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalEditLampiran" data-id="<?php echo "$id_radiologi_file";?>">
                                                <i class="ti ti-pencil"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalHapusLampiran" data-id="<?php echo "$id_radiologi_file";?>">
                                                <i class="ti ti-close"></i> Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <?php
                                    $JumlahVerifikasiRadiografer = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM radiologi_sig WHERE id_rad='$id_rad' AND kategori='Radiografer'"));
                                    if(empty($JumlahVerifikasiRadiografer)){
                                        echo '<a href="index.php?Page=Radiologi&Sub=VerifikasiRadiografer&id='.$id_rad.'" class="btn btn-md btn-block btn-dropbox" title="Verifikasi Dari Petugas Radiografer">';
                                        echo '  <i class="icofont-finger-print"></i> Verifikasi Radiografer';
                                        echo '</a>';
                                    }else{
                                        //Buka data verifikasi radiologi
                                        $QryVerifikasiRadiografer = mysqli_query($Conn,"SELECT * FROM radiologi_sig WHERE id_rad='$id_rad' AND kategori='Radiografer'")or die(mysqli_error($Conn));
                                        $DataVerifikasiRadiografer = mysqli_fetch_array($QryVerifikasiRadiografer);
                                        $id_radiologi_sig=$DataVerifikasiRadiografer['id_radiologi_sig'];
                                        $TanggalFVerifikasiRadioGrafer=$DataVerifikasiRadiografer['tanggal'];
                                        $NamaValidator=$DataVerifikasiRadiografer['nama'];
                                        $signature=$DataVerifikasiRadiografer['signature'];
                                        //Format Tanggal
                                        $StrtotimeTanggal2=strtotime($TanggalFVerifikasiRadioGrafer);
                                        $TanggalFVerifikasiRadioGrafer=date('d/m/Y H:i',$StrtotimeTanggal2);
                                        echo '<dt class="text-success">';
                                        echo '  <i class="icofont-checked"></i> Terverifikasi Radiografer';
                                        echo '</dt>';
                                    }
                                ?>
                            </div>
                            <div class="card-body bg-default">
                                <?php
                                    $JumlahVerifikasiRadiografer = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM radiologi_sig WHERE id_rad='$id_rad' AND kategori='Radiografer'"));
                                    if(empty($JumlahVerifikasiRadiografer)){
                                        echo '<div class="card mb-3">';
                                        echo '  <div class="card-body">';
                                        echo '      <div class="row">';
                                        echo '          <div class="col-md-12 text-center text-secondary mb-3">';
                                        echo '              <i class="icofont-finger-print icofont-5x"></i><br>';
                                        echo '          </div>';
                                        echo '          <div class="col-md-12 text-center text-secondary mb-3">';
                                        echo '              Belum Memperoleh Verifikasi Radiografer';
                                        echo '          </div>';
                                        echo '      </div>';
                                        echo '  </div>';
                                        echo '</div>';
                                    }else{
                                ?>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <img src="<?php echo 'data:image/png;base64,' . $signature . '';?>" width="100px" height="100px" class="img img-radius">
                                                </div>
                                                <div class="col-md-8 text-dark">
                                                    <?php 
                                                        echo "<i class='ti ti-file'></i> $id_rad <br>"; 
                                                        echo "<i class='ti ti-user'></i> $NamaValidator <br>"; 
                                                        echo "<i class='ti ti-calendar'></i> $TanggalFVerifikasiRadioGrafer <br>"; 
                                                    ?>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="card-footer">
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalDetailVerifikasi" data-id="<?php echo "$id_radiologi_sig";?>">
                                                    <i class="ti ti-info-alt"></i> Detail
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <?php
                                    $JumlahVerifikasiDokter = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM radiologi_sig WHERE id_rad='$id_rad' AND kategori='Dokter Spesialis'"));
                                    if(empty($JumlahVerifikasiDokter)){
                                        echo '<a href="index.php?Page=Radiologi&Sub=VerifikasiDokter&id='.$id_rad.'" class="btn btn-md btn-dropbox btn-block" title="Verifikasi Dari Dokter Spesialis">';
                                        echo '  <i class="icofont-finger-print"></i> Verifikasi Dokter';
                                        echo '</a>';
                                    }else{
                                        //Buka data verifikasi Dokter
                                        $QryVerifikasiDokter = mysqli_query($Conn,"SELECT * FROM radiologi_sig WHERE id_rad='$id_rad' AND kategori='Dokter Spesialis'")or die(mysqli_error($Conn));
                                        $DataVerifikasiDokter = mysqli_fetch_array($QryVerifikasiDokter);
                                        $id_radiologi_sig=$DataVerifikasiDokter['id_radiologi_sig'];
                                        $TanggalFVerifikasiDokter=$DataVerifikasiDokter['tanggal'];
                                        $NamaValidatorDokter=$DataVerifikasiDokter['nama'];
                                        $SignatureDokter=$DataVerifikasiDokter['signature'];
                                        //Format Tanggal
                                        $StrtotimeTanggal3=strtotime($TanggalFVerifikasiDokter);
                                        $TanggalFVerifikasiDokter=date('d/m/Y H:i',$StrtotimeTanggal3);
                                        echo '<dt class="text-success">';
                                        echo '  <i class="icofont-checked"></i> Terverifikasi Dokter';
                                        echo '</dt>';
                                    }
                                ?>
                            </div>
                            <div class="card-body bg-default">
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php
                                            $JumlahVerifikasiDokter = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM radiologi_sig WHERE id_rad='$id_rad' AND kategori='Dokter Spesialis'"));
                                            if(empty($JumlahVerifikasiDokter)){
                                                echo '<div class="card mb-3">';
                                                echo '  <div class="card-body">';
                                                echo '      <div class="row">';
                                                echo '          <div class="col-md-12 text-center text-secondary mb-3">';
                                                echo '              <i class="icofont-finger-print icofont-5x"></i><br>';
                                                echo '          </div>';
                                                echo '          <div class="col-md-12 text-center text-secondary mb-3">';
                                                echo '              Belum Memperoleh Verifikasi Dokter Spesialis';
                                                echo '          </div>';
                                                echo '      </div>';
                                                echo '  </div>';
                                                echo '</div>';
                                            }else{
                                        ?>
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <img src="<?php echo 'data:image/png;base64,' . $SignatureDokter . '';?>" width="100px" height="100px" class="img img-radius">
                                                        </div>
                                                        <div class="col-md-8 text-dark">
                                                            <?php 
                                                                echo "<i class='ti ti-file'></i> $id_rad <br>"; 
                                                                echo "<i class='ti ti-user'></i> $NamaValidatorDokter <br>"; 
                                                                echo "<i class='ti ti-calendar'></i> $TanggalFVerifikasiDokter <br>"; 
                                                            ?>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                <div class="card-footer">
                                                    <div class="btn-group">
                                                        <button class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalDetailVerifikasi" data-id="<?php echo "$id_radiologi_sig";?>">
                                                            <i class="ti ti-info-alt"></i> Detail
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div id="styleSelector">

        </div>
    </div>
</div>