<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    //Buka Pengaturan SIRS Online
    $x_id_rs=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','id_rs');
    $url_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','url_sirs_online');
    $password_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','password_sirs_online');
?>
<div class="card-body">
    <div class="table table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <td align="center"><dt>ID</dt></td>
                    <td align="center"><dt>Kebutuhan</dt></td>
                    <td align="center"><dt>Eksisting</dt></td>
                    <td align="center"><dt>Jumlah</dt></td>
                    <td align="center"><dt>Diterima</dt></td>
                    <td align="center"><dt>Update</dt></td>
                    <td align="center"><dt>Opsi</dt></td>
                </tr>
            </thead>
            <tbody>
                <?php
                    $DataAlkes=DataAlkesSirsOnline($x_id_rs,$password_sirs_online,$url_sirs_online,'GET');
                    if(empty($DataAlkes)){
                        echo '<tr>';
                        echo '  <td align="center" colspan="6">Tidak ada response dari service SIRS Online</td>';
                        echo '</tr>';
                    }else{
                        $php_array = json_decode($DataAlkes, true);
                        $ListAlkes=$php_array['apd'];
                        $JumlahData=count($ListAlkes);
                        if(empty($JumlahData)){
                            echo '<tr>';
                            echo '  <td align="center" colspan="6">Tidak ada data yang ditampilkan. <br>Keterangan: '.$php_array.'</td>';
                            echo '</tr>';
                        }else{
                            $no=1;
                            foreach ($ListAlkes as $item) {
                                // Tambahkan setiap elemen ke dalam array PHP
                                $id_kebutuhan= $item['id_kebutuhan'];
                                $jumlah_diterima= $item['jumlah_diterima'];
                                if(empty($item['kebutuhan'])){
                                    $kebutuhan='<span class="text-danger">None</span>';
                                }else{
                                    $kebutuhan= $item['kebutuhan'];
                                }
                                if(empty($item['jumlah_eksisting'])){
                                    $jumlah_eksisting='<span class="text-danger">None</span>';
                                }else{
                                    $jumlah_eksisting= $item['jumlah_eksisting'];
                                }
                                if(empty($item['jumlah'])){
                                    $jumlah='<span class="text-danger">None</span>';
                                }else{
                                    $jumlah= $item['jumlah'];
                                }
                                if(empty($item['jumlah_diterima'])){
                                    $jumlah_diterima='<span class="text-danger">None</span>';
                                }else{
                                    $jumlah_diterima= $item['jumlah_diterima'];
                                }
                                //Format Tanggal
                                if(!empty($item['tglupdate'])){
                                    $tglupdate= $item['tglupdate'];
                                    $strtotime=strtotime($tglupdate);
                                    $tglupdate=date('d/m/Y',$strtotime);
                                    $sekarang=date('d/m/Y');
                                    if($sekarang>$tglupdate){
                                        $tglupdate='<span class="text-danger">'.$tglupdate.'</span>';
                                    }else{
                                        $tglupdate='<span class="text-success">'.$tglupdate.'</span>';
                                    }
                                }else{
                                    $tglupdate="";
                                    $tglupdate='<span class="text-danger">None</span>';
                                }
                                if(empty($item['tglupdate'])){
                                    $tombol='<button type="button" title="Tambah Alkes" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#ModalTambahAlkes" data-id="'.$id_kebutuhan.'"><i class="ti ti-plus"></i></button>';
                                }else{
                                    $tombol='<button type="button" title="Edit Alkes" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalEditAlkes" data-id="'.$id_kebutuhan.'"><i class="ti ti-reload"></i></button>';
                                }
                                echo '<tr>';
                                echo '  <td align="center">'.$id_kebutuhan.'</td>';
                                echo '  <td align="left">';
                                echo '      <a href="javascript:void(0);" class="text-primary" title="Lihat Detail Alkes" data-toggle="modal" data-target="#ModalDetailAlkes" data-id="'.$id_kebutuhan.'">'.$kebutuhan.'</a>';
                                echo '  </td>';
                                echo '  <td align="center">'.$jumlah_eksisting.'</td>';
                                echo '  <td align="center">'.$jumlah.'</td>';
                                echo '  <td align="center">'.$jumlah_diterima.'</td>';
                                echo '  <td align="left">'.$tglupdate.'</td>';
                                echo '  <td align="center">'.$tombol.'</td>';
                                echo '</tr>';
                                $no++;
                            }
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>