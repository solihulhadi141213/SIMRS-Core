<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Tangkap id_kunjungan
    if(empty($_POST['id_kunjungan'])){
        echo '<div class="card-body border-0 pb-0">';
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          Data ID Kunjungan Tidak Dapat didefinisikan.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_kunjungan=$_POST['id_kunjungan'];
        //Buka data Pasien
        $Qry = mysqli_query($Conn,"SELECT * FROM kunjungan_utama WHERE id_kunjungan='$id_kunjungan'")or die(mysqli_error($Conn));
        $Data = mysqli_fetch_array($Qry);
        $id_pasien= $Data['id_pasien'];
        $no_antrian= $Data['no_antrian'];
        $nik= $Data['nik'];
        $no_bpjs= $Data['no_bpjs'];
        $sep= $Data['sep'];
        $noRujukan= $Data['noRujukan'];
        $skdp= $Data['skdp'];
        $nama= $Data['nama'];
        $tanggal= $Data['tanggal'];
        $propinsi= $Data['propinsi'];
        $kabupaten= $Data['kabupaten'];
        $kecamatan= $Data['kecamatan'];
        $desa= $Data['desa'];
        $alamat= $Data['alamat'];
        $keluhan= $Data['keluhan'];
        $tujuan= $Data['tujuan'];
        $id_dokter= $Data['id_dokter'];
        $dokter= $Data['dokter'];
        $id_poliklinik= $Data['id_poliklinik'];
        $poliklinik= $Data['poliklinik'];
        $kelas= $Data['kelas'];
        $ruangan= $Data['ruangan'];
        $id_kasur= $Data['id_kasur'];
        $DiagAwal= $Data['DiagAwal'];
        $rujukan_dari= $Data['rujukan_dari'];
        $rujukan_ke= $Data['rujukan_ke'];
        $pembayaran= $Data['pembayaran'];
        $cara_keluar= $Data['cara_keluar'];
        $tanggal_keluar= $Data['tanggal_keluar'];
        $status= $Data['status'];
        $id_akses= $Data['id_akses'];
        $nama_petugas= $Data['nama_petugas'];
        $updatetime= $Data['updatetime'];
        //Membuka daya approval
        $QryApproval = mysqli_query($Conn,"SELECT * FROM approval WHERE noKartu='$no_bpjs'")or die(mysqli_error($Conn));
        $DataApproval = mysqli_fetch_array($QryApproval);
        $id_approval= $DataApproval['id_approval'];
        //Menghitung data rencana kontrol
        $JumlahRencanaKontrol = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM rencana_kontrol WHERE kategori='Rencana Kontrol' AND noSEP='$sep'"));
        //Menghitung data SPRI
        $JumlahSPRI = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM rencana_kontrol WHERE kategori='SPRI' AND noSEP='$sep'"));
        //Membuka rencana_kontrol
        $QryRencanaKontrol = mysqli_query($Conn,"SELECT * FROM rencana_kontrol WHERE kategori='Rencana Kontrol' AND noSEP='$sep'")or die(mysqli_error($Conn));
        $DataRencanaKontrol = mysqli_fetch_array($QryRencanaKontrol);
        $id_rencana_kontrol= $DataRencanaKontrol['id_rencana_kontrol'];
        $noSuratKontrol= $DataRencanaKontrol['noSuratKontrol'];
        $tglRencanaKontrol= $DataRencanaKontrol['tglRencanaKontrol'];
        $namaDokter= $DataRencanaKontrol['namaDokter'];
?>
    <div class="modal-body border-0 pb-0 mb-4">
        <div class="row mt-2 pre-scrollable"> 
            <div class="col-md-12">
                <div class="table table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th colspan="3">
                                    <dt>A. Detail Informasi Kunjungan</dt>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(!empty($id_kunjungan)){
                                    echo '<tr>';
                                    echo '  <td><dt>No.REG</dt></td>';
                                    echo '  <td>'.$id_kunjungan.'</td>';
                                    echo '</tr>';
                                }
                                if(!empty($id_pasien)){
                                    echo '<tr>';
                                    echo '  <td><dt>No.Rm</dt></td>';
                                    echo '  <td>'.$id_pasien.'</td>';
                                    echo '</tr>';
                                }
                                if(!empty($no_antrian)){
                                    echo '<tr>';
                                    echo '  <td><dt>No.Antrian</dt></td>';
                                    echo '  <td>'.$no_antrian.'</td>';
                                    echo '</tr>';
                                }
                                if(!empty($nama)){
                                    echo '<tr>';
                                    echo '  <td><dt>Nama Pasien</dt></td>';
                                    echo '  <td>'.$nama.'</td>';
                                    echo '</tr>';
                                }
                                if(!empty($nik)){
                                    echo '<tr>';
                                    echo '  <td><dt>No.KTP (NIK)</dt></td>';
                                    echo '  <td>'.$nik.' <a href="jascript:void(0);" class="badge badge-inverse" data-toggle="modal" data-target="#ModalCekKepesertaanByNik" data-id="'.$nik.'">Detail</a> </td>';
                                    echo '</tr>';
                                }
                                if(!empty($no_bpjs)){
                                    echo '<tr>';
                                    echo '  <td><dt>No.BPJS</dt></td>';
                                    echo '  <td>'.$no_bpjs.' <a href="jascript:void(0);" class="badge badge-inverse" data-toggle="modal" data-target="#ModalCekKepesertaanByBpjs" data-id="'.$no_bpjs.'">Detail</a> </td>';
                                    echo '</tr>';
                                }
                                if(!empty($sep)){
                                    echo '<tr>';
                                    echo '  <td><dt>No.SEP</dt></td>';
                                    echo '  <td>'.$sep.' <a href="jascript:void(0);" class="badge badge-inverse" data-toggle="modal" data-target="#ModalDetailSep" data-id="'.$sep.'">Detail</a></td>';
                                    echo '</tr>';
                                }
                                if(!empty($noRujukan)){
                                    echo '<tr>';
                                    echo '  <td><dt>No.Rujukan</dt></td>';
                                    echo '  <td>'.$noRujukan.'</td>';
                                    echo '</tr>';
                                }
                                if(!empty($skdp)){
                                    echo '<tr>';
                                    echo '  <td><dt>No.SKDP/SPRI</dt></td>';
                                    echo '  <td>'.$skdp.'</td>';
                                    echo '</tr>';
                                }
                                if(!empty($tanggal)){
                                    echo '<tr>';
                                    echo '  <td><dt>Tanggal Daftar</dt></td>';
                                    echo '  <td>'.$tanggal.'</td>';
                                    echo '</tr>';
                                }
                                if(!empty($alamat)){
                                    echo '<tr>';
                                    echo '  <td><dt>Alamat</dt></td>';
                                    echo '  <td>'.$alamat.','.$desa.','.$kecamatan.','.$kabupaten.','.$propinsi.'</td>';
                                    echo '</tr>';
                                }
                                if(!empty($keluhan)){
                                    echo '<tr>';
                                    echo '  <td><dt>Keluhan</dt></td>';
                                    echo '  <td>'.$keluhan.'</td>';
                                    echo '</tr>';
                                }
                                if(!empty($tujuan)){
                                    echo '<tr>';
                                    echo '  <td><dt>Tujuan</dt></td>';
                                    echo '  <td>'.$tujuan.'</td>';
                                    echo '</tr>';
                                }
                                if(!empty($dokter)){
                                    echo '<tr>';
                                    echo '  <td><dt>Dokter</dt></td>';
                                    echo '  <td>'.$dokter.'</td>';
                                    echo '</tr>';
                                }
                                if(!empty($poliklinik)){
                                    echo '<tr>';
                                    echo '  <td><dt>Poliklinik</dt></td>';
                                    echo '  <td>'.$poliklinik.'</td>';
                                    echo '</tr>';
                                }
                                if(!empty($DiagAwal)){
                                    echo '<tr>';
                                    echo '  <td><dt>Diagnosa Awal</dt></td>';
                                    echo '  <td>'.$DiagAwal.'</td>';
                                    echo '</tr>';
                                }
                                if(!empty($rujukan_dari)){
                                    echo '<tr>';
                                    echo '  <td><dt>Rujukan Dari</dt></td>';
                                    echo '  <td>'.$rujukan_dari.'</td>';
                                    echo '</tr>';
                                }
                                if(!empty($rujukan_dari)){
                                    echo '<tr>';
                                    echo '  <td><dt>Rujukan Dari</dt></td>';
                                    echo '  <td>'.$rujukan_dari.'</td>';
                                    echo '</tr>';
                                }
                                if(!empty($rujukan_ke)){
                                    echo '<tr>';
                                    echo '  <td><dt>Rujukan Ke</dt></td>';
                                    echo '  <td>'.$rujukan_ke.'</td>';
                                    echo '</tr>';
                                }
                                if(!empty($pembayaran)){
                                    echo '<tr>';
                                    echo '  <td><dt>Pembayaran</dt></td>';
                                    echo '  <td>'.$pembayaran.'</td>';
                                    echo '</tr>';
                                }
                                if(!empty($cara_keluar)){
                                    echo '<tr>';
                                    echo '  <td><dt>Cara Keluar</dt></td>';
                                    echo '  <td>'.$cara_keluar.'</td>';
                                    echo '</tr>';
                                }
                                if(!empty($tanggal_keluar)){
                                    echo '<tr>';
                                    echo '  <td><dt>Tanggal Keluar</dt></td>';
                                    echo '  <td>'.$tanggal_keluar.'</td>';
                                    echo '</tr>';
                                }
                                if(!empty($nama_petugas)){
                                    echo '<tr>';
                                    echo '  <td><dt>Petugas</dt></td>';
                                    echo '  <td>'.$nama_petugas.'</td>';
                                    echo '</tr>';
                                }
                                if(!empty($status)){
                                    echo '<tr>';
                                    echo '  <td><dt>Status</dt></td>';
                                    echo '  <td>'.$status.'</td>';
                                    echo '</tr>';
                                }
                                if(!empty($updatetime)){
                                    echo '<tr>';
                                    echo '  <td><dt>Updatetime</dt></td>';
                                    echo '  <td>'.$updatetime.'</td>';
                                    echo '</tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12" id="">
                <div class="table table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th colspan="3">
                                    <a href="javascript:void(0);" class="text-primary">
                                        <dt>B. Rencana Kontrol (Database)</dt>
                                    </a>
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="col-md-12" id="">
                <div class="table table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th colspan="3">
                                    <a href="javascript:void(0);" class="text-primary">
                                        <dt>C. SPRI (Database)</dt>
                                    </a>
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-primary">
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="btn-group dropdown-split-inverse">
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
                </div>
                    <button type="button" class="btn btn-md btn-light mt-2 ml-2" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>