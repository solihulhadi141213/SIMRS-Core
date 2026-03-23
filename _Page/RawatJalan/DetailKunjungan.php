<?php
    include "_Config/SimrsFunction.php"; 
    if(empty($_SESSION['UrlBackKunjungan'])){
        $UrlBack='index.php?Page=RawatJalan';
    }else{
        $UrlBack=$_SESSION['UrlBackKunjungan'];
    }
    //Tangkap ID
    if(empty($_GET['id'])){
        echo '<span class="text-danger">Belum Ada Data Kunjungan Yang Dipilih</span>';
    }else{
        $id_kunjungan=$_GET['id'];
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
        $kode_dokter=getDataDetail($Conn,"dokter",'id_dokter',$id_dokter,'kode');
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
        $TanggalFormat=date('d/m/Y H:i T',$strtotime);
        //Update Time Format
        $strtotime2=strtotime($updatetime);
        $updatetime_format=date('d/m/Y H:i T',$strtotime2);
        //Buka IHS Pasien
        $id_ihs=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'id_ihs');
        //Membuka Condition Pasien
        $id_kunjungan_condition=getDataDetail($Conn,"kunjungan_condition",'id_kunjungan',$id_kunjungan,'id_kunjungan_condition');
        //Membuka Data Observation
        $id_kunjungan_observation=getDataDetail($Conn,"kunjungan_observation",'id_kunjungan',$id_kunjungan,'id_kunjungan_observation');
        //Mencari rujukan keluar
        $noRujukanKeluar=getDataDetail($Conn,"rujukan",'id_kunjungan',$id_kunjungan,'noRujukan');
        echo '<input type="hidden" id="GetIdKunjungan" value="'.$id_kunjungan.'">';
