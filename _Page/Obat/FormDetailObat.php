<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_obat
    if(empty($_POST['id_obat'])){
        echo '<div class="card-body border-0 pb-0">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center text-danger">';
        echo '          Data ID Obat Tidak Dapat didefinisikan.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_obat=$_POST['id_obat'];
        $id_obat=getDataDetail($Conn,'obat','id_obat',$id_obat,'id_obat');
        //Buka data obat
        if(empty($id_obat)){
            echo '<div class="card-body border-0 pb-0">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-center text-danger">';
            echo '          Data ID Obat Tidak Dapat didefinisikan.';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $kode=getDataDetail($Conn,'obat','id_obat',$id_obat,'kode');
            $nama=getDataDetail($Conn,'obat','id_obat',$id_obat,'nama');
            $kode=getDataDetail($Conn,'obat','id_obat',$id_obat,'kode');
            $kelompok=getDataDetail($Conn,'obat','id_obat',$id_obat,'kelompok');
            $kategori=getDataDetail($Conn,'obat','id_obat',$id_obat,'kategori');
            $satuan=getDataDetail($Conn,'obat','id_obat',$id_obat,'satuan');
            $isi=getDataDetail($Conn,'obat','id_obat',$id_obat,'isi');
            $stok=getDataDetail($Conn,'obat','id_obat',$id_obat,'stok');
            $harga=getDataDetail($Conn,'obat','id_obat',$id_obat,'harga');
            $stok_min=getDataDetail($Conn,'obat','id_obat',$id_obat,'stok_min');
            $keterangan=getDataDetail($Conn,'obat','id_obat',$id_obat,'keterangan');
            $tanggal=getDataDetail($Conn,'obat','id_obat',$id_obat,'tanggal');
            $updatetime=getDataDetail($Conn,'obat','id_obat',$id_obat,'updatetime');
            //Format Harga Beli
            $harga=number_format($harga,0,',','.');
            //Format Tanggal
            $strtotime1=strtotime($tanggal);
            $strtotime2=strtotime($updatetime);
            $TanggalInput=date('d/m/Y H:i',$strtotime1);
            $UpdateTime=date('d/m/Y H:i',$strtotime2);
?>
    <div class="row mb-3">
        <div class="col col-md-4">Kode</div>
        <div class="col col-md-8">
            <code class="text-secondary">
                <?php echo "$kode"; ?>
            </code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Nama/Merek</div>
        <div class="col col-md-8">
            <code class="text-secondary">
                <?php echo "$nama"; ?>
            </code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Kelompok</div>
        <div class="col col-md-8">
            <code class="text-secondary">
                <?php echo "$kelompok"; ?>
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
        <div class="col col-md-4">Satuan</div>
        <div class="col col-md-8">
            <code class="text-secondary">
                <?php echo "$satuan"; ?>
            </code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Isi</div>
        <div class="col col-md-8">
            <code class="text-secondary">
                <?php echo "$isi"; ?>
            </code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Stok</div>
        <div class=" col col-md-8">
            <code class="text-secondary">
                <?php echo "$stok"; ?>
            </code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Harga Beli</div>
        <div class=" col col-md-8">
            <code class="text-secondary">
                <?php echo "$harga"; ?>
            </code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-12">Harga Multi</div>
    </div>
    <?php
        $JumlahKategori = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_kategori_harga"));
        //Apabila Kategori Ada Maka Buka List Datanya
        if(empty($JumlahKategori)){
            echo '<div class="row mb-3">';
            echo '  <div class="col col-md-12"><code class="text-danger">Tidak Ada Multi Harga</code></div>';
            echo '</div>';
        }else{
            $no=1;
            $query = mysqli_query($Conn, "SELECT*FROM obat_kategori_harga ORDER BY kategori_harga ASC");
            while ($data = mysqli_fetch_array($query)) {
                $id_kategori_harga= $data['id_kategori_harga'];
                $kategori_harga= $data['kategori_harga'];
                //Buka Harga Multi
                $QryView = mysqli_query($Conn,"SELECT * FROM obat_harga WHERE id_kategori_harga='$id_kategori_harga' AND id_obat='$id_obat'")or die(mysqli_error($Conn));
                $DataView = mysqli_fetch_array($QryView);
                if(!empty($DataView['harga'])){
                    $harga_multi = $DataView['harga'];
                    $harga_multi=number_format($harga_multi,0,',','.');
                }else{
                    $harga_multi ="None";
                }
                echo '<div class="row mb-3">';
                echo '  <div class="col col-md-4">'.$no.'. '.$kategori_harga.'</div>';
                echo '  <div class="col col-md-8"><code class="text-secondary">'.$harga_multi.'</code></div>';
                echo '</div>';
                $no++;
            }
        }
    ?>
    <div class="row mb-3">
        <div class="col col-md-4">Tanggal Input</div>
        <div class=" col col-md-8">
            <code class="text-secondary">
                <?php echo "$TanggalInput"; ?>
            </code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Update Time</div>
        <div class=" col col-md-8">
            <code class="text-secondary">
                <?php echo "$UpdateTime"; ?>
            </code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <a href="index.php?Page=Obat&Sub=DetailObat&id=<?php echo "$id_obat"; ?>" class="btn btn-sm btn-block btn-outline-primary btn-round">
                <i class="ti-info-alt"></i> Detail Obat/Alkes
            </a>
        </div>
    </div>
<?php }} ?>