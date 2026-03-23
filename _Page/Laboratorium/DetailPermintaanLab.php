<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <?php
                        if(empty($_GET['id'])){
                            echo '<div class="col-12">';
                            echo '  <div class="card-body">';
                            echo '      <div class="row mb-4">';
                            echo '          <div class="col-12 text-danger text-center">';
                            echo '              ID Permintaan Tidak Boleh Kosong';
                            echo '          </div>';
                            echo '      </div>';
                            echo '  </div>';
                            echo '</div>';
                        }else{
                            // include "_Config/SimrsFunction.php";
                            $id_permintaan=$_GET['id'];
                            $id_pasien=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'id_pasien');
                            $id_kunjungan=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'id_kunjungan');
                            $id_dokter=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'id_dokter');
                            $tujuan=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'tujuan');
                            $nama_pasien=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'nama_pasien');
                            $nama_dokter=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'nama_dokter');
                            $tanggal=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'tanggal');
                            $faskes=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'faskes');
                            $unit=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'unit');
                            $prioritas=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'prioritas');
                            $diagnosis=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'diagnosis');
                            $keterangan_permintaan=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'keterangan_permintaan');
                            $nama_signature=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'nama_signature');
                            $signature=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'signature');
                            $status=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'status');
                            $keterangan_status=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'keterangan_status');
                            //Pecahkan tanggal
                            $strtotime=strtotime($tanggal);
                            $Tanggal=date('d/m/Y H:i T',$strtotime);
                    ?>
                        <div class="col-xl-6 col-12">
                            <div class="card table-card">
                                <div class="card-header border-info">
                                    <div class="row">
                                        <div class="col-12 mb-3 card-title text-center">
                                            <h4 class="text-dark">
                                                <i class="icofont-prescription"></i> Pendaftaran / Permintaan Laboratorium
                                            </h4>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <a href="index.php?Page=Laboratorium&Sub=PermintaanLab" class="btn btn-sm btn-block btn-secondary" title="kembali Ke Data Permintaan Lab">
                                                <i class="ti ti-angle-left text-white"></i> Kembali
                                            </a>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <a href="index.php?Page=Laboratorium&Sub=EditPermintaanLab&id=<?php echo "$id_permintaan"; ?>" class="btn btn-sm btn-block btn-inverse" title="Edit Data Permintaan Lab">
                                                <i class="ti ti-pencil-alt text-white"></i> Edit
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3 is-hover">
                                        <div class="col-6"><dt>Tanggal/Waktu</dt></div>
                                        <div class="col-6"><?php echo "$Tanggal"; ?></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6"><dt>No.RM</dt></div>
                                        <div class="col-6"><?php echo "$id_pasien"; ?></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6"><dt>No.REG</dt></div>
                                        <div class="col-6"><?php echo "$id_kunjungan"; ?></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6"><dt>Nama Pasien</dt></div>
                                        <div class="col-6"><?php echo "$nama_pasien"; ?></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6"><dt>Tujuan Kunjungan</dt></div>
                                        <div class="col-6"><?php echo "$tujuan"; ?></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6"><dt>Faskes</dt></div>
                                        <div class="col-6"><?php echo "$faskes"; ?></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6"><dt>Unit</dt></div>
                                        <div class="col-6"><?php echo "$unit"; ?></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6"><dt>Prioritas</dt></div>
                                        <div class="col-6"><?php echo "$prioritas"; ?></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6"><dt>Dokter</dt></div>
                                        <div class="col-6"><?php echo "$nama_dokter"; ?></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6"><dt>Diagnosis</dt></div>
                                        <div class="col-6"><?php echo "$diagnosis"; ?></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6"><dt>Ket.Permintaan</dt></div>
                                        <div class="col-6"><?php echo "$keterangan_permintaan"; ?></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6"><dt>Status</dt></div>
                                        <div class="col-6"><?php echo "$status"; ?></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6"><dt>Ket.Permintaan</dt></div>
                                        <div class="col-6"><?php echo "$keterangan_permintaan"; ?></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12 text-center">
                                            <dt>Pemohon</dt>
                                            <img src="<?php echo 'data:image/png;base64,' . $signature . ''; ?>" width="100%"><br>
                                            <?php echo "($nama_signature)"; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-12">
                            <div class="card table-card">
                                <div class="card-header border-info">
                                    <div class="row">
                                        <div class="col-12 mb-3 card-title text-center">
                                            <h4 class="text-dark">
                                                <i class="icofont-prescription"></i> Pemeriksaan Laboratorium
                                            </h4>
                                        </div>
                                        <div class="col-12 mb-3 text-center">
                                            <?php if($status=="Pending"){ ?>
                                                <button type="button" class="btn btn-sm btn-block btn-danger" data-toggle="modal" data-target="#ModalKonfirmasiPermintaan" data-id="<?php echo $id_permintaan; ?>" title="Konfirmasi Permintaan Pemeriksaan">
                                                    <i class="ti ti-check-box text-white"></i> Konfirmasi Permintaan
                                                </button>
                                            <?php }else{ ?>
                                                <?php if($status=="Ditolak"){ ?>
                                                    <small class="text-danger">Setelah permintaan ditolak, petugas tidak dapat menambahkan informasi pemeriksaan</small>
                                                <?php }else{ ?>
                                                    <button type="button" class="btn btn-sm btn-block btn-success"  data-toggle="modal" data-target="#ModalUpdatePemeriksaan" data-id="<?php echo $id_permintaan; ?>" title="Ubah Informasi Pemeriksaan">
                                                        <i class="ti ti-pencil-alt text-white"></i> Update Pemeriksaan
                                                    </button>
                                                <?php } ?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <?php
                                        //Buka Data hasil Pemeriksaan
                                        $id_lab=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'id_lab');
                                        if(!empty($id_lab)){
                                            $waktu_pendaftaran=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'waktu_pendaftaran');
                                            $pengambilan_sample=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'pengambilan_sample');
                                            $pemeriksaan_sample=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'pemeriksaan_sample');
                                            $keluar_hasil=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'keluar_hasil');
                                            $hasil_diserahkan=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'hasil_diserahkan');
                                            $metode_penyerahan=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'metode_penyerahan');
                                            $interpertasi_hasil=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'interpertasi_hasil');
                                            $dokter_interpertasi=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'dokter_interpertasi');
                                            $dokter_validator=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'dokter_validator');
                                            $petugas_analis=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'petugas_analis');
                                            $sig_dokter_intr=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'sig_dokter_intr');
                                            $sig_dokter_validator=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'sig_dokter_validator');
                                            $sig_petugas_analis=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'sig_petugas_analis');
                                    ?>
                                        <div class="row mb-3">
                                            <div class="col-6"><dt>ID Lab</dt></div>
                                            <div class="col-6"><?php echo "$id_lab"; ?></div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-6"><dt>Tanggal/Waktu</dt></div>
                                            <div class="col-6"><?php echo "$waktu_pendaftaran"; ?></div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-6"><dt>Pengambilan Spesimen</dt></div>
                                            <div class="col-6"><?php echo "$pengambilan_sample"; ?></div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-6"><dt>Pemeriksaan</dt></div>
                                            <div class="col-6"><?php echo "$pemeriksaan_sample"; ?></div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-6"><dt>Keluar Hasil</dt></div>
                                            <div class="col-6"><?php echo "$keluar_hasil"; ?></div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-6"><dt>Penyerahan Hasil</dt></div>
                                            <div class="col-6"><?php echo "$hasil_diserahkan"; ?></div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-6"><dt>Metode Penyerahan</dt></div>
                                            <div class="col-6">
                                                <?php 
                                                    if($metode_penyerahan==1){
                                                        echo "Penyerahan Langsung"; 
                                                    }else{
                                                        if($metode_penyerahan==2){
                                                            echo "Melalui Surel"; 
                                                        }else{
                                                            echo "Tidak Ada"; 
                                                        }
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-6"><dt>Interpertasi Dokter</dt></div>
                                            <div class="col-6"><?php echo "$interpertasi_hasil"; ?></div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4 text-center">
                                                <dt>Dokter Analisis</dt>
                                                <?php 
                                                    if(!empty($dokter_interpertasi)){
                                                        if(empty($sig_dokter_intr)){
                                                            echo '<small>';
                                                            echo '  <small class="text-danger">';
                                                            echo '      <a href="index.php?Page=Laboratorium&Sub=FormSigLaboratorium&id='.$id_permintaan.'&SignatureName=sig_dokter_intr" class="text-primary">';
                                                            echo '          <small><i class="ti ti-pencil"></i> Tanda Tangan Dokter Analis</small>';
                                                            echo '      </a>';
                                                            echo '  </small>';
                                                            echo '</small><br>';
                                                        }else{
                                                            echo '<img src="data:image/png;base64,' . $sig_dokter_intr . '" width="100%"><br>';
                                                        }
                                                        echo "($dokter_interpertasi)";
                                                    }
                                                ?>
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <dt>Dokter Validator</dt>
                                                <?php 
                                                    if(!empty($dokter_validator)){
                                                        if(empty($sig_dokter_validator)){
                                                            echo '<small>';
                                                            echo '  <small class="text-danger">';
                                                            echo '      <a href="index.php?Page=Laboratorium&Sub=FormSigLaboratorium&id='.$id_permintaan.'&SignatureName=sig_dokter_validator" class="text-primary">';
                                                            echo '          <small><i class="ti ti-pencil"></i> Tanda Tangan Dokter Validator</small>';
                                                            echo '      </a>';
                                                            echo '  </small>';
                                                            echo '</small><br>';
                                                        }else{
                                                            echo '<img src="data:image/png;base64,' . $sig_dokter_validator . '" width="100%"><br>';
                                                        }
                                                        echo "($dokter_validator)";
                                                    }
                                                ?>
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <dt>Petugas Analis</dt>
                                                <?php 
                                                    if(!empty($petugas_analis)){
                                                        if(empty($sig_petugas_analis)){
                                                            echo '<small>';
                                                            echo '  <small class="text-danger">';
                                                            echo '      <a href="index.php?Page=Laboratorium&Sub=FormSigLaboratorium&id='.$id_permintaan.'&SignatureName=sig_petugas_analis" class="text-primary">';
                                                            echo '          <small><i class="ti ti-pencil"></i> Tanda Tangan Petugas Analis Lab</small>';
                                                            echo '      </a>';
                                                            echo '  </small>';
                                                            echo '</small><br>';
                                                        }else{
                                                            echo '<img src="data:image/png;base64,' . $sig_petugas_analis . '" width="100%"><br>';
                                                        }
                                                        echo "($petugas_analis)";
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 mb-2 text-center">
                                                <button type="button" class="btn btn-sm btn-block btn-primary"  data-toggle="modal" data-target="#ModalTambahSpesiemen" data-id="<?php echo $id_lab; ?>" title="Tambah Informasi Spesimen">
                                                    <i class="ti ti-plus"></i> Spesimen
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <?php
                                                    //Menampilkan Data Spesimen
                                                    $QrySpesimen = mysqli_query($Conn, "SELECT*FROM laboratorium_sample WHERE id_lab='$id_lab' ORDER BY id_laboratorium_sample DESC");
                                                    while ($DataSpesimen = mysqli_fetch_array($QrySpesimen)) {
                                                        $id_laboratorium_sample= $DataSpesimen['id_laboratorium_sample'];
                                                        if(empty($DataSpesimen['waktu_pengambilan'])){
                                                            $TglSpesiemn='<span class="text-danger">Tidak Ada Informasi</span>';
                                                        }else{
                                                            $waktu_pengambilan=$DataSpesimen['waktu_pengambilan'];
                                                            $strtotime_sample=strtotime($waktu_pengambilan);
                                                            $TglSpesiemn=date('d/m/Y H:i',$strtotime_sample);
                                                        }
                                                        if(empty($DataSpesimen['sumber'])){
                                                            $sumber='<span class="text-danger">Tidak Ada Informasi Sumber Spesimen</span>';
                                                        }else{
                                                            $sumber=$DataSpesimen['sumber'];
                                                        }
                                                        $SattusSpesimen= $DataSpesimen['status'];
                                                        if($SattusSpesimen=="Terdaftar"){
                                                            $LabelStatusSpesimen='<span class="badge badge-danger"><i class="icofont-patient-file"></i> Terdaftar</span>';
                                                        }else{
                                                            if($SattusSpesimen=="Proses"){
                                                                $LabelStatusSpesimen='<span class="badge badge-info"><i class="icofont-sand-clock"></i> Proses</span>';
                                                            }else{
                                                                if($SattusSpesimen=="Selesai"){
                                                                    $LabelStatusSpesimen='<span class="badge badge-primary"><i class="icofont-checked"></i> Selesai</span>';
                                                                }else{
                                                                    $LabelStatusSpesimen='<span class="badge badge-dark"><i class="icofont-close-line"></i> None</span>';
                                                                }
                                                            }
                                                        }
                                                        //Menhitung hasil pemeriksaan
                                                        $JumlahHasilPemeriksaanSample=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM laboratorium_rincian WHERE id_laboratorium_sample='$id_laboratorium_sample'"));
                                                        if(!empty($JumlahHasilPemeriksaanSample)){
                                                            $LabelHasilPemeriksaan='<span class="badge badge-success ml-2">'.$JumlahHasilPemeriksaanSample.'</span>';
                                                        }else{
                                                            $LabelHasilPemeriksaan='';
                                                        }
                                                ?>
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <div class="row">
                                                                <div class="col-12 text-center mb-2">
                                                                    <dt class="text-dark">
                                                                        <i class="icofont-laboratory"></i> 
                                                                        <?php 
                                                                            echo "
                                                                            <i title='No.RM'>$id_pasien</i>/<i title='ID Pendaftaran/Permintaan'>$id_permintaan</i>/<i title='ID Lab'>$id_lab</i>/<i title='ID Sample'>$id_laboratorium_sample</i>"; 
                                                                        ?>
                                                                    </dt>
                                                                    <small><?php echo "$TglSpesiemn";?></small><br>
                                                                    <small><?php echo "$sumber";?></small><br>
                                                                    <?php echo "$LabelStatusSpesimen $LabelHasilPemeriksaan";?>
                                                                </div>
                                                                <div class="col-12 mb-2 text-center">
                                                                    <button type="button" class="btn btn-sm btn-outline-dark mb-2"  data-toggle="modal" data-target="#ModalDetailSpesimen" data-id="<?php echo $id_laboratorium_sample; ?>" title="Detail Informasi Spesimen">
                                                                        <i class="ti ti-info-alt"></i>
                                                                    </button>
                                                                    <button type="button" class="btn btn-sm btn-outline-dark mb-2"  data-toggle="modal" data-target="#ModaCetakLabelSpesimen" data-id="<?php echo $id_laboratorium_sample; ?>" title="Cetak Label Spesimen">
                                                                        <i class="ti ti-printer"></i>
                                                                    </button>
                                                                    <button type="button" class="btn btn-sm btn-outline-dark mb-2"  data-toggle="modal" data-target="#ModalEditSpesimen" data-id="<?php echo $id_laboratorium_sample; ?>" title="Edit Informasi Spesimen">
                                                                        <i class="ti ti-pencil-alt"></i>
                                                                    </button>
                                                                    <a href="index.php?Page=Laboratorium&Sub=TambahHasilPemeriksaan&id_permintaan=<?php echo "$id_permintaan"; ?>&id_lab=<?php echo "$id_lab"; ?>&id_laboratorium_sample=<?php echo "$id_laboratorium_sample"; ?>" class="btn btn-sm btn-outline-dark mb-2" title="Kelola Hasil Pemeriksaan">
                                                                        <i class="ti ti-clipboard"></i>
                                                                    </a>
                                                                    <button type="button" class="btn btn-sm btn-outline-dark mb-2"  data-toggle="modal" data-target="#ModalHapusSpesimen" data-id="<?php echo $id_laboratorium_sample; ?>" title="Hapus Informasi Spesimen">
                                                                        <i class="ti ti-close"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 mb-2 text-center">
                                                <button type="button" class="btn btn-sm btn-block btn-inverse"  data-toggle="modal" data-target="#ModalCetakHasilPemeriksaan" data-id="<?php echo $id_lab; ?>" title="Cetak Hasil Pemeriksaan">
                                                    <i class="ti ti-printer"></i> Cetak
                                                </button>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
