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
        //Tangkap id_obat_storage
        if(empty($_POST['id_obat_storage'])){
            echo '<div class="row">';
            echo '      <div class="col-md-12 text-center text-danger">';
            echo '          Data ID Obat Storage Tidak Boleh Kosong!';
            echo '      </div>';
            echo '</div>';
        }else{
            $id_obat=$_POST['id_obat'];
            $id_obat_storage=$_POST['id_obat_storage'];
            //Buka Obat
            $kode=getDataDetail($Conn,'obat','id_obat',$id_obat,'kode');
            if(empty($kode)){
                echo '<div class="card-body border-0 pb-0">';
                echo '  <div class="row">';
                echo '      <div class="col-md-6 mb-3">';
                echo '          Data Obat Tidak Ditemukan Pada Database.';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
            }else{
                $nama=getDataDetail($Conn,'obat','id_obat',$id_obat,'nama');
                $stok=getDataDetail($Conn,'obat','id_obat',$id_obat,'stok');
                $satuan=getDataDetail($Conn,'obat','id_obat',$id_obat,'satuan');
                $isi=getDataDetail($Conn,'obat','id_obat',$id_obat,'isi');
                //Buka Storage
                $nama_penyimpanan=getDataDetail($Conn,'obat_storage','id_obat_storage',$id_obat_storage,'nama_penyimpanan');
                if(empty($nama_penyimpanan)){
                    echo '<div class="card-body border-0 pb-0">';
                    echo '  <div class="row">';
                    echo '      <div class="col-md-6 mb-3">';
                    echo '          Data Penyimpanan Tidak Ditemukan Pada Database.';
                    echo '      </div>';
                    echo '  </div>';
                    echo '</div>';
                }else{
                    //Buka Posisi
                    $QryPosisi = mysqli_query($Conn,"SELECT * FROM obat_posisi WHERE id_obat='$id_obat' AND id_obat_storage='$id_obat_storage'")or die(mysqli_error($Conn));
                    $DataPosisi = mysqli_fetch_array($QryPosisi);
                    if(empty($DataPosisi['stok'])){
                        $StokPosisi=0;
                    }else{
                        $StokPosisi=$DataPosisi['stok'];
                    }
?>
    <div class="row mb-4">
        <div class="col-md-4"><label for="id_obat">ID Obat/Alkes</label></div>
        <div class="col-md-8">
            <input type="text" readonly class="form-control" name="id_obat" id="id_obat" value="<?php echo "$id_obat"; ?>">
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-4"><label for="id_obat_storage">ID Penyimpanan</label></div>
        <div class="col-md-8">
            <input type="text" readonly class="form-control" name="id_obat_storage" id="id_obat_storage" value="<?php echo "$id_obat_storage"; ?>">
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-4"><label for="nama">Nama/Merek</label></div>
        <div class="col-md-8">
            <input type="text" readonly class="form-control" name="nama" id="nama" value="<?php echo "$nama"; ?>">
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-4"><label for="nama_penyimpanan">Tempat Penyimpanan</label></div>
        <div class="col-md-8">
            <input type="text" readonly class="form-control" name="nama_penyimpanan" id="nama_penyimpanan" value="<?php echo "$nama_penyimpanan"; ?>">
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-4"><label for="StokPosisi">Stok</label></div>
        <div class="col-md-8">
            <input type="text" class="form-control" name="StokPosisi" id="StokPosisi" value="<?php echo "$StokPosisi"; ?>">
        </div>
    </div>
<?php }}}} ?>