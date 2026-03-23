<?php
    $url="$url_vclaim/Monitoring/Kunjungan/Tanggal/$tanggal_perulangan/JnsPelayanan/$JenisPelayanan";
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
                if(empty($JsonData['sep'])){
                    echo '<div class="row">';
                    echo '  <div class="col-md-12 text-center">';
                    echo '      <dt class="text-danger">Terjadi Kesalahan Saat Deskripsi Data</dt>';
                    echo '  </div>';
                    echo '</div>';
                }else{
                    $ListSep=$JsonData['sep'];
                    echo '<div class="row">';
                    echo '  <div class="col-md-12 table table-responsive">';
                    echo '      <table class="table table-bordered table-hover">';
                    echo '          <thead>';
                    echo '              <tr>';
                    echo '                  <th class="text-center"><dt>No</dt></th>';
                    echo '                  <th class="text-center"><dt>Pasien</dt></th>';
                    echo '                  <th class="text-center"><dt>Kunjungan</dt></th>';
                    echo '                  <th class="text-center"><dt>Keterangan</dt></th>';
                    echo '                  <th class="text-center"><dt>SIMRS</dt></th>';
                    echo '              </tr>';
                    echo '          </thead>';
                    echo '          <tbody>';
                    $no2=1;
                    $JumlahListSep=count($ListSep);
                    foreach($ListSep as $ListDataShow){
                        $NamaPasien=$ListDataShow['nama'];
                        $NomorKartuPasien=$ListDataShow['noKartu'];
                        $jnsPelayanan=$ListDataShow['jnsPelayanan'];
                        $diagnosa=$ListDataShow['diagnosa'];
                        if(empty($ListDataShow['noRujukan'])){
                            $LabelRujukan='<span class="text-danger">None</span>';
                        }else{
                            $noRujukan=$ListDataShow['noRujukan'];
                            $LabelRujukan='<span class="text-muted"><i class="ti-receipt"></i> '.$noRujukan.'</span>';
                        }
                        if(empty($ListDataShow['noSep'])){
                            $LabelNomorSep='<span class="text-danger">None</span>';
                        }else{
                            $SepPasien=$ListDataShow['noSep'];
                            $LabelNomorSep='<span class="text-muted"><i class="ti-receipt"></i> '.$SepPasien.'</span>';
                        }
                        if(empty($ListDataShow['kelasRawat'])){
                            $LabelKelasRawat='<span class="text-danger">None</span>';
                        }else{
                            $kelasRawat=$ListDataShow['kelasRawat'];
                            $LabelKelasRawat='<span class="text-muted"><i class="ti-star"></i> Kelas '.$kelasRawat.'</span>';
                        }
                        if(empty($ListDataShow['poli'])){
                            $LabelPoli='<span class="text-danger">None</span>';
                        }else{
                            $poli=$ListDataShow['poli'];
                            $LabelPoli='<span class="text-muted"><i class="ti-direction"></i> '.$poli.'</span>';
                        }
                        $tglPlgSep=$ListDataShow['tglPlgSep'];
                        $tglSep=$ListDataShow['tglSep'];
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
                        echo '      <small class="text-muted m-b-0" title="Nomor kartu"><i class="ti ti-credit-card"></i> '.$NomorKartuPasien.'</small><br>';
                        echo '      <small class="text-muted m-b-0" title="Nomor SEP">'.$LabelNomorSep.'</small><br>';
                        echo '  </td>';
                        echo '  <td class="text-left">';
                        echo '      <span class="Tujuan Kunjungan">'.$jnsPelayanan.'</span><br>';
                        echo '      <small class="text-muted m-b-0" title="Diagnosa"><i class="ti-search"></i> '.$diagnosa.'</small><br>';
                        echo '      <small class="text-muted m-b-0" title="Nomor Rujukan">'.$LabelRujukan.'</small><br>';
                        echo '  </td>';
                        echo '  <td class="text-left">';
                        echo '      <span class="Tanggal SEP"><i class="ti-calendar"></i> '.$tglSep.'</span><br>';
                        echo '      <small class="text-muted m-b-0" title="Tanggal SEP Pulang">'.$tglPlgSep.'</small><br>';
                        echo '  </td>';
                        echo '  <td class="text-left">';
                        echo '      <span class="ID Kunjungan">'.$LabelIdKunjungan.'</span><br>';
                        echo '      <small class="text-muted m-b-0" title="Poliklinik">'.$LabelPoli.'</small><br>';
                        echo '      <small class="text-muted m-b-0" title="Kelas Rawat">'.$LabelKelasRawat.'</small><br>';
                        echo '  </td>';
                        echo '</tr>';
                        $no2++;
                    }
                    echo '<input type="hidden" id="GetCount'.$no.'" value="'.$JumlahListSep.'">';
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