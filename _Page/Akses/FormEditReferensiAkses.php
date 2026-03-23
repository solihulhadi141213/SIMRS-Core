<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_akses_ref
    if(empty($_POST['id_akses_ref'])){
        echo '<div class="card-body border-0 pb-0">';
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          Data ID Referensi Akses Tidak Dapat didefinisikan.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_akses_ref=$_POST['id_akses_ref'];
        $nama_fitur=getDataDetail($Conn,'akses_ref','id_akses_ref',$id_akses_ref,'nama_fitur');
        $kategori=getDataDetail($Conn,'akses_ref','id_akses_ref',$id_akses_ref,'kategori');
        $kode=getDataDetail($Conn,'akses_ref','id_akses_ref',$id_akses_ref,'kode');
        $keterangan=getDataDetail($Conn,'akses_ref','id_akses_ref',$id_akses_ref,'keterangan');
?>
    <input type="hidden" name="id_akses_ref" value="<?php echo "$id_akses_ref"; ?>">
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="nama_fitur">Nama Fitur</label>
            <input type="text" class="form-control" id="nama_fitur" name="nama_fitur" value="<?php echo "$nama_fitur"; ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="kategori">Kategori Fitur</label>
            <input type="text" class="form-control" id="kategori" name="kategori" list="ListKategori" value="<?php echo "$kategori"; ?>">
            <datalist id="ListKategori">
                <?php
                    $QryKategori = mysqli_query($Conn, "SELECT DISTINCT kategori FROM akses_ref ORDER BY kategori ASC");
                    while ($Datakategori = mysqli_fetch_array($QryKategori)) {
                        $KategoriList= $Datakategori['kategori'];
                        echo '<option value="'.$KategoriList.'">';
                    }
                ?>
            </datalist>
            <small>Klik 2 kali untuk melihat datalist kategori yang sudah ada</small>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="kode">Kode Fitur</label>
            <div class="input-group">
                <input type="text" class="form-control" id="kode2" name="kode" value="<?php echo "$kode"; ?>">
                <button type="button" class="btn btn-sm btn-secondary" id="GenerateKodeFitur2" title="Generate Kode">
                    <i class="ti ti-reload"></i>
                </button>
            </div>
            
            <small>Maksimal 15 karakter huruf & angka</small>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="keterangan">Keterangan Singkat</label>
            <textarea name="keterangan" id="keterangan" cols="30" rows="3" class="form-control"><?php echo "$keterangan"; ?></textarea>
        </div>
    </div>
<?php } ?>