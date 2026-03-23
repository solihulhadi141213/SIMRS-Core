<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    //tanggal
    if(!empty($_POST['tanggal'])){
        $tanggal=$_POST['tanggal'];
    }else{
        $tanggal="";
    }
    //Buka Pengaturan SIRS Online
    $x_id_rs=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','id_rs');
    $url_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','url_sirs_online');
    $password_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','password_sirs_online');
    //Request Data
    $response=DataPcrNakes($x_id_rs,$password_sirs_online,$url_sirs_online,'GET',$tanggal);
    $php_array = json_decode($response, true);
    if(!empty($php_array['PCRNakes'])){
        $DataPcrNakes=$php_array['PCRNakes'];
        $JumlahData=count($DataPcrNakes);
    }else{
        $DataPcrNakes="";
        $JumlahData=0;
    }
?>
<div class="card-body">
    <div class="table table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th class="text-center"><dt>No</dt></th>
                    <th class="text-center"><dt>Tanggal</dt></th>
                    <th class="text-center"><dt>Diperiksa</dt></th>
                    <th class="text-center"><dt>Hasil</dt></th>
                    <th class="text-center"><dt>Jumlah</dt></th>
                    <th class="text-center"><dt>Updatetime</dt></th>
                    <th class="text-center"><dt>Option</dt></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(empty($JumlahData)){
                        echo '<tr>';
                        echo '  <td colspan="6" class="text-center text-danger">Tidak ada data yang ditampilkan. <br>Keterangan: '.$php_array.'</td>';
                        echo '</tr>';
                    }else{
                        $no=1;
                        foreach ($DataPcrNakes as $item) {
                            if(!empty($item['tanggal'])){
                                $tanggal= $item['tanggal'];
                                $strtotime1=strtotime($tanggal);
                                $TanggalFormat=date('d/m/Y',$strtotime1);
                            }else{
                                $TanggalFormat="None";
                            }
                            if(!empty($item['rekap_jumlah_tenaga'])){
                                $rekap_jumlah_tenaga= $item['rekap_jumlah_tenaga'];
                            }else{
                                $rekap_jumlah_tenaga="0";
                            }
                            if(!empty($item['rekap_jumlah_sudah_diperiksa'])){
                                $rekap_jumlah_sudah_diperiksa= $item['rekap_jumlah_sudah_diperiksa'];
                            }else{
                                $rekap_jumlah_sudah_diperiksa="0";
                            }
                            if(!empty($item['rekap_jumlah_hasil_pcr'])){
                                $rekap_jumlah_hasil_pcr= $item['rekap_jumlah_hasil_pcr'];
                            }else{
                                $rekap_jumlah_hasil_pcr="0";
                            }
                            if(!empty($item['tgllapor'])){
                                $tgllapor= $item['tgllapor'];
                                $strtotime2=strtotime($tgllapor);
                                $tgllapor=date('d/m/Y H:i:s',$strtotime2);
                            }else{
                                $tgllapor="None";
                            }
                            echo '<tr>';
                            echo '  <td class="text-center">'.$no.'</td>';
                            echo '  <td class="text-left">'.$TanggalFormat.'</td>';
                            echo '  <td class="text-center">'.$rekap_jumlah_sudah_diperiksa.'</td>';
                            echo '  <td class="text-center">'.$rekap_jumlah_hasil_pcr.'</td>';
                            echo '  <td class="text-center">'.$rekap_jumlah_tenaga.'</td>';
                            echo '  <td class="text-left">'.$tgllapor.'</td>';
                            echo '  <td class="text-center">';
                            echo '      <div class="btn-group">';
                            echo '          <a href="javascript:void(0);" class="btn btn-sm btn-outline-secondary" title="Detail PCR Nakes SIRS Online" data-toggle="modal" data-target="#ModalDetailPcrNakesSirsOnline" data-id="'.$tanggal.'">';
                            echo '              <i class="ti ti-info-alt"></i>';
                            echo '          </a>';
                            echo '          <a href="javascript:void(0);" class="btn btn-sm btn-outline-secondary" title="Edit PCR Nakes SIRS Online" data-toggle="modal" data-target="#ModalEditPcrNakesSirsOnline" data-id="'.$tanggal.'">';
                            echo '              <i class="ti ti-pencil"></i>';
                            echo '          </a>';
                            echo '          <a href="javascript:void(0);" class="btn btn-sm btn-outline-secondary" title="Copy PCR Nakes SIRS Online"  data-toggle="modal" data-target="#ModalCopyPcrNakes" data-id="'.$tanggal.'">';
                            echo '              <i class="ti ti-clipboard"></i>';
                            echo '          </a>';
                            echo '      </div>';
                            echo '  </td>';
                            echo '</tr>';
                            $no++;
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>