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
    <div class="row mb-3">
        <div class="col-md-2">
            <dt>Keterangan : </dt>
        </div>
        <div class="col-md-10">
            Berikut ini adalah data tempat tidur yang ada di SIMRS. Silahkan hubungkan dengan ID TT dari SIRS online untuk mempermudah perhitungan.
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center"><dt>No</dt></th>
                            <th class="text-center"><dt>ID/Kelas (SIMRS)</dt></th>
                            <th class="text-center"><dt>Jumlah Ruangan</dt></th>
                            <th class="text-center"><dt>ID/TT (RS Online)</dt></th>
                            <th class="text-center"><dt>Opsi</dt></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM ruang_rawat WHERE kategori='kelas'"));
                            if(empty($jml_data)){
                                echo '<tr>';
                                echo '  <td colspan="5" class="text-center text-danger">Tidak ada data kelas pada datababse SIMRS</td>';
                                echo '</tr>';
                            }else{
                                $no=1;
                                $query = mysqli_query($Conn, "SELECT*FROM ruang_rawat WHERE kategori='kelas' ORDER BY id_ruang_rawat ASC");
                                while ($data = mysqli_fetch_array($query)) {
                                    $id_ruang_rawat  = $data['id_ruang_rawat'];
                                    $kodekelas  = $data['kodekelas'];
                                    $kelas  = $data['kelas'];
                                    $JumlahRuangan = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM ruang_rawat WHERE kelas='$kelas' AND kategori='ruangan'"));
                                    //Cari TT dan ID TT
                                    $id_tt=getDataDetail($Conn,'ruang_rawat_sirs','id_ruang_rawat',$id_ruang_rawat,'id_tt');
                                    $tt=getDataDetail($Conn,'ruang_rawat_sirs','id_ruang_rawat',$id_ruang_rawat,'tt');
                                    if(!empty($id_tt)){
                                        $GetIdTt="($id_tt) $tt";
                                    }else{
                                        $GetIdTt='<span class="text-danger">Tidak Ada</span>';
                                    }
                                    echo '<tr>';
                                    echo '  <td align="center">'.$no.'</td>';
                                    echo '  <td align="left">('.$id_ruang_rawat.') '.$kelas.'</td>';
                                    echo '  <td align="left">'.$JumlahRuangan.'</td>';
                                    echo '  <td align="left">'.$GetIdTt.'</td>';
                                    echo '  <td align="center">';
                                    echo '      <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#ModalSettingTempatTidur" data-id="'.$id_ruang_rawat.'">';
                                    echo '          <i class="ti ti-settings"></i>';
                                    echo '      </button>';
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
    </div>
</div>