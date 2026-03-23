<?php
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    //Buka Pengaturan SIRS Online
    $x_id_rs=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','id_rs');
    $url_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','url_sirs_online');
    $password_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','password_sirs_online');
?>
<div class="card-body">
    <div class="row">
        <div class="col-md-12">
            Berikut Ini Adalah Data Rekapitulasi Nakes Dari SIRS Online
        </div>
    </div>
    <div class="table table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <td align="center"><dt>No</dt></td>
                    <td align="center"><dt>ID</dt></td>
                    <td align="center"><dt>Kebutuhan</dt></td>
                    <td align="center"><dt>Rekap</dt></td>
                    <td align="center"><dt>Eksisting</dt></td>
                    <td align="center"><dt>Jumlah</dt></td>
                    <td align="center"><dt>Diterima</dt></td>
                    <td align="center"><dt>Tanggal</dt></td>
                    <td align="center"><dt>Option</dt></td>
                </tr>
            </thead>
            <tbody>
                <?php
                    $response_referensi=DataSdmSirsOnline($x_id_rs,$password_sirs_online,$url_sirs_online,'GET');
                    $php_array = json_decode($response_referensi, true);
                    $DataSdm=$php_array['sdm'];
                    $JumlahData=count($DataSdm);
                    if(empty($JumlahData)){
                        echo '<tr>';
                        echo '  <td align="center" colspan="8">Tidak ada data yang ditampilkan. <br>Keterangan: '.$php_array.'</td>';
                        echo '</tr>';
                    }else{
                        $no=1;
                        foreach ($DataSdm as $item) {
                            // Tambahkan setiap elemen ke dalam array PHP
                            $id_kebutuhan= $item['id_kebutuhan'];
                            $kebutuhan= $item['kebutuhan'];
                            if(empty($item['tglupdate'])){
                                $tglupdate="None";
                                $jumlah_eksisting="-";
                                $jumlah="-";
                                $jumlah_diterima="-";
                                $TombolUpdate='<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalCreatSdm" data-id="'.$id_kebutuhan.'"><i class="ti ti-plus"></i></button>';
                                $TanggalUpdate='<span class="text-dark">'.$tglupdate.'</span>';
                            }else{
                                $tglupdate= $item['tglupdate'];
                                $jumlah_eksisting= $item['jumlah_eksisting'];
                                $jumlah= $item['jumlah'];
                                $jumlah_diterima= $item['jumlah_diterima'];
                                //Perbandingan natara tanggal update dengan tanggal sekarang
                                $TanggalSekarang=date('Y-m-d');
                                if($TanggalSekarang>$tglupdate){
                                    $TombolUpdate='<button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#ModalUpdateSdm" data-id="'.$id_kebutuhan.'"><i class="ti ti-reload"></i></button>';
                                    $strtotime=strtotime($tglupdate);
                                    $tglupdateFormat=date('d/m/Y',$strtotime);
                                    $TanggalUpdate='<span class="text-danger">'.$tglupdateFormat.'</span>';
                                }else{
                                    $TombolUpdate='<button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#ModalUpdateSdm" data-id="'.$id_kebutuhan.'"><i class="ti ti-reload"></i></button>';
                                    $strtotime=strtotime($tglupdate);
                                    $tglupdateFormat=date('d/m/Y',$strtotime);
                                    $TanggalUpdate='<span class="text-success">'.$tglupdateFormat.'</span>';
                                }
                            }
                            //Hitung Jumlah Nakes pada SIMRS
                            $JumlahSimrs = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes WHERE referensi_sdm='$kebutuhan'"));
                            echo '<tr>';
                            echo '  <td align="center">'.$no.'</td>';
                            echo '  <td align="center">'.$id_kebutuhan.'</td>';
                            echo '  <td align="left">'.$kebutuhan.'</td>';
                            echo '  <td align="center">'.$JumlahSimrs.'</td>';
                            echo '  <td align="center">'.$jumlah_eksisting.'</td>';
                            echo '  <td align="center">'.$jumlah.'</td>';
                            echo '  <td align="center">'.$jumlah_diterima.'</td>';
                            echo '  <td align="center">'.$TanggalUpdate.'</td>';
                            echo '  <td align="center">';
                            echo '      '.$TombolUpdate.'';
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