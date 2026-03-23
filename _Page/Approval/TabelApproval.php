<?php
    date_default_timezone_set('UTC');
    include "../../_Config/Connection.php";
    include "../../_Config/SettingBridging.php";
    include "../../_Config/SimrsFunction.php";
    include "../../vendor/autoload.php";
    if(empty($_POST['bulan'])){
        echo '<tr><td colspan="6" class="text-center text-danger">Bulan Tidak Boleh Kosong!</td></tr</span>';
    }else{
        if(empty($_POST['tahun'])){
            echo '<tr><td colspan="6" class="text-center text-danger">Tahun Tidak Boleh Kosong!</td></tr</span>';
        }else{
            if(empty($_POST['sumber'])){
                echo '<tr><td colspan="6" class="text-center text-danger">Sumber Data Tidak Boleh Kosong!</td></tr</span>';
            }else{
                $bulan=$_POST['bulan'];
                $tahun=$_POST['tahun'];
                $sumber=$_POST['sumber'];
                if($sumber=="RS"){
                    $BulanTahun="$tahun-$bulan";
                    $JumlahData = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM approval WHERE tglSep like '%$BulanTahun%'"));
                    if(empty($JumlahData)){
                        echo '<tr><td colspan="6" class="text-center text-danger">Pendaftaran Approval Tidak Ditemukan!</td></tr</span>';
                    }else{
                        $no=1;
                        //KONDISI PENGATURAN MASING FILTER
                        $query = mysqli_query($Conn, "SELECT*FROM approval WHERE tglSep like '%$BulanTahun%'");
                        while ($data = mysqli_fetch_array($query)) {
                            $id_approval=$data['id_approval'];
                            $id_akses=$data['id_akses'];
                            $noKartu=$data['noKartu'];
                            $tglSep=$data['tglSep'];
                            $jnsPelayanan=$data['jnsPelayanan'];
                            $jnsPengajuan=$data['jnsPengajuan'];
                            $keterangan=$data['keterangan'];
                            $status=$data['status'];
                            $user=$data['user'];
                            //Format Tanggal
                            $strtotime=strtotime($tglSep);
                            $TanggalFormat=date('d/m/Y',$strtotime);
                            //Cari Data Pasien
                            $id_pasien=getDataDetail($Conn,'pasien','no_bpjs',$noKartu,'id_pasien');
                            if(empty($id_pasien)){
                                $nama='<span class="text-danger">Pasien Tidak Terdaftar SIMRS</span>';
                            }else{
                                $nama=getDataDetail($Conn,'pasien','no_bpjs',$noKartu,'nama');
                            }
                            //Routing Jenis Pelayanan
                            if($jnsPelayanan=="1"){
                                $LabelPelayanan="Rawat Inap";
                            }else{
                                $LabelPelayanan="Rawat Jalan";
                            }
                            //Routing Status
                            if($status=="Pengajuan"){
                                $LabelStatus='<span class="badge badge-info">Pengajuan</span>';
                            }else{
                                if($status=="Pengajuan"){
                                    $LabelStatus='<span class="badge badge-info">Pengajuan</span>';
                                }else{
                                    $LabelStatus='<span class="badge badge-success">Approval</span>';
                                }
                            }
                            //Routing Jenis Pengajuan
                            if($jnsPengajuan=="1"){
                                $LabelPengajuan='<span class="text-primary">Pengajuan Backdate</span>';
                            }else{
                                $LabelPengajuan='<span class="text-success">Pengajuan finger print</span>';
                            }
                            echo '<tr>';
                            echo '  <td class="text-center">'.$no.'</td>';
                            echo '  <td class="text-left">';
                            echo '      '.$TanggalFormat.'<br>';
                            echo '      <small>('.$keterangan.')</small>';
                            echo '  </td>';
                            echo '  <td class="text-left">';
                            echo '      '.$noKartu.'<br>';
                            echo '      <small>'.$nama.'</small>';
                            echo '  </td>';
                            echo '  <td class="text-left">';
                            echo '      '.$LabelPelayanan.'<br>';
                            echo '      <small>'.$LabelPengajuan.'</small>';
                            echo '  </td>';
                            echo '  <td class="text-center">'.$LabelStatus.'</td>';
                            echo '  <td class="text-center">';
                            echo '      <div class="btn-group">';
                            echo '          <a href="javascript:void(0);" class="btn btn-sm btn-round btn-outline-secondary" data-toggle="modal" data-target="#ModalDetailApprovalSimrs" data-id="'.$id_approval.'" title="Detail Approval"><i class="ti ti-info-alt"></i></a>';
                            echo '          <a href="javascript:void(0);" class="btn btn-sm btn-round btn-outline-secondary" data-toggle="modal" data-target="#ModalUpdateApprovalSimrs" data-id="'.$id_approval.'" title="Update Approval"><i class="ti ti-check"></i></a>';
                            echo '          <a href="javascript:void(0);" class="btn btn-sm btn-round btn-outline-secondary" data-toggle="modal" data-target="#ModalHapusApprovalSimrs" data-id="'.$id_approval.'" title="Hapus Approval"><i class="ti ti-trash"></i></a>';
                            echo '      </div>';
                            echo '  </td>';
                            echo '</tr>';
                            $no++;
                        }
                    }
                }else{
                    $url="$url_vclaim/Sep/persetujuanSEP/list/bulan/$bulan/tahun/$tahun";
                    $Response=BridgingServiceGetUrlencoded($consid,$secret_key,$user_key,$url);
                    $ResponseJson =json_decode($Response, true);
                    if(empty($ResponseJson['metaData']['code'])){
                        echo '<tr><td colspan="6" class="text-center text-danger">Tidak Ada Response Dari Service BPJS!</td></tr</span>';
                    }else{
                        $ResponseCode=$ResponseJson['metaData']['code'];
                        if($ResponseCode!=="200"){
                            echo '<tr><td colspan="6" class="text-center text-danger">Pesan: '.$ResponseJson['metaData']['message'].'</td></tr</span>';
                        }else{
                            if(empty($ResponseJson['response'])){
                                echo '<tr><td colspan="6" class="text-center text-danger"><dt class="text-danger">Terjadi Kesalahan Pada Response</dt>Pesan: '.$ResponseJson['metaData']['message'].'</td></tr</span>';
                            }else{
                                $string=$ResponseJson['response'];
                                $stringData =json_decode($string, true);
                                $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                                $key="$consid$secret_key$timestamp";
                                //--masukan ke fungsi
                                $FileDeskripsi=stringDecrypt("$key", "$string");
                                $FileDekompresi=decompress("$FileDeskripsi");
                                //--konveris json to raw
                                $JsonData =json_decode($FileDekompresi, true);
                                if(empty($JsonData['list'])){
                                    echo '<tr><td colspan="6" class="text-center text-danger">Terjadi Kesalahan Saat Deskripsi Data</td></tr</span>';
                                }else{
                                    $ListApproval=$JsonData['list'];
                                    $no=1;
                                    $JumlahApproval=count($ListApproval);
                                    foreach($ListApproval as $ListDataShow){
                                        $noKartu=$ListDataShow['noKartu'];
                                        $nama=$ListDataShow['nama'];
                                        $tglsep=$ListDataShow['tglsep'];
                                        $jnspelayanan=$ListDataShow['jnspelayanan'];
                                        $persetujuan=$ListDataShow['persetujuan'];
                                        $status=$ListDataShow['status'];
                                        echo '<tr>';
                                        echo '  <td class="text-center">'.$no.'</td>';
                                        echo '  <td class="text-center">'.$tglsep.'</td>';
                                        echo '  <td class="text-center">'.$nama.'</td>';
                                        echo '  <td class="text-center">'.$jnspelayanan.'</td>';
                                        echo '  <td class="text-center">'.$persetujuan.'</td>';
                                        echo '  <td class="text-center">'.$status.'</td>';
                                        echo '</tr>';
                                        $no++;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>