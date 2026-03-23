<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_cost
    if(empty($_POST['id_cost'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      Data ID Unit Cost Tidak Boleh Kosong.';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_cost=$_POST['id_cost'];
        $id_cost=getDataDetail($Conn,'tarif_cost','id_cost',$id_cost,'id_cost');
        //Buka data obat
        if(empty($id_cost)){
            echo '<div class="card-body border-0 pb-0">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-center text-danger">';
            echo '          ID Unit Cost Tidak Valid Karena Tidak Ditemukan Pada Database.';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $nama=getDataDetail($Conn,'tarif_cost','id_cost',$id_cost,'nama');
            $cost=getDataDetail($Conn,'tarif_cost','id_cost',$id_cost,'cost');
?>
    <input type="hidden" name="id_cost" id="id_cost" value="<?php echo "$id_cost"; ?>">
    <div class="row mb-3">
        <div class="col-md-12">
            <label for="nama">Nama Unit Cost</label>
            <input type="text" class="form-control" name="nama" id="nama" value="<?php echo "$nama"; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <label for="cost">Nilai Cost (Rp)</label>
            <input type="number" class="form-control" name="cost" id="cost" value="<?php echo "$cost"; ?>">
        </div>
    </div>
<?php }} ?>