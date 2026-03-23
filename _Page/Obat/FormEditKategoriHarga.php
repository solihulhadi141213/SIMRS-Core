<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Tangkap id_kategori_harga
    if(empty($_POST['id_kategori_harga'])){
        echo '<div class="row">';
        echo '  <div class="col-md-6 mb-3">';
        echo '      ID Kategori Harga Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_kategori_harga=$_POST['id_kategori_harga'];
        //Buka data obat
        $QryKategoriHargaObat = mysqli_query($Conn,"SELECT * FROM obat_kategori_harga WHERE id_kategori_harga='$id_kategori_harga'")or die(mysqli_error($Conn));
        $DataKategoriHargaObat = mysqli_fetch_array($QryKategoriHargaObat);
        if(empty($DataKategoriHargaObat['id_kategori_harga'])){
            echo '<div class="row">';
            echo '  <div class="col-md-6 mb-3">';
            echo '      Kategori Harga Tidak Valid!';
            echo '  </div>';
            echo '</div>';
        }else{
            $kategori_harga=$DataKategoriHargaObat['kategori_harga'];
            $keterangan=$DataKategoriHargaObat['keterangan'];
?>
    <input type="hidden" name="id_kategori_harga" value="<?php echo "$id_kategori_harga"; ?>">
    <div class="row mb-3">
        <div class="col-md-12">
            <label for="kategori_harga">Kategori Harga</label>
            <input type="text" name="kategori_harga" id="kategori_harga" class="form-control" value="<?php echo "$kategori_harga"; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <label for="keterangan">Keterangan</label>
            <textarea name="keterangan" id="keterangan" class="form-control"><?php echo "$keterangan"; ?></textarea>
        </div>
    </div>
<?php
        }
    }
?>