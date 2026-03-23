<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Tangkap id_obat
    if(empty($_POST['id_obat'])){
        echo '<div class="card-body border-0 pb-0">';
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          Data ID Obat Tidak Dapat didefinisikan.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_obat=$_POST['id_obat'];
        //Buka data obat
        $QryObat = mysqli_query($Conn,"SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($Conn));
        $DataObat = mysqli_fetch_array($QryObat);
        if(empty($DataObat['id_obat'])){
            echo '<div class="card-body border-0 pb-0">';
            echo '  <div class="row">';
            echo '      <div class="col-md-6 mb-3">';
            echo '          Data Obat Tidak Ditemukan Pada Database.';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $kode= $DataObat['kode'];
            $nama_obat= $DataObat['nama_obat'];
            $kategori= $DataObat['kategori'];
            $stok= $DataObat['stok'];
            $isi= $DataObat['isi'];
            $satuan= $DataObat['satuan'];
            $harga_1= $DataObat['harga_1'];
            $harga_2= $DataObat['harga_2'];
            $harga_3= $DataObat['harga_3'];
            $harga_4= $DataObat['harga_4'];
            $stok_min= $DataObat['stok_min'];
            $updatetime= $DataObat['updatetime'];
            //Membuat kode Terbaru
            $Qry=mysqli_query($Conn, "SELECT max(id_obat_multi) as maksimal FROM obat_multi")or die(mysqli_error($Conn));
            while($Hasil=mysqli_fetch_array($Qry)){
                $NilaiMax=$Hasil['maksimal'];
            }
            $MaxKode=$NilaiMax+1;
?>
    <form action="javascript:void(0);" id="ProsesTambahMultiSatuan">
        <input type="hidden" name="id_obat" id="id_obat" value="<?php echo "$id_obat"; ?>">
        <input type="hidden" name="isi" id="isi" value="<?php echo "$isi"; ?>">
        <input type="hidden" name="stok" id="stok" value="<?php echo "$stok"; ?>">
        <input type="hidden" name="harga_1" id="harga_1" value="<?php echo "$harga_1"; ?>">
        <input type="hidden" name="harga_2" id="harga_2" value="<?php echo "$harga_2"; ?>">
        <input type="hidden" name="harga_3" id="harga_3" value="<?php echo "$harga_3"; ?>">
        <input type="hidden" name="harga_4" id="harga_4" value="<?php echo "$harga_4"; ?>">
        <div class="modal-body border-0 pb-0 mb-4">
            <div class="row">
                <div class="col-md-12">
                    <label for="">Nama Obat : <?php echo $nama_obat;?></label>
                </div>
            </div>
            <div class="row"> 
                <div class="col-md-6 mt-3">
                    <label for="kode_multi">Kode Obat</label>
                    <input type="text" name="kode_multi" id="kode_multi" class="form-control" value="<?php echo "$kode-$MaxKode"; ?>" required>
                </div>
                <div class="col-md-6 mt-3">
                    <label for="satuan_multi">Satuan</label>
                    <input type="text" name="satuan_multi" id="satuan_multi" list="Listsatuan" class="form-control" required>
                    <datalist id="Listsatuan">
                    <?php
                        $Qry=mysqli_query($Conn, "SELECT DISTINCT satuan_multi FROM obat_multi")or die(mysqli_error($Conn));
                        while($Hasil=mysqli_fetch_array($Qry)){
                            echo "<option value='$Hasil[satuan_multi]'>$Hasil[satuan_multi]</option>";
                        }
                    ?>
                </datalist>
                </div>
            </div>
            <div class="row"> 
                <div class="col-md-6 mt-3">
                    <label for="isi_multi">Isi</label>
                    <input type="text" name="isi_multi" id="isi_multi" class="form-control" required>
                </div>
                <div class="col-md-6 mt-3">
                    <label for="stok_multi">Stok</label>
                    <input type="text" name="stok_multi" id="stok_multi" class="form-control">
                </div>
            </div>
            <div class="row"> 
                <div class="col-md-6 mt-3">
                    <label for="harga_multi_1">Harga Beli</label>
                    <input type="text" name="harga_multi_1" id="harga_multi_1" class="form-control">
                </div>
                <div class="col-md-6 mt-3">
                    <label for="harga_multi_2">Harga Eceran</label>
                    <input type="text" name="harga_multi_2" id="harga_multi_2" class="form-control">
                </div>
            </div>
            <div class="row"> 
                <div class="col-md-6 mt-3">
                    <label for="harga_multi_3">Harga Grosir</label>
                    <input type="text" name="harga_multi_3" id="harga_multi_3" class="form-control">
                </div>
                <div class="col-md-6 mt-3">
                    <label for="harga_multi_4">Harga Medis</label>
                    <input type="text" name="harga_multi_4" id="harga_multi_4" class="form-control">
                </div>
            </div>
            <div class="row"> 
                <div class="col-md-12 mt-3" id="NotifikasiTambahMultiSatuan">
                    <span class="text-primary">Pastikan data multi satuan sudah sesuai</span>
                </div>
            </div>
        </div>
        <div class="modal-footer bg-inverse">
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-md btn-primary ml-2">
                            <i class="ti-save"></i> Simpan
                        </button>
                        <button type="button" class="btn btn-md btn-light ml-2" data-dismiss="modal">
                            <i class="ti-close"></i> Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
<?php }} ?>