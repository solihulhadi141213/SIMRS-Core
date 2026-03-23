<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <dt class="card-title">
                    1. Penyimpanan Utama
                </dt>
            </div>
            <div class="card-body">
                <?php
                    //Hitung Jumlah Sesi
                    $JumlahSesiSo = mysqli_num_rows(mysqli_query($Conn, "SELECT DISTINCT tanggal FROM obat_so WHERE id_obat_storage='0'"));
                    //Hitung Jumlah Item Obat
                    $JumlahItemObat = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat"));
                    //Jumlah Record SO
                    $JumlahRecordSo = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_so WHERE id_obat_storage='0'"));
                    //SO Terakhir Kali
                    $QrySoTerakhirKali = mysqli_query($Conn,"SELECT * FROM obat_so WHERE id_obat_storage='0'ORDER BY tanggal DESC")or die(mysqli_error($Conn));
                    $QrDataSoTerakhirKali = mysqli_fetch_array($QrySoTerakhirKali);
                    if(empty($QrDataSoTerakhirKali['tanggal'])){
                        $SoTerakhirKali='<code>Belum Ada</code>';
                    }else{
                        $tanggal=$QrDataSoTerakhirKali['tanggal'];
                        $strtotime=strtotime($tanggal);
                        $SoTerakhirKali=date('d/m/Y H:i:s T',$strtotime);
                        $SoTerakhirKali='<code class="text-secondary">'.$SoTerakhirKali.'</code>';
                    }
                    //Format jumlah
                    $JumlahItemObat=number_format($JumlahItemObat,0,',','.');
                    $JumlahRecordSo=number_format($JumlahRecordSo,0,',','.');
                    echo '<ol>';
                    echo '  <li>Item Barang : <code class="text-secondary">'.$JumlahItemObat.'</code></li>';
                    echo '  <li>Sesi Opename : <code class="text-secondary">'.$JumlahSesiSo.'</code></li>';
                    echo '  <li>Record Opename : <code class="text-secondary">'.$JumlahRecordSo.'</code></li>';
                    echo '  <li>Last Update: '.$SoTerakhirKali.'</li>';
                    echo '</ol>';
                ?>
            </div>
            <div class="card-footer">
                <a href="index.php?Page=StokOpename&Sub=StokOpenameByStorage" class="btn btn-sm btn-block btn-round btn-outline-dark">
                    Lihat Selengkapnya <i class="ti ti-more"></i>
                </a>
            </div>
        </div>
    </div>
    <?php
        $no=2;
        $query = mysqli_query($Conn, "SELECT*FROM obat_storage ORDER BY id_obat_storage DESC");
        while ($data = mysqli_fetch_array($query)) {
            $id_obat_storage= $data['id_obat_storage'];
            $nama_penyimpanan= $data['nama_penyimpanan'];
    ?>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <dt class="card-title">
                        <?php echo "$no. $nama_penyimpanan"; ?>
                    </dt>
                </div>
                <div class="card-body">
                    <?php
                        //Hitung Jumlah Sesi
                        $JumlahSesiSo = mysqli_num_rows(mysqli_query($Conn, "SELECT DISTINCT tanggal FROM obat_so WHERE id_obat_storage='$id_obat_storage'"));
                        //Hitung Jumlah Item Obat
                        $JumlahItemObat = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_posisi WHERE id_obat_storage='$id_obat_storage'"));
                        //Jumlah Record SO
                        $JumlahRecordSo = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_so WHERE id_obat_storage='$id_obat_storage'"));
                        //SO Terakhir Kali
                        $QrySoTerakhirKali = mysqli_query($Conn,"SELECT * FROM obat_so WHERE id_obat_storage='$id_obat_storage'ORDER BY tanggal DESC")or die(mysqli_error($Conn));
                        $QrDataSoTerakhirKali = mysqli_fetch_array($QrySoTerakhirKali);
                        if(empty($QrDataSoTerakhirKali['tanggal'])){
                            $SoTerakhirKali='<code>Belum Ada</code>';
                        }else{
                            $tanggal=$QrDataSoTerakhirKali['tanggal'];
                            $strtotime=strtotime($tanggal);
                            $SoTerakhirKali=date('d/m/Y H:i:s T',$strtotime);
                            $SoTerakhirKali='<code class="text-secondary">'.$SoTerakhirKali.'</code>';
                        }
                        //Format jumlah
                        $JumlahItemObat=number_format($JumlahItemObat,0,',','.');
                        $JumlahRecordSo=number_format($JumlahRecordSo,0,',','.');
                        echo '<ol>';
                        echo '  <li>Item Barang : <code class="text-secondary">'.$JumlahItemObat.'</code></li>';
                        echo '  <li>Sesi Opename : <code class="text-secondary">'.$JumlahSesiSo.'</code></li>';
                        echo '  <li>Record Opename : <code class="text-secondary">'.$JumlahRecordSo.'</code></li>';
                        echo '  <li>Last Update: '.$SoTerakhirKali.'</li>';
                        echo '</ol>';
                    ?>
                </div>
                <div class="card-footer">
                    <a href="index.php?Page=StokOpename&Sub=StokOpenameByStorage&id=<?php echo $id_obat_storage;?>" class="btn btn-sm btn-block btn-round btn-outline-dark">
                        Lihat Selengkapnya <i class="ti ti-more"></i>
                    </a>
                </div>
            </div>
        </div>
    <?php $no++;} ?>
</div>