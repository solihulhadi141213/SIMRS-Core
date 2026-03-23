<?php
    date_default_timezone_set('UTC');
    include "../../_Config/Connection.php";
    include "../../_Config/SettingBridging.php";
    include "../../_Config/SimrsFunction.php";
    include "../../vendor/autoload.php";
    if(empty($_POST['PeriodeAwal'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">Periode Awal Pencarian Belum Diisi!</div>';
        echo '</div>';
    }else{
        if(empty($_POST['PeriodeAkhir'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center text-danger">Periode Akhir Pencarian Belum Diisi!</div>';
            echo '</div>';
        }else{
            if(empty($_POST['JenisPelayanan'])){
                echo '<div class="row">';
                echo '  <div class="col-md-12 text-center text-danger">Periode Akhir Pencarian Belum Diisi!</div>';
                echo '</div>';
            }else{
                if(empty($_POST['StatusKlaim'])){
                    echo '<div class="row">';
                    echo '  <div class="col-md-12 text-center text-danger">Status Klaim Pencarian Belum Diisi!</div>';
                    echo '</div>';
                }else{
                    $PeriodeAwal=$_POST['PeriodeAwal'];
                    $PeriodeAkhir=$_POST['PeriodeAkhir'];
                    $JenisPelayanan=$_POST['JenisPelayanan'];
                    $StatusKlaim=$_POST['StatusKlaim'];
                    $timestamp_awal = strtotime($PeriodeAwal);
                    $timestamp_akhir = strtotime($PeriodeAkhir);
                    if($timestamp_akhir<=$timestamp_awal){
                        echo '<div class="row">';
                        echo '  <div class="col-md-12 text-center text-danger">Periode Data Pencarian Tidak Valid!</div>';
                        echo '</div>';
                    }else{
                        $no=1;
                        for ($current_timestamp = $timestamp_awal; $current_timestamp <= $timestamp_akhir; $current_timestamp += 86400) {
                            $tanggal_perulangan = date('Y-m-d', $current_timestamp);
                            $LabelTanggal = date('d/m/Y', $current_timestamp);
    ?>
                        <div class="accordion-panel">
                            <div class="accordion-heading" role="tab" id="HeadingKlaim<?php echo $no;?>">
                                <h3 class="card-title accordion-title">
                                    <a class="accordion-msg waves-effect waves-dark scale_active collapsed" data-toggle="collapse" data-parent="#accordionKlaim" href="#CollapseKlaim<?php echo $no;?>" aria-expanded="false" aria-controls="CollapseKlaim<?php echo $no;?>">
                                        <dt><?php echo "$no. Tanggal $LabelTanggal";?> <span id="PutJumlah<?php echo $no;?>"></span></dt>
                                    </a>
                                </h3>
                            </div>
                            <div id="CollapseKlaim<?php echo $no;?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="HeadingKlaim<?php echo $no;?>">
                                <div class="accordion-content accordion-desc">
                                    <?php
                                        $url="$url_vclaim/Monitoring/Klaim/Tanggal/$tanggal_perulangan/JnsPelayanan/$JenisPelayanan/Status/$StatusKlaim";
                                        $ResponseKunjunganRanap=BridgingServiceGet($consid,$secret_key,$user_key,$url);
                                        $ResponseKunjunganRanapJson =json_decode($ResponseKunjunganRanap, true);
                                        if(empty($ResponseKunjunganRanapJson['metaData']['code'])){
                                            echo '<div class="row">';
                                            echo '  <div class="col-md-12 text-center">';
                                            echo '      <span class="text-danger">Tidak Ada Response Dari Service BPJS!</span>';
                                            echo '  </div>';
                                            echo '</div>';
                                        }else{
                                            $ResponseCode=$ResponseKunjunganRanapJson['metaData']['code'];
                                            if($ResponseCode!=="200"){
                                                echo '<div class="row">';
                                                echo '  <div class="col-md-12 text-center">';
                                                echo '      <span class="text-danger">Pesan: '.$ResponseKunjunganRanapJson['metaData']['message'].'</span>';
                                                echo '  </div>';
                                                echo '</div>';
                                            }else{
                                                if(empty($ResponseKunjunganRanapJson['response'])){
                                                    echo '<div class="row">';
                                                    echo '  <div class="col-md-12 text-center">';
                                                    echo '      <dt class="text-danger">Terjadi Kesalahan Pada Response</dt>';
                                                    echo '      <span class="text-danger">Pesan: '.$ResponseKunjunganRanapJson['metaData']['message'].'</span>';
                                                    echo '  </div>';
                                                    echo '</div>';
                                                }else{
                                                    $string=$ResponseKunjunganRanapJson['response'];
                                                    $stringData =json_decode($string, true);
                                                    $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                                                    $key="$consid$secret_key$timestamp";
                                                    //--masukan ke fungsi
                                                    $FileDeskripsi=stringDecrypt("$key", "$string");
                                                    $FileDekompresi=decompress("$FileDeskripsi");
                                                    //--konveris json to raw
                                                    $JsonData =json_decode($FileDekompresi, true);
                                                    if(empty($JsonData['klaim'])){
                                                        echo '<div class="row">';
                                                        echo '  <div class="col-md-12 text-center">';
                                                        echo '      <dt class="text-danger">Terjadi Kesalahan Saat Deskripsi Data</dt>';
                                                        echo '  </div>';
                                                        echo '</div>';
                                                    }else{
                                                        $ListKlaim=$JsonData['klaim'];
                                                        echo '<div class="row">';
                                                        echo '  <div class="col-md-12 table table-responsive">';
                                                        echo '      <table class="table table-bordered table-hover">';
                                                        echo '          <thead>';
                                                        echo '              <tr>';
                                                        echo '                  <th class="text-center"><dt>No</dt></th>';
                                                        echo '                  <th class="text-center"><dt>Pasien</dt></th>';
                                                        echo '                  <th class="text-center"><dt>Kunjungan</dt></th>';
                                                        echo '                  <th class="text-center"><dt>Keterangan</dt></th>';
                                                        echo '                  <th class="text-center"><dt>Biaya</dt></th>';
                                                        echo '              </tr>';
                                                        echo '          </thead>';
                                                        echo '          <tbody>';
                                                        $no2=1;
                                                        $JumlahListKlaim=count($ListKlaim);
                                                        foreach($ListKlaim as $ListDataShow){
                                                            $NamaPasien=$ListDataShow['peserta']['nama'];
                                                            $NomorKartuPasien=$ListDataShow['peserta']['noKartu'];
                                                            $NomorRm=$ListDataShow['peserta']['noMR'];
                                                            $SepPasien=$ListDataShow['noSEP'];
                                                            $noFPK=$ListDataShow['noFPK'];
                                                            $SetLabel=$ListDataShow['status'];
                                                            $tglPlgSep=$ListDataShow['tglPulang'];
                                                            $tglSep=$ListDataShow['tglSep'];
                                                            $poli=$ListDataShow['poli'];
                                                            $kelasRawat=$ListDataShow['kelasRawat'];
                                                            //INACBG
                                                            $kodeInacbg=$ListDataShow['Inacbg']['kode'];
                                                            $namaInacbg=$ListDataShow['Inacbg']['nama'];
                                                            //Biaya
                                                            $byPengajuan=$ListDataShow['biaya']['byPengajuan'];
                                                            $bySetujui=$ListDataShow['biaya']['bySetujui'];
                                                            $byTarifGruper=$ListDataShow['biaya']['byTarifGruper'];
                                                            $byTarifRS=$ListDataShow['biaya']['byTarifRS'];
                                                            $byTopup=$ListDataShow['biaya']['byTopup'];
                                                            //Format Rupiah
                                                            $byPengajuan = number_format($byPengajuan, 0, ',', '.');
                                                            $bySetujui = number_format($bySetujui, 0, ',', '.');
                                                            $byTarifGruper = number_format($byTarifGruper, 0, ',', '.');
                                                            $byTarifRS = number_format($byTarifRS, 0, ',', '.');
                                                            $byTopup = number_format($byTopup, 0, ',', '.');
                                                            //Format Tanggal
                                                            $strtotime1=strtotime($tglPlgSep);
                                                            $strtotime2=strtotime($tglSep);
                                                            $tglPlgSep=date('d/m/Y',$strtotime1);
                                                            $tglSep=date('d/m/Y',$strtotime2);
                                                            //Cek Data Kunjungan Pasien
                                                            $id_kunjungan=getDataDetail($Conn,"kunjungan_utama",'sep',$SepPasien,'id_kunjungan');
                                                            if(empty($id_kunjungan)){
                                                                $LabelIdKunjungan='<span class="text-danger">Belum Terdaftar</span>';
                                                                $LabelIdPasien='<span class="text-danger">None</span>';
                                                            }else{
                                                                $id_pasien=getDataDetail($Conn,"kunjungan_utama",'no_bpjs',$NomorKartuPasien,'id_pasien');
                                                                $LabelIdKunjungan='<span class="text-muted">ID.REG.'.$id_kunjungan.'</span>';
                                                                $LabelIdPasien='<span class="text-muted">No.RM.'.$id_pasien.'</span>';
                                                            }
                                                            echo '<tr>';
                                                            echo '  <td class="text-center">'.$no2.'</td>';
                                                            echo '  <td class="text-left">';
                                                            echo '      <a href="javascript:void(0);" data-toggle="modal" data-target="#ModalDetailSep" data-id="'.$SepPasien.'" class="text-primary"><i class="ti ti-user"></i> '.$NamaPasien.'</a><br>';
                                                            echo '      <small class="text-muted m-b-0" title="Nomor kartu">Kartu :'.$NomorKartuPasien.'</small><br>';
                                                            echo '      <small class="text-muted m-b-0" title="Nomor SEP">SEP : '.$SepPasien.'</small><br>';
                                                            echo '      <small class="text-muted m-b-0" title="Nomor FKP">FKP : '.$noFPK.'</small>';
                                                            echo '  </td>';
                                                            echo '  <td class="text-left">';
                                                            echo '      <small class="text-muted m-b-0" title="Poliklinik">Poli : '.$poli.'</small><br>';
                                                            echo '      <small class="text-muted m-b-0" title="Kelas Rawat">Kelas: '.$kelasRawat.'</small><br>';
                                                            echo '      <small class="text-muted m-b-0" title="Tanggal SEP">Tgl.SEP : '.$tglSep.'</small><br>';
                                                            echo '      <small class="text-muted m-b-0" title="Tanggal Pulang SEP">Tgl.Plng :'.$tglPlgSep.'</small><br>';
                                                            echo '  </td>';
                                                            echo '  <td class="text-left">';
                                                            echo '      <small class="text-muted m-b-0" title="'.$namaInacbg.'">INACBG: '.$kodeInacbg.'</small><br>';
                                                            echo '      <small class="text-muted m-b-0" title="Nomor RM">No.RM : '.$NomorRm.'</small><br>';
                                                            echo '      <small class="text-muted m-b-0" title="Status Klaim">Status : '.$SetLabel.'</small><br>';
                                                            echo '  </td>';
                                                            echo '  <td class="text-left">';
                                                            echo '      <small class="text-muted m-b-0" title="Disetujui">Pengajuan : '.$byPengajuan.'</small><br>';
                                                            echo '      <small class="text-muted m-b-0" title="Disetujui">Disetujui : '.$bySetujui.'</small><br>';
                                                            echo '      <small class="text-muted m-b-0" title="Grouper">Grouper : '.$byTarifGruper.'</small><br>';
                                                            echo '      <small class="text-muted m-b-0" title="RS">RS : '.$byTarifRS.'</small><br>';
                                                            echo '  </td>';
                                                            echo '</tr>';
                                                            $no2++;
                                                        }
                                                        echo '<input type="hidden" id="GetCount'.$no.'" value="'.$JumlahListKlaim.'">';
                                                        echo '          </tbody>';
                                                        echo '      </table>';
                                                        echo '  </div>';
                                                        echo '</div>';
    ?>
        <script>
            var JumlahListKlaim = $('#GetCount<?php echo ''.$no.''; ?>').val();
            if(JumlahListKlaim==""){
                $('#PutJumlah<?php echo ''.$no.''; ?>').html('<span class="badge badge-danger">0</span>');
            }
            if(JumlahListKlaim!==""){
                $('#PutJumlah<?php echo ''.$no.''; ?>').html('<span class="badge badge-success">'+JumlahListKlaim+'</span>');
            }
            
        </script>
    <?php
                                                    }
                                                }
                                            }
                                        } 
    ?>
                                </div>
                            </div>
                        </div>
<?php
                            $no++;
                        }
                    }
                }
            }
        }
    }
?>