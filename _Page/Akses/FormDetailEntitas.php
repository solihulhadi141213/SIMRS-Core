<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Tangkap id_akses
    if(empty($_POST['id_akses_entitas'])){
        echo '<div class="modal-body border-0 pb-0">';
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          Data ID Akses Tidak Dapat didefinisikan.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_akses_entitas=$_POST['id_akses_entitas'];
        //Buka data askes
        $QryDetailAkses = mysqli_query($Conn,"SELECT * FROM akses_entitas WHERE id_akses_entitas='$id_akses_entitas'")or die(mysqli_error($Conn));
        $DataDetailAkses = mysqli_fetch_array($QryDetailAkses);
        $akses = $DataDetailAkses['akses'];
        $deskripsi= $DataDetailAkses['deskripsi'];
        $standar_referensi= $DataDetailAkses['standar_referensi'];
        $JumlahUser = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses WHERE akses='$akses'"));
        //Decode data json
        if(!empty($DataDetailAkses['standar_referensi'])){
            $JsonData = json_decode($standar_referensi,true);
            $string=count($JsonData);
            $JumlahFitur=0;
            for($i=0; $i<$string; $i++){
                $id_akses_ref=$JsonData[$i]['id_akses_ref'];
                $StatusItem=$JsonData[$i]['status'];
                if($StatusItem=="Yes"){
                    $JumlahFitur=$JumlahFitur+1;
                }else{
                    $JumlahFitur=$JumlahFitur+0;
                }
            }
        }else{
            $JsonData ="";
            $JumlahFitur =0;
        }
        if(empty($JumlahUser)){
            $LabelJumlahUser='<span class="text-danger">0 Orang</span>';
        }else{
            $LabelJumlahUser='<span class="text-success">'.$JumlahUser.' Orang</span>';
        }
        if(empty($JumlahFitur)){
            $LabelJumlahFitur='<span class="text-danger">0 Fitur</span>';
        }else{
            $LabelJumlahFitur='<span class="text-success">'.$JumlahFitur.' Fitur</span>';
        }
?>
    <div class="modal-body border-0 pb-0 mb-4">
        <div class="row mt-2"> 
            <div class="col-md-4"><dt>Nama Akses</dt></div>
            <div class="col-md-8"><?php echo "$akses"; ?></div>
        </div>
        <div class="row mt-2"> 
            <div class="col-md-4"><dt>Deskripsi</dt></div>
            <div class="col-md-8"><?php echo "$deskripsi"; ?></div>
        </div>
        <div class="row mt-2"> 
            <div class="col-md-4"><dt>Jumlah Fitur</dt></div>
            <div class="col-md-8"><?php echo "$LabelJumlahFitur"; ?></div>
        </div>
        <div class="row mt-2"> 
            <div class="col-md-4"><dt>Jumlah User</dt></div>
            <div class="col-md-8"><?php echo "$LabelJumlahUser"; ?></div>
        </div>
        <div class="row mt-4">
            <?php
                $no=1;
                $QryKategoriReferensi = mysqli_query($Conn, "SELECT DISTINCT kategori FROM akses_ref");
                while ($DataKategori = mysqli_fetch_array($QryKategoriReferensi)) {
                    $kategori= $DataKategori['kategori'];
            ?>
                <div class="col-md-6 mb-3">
                    <dt><?php echo "$no. $kategori"; ?></dt>
                    <ul>
                        <?php
                            $no2=1;
                            $QryReferensi = mysqli_query($Conn, "SELECT * FROM akses_ref WHERE kategori='$kategori'");
                            while ($DataReferensi = mysqli_fetch_array($QryReferensi)) {
                                $id_akses_ref= $DataReferensi['id_akses_ref'];
                                $nama_fitur= $DataReferensi['nama_fitur'];
                                $kode= $DataReferensi['kode'];
                                $keterangan= $DataReferensi['keterangan'];
                                $string=count($JsonData);
                                for($i=0; $i<$string; $i++){
                                    if($id_akses_ref==$JsonData[$i]['id_akses_ref']){
                                        $StatusItem=$JsonData[$i]['status'];
                                    }
                                }
                                if($StatusItem=="Yes"){
                                    echo '<li class="text-success">';
                                    echo '  <i class="ti ti-check"></i> '.$nama_fitur.'';
                                    echo '</li>';
                                }else{
                                    echo '<li class="text-dark">';
                                    echo '  <i class="ti ti-close"></i> '.$nama_fitur.'';
                                    echo '</li>';
                                }
                                $no2++;
                            }
                        ?>
                    </ul>
                </div>
            <?php $no++;} ?>
        </div>
    </div>
    <div class="modal-footer bg-info">
        <div class="btn-group dropdown-split-inverse">
            <button type="button" class="btn btn-md btn-primary dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="OptionButton">
                <i class="ti ti-settings"></i> Option
            </button>
            <div class="dropdown-menu" x-placement="top-start" style="position: absolute; transform: translate3d(107px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                <a class="dropdown-item waves-effect waves-light" href="index.php?Page=Akses&Sub=DetailEntitas&id=<?php echo "$id_akses_entitas"; ?>">
                    <i class="ti ti-info-alt"></i> Selengkapnya
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item waves-effect waves-light" href="index.php?Page=Akses&Sub=EditEntitas&id=<?php echo "$id_akses_entitas"; ?>">
                    <i class="ti-pencil"></i> Edit
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalHapusEntitas" data-id="<?php echo "$id_akses_entitas"; ?>">
                    <i class="ti-trash"></i> Hapus
                </a>
            </div>
        </div>
        <button type="button" class="btn btn-md btn-inverse" data-dismiss="modal">
            <i class="ti ti-close"></i> Tutup
        </button>
    </div>
<?php } ?>