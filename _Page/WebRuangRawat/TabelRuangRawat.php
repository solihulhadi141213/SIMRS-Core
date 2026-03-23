<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/WebFunction.php";
    $UrlInfo=urlService('Info Ruang Rawat');
    $jumlahRuangRawat=GetInfoRuangRawat($api_key,$UrlInfo,"jumlah_data");
?>
<div class="card-block">
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th class="text-center">
                        <dt>No</dt>
                    </th>
                    <th class="text-center">
                        <dt>Nama Ruangan</dt>
                    </th>
                    <th class="text-center">
                        <dt>Kelas</dt>
                    </th>
                    <th class="text-center">
                        <dt>Kapasitas</dt>
                    </th>
                    <th class="text-center">
                        <dt>Pasien</dt>
                    </th>
                    <th class="text-center">
                        <dt>Sisa/Tersedia</dt>
                    </th>
                    <th class="text-center">
                        <dt>Option</dt>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(empty($jumlahRuangRawat)){
                        echo '<tr>';
                        echo '  <td colspan="6" class="text-center">';
                        echo '      Tidak Ada Data Yang Ditampilkan';
                        echo '  </td>';
                        echo '</tr>';
                    }else{
                        $list_data=GetInfoRuangRawat($api_key,$UrlInfo,"ruang_rawat");
                        $no=1;
                        foreach($list_data as $value){
                            $ruang_rawat=$value['ruang_rawat'];
                            $kelas_ruangan=$value['kelas_ruangan'];
                            $kode_kelas=$value['kode_kelas'];
                            $kapasitas=$value['kapasitas'];
                            $pasien=$value['pasien'];
                            $tersedia=$value['tersedia'];
                            $status=$value['status'];
                            $last_update=$value['last_update'];
                            //Ubah Format Last Update
                            $strtotime=strtotime($last_update);
                            $last_update=date('d/m/Y H:i',$strtotime);
                ?>
                    <tr>
                        <td class="text-center"><?php echo "$no"; ?></td>
                        <td class="text-left">
                            <?php 
                                echo "$ruang_rawat<br>"; 
                                echo "<small class='text-muted'>Status: $status</small>";
                            ?>
                        </td>
                        <td class="text-left">
                            <?php 
                                echo "$kelas_ruangan<br>"; 
                                echo "<small class='text-muted'>Kode: $kode_kelas</small>"; 
                            ?>
                        </td>
                        <td class="text-left"><?php echo "$kapasitas Bed"; ?></td>
                        <td class="text-left"><?php echo "$pasien Pasien"; ?></td>
                        <td class="text-left">
                            <?php 
                                echo "$tersedia Bed <br>"; 
                                echo "<small class='text-muted'>$last_update</small>"; 
                            ?>
                        </td>
                        <td class="text-center">
                            <div class="btn-group dropdown-split-inverse">
                                <button type="button" class="btn btn-sm btn-inverse dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="OptionButton">
                                    <i class="ti ti-settings"></i>
                                </button>
                                <div class="dropdown-menu" x-placement="top-start" style="position: absolute; transform: translate3d(107px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalEditRuangRawat" data-id="<?php echo $ruang_rawat;?>" title="Edit Poliklinik">
                                        <i class="ti-pencil"></i> Edit
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalHapusRuangRawat" data-id="<?php echo "$ruang_rawat"; ?>" title="Hapus Poliklinik">
                                        <i class="ti-trash"></i> Hapus
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php
                            $no++;
                        }
                    }
                ?>
            </tbody>
        </table>
        
    </div>
</div>