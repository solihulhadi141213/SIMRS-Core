<?php
    include "_Config/SimrsFunction.php";
    if(empty($_GET['id'])){
        echo '<div class="card">';
        echo '  <div class="card-body text-center text-danger">';
        echo '      ID Penyimpanan Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_GET['id_obat'])){
            echo '<div class="card">';
            echo '  <div class="card-body text-center text-danger">';
            echo '      ID Obat Tidak Boleh Kosong!';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_obat_storage=$_GET['id'];
            $id_obat=$_GET['id_obat'];
            //Buka data Pengimpanan Obat
            $nama_penyimpanan=getDataDetail($Conn,'obat_storage','id_obat_storage',$id_obat_storage,'nama_penyimpanan');
            $tanggal=getDataDetail($Conn,'obat_storage','id_obat_storage',$id_obat_storage,'tanggal');
            $updatetime=getDataDetail($Conn,'obat_storage','id_obat_storage',$id_obat_storage,'updatetime');
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
            if(empty($nama_penyimpanan)){
                echo '<div class="card">';
                echo '  <div class="card-body text-center text-danger">';
                echo '      ID Penyimpanan Obat Tidak Boleh Kosong!';
                echo '  </div>';
                echo '</div>';
            }else{
                $id_obat=getDataDetail($Conn,'obat','id_obat',$id_obat,'id_obat');
                if(empty($id_obat)){
                    echo '<div class="card">';
                    echo '  <div class="card-body text-center text-danger">';
                    echo '      ID Obat Tidak Valid!';
                    echo '  </div>';
                    echo '</div>';
                }else{
                    $KodeObat=getDataDetail($Conn,'obat','id_obat',$id_obat,'kode');
                    $NamaObat=getDataDetail($Conn,'obat','id_obat',$id_obat,'nama');
                    $KategoriObat=getDataDetail($Conn,'obat','id_obat',$id_obat,'kategori');
                    $SatuanObat=getDataDetail($Conn,'obat','id_obat',$id_obat,'satuan');
                    $StokObat=getDataDetail($Conn,'obat','id_obat',$id_obat,'stok');
?>
    <div class="row mb-3">
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header border-bottom-inverse">
                    <div class="row">
                        <div class="col-md-12 mb-2 text-center">
                            <h4 class="card-title">
                                <i class="ti ti-info-alt"></i> Informasi Alokasi
                            </h4>
                        </div>
                        <div class="col-md-12 mb-2">
                            <a href="index.php?Page=ObatStorage&Sub=DetailStorage&id=<?php echo $id_obat_storage; ?>" class="btn btn-sm btn-block btn-dark" title="Kembali Ke Halaman Sebelumnya">
                                <i class="ti ti-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col col-md-12">
                            <?php
                                echo '<dt>Informasi Obat</dt>';
                                echo '  <ul>';
                                echo '      <li>Nama Obat : <code class="text-secondary">'.$NamaObat.'</code></li>';
                                echo '      <li>Kode : <code class="text-secondary">'.$KodeObat.'</code></li>';
                                echo '      <li>Kategori : <code class="text-secondary">'.$KategoriObat.'</code></li>';
                                echo '      <li>Stok : <code class="text-secondary">'.$StokObat.' '.$SatuanObat.'</code></li>';
                                echo '  </ul>';
                            ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-12">
                            <?php
                                echo '<dt>Informasi Penyimpanan</dt>';
                                echo '  <ul>';
                                echo '      <li>Nama Penyimpanan : <code class="text-secondary">'.$nama_penyimpanan.' Item</code></li>';
                                echo '      <li>Jumlah Item : <code class="text-secondary">'.$jumlahItem.' Item</code></li>';
                                echo '      <li>Transfer Masuk : <code class="text-secondary">'.$JumlahTransferMasuk.'</code></li>';
                                echo '      <li>Transfer Keluar : <code class="text-secondary">'.$JumlahTransferKeluar.'</code></li>';
                                echo '      <li>Update Time : <code class="text-secondary">'.$Updatetime.'</code></li>';
                                echo '  </ul>';
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <form action="javascript:void(0);" id="ProsesAlokasiObat">
                    <div class="card-header">
                        <h4 class="card-title">
                            <i class="ti ti-pencil"></i> Form Alokasi Obat
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label for="id_obat">ID Obat & Alkes</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" readonly name="id_obat" id="id_obat" class="form-control" value="<?php echo "$id_obat"; ?>">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label for="id_obat">Nama/Merek</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" readonly name="nama_obat" id="nama_obat" class="form-control" value="<?php echo "$NamaObat"; ?>">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label for="id_obat_storage">Penyimpanan</label>
                            </div>
                            <div class="col-md-9">
                                <select name="id_obat_storage" id="id_obat_storage" class="form-control">
                                    <option value="<?php echo "$id_obat_storage"; ?>"><?php echo "$nama_penyimpanan"; ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-3 mb-2">
                                <label for="qty">QTY/Jumlah</label>
                            </div>
                            <div class="col-md-9 mb-2">
                                <input type="number" min="1" name="qty" class="form-control">
                                <small><?php echo "/ $SatuanObat"; ?></small>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-3 mb-2"><dt>Notifikasi</dt></div>
                            <div class="col-md-9 mb-2" id="NotifikasiAlokasi">
                                <span class="text-primary">
                                    Pastikan data alokasi yang anda input sudah sesuai.
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-md btn-primary">
                            <i class="ti ti-save"></i> Simpan
                        </button>
                        <button type="button" class="btn btn-md btn-info" data-toggle="modal" data-target="#ModalAlokasiItem" data-id="<?php echo "$id_obat_storage"; ?>">
                            <i class="ti ti-new-window"></i> Ganti Item Barang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
<?php }}}} ?>