<div class="row">
    <div class="col-md-6 mb-3">
        <div class="card mb-3">
            <div class="card-header">
                <dt class="card-title">
                    <?php
                        include "_Config/SimrsFunction.php";
                        if(empty($_GET['id'])){
                            $id_obat_storage="0";
                            echo '<i class="ti ti-info-alt"></i> Penyimpanan Utama';
                        }else{
                            $id_obat_storage=$_GET['id'];
                            $QryStorage = mysqli_query($Conn,"SELECT * FROM obat_storage WHERE id_obat_storage='$id_obat_storage'")or die(mysqli_error($Conn));
                            $DataStorage = mysqli_fetch_array($QryStorage);
                            if(empty($DataStorage['nama_penyimpanan'])){
                                echo '<span class="text-danger">Tidak Diketahui</span>';
                            }else{
                                $nama_penyimpanan= $DataStorage['nama_penyimpanan'];
                                echo '<i class="ti ti-info-alt"></i> '.$nama_penyimpanan.'';
                            }
                        }
                    ?>
                </dt>
                <small>Informasi Lokasi Stok Opename</small>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <?php
                            if(empty($_GET['id'])){
                                $id_obat_storage="0";
                                //Jumlah Sesi
                                $JumlahSesiSo = mysqli_num_rows(mysqli_query($Conn, "SELECT DISTINCT tanggal FROM obat_so WHERE id_obat_storage='$id_obat_storage'"));
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
                                echo '  <li>ID Penyimpanan : <code class="text-secondary" id="GetIdPenyimpanan">0</code></li>';
                                echo '  <li>Item Barang : <code class="text-secondary">'.$JumlahItemObat.'</code></li>';
                                echo '  <li>Sesi Opename : <code class="text-secondary">'.$JumlahSesiSo.'</code></li>';
                                echo '  <li>Record Opename : <code class="text-secondary">'.$JumlahRecordSo.'</code></li>';
                                echo '  <li>Last Update: '.$SoTerakhirKali.'</li>';
                                echo '</ol>';
                            }else{
                                $id_obat_storage=$_GET['id'];
                                //Jumlah Sesi
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
                                echo '  <li>ID Penyimpanan : <code class="text-secondary" id="GetIdPenyimpanan">'.$id_obat_storage.'</code></li>';
                                echo '  <li>Item Barang : <code class="text-secondary">'.$JumlahItemObat.'</code></li>';
                                echo '  <li>Sesi Opename : <code class="text-secondary">'.$JumlahSesiSo.'</code></li>';
                                echo '  <li>Record Opename : <code class="text-secondary">'.$JumlahRecordSo.'</code></li>';
                                echo '  <li>Last Update: '.$SoTerakhirKali.'</li>';
                                echo '</ol>';
                            }
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <a href="index.php?Page=StokOpename" class="btn btn-sm btn-block btn-dark btn-round">
                            <i class="ti ti-arrow-circle-left"></i> Kembali
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <button type="button" class="btn btn-sm btn-block btn-primary btn-round" data-toggle="modal" data-target="#ModalTambahSesiStokOpename" data-id="<?php echo "$id_obat_storage"; ?>">
                            <i class="ti ti-plus"></i> Buat Sesi Baru
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-12">
                        <dt class="card-title"><i class="icofont-list"></i> Daftar Sesi Stok Opename</dt>
                    </div>
                </div>
            </div>
            <div id="TableSesiStokOpename">
                
            </div>
        </div>
    </div>
</div>