<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_transaksi
    if(empty($_POST['id_transaksi'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 mb-3 text-center text-danger">';
        echo '      ID Transaksi Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_transaksi=$_POST['id_transaksi'];
        $kode=getDataDetail($Conn,'transaksi','id_transaksi',$id_transaksi,'kode');
        if(empty($kode)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center text-danger">';
            echo '      ID Transaksi '.$id_transaksi.' Tersebut Tidak Valid Atau Tidak Terdaftar!';
            echo '  </div>';
            echo '</div>';
        }else{
            //Hitung Rincian Transaksi
            $JumlahRincian = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM transaksi_rincian WHERE kode='$kode'"));
            if(empty($JumlahRincian)){
                echo '<div class="row">';
                echo '  <div class="col-md-12 mb-3 text-center text-danger">';
                echo '      Tidak Ada Rincian Untuk Transaksi Ini';
                echo '  </div>';
                echo '</div>';
            }else{
                $no=1;
                $JumlahTransaksi=0;
                $query = mysqli_query($Conn, "SELECT*FROM transaksi_rincian WHERE kode='$kode' ORDER BY id_rincian ASC");
                while ($data = mysqli_fetch_array($query)) {
                    $id_rincian= $data['id_rincian'];
                    $kategori= $data['kategori'];
                    $id_obat_tindakan= $data['id_obat_tindakan'];
                    $nama= $data['nama'];
                    $qty= $data['qty'];
                    $satuan= $data['satuan'];
                    $harga= $data['harga'];
                    $ppn= $data['ppn'];
                    $diskon= $data['diskon'];
                    $jumlah= $data['jumlah'];
                    $klaim= $data['klaim'];
                    $retur= $data['retur'];
                    $updatetime= $data['updatetime'];
                    //Format Subtotal
                    $HargaFormat = "Rp " . number_format($harga, 0, ',', '.');
                    $PpnFormat = "Rp " . number_format($ppn, 0, ',', '.');
                    $DiskonFormat = "Rp " . number_format($diskon, 0, ',', '.');
                    $JumlahFormat = "Rp " . number_format($jumlah, 0, ',', '.');
                    //Format Tanggal
                    $strtotime=strtotime($updatetime);
                    $UpdatetimeFormat=date('d/m/Y H:i:s T',$strtotime);
                    //Tambah Masing-masing Rincian
                    $JumlahTransaksi=$JumlahTransaksi+$jumlah;
?>
    <div class="row mb-3 sub-title">
        <div class="col col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <dt>
                        <?php echo "$no. $nama"; ?>
                    </dt>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <ul class="ml-3">
                        <li><small class="text-secondary"><?php echo "$UpdatetimeFormat"; ?></small></li>
                        <li>ID.Rincian : <span class="text-secondary"><?php echo "$id_rincian"; ?></span></li>
                        <li>Kategori : <span class="text-secondary"><?php echo "$kategori"; ?></span></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <ul class="ml-3">
                        <li>QTY : <span class="text-secondary"><?php echo "$qty $satuan"; ?></span></li>
                        <li>Klaim : <span class="text-secondary"><?php echo "$klaim"; ?></span></li>
                        <li>Harga : <span class="text-secondary"><?php echo "$HargaFormat"; ?></span></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <ul class="ml-3">
                        <li>PPN : <span class="text-secondary"><?php echo "$PpnFormat"; ?></span></li>
                        <li>Diskon : <span class="text-secondary"><?php echo "$DiskonFormat"; ?></span></li>
                        <li>Jumlah : <span class="text-secondary"><?php echo "$JumlahFormat"; ?></span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php
                    $no++;
                }
            }
        }
    } 
    $SubtotalFormat = "Rp " . number_format($JumlahTransaksi, 0, ',', '.');
?>
    <div class="row mb-3 sub-title">
        <div class="col col-md-8 text-right">
            <dt>SUBTOTAL</dt>
        </div>
        <div class="col col-md-4">
            <span class="ml-3 text-secondary">
                <?php echo "$SubtotalFormat"; ?>
            </span>
        </div>
    </div>