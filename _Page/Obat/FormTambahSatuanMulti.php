<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_obat
    if(empty($_POST['id_obat'])){
        echo '<div class="row">';
        echo '      <div class="col-md-12 text-center text-danger">';
        echo '          Data ID Obat Tidak Boleh Kosong!';
        echo '      </div>';
        echo '</div>';
    }else{
        $id_obat=$_POST['id_obat'];
        $kode=getDataDetail($Conn,'obat','id_obat',$id_obat,'kode');
        $nama=getDataDetail($Conn,'obat','id_obat',$id_obat,'nama');
        $stok=getDataDetail($Conn,'obat','id_obat',$id_obat,'stok');
        $satuan=getDataDetail($Conn,'obat','id_obat',$id_obat,'satuan');
        $isi=getDataDetail($Conn,'obat','id_obat',$id_obat,'isi');
        if(empty($kode)){
            echo '<div class="card-body border-0 pb-0">';
            echo '  <div class="row">';
            echo '      <div class="col-md-6 mb-3">';
            echo '          Data Obat Tidak Ditemukan Pada Database.';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
?>
    <div class="row mb-4">
        <div class="col-md-4"><label for="id_obat">ID Obat/Alkes</label></div>
        <div class="col-md-8">
            <input type="text" readonly class="form-control" name="id_obat" id="id_obat" value="<?php echo "$id_obat"; ?>">
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-4"><label for="nama">Nama/Merek</label></div>
        <div class="col-md-8">
            <input type="text" readonly class="form-control" name="nama" id="nama" value="<?php echo "$nama"; ?>">
            <small>
                Isi Per Satuan : 
                <span id="IsiObatUtama"><?php echo "$isi"; ?></span>/<span id="SatuanObatUtama"><?php echo "$satuan"; ?></span> 
            </small>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-4"><label for="stok_utama">Stok</label></div>
        <div class="col-md-8">
            <input type="text" readonly class="form-control" name="stok_utama" id="stok_utama" value="<?php echo "$stok"; ?>">
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-4"><label for="SatuanMulti">Satuan</label></div>
        <div class="col-md-8">
            <input type="text" class="form-control" name="satuan" id="SatuanMulti" list="ListSatuan">
            <datalist id="Listsatuan">
                <?php
                    $QrySatuanMulti=mysqli_query($Conn, "SELECT DISTINCT satuan FROM obat_satuan")or die(mysqli_error($Conn));
                    while($HasilSatuanMulti=mysqli_fetch_array($QrySatuanMulti)){
                        echo "<option value='$HasilSatuanMulti[satuan]'>";
                    }
                ?>
            </datalist>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-4"><label for="IsikemasanMulti">Isi/Kemasan</label></div>
        <div class="col-md-8">
            <input type="text" class="form-control" name="isi" id="IsikemasanMulti">
            <small>
                Stok : 
                <span id="StokSatuanMulti"><?php echo "$stok"; ?></span> <span id="PutSatuanMulti"><?php echo "$satuan"; ?></span>
            </small>
        </div>
    </div>
<?php }} ?>
<script>
    //Ketika isi pada satuan multi diubah
    $('#IsikemasanMulti').keyup(function() { 
        var IsikemasanMulti=$('#IsikemasanMulti').val();
        var stok_utama=$('#stok_utama').val();
        var IsiObatUtama=$('#IsiObatUtama').html();
        var SatuanMulti=$('#SatuanMulti').val();
        //Menghitung Stok Satuan Multi
        if(stok_utama==0){
            var StokSatuanMulti=0;
        }else{
            var StokSatuanMulti=(IsiObatUtama/IsikemasanMulti)*stok_utama;
        }
        //Terapkan pada form
        $('#StokSatuanMulti').html(StokSatuanMulti);
        $('#PutSatuanMulti').html(SatuanMulti);
    });
</script>