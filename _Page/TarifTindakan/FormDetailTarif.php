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
            echo '          Data ID Obat Tidak Dapat didefinisikan.';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $nama=getDataDetail($Conn,'tarif','id_tarif',$id_tarif,'nama');
            $kategori=getDataDetail($Conn,'tarif','id_tarif',$id_tarif,'kategori');
            $tarif=getDataDetail($Conn,'tarif','id_tarif',$id_tarif,'tarif');
            //Format Harga Beli
            $tarif=number_format($tarif,0,',','.');
?>
    <div class="row mb-3">
        <div class="col col-md-4">ID Tarif</div>
        <div class="col col-md-8">
            <code class="text-secondary">
                <?php echo "$id_tarif"; ?>
            </code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Nama Tarif</div>
        <div class="col col-md-8">
            <code class="text-secondary">
                <?php echo "$nama"; ?>
            </code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Kategori</div>
        <div class="col col-md-8">
            <code class="text-secondary">
                <?php echo "$kategori"; ?>
            </code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Tarif</div>
        <div class="col col-md-8">
            <code class="text-secondary">
                <?php echo "$tarif"; ?>
            </code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <a href="index.php?Page=TarifTindakan&Sub=DetailTarif&id=<?php echo "$id_tarif"; ?>" class="btn btn-sm btn-block btn-outline-primary btn-round">
                <i class="ti-info-alt"></i> Detail Tarif & Tindakan
            </a>
        </div>
    </div>
<?php }} ?>