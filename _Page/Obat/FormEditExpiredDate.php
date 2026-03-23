<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_obat_expired
    if(empty($_POST['id_obat_expired'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 mb-3 text-center text-danger">';
        echo '      ID Expired Obat Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_obat_expired=$_POST['id_obat_expired'];
        //Buka data obat
        $id_obat_expired=getDataDetail($Conn,'obat_expired','id_obat_expired',$id_obat_expired,'id_obat_expired');
        if(empty($id_obat_expired)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center text-danger">';
            echo '      ID Expired Tidak Valid';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_obat=getDataDetail($Conn,'obat_expired','id_obat_expired',$id_obat_expired,'id_obat');
            $SatuanUtama=getDataDetail($Conn,'obat','id_obat',$id_obat,'satuan');
            $batch=getDataDetail($Conn,'obat_expired','id_obat_expired',$id_obat_expired,'batch');
            $satuan=getDataDetail($Conn,'obat_expired','id_obat_expired',$id_obat_expired,'satuan');
            $qty=getDataDetail($Conn,'obat_expired','id_obat_expired',$id_obat_expired,'qty');
            $expired=getDataDetail($Conn,'obat_expired','id_obat_expired',$id_obat_expired,'expired');
            $ingatkan=getDataDetail($Conn,'obat_expired','id_obat_expired',$id_obat_expired,'ingatkan');
            $status=getDataDetail($Conn,'obat_expired','id_obat_expired',$id_obat_expired,'status');
?>
    <input type="hidden" name="id_obat_expired" id="id_obat_expired" value="<?php echo "$id_obat_expired"; ?>">
    <div class="row mb-4"> 
        <div class="col-md-4">
            <label for="batch">Nomor Batch</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="batch" id="batch" class="form-control" value="<?php echo $batch; ?>">
        </div>
    </div>
    <div class="row mb-4"> 
        <div class="col-md-4">
            <label for="qty">QTY/Jumlah</label>
        </div>
        <div class="col-md-8">
            <input type="number" min="1" step="1" name="qty" id="qty" class="form-control" value="<?php echo $qty; ?>">
        </div>
    </div>
    <div class="row mb-4"> 
        <div class="col-md-4">
            <label for="satuan">Satuan</label>
        </div>
        <div class="col-md-8">
            <select name="satuan" id="satuan" class="form-control">
                <option <?php if($satuan==$SatuanUtama){echo "selected";} ?> value="<?php echo $SatuanUtama;?>"><?php echo $SatuanUtama;?></option>
                <?php
                    //Buka List Satuan
                    $QrySatuan = mysqli_query($Conn, "SELECT*FROM obat_satuan WHERE id_obat='$id_obat' ORDER BY id_obat_multi ASC");
                    while ($DataSatuan = mysqli_fetch_array($QrySatuan)) {
                        $id_obat_multi= $DataSatuan['id_obat_multi'];
                        $SatuanMulti= $DataSatuan['satuan'];
                        if($satuan==$SatuanMulti){
                            echo '<option selected value="'.$SatuanMulti.'">'.$SatuanMulti.'</option>';
                        }else{
                            echo '<option value="'.$SatuanMulti.'">'.$SatuanMulti.'</option>';
                        }
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="row mb-4"> 
        <div class="col-md-4">
            <label for="expired">Tanggal Expired</label>
        </div>
        <div class="col-md-8">
            <input type="date" name="expired" id="expired" class="form-control" value="<?php echo $expired; ?>">
        </div>
    </div>
    <div class="row mb-4"> 
        <div class="col-md-4">
            <label for="ingatkan">Tanggal Peringatan</label>
        </div>
        <div class="col-md-8">
            <input type="date" name="ingatkan" id="ingatkan" class="form-control" value="<?php echo $ingatkan; ?>">
        </div>
    </div>
    <div class="row mb-4"> 
        <div class="col-md-4">
            <label for="status">Status</label>
        </div>
        <div class="col-md-8">
            <select name="status" id="status" class="form-control">
                <option <?php if($status=="Tersedia"){echo "selected";} ?> value="Tersedia">Tersedia</option>
                <option <?php if($status=="Terjual"){echo "selected";} ?> value="Terjual">Terjual</option>
            </select>
        </div>
    </div>
<?php }} ?>