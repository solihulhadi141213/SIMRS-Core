<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_obat_so'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      ID Stok Opename Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
            $id_obat_so=$_POST['id_obat_so'];
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
            //Format Tanggal
            $strtotime=strtotime($tanggal);
            $strtotime2=strtotime($updatetime);
            $TanggalFormat=date('d/m/Y',$strtotime);
            $UpdatetimeFormat=date('d/m/Y H:i T',$strtotime2);
            //Format Harga
            $HargaRp = "Rp " . number_format($harga,2,',','.');
?>
    <div class="row mb-3">
        <div class="col col-md-4">ID/Tgl SO</div>
        <div class="col col-md-8"><code class="text-secondary"><?php echo "($id_obat_so) $TanggalFormat"; ?></code></div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Penyimpanan</div>
        <div class="col col-md-8"><code class="text-secondary"><?php echo "($id_obat_storage) $nama_penyimpanan"; ?></code></div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">ID/Kode Barang</div>
        <div class="col col-md-8"><code class="text-secondary"><?php echo "($id_obat) $kode"; ?></code></div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Nama Barang</div>
        <div class="col col-md-8"><code class="text-secondary"><?php echo " $nama"; ?></code></div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Harga/Satuan</div>
        <div class="col col-md-8"><code class="text-secondary"><?php echo "$HargaRp/$satuan"; ?></code></div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Stok Awal</div>
        <div class="col col-md-8"><code class="text-secondary"><?php echo "$stok_awal $satuan"; ?></code></div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Stok Akhir</div>
        <div class="col col-md-8"><code class="text-secondary"><?php echo "$stok_akhir $satuan"; ?></code></div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Stok Selisih</div>
        <div class="col col-md-8"><code class="text-secondary"><?php echo "$stok_selisih $satuan"; ?></code></div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Keterangan</div>
        <div class="col col-md-8"><code class="text-secondary"><?php echo "$keterangan"; ?></code></div>
    </div>
    <div class="row mb-4">
        <div class="col col-md-4">Updatetime</div>
        <div class="col col-md-8"><code class="text-secondary"><?php echo "$UpdatetimeFormat"; ?></code></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12 text-center">
            <div class="btn-group">
                <button type="button" class="btn btn-sm btn-outline-dark btn-round "  data-toggle="modal" data-target="#ModalEditStokOpenameItem" data-id="<?php echo "$id_obat_so" ?>">
                    <i class="ti ti-pencil"></i> Edit
                </button>
                <button type="button" class="btn btn-sm btn-outline-dark btn-round" data-toggle="modal" data-target="#ModalHapusStokOpenameItem" data-id="<?php echo "$id_obat_so" ?>">
                    <i class="ti ti-trash"></i> Hapus
                </button>
            </div>
        </div>
    </div>
<?php } ?>