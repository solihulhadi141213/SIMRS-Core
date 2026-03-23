<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_pasien
    if(empty($_POST['nik'])){
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center text-danger">';
        echo '          NIK Pasien Tidak Boleh Kosong!';
        echo '      </div>';
        echo '  </div>';
    }else{
        $nik=$_POST['nik'];
        $id_pasien =getDataDetail($Conn,"pasien",'nik',$nik,'id_pasien');
        $id_ihs =getDataDetail($Conn,"pasien",'nik',$nik,'id_ihs');
        $nama =getDataDetail($Conn,"pasien",'nik',$nik,'nama');
        $tanggal_daftar =getDataDetail($Conn,"pasien",'nik',$nik,'tanggal_daftar');
        $nik =getDataDetail($Conn,"pasien",'nik',$nik,'nik');
        $no_bpjs =getDataDetail($Conn,"pasien",'nik',$nik,'no_bpjs');
        $gender =getDataDetail($Conn,"pasien",'nik',$nik,'gender');
        $tempat_lahir =getDataDetail($Conn,"pasien",'nik',$nik,'tempat_lahir');
        $tanggal_lahir =getDataDetail($Conn,"pasien",'nik',$nik,'tanggal_lahir');
        $propinsi =getDataDetail($Conn,"pasien",'nik',$nik,'propinsi');
        $kabupaten =getDataDetail($Conn,"pasien",'nik',$nik,'kabupaten');
        $kecamatan =getDataDetail($Conn,"pasien",'nik',$nik,'kecamatan');
        $desa =getDataDetail($Conn,"pasien",'nik',$nik,'desa');
        $alamat =getDataDetail($Conn,"pasien",'nik',$nik,'alamat');
        $alamat =getDataDetail($Conn,"pasien",'nik',$nik,'alamat');
        $kontak =getDataDetail($Conn,"pasien",'nik',$nik,'kontak');
        $kontak_darurat =getDataDetail($Conn,"pasien",'nik',$nik,'kontak_darurat');
        $penanggungjawab =getDataDetail($Conn,"pasien",'nik',$nik,'penanggungjawab');
        $golongan_darah =getDataDetail($Conn,"pasien",'nik',$nik,'golongan_darah');
        $perkawinan =getDataDetail($Conn,"pasien",'nik',$nik,'perkawinan');
        $pekerjaan =getDataDetail($Conn,"pasien",'nik',$nik,'pekerjaan');
        $gambar =getDataDetail($Conn,"pasien",'nik',$nik,'gambar');
        $status =getDataDetail($Conn,"pasien",'nik',$nik,'status');
        $id_pasien_relasi =getDataDetail($Conn,"pasien",'nik',$nik,'id_pasien_relasi');
        $status_relasi =getDataDetail($Conn,"pasien",'nik',$nik,'status_relasi');
        $id_akses =getDataDetail($Conn,"pasien",'nik',$nik,'id_akses');
        $nama_petugas =getDataDetail($Conn,"pasien",'nik',$nik,'nama_petugas');
        $updatetime =getDataDetail($Conn,"pasien",'nik',$nik,'updatetime');
?>
    <div class="row"> 
        <div class="col-md-12">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs md-tabs " role="tablist">
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#home7" role="tab" aria-expanded="true">
                        <i class="ti ti-info-alt"></i> Detail
                    </a>
                    <div class="slide"></div>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#profile7" role="tab" aria-expanded="false">
                        <i class="icofont-ui-v-card"></i> BPJS
                    </a>
                    <div class="slide"></div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#messages7" role="tab">
                        <i class="icofont-id-card"></i> IHS
                    </a>
                    <div class="slide"></div>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content card-block">
                <div class="tab-pane" id="home7" role="tabpanel" aria-expanded="true">
                <div class="row mb-3">
                    <div class="col-md-6"><dt>No.RM</dt></div>
                    <div class="col-md-6"><small><?php echo "$id_pasien"; ?></small></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"><dt>ID IHS</dt></div>
                    <div class="col-md-6"><small><?php echo "$id_ihs"; ?></small></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"><dt>Nama Lengkap</dt></div>
                    <div class="col-md-6"><small><?php echo "$nama"; ?></small></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"><dt>Tanggal Daftar</dt></div>
                    <div class="col-md-6"><small><?php echo "$tanggal_daftar"; ?></small></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"><dt>NIK</dt></div>
                    <div class="col-md-6"><small><?php echo "$nik"; ?></small></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"><dt>BPJS</dt></div>
                    <div class="col-md-6"><small><?php echo "$no_bpjs"; ?></small></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"><dt>TTL</dt></div>
                    <div class="col-md-6"><small><?php echo "$tempat_lahir, $tanggal_lahir"; ?></small></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"><dt>Provinsi</dt></div>
                    <div class="col-md-6"><small><?php echo "$propinsi"; ?></small></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"><dt>Kabupaten/Kota</dt></div>
                    <div class="col-md-6"><small><?php echo "$kabupaten"; ?></small></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"><dt>Kecamatan</dt></div>
                    <div class="col-md-6"><small><?php echo "$kecamatan"; ?></small></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"><dt>Desa/Kelurahan</dt></div>
                    <div class="col-md-6"><small><?php echo "$desa"; ?></small></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"><dt>Alamat</dt></div>
                    <div class="col-md-6"><small><?php echo "$alamat"; ?></small></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"><dt>Kontak Utama</dt></div>
                    <div class="col-md-6"><small><?php echo "$kontak"; ?></small></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"><dt>Kontak Darurat</dt></div>
                    <div class="col-md-6"><small><?php echo "$kontak_darurat"; ?></small></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"><dt>Penanggung Jawab</dt></div>
                    <div class="col-md-6"><small><?php echo "$penanggungjawab"; ?></small></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"><dt>Golongan Darah</dt></div>
                    <div class="col-md-6"><small><?php echo "$golongan_darah"; ?></small></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"><dt>Status Perkawinan</dt></div>
                    <div class="col-md-6"><small><?php echo "$perkawinan"; ?></small></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"><dt>Pekerjaan</dt></div>
                    <div class="col-md-6"><small><?php echo "$pekerjaan"; ?></small></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"><dt>Status pasien</dt></div>
                    <div class="col-md-6"><small><?php echo "$status"; ?></small></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"><dt>Petugas Pencatat</dt></div>
                    <div class="col-md-6"><small><?php echo "$nama_petugas"; ?></small></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"><dt>Update Time</dt></div>
                    <div class="col-md-6"><small><?php echo "$updatetime"; ?></small></div>
                </div>
                </div>
                <div class="tab-pane active" id="profile7" role="tabpanel" aria-expanded="false">
                    <div id="FormDetailNikByBpjs">

                    </div>
                </div>
                <div class="tab-pane" id="messages7" role="tabpanel">
                    <div id="FormDetailNikByIhs" class="mt-3 mb-3">

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>