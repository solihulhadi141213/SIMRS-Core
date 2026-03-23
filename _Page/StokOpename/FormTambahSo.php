<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_obat'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      ID Obat Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['tanggal'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center text-danger">';
            echo '      Tanggal Periode Stok Opename Tidak Boleh Kosong!';
            echo '  </div>';
            echo '</div>';
        }else{
            if(empty($_POST['id_obat_storage'])){
                $id_obat_storage="0";
            }else{
                $id_obat_storage=$_POST['id_obat_storage'];
            }
            $id_obat=$_POST['id_obat'];
            $tanggal=$_POST['tanggal'];
            //Mencari Nama Obat
            $NamaObat=getDataDetail($Conn,'obat','id_obat',$id_obat,'nama');
            if(empty($NamaObat)){
                $LabelNamaObat='<span class="text-danger">Data Barang Tidak Diketahui!</span>';
            }else{
                $LabelNamaObat='<span class="text-secondary">'.$NamaObat.'</span>';
            }
            if(empty($id_obat_storage)){
                $LabelPenyimpanan='<span class="text-primary">Penyimpanan Utama</span>';
            }else{
                $NamaPenyimpanan=getDataDetail($Conn,'obat_storage','id_obat_storage',$id_obat_storage,'nama_penyimpanan');
                $LabelPenyimpanan='<span class="text-secondary">'.$NamaPenyimpanan.'</span>';
            }
            //Format Tanggal
            $strtotime=strtotime($tanggal);
            $FormatTanggal=date('d/m/Y',$strtotime);
            //Satuan Dan Harga
            $SatuanObat=getDataDetail($Conn,'obat','id_obat',$id_obat,'satuan');
            $HargaObat=getDataDetail($Conn,'obat','id_obat',$id_obat,'harga');
            $HargaObat = "Rp " . number_format($HargaObat,2,',','.');
            //Stok
            if(empty($id_obat_storage)){
                $stok=getDataDetail($Conn,'obat','id_obat',$id_obat,'stok');
            }else{
                //Stok di penyimpanannya
                $Qry = mysqli_query($Conn,"SELECT * FROM obat_posisi WHERE id_obat_storage='$id_obat_storage' AND id_obat='$id_obat'")or die(mysqli_error($Conn));
                $DataObat = mysqli_fetch_array($Qry);
                if(empty($DataObat['stok'])){
                    $stok="0";
                }else{
                    $stok=$DataObat['stok'];
                }
            }
            if(empty($stok)){
                $StokFormat =0;
            }else{
                $StokFormat = "" . number_format($stok,0,',','.');
            }
?>
    <input type="hidden" name="id_obat" value="<?php echo "$id_obat"; ?>">
    <input type="hidden" name="id_obat_storage" value="<?php echo "$id_obat_storage"; ?>">
    <input type="hidden" name="tanggal" value="<?php echo "$tanggal"; ?>">
    <input type="hidden" name="stok_awal" id="stok_awal" value="<?php echo "$stok"; ?>">
    <div class="row mb-3">
        <div class="col col-md-4">Obat/Alkes</div>
        <div class="col col-md-8"><code class="text-secondary"><?php echo "($id_obat) $LabelNamaObat"; ?></code></div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Penyimpanan</div>
        <div class="col col-md-8"><code class="text-secondary"><?php echo "($id_obat_storage) $LabelPenyimpanan"; ?></code></div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Tanggal</div>
        <div class="col col-md-8"><code class="text-secondary"><?php echo "$FormatTanggal"; ?></code></div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Satuan</div>
        <div class="col col-md-8"><code class="text-secondary" id="GetSatuan"><?php echo "$SatuanObat"; ?></code></div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Harga</div>
        <div class="col col-md-8"><code class="text-secondary"><?php echo "$HargaObat"; ?></code></div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Stok</div>
        <div class="col col-md-8"><code class="text-secondary"><?php echo "$StokFormat"; ?></code></div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Stok Aktual</div>
        <div class="col col-md-8">
            <input type="text" name="stok_akhir" id="stok_akhir" class="form-control" value="<?php echo "$stok"; ?>">
            <small>Selisih : <code id="PusSelisih"><span class="text-dark">0 <?php echo "$SatuanObat"; ?></span></code></small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Keterangan</div>
        <div class="col col-md-8">
            <input type="text" name="keterangan" id="keterangan" class="form-control">
            <small>Alasan/keterangan terjadinya selisih</small>
        </div>
    </div>
<?php
        }
    }
?>