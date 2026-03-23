<?php
    if(empty($_GET['id'])){
        echo '<div class="row">';
        echo '  <div class="col-xl-12 col-md-12">';
        echo '      <div class="card table-card">';
        echo '          <div class="card-body text-danger">';
        echo '              ID Entitas Tidak Boleh Kosong!';
        echo '          </div>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_akses_entitas=$_GET['id'];
        //Buka data askes
        $QryDetailAkses = mysqli_query($Conn,"SELECT * FROM akses_entitas WHERE id_akses_entitas='$id_akses_entitas'")or die(mysqli_error($Conn));
        $DataDetailAkses = mysqli_fetch_array($QryDetailAkses);
        $akses = $DataDetailAkses['akses'];
        $deskripsi= $DataDetailAkses['deskripsi'];
        $standar_referensi= $DataDetailAkses['standar_referensi'];
        //Decode data json
        if(!empty($DataDetailAkses['standar_referensi'])){
            $JsonData = json_decode($standar_referensi,true);
        }else{
            $JsonData ="";
        }
?>
    <div class="row">
        <div class="col-xl-6 col-md-12">
            <div class="card table-card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <h4># Detail Entitas Akses</h4>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="index.php?Page=Akses&Sub=EntitasAkses" class="btn btn-sm btn-block btn-secondary">
                                <i class="ti ti-angle-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <dt>Entitas Akses <?php echo "$akses"; ?></dt>
                            <?php echo "$deskripsi"; ?>
                        </div>
                    </div>
                    <div class="row mb-4">
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
                <div class="card-footer">
                    <a href="index.php?Page=Akses&Sub=EditEntitas&id=<?php echo "$id_akses_entitas"; ?>" class="btn btn-sm btn-block btn-success">
                        <i class="ti ti-pencil-alt"></i> Edit Entitas
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-12">
            <div class="card table-card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <h4># User Akses</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-12 table table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center"><dt>NO</dt></th>
                                        <th class="text-center"><dt>NAMA</dt></th>
                                        <th class="text-center"><dt>EMAIL</dt></th>
                                        <th class="text-center"><dt>KONTAK</dt></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $JumlahUser = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses WHERE akses='$akses'"));
                                        if(empty($JumlahUser)){
                                            echo '<tr>';
                                            echo '  <td colspan="4" class="text-center">Belum Ada Akses User</td>';
                                            echo '</tr>';
                                        }else{
                                            $no=1;
                                            $QryAksesUser = mysqli_query($Conn, "SELECT*FROM akses WHERE akses='$akses'");
                                            while ($DataAksesUser = mysqli_fetch_array($QryAksesUser)) {
                                                $id_akses= $DataAksesUser['id_akses'];
                                                $nama= $DataAksesUser['nama'];
                                                $email= $DataAksesUser['email'];
                                                $kontak= $DataAksesUser['kontak'];
                                                $password= $DataAksesUser['password'];
                                                $akses= $DataAksesUser['akses'];
                                    ?>
                                        <tr>
                                            <th class="text-center"><?php echo "$no"; ?></th>
                                            <th class="text-left"><?php echo "$nama"; ?></th>
                                            <th class="text-left"><?php echo "$email"; ?></th>
                                            <th class="text-left"><?php echo "$kontak"; ?></th>
                                        </tr>
                                    <?php $no++;}} ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>