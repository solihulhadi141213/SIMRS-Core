<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/WebFunction.php";
    $url=urlService("List Unit");
    $keyword_by="";
    $keyword="";
    $short_by="DESC";
    $order_by="id_unit_instalasi";
    $List=GetListInline($api_key,$url,$keyword_by,$keyword,$short_by,$order_by);
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
                        <dt>Image</dt>
                    </th>
                    <th class="text-center">
                        <dt>Nama Unit</dt>
                    </th>
                    <th class="text-center">
                        <dt>Anggota</dt>
                    </th>
                    <th class="text-center">
                        <dt>Galeri</dt>
                    </th>
                    <th class="text-center">
                        <dt>Last Update</dt>
                    </th>
                    <th class="text-center">
                        <dt>Option</dt>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no=1;
                    foreach($List as $value){
                        $id_unit_instalasi=$value['id_unit_instalasi'];
                        $nama_unit_instalasi=$value['nama_unit_instalasi'];
                        $deskripsi_unit_instalasi=$value['deskripsi_unit_instalasi'];
                        $jumlah_anggota=$value['jumlah_anggota'];
                        $jumlah_galeri=$value['jumlah_galeri'];
                        $poster_unit_instalasi=$value['poster_unit_instalasi'];
                        $datetime_unit_instalasi=$value['datetime_unit_instalasi'];
                        $preview = substr($deskripsi_unit_instalasi, 0, 40);
                        //Ubah Format Last Update
                        $strtotime=strtotime($datetime_unit_instalasi);
                        $last_update=date('d/m/Y H:i',$strtotime);
                ?>
                    <tr>
                        <td class="text-center"><?php echo "$no"; ?></td>
                        <td class="text-center">
                            <img src="<?php echo "$poster_unit_instalasi";?>" alt="<?php echo "$nama_unit_instalasi";?>" width="50px">
                        </td>
                        <td class="text-left">
                            <?php 
                                echo '<a href="javascript:void(0);" title="Detail Informasi Unit" data-toggle="modal" data-target="#ModalDetailUnit" data-id="'.$id_unit_instalasi.'">';
                                echo "  <dt class='text-primary'>$nama_unit_instalasi</dt>";
                                echo '</a>';
                                echo "<small class='text-muted'>$preview</small>";
                            ?>
                        </td>
                        <td class="text-left"><?php echo "$jumlah_anggota Orang"; ?></td>
                        <td class="text-left"><?php echo "$jumlah_galeri Record"; ?></td>
                        <td class="text-left"><?php echo "$last_update"; ?></td>
                        <td class="text-center">
                            <div class="btn-group dropdown-split-inverse">
                                <button type="button" class="btn btn-sm btn-inverse dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="OptionButton">
                                    <i class="ti ti-settings"></i>
                                </button>
                                <div class="dropdown-menu" x-placement="top-start" style="position: absolute; transform: translate3d(107px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                                    <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalDetailUnit" data-id="<?php echo "$id_unit_instalasi"; ?>">
                                        <i class="ti ti-info-alt"></i> Detail
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item waves-effect waves-light" href="index.php?Page=WebUnit&Sub=EditUnit&id=<?php echo $id_unit_instalasi;?>" title="Edit Unit">
                                        <i class="ti-pencil"></i> Edit
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalhapusUnit" data-id="<?php echo "$id_unit_instalasi"; ?>" title="Hapus Unit">
                                        <i class="ti-trash"></i> Hapus
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php
                        $no++;
                    }
                ?>
            </tbody>
        </table>
        
    </div>
</div>