?>
<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <h4>
                                            <i class="ti ti-info-alt"></i> Detail Kunjungan Pasien (<?php echo "$tujuan"; ?>)
                                        </h4>
                                    </div>
                                    <div class="col-md-12 mb-2 text-center">
                                        <div class="icon-btn">
                                            <a href="<?php echo $UrlBack;?>" class="btn btn-icon btn-outline-secondary">
                                                <i class="icofont-rounded-double-left"></i>
                                            </a>
                                            <a href="" class="btn btn-icon btn-outline-secondary" title="Reload Halaman Kunjungan Ini">
                                                <i class="icofont-refresh"></i>
                                            </a>
                                            <button type="button" class="btn btn-icon btn-outline-secondary" data-toggle="modal" data-target="#ModalEditKunjungan" data-id="<?php echo "$id_kunjungan"; ?>">
                                                <i class="ti-pencil"></i>
                                            </button>
                                            <button type="button" class="btn btn-icon btn-outline-secondary" data-toggle="modal" data-target="#ModalHapusKunjungan" data-id="<?php echo "$id_kunjungan"; ?>">
                                                <i class="ti-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 sub-title">
                                        <dt>A. Informasi Umum</dt>
                                        <ol>
                                            <li>
                                                ID.Kunjungan : <?php echo "<code class='text-secondary'>$id_kunjungan</code>"; ?>
                                            </li>
                                            <li>
                                                ID Encounter : 
                                                <code>
                                                    <?php 
                                                        if(empty($id_encounter)){
                                                            echo '<a href="javascript:void(0);" class="text-success" data-toggle="modal" data-target="#ModalTambahEncounter" data-id='.$id_kunjungan.'"><i class="ti ti-pencil"></i> Tambah Encounter</a>';
                                                        }else{
                                                            echo '<a href="javascript:void(0);" class="text-info" data-toggle="modal" data-target="#ModalDetailEncounter" data-id="'.$id_encounter.'">'.$id_encounter.' <i class="ti ti-new-window"></i></a>'; 
                                                        }
                                                    ?>
                                                </code>
                                            </li>
                                            <li>
                                                No.RM : 
                                                <?php
                                                    echo "<code>"; 
                                                    echo '  <a href="javascript:void(0);" class="text-info" data-toggle="modal" data-target="#ModalDetailPasien2" data-id='.$id_pasien.'">'.$id_pasien.' <i class="ti ti-new-window"></i></a>';
                                                    echo "</code>"; 
                                                ?>
                                            </li>
                                            <li>
                                                ID.IHS : 
                                                <?php
                                                    echo "<code>"; 
                                                    if(empty($id_ihs)){
                                                        echo '<span class="text-danger">Tidak Ada</span>';
                                                    }else{
                                                        echo '<a href="javascript:void(0);" class="text-info" data-toggle="modal" data-target="#ModalDetailIhs" data-id="'.$id_ihs.'">'.$id_ihs.' <i class="ti ti-new-window"></i></a>'; 
                                                    }
                                                    echo "</code>"; 
                                                ?>
                                            </li>
                                            <li>
                                                Tgl/Jam Kunjungan : <?php echo "<code class='text-secondary'>$TanggalFormat</code>"; ?>
                                            </li>
                                        </ol>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 sub-title">
                                        <dt>B. Informasi Pasien</dt>
                                        <ol>
                                            <li>
                                                No.RM : 
                                                <?php
                                                    echo "<code>"; 
                                                    echo '  <a href="javascript:void(0);" class="text-info" data-toggle="modal" data-target="#ModalDetailPasien2" data-id='.$id_pasien.'">'.$id_pasien.' <i class="ti ti-new-window"></i></a>';
                                                    echo "</code>"; 
                                                ?>
                                            </li>
                                            <li>
                                                Nama Pasien : <?php echo "<code class='text-secondary'>$nama</code>"; ?>
                                            </li>
                                            <li>
                                                NIK : 
                                                <?php
                                                    echo "<code>"; 
                                                    if(empty($nik)){
                                                        echo '<span class="text-danger">Tidak Ada</span>';
                                                    }else{
                                                        echo '  <a href="javascript:void(0);" class="text-info" data-toggle="modal" data-target="#ModalDetailNik" data-id="'.$nik.'">'.$nik.' <i class="ti ti-new-window"></i></a>';
                                                    }
                                                    echo "</code>"; 
                                                ?>
                                            </li>
                                            <li>
                                                No.BPJS : 
                                                <?php
                                                    echo "<code>"; 
                                                    if(empty($nik)){
                                                        echo '<span class="text-danger">Tidak Ada</span>';
                                                    }else{
                                                        echo '<a href="javascript:void(0);" class="text-info" data-toggle="modal" data-target="#ModalDetailBpjs" data-id="'.$no_bpjs.'"><code>'.$no_bpjs.' <i class="ti ti-new-window"></i></code></a>';
                                                    }
                                                    echo "</code>"; 
                                                ?>
                                            </li>
                                            <li>
                                                Alamat Pasien : 
                                                <ul>
                                                    <li>
                                                        - Provinsi
                                                        <?php 
                                                            echo '<code>';
                                                            if(empty($propinsi)){
                                                                echo '<span class="text-danger">Tidak Ada</span>';
                                                            }else{
                                                                echo "<span class='text-secondary'>$propinsi</span>"; 
                                                            }
                                                            echo '</code>';
                                                        ?>
                                                    </li>
                                                    <li>
                                                        - Kabupaten/Kota
                                                        <?php 
                                                            echo '<code>';
                                                            if(empty($kabupaten)){
                                                                echo '<span class="text-danger">Tidak Ada</span>';
                                                            }else{
                                                                echo "<span class='text-secondary'>$kabupaten</span>"; 
                                                            }
                                                            echo '</code>';
                                                        ?>
                                                    </li>
                                                    <li>
                                                        - Kecamatan
                                                        <?php 
                                                            echo '<code>';
                                                            if(empty($kecamatan)){
                                                                echo '<span class="text-danger">Tidak Ada</span>';
                                                            }else{
                                                                echo "<span class='text-secondary'>$kecamatan</span>"; 
                                                            }
                                                            echo '</code>';
                                                        ?>
                                                    </li>
                                                    <li>
                                                        - Desa/Kelurahan
                                                        <?php 
                                                            echo '<code>';
                                                            if(empty($desa)){
                                                                echo '<span class="text-danger">Tidak Ada</span>';
                                                            }else{
                                                                echo "<span class='text-secondary'>$desa</span>"; 
                                                            }
                                                            echo '</code>';
                                                        ?>
                                                    </li>
                                                    <li>
                                                        - RT/RW/Jalan
                                                        <?php 
                                                            echo '<code>';
                                                            if(empty($alamat)){
                                                                echo '<span class="text-danger">Tidak Ada</span>';
                                                            }else{
                                                                echo "<span class='text-secondary'>$alamat</span>"; 
                                                            }
                                                            echo '</code>';
                                                        ?>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ol>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 sub-title">
                                        <dt>C. Bridging BPJS</dt>
                                        <ol>
                                            <li>
                                                No.SEP : 
                                                <?php
                                                    echo "<code>"; 
                                                    if(empty($sep)){
                                                        echo '<span class="text-danger">Tidak Ada</span>';
                                                    }else{
                                                        echo '  <a href="javascript:void(0);" class="text-info" data-toggle="modal" data-target="#ModalDetailSepBySep" data-id="'.$sep.'"><i class="ti ti-layers"></i> '.$sep.'</a>';
                                                    }
                                                    echo "</code>"; 
                                                ?>
                                            </li>
                                            <li>
                                                SKDP/SPRI : 
                                                <?php
                                                    echo "<code>"; 
                                                    if(empty($skdp)){
                                                        echo '<span class="text-danger">Tidak Ada</span>';
                                                    }else{
                                                        echo '  <a href="javascript:void(0);" class="text-info" data-toggle="modal" data-target="#ModalDetailSpriSkdp" data-id="'.$skdp.'"><i class="ti ti-layers"></i> '.$skdp.'</a>';
                                                    }
                                                    echo "</code>"; 
                                                ?>
                                            </li>
                                            <li>
                                                No. Antrian : 
                                                <?php
                                                    echo "<code>"; 
                                                    if(empty($no_antrian)){
                                                        echo '<span class="text-danger">Tidak Ada</span>';
                                                    }else{
                                                        echo "<span>$no_antrian</span>"; 
                                                    }
                                                    echo "</code>"; 
                                                ?>
                                            </li>
                                            <li>
                                                Rujukan Masuk : 
                                                <ul>
                                                    <li>
                                                        - No.Rujukan : 
                                                        <?php
                                                            echo "<code>"; 
                                                            if(empty($noRujukan)){
                                                                echo '<span class="text-danger">Tidak Ada</span>';
                                                            }else{
                                                                echo '  <a href="javascript:void(0);" class="text-info" data-toggle="modal" data-target="#ModalDetailRujukanMasukByRujukan" data-id="'.$noRujukan.'"><i class="ti ti-layers"></i> '.$noRujukan.'</a>';
                                                            }
                                                            echo "</code>"; 
                                                        ?>
                                                    </li>
                                                    <li>
                                                        - PPK Asal Rujukan : 
                                                        <?php 
                                                            echo "<code>"; 
                                                            if(empty($rujukan_dari)){
                                                                echo '<span class="text-danger">Tidak Ada</span>';
                                                            }else{
                                                                echo "<span class='text-secondary'>$rujukan_dari</span>"; 
                                                            }
                                                            echo "</code>"; 
                                                        ?>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li>
                                                Rujukan Keluar : 
                                                <ul>
                                                    <li>
                                                        - No.Rujukan : 
                                                        <?php
                                                            echo "<code>"; 
                                                            if(empty($noRujukanKeluar)){
                                                                echo '<span class="text-danger">Tidak Ada</span>';
                                                            }else{
                                                                echo '  <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalDetailRujukanMasukByRujukan" data-id='.$noRujukanKeluar.'"><i class="ti ti-layers"></i> '.$noRujukanKeluar.'</a>';
                                                            }
                                                            echo "</code>"; 
                                                        ?>
                                                    </li>
                                                    <li>
                                                        - PPK Tujuan Rujukan : 
                                                        <?php 
                                                            echo "<code>"; 
                                                            if(empty($rujukan_ke)){
                                                                echo '<span class="text-danger">Tidak Ada</span>';
                                                            }else{
                                                                echo "<span class='text-secondary'>$rujukan_ke</span>"; 
                                                            }
                                                            echo "</code>"; 
                                                        ?>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ol>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 sub-title">
                                        <dt>D. Informasi Kunjungan</dt>
                                        <ol>
                                            <li>
                                                Tujuan Kunjungan : <?php echo "<code class='text-secondary'>$tujuan</code>"; ?>
                                            </li>
                                            <li>
                                                Dokter DPJP : <?php echo "<code class='text-secondary'>$dokter</code>"; ?>
                                            </li>
                                            <li>
                                                Poliklinik : 
                                                <?php
                                                    echo "<code>"; 
                                                    if(empty($poliklinik)){
                                                        echo '<span class="text-danger">Tidak Ada</span>';
                                                    }else{
                                                        echo "<span class='text-secondary'>$poliklinik</span>"; 
                                                    }
                                                    echo "</code>"; 
                                                ?>
                                            </li>
                                            <li>
                                                Kelas/Ruangan : 
                                                <?php
                                                    echo "<code>"; 
                                                    if(empty($kelas)){
                                                        echo '<span class="text-danger">Tidak Ada</span>';
                                                    }else{
                                                        echo "<span class='text-secondary'>$kelas-$ruangan</span>"; 
                                                    }
                                                    echo "</code>"; 
                                                ?>
                                            </li>
                                            <li>
                                                Metode Pembayaran : <?php echo "<code class='text-secondary'>$pembayaran</code>"; ?>
                                            </li>
                                            <li>
                                                Diagnosa Masuk : 
                                                <?php
                                                    echo "<code>"; 
                                                    if(empty($DiagAwal)){
                                                        echo '<span class="text-danger">Tidak Ada</span>';
                                                    }else{
                                                        echo "<span class='text-secondary'>$DiagAwal</span>"; 
                                                    }
                                                    echo "</code>"; 
                                                ?>
                                            </li>
                                        </ol>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <dt>E. Kesimpulan Kunjungan</dt>
                                        <ol>
                                            <li>
                                                Cara Keluar : 
                                                <?php
                                                    echo "<code>"; 
                                                    if(empty($cara_keluar)){
                                                        echo '<span class="text-danger">Tidak Ada</span>';
                                                    }else{
                                                        echo "<span class='text-secondary'>$cara_keluar</span>"; 
                                                    }
                                                    echo "</code>"; 
                                                ?>
                                            </li>
                                            <li>
                                                Tanggal Keluar : 
                                                <?php
                                                    echo "<code>"; 
                                                    if(empty($tanggal_keluar)){
                                                        echo '<span class="text-danger">Tidak Ada</span>';
                                                    }else{
                                                        echo "<span class='text-secondary'>$tanggal_keluar</span>"; 
                                                    }
                                                    echo "</code>"; 
                                                ?>
                                            </li>
                                            <li>
                                                Status Kunjungan : <?php echo "<code class='text-secondary'>$status</code>"; ?>
                                            </li>
                                            <li>
                                                Updatetime : <?php echo "<code class='text-secondary'>$updatetime_format</code>"; ?>
                                            </li>
                                            <li>
                                                Petugas : <?php echo "<code class='text-secondary'>$nama_petugas</code>"; ?>
                                            </li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        //Properti Checklist
                        $CheckIdAntrian=getDataDetail($Conn,"antrian",'id_kunjungan',$id_kunjungan,'id_antrian');
                        $CheckGeneralConsent=getDataDetail($Conn,"general_consent",'id_kunjungan',$id_kunjungan,'id_general_consent');
                        $CheckTreaseIgd=getDataDetail($Conn,"triase_igd",'id_kunjungan',$id_kunjungan,'id_triase_igd');
                        $CheckAnamnesis=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'id_anamnesis');
                        $CheckPemeriksaanFisik=getDataDetail($Conn,"pemeriksaan_fisik",'id_kunjungan',$id_kunjungan,'id_pemeriksaan_fisik');
                        $CheckPsikosos=getDataDetail($Conn,"psikosos",'id_kunjungan',$id_kunjungan,'id_psikosos');
                        $CheckScreening=getDataDetail($Conn,"screening",'id_kunjungan',$id_kunjungan,'id_screening');
                        //Menghitung Pemeriksaan dasar
                        if(empty($CheckTreaseIgd)){
                            $JumlahTreaseIgd=0;
                        }else{
                            $JumlahTreaseIgd=1;
                        }
                        if(empty($CheckAnamnesis)){
                            $JumlahAnamnesa=0;
                        }else{
                            $JumlahAnamnesa=1;
                        }
                        if(empty($CheckPemeriksaanFisik)){
                            $JumlahPemeriksaanFisik=0;
                        }else{
                            $JumlahPemeriksaanFisik=1;
                        }
                        if(empty($CheckPsikosos)){
                            $JumlahPsikosos=0;
                        }else{
                            $JumlahPsikosos=1;
                        }
                        if(empty($CheckScreening)){
                            $JumlahScreening=0;
                        }else{
                            $JumlahScreening=1;
                        }
                        $CheckPemeriksaanDasar=$JumlahTreaseIgd+$JumlahAnamnesa+$JumlahPemeriksaanFisik+$JumlahPsikosos+$JumlahScreening;
                        $CheckDiagnosa=getDataDetail($Conn,"diagnosis_pasien",'id_kunjungan',$id_kunjungan,'id_diagnosis_pasien');
                        //Terapi Tindakan
                        $CheckPersetujuanTindakan=getDataDetail($Conn,"persetujuan_tindakan",'id_kunjungan',$id_kunjungan,'id_persetujuan_tindakan');
                        $CheckTindakan=getDataDetail($Conn,"tindakan",'id_kunjungan',$id_kunjungan,'id_tindakan');
                        $CheckResepObat=getDataDetail($Conn,"resep",'id_kunjungan',$id_kunjungan,'id_resep');
                        $CheckRiwayatPenggunaanObat=getDataDetail($Conn,"riwayat_penggunaan_obat",'id_kunjungan',$id_kunjungan,'id_riwayat_penggunaan_obat');
                        if(empty($CheckPersetujuanTindakan)){
                            $JumlahPersetujuanTindakan=0;
                        }else{
                            $JumlahPersetujuanTindakan=1;
                        }
                        if(empty($CheckTindakan)){
                            $JumlahTindakan=0;
                        }else{
                            $JumlahTindakan=1;
                        }
                        if(empty($CheckResepObat)){
                            $JumlahResepObat=0;
                        }else{
                            $JumlahResepObat=1;
                        }
                        if(empty($CheckRiwayatPenggunaanObat)){
                            $JumlahRiwayatPenggunaanObat=0;
                        }else{
                            $JumlahRiwayatPenggunaanObat=1;
                        }
                        $CheckTerapiDanTindakan=$JumlahPersetujuanTindakan+$JumlahTindakan+$JumlahResepObat+$JumlahRiwayatPenggunaanObat;
                        //Penunjang
                        $CheckLaboratorium=getDataDetail($Conn,"laboratorium_permintaan",'id_kunjungan',$id_kunjungan,'id_permintaan');
                        $CheckRadiologi=getDataDetail($Conn,"radiologi",'id_kunjungan',$id_kunjungan,'id_rad');
                        if(empty($CheckLaboratorium)){
                            $JumlahLaboratorium=0;
                        }else{
                            $JumlahLaboratorium=1;
                        }
                        if(empty($CheckRadiologi)){
                            $JumlahRadiologi=0;
                        }else{
                            $JumlahRadiologi=1;
                        }
                        $CheckPenunjang=$JumlahLaboratorium+$JumlahRadiologi;
                        //Perencanaan Pasien
                        $CheckPerencanaanPasien=getDataDetail($Conn,"perencanaan_pasien",'id_kunjungan',$id_kunjungan,'id_perencanaan_pasien');
                        //CPPT
                        $CheckCcpt=getDataDetail($Conn,"cppt",'id_kunjungan',$id_kunjungan,'id_cppt');
                        //Konsultasi
                        $CheckKonsultasi=getDataDetail($Conn,"konsultasi",'id_kunjungan',$id_kunjungan,'id_konsultasi');
                        //Edukasi
                        $CheckEdukasi=getDataDetail($Conn,"edukasi",'id_kunjungan',$id_kunjungan,'id_edukasi');
                        //Operasi
                        $CheckOperasi=getDataDetail($Conn,"operasi",'id_kunjungan',$id_kunjungan,'id_operasi');
                        //Resume
                        $CehckResume=getDataDetail($Conn,"resume",'id_kunjungan',$id_kunjungan,'id_resume');
                    ?>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="card">
                                    <div class="card-header">
                                        <h4><i class="icofont-patient-file"></i> Attachment Kunjungan (<?php echo "$tujuan"; ?>)</h4>
                                    </div>
                                    <div class="card-body accordion-block">
                                        <div id="accordion" role="tablist" aria-multiselectable="true">
                                            <div class="accordion-panel">
                                                <div class="accordion-heading" role="tab" id="heading1">
                                                    <h3 class="card-title accordion-title">
                                                        <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#EncounterSatuSehat" aria-expanded="true" aria-controls="EncounterSatuSehat">
                                                            <dt>1. Satu Sehat</dt>
                                                        </a>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div id="EncounterSatuSehat" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading1">
                                                <div class="accordion-content accordion-desc bg-light">
                                                    <?php
                                                        //Apabila ID Encounter Satu Sehat Belum Ada
                                                        if(empty($id_encounter)){
                                                            echo '<div class="row">';
                                                            echo '  <div class="col-md-12">';
                                                            echo '      <span class="text-dark">';
                                                            echo '          Belum Ada ID Encounter Pada Kunjungan Ini, Silahkan Buat Terlebih Dulu Dengan Memilih Tautan ';
                                                            echo '          <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalTambahEncounter" data-id='.$id_kunjungan.'">Berikut Ini</a>';
                                                            echo '      </span>';
                                                            echo '  </div>';
                                                            echo '</div>';
                                                        }else{
                                                            //Apabila ID Encounter Satu Sehat Sudah Ada
                                                            echo '<input type="hidden" id="GetIdEncounter" value="'.$id_encounter.'">';
                                                            echo '<div class="accordion-panel">';
                                                            echo '  <div class="accordion-heading" role="tab" id="heading1_1">';
                                                            echo '      <h3 class="card-title accordion-title">';
                                                            echo '          <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#EncounterDetail" aria-expanded="false" aria-controls="EncounterDetail">';
                                                            echo '              <dt>1.1 Detail Encounter</dt>';
                                                            echo '          </a>';
                                                            echo '      </h3>';
                                                            echo '  </div>';
                                                            echo '</div>';
                                                            echo '<div id="EncounterDetail" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading1_1">';
                                                            echo '  <div class="accordion-content accordion-desc">';
                                                            echo '      <div class="row mb-3">';
                                                            echo '          <div class="col-md-6 mt-3">';
                                                            echo '              <a href="javascript:void(0);" class="btn btn-sm btn-outline-dark btn-block" data-toggle="modal" data-target="#ModalEditEncounter" data-id="'.$id_encounter.','.$id_kunjungan.'" title="Ubah Data Encounter Utama">';
                                                            echo '                  <i class="ti ti-pencil"></i> Edit';
                                                            echo '              </a>';
                                                            echo '          </div>';
                                                            echo '          <div class="col-md-6 mt-3">';
                                                            echo '              <a href="javascript:void(0);" class="btn btn-sm btn-outline-dark btn-block" data-toggle="modal" data-target="#ModalUpdateEncounter" data-id="'.$id_encounter.','.$id_kunjungan.'" title="Update Data Status Encounter">';
                                                            echo '                  <i class="ti ti-timer"></i> Update';
                                                            echo '              </a>';
                                                            echo '          </div>';
                                                            echo '      </div>';
                                                            echo '      <div class="row mb-3">';
                                                            echo '          <div class="col-md-12 mb-3" id="DetailEncounterKunjungan"> Loading...</div>';
                                                            echo '      </div>';
                                                            echo '  </div>';
                                                            echo '</div>';
                                                            echo '<div class="accordion-panel">';
                                                            echo '  <div class="accordion-heading" role="tab" id="heading1_2">';
                                                            echo '      <h3 class="card-title accordion-title">';
                                                            echo '          <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#EncounterCondition" aria-expanded="false" aria-controls="EncounterCondition">';
                                                            echo '              <dt>1.2 Condition</dt>';
                                                            echo '          </a>';
                                                            echo '      </h3>';
                                                            echo '  </div>';
                                                            echo '</div>';
                                                            echo '<div id="EncounterCondition" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading1_2">';
                                                            echo '  <div class="accordion-content accordion-desc">';
                                                            if(empty($id_kunjungan_condition)){
                                                                echo '      <div class="row mb-3 mt-3">';
                                                                echo '          <div class="col-md-12">';
                                                                echo '              <button type="button" class="btn btn-sm btn-block btn-outline-dark" data-toggle="modal" data-target="#ModalTambahCondition" data-id="'.$id_kunjungan.'">';
                                                                echo '                  <i class="ti ti-plus"></i> Tambah Condition';
                                                                echo '              </button>';
                                                                echo '          </div>';
                                                                echo '      </div>';
                                                            }else{
                                                                //Buka Data Condition Dari SIMRS
                                                                $id_condition=getDataDetail($Conn,"kunjungan_condition",'id_kunjungan',$id_kunjungan,'id_condition');
                                                                $categorycondition=getDataDetail($Conn,"kunjungan_condition",'id_kunjungan',$id_kunjungan,'category');
                                                                $clinicalStatus=getDataDetail($Conn,"kunjungan_condition",'id_kunjungan',$id_kunjungan,'clinicalStatus');
                                                                $code_system=getDataDetail($Conn,"kunjungan_condition",'id_kunjungan',$id_kunjungan,'code_system');
                                                                echo '<input type="hidden" id="GetIdCondition" value="'.$id_kunjungan_condition.'">';
                                                                echo '      <div class="row mb-3">';
                                                                echo '          <div class="col-md-12">';
                                                                echo '              <button type="button" class="btn btn-sm btn-block btn-outline-dark" data-toggle="modal" data-target="#ModalEditCondition" data-id="'.$id_kunjungan_condition.'">';
                                                                echo '                  <i class="ti ti-plus"></i> Edit Condition';
                                                                echo '              </button>';
                                                                echo '          </div>';
                                                                echo '      </div>';
                                                                echo '      <div class="row mb-3">';
                                                                echo '          <div class="col-md-4">ID Condition</div>';
                                                                echo '          <div class="col-md-8">'.$id_kunjungan_condition.'</div>';
                                                                echo '      </div>';
                                                                echo '      <div class="row mb-3">';
                                                                echo '          <div class="col-md-4">IHS Condition</div>';
                                                                echo '          <div class="col-md-8">';
                                                                echo '              <a href="javascript:void(0);" class="text-success" data-toggle="modal" data-target="#ModalDetailCondition" data-id="'.$id_condition.'">'.$id_condition.' <i class="ti ti-new-window"></i></a>';
                                                                echo '          </div>';
                                                                echo '      </div>';
                                                                echo '      <div class="row mb-3">';
                                                                echo '          <div class="col-md-4">Category Condition</div>';
                                                                echo '          <div class="col-md-8">'.$categorycondition.'</div>';
                                                                echo '      </div>';
                                                                echo '      <div class="row mb-3">';
                                                                echo '          <div class="col-md-4">Clinical Status</div>';
                                                                echo '          <div class="col-md-8">'.$clinicalStatus.'</div>';
                                                                echo '      </div>';
                                                                echo '      <div class="row mb-3">';
                                                                echo '          <div class="col-md-4">Code System</div>';
                                                                echo '          <div class="col-md-8">'.$code_system.'</div>';
                                                                echo '      </div>';
                                                            }
                                                            echo '  </div>';
                                                            echo '</div>';
                                                            echo '<div class="accordion-panel">';
                                                            echo '  <div class="accordion-heading" role="tab" id="heading1_3">';
                                                            echo '      <h3 class="card-title accordion-title">';
                                                            echo '          <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#EncounterObservation" aria-expanded="false" aria-controls="EncounterObservation">';
                                                            echo '              <dt>1.3 Observation</dt>';
                                                            echo '          </a>';
                                                            echo '      </h3>';
                                                            echo '  </div>';
                                                            echo '</div>';
                                                            echo '<div id="EncounterObservation" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading1_3">';
                                                            echo '  <div class="accordion-content accordion-desc" id="ShowObservation">';
                                                            //Show Observation Disini
                                                            echo '  </div>';
                                                            echo '</div>';
                                                            echo '<div class="accordion-panel">';
                                                            echo '  <div class="accordion-heading" role="tab" id="heading1_4">';
                                                            echo '      <h3 class="card-title accordion-title">';
                                                            echo '          <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#EncounterComposition" aria-expanded="false" aria-controls="EncounterComposition">';
                                                            echo '              <dt>1.4 Composition</dt>';
                                                            echo '          </a>';
                                                            echo '      </h3>';
                                                            echo '  </div>';
                                                            echo '</div>';
                                                            echo '<div id="EncounterComposition" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading1_4">';
                                                            echo '  <div class="accordion-content accordion-desc" id="ShowComposition">';
                                                            //Show Procedure Disini
                                                            echo '  </div>';
                                                            echo '</div>';
                                                            echo '<div class="accordion-panel">';
                                                            echo '  <div class="accordion-heading" role="tab" id="heading1_5">';
                                                            echo '      <h3 class="card-title accordion-title">';
                                                            echo '          <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#EncounterProcedure" aria-expanded="false" aria-controls="EncounterProcedure">';
                                                            echo '              <dt>1.5 Procedure</dt>';
                                                            echo '          </a>';
                                                            echo '      </h3>';
                                                            echo '  </div>';
                                                            echo '</div>';
                                                            echo '<div id="EncounterProcedure" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading1_5">';
                                                            echo '  <div class="accordion-content accordion-desc">';
                                                            echo '      <div class="row mb-3 mt-3 mb-3">';
                                                            echo '          <div class="col-md-12">';
                                                            echo '              <div class="btn-group">';
                                                            echo '                  <button type="button" class="btn btn-sm btn-outline-dark" id="ReloadProcedure">';
                                                            echo '                      <i class="ti ti-reload"></i> Reload';
                                                            echo '                  </button>';
                                                            echo '                  <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalTambahProcedur" data-id="'.$id_kunjungan.'">';
                                                            echo '                      <i class="ti ti-plus"></i> Tambah Procedur';
                                                            echo '                  </button>';
                                                            echo '              </div>';
                                                            echo '          </div>';
                                                            echo '      </div>';
                                                            echo '      <p id="ShowProcedur">';
                                                            echo '          Detail Procedure Disini';
                                                            echo '      </p>';
                                                            echo '  </div>';
                                                            echo '</div>';
                                                            //Show Medication Disini
                                                            echo '<div class="accordion-panel">';
                                                            echo '  <div class="accordion-heading" role="tab" id="heading1_6">';
                                                            echo '      <h3 class="card-title accordion-title">';
                                                            echo '          <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#EncounterMedication" aria-expanded="false" aria-controls="EncounterMedication">';
                                                            echo '              <dt>1.6 Medication</dt>';
                                                            echo '          </a>';
                                                            echo '      </h3>';
                                                            echo '  </div>';
                                                            echo '</div>';
                                                            echo '<div id="EncounterMedication" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading1_6">';
                                                            echo '  <div class="accordion-content accordion-desc">';
                                                            echo '      <p>';
                                                            echo '          <div class="accordion-panel">';
                                                            echo '              <div class="accordion-heading" role="tab" id="heading1_6_2">';
                                                            echo '                  <h3 class="card-title accordion-title">';
                                                            echo '                      <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#EncounterMedication_2" aria-expanded="false" aria-controls="EncounterMedication_2">';
                                                            echo '                          <dt>1.6.1 Medication Request</dt>';
                                                            echo '                      </a>';
                                                            echo '                  </h3>';
                                                            echo '              </div>';
                                                            echo '          </div>';
                                                            echo '          <div id="EncounterMedication_2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading1_6_2">';
                                                            echo '              <div class="accordion-content accordion-desc">';
                                                            echo '                  <div class="row mb-3">';
                                                            echo '                      <div class="col-md-6 mb-2">';
                                                            echo '                          <button type="button" class="btn btn-sm btn-outline-secondary btn-block" id="ReloadMedicationRequest">';
                                                            echo '                              <i class="ti ti-reload"></i> Reload';
                                                            echo '                          </button>';
                                                            echo '                      </div>';
                                                            echo '                      <div class="col-md-6 mb-2">';
                                                            echo '                          <button type="button" class="btn btn-sm btn-outline-secondary btn-block" data-toggle="modal" data-target="#ModalTambahMedicationRequest" data-id="'.$id_kunjungan.'">';
                                                            echo '                              <i class="ti ti-plus"></i> Tambah';
                                                            echo '                          </button>';
                                                            echo '                      </div>';
                                                            echo '                  </div>';
                                                            echo '                  <div class="row mb-3">';
                                                            echo '                      <div class="col-md-12 mb-2" id="MenampilkanMedicationRequest">';
                                                            echo '                           Detail Medication Request Disini';
                                                            echo '                      </div>';
                                                            echo '                  </div>';
                                                            echo '              </div>';
                                                            echo '          </div>';
                                                            echo '          <div class="accordion-panel">';
                                                            echo '              <div class="accordion-heading" role="tab" id="heading1_6_3">';
                                                            echo '                  <h3 class="card-title accordion-title">';
                                                            echo '                      <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#EncounterMedication_3" aria-expanded="false" aria-controls="EncounterMedication_3">';
                                                            echo '                          <dt>1.6.2 Medication Dispense</dt>';
                                                            echo '                      </a>';
                                                            echo '                  </h3>';
                                                            echo '              </div>';
                                                            echo '          </div>';
                                                            echo '          <div id="EncounterMedication_3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading1_6_3">';
                                                            echo '              <div class="accordion-content accordion-desc">';
                                                            echo '                  <div class="row mb-3">';
                                                            echo '                      <div class="col-md-12 text-center mb-2">';
                                                            echo '                          <button type="button" class="btn btn-sm btn-outline-secondary" id="ReloadMedicationDispense">';
                                                            echo '                              <i class="ti ti-reload"></i> Reload';
                                                            echo '                          </button>';
                                                            echo '                          <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#ModalTambahMedicationDispense" data-id="'.$id_kunjungan.'">';
                                                            echo '                              <i class="ti ti-plus"></i> Tambah';
                                                            echo '                          </button>';
                                                            echo '                      </div>';
                                                            echo '                  </div>';
                                                            echo '                  <div class="row mb-3">';
                                                            echo '                      <div class="col-md-12 mb-2" id="MenampilkanMedicationDispense">';
                                                            echo '                           Detail Medication Dispense Disini';
                                                            echo '                      </div>';
                                                            echo '                  </div>';
                                                            echo '              </div>';
                                                            echo '          </div>';
                                                            echo '      </p>';
                                                            echo '  </div>';
                                                            echo '</div>';
                                                            echo '<div class="accordion-panel">';
                                                            echo '  <div class="accordion-heading" role="tab" id="heading1_7">';
                                                            echo '      <h3 class="card-title accordion-title">';
                                                            echo '          <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#EncounterAllergyIntolerance" aria-expanded="false" aria-controls="EncounterAllergyIntolerance">';
                                                            echo '              <dt>1.7 Allergy Intolerance</dt>';
                                                            echo '          </a>';
                                                            echo '      </h3>';
                                                            echo '  </div>';
                                                            echo '</div>';
                                                            echo '<div id="EncounterAllergyIntolerance" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading1_7">';
                                                            echo '  <div class="accordion-content accordion-desc">';
                                                            //Histori
                                                            echo '      <div class="accordion-panel">';
                                                            echo '          <div class="accordion-heading" role="tab" id="heading1_7_1">';
                                                            echo '              <h3 class="card-title accordion-title">';
                                                            echo '                  <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#AllergyIntoleranceByIdPatient" aria-expanded="false" aria-controls="AllergyIntoleranceByIdPatient" id="TampilkanHistoriAlergiByIdPasien">';
                                                            echo '                      <dt>1.7.1 History Allergy Intoleranc </dt>';
                                                            echo '                  </a>';
                                                            echo '              </h3>';
                                                            echo '          </div>';
                                                            echo '      </div>';
                                                            echo '      <div id="AllergyIntoleranceByIdPatient" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading1_7_1">';
                                                            echo '          <div class="accordion-content accordion-desc">';
                                                            echo '              <div class="row mb-3">';
                                                            echo '                  <div class="col-md-12">';
                                                            echo '                      <button type="button" class="btn btn-sm btn-outline-secondary btn-block" id="ReloadAlergiByIdIhsPasien"><i class="ti ti-reload"></i> Reload</button>';
                                                            echo '                  </div>';
                                                            echo '              </div>';
                                                            echo '              <div class="row mb-3">';
                                                            echo '                  <div class="col-md-12" id="MenampilkanAlergiByIdIhsPasien">';
                                                            echo '                      Riwayat Alergi Disini';
                                                            echo '                  </div>';
                                                            echo '              </div>';
                                                            echo '          </div>';
                                                            echo '      </div>';
                                                            //Histori By Encounter
                                                            echo '      <div class="accordion-panel">';
                                                            echo '          <div class="accordion-heading" role="tab" id="heading1_7_2">';
                                                            echo '              <h3 class="card-title accordion-title">';
                                                            echo '                  <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#AllergyIntoleranceByEncounter" aria-expanded="false" aria-controls="AllergyIntoleranceByEncounter">';
                                                            echo '                      <dt>1.7.2 Allergy Intoleranc By Encounter</dt>';
                                                            echo '                  </a>';
                                                            echo '              </h3>';
                                                            echo '          </div>';
                                                            echo '      </div>';
                                                            echo '      <div id="AllergyIntoleranceByEncounter" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading1_7_2">';
                                                            echo '          <div class="accordion-content accordion-desc">';
                                                            if(empty($id_encounter)){
                                                                echo '          <div class="row mb-3">';
                                                                echo '              <div class="col-md-12 text-center text-danger">';
                                                                echo '                  Belum Ada ID Encounter Untuk Dilakukan Pencatatan Alergi';
                                                                echo '              </div>';
                                                                echo '          </div>';
                                                            }else{
                                                                echo '          <div class="row mb-3">';
                                                                echo '              <div class="col-md-12">';
                                                                echo '                  <button type="button" class="btn btn-sm btn-block btn-outline-secondary" id="ReloadAllergyIntolerancKunjungan">';
                                                                echo '                      <i class="ti ti-reload"></i> Reload Alergi';
                                                                echo '                  </button>';
                                                                echo '              </div>';
                                                                echo '          </div>';
                                                                echo '          <div class="row mb-3 subtitle">';
                                                                echo '              <div class="col-md-12" id="MenampilkanAllergyIntolerancKunjungan">';
                                                                echo '              </div>';
                                                                echo '          </div>';
                                                            }
                                                            echo '          </div>';
                                                            echo '      </div>';
                                                            echo '  </div>';
                                                            echo '</div>';
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="accordion-panel">
                                                <div class="accordion-heading" role="tab" id="heading2">
                                                    <h3 class="card-title accordion-title">
                                                        <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#AntrianKunjungan" aria-expanded="false" aria-controls="AntrianKunjungan">
                                                            <dt>2. Antrian <?php if(!empty($CheckIdAntrian)){echo '<span class="badge badge-success"><i class="ti ti-check"></i></span>';} ?></dt>
                                                        </a>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div id="AntrianKunjungan" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading2">
                                                <div class="accordion-content accordion-desc">
                                                    <p id="DetailAntrianKunjungan">
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="accordion-panel">
                                                <div class="accordion-heading" role="tab" id="heading3">
                                                    <h3 class="card-title accordion-title">
                                                        <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#Bpjs" aria-expanded="false" aria-controls="Bpjs">
                                                            <dt>3. BPJS Kesehatan</dt>
                                                        </a>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div id="Bpjs" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading3">
                                                <div class="accordion-content accordion-desc">
                                                    <p>
                                                        <div class="accordion-panel">
                                                            <div class="accordion-heading" role="tab" id="heading3_1">
                                                                <h3 class="card-title accordion-title">
                                                                    <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#SepBpjs" aria-expanded="false" aria-controls="SepBpjs" id="TampilkanDetailSep">
                                                                        <dt>3.1 SEP</dt>
                                                                    </a>
                                                                </h3>
                                                            </div>
                                                        </div>
                                                        <div id="SepBpjs" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading3_1">
                                                            <div class="accordion-content accordion-desc">
                                                                <p id="MenampilkanDetailSep">
                                                                    Detail SEP Bpjs Disini
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-panel">
                                                            <div class="accordion-heading" role="tab" id="heading3_3">
                                                                <h3 class="card-title accordion-title">
                                                                    <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#sep_internal" aria-expanded="false" aria-controls="sep_internal">
                                                                        <dt>3.2 SEP Internal</dt>
                                                                    </a>
                                                                </h3>
                                                            </div>
                                                        </div>
                                                        <div id="sep_internal" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading3_3">
                                                            <div class="accordion-content accordion-desc">
                                                                <p>
                                                                    Detail SEP Internal Disini
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-panel">
                                                            <div class="accordion-heading" role="tab" id="heading3_2">
                                                                <h3 class="card-title accordion-title">
                                                                    <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#RujukanBpjs" aria-expanded="false" aria-controls="RujukanBpjs">
                                                                        <dt>3.3 Rujukan</dt>
                                                                    </a>
                                                                </h3>
                                                            </div>
                                                        </div>
                                                        <div id="RujukanBpjs" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading3_2">
                                                            <div class="accordion-content accordion-desc">
                                                                <p>
                                                                    Detail Rujukan Disini
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-panel">
                                                            <div class="accordion-heading" role="tab" id="heading3_3">
                                                                <h3 class="card-title accordion-title">
                                                                    <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#SpriSkdp" aria-expanded="false" aria-controls="SpriSkdp">
                                                                        <dt>3.4 SPRI/Surat Kontrol</dt>
                                                                    </a>
                                                                </h3>
                                                            </div>
                                                        </div>
                                                        <div id="SpriSkdp" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading3_3">
                                                            <div class="accordion-content accordion-desc">
                                                                <p>
                                                                    Detail SPRI/Surat Kontrol Disini
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-panel">
                                                            <div class="accordion-heading" role="tab" id="heading3_3">
                                                                <h3 class="card-title accordion-title">
                                                                    <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#Aproval" aria-expanded="false" aria-controls="Aproval">
                                                                        <dt>3.5 Aproval</dt>
                                                                    </a>
                                                                </h3>
                                                            </div>
                                                        </div>
                                                        <div id="Aproval" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading3_3">
                                                            <div class="accordion-content accordion-desc">
                                                                <p>
                                                                    Detail Aproval Disini
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-panel">
                                                            <div class="accordion-heading" role="tab" id="heading3_6">
                                                                <h3 class="card-title accordion-title">
                                                                    <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#Lpk" aria-expanded="false" aria-controls="Lpk">
                                                                        <dt>3.6 Lembar Pengajuan Klaim (LPK)</dt>
                                                                    </a>
                                                                </h3>
                                                            </div>
                                                        </div>
                                                        <div id="Lpk" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading3_6">
                                                            <div class="accordion-content accordion-desc">
                                                                <p>
                                                                    Detail Lembar Pengajuan Klaim (LPK) Disini
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-panel">
                                                            <div class="accordion-heading" role="tab" id="heading3_3">
                                                                <h3 class="card-title accordion-title">
                                                                    <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#Aproval" aria-expanded="false" aria-controls="Aproval">
                                                                        <dt>3.7 Program Rujuk Balik (PRB)</dt>
                                                                    </a>
                                                                </h3>
                                                            </div>
                                                        </div>
                                                        <div id="Aproval" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading3_3">
                                                            <div class="accordion-content accordion-desc">
                                                                <p>
                                                                    Detail Program Rujuk Balik (PRB) Disini
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-panel">
                                                            <div class="accordion-heading" role="tab" id="heading3_4">
                                                                <h3 class="card-title accordion-title">
                                                                    <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#Icare" aria-expanded="false" aria-controls="Icare">
                                                                        <dt>3.8 iCare</dt>
                                                                    </a>
                                                                </h3>
                                                            </div>
                                                        </div>
                                                        <div id="Icare" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading3_4">
                                                            <div class="accordion-content accordion-desc">
                                                                <form action="javascript:void(0);" id="ProsesBukaIcare">
                                                                    <div class="row mb-3">
                                                                        <div class="col-md-4">
                                                                            <label for="nomor_kartu">Nomor Kartu</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="text" name="nomor_kartu" id="nomor_kartu" class="form-control" value="<?php echo $no_bpjs; ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-3">
                                                                        <div class="col-md-4">
                                                                            <label for="kode_dokter">Kode Dokter</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="text" name="kode_dokter" id="kode_dokter" class="form-control" value="<?php echo $kode_dokter; ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-3">
                                                                        <div class="col-md-12">
                                                                            <button type="submit" class="btn btn-sm btn-block btn-primary" id="ButtonIcare">
                                                                                <i class="ti ti-reload"></i> Generate Link
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-3">
                                                                        <div class="col-md-12" id="MenampilkanDataIcare">
                                                                            <!-- Data i care Disini -->
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="accordion-panel">
                                                <div class=" accordion-heading" role="tab" id="heading6">
                                                    <h3 class="card-title accordion-title">
                                                        <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#GeneralConsent" aria-expanded="false" aria-controls="GeneralConsent">
                                                            <dt>4. Persetujuan Umum <i>(General Consent)</i> <?php if(!empty($CheckGeneralConsent)){echo '<span class="badge badge-success"><i class="ti ti-check"></i></span>';} ?></dt>
                                                        </a>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div id="GeneralConsent" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading6">
                                                <div class="accordion-content accordion-desc">
                                                    <div class="row mb-3">
                                                        <div class="col-md-12">
                                                            Untuk menjaga validitas data, maka setiap lembar <i>general consent </i>
                                                            hanya berlaku untuk 1 (satu) data kunjungan.
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-12" id="ListGeneralConsent">
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-panel">
                                                <div class=" accordion-heading" role="tab" id="heading4">
                                                    <h3 class="card-title accordion-title">
                                                        <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#PemeriksaanDasar" aria-expanded="false" aria-controls="PemeriksaanDasar">
                                                            <dt>5. Pemeriksaan Dasar (Asesmen Awal) <?php if(!empty($CheckPemeriksaanDasar)){echo '<span class="badge badge-inverse-primary">'.$CheckPemeriksaanDasar.'</span>';} ?></dt>
                                                        </a>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div id="PemeriksaanDasar" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading4">
                                                <div class="accordion-content accordion-desc">
                                                    <div class="accordion-panel">
                                                        <div class=" accordion-heading" role="tab" id="heading5">
                                                            <h3 class="card-title accordion-title">
                                                                <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#TriaseDanIgd" aria-expanded="false" aria-controls="TriaseDanIgd">
                                                                    <dt>5.1. Triase dan Gawat Darurat <?php if(!empty($CheckTreaseIgd)){echo '<span class="badge badge-success"><i class="ti ti-check"></i></span>';} ?></dt>
                                                                </a>
                                                            </h3>
                                                        </div>
                                                    </div>
                                                    <div id="TriaseDanIgd" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading5">
                                                        <div class="accordion-content accordion-desc">
                                                            <div class="row">
                                                                <div class="col-md-12" id="DetailTriaseDanIgd">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-panel">
                                                        <div class=" accordion-heading" role="tab" id="heading5">
                                                            <h3 class="card-title accordion-title">
                                                                <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#Anamnesa" aria-expanded="false" aria-controls="Anamnesa">
                                                                    <dt>5.2. Anamnesis <?php if(!empty($CheckAnamnesis)){echo '<span class="badge badge-success"><i class="ti ti-check"></i></span>';} ?></dt>
                                                                </a>
                                                            </h3>
                                                        </div>
                                                    </div>
                                                    <div id="Anamnesa" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading5">
                                                        <div class="accordion-content accordion-desc">
                                                            <div class="row mb-3">
                                                                <div class="col-md-12" id="DetailAnamnesis">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-panel">
                                                        <div class=" accordion-heading" role="tab" id="heading52">
                                                            <h3 class="card-title accordion-title">
                                                                <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#PemeriksaanFisik" aria-expanded="false" aria-controls="PemeriksaanFisik">
                                                                    <dt>5.3. Pemeriksaan Fisik <?php if(!empty($CheckPemeriksaanFisik)){echo '<span class="badge badge-success"><i class="ti ti-check"></i></span>';} ?></dt>
                                                                </a>
                                                            </h3>
                                                        </div>
                                                    </div>
                                                    <div id="PemeriksaanFisik" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading52">
                                                        <div class="accordion-content accordion-desc">
                                                            <div class="row">
                                                                <div class="col-md-12" id="DetailPemeriksaanDasar">
                                                                    <!-- Detail Pemeriksaan Fisik/Dasar -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-panel">
                                                        <div class=" accordion-heading" role="tab" id="heading5">
                                                            <h3 class="card-title accordion-title">
                                                                <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#Pses" aria-expanded="false" aria-controls="Pses">
                                                                    <dt>5.4. Pemeriksaan Psikologis, Sosial Ekonomi Dan Spiritual <?php if(!empty($CheckPsikosos)){echo '<span class="badge badge-success"><i class="ti ti-check"></i></span>';} ?></dt>
                                                                </a>
                                                            </h3>
                                                        </div>
                                                    </div>
                                                    <div id="Pses" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading5">
                                                        <div class="accordion-content accordion-desc">
                                                            <div class="row">
                                                                <div class="col-md-12" id="DetailPsikosos">
                                                                    <!-- Detail Psikologis, Sosial dan Spriritual -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-panel">
                                                        <div class=" accordion-heading" role="tab" id="heading5">
                                                            <h3 class="card-title accordion-title">
                                                                <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#Screening" aria-expanded="false" aria-controls="Screening">
                                                                    <dt>5.5. Screening <?php if(!empty($CheckScreening)){echo '<span class="badge badge-success"><i class="ti ti-check"></i></span>';} ?></dt>
                                                                </a>
                                                            </h3>
                                                        </div>
                                                    </div>
                                                    <div id="Screening" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading5">
                                                        <div class="accordion-content accordion-desc">
                                                            <div class="row">
                                                                <div class="col-md-12" id="DetailScreening">
                                                                    <!-- Detail Screening -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-panel">
                                                <div class=" accordion-heading" role="tab" id="heading6">
                                                    <h3 class="card-title accordion-title">
                                                        <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#Diagnosa" aria-expanded="false" aria-controls="Diagnosa">
                                                            <dt>6. Diagnosa <?php if(!empty($CheckDiagnosa)){echo '<span class="badge badge-success"><i class="ti ti-check"></i></span>';} ?></dt>
                                                        </a>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div id="Diagnosa" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading6">
                                                <div class="accordion-content accordion-desc">
                                                    <div class="row">
                                                        <div class="col-md-12" id="DetailDiagnosa">
                                                            <!-- Detail Diagnosa -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-panel">
                                                <div class=" accordion-heading" role="tab" id="heading6">
                                                    <h3 class="card-title accordion-title">
                                                        <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#Procedur" aria-expanded="false" aria-controls="Procedur">
                                                            <dt>7. Terapi/Tindakan <?php if(!empty($CheckTerapiDanTindakan)){echo '<span class="badge badge-inverse-primary">'.$CheckTerapiDanTindakan.'</span>';} ?></dt>
                                                        </a>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div id="Procedur" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading6">
                                                <div class="accordion-content accordion-desc">
                                                    <div class="accordion-panel">
                                                        <div class=" accordion-heading" role="tab" id="heading6">
                                                            <h3 class="card-title accordion-title">
                                                                <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#PersetujuanTindakan" aria-expanded="false" aria-controls="PersetujuanTindakan" id="TampilkanPersetujuanTindakan">
                                                                    <dt>7.1. Persetujuan/Penolakan Tindakan <?php if(!empty($CheckPersetujuanTindakan)){echo '<span class="badge badge-success"><i class="ti ti-check"></i></span>';} ?></dt>
                                                                </a>
                                                            </h3>
                                                        </div>
                                                    </div>
                                                    <div id="PersetujuanTindakan" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading6">
                                                        <div class="accordion-content accordion-desc">
                                                            <div class="row">
                                                                <div class="col-md-12" id="DetailPersetujuanTindakan">
                                                                    <!-- Detail Persetujuan Tindakan -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-panel">
                                                        <div class=" accordion-heading" role="tab" id="heading6">
                                                            <h3 class="card-title accordion-title">
                                                                <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#Tindakan" aria-expanded="false" aria-controls="Tindakan" id="TampilkanTindakan">
                                                                    <dt>7.2. Tindakan <?php if(!empty($CheckTindakan)){echo '<span class="badge badge-success"><i class="ti ti-check"></i></span>';} ?></dt>
                                                                </a>
                                                            </h3>
                                                        </div>
                                                    </div>
                                                    <div id="Tindakan" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading6">
                                                        <div class="accordion-content accordion-desc">
                                                            <div class="row">
                                                                <div class="col-md-12" id="DetailTindakan">
                                                                    <!-- Detail Tindakan -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-panel">
                                                        <div class=" accordion-heading" role="tab" id="heading9">
                                                            <h3 class="card-title accordion-title">
                                                                <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#ResepObat" aria-expanded="false" aria-controls="ResepObat" id="TampilkanResep">
                                                                    <dt>7.3. Resep Obat <?php if(!empty($CheckResepObat)){echo '<span class="badge badge-success"><i class="ti ti-check"></i></span>';} ?></dt>
                                                                </a>
                                                            </h3>
                                                        </div>
                                                    </div>
                                                    <div id="ResepObat" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading9">
                                                        <div class="accordion-content accordion-desc">
                                                            <div class="row">
                                                                <div class="col-md-12" id="DetailResep">
                                                                    <!-- Detail Tindakan -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-panel">
                                                        <div class=" accordion-heading" role="tab" id="heading5">
                                                            <h3 class="card-title accordion-title">
                                                                <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#RiwayatPenggunaanObat" aria-expanded="false" aria-controls="RiwayatPenggunaanObat" id="TampilkanRiwayatObat">
                                                                    <dt>7.4. Riwayat Penggunaan Obat <?php if(!empty($CheckRiwayatPenggunaanObat)){echo '<span class="badge badge-success"><i class="ti ti-check"></i></span>';} ?></dt>
                                                                </a>
                                                            </h3>
                                                        </div>
                                                    </div>
                                                    <div id="RiwayatPenggunaanObat" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading5">
                                                        <div class="accordion-content accordion-desc">
                                                            <p id="DetailRiwayatObat">
                                                                Riwayat Penggunaan Obat Disini
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-panel">
                                                <div class=" accordion-heading" role="tab" id="heading6">
                                                    <h3 class="card-title accordion-title">
                                                        <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#Penunjang" aria-expanded="false" aria-controls="Penunjang">
                                                            <dt>8. Penunjang <?php if(!empty($CheckPenunjang)){echo '<span class="badge badge-inverse-primary">'.$CheckPenunjang.'</span>';} ?></dt>
                                                        </a>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div id="Penunjang" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading6">
                                                <div class="accordion-content accordion-desc">
                                                    <div class="accordion-panel">
                                                        <div class=" accordion-heading" role="tab" id="heading6">
                                                            <h3 class="card-title accordion-title">
                                                                <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#Laboratorium" aria-expanded="false" aria-controls="Laboratorium" id="TampilkanDetailLaboratorium">
                                                                    <dt>8.1. Laboratorium <?php if(!empty($CheckLaboratorium)){echo '<span class="badge badge-success"><i class="ti ti-check"></i></span>';} ?></dt>
                                                                </a>
                                                            </h3>
                                                        </div>
                                                    </div>
                                                    <div id="Laboratorium" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading6">
                                                        <div class="accordion-content accordion-desc">
                                                            <p id="MenampilkanDetailLaboratorium">
                                                                Menampilkan Laboratorium disini
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-panel">
                                                        <div class=" accordion-heading" role="tab" id="heading6">
                                                            <h3 class="card-title accordion-title">
                                                                <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#Radiologi" aria-expanded="false" aria-controls="Radiologi" id="TampilkanDetailRadiologi">
                                                                    <dt>8.2. Radiologi <?php if(!empty($CheckRadiologi)){echo '<span class="badge badge-success"><i class="ti ti-check"></i></span>';} ?></dt>
                                                                </a>
                                                            </h3>
                                                        </div>
                                                    </div>
                                                    <div id="Radiologi" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading6">
                                                        <div class="accordion-content accordion-desc">
                                                            <p id="MenampilkanDetailRadiologi">
                                                                Menampilkan Radiologi disini
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-panel">
                                                <div class=" accordion-heading" role="tab" id="heading5">
                                                    <h3 class="card-title accordion-title">
                                                        <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#PerencanaanPasien" aria-expanded="false" aria-controls="PerencanaanPasien" id="TampilkanPerencanaanPasien">
                                                            <dt>9. Perencanaan Pasien <?php if(!empty($CheckPerencanaanPasien)){echo '<span class="badge badge-success"><i class="ti ti-check"></i></span>';} ?></dt>
                                                        </a>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div id="PerencanaanPasien" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading5">
                                                <div class="accordion-content accordion-desc">
                                                    <div class="row">
                                                        <div class="col-md-12" id="DetailPerencanaanPasien">
                                                            <!-- Detail Perencanaan Pasien -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-panel">
                                                <div class=" accordion-heading" role="tab" id="heading7">
                                                    <h3 class="card-title accordion-title">
                                                        <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#CPPT" aria-expanded="false" aria-controls="CPPT" id="TampilkanCCPT">
                                                            <dt>10. CPPT  <?php if(!empty($CheckCcpt)){echo '<span class="badge badge-success"><i class="ti ti-check"></i></span>';} ?></dt>
                                                        </a>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div id="CPPT" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading7">
                                                <div class="accordion-content accordion-desc" id="DetailCCPT">
                                                    <p>
                                                        Menampilkan CPPT disini
                                                    </p>
                                                </div>
                                            </div>
                                            
                                            <div class="accordion-panel">
                                                <div class=" accordion-heading" role="tab" id="heading10">
                                                    <h3 class="card-title accordion-title">
                                                        <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#Konsultasi" aria-expanded="false" aria-controls="Konsultasi" id="TampilkanKonsultasi">
                                                            <dt>11. Konsultasi <?php if(!empty($CheckKonsultasi)){echo '<span class="badge badge-success"><i class="ti ti-check"></i></span>';} ?></dt>
                                                        </a>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div id="Konsultasi" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading10">
                                                <div class="accordion-content accordion-desc" id="DetailKonsultasi">
                                                    <p>
                                                        Menampilkan Konsultasi disini
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="accordion-panel">
                                                <div class=" accordion-heading" role="tab" id="heading10">
                                                    <h3 class="card-title accordion-title">
                                                        <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#Edukasi" aria-expanded="false" aria-controls="Edukasi" id="TampilkanEdukasi">
                                                            <dt>12. Edukasi <?php if(!empty($CheckEdukasi)){echo '<span class="badge badge-success"><i class="ti ti-check"></i></span>';} ?></dt>
                                                        </a>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div id="Edukasi" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading10">
                                                <div class="accordion-content accordion-desc" id="DetailEdukasi">
                                                    <p>
                                                        Menampilkan Edukasi disini
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="accordion-panel">
                                                <div class=" accordion-heading" role="tab" id="heading11">
                                                    <h3 class="card-title accordion-title">
                                                        <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#Operasi" aria-expanded="false" aria-controls="Operasi" id="TampilkanOperasi">
                                                            <dt>13. Operasi <?php if(!empty($CheckOperasi)){echo '<span class="badge badge-success"><i class="ti ti-check"></i></span>';} ?></dt>
                                                        </a>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div id="Operasi" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading11">
                                                <div class="accordion-content accordion-desc">
                                                    <p id="MenampilkanOperasi">
                                                        Menampilkan Operasi disini
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="accordion-panel">
                                                <div class=" accordion-heading" role="tab" id="heading11">
                                                    <h3 class="card-title accordion-title">
                                                        <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#ResumePulang" aria-expanded="false" aria-controls="ResumePulang" id="TampilkanResume">
                                                            <dt>14. Resume <?php if(!empty($CehckResume)){echo '<span class="badge badge-success"><i class="ti ti-check"></i></span>';} ?></dt>
                                                        </a>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div id="ResumePulang" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading11">
                                                <div class="accordion-content accordion-desc">
                                                    <p id="MenampilkanDetailResume">
                                                        Menampilkan Resume disini
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>