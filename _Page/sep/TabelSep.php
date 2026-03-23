<?php
    date_default_timezone_set('UTC');
    include "../../_Config/Connection.php";
    include "../../_Config/SettingBridging.php";
    include "../../_Config/SimrsFunction.php";
    include "../../vendor/autoload.php";
?>
<div class="card-body">
    <div class="row">
        <div class="col-md-12 table table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th class="text-center"><dt>No</dt></th>
                        <th class="text-center"><dt>Tanggal</dt></th>
                        <th class="text-center"><dt>SEP</dt></th>
                        <th class="text-center"><dt>Pasien</dt></th>
                        <th class="text-center"><dt>Keterangan</dt></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        //menangkap data dari form
                        if(empty($_POST['tanggal_sep'])){
                            echo '<tr>';
                            echo '  <td class="text-center text-danger" colspan="5">Tanggal SEP Tidak Boleh Kosong!</td>';
                            echo '</tr>';
                        }else{
                            if(empty($_POST['jenis_pelayanan'])){
                                echo '<tr>';
                                echo '  <td class="text-center text-danger" colspan="5">Tanggal SEP Tidak Boleh Kosong!</td>';
                                echo '</tr>';
                            }else{
                                $TanggalSep=$_POST['tanggal_sep'];
                                $JenisPelayanan=$_POST['jenis_pelayanan'];
                                //Membuka Data Pada Service BPJS
                                $url="$url_vclaim/Monitoring/Kunjungan/Tanggal/$TanggalSep/JnsPelayanan/$JenisPelayanan";
                                $Kontent=BridgingServiceGet($consid,$secret_key,$user_key,$url);
                                if(empty($Kontent)){
                                    echo '<tr>';
                                    echo '  <td class="text-center text-danger" colspan="5">';
                                    echo '      Tidak ada response dari service BPJS';
                                    echo '  </td>';
                                    echo '</tr>';
                                    echo '<tr>';
                                    echo '  <td class="text-center text-danger" colspan="5">';
                                    echo '      URL: '.$url.'';
                                    echo '  </td>';
                                    echo '</tr>';
                                }else{
                                    //Decode Response
                                    $KontentJson =json_decode($Kontent, true);
                                    if($KontentJson['metaData']['code']!=="200"){
                                        echo '<tr>';
                                        echo '  <td class="text-center text-danger" colspan="5">';
                                        echo '      Terjadi kesalahan pada request data bridging';
                                        echo '  </td>';
                                        echo '</tr>';
                                        echo '<tr>';
                                        echo '  <td class="text-center text-danger" colspan="5">';
                                        echo '      Pesan: '.$KontentJson['metaData']['message'].'';
                                        echo '  </td>';
                                        echo '</tr>';
                                    }else{
                                        if(empty($KontentJson['response'])){
                                            echo '<tr>';
                                            echo '  <td class="text-center text-danger" colspan="5">';
                                            echo '      Proses berhasil namun tidak ada response dari service BPJS';
                                            echo '  </td>';
                                            echo '</tr>';
                                        }else{
                                            $string=$KontentJson['response'];
                                            //Encrypt
                                            $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                                            $key="$consid$secret_key$timestamp";
                                            //--masukan ke fungsi
                                            $FileDeskripsi=stringDecrypt("$key", "$string");
                                            $FileDekompresi=decompress("$FileDeskripsi");
                                            //--konveris json to raw
                                            $JsonData =json_decode($FileDekompresi, true);
                                            if(empty($JsonData['sep'])){
                                                echo '<tr>';
                                                echo '  <td class="text-center text-danger" colspan="5">';
                                                echo '      Proses berhasil namun data list gagal ditampilkan';
                                                echo '  </td>';
                                                echo '</tr>';
                                            }else{
                                                $no=1;
                                                foreach($JsonData['sep'] as $List){
                                                    if(!empty($List['diagnosa'])){
                                                        $diagnosa=$List['diagnosa'];
                                                    }else{
                                                        $diagnosa='<span class="text-danger">None</span>';
                                                    }
                                                    if(!empty($List['jnsPelayanan'])){
                                                        $jnsPelayanan=$List['jnsPelayanan'];
                                                    }else{
                                                        $jnsPelayanan='<span class="text-danger">None</span>';
                                                    }
                                                    if(!empty($List['kelasRawat'])){
                                                        $kelasRawat=$List['kelasRawat'];
                                                    }else{
                                                        $kelasRawat='<span class="text-danger">None</span>';
                                                    }
                                                    if(!empty($List['nama'])){
                                                        $nama=$List['nama'];
                                                    }else{
                                                        $nama='<span class="text-danger">None</span>';
                                                    }
                                                    if(!empty($List['noKartu'])){
                                                        $noKartu=$List['noKartu'];
                                                    }else{
                                                        $noKartu='<span class="text-danger">None</span>';
                                                    }
                                                    if(!empty($List['noSep'])){
                                                        $noSep=$List['noSep'];
                                                    }else{
                                                        $noSep='<span class="text-danger">None</span>';
                                                    }
                                                    if(!empty($List['noRujukan'])){
                                                        $noRujukan=$List['noRujukan'];
                                                    }else{
                                                        $noRujukan='<span class="text-danger">None</span>';
                                                    }
                                                    if(!empty($List['poli'])){
                                                        $poli=$List['poli'];
                                                    }else{
                                                        $poli='<span class="text-danger">None</span>';
                                                    }
                                                    if(!empty($List['tglPlgSep'])){
                                                        $tglPlgSep=$List['tglPlgSep'];
                                                        $strtotime=strtotime($tglPlgSep);
                                                        $tglPlgSep=date('d/m/Y', $strtotime);
                                                    }else{
                                                        $tglPlgSep='<span class="text-danger">None</span>';
                                                    }
                                                    if(!empty($List['tglSep'])){
                                                        $tglSep=$List['tglSep'];
                                                        $strtotime2=strtotime($tglSep);
                                                        $tglSep=date('d/m/Y', $strtotime2);
                                                    }else{
                                                        $tglSep='<span class="text-danger">None</span>';
                                                    }
                    ?>
                                        <tr tabindex="0" class="table-light" data-toggle="modal" data-target="#ModalDetailSep" data-id="<?php echo "$noSep";?>" onmousemove="this.style.cursor='pointer'">
                                            <td class="text-center"><?php echo "$no"; ?></td>
                                            <td>
                                                <?php 
                                                    echo '<small title="Tanggal SEP"><i class="icofont-ui-calendar"></i> '.$tglSep.'</small><br>';
                                                    echo '<small title="Tanggal Pulang"><i class="ti-back-left"></i> '.$tglPlgSep.'</small><br>';
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                                    echo '<small title="Nomor SEP"><i class="ti-file"></i> '.$noSep.'</small><br>';
                                                    echo '<small title="Nomor Rujukan"><i class="icofont-paper-plane"></i> '.$noRujukan.'</small><br>';
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                                    echo '<small title="Nama Pasien"><i class="ti-user"></i> '.$nama.'</small><br>';
                                                    echo '<small title="Nomor Kartu"><i class="ti-credit-card"></i> '.$noKartu.'</small><br>';
                                                    echo '<small title="Jenis Pelayanan"><i class="icofont-patient-file"></i> '.$jnsPelayanan.'</small><br>';
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                                    echo '<small title="Diagnosa"><i class="icofont-heartbeat"></i> '.$diagnosa.'</small><br>';
                                                    echo '<small title="Kelas Rawat"><i class="icofont-hospital"></i> Kelas '.$kelasRawat.'</small><br>';
                                                    echo '<small title="Poliklinik"><i class="icofont-surgeon-alt"></i> '.$poli.'</small><br>';
                                                ?>
                                            </td>
                                        </tr>
                    <?php 
                                                    $no++;
                                                }
                                            }
                                        }
                                    }
                                }
                            } 
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>