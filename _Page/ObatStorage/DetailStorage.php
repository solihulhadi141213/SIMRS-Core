<?php
    if(empty($_GET['id'])){
        echo '<div class="card">';
        echo '  <div class="card-body text-center text-danger">';
        echo '      ID Penyimpanan Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_obat_storage=$_GET['id'];
        //Buka data Pengimpanan Obat
        $QryStorage = mysqli_query($Conn,"SELECT * FROM obat_storage WHERE id_obat_storage='$id_obat_storage'")or die(mysqli_error($Conn));
        $DataStorage = mysqli_fetch_array($QryStorage);
        $tanggal= $DataStorage['tanggal'];
        $nama_petugas= $DataStorage['nama_petugas'];
        $nama_obat_storage= $DataStorage['nama_penyimpanan'];
        $deskripsi_tempat= $DataStorage['deskripsi_tempat'];
        $updatetime= $DataStorage['updatetime'];
        //Format Tanggal
        $strtotime1=strtotime($tanggal);
        $strtotime2=strtotime($updatetime);
        $TanggalInput=date('d/m/Y H:i T',$strtotime1);
        $Updatetime=date('d/m/Y H:i T',$strtotime2);
        //menghitung Data Item
        $jumlahItem = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_posisi WHERE id_obat_storage='$id_obat_storage'"));
        //menghitung Transfer Masuk
        $JumlahTransferMasuk = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_transfer_alokasi WHERE storage_to='$id_obat_storage' "));
        //menghitung Transfer Keluar
        $JumlahTransferKeluar = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_transfer_alokasi WHERE storage_from='$id_obat_storage' "));
        //menghitung Alokasi Masuk
        $JumlahAlokasiMasuk = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_transfer_alokasi WHERE storage_to='$id_obat_storage'"));
        //menghitung Alokasi Keluar
        $JumlahAlokasiKeluar = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_transfer_alokasi WHERE storage_from='$id_obat_storage'"));
?>
    <div class="row mb-3">
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header border-bottom-inverse">
                    <div class="row">
                        <div class="col-md-12 mb-2 text-center">
                            <h4 class="card-title">
                                <i class="ti ti-info-alt"></i> Detail Lokasi Penyimpanan
                            </h4>
                        </div>
                        <div class="col-md-12 mb-2">
                            <a href="index.php?Page=ObatStorage" class="btn btn-sm btn-block btn-dark btn-round" title="Kembali Ke Halaman Sebelumnya">
                                <i class="ti ti-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col col-md-12">
                            <?php
                                echo '  <ul>';
                                echo '      <li class="mb-3">Nama Penyimpanan : <code class="text-secondary">'.$nama_obat_storage.'</code></li>';
                                echo '      <li class="mb-3">Deskripsi : <code class="text-secondary">'.$deskripsi_tempat.'</code></li>';
                                echo '      <li class="mb-3">Petugas Input : <code class="text-secondary">'.$nama_petugas.'</code></li>';
                                echo '      <li class="mb-3">Jumlah Item : <code class="text-secondary">'.$jumlahItem.' Item</code></li>';
                                echo '      <li class="mb-3">Transfer Masuk : <code class="text-secondary">'.$JumlahTransferMasuk.'</code></li>';
                                echo '      <li class="mb-3">Transfer Keluar : <code class="text-secondary">'.$JumlahTransferKeluar.'</code></li>';
                                echo '      <li class="mb-3">Tanggal Input : <code class="text-secondary">'.$TanggalInput.'</code></li>';
                                echo '      <li class="mb-3">Tanggal Update : <code class="text-secondary">'.$Updatetime.'</code></li>';
                                echo '  </ul>';
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="row mb-3">
                        <div class="col-md-12 text-center">
                            <h4 class="card-title">
                                <i class="ti ti-list"></i> Uraian Item Barang
                            </h4>
                        </div>
                    </div>
                    <form action="javascript:void(0);" id="ProsesBatasObatOnPosisi">
                        <input type="hidden" name="id_obat_storage" id="id_obat_storage" value="<?php echo $id_obat_storage;?>">
                        <div class="row">
                            <div class="col-md-12 mb-3 form-group">
                                <input type="text" name="keyword" id="keyword" class="form-control form-control-round" placeholder="Nama/Kode Obat & Alkes">
                            </div>
                            <div class="col-md-12 mb-3">
                                <button type="submit" class="btn btn-sm btn-block btn-outline-dark btn-round">
                                    <i class="ti ti-search"></i> Cari
                                </button>
                            </div>
                            <div class="col-md-12 mb-3">
                                <button type="button" class="btn btn-sm btn-block btn-primary btn-round" data-toggle="modal" data-target="#ModalAlokasiItem" data-id="<?php echo "$id_obat_storage"; ?>">
                                    <i class="ti ti-plus"></i> Alokasi
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="TabelListObatOnPosisi">

                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="row mb-3">
                        <div class="col-md-12 text-center">
                            <h4 class="card-title">
                                <i class="ti ti-truck"></i> Transfer/Pemindahan
                            </h4>
                        </div>
                    </div>
                    <form action="javascript:void(0);" id="ProsesBatasTransfer">
                        <input type="hidden" name="id_obat_storage" id="id_obat_storage" value="<?php echo $id_obat_storage;?>">
                        <div class="row">
                            <div class="col-md-12 mb-3 form-group">
                                <input type="text" name="KeywordHistoriTransfer" id="KeywordHistoriTransfer" class="form-control form-control-round" placeholder="Nama/Kode Obat & Alkes">
                            </div>
                            <div class="col-md-12 mb-3">
                                <button type="submit" class="btn btn-sm btn-block btn-outline-dark btn-round">
                                    <i class="ti ti-search"></i> Cari
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body" id="ListHistoriTransfer">

                </div>
            </div>
        </div>
    </div>
    
<?php } ?>