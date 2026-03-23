<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_tarif
    if(empty($_POST['id_tarif'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      Data ID Tarif Tidak Boleh Kosong.';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_tarif=$_POST['id_tarif'];
        $id_tarif=getDataDetail($Conn,'tarif','id_tarif',$id_tarif,'id_tarif');
        //Buka data obat
        if(empty($id_tarif)){
            echo '<div class="card-body border-0 pb-0">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-center text-danger">';
            echo '          Data ID Tarif Tidak Valid karena Tidak Ditemukan Pada Database.';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $nama=getDataDetail($Conn,'tarif','id_tarif',$id_tarif,'nama');
            $kategori=getDataDetail($Conn,'tarif','id_tarif',$id_tarif,'kategori');
            $tarif=getDataDetail($Conn,'tarif','id_tarif',$id_tarif,'tarif');
?>
    <script>
        //Ketika Kategori diketik
    $('#kategori2').keyup(function(){
        var kategori=$('#kategori2').val();
        var charCount = kategori.length;
        if(charCount>1){
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/TarifTindakan/SelectKategori.php',
                data 	    :  {kategori: kategori},
                success     : function(data){
                    $('#ListKategori2').html(data);
                }
            });
        }
    });
    </script>
    <input type="hidden" name="id_tarif" id="id_tarif" value="<?php echo "$id_tarif"; ?>">
    <div class="row mb-3">
        <div class="col-md-12">
            <label for="nama">Nama Tarif</label>
            <input type="text" class="form-control" name="nama" id="nama" value="<?php echo "$nama"; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <label for="kategori">Kategori Tarif</label>
            <input type="text" class="form-control" name="kategori" id="kategori2" list="ListKategori2" value="<?php echo "$kategori"; ?>">
            <datalist id="ListKategori2"></datalist>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <label for="tarif">Tarif</label>
            <input type="number" class="form-control" name="tarif" id="tarif" value="<?php echo "$tarif"; ?>">
        </div>
    </div>
<?php }} ?>