<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_supplier
    if(empty($_POST['id_supplier'])){
        echo '<input type="hidden" name="id_supplier" id="GetIdSupplierForDelete" value="0">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 mb-3 text-center text-danger">';
        echo '          ID Supplier Tidak Boleh Kosong!';
        echo '      </div>';
        echo '  </div>';
    }else{
        $id_supplier=$_POST['id_supplier'];
        $IdSupplier=getDataDetail($Conn,'supplier','id_supplier',$id_supplier,'id_supplier');
        if(empty($IdSupplier)){
            echo '<input type="hidden" name="id_supplier" id="GetIdSupplierForDelete" value="0">';
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center text-danger">';
            echo '      ID Supplier Tersebut Tidak Valid Atau Tidak Terdaftar!';
            echo '  </div>';
            echo '</div>';
        }else{
            $nama=getDataDetail($Conn,'supplier','id_supplier',$id_supplier,'nama');
            $company=getDataDetail($Conn,'supplier','id_supplier',$id_supplier,'company');
            //Hitung Keberadaan Data Transaksi
            $JumlahDataTransaksiSupplier = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM transaksi WHERE id_supplier='$id_supplier'"));
            if(!empty($JumlahDataTransaksiSupplier)){
                echo '<input type="hidden" name="id_supplier" id="GetIdSupplierForDelete" value="0">';
                echo '<div class="row">';
                echo '  <div class="col-md-12 mb-3 text-center text-danger">';
                echo '      Anda tidak bisa menghapus supplier ini karena sudah memeliki data <i>Transaksi</i>. Untuk menghapus data ini, pastikan dupu supplier tidak memiliki data transaksi tersebut.';
                echo '  </div>';
                echo '</div>';
            }else{
?>
    <input type="hidden" name="id_supplier" id="GetIdSupplierForDelete" value="<?php echo "$id_supplier"; ?>">
    <div class="row mt-2 mb-2"> 
        <div class="col-md-12 text-center">
            <img src="assets/images/question.gif" alt="" width="70%">
        </div>
    </div>
    <div class="row mt-2 mb-2"> 
        <div class="col-md-12 text-center">
            Konfirmasi hapus data supplier atas nama <dt><?php echo "$nama"; ?></dt>
        </div>
    </div>
<?php }}} ?>