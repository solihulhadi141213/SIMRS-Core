<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    //Buka Pengaturan SIRS Online
    $x_id_rs=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','id_rs');
    $url_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','url_sirs_online');
    $password_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','password_sirs_online');
?>
<div class="card-body">
    <div class="row">
        <div class="col-md-2">
            <dt>Keterangan :</dt>
        </div>
        <div class="col-md-10">
            Berikut ini adalah data tempat tidur yang berasal dari SIRS Online. <br>
            Silahkan lakukan update secara rutin pada masing-masing kategori tempat tidur yang masa updatenya sudah berlalu.
        </div>
    </div>
    <div class="table table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <td align="center"><dt>No</dt></td>
                    <td align="center"><dt>ID/TT</dt></td>
                    <td align="center"><dt>SIRANAP</dt></td>
                    <td align="center"><dt>Update</dt></td>
                    <td align="center"><dt>Kelas/SIMRS</dt></td>
                    <td align="center"><dt>Opsi</dt></td>
                </tr>
            </thead>
            <tbody>
                <?php
                    $response_referensi=DataTtSirsOnline($x_id_rs,$password_sirs_online,$url_sirs_online,'GET');
                    if(empty($response_referensi)){
                        echo '<tr>';
                        echo '  <td align="center" colspan="5">Tidak ada response dari SIRS Online <br>Keterangan: '.$response_referensi.'</td>';
                        echo '</tr>';
                    }else{
                        $php_array = json_decode($response_referensi, true);
                        $ReferensiTt=$php_array['fasyankes'];
                        $JumlahData=count($ReferensiTt);
                        if(empty($JumlahData)){
                            echo '<tr>';
                            echo '  <td align="center" colspan="5">Tidak ada data yang ditampilkan. <br>Keterangan: '.$response_referensi.'</td>';
                            echo '</tr>';
                        }else{
                            $no=1;
                            foreach ($ReferensiTt as $item) {
                                // Tambahkan setiap elemen ke dalam array PHP
                                $id_tt= $item['id_tt'];
                                $tt= $item['tt'];
                                $ruang= $item['ruang'];
                                $kode_siranap= $item['kode_siranap'];
                                $jumlah_ruang= $item['jumlah_ruang'];
                                $jumlah= $item['jumlah'];
                                $terpakai= $item['terpakai'];
                                $terpakai_suspek= $item['terpakai_suspek'];
                                $terpakai_konfirmasi= $item['terpakai_konfirmasi'];
                                $antrian= $item['antrian'];
                                $prepare= $item['prepare'];
                                $prepare_plan= $item['prepare_plan'];
                                $kosong= $item['kosong'];
                                $covid= $item['covid'];
                                $id_t_tt= $item['id_t_tt'];
                                $tglupdate= $item['tglupdate'];
                                if(!empty($ruang)){
                                    $DataRuang = explode("," , $ruang);
                                    $JumlahRuang=count($DataRuang);
                                }else{
                                    $DataRuang ="";
                                    $JumlahRuang=0;
                                }
                                if(!empty($tglupdate)){
                                    $strtotime=strtotime($tglupdate);
                                    $LabelTglUpdate=date('d/m/Y H:i:s',$strtotime);
                                }else{
                                    $strtotime="";
                                    $LabelTglUpdate='<span class="text-danger">Tidak Ada</span>';
                                }
                                //Cari Kelas dari SIMRS yang sudah di sinkronisasikan
                                $id_ruang_rawat_sirs=getDataDetail($Conn,'ruang_rawat_sirs','id_tt',$id_tt,'id_ruang_rawat_sirs');
                                $id_ruang_rawat=getDataDetail($Conn,'ruang_rawat_sirs','id_tt',$id_tt,'id_ruang_rawat');
                                //Buka Nama kelas
                                
                                if(!empty($id_ruang_rawat)){
                                    $Namakelas=getDataDetail($Conn,'ruang_rawat','id_ruang_rawat',$id_ruang_rawat,'kodekelas');
                                }else{
                                    $Namakelas='<span class="text-danger">Tidak ADa</span>';
                                }
                                echo '<tr>';
                                echo '  <td align="center">'.$no.'</td>';
                                echo '  <td>';
                                echo '      <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalDetailTempatTidur" data-id="'.$id_tt.'">';
                                echo '          ('.$id_tt.') '.$tt.'';
                                echo '      </a>';
                                echo '  </td>';
                                echo '  <td>'.$kode_siranap.'</td>';
                                echo '  <td>'.$LabelTglUpdate.'</td>';
                                echo '  <td>'.$Namakelas.'</td>';
                                echo '  <td class="text-center">';
                                if(empty($id_ruang_rawat)){
                                    echo '      <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#ModalSettingTempatTidurDulu">';
                                    echo '          <i class="ti ti-settings"></i>';
                                    echo '      </button>';
                                }else{
                                    if(empty($tglupdate)){
                                        echo '      <button type="button" title="Tambah Tempat Tidur" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#ModalTambahTempatTidur" data-id="'.$id_tt.'">';
                                        echo '          <i class="ti ti-plus"></i>';
                                        echo '      </button>';
                                    }else{
                                        echo '      <button type="button" title="Update Tempat Tidur" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalUpdateTempatTidur" data-id="'.$id_tt.'">';
                                        echo '          <i class="ti ti-reload"></i>';
                                        echo '      </button>';
                                    }
                                }
                                echo '  </td>';
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