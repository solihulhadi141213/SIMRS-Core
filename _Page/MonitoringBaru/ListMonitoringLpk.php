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
                $PeriodeAwal=$_POST['PeriodeAwal'];
                $PeriodeAkhir=$_POST['PeriodeAkhir'];
                $JenisPelayanan=$_POST['JenisPelayanan'];
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
                                    $url="$url_vclaim//LPK/TglMasuk/$tanggal_perulangan/JnsPelayanan/$JenisPelayanan";
                                    $ResponseLpk=BridgingServiceGet($consid,$secret_key,$user_key,$url);
                                    $ResponseLpkJson =json_decode($ResponseLpk, true);
                                    if(empty($ResponseLpkJson['metaData']['code'])){
                                        echo '<div class="row">';
                                        echo '  <div class="col-md-12 text-center">';
                                        echo '      <span class="text-danger">Tidak Ada Response Dari Service BPJS!</span>';
                                        echo '  </div>';
                                        echo '</div>';
                                    }else{
                                        $ResponseCode=$ResponseLpkJson['metaData']['code'];
                                        if($ResponseCode!=="200"){
                                            echo '<div class="row">';
                                            echo '  <div class="col-md-12 text-center">';
                                            echo '      <span class="text-danger">Pesan: '.$ResponseLpkJson['metaData']['message'].'</span>';
                                            echo '  </div>';
                                            echo '</div>';
                                        }else{
                                            if(empty($ResponseLpkJson['response'])){
                                                echo '<div class="row">';
                                                echo '  <div class="col-md-12 text-center">';
                                                echo '      <dt class="text-danger">Terjadi Kesalahan Pada Response</dt>';
                                                echo '      <span class="text-danger">Pesan: '.$ResponseLpkJson['metaData']['message'].'</span>';
                                                echo '  </div>';
                                                echo '</div>';
                                            }else{
                                                $string=$ResponseLpkJson['response'];
                                                $stringData =json_decode($string, true);
                                                $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                                                $key="$consid$secret_key$timestamp";
                                                //--masukan ke fungsi
                                                $FileDeskripsi=stringDecrypt("$key", "$string");
                                                $FileDekompresi=decompress("$FileDeskripsi");
                                                //--konveris json to raw
                                                $JsonData =json_decode($FileDekompresi, true);
                                                if(empty($JsonData['lpk'])){
                                                    echo '<div class="row">';
                                                    echo '  <div class="col-md-12 text-center">';
                                                    echo '      <dt class="text-danger">Terjadi Kesalahan Saat Deskripsi Data</dt>';
                                                    echo '  </div>';
                                                    echo '</div>';
                                                }else{
                                                    if(empty($JsonData['lpk']['list'])){
                                                        echo '<div class="row">';
                                                        echo '  <div class="col-md-12 text-center">';
                                                        echo '      <dt class="text-danger">Terjadi Kesalahan Saat Deskripsi Data</dt>';
                                                        echo '  </div>';
                                                        echo '</div>';
                                                    }else{
                                                        $ListLpk=$JsonData['lpk']['list'];
                                                        echo '<div class="row">';
                                                        echo '  <div class="col-md-12 table table-responsive">';
                                                        echo '      <table class="table table-bordered table-hover">';
                                                        echo '          <thead>';
                                                        echo '              <tr>';
                                                        echo '                  <th class="text-center"><dt>No</dt></th>';
                                                        echo '                  <th class="text-center"><dt>Pasien</dt></th>';
                                                        echo '                  <th class="text-center"><dt>Kunjungan</dt></th>';
                                                        echo '                  <th class="text-center"><dt>Keterangan</dt></th>';
                                                        echo '              </tr>';
                                                        echo '          </thead>';
                                                        echo '          <tbody>';
                                                        $no2=1;
                                                        $JumlahListLpk=count($ListLpk);
                                                        foreach($ListLpk as $ListDataShow){
                                                            $noSep=$ListDataShow['noSep'];
                                                            $jnsPelayanan=$ListDataShow['jnsPelayanan'];
                                                            //Cek Data Kunjungan Pasien
                                                            $id_kunjungan=getDataDetail($Conn,"kunjungan_utama",'sep',$noSep,'id_kunjungan');
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
                                                        echo '<input type="hidden" id="GetCount'.$no.'" value="'.$JumlahListLpk.'">';
                                                        echo '          </tbody>';
                                                        echo '      </table>';
                                                        echo '  </div>';
                                                        echo '</div>';
?>
    <script>
        var JumlahListLpk = $('#GetCount<?php echo ''.$no.''; ?>').val();
        if(JumlahListLpk==""){
            $('#PutJumlah<?php echo ''.$no.''; ?>').html('<span class="badge badge-danger">0</span>');
        }
        if(JumlahListLpk!==""){
            $('#PutJumlah<?php echo ''.$no.''; ?>').html('<span class="badge badge-success">'+JumlahListLpk+'</span>');
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