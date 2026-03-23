<?php
    //Koneksi
    include "../../_Config/Connection.php";
    //Menangkap id bridging
    if(empty($_POST['id_bridging'])){
        echo '<div class="card-body border-0 pb-0">';
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          Data ID Bridging Tidak Dapat didefinisikan.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_bridging=$_POST['id_bridging'];
        //Membuka data profile brdiging
        $QryBridging = mysqli_query($Conn,"SELECT * FROM bridging WHERE id_bridging='$id_bridging'")or die(mysqli_error($Conn));
        $DataBridging = mysqli_fetch_array($QryBridging);
        $id_bridging= $DataBridging['id_bridging'];
        $nama_bridging= $DataBridging['nama_bridging'];
        $consid= $DataBridging['consid'];
        $cons_id_antrol= $DataBridging['cons_id_antrol'];
        $user_key= $DataBridging['user_key'];
        $user_key_antrol= $DataBridging['user_key_antrol'];
        $secret_key= $DataBridging['secret_key'];
        $secret_key_antrol= $DataBridging['secret_key_antrol'];
        $kode_ppk= $DataBridging['kode_ppk'];
        $url_vclaim= $DataBridging['url_vclaim'];
        $url_aplicare= $DataBridging['url_aplicare'];
        $url_faskes= $DataBridging['url_faskes'];
        $url_antrol= $DataBridging['url_antrol'];
        $kategori_ppk= $DataBridging['kategori_ppk'];
        $status= $DataBridging['status'];
?>
    <form action="javascript:void(0);" method="POST" id="ProsesEditBridging">
        <input type="hidden" name="id_bridging" value="<?php echo "$id_bridging"; ?>">
        <div class="modal-body p-0">
            <div class="card-body border-0 pb-0">
                <div class="row">
                    <div class="col-md-12 mb-3 form-group form-primary">
                        <label for="nama_bridging"><dt>Nama Profile</dt></label>
                        <input type="text" name="nama_bridging" id="nama_bridging" class="form-control" value="<?php echo "$nama_bridging"; ?>" required>
                        <small>Ex: Setting Test bridging Vclaim V.2</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3 form-group form-primary">
                        <label for="url_vclaim"><dt>URL VClaim</dt></label>
                        <input type="text" name="url_vclaim" id="url_vclaim" class="form-control" value="<?php echo "$url_vclaim"; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3 form-group form-primary">
                        <label for="url_aplicare"><dt>URL Aplicare</dt></label>
                        <input type="text" name="url_aplicare" id="url_aplicare" class="form-control" value="<?php echo "$url_aplicare"; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3 form-group form-primary">
                        <label for="url_antrol"><dt>URL Antrian Online</dt></label>
                        <input type="text" name="url_antrol" id="url_antrol" class="form-control" value="<?php echo "$url_antrol"; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3 form-group form-primary">
                        <label for="url_faskes"><dt>URL Faskes</dt></label>
                        <input type="text" name="url_faskes" id="url_faskes" class="form-control" value="<?php echo "$url_faskes"; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group form-primary">
                        <label for="consid"><dt>Cons-id Vclaim</dt></label>
                        <input type="text" name="consid" id="consid" class="form-control"  value="<?php echo "$consid"; ?>">
                    </div>
                    <div class="col-md-6 mb-3 form-group form-primary">
                        <label for="consid"><dt>Cons-id Antrol</dt></label>
                        <input type="text" name="cons_id_antrol" id="cons_id_antrol" class="form-control"  value="<?php echo "$cons_id_antrol"; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group form-primary">
                        <label for="user_key"><dt>User Key Vclaim</dt></label>
                        <input type="text" name="user_key" id="user_key" class="form-control" value="<?php echo "$user_key"; ?>">
                    </div>
                    <div class="col-md-6 mb-3 form-group form-primary">
                        <label for="user_key"><dt>User Key Antrol</dt></label>
                        <input type="text" name="user_key_antrol" id="user_key_antrol" class="form-control" value="<?php echo "$user_key_antrol"; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group form-primary">
                        <label for="secret_key"><dt>Secret Key Vclaim</dt></label>
                        <input type="text" name="secret_key" id="secret_key" class="form-control" value="<?php echo "$secret_key"; ?>">
                    </div>
                    <div class="col-md-6 mb-3 form-group form-primary">
                        <label for="secret_key"><dt>Secret Key Antrol</dt></label>
                        <input type="text" name="secret_key_antrol" id="secret_key_antrol" class="form-control" value="<?php echo "$secret_key_antrol"; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group form-primary">
                        <label for="kode_ppk"><dt>Kode PPK</dt></label>
                        <input type="text" name="kode_ppk" id="kode_ppk" class="form-control" value="<?php echo "$kode_ppk"; ?>">
                    </div>
                    <div class="col-md-6 mb-3 form-group form-primary" required>
                        <label for="kategori_ppk"><dt>Kategori PPK</dt></label>
                        <select name="kategori_ppk" id="kategori_ppk" class="form-control">
                            <option <?php if($kategori_ppk=="PCare"){echo "selected";} ?> value="PCare">PCare</option>
                            <option <?php if($kategori_ppk=="Rumah Sakit"){echo "selected";} ?> value="Rumah Sakit">Rumah Sakit</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3 form-group form-primary text-left ml-4" required>
                        <label for="status"><dt>Status Profile</dt></label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="status" name="status" value="Aktiv" <?php if($status=="Aktiv"){echo "checked";} ?>>
                            <label class="form-check-label" for="flexSwitchCheckDefault">Aktiv Profile Setting</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="status" name="status" value="Non-Aktiv" <?php if($status=="Non Aktiv"){echo "checked";} ?>>
                            <label class="form-check-label" for="flexSwitchCheckDefault">Non Aktiv Profile Setting</label>
                        </div>
                    </div>
                </div>
            </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div id="NotifikasiEditBridging">
                            Pastikan data setting bridging yang anda masukan sudah benar.
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        <div class="modal-footer bg-inverse">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <button type="submit" class="btn btn-md btn-primary mt-2 ml-2">
                        <i class="ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-md btn-light mt-2 ml-2" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </form>
<?php } ?>