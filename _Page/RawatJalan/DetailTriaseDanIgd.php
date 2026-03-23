<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_kunjungan'])){
        echo '<div class="card">';
        echo '  <div class="card-body text-center text-danger">';
        echo '      ID Kunjungan Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_kunjungan=$_POST['id_kunjungan'];
        $id_triase_igd=getDataDetail($Conn,"triase_igd",'id_kunjungan',$id_kunjungan,'id_kunjungan');
        if(empty($id_triase_igd)){
            echo '<div class="card">';
            echo '  <div class="card-header">';
            echo '      <button type="button" class="btn btn-sm btn-outline-dark btn-block" data-toggle="modal" data-target="#ModalTambahTriaseDanIgd" data-id="'.$id_kunjungan.'">';
            echo '          <i class="ti ti-plus"></i> Tambah Data Triase & IGD';
            echo '      </button>';
            echo '  </div>';
            echo '  <div class="card-body text-center text-danger">';
            echo '      Belum ada informasi trease dan gawat darurat untuk kunjungan ini.';
            echo '  </div>';
            echo '</div>';
        }else{
            //Membuka Detail Triase Dan IGD
            $id_pasien=getDataDetail($Conn,"triase_igd",'id_kunjungan',$id_kunjungan,'id_pasien');
            $id_akses=getDataDetail($Conn,"triase_igd",'id_kunjungan',$id_kunjungan,'id_akses');
            $tanggal=getDataDetail($Conn,"triase_igd",'id_kunjungan',$id_kunjungan,'tanggal');
            $nama_pasien=getDataDetail($Conn,"triase_igd",'id_kunjungan',$id_kunjungan,'nama_pasien');
            $nama_petugas=getDataDetail($Conn,"triase_igd",'id_kunjungan',$id_kunjungan,'nama_petugas');
            $tanggal_jam_masuk=getDataDetail($Conn,"triase_igd",'id_kunjungan',$id_kunjungan,'tanggal_jam_masuk');
            $triase_igd=getDataDetail($Conn,"triase_igd",'id_kunjungan',$id_kunjungan,'triase_igd');
            //Decode JSON
            $JsonTriaseIgd =json_decode($triase_igd, true);
            //Format Tanggal
            $strtotime=strtotime($tanggal);
            $FormatTanggal=date('d/m/Y H:i', $strtotime);
            //Format Tanggal Masuk
            $strtotime2=strtotime($tanggal_jam_masuk);
            $FormatTanggalMasuk=date('d/m/Y H:i:s T', $strtotime2);
            //Buka Petugas
            $sarana_transportasi=$JsonTriaseIgd['sarana_transportasi'];
            $surat_pengantar_rujukan=$JsonTriaseIgd['surat_pengantar_rujukan'];
            $kondisi_pasien_tiba=$JsonTriaseIgd['kondisi_pasien_tiba'];
            $pengantar_pasien=$JsonTriaseIgd['pengantar_pasien'];
            $asesmen_nyeri=$JsonTriaseIgd['asesmen_nyeri'];
            $kajian_resiko_jatuh=$JsonTriaseIgd['kajian_resiko_jatuh'];
            $kesadaran_pasien=$JsonTriaseIgd['kesadaran_pasien'];
            if(empty($kesadaran_pasien)){
                $kesadaran_pasien='<span class="text-danger">Tidak Ada</span>';
            }
            //Assesmen Nyeri
            if(!empty($asesmen_nyeri)){
                if($asesmen_nyeri['skala_nips']['skala_nips1']==1){
                    $LabelNips1="Grimace";
                }else{
                    if($asesmen_nyeri['skala_nips']['skala_nips1']==0){
                        $LabelNips1="Relaxed";
                    }else{
                        $LabelNips1="None";
                    }
                }
                if($asesmen_nyeri['skala_nips']['skala_nips2']==0){
                    $LabelNips2="No Cry";
                }else{
                    if($asesmen_nyeri['skala_nips']['skala_nips2']==1){
                        $LabelNips2="Whimper";
                    }else{
                        $LabelNips2="Vigorous crying or silent cry";
                    }
                }
                if($asesmen_nyeri['skala_nips']['skala_nips3']==0){
                    $LabelNips3="Relaxed";
                }else{
                    if($asesmen_nyeri['skala_nips']['skala_nips3']==1){
                        $LabelNips3="Change in breathing";
                    }else{
                        $LabelNips3="None";
                    }
                }
                if($asesmen_nyeri['skala_nips']['skala_nips4']==0){
                    $LabelNips4="Relaxed";
                }else{
                    if($asesmen_nyeri['skala_nips']['skala_nips4']==1){
                        $LabelNips4="Flexed/extended";
                    }else{
                        $LabelNips4="None";
                    }
                }
                if($asesmen_nyeri['skala_nips']['skala_nips5']==0){
                    $LabelNips5="Relaxed";
                }else{
                    if($asesmen_nyeri['skala_nips']['skala_nips5']==1){
                        $LabelNips5="Flexed/extended";
                    }else{
                        $LabelNips5="None";
                    }
                }
                if($asesmen_nyeri['skala_nips']['skala_nips6']==0){
                    $LabelNips6="quiet, peaceful, settled";
                }else{
                    if($asesmen_nyeri['skala_nips']['skala_nips6']==1){
                        $LabelNips6="alert, restless, and thrashing";
                    }else{
                        $LabelNips6="None";
                    }
                }
            }
            //RESIKO JATUH
            if(!empty($kajian_resiko_jatuh)){
                //Label MFS
                if($kajian_resiko_jatuh['mfs']['mfs1']==0){
                    $LabelMfs1="Tidak";
                }else{
                    $LabelMfs1="Ya";
                }
                if($kajian_resiko_jatuh['mfs']['mfs2']==0){
                    $LabelMfs2="Tidak";
                }else{
                    $LabelMfs2="Ya";
                }
                if($kajian_resiko_jatuh['mfs']['mfs3']==0){
                    $LabelMfs3="Tidak Ada";
                }else{
                    if($kajian_resiko_jatuh['mfs']['mfs3']==15){
                        $LabelMfs3="Tongkat/Alat Bantu";
                    }else{
                        $LabelMfs3="Furniture";
                    }
                }
                if($kajian_resiko_jatuh['mfs']['mfs4']==0){
                    $LabelMfs4="Tidak";
                }else{
                    $LabelMfs4="Ya";
                }
                if($kajian_resiko_jatuh['mfs']['mfs5']==0){
                    $LabelMfs5="Normal";
                }else{
                    if($kajian_resiko_jatuh['mfs']['mfs5']==10){
                        $LabelMfs5="Lemah";
                    }else{
                        $LabelMfs5="Terganggu";
                    }
                }
                if($kajian_resiko_jatuh['mfs']['mfs6']==0){
                    $LabelMfs6="Mengetahui Kemampuan Diri";
                }else{
                    $LabelMfs6="Lupa Keterbatasan";
                }
                //HDS
                if($kajian_resiko_jatuh['hds']['hds1']==4){
                    $LabelHds1="< 3 tahun";
                }else{
                    if($kajian_resiko_jatuh['hds']['hds1']==3){
                        $LabelHds1="3-7 tahun";
                    }else{
                        if($kajian_resiko_jatuh['hds']['hds1']==2){
                            $LabelHds1="7-13 tahun";
                        }else{
                            if($kajian_resiko_jatuh['hds']['hds1']==1){
                                $LabelHds1="13-18 tahun";
                            }else{
                                $LabelHds1="None";
                            }
                        }
                    }
                }
                if($kajian_resiko_jatuh['hds']['hds2']==2){
                    $LabelHds2="Laki-laki";
                }else{
                    if($kajian_resiko_jatuh['hds']['hds2']==1){
                        $LabelHds2="Perempuan";
                    }else{
                        $LabelHds2="None";
                    }
                }
                if($kajian_resiko_jatuh['hds']['hds3']==4){
                    $LabelHds3="Kelainan neurologi";
                }else{
                    if($kajian_resiko_jatuh['hds']['hds3']==3){
                        $LabelHds3="Gangguan oksigenasi";
                    }else{
                        if($kajian_resiko_jatuh['hds']['hds3']==2){
                            $LabelHds3="Kelemahan fisik/kelainan psikis";
                        }else{
                            if($kajian_resiko_jatuh['hds']['hds3']==1){
                                $LabelHds3="Ada diagnosis tambahan";
                            }else{
                                $LabelHds3="None";
                            }
                        }
                    }
                }
                if($kajian_resiko_jatuh['hds']['hds4']==3){
                    $LabelHds4="Tidak memahami keterbatasan";
                }else{
                    if($kajian_resiko_jatuh['hds']['hds4']==2){
                        $LabelHds4="Lupa keterbatasan";
                    }else{
                        if($kajian_resiko_jatuh['hds']['hds4']==1){
                            $LabelHds4="Orientasi terhadap kelemahan";
                        }else{
                            $LabelHds4="None";
                        }
                    }
                }
                if($kajian_resiko_jatuh['hds']['hds5']==4){
                    $LabelHds5="Riwayat jatuh dari tempat tidur";
                }else{
                    if($kajian_resiko_jatuh['hds']['hds5']==3){
                        $LabelHds5="Pasien menggunakan alat bantu";
                    }else{
                        if($kajian_resiko_jatuh['hds']['hds5']==2){
                            $LabelHds5="Pasien berada di tempat tidur";
                        }else{
                            if($kajian_resiko_jatuh['hds']['hds5']==1){
                                $LabelHds5="Pasien berada di luar area ruang perawatan";
                            }else{
                                $LabelHds5="None";
                            }
                        }
                    }
                }
                if($kajian_resiko_jatuh['hds']['hds6']==3){
                    $LabelHds6="Kurang dari 24 jam";
                }else{
                    if($kajian_resiko_jatuh['hds']['hds6']==2){
                        $LabelHds6="Kurang dari 48 jam";
                    }else{
                        if($kajian_resiko_jatuh['hds']['hds6']==1){
                            $LabelHds6="Lebih dari 48 jam";
                        }else{
                            $LabelHds6="None";
                        }
                    }
                }
                if($kajian_resiko_jatuh['hds']['hds7']==3){
                    $LabelHds7="Penggunaan obat sedative";
                }else{
                    if($kajian_resiko_jatuh['hds']['hds7']==2){
                        $LabelHds7="Hiponotik, barbitural, fenotazin, antidepresan, laksatif/diuretik, narotik/metadon";
                    }else{
                        if($kajian_resiko_jatuh['hds']['hds7']==1){
                            $LabelHds7="Pengobatan lain";
                        }else{
                            $LabelHds7="None";
                        }
                    }
                }
                //EPFRA
                if($kajian_resiko_jatuh['epfra']['epfra1']==8){
                    $LabelEpfra1="< 50 tahun";
                }else{
                    if($kajian_resiko_jatuh['epfra']['epfra1']==10){
                        $LabelEpfra1="3-7 tahun";
                    }else{
                        if($kajian_resiko_jatuh['epfra']['epfra1']==26){
                            $LabelEpfra1="7-13 tahun";
                        }else{
                            $LabelEpfra1="None";
                        }
                    }
                }
                if($kajian_resiko_jatuh['epfra']['epfra2']==-4){
                    $LabelEpfra2="Sadar Penuh Dan Orientasi Waktu Baik";
                }else{
                    if($kajian_resiko_jatuh['epfra']['epfra2']==13){
                        $LabelEpfra2="Agitasi/Cemas";
                    }else{
                        if($kajian_resiko_jatuh['epfra']['epfra2']==12){
                            $LabelEpfra2="Sering Bingung";
                        }else{
                            if($kajian_resiko_jatuh['epfra']['epfra2']==14){
                                $LabelEpfra2="Bingung dan Disorientasi";
                            }else{
                                $LabelEpfra2="None";
                            }
                        }
                    }
                }
                if($kajian_resiko_jatuh['epfra']['epfra3']==8){
                    $LabelEpfra3="Mandiri untuk BAB dan BAK";
                }else{
                    if($kajian_resiko_jatuh['epfra']['epfra3']==12){
                        $LabelEpfra3="Memakai kateter/ostomy, Gangguan Eliminasi, Inkontinesia tetapi bisa ambulasi mandiri";
                    }else{
                        if($kajian_resiko_jatuh['epfra']['epfra3']==10){
                            $LabelEpfra3="BAB dan BAK dengan Bantuan";
                        }else{
                            $LabelEpfra3="None";
                        }
                    }
                }
                if($kajian_resiko_jatuh['epfra']['epfra4']==10){
                    $LabelEpfra4="Tidak ada pengobatan yang diberikan, Obat-obatan jantung";
                }else{
                    if($kajian_resiko_jatuh['epfra']['epfra4']==8){
                        $LabelEpfra4="Obat psikiatri";
                    }else{
                        if($kajian_resiko_jatuh['epfra']['epfra4']==12){
                            $LabelEpfra4="Meningkatnya dosis obat yang dikonsumsi";
                        }else{
                            $LabelEpfra4="None";
                        }
                    }
                }
                if($kajian_resiko_jatuh['epfra']['epfra5']==8){
                    $LabelEpfra5="Penyalah gunaan zat terlarang dan alkohol";
                }else{
                    if($kajian_resiko_jatuh['epfra']['epfra5']==10){
                        $LabelEpfra5="Bipolar / Gangguan Scizo Affective, Gangguan depresi mayor";
                    }else{
                        if($kajian_resiko_jatuh['epfra']['epfra5']==12){
                            $LabelEpfra5="Dimensia/Delirium";
                        }else{
                            $LabelEpfra5="None";
                        }
                    }
                }
                if($kajian_resiko_jatuh['epfra']['epfra6']==7){
                    $LabelEpfra6="Ambulasi Mandiri";
                }else{
                    if($kajian_resiko_jatuh['epfra']['epfra6']==8){
                        $LabelEpfra6="Penggunaan Alat Bantu";
                    }else{
                        if($kajian_resiko_jatuh['epfra']['epfra6']==10){
                            $LabelEpfra6="Vertigo";
                        }else{
                            if($kajian_resiko_jatuh['epfra']['epfra6']==15){
                                $LabelEpfra6="Tidak Menyadari Kemampuan";
                            }else{
                                $LabelEpfra6="None";
                            }
                        }
                    }
                }
                if($kajian_resiko_jatuh['epfra']['epfra7']==0){
                    $LabelEpfra7="Nafsu Makan Baik";
                }else{
                    if($kajian_resiko_jatuh['epfra']['epfra7']==12){
                        $LabelEpfra7="Sedikit mendapatkan asupan makanan/minum";
                    }else{
                        $LabelEpfra7="None";
                    }
                }
                if($kajian_resiko_jatuh['epfra']['epfra8']==8){
                    $LabelEpfra8="Tidak Ada Gangguan Tidur";
                }else{
                    if($kajian_resiko_jatuh['epfra']['epfra8']==12){
                        $LabelEpfra8="Ada Gangguan Tidur";
                    }else{
                        $LabelEpfra8="None";
                    }
                }
                if($kajian_resiko_jatuh['epfra']['epfra9']==8){
                    $LabelEpfra9="Tidak Ada Riwayat Jatuh";
                }else{
                    if($kajian_resiko_jatuh['epfra']['epfra9']==14){
                        $LabelEpfra9="Ada Riwayat Jatuh Dalam 3 Bulan";
                    }else{
                        $LabelEpfra9="None";
                    }
                }
            }
            echo '<div class="card">';
            echo '  <div class="card-header">';
            echo '      <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalEditTriaseDanIgd" data-id="'.$id_kunjungan.'" title="Ubah Triase IGD">';
            echo '          <i class="ti ti-pencil-alt"></i>';
            echo '      </button>';
            echo '      <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalHapusTriaseIgd" data-id="'.$id_kunjungan.'" title="Hapus Data Triase IGD">';
            echo '          <i class="ti ti-trash"></i>';
            echo '      </button>';
            echo '      <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalCetakTriaseIgd" data-id="'.$id_kunjungan.'" title="Cetak Lembar Triase IGD">';
            echo '          <i class="ti ti-printer"></i>';
            echo '      </button>';
            echo '  </div>';
            echo '  <div class="card-body">';
            echo '      <div class="row mb-4">';
            echo '          <div class="col col-md-6">a. ID Triase & IGD</div>';
            echo '          <div class="col col-md-6">'.$id_triase_igd.'</div>';
            echo '      </div>';
            echo '      <div class="row mb-4">';
            echo '          <div class="col col-md-6">b. ID Kunjungan</div>';
            echo '          <div class="col col-md-6">'.$id_kunjungan.'</div>';
            echo '      </div>';
            echo '      <div class="row mb-4">';
            echo '          <div class="col col-md-6">c. No.RM</div>';
            echo '          <div class="col col-md-6">'.$id_pasien.'</div>';
            echo '      </div>';
            echo '      <div class="row mb-4">';
            echo '          <div class="col col-md-6">d. Nama Pasien</div>';
            echo '          <div class="col col-md-6">'.$nama_pasien.'</div>';
            echo '      </div>';
            echo '      <div class="row mb-4">';
            echo '          <div class="col col-md-6">e. Tanggal/Waktu Pencatatan</div>';
            echo '          <div class="col col-md-6">'.$FormatTanggal.'</div>';
            echo '      </div>';
            echo '      <div class="row mb-4">';
            echo '          <div class="col col-md-6">f. Tanggal/Waktu Masuk</div>';
            echo '          <div class="col col-md-6">'.$FormatTanggalMasuk.'</div>';
            echo '      </div>';
            echo '      <div class="row mb-4">';
            echo '          <div class="col col-md-6">g. Petugas Entry</div>';
            echo '          <div class="col col-md-6">'.$nama_petugas.'</div>';
            echo '      </div>';
            if(empty($sarana_transportasi)){
                echo '      <div class="row mb-4">';
                echo '          <div class="col col-md-6">h. Sarana Transportasi</div>';
                echo '          <div class="col col-md-6 text-danger">Tidak Diketahui</div>';
                echo '      </div>';
            }else{
                echo '      <div class="row mb-4">';
                echo '          <div class="col-md-12 mb-2">h. Sarana Transportasi</div>';
                echo '          <div class="col-md-12">';
                echo '              <div class="row mb-1">';
                echo '                  <div class="col col-md-1 text-muted"></div>';
                echo '                  <div class="col col-md-5 text-muted">h.1. Kategori</div>';
                echo '                  <div class="col col-md-6 text-muted">'.$sarana_transportasi['kategori'].'</div>';
                echo '              </div>';
                echo '              <div class="row mb-1">';
                echo '                  <div class="col col-md-1 text-muted"></div>';
                echo '                  <div class="col col-md-5 text-muted">h.2. Keterangan</div>';
                echo '                  <div class="col col-md-6 text-muted">'.$sarana_transportasi['keterangan'].'</div>';
                echo '              </div>';
                echo '          </div>';
                echo '      </div>';
            }
            if(empty($surat_pengantar_rujukan)){
                echo '      <div class="row mb-4">';
                echo '          <div class="col col-md-6">i. Surat Pengantar/Rujukan</div>';
                echo '          <div class="col col-md-6 text-danger">Tidak Diketahui</div>';
                echo '      </div>';
            }else{
                if($surat_pengantar_rujukan['surat_rujukan']=="Tidak"){
                    echo '      <div class="row mb-4">';
                    echo '          <div class="col col-md-6">i. Surat Pengantar/Rujukan</div>';
                    echo '          <div class="col col-md-6 text-danger">Tidak Ada</div>';
                    echo '      </div>';
                }else{
                    echo '      <div class="row mb-4">';
                    echo '          <div class="col-md-12 mb-2">i. Surat Pengantar/Rujukan</div>';
                    echo '          <div class="col-md-12">';
                    echo '              <div class="row mb-1">';
                    echo '                  <div class="col col-md-1 text-muted"></div>';
                    echo '                  <div class="col col-md-5 text-muted">i.1. Nomor Surat</div>';
                    echo '                  <div class="col col-md-6 text-muted">'.$surat_pengantar_rujukan['no_surat_rujukan'].'</div>';
                    echo '              </div>';
                    echo '              <div class="row mb-1">';
                    echo '                  <div class="col col-md-1 text-muted"></div>';
                    echo '                  <div class="col col-md-5 text-muted">i.2. Asal Rujukan</div>';
                    echo '                  <div class="col col-md-6 text-muted">'.$surat_pengantar_rujukan['asal_rujukan'].'</div>';
                    echo '              </div>';
                    echo '          </div>';
                    echo '      </div>';
                }
            }
            if(empty($kondisi_pasien_tiba)){
                echo '      <div class="row mb-4">';
                echo '          <div class="col col-md-6">j. Kondisi Pasien Tiba</div>';
                echo '          <div class="col col-md-6 text-danger">Tidak Diketahui</div>';
                echo '      </div>';
            }else{
                echo '      <div class="row mb-4">';
                echo '          <div class="col col-md-12 mb-2">j. Kondisi Pasien Tiba</div>';
                echo '          <div class="col col-md-12">';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-1 text-muted"></div>';
                echo '                  <div class="col col-md-5 text-muted">j.1. Kategori</div>';
                echo '                  <div class="col col-md-6 text-muted">'.$kondisi_pasien_tiba['kategori_kondisi_pasien'].'</div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-1 text-muted"></div>';
                echo '                  <div class="col col-md-5 text-muted">j.2. Penjelasan</div>';
                echo '                  <div class="col col-md-6 text-muted">'.$kondisi_pasien_tiba['penjelasan_kondisi_pasien'].'</div>';
                echo '              </div>';
                echo '          </div>';
                echo '      </div>';
            }
            if(empty($pengantar_pasien)){
                echo '      <div class="row mb-4">';
                echo '          <div class="col col-md-6">k. Pengantar Pasien</div>';
                echo '          <div class="col col-md-6 text-danger">Tidak Diketahui</div>';
                echo '      </div>';
            }else{
                echo '      <div class="row mb-4">';
                echo '          <div class="col col-md-12 mb-2">k. Pengantar Pasien</div>';
                echo '          <div class="col col-md-12">';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-1 text-muted"></div>';
                echo '                  <div class="col col-md-5 text-muted">k.1. Nama Pengantar</div>';
                echo '                  <div class="col col-md-6 text-muted">'.$pengantar_pasien['nama_pengantar_pasien'].'</div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-1 text-muted"></div>';
                echo '                  <div class="col col-md-5 text-muted">k.2. Kontak</div>';
                echo '                  <div class="col col-md-6 text-muted">'.$pengantar_pasien['kontak_pengantar_pasien'].'</div>';
                echo '              </div>';
                echo '          </div>';
                echo '      </div>';
            }
            if(empty($asesmen_nyeri)){
                echo '      <div class="row mb-4">';
                echo '          <div class="col col-md-6">l. Asesmen Nyeri</div>';
                echo '          <div class="col col-md-6 text-danger">Tidak Diketahui</div>';
                echo '      </div>';
            }else{
                if($asesmen_nyeri['asesmen_nyeri']!=="Ada"){
                    echo '      <div class="row mb-4">';
                    echo '          <div class="col col-md-6">l. Asesmen Nyeri</div>';
                    echo '          <div class="col col-md-6 text-danger">Tidak Ada</div>';
                    echo '      </div>';
                }else{
                    echo '      <div class="row mb-4">';
                    echo '          <div class="col col-md-12 mb-2">l. Asesmen Nyeri</div>';
                    echo '          <div class="col col-md-12">';
                    echo '              <div class="row mb-2">';
                    echo '                  <div class="col col-md-1 text-muted"></div>';
                    echo '                  <div class="col col-md-5 text-muted">l.1. Lokasi Nyeri</div>';
                    echo '                  <div class="col col-md-6 text-muted">'.$asesmen_nyeri['lokasi_nyeri'].'</div>';
                    echo '              </div>';
                    echo '              <div class="row mb-2">';
                    echo '                  <div class="col col-md-1 text-muted"></div>';
                    echo '                  <div class="col col-md-5 text-muted">l.2. Penyebab Nyeri</div>';
                    echo '                  <div class="col col-md-6 text-muted">'.$asesmen_nyeri['penyebab_nyeri'].'</div>';
                    echo '              </div>';
                    echo '              <div class="row mb-2">';
                    echo '                  <div class="col col-md-1 text-muted"></div>';
                    echo '                  <div class="col col-md-5 text-muted">l.3. Durasi Nyeri</div>';
                    echo '                  <div class="col col-md-6 text-muted">'.$asesmen_nyeri['durasi_nyeri'].'</div>';
                    echo '              </div>';
                    echo '              <div class="row mb-2">';
                    echo '                  <div class="col col-md-1 text-muted"></div>';
                    echo '                  <div class="col col-md-5 text-muted">l.4. Frekuensi Nyeri</div>';
                    echo '                  <div class="col col-md-6 text-muted">'.$asesmen_nyeri['frekuensi_nyeri'].'</div>';
                    echo '              </div>';
                    echo '              <div class="row mb-2">';
                    echo '                  <div class="col col-md-1 text-muted"></div>';
                    echo '                  <div class="col col-md-5 text-muted">l.5. Pemeriksa Nyeri</div>';
                    echo '                  <div class="col col-md-6 text-muted">'.$asesmen_nyeri['nakes_nyeri'].'</div>';
                    echo '              </div>';
                    echo '          </div>';
                    echo '      </div>';
                    echo '      <div class="row mb-2">';
                    echo '          <div class="col col-md-12">m. Skala Nyeri</div>';
                    echo '      </div>';
                    if(empty($asesmen_nyeri['skala_vas'])){
                        echo '<div class="row mb-2">';
                        echo '  <div class="col col-md-1 text-muted"></div>';
                        echo '  <div class="col col-md-5 text-muted">m.1 Skala VAS</div>';
                        echo '  <div class="col col-md-6 text-danger">Tidak Diketahui</div>';
                        echo '</div>';
                    }else{
                        echo '<div class="row mb-2">';
                        echo '  <div class="col col-md-1 text-muted"></div>';
                        echo '  <div class="col col-md-5 text-muted">m.2 Skala VAS</div>';
                        echo '  <div class="col col-md-6 text-muted">'.$asesmen_nyeri['skala_vas']['skor'].' ('.$asesmen_nyeri['skala_vas']['kategori'].')</div>';
                        echo '</div>';
                    }
                    if(empty($asesmen_nyeri['skala_nrs'])){
                        echo '<div class="row mb-2">';
                        echo '  <div class="col col-md-1 text-muted"></div>';
                        echo '  <div class="col col-md-5 text-muted">m.3 Skala NRS</div>';
                        echo '  <div class="col col-md-6 text-danger">Tidak Diketahui</div>';
                        echo '</div>';
                    }else{
                        echo '<div class="row mb-2">';
                        echo '  <div class="col col-md-1 text-muted"></div>';
                        echo '  <div class="col col-md-5 text-muted">m.4 Skala NRS</div>';
                        echo '  <div class="col col-md-6 text-muted">'.$asesmen_nyeri['skala_nrs']['skor'].' ('.$asesmen_nyeri['skala_nrs']['kategori'].')</div>';
                        echo '</div>';
                    }
                    if(empty($asesmen_nyeri['skala_vrs'])){
                        echo '<div class="row mb-2">';
                        echo '  <div class="col col-md-1 text-muted"></div>';
                        echo '  <div class="col col-md-5 text-muted">m.5 Skala VRS</div>';
                        echo '  <div class="col col-md-6 text-danger">Tidak Diketahui</div>';
                        echo '</div>';
                    }else{
                        echo '<div class="row mb-2">';
                        echo '  <div class="col col-md-1 text-muted"></div>';
                        echo '  <div class="col col-md-5 text-muted">m.6 Skala VRS</div>';
                        echo '  <div class="col col-md-6 text-muted">'.$asesmen_nyeri['skala_vrs']['skor'].' ('.$asesmen_nyeri['skala_vrs']['kategori'].')</div>';
                        echo '</div>';
                    }
                    if(empty($asesmen_nyeri['skala_nips'])){
                        echo '<div class="row mb-2">';
                        echo '  <div class="col col-md-1 text-muted"></div>';
                        echo '  <div class="col col-md-5 text-muted">m.7 Skala NIPS</div>';
                        echo '  <div class="col col-md-6 text-danger">Tidak Diketahui</div>';
                        echo '</div>';
                    }else{
                        echo '<div class="row mb-1">';
                        echo '  <div class="col col-md-1 text-muted"></div>';
                        echo '  <div class="col col-md-5 text-muted">m.7 Skala NIPS</div>';
                        echo '  <div class="col col-md-6 text-muted"><small>'.$asesmen_nyeri['skala_nips']['skor'].' ('.$asesmen_nyeri['skala_nips']['kategori'].')</small></div>';
                        echo '</div>';
                        echo '<div class="row mb-1">';
                        echo '  <div class="col col-md-2 text-muted"></div>';
                        echo '  <div class="col col-md-4 text-muted"><small>1. Facial Expression</small></div>';
                        echo '  <div class="col col-md-6 text-muted"><small>'.$asesmen_nyeri['skala_nips']['skala_nips1'].'. '.$LabelNips1.'</small></div>';
                        echo '</div>';
                        echo '<div class="row mb-1">';
                        echo '  <div class="col col-md-2 text-muted"></div>';
                        echo '  <div class="col col-md-4 text-muted"><small>2. Cry</small></div>';
                        echo '  <div class="col col-md-6 text-muted"><small>'.$asesmen_nyeri['skala_nips']['skala_nips2'].'. '.$LabelNips2.'</small></div>';
                        echo '</div>';
                        echo '<div class="row mb-1">';
                        echo '  <div class="col col-md-2 text-muted"></div>';
                        echo '  <div class="col col-md-4 text-muted"><small>3. Breathing Pattern</small></div>';
                        echo '  <div class="col col-md-6 text-muted"><small>'.$asesmen_nyeri['skala_nips']['skala_nips3'].'. '.$LabelNips3.'</small></div>';
                        echo '</div>';
                        echo '<div class="row mb-1">';
                        echo '  <div class="col col-md-2 text-muted"></div>';
                        echo '  <div class="col col-md-4 text-muted"><small>4. Arms</small></div>';
                        echo '  <div class="col col-md-6 text-muted"><small>'.$asesmen_nyeri['skala_nips']['skala_nips4'].'. '.$LabelNips4.'</small></div>';
                        echo '</div>';
                        echo '<div class="row mb-1">';
                        echo '  <div class="col col-md-2 text-muted"></div>';
                        echo '  <div class="col col-md-4 text-muted"><small>5. Legs</small></div>';
                        echo '  <div class="col col-md-6 text-muted"><small>'.$asesmen_nyeri['skala_nips']['skala_nips5'].'. '.$LabelNips5.'</small></div>';
                        echo '</div>';
                        echo '<div class="row mb-2">';
                        echo '  <div class="col col-md-2 text-muted"></div>';
                        echo '  <div class="col col-md-4 text-muted"><small>6. State Of Arousal</small></div>';
                        echo '  <div class="col col-md-6 text-muted"><small>'.$asesmen_nyeri['skala_nips']['skala_nips6'].'. '.$LabelNips6.'</small></div>';
                        echo '</div>';
                    }
                }
            }
            echo '      <div class="row mb-4 mt-4">';
            echo '          <div class="col col-md-6">N. Kesadaran pasien</div>';
            echo '          <div class="col col-md-6">'.$kesadaran_pasien.'</div>';
            echo '      </div>';
            if(empty($kajian_resiko_jatuh)){
                echo '      <div class="row mb-4 mt-4">';
                echo '          <div class="col col-md-6">o. Kajian Resiko Jatuh</div>';
                echo '          <div class="col col-md-6 text-danger">Tidak Diketahui</div>';
                echo '      </div>';
            }else{
                
                echo '      <div class="row mb-4">';
                echo '          <div class="col col-md-12 mb-3">o. Kajian Resiko Jatuh</div>';
                echo '          <div class="col col-md-12">';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-1 text-muted"></div>';
                echo '                  <div class="col col-md-5 text-muted">o.1. Nakes Pemeriksa</div>';
                echo '                  <div class="col col-md-6 text-muted">'.$kajian_resiko_jatuh['pemeriksa'].'</div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-1 text-muted"></div>';
                echo '                  <div class="col col-md-5 text-muted">o.2. MFS<br><small><i>(Morse Fall Scale)</i></small></div>';
                echo '                  <div class="col col-md-6 text-muted">'.$kajian_resiko_jatuh['mfs']['skor'].' ('.$kajian_resiko_jatuh['mfs']['kategori'].')</div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-2 text-muted"></div>';
                echo '                  <div class="col col-md-4 text-muted"><small>1. Riwayat jatuh</small></div>';
                echo '                  <div class="col col-md-6 text-muted"><small>'.$kajian_resiko_jatuh['mfs']['mfs1'].' ('.$LabelMfs1.')</small></div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-2 text-muted"></div>';
                echo '                  <div class="col col-md-4 text-muted"><small>2. Diagnosis Lain</small></div>';
                echo '                  <div class="col col-md-6 text-muted"><small>'.$kajian_resiko_jatuh['mfs']['mfs2'].' ('.$LabelMfs2.')</small></div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-2 text-muted"></div>';
                echo '                  <div class="col col-md-4 text-muted"><small>3. Bantuan Berjalan</small></div>';
                echo '                  <div class="col col-md-6 text-muted"><small>'.$kajian_resiko_jatuh['mfs']['mfs3'].' ('.$LabelMfs3.')</small></div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-2 text-muted"></div>';
                echo '                  <div class="col col-md-4 text-muted"><small>4. Heparin Lock</small></div>';
                echo '                  <div class="col col-md-6 text-muted"><small>'.$kajian_resiko_jatuh['mfs']['mfs4'].' ('.$LabelMfs4.')</small></div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-2 text-muted"></div>';
                echo '                  <div class="col col-md-4 text-muted"><small>5. Cara Berjalan/Berpindah</small></div>';
                echo '                  <div class="col col-md-6 text-muted"><small>'.$kajian_resiko_jatuh['mfs']['mfs5'].' ('.$LabelMfs5.')</small></div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-2 text-muted"></div>';
                echo '                  <div class="col col-md-4 text-muted"><small>6. Status Mental</small></div>';
                echo '                  <div class="col col-md-6 text-muted"><small>'.$kajian_resiko_jatuh['mfs']['mfs6'].' ('.$LabelMfs6.')</small></div>';
                echo '              </div>';
                echo '              <div class="row mt-4">';
                echo '                  <div class="col col-md-1 text-muted"></div>';
                echo '                  <div class="col col-md-5 text-muted">o.3. HDS<br><small><i>(Humpty Dumpty Scale)</i></small></div>';
                echo '                  <div class="col col-md-6 text-muted">'.$kajian_resiko_jatuh['hds']['skor'].' ('.$kajian_resiko_jatuh['hds']['kategori'].')</div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-2 text-muted"></div>';
                echo '                  <div class="col col-md-4 text-muted"><small>1. Umur</small></div>';
                echo '                  <div class="col col-md-6 text-muted"><small>'.$kajian_resiko_jatuh['hds']['hds1'].' ('.$LabelHds1.')</small></div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-2 text-muted"></div>';
                echo '                  <div class="col col-md-4 text-muted"><small>2. Jenis Kelamin</small></div>';
                echo '                  <div class="col col-md-6 text-muted"><small>'.$kajian_resiko_jatuh['hds']['hds2'].' ('.$LabelHds2.')</small></div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-2 text-muted"></div>';
                echo '                  <div class="col col-md-4 text-muted"><small>3. Diagnosis</small></div>';
                echo '                  <div class="col col-md-6 text-muted"><small>'.$kajian_resiko_jatuh['hds']['hds3'].' ('.$LabelHds3.')</small></div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-2 text-muted"></div>';
                echo '                  <div class="col col-md-4 text-muted"><small>4. Gangguan kognitif</small></div>';
                echo '                  <div class="col col-md-6 text-muted"><small>'.$kajian_resiko_jatuh['hds']['hds4'].' ('.$LabelHds4.')</small></div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-2 text-muted"></div>';
                echo '                  <div class="col col-md-4 text-muted"><small>5. Faktor lingkungan</small></div>';
                echo '                  <div class="col col-md-6 text-muted"><small>'.$kajian_resiko_jatuh['hds']['hds5'].' ('.$LabelHds5.')</small></div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-2 text-muted"></div>';
                echo '                  <div class="col col-md-4 text-muted"><small>6. Respon terhadap obat</small></div>';
                echo '                  <div class="col col-md-6 text-muted"><small>'.$kajian_resiko_jatuh['hds']['hds6'].' ('.$LabelHds6.')</small></div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-2 text-muted"></div>';
                echo '                  <div class="col col-md-4 text-muted"><small>7. Penggunaan obat</small></div>';
                echo '                  <div class="col col-md-6 text-muted"><small>'.$kajian_resiko_jatuh['hds']['hds7'].' ('.$LabelHds7.')</small></div>';
                echo '              </div>';
                echo '              <div class="row mt-4">';
                echo '                  <div class="col col-md-1 text-muted"></div>';
                echo '                  <div class="col col-md-5 text-muted">o.4.  EPFRA <br><small><i>(Edmonson Psychiatric Fall Risk Assessment)</i></small></div>';
                echo '                  <div class="col col-md-6 text-muted">'.$kajian_resiko_jatuh['epfra']['skor'].' ('.$kajian_resiko_jatuh['epfra']['kategori'].')</div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-2 text-muted"></div>';
                echo '                  <div class="col col-md-4 text-muted"><small>1. Umur</small></div>';
                echo '                  <div class="col col-md-6 text-muted"><small>'.$kajian_resiko_jatuh['epfra']['epfra1'].' ('.$LabelEpfra1.')</small></div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-2 text-muted"></div>';
                echo '                  <div class="col col-md-4 text-muted"><small>2. Status Mental</small></div>';
                echo '                  <div class="col col-md-6 text-muted"><small>'.$kajian_resiko_jatuh['epfra']['epfra2'].' ('.$LabelEpfra2.')</small></div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-2 text-muted"></div>';
                echo '                  <div class="col col-md-4 text-muted"><small>3. Eliminasi</small></div>';
                echo '                  <div class="col col-md-6 text-muted"><small>'.$kajian_resiko_jatuh['epfra']['epfra3'].' ('.$LabelEpfra3.')</small></div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-2 text-muted"></div>';
                echo '                  <div class="col col-md-4 text-muted"><small>4. Medikasi</small></div>';
                echo '                  <div class="col col-md-6 text-muted"><small>'.$kajian_resiko_jatuh['epfra']['epfra4'].' ('.$LabelEpfra4.')</small></div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-2 text-muted"></div>';
                echo '                  <div class="col col-md-4 text-muted"><small>5. Diagnosis</small></div>';
                echo '                  <div class="col col-md-6 text-muted"><small>'.$kajian_resiko_jatuh['epfra']['epfra5'].' ('.$LabelEpfra5.')</div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-2 text-muted"></div>';
                echo '                  <div class="col col-md-4 text-muted"><small>6. Ambulasi/Keseimbangan</small></div>';
                echo '                  <div class="col col-md-6 text-muted"><small>'.$kajian_resiko_jatuh['epfra']['epfra6'].' ('.$LabelEpfra6.')</small></div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-2 text-muted"></div>';
                echo '                  <div class="col col-md-4 text-muted"><small>7. Nutrisi</small></div>';
                echo '                  <div class="col col-md-6 text-muted"><small>'.$kajian_resiko_jatuh['epfra']['epfra7'].' ('.$LabelEpfra7.')</small></div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-2 text-muted"></div>';
                echo '                  <div class="col col-md-4 text-muted"><small>8. Gangguan Tidur</small></div>';
                echo '                  <div class="col col-md-6 text-muted"><small>'.$kajian_resiko_jatuh['epfra']['epfra8'].' ('.$LabelEpfra8.')</small></div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-2 text-muted"></div>';
                echo '                  <div class="col col-md-4 text-muted"><small>9. Riwayat Jatuh</small></div>';
                echo '                  <div class="col col-md-6 text-muted"><small>'.$kajian_resiko_jatuh['epfra']['epfra9'].' ('.$LabelEpfra9.')</small></div>';
                echo '              </div>';
                echo '          </div>';
                echo '      </div>';
            }
           
            
            echo '  </div>';
            echo '</div>';
        }
    }
?>
