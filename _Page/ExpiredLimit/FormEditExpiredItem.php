<?php
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_obat_expired'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      ID Obat Expired Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['page'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center text-danger">';
            echo '      Informasi Halaman Tidak Boleh Kosong!';
            echo '  </div>';
            echo '</div>';
        }else{
            $page=$_POST['page'];
            $id_obat_expired=$_POST['id_obat_expired'];
            $batch=getDataDetail($Conn,'obat_expired','id_obat_expired',$id_obat_expired,'batch');
            $nama=getDataDetail($Conn,'obat_expired','id_obat_expired',$id_obat_expired,'nama');
            $qty=getDataDetail($Conn,'obat_expired','id_obat_expired',$id_obat_expired,'qty');
            $satuan=getDataDetail($Conn,'obat_expired','id_obat_expired',$id_obat_expired,'satuan');
            $expired=getDataDetail($Conn,'obat_expired','id_obat_expired',$id_obat_expired,'expired');
            $ingatkan=getDataDetail($Conn,'obat_expired','id_obat_expired',$id_obat_expired,'ingatkan');
            $status=getDataDetail($Conn,'obat_expired','id_obat_expired',$id_obat_expired,'status');
?>
    <input type="hidden" name="GetPage" id="GetPage" value="<?php echo "$page"; ?>">
    <input type="hidden" name="id_obat_expired" value="<?php echo "$id_obat_expired"; ?>">
    <div class="row mb-4">
        <div class="col-md-12">
            <label for="batch">Kode Batch</label>
            <input type="text" name="batch" id="batch" class="form-control" value="<?php echo $batch; ?>">
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-12">
            <label for="qty">QTY Item</label>
            <input type="number" name="qty" id="qty" class="form-control" value="<?php echo $qty; ?>">
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-12">
            <label for="expired">Expired Date</label>
            <input type="date" name="expired" id="expired" class="form-control" value="<?php echo $expired; ?>">
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-12">
            <label for="ingatkan">Ingatkan Pada</label>
            <input type="date" name="ingatkan" id="ingatkan" class="form-control" value="<?php echo $ingatkan; ?>">
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-12">
            <label for="status">Status</label>
            <ul>
                <li>
                    <input type="radio" <?php if($status=="Terjual"){echo "checked";} ?> name="status" id="StatusTerjual" value="Terjual"> 
                    <label for="StatusTerjual"><small>Item Sudah Terjual</small></label>
                </li>
                <li>
                    <input type="radio" <?php if($status=="Tersedia"){echo "checked";} ?> name="status" id="StatusTersedia" value="Tersedia"> 
                    <label for="StatusTersedia"><small>Item Sudah Tersedia</small></label>
                </li>
            </ul>
        </div>
    </div>
<?php }} ?>