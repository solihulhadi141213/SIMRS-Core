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
    <form action="javascript:void(0);" id="ProsesEditEntitas">
        <input type="hidden" id="id_akses_entitas" name="id_akses_entitas" value="<?php echo "$id_akses_entitas"; ?>">
        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="card table-card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-10 mb-3">
                                <h4># Form Edit Entitas Akses</h4>
                            </div>
                            <div class="col-md-2 mb-3">
                                <a href="index.php?Page=Akses&Sub=EntitasAkses" class="btn btn-sm btn-block btn-secondary">
                                    <i class="ti ti-angle-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="akses"><dt>Nama Entitas Akses</dt></label>
                                <input type="text" id="akses" name="akses" class="form-control" value="<?php echo "$akses"; ?>">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="deskripsi"><dt>Deskripsi/Gambaran Umum</dt></label>
                                <input type="text" id="deskripsi" name="deskripsi" class="form-control" value="<?php echo "$deskripsi"; ?>">
                            </div>
                            <div class="col-md-12">
                                Atur referensi fitur standar untuk entitas ini.
                            </div>
                        </div>
                        <?php
                            $no=1;
                            $QryKategoriReferensi = mysqli_query($Conn, "SELECT DISTINCT kategori FROM akses_ref");
                            while ($DataKategori = mysqli_fetch_array($QryKategoriReferensi)) {
                                $kategori= $DataKategori['kategori'];
                        ?>
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <dt><?php echo "$no. $kategori"; ?></dt>
                                </div>
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
                                            echo '<div class="col-md-12 ml-4">';
                                            echo "  <input type='checkbox' checked id='Referensi$id_akses_ref' name='Referensi$id_akses_ref' value='Yes'> <label for='Referensi$id_akses_ref'>$no.$no2 $nama_fitur</label>";
                                            echo '</div>';
                                        }else{
                                            echo '<div class="col-md-12 ml-4">';
                                            echo "  <input type='checkbox' id='Referensi$id_akses_ref' name='Referensi$id_akses_ref' value='Yes'> <label for='Referensi$id_akses_ref'>$no.$no2 $nama_fitur</label>";
                                            echo '</div>';
                                        }
                                        $no2++;
                                    }
                                ?>
                            </div>
                        <?php $no++;} ?>
                        <div class="row">
                            <div class="col-md-12 mb-4" id="NotifikasiEditEntitas">
                                <span class="text-primary">Pastikan Data Entitas yang Anda Isi Sudah Sesuai</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-md btn-success">
                            <i class="ti-save"></i> Simpan
                        </button>
                        <button type="reset" class="btn btn-md btn-danger">
                            <i class="ti ti-reload"></i> Reset
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
<?php } ?>