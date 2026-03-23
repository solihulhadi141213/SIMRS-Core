<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_kunjungan
    if(empty($_POST['id_kunjungan'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center text-danger mb-3">';
        echo '          ID Kunjungan Tidak Boleh Kosong.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer bg-inverse">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12">';
        echo '          <button type="button" class="btn btn-sm btn-light" data-dismiss="modal"><i class="ti-close"></i> Tutup</button>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_kunjungan=$_POST['id_kunjungan'];
        //URL Back pasien
        if(empty($_POST['UrlBackPasien'])){
            $_SESSION['UrlBackKunjungan']="index.php?Page=RawatJalan";
        }else{
            $_SESSION['UrlBackKunjungan']=$_POST['UrlBackPasien'];
        }
        //Buka data Kunjungan
        $Qry = mysqli_query($Conn,"SELECT * FROM kunjungan_utama WHERE id_kunjungan='$id_kunjungan'")or die(mysqli_error($Conn));
        $Data = mysqli_fetch_array($Qry);
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
         //Membuka daya approval
        $id_approval=getDataDetail($Conn,"approval",'noKartu',$no_bpjs,'id_approval');
        //Menghitung data rencana kontrol
        $JumlahRencanaKontrol = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM rencana_kontrol WHERE kategori='Rencana Kontrol' AND noSEP='$sep'"));
        //Menghitung data SPRI
        $JumlahSPRI = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM rencana_kontrol WHERE kategori='SPRI' AND noSEP='$sep'"));
        //Membuka rencana_kontrol
        if(!empty($sep)){
            $QryRencanaKontrol = mysqli_query($Conn,"SELECT * FROM rencana_kontrol WHERE kategori='Rencana Kontrol' AND noSEP='$sep'")or die(mysqli_error($Conn));
            $DataRencanaKontrol = mysqli_fetch_array($QryRencanaKontrol);
            if(!empty($DataRencanaKontrol['id_rencana_kontrol'])){
                $id_rencana_kontrol= $DataRencanaKontrol['id_rencana_kontrol'];
                $noSuratKontrol= $DataRencanaKontrol['noSuratKontrol'];
                $tglRencanaKontrol= $DataRencanaKontrol['tglRencanaKontrol'];
                $namaDokter= $DataRencanaKontrol['namaDokter'];
            }else{
                $id_rencana_kontrol="";
                $noSuratKontrol="";
                $tglRencanaKontrol="";
                $namaDokter="";
            }
        }else{
            $id_rencana_kontrol="";
            $noSuratKontrol="";
            $tglRencanaKontrol="";
            $namaDokter="";
        }
        $strtotime=strtotime($tanggal);
        $TanggalFormat=date('d/m/Y H:i',$strtotime);
        //Update Time Format
        $strtotime2=strtotime($updatetime);
        $updatetime_format=date('d/m/Y H:i',$strtotime2);
        //Buka Ihs Pasien
        $id_ihs=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'id_ihs');
?>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 accordion-block">
                <div id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="accordion-panel active">
                        <div class="accordion-heading" role="tab" id="headingOne">
                            <h3 class="card-title accordion-title">
                                <a class="accordion-msg waves-effect waves-dark scale_active collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    <dt>A.Informasi Umum</dt>
                                </a>
                            </h3>
                        </div>
                        <div id="collapseOne" class="panel-collapse in collapse show" role="tabpanel" aria-labelledby="headingOne" style="">
                            <div class="accordion-content accordion-desc">
                                <div class="row mb-3">
                                    <div class="col-md-4">A.1 Id Kunjungan</div>
                                    <div class="col-md-8">
                                        <span>
                                            <?php 
                                                if(empty($id_kunjungan)){
                                                    echo '<span class="text-danger">Tidak Ada</small>';
                                                }else{
                                                    echo "<span>$id_kunjungan</small>"; 
                                                }
                                            ?>
                                        </small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">A.2 Tanggal</div>
                                    <div class="col-md-8">
                                        <span>
                                            <?php 
                                                if(empty($tanggal)){
                                                    echo '<span class="text-danger">Tidak Ada</small>';
                                                }else{
                                                    echo "<span>$TanggalFormat</small>"; 
                                                }
                                            ?>
                                        </small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">A.3 Id Encounter</div>
                                    <div class="col-md-8">
                                        <span>
                                            <?php 
                                                if(empty($id_encounter)){
                                                    echo '<span class="text-danger">Tidak Ada</small>';
                                                }else{
                                                    echo "<span>$id_encounter</small>"; 
                                                }
                                            ?>
                                        </small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">A.4 No.RM</div>
                                    <div class="col-md-8">
                                        <span>
                                            <?php 
                                                if(empty($id_pasien)){
                                                    echo '<span class="text-danger">Tidak Ada</small>';
                                                }else{
                                                    echo "<span>$id_pasien</small>"; 
                                                }
                                            ?>
                                        </small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">A.5 ID IHS</div>
                                    <div class="col-md-8">
                                        <span>
                                            <?php 
                                                if(empty($id_ihs)){
                                                    echo '<span class="text-danger">Tidak Ada</small>';
                                                }else{
                                                    echo "<span>$id_ihs</small>"; 
                                                }
                                            ?>
                                        </small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">A.6 NIK</div>
                                    <div class="col-md-8">
                                        <span>
                                            <?php 
                                                if(empty($nik)){
                                                    echo '<span class="text-danger">Tidak Ada</small>';
                                                }else{
                                                    echo "<span>$nik</small>"; 
                                                }
                                            ?>
                                        </small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">A.7 No.BPJS</div>
                                    <div class="col-md-8">
                                        <span>
                                            <?php 
                                                if(empty($no_bpjs)){
                                                    echo '<span class="text-danger">Tidak Ada</small>';
                                                }else{
                                                    echo "<span>$no_bpjs</small>"; 
                                                }
                                            ?>
                                        </small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">A.8 Nama</div>
                                    <div class="col-md-8">
                                        <span>
                                            <?php 
                                                if(empty($nama)){
                                                    echo '<span class="text-danger">Tidak Ada</small>';
                                                }else{
                                                    echo "<span>$nama</small>"; 
                                                }
                                            ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-heading" role="tab" id="headingTwo">
                            <h3 class="card-title accordion-title">
                                <a class="accordion-msg waves-effect waves-dark scale_active collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <dt>B. Alamat Pasien</dt>
                                </a>
                            </h3>
                        </div>
                        <div id="collapseTwo" class="panel-collapse in collapse" role="tabpanel" aria-labelledby="headingTwo" style="">
                            <div class="accordion-content accordion-desc">
                                <div class="row mb-3">
                                    <div class="col-md-4">B.1 Alamat</div>
                                    <div class="col-md-8">
                                        <span>
                                            <?php 
                                                if(empty($alamat)){
                                                    echo '<span class="text-danger">Tidak Ada</small>';
                                                }else{
                                                    echo "<span>$alamat</small>"; 
                                                }
                                            ?>
                                        </small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">B.2 Desa</div>
                                    <div class="col-md-8">
                                        <span>
                                            <?php 
                                                if(empty($desa)){
                                                    echo '<span class="text-danger">Tidak Ada</small>';
                                                }else{
                                                    echo "<span>$desa</small>"; 
                                                }
                                            ?>
                                        </small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">B.3 Kecamatan</div>
                                    <div class="col-md-8">
                                        <span>
                                            <?php 
                                                if(empty($kecamatan)){
                                                    echo '<span class="text-danger">Tidak Ada</small>';
                                                }else{
                                                    echo "<span>$kecamatan</small>"; 
                                                }
                                            ?>
                                        </small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">B.4 Kabupaten</div>
                                    <div class="col-md-8">
                                        <span>
                                            <?php 
                                                if(empty($kabupaten)){
                                                    echo '<span class="text-danger">Tidak Ada</small>';
                                                }else{
                                                    echo "<span>$kabupaten</small>"; 
                                                }
                                            ?>
                                        </small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">B.5 Provinsi</div>
                                    <div class="col-md-8">
                                        <span>
                                            <?php 
                                                if(empty($propinsi)){
                                                    echo '<span class="text-danger">Tidak Ada</small>';
                                                }else{
                                                    echo "<span>$propinsi</small>"; 
                                                }
                                            ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-heading" role="tab" id="headingTri">
                            <h3 class="card-title accordion-title">
                                <a class="accordion-msg waves-effect waves-dark scale_active collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTri" aria-expanded="false" aria-controls="collapseTri">
                                    <dt>C. Informasi Kunjungan</dt>
                                </a>
                            </h3>
                        </div>
                        <div id="collapseTri" class="panel-collapse in collapse" role="tabpanel" aria-labelledby="headingTri" style="">
                            <div class="accordion-content accordion-desc">
                                <div class="row mb-3">
                                    <div class="col-md-4">C.1 Nomor SEP</div>
                                    <div class="col-md-8">
                                        <span>
                                            <?php 
                                                if(empty($sep)){
                                                    echo '<span class="text-danger">Tidak Ada</small>';
                                                }else{
                                                    echo "<span>$sep</small>"; 
                                                }
                                            ?>
                                        </small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">C.2 Nomor Rujukan</div>
                                    <div class="col-md-8">
                                        <span>
                                            <?php 
                                                if(empty($noRujukan)){
                                                    echo '<span class="text-danger">Tidak Ada</small>';
                                                }else{
                                                    echo "<span>$noRujukan</small>"; 
                                                }
                                            ?>
                                        </small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">C.3 Tujuan</div>
                                    <div class="col-md-8">
                                        <span>
                                            <?php 
                                                if(empty($tujuan)){
                                                    echo '<span class="text-danger">Tidak Ada</small>';
                                                }else{
                                                    echo "<span>$tujuan</small>"; 
                                                }
                                            ?>
                                        </small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">C.4 Dokter</div>
                                    <div class="col-md-8">
                                        <span>
                                            <?php 
                                                if(empty($dokter)){
                                                    echo '<span class="text-danger">Tidak Ada</small>';
                                                }else{
                                                    echo "<span>$dokter</small>"; 
                                                }
                                            ?>
                                        </small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">C.5 Poliklinik</div>
                                    <div class="col-md-8">
                                        <span>
                                            <?php 
                                                if(empty($poliklinik)){
                                                    echo '<span class="text-danger">Tidak Ada</small>';
                                                }else{
                                                    echo "<span>$poliklinik</small>"; 
                                                }
                                            ?>
                                        </small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">C.6 Kelas/Ruangan</div>
                                    <div class="col-md-8">
                                        <span>
                                            <?php 
                                                if(empty($kelas)){
                                                    echo '<span class="text-danger">Tidak Ada</small>';
                                                }else{
                                                    echo "<span>$kelas-$ruangan</small>"; 
                                                }
                                            ?>
                                        </small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">C.7 Pembayaran</div>
                                    <div class="col-md-8">
                                        <span>
                                            <?php 
                                                if(empty($pembayaran)){
                                                    echo '<span class="text-danger">Tidak Ada</small>';
                                                }else{
                                                    echo "<span>$pembayaran</small>"; 
                                                }
                                            ?>
                                        </small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">C.8 Diagnosa Awal</div>
                                    <div class="col-md-8">
                                        <span>
                                            <?php 
                                                if(empty($DiagAwal)){
                                                    echo '<span class="text-danger">Tidak Ada</small>';
                                                }else{
                                                    echo "<span>$DiagAwal</small>"; 
                                                }
                                            ?>
                                        </small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">C.9 Rujukan Dari</div>
                                    <div class="col-md-8">
                                        <span>
                                            <?php 
                                                if(empty($rujukan_dari)){
                                                    echo '<span class="text-danger">Tidak Ada</small>';
                                                }else{
                                                    echo "<span>$rujukan_dari</small>"; 
                                                }
                                            ?>
                                        </small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">C.10 Dirujuk Ke</div>
                                    <div class="col-md-8">
                                        <span>
                                            <?php 
                                                if(empty($rujukan_ke)){
                                                    echo '<span class="text-danger">Tidak Ada</small>';
                                                }else{
                                                    echo "<span>$rujukan_ke</small>"; 
                                                }
                                            ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-heading" role="tab" id="headingFour">
                            <h3 class="card-title accordion-title">
                                <a class="accordion-msg waves-effect waves-dark scale_active collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    <dt>D. Informasi Kepulangan</dt>
                                </a>
                            </h3>
                        </div>
                        <div id="collapseFour" class="panel-collapse in collapse" role="tabpanel" aria-labelledby="headingFour" style="">
                            <div class="accordion-content accordion-desc">
                                <div class="row mb-3">
                                    <div class="col-md-4">D.1 Cara Keluar</div>
                                    <div class="col-md-8">
                                        <span>
                                            <?php 
                                                if(empty($cara_keluar)){
                                                    echo '<span class="text-danger">Tidak Ada</small>';
                                                }else{
                                                    echo "<span>$cara_keluar</small>"; 
                                                }
                                            ?>
                                        </small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">D.2 Tanggal Keluar</div>
                                    <div class="col-md-8">
                                        <span>
                                            <?php 
                                                if(empty($tanggal_keluar)){
                                                    echo '<span class="text-danger">Tidak Ada</small>';
                                                }else{
                                                    echo "<span>$tanggal_keluar</small>"; 
                                                }
                                            ?>
                                        </small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">D.3 Status</div>
                                    <div class="col-md-8">
                                        <span>
                                            <?php 
                                                if(empty($status)){
                                                    echo '<span class="text-danger">Tidak Ada</small>';
                                                }else{
                                                    echo "<span>$status</small>"; 
                                                }
                                            ?>
                                        </small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">D.4 Updatetime</div>
                                    <div class="col-md-8">
                                        <span>
                                            <?php 
                                                if(empty($updatetime_format)){
                                                    echo '<span class="text-danger">Tidak Ada</small>';
                                                }else{
                                                    echo "<span>$updatetime_format</small>"; 
                                                }
                                            ?>
                                        </small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">D.5 Petugas</div>
                                    <div class="col-md-8">
                                        <span>
                                            <?php 
                                                if(empty($nama_petugas)){
                                                    echo '<span class="text-danger">Tidak Ada</small>';
                                                }else{
                                                    echo "<span>$nama_petugas</small>"; 
                                                }
                                            ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-inverse">
        <div class="row">
            <div class="col-md-12">
                <!-- <div class="btn-group dropdown-split-inverse">
                    <button type="button" class="btn btn-md btn-inverse dropdown-toggle dropdown-toggle-split waves-effect waves-light mt-2 ml-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="OptionButton">
                        Option
                    </button>
                    <div class="dropdown-menu" x-placement="top-start" style="position: absolute; transform: translate3d(107px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                        <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalEditKunjungan">
                            <i class="ti-pencil"></i> Edit
                        </a>
                        <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalHapusKunjungan">
                            <i class="ti-trash"></i> Hapus
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalBuatSEP">
                            <i class="icofont-stethoscope-alt"></i> Buat SEP
                        </a>
                        <?php if(!empty($sep)){ ?>
                            <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalEditSEP" data-id="<?php echo "$sep";?>">
                                <i class="ti ti-pencil-alt2"></i> Edit SEP
                            </a>
                            <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalHapusSep" data-id="<?php echo "$sep";?>">
                                <i class="ti ti-trash"></i> Hapus SEP
                            </a>
                        <?php }else{ ?>
                            <?php if(empty($id_approval)){ ?>
                                <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalPengajuanApproval" data-id="<?php echo "$no_bpjs";?>">
                                    <i class="icofont-wall-clock"></i> Pengajuan Approval
                                </a>
                            <?php }else{ ?>
                                <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalDataApproval" data-id="<?php echo "$no_bpjs";?>">
                                    <i class="icofont-wall-clock"></i> Data Approval
                                </a>
                            <?php } ?>
                        <?php } ?>
                        <div class="dropdown-divider"></div>
                        <?php if(!empty($sep)){ ?>
                            <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalUpdateTanggalPulang" data-id="<?php echo "$sep";?>">
                                <i class="icofont-check-circled"></i> Update Pulang
                            </a>
                            <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalCariSPRI" data-id="<?php echo "$sep";?>">
                                <i class="icofont-search-document"></i> Cari SPRI/SKDP
                            </a>
                            <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalInsertRencanaKontrol" data-id="<?php echo "$sep";?>">
                                <i class="icofont-ui-calendar"></i> Rencana Kontrol
                            </a>
                            <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalInsertSpri" data-id="<?php echo "$no_bpjs";?>">
                                <i class="icofont-patient-bed"></i> SPRI
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalDataSepInternal" data-id="<?php echo "$sep";?>">
                                <i class="icofont-paper"></i> SEP Internal
                            </a>
                            <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalHapusSepInternal" data-id="<?php echo "$sep";?>">
                                <i class="ti ti-trash"></i> Hapus SEP Internal
                            </a>
                        <?php } ?>
                    </div>
                </div> -->
                    <a href="index.php?Page=RawatJalan&Sub=DetailKunjungan&id=<?php echo $id_kunjungan; ?>" class="btn btn-sm btn-success mr-2">
                        Selengkapnya <i class="ti ti-more-alt"></i> 
                    </a>
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>