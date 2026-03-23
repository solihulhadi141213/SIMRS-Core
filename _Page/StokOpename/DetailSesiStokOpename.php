<div class="row">
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-header">
                <dt class="card-title">
                    <?php
                        include "_Config/SimrsFunction.php";
                        if(empty($_GET['tanggal'])){
                            $TanggalStokOpename="";
                        }else{
                            $TanggalStokOpename=$_GET['tanggal'];
                        }
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
            </div>
            <div class="card-body">
                <?php
                    if(empty($_GET['id'])){
                        $id_obat_storage="0";
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
                        echo '  <li>Record Opename : <code class="text-secondary">'.$JumlahRecordSo.'</code></li>';
                        echo '  <li>Last Update: '.$SoTerakhirKali.'</li>';
                        echo '</ol>';
                    }else{
                        $id_obat_storage=$_GET['id'];
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
                        echo '  <li>Record Opename : <code class="text-secondary">'.$JumlahRecordSo.'</code></li>';
                        echo '  <li>Last Update: '.$SoTerakhirKali.'</li>';
                        echo '</ol>';
                    }
                ?>
            </div>
            <div class="card-footer">
                <a href="index.php?Page=StokOpename&Sub=StokOpenameByStorage&id=<?php echo $id_obat_storage; ?>" class="btn btn-sm btn-block btn-dark btn-round mb-4">
                    <i class="ti ti-arrow-circle-left"></i> Kembali
                </a>
            </div>
        </div>
        <form action="javascript:void(0);" id="ProsesBatasItemSo">
            <input type="hidden" name="tanggal" value="<?php echo $TanggalStokOpename; ?>">
            <input type="hidden" name="id_obat_storage" value="<?php echo $id_obat_storage; ?>">
            <div class="card">
                <div class="card-header">
                    <dt class="card-title">
                        <i class="ti ti-search"></i> Cari Obat/Alkes
                    </dt>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="batas">Batas Data</label>
                            <select name="batas" id="batas" class="form-control">
                                <option value="5">5</option>
                                <option selected value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="keyword">Kata Kunci</label>
                            <input type="text" name="keyword" id="keyword" class="form-control" placeholder="Kode / Nama">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-sm btn-block btn-round btn-outline-dark">
                                <i class="ti ti-search"></i> Cari
                            </button>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-sm btn-block btn-round btn-secondary" data-toggle="modal" data-target="#ModalExportStokOpename" data-id="<?php echo "$id_obat_storage,$tanggal"; ?>">
                                <i class="ti ti-download"></i> Export
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-9 mb-3">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-12">
                        <dt class="card-title"><i class="icofont-list"></i> Daftar Sesi Stok Opename</dt>
                        <small>Periode Tanggal : <?php echo '<code id="GetTanggalStokOpename">'.$TanggalStokOpename.'</code>'; ?></small>
                    </div>
                </div>
            </div>
            <div id="TableSesiStokOpenameItem">
                
            </div>
        </div>
    </div>
</div>