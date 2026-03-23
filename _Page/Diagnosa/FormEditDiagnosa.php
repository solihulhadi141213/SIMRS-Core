<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Tangkap id_diagnosa
    if(empty($_POST['id_diagnosa'])){
        echo '<div class="card-body border-0 pb-0">';
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          Data ID Diagnosa Tidak Dapat didefinisikan.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="card-footer">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 mb-2 mb-2">';
        echo '          <button class="btn btn-md btn-secondary" data-dismiss="modal"><i class="ti ti-close"></i> Tutup</button>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_diagnosa=$_POST['id_diagnosa'];
        //Buka data diagnosa
        $QryDiagnosa = mysqli_query($Conn,"SELECT * FROM diagnosa WHERE id_diagnosa='$id_diagnosa'")or die(mysqli_error($Conn));
        $DataDiagnosa = mysqli_fetch_array($QryDiagnosa);
        $id_diagnosa= $DataDiagnosa['id_diagnosa'];
        $kode= $DataDiagnosa['kode'];
        $long_des= $DataDiagnosa['long_des'];
        $short_des= $DataDiagnosa['short_des'];
        $versi= $DataDiagnosa['versi'];
?>
    <form action="javascript:void(0);" id="ProsesEditDiagnosa" autocomplete="off">
        <input type="hidden" name="id_diagnosa" id="id_diagnosa" value="<?php echo $id_diagnosa;?>">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="versi"><dt>Versi</dt></label>
                    <select name="versi" id="versi" class="form-control">
                        <option <?php if($versi=="ICD9"){echo "selected";} ?> value="ICD9">ICD9</option>
                        <option <?php if($versi=="ICD10"){echo "selected";} ?> value="ICD10">ICD10</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="kode"><dt>Kode Diagnosa</dt></label>
                    <input type="text" name="kode" id="kode" class="form-control" required value="<?php echo $kode;?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="long_des"><dt>Long Description</dt></label>
                    <input type="text" name="long_des" id="long_des" class="form-control" value="<?php echo $long_des;?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="short_des"><dt>Short Description</dt></label>
                    <input type="text" name="short_des" id="short_des" class="form-control" value="<?php echo $short_des;?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3" id="NotifikasiEditDiagnosa">
                    <dt>Keterangan :</dt>
                    Pastikan data yang anda input sudah benar.
                </div>
            </div>
        </div>
        <div class="modal-footer bg-info">
            <div class="row">
                <div class="col-md-12 mb-2 mb-2">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary ml-2" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </form>
<?php } ?>