<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //Tangkap id_obat
    if(empty($_POST['id_obat'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 mb-3 text-center text-danger">';
        echo '      ID Obat Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_obat=$_POST['id_obat'];
        //Buka data obat
        $QryObat = mysqli_query($Conn,"SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($Conn));
        $DataObat = mysqli_fetch_array($QryObat);
        if(empty($DataObat['id_obat'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center text-danger">';
            echo '      ID Obat Tidak Valid';
            echo '  </div>';
            echo '</div>';
        }else{
            $SatuanUtama=$DataObat['satuan'];
?>
    <input type="hidden" name="id_obat" id="id_obat" value="<?php echo "$id_obat"; ?>">
    <div class="row mb-4"> 
        <div class="col-md-4">
            <label for="batch">Nomor Batch</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="batch" id="batch" class="form-control">
        </div>
    </div>
    <div class="row mb-4"> 
        <div class="col-md-4">
            <label for="qty">QTY/Jumlah</label>
        </div>
        <div class="col-md-8">
            <input type="number" min="1" step="1" name="qty" id="qty" class="form-control" value="1">
        </div>
    </div>
    <div class="row mb-4"> 
        <div class="col-md-4">
            <label for="satuan">Satuan</label>
        </div>
        <div class="col-md-8">
            <select name="satuan" id="satuan" class="form-control">
                <option value="<?php echo $SatuanUtama;?>"><?php echo $SatuanUtama;?></option>
                <?php
                    //Buka List Satuan
                    $QrySatuan = mysqli_query($Conn, "SELECT*FROM obat_satuan WHERE id_obat='$id_obat' ORDER BY id_obat_multi ASC");
                    while ($DataSatuan = mysqli_fetch_array($QrySatuan)) {
                        $id_obat_multi= $DataSatuan['id_obat_multi'];
                        $SatuanMulti= $DataSatuan['satuan'];
                        echo '<option value="'.$SatuanMulti.'">'.$SatuanMulti.'</option>';
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
            <input type="date" name="expired" id="expired" class="form-control">
        </div>
    </div>
    <div class="row mb-4"> 
        <div class="col-md-4">
            <label for="ingatkan">Tanggal Peringatan</label>
        </div>
        <div class="col-md-8">
            <input type="date" name="ingatkan" id="ingatkan" class="form-control">
        </div>
    </div>
    <div class="row mb-4"> 
        <div class="col-md-4">
            <label for="status">Status</label>
        </div>
        <div class="col-md-8">
            <select name="status" id="status" class="form-control">
                <option value="Tersedia">Tersedia</option>
                <option value="Terjual">Terjual</option>
            </select>
        </div>
    </div>
<?php }} ?>