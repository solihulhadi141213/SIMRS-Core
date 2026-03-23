<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_obat_so'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      ID Item Stok Opename Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_obat_so=$_POST['id_obat_so'];
        //Buka Detail
        $tanggal=getDataDetail($Conn,'obat_so','id_obat_so',$id_obat_so,'tanggal');
        $id_obat=getDataDetail($Conn,'obat_so','id_obat_so',$id_obat_so,'id_obat');
        $nama=getDataDetail($Conn,'obat_so','id_obat_so',$id_obat_so,'nama');
        $kode=getDataDetail($Conn,'obat_so','id_obat_so',$id_obat_so,'kode');
        $id_obat_storage=getDataDetail($Conn,'obat_so','id_obat_so',$id_obat_so,'id_obat_storage');
        $nama_penyimpanan=getDataDetail($Conn,'obat_so','id_obat_so',$id_obat_so,'nama_penyimpanan');
        $satuan=getDataDetail($Conn,'obat_so','id_obat_so',$id_obat_so,'satuan');
        $harga=getDataDetail($Conn,'obat_so','id_obat_so',$id_obat_so,'harga');
        $stok_awal=getDataDetail($Conn,'obat_so','id_obat_so',$id_obat_so,'stok_awal');
        $stok_akhir=getDataDetail($Conn,'obat_so','id_obat_so',$id_obat_so,'stok_akhir');
        $stok_selisih=getDataDetail($Conn,'obat_so','id_obat_so',$id_obat_so,'stok_selisih');
        $keterangan=getDataDetail($Conn,'obat_so','id_obat_so',$id_obat_so,'keterangan');
        $updatetime=getDataDetail($Conn,'obat_so','id_obat_so',$id_obat_so,'updatetime');
        //Format
        $strtotime=strtotime($tanggal);
        $strtotime2=strtotime($updatetime);
        $TanggalFormat=date('d/m/Y',$strtotime);
        $UpdatetimeFormat=date('d/m/Y H:i T',$strtotime2);
        $HargaRp = "Rp " . number_format($harga,2,',','.');
?>
    <input type="hidden" name="id_obat_so" value="<?php echo "$id_obat_so"; ?>">
    <input type="hidden" name="stok_awal" id="stok_awal" value="<?php echo "$stok_awal"; ?>">
    <div class="row mb-3">
        <div class="col col-md-4">Obat/Alkes</div>
        <div class="col col-md-8"><code class="text-secondary"><?php echo "($id_obat) $nama"; ?></code></div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Penyimpanan</div>
        <div class="col col-md-8"><code class="text-secondary"><?php echo "($id_obat_storage) $nama_penyimpanan"; ?></code></div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Tanggal</div>
        <div class="col col-md-8"><code class="text-secondary"><?php echo "$TanggalFormat"; ?></code></div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Satuan</div>
        <div class="col col-md-8"><code class="text-secondary" id="GetSatuan"><?php echo "$satuan"; ?></code></div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Harga</div>
        <div class="col col-md-8"><code class="text-secondary"><?php echo "$HargaRp"; ?></code></div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Stok</div>
        <div class="col col-md-8"><code class="text-secondary"><?php echo "$stok_akhir"; ?></code></div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Stok Aktual</div>
        <div class="col col-md-8">
            <input type="text" name="stok_akhir" id="stok_akhir" class="form-control" value="<?php echo "$stok_akhir"; ?>">
            <small>Selisih : <code id="PusSelisih"><span class="text-dark"> <?php echo "$stok_selisih $satuan"; ?></span></code></small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Keterangan</div>
        <div class="col col-md-8">
            <input type="text" name="keterangan" id="keterangan" class="form-control">
            <small>Alasan/keterangan terjadinya selisih</small>
        </div>
    </div>
<?php } ?>