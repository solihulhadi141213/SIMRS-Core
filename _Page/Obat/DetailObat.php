<?php
    include "_Config/SimrsFunction.php";
    if(empty($_GET['id'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12">';
        echo '      <div class="card">';
        echo '          <div class="card-body text-center text-danger">';
        echo '              ID Obat/Alkes Tidak Boleh Kosong!';
        echo '          </div>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_obat=$_GET['id'];
        $id_obat=getDataDetail($Conn,'obat','id_obat',$id_obat,'id_obat');
        //Buka data obat
        if(empty($id_obat)){
            echo '<div class="row">';
            echo '  <div class="col-md-12">';
            echo '      <div class="card">';
            echo '          <div class="card-body text-center text-danger">';
            echo '              ID Obat/Alkes Tidak Valid!';
            echo '          </div>';
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
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="row mb-4">
                        <div class="col-md-12 text-center">
                            <h4 class="card-title"><i class="ti ti-info-alt"></i> Detail Obat/Alkes</h4>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12 text-center">
                            <a href="index.php?Page=Obat" class="btn btn-sm btn-block btn-dark btn-round">
                                <i class="ti ti-arrow-circle-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
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
                        <div class="col-md-12">
                            Harga Multi
                        </div>
                    </div>
                    <?php
                        $JumlahKategori = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_kategori_harga"));
                        //Apabila Kategori Ada Maka Buka List Datanya
                        if(empty($JumlahKategori)){
                            echo '<div class="row"><div class="col-md-12"><code class="text-danger">Tidak Ada Multi Harga</code></div></div>';
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
                                echo '  <div class="col col-md-4">'.$no.'.'.$kategori_harga.'</div>';
                                echo '  <div class=" col col-md-8">';
                                echo '      <code class="text-secondary">'.$harga_multi.'</code>';
                                echo '  </div>';
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
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <button type="button" class="btn btn-sm btn-block btn-outline-dark btn-round" data-toggle="modal" data-target="#ModalEditObat" data-id="<?php echo $id_obat; ?>" title="Edit Data Obat">
                                <i class="ti ti-pencil-alt"></i> Edit
                            </button>
                        </div>
                        <div class="col-md-6 mb-2">
                            <button type="button" class="btn btn-sm btn-block btn-outline-dark btn-round" data-toggle="modal" data-target="#ModalHapusObat" data-id="<?php echo $id_obat; ?>" title="Hapus Data Obat">
                                <i class="ti ti-trash"></i> Hapus
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-2">
                <div class="card-header">
                    <div class="row mb-4">
                        <div class="col-md-12 text-center">
                            <h4 class="card-title">
                                <i class="ti-layout-grid3"></i> Multi Satuan
                            </h4>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12 text-center">
                            <a href="javascript:void(0);" class="btn btn-sm btn-block btn-primary btn-round" data-toggle="modal" data-target="#ModalTambahSatuanMulti" data-id="<?php echo $id_obat; ?>">
                                <i class="ti ti-plus"></i> Tambah Multi Satuan
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <?php
                            $JumlahSatuan = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_satuan WHERE id_obat='$id_obat'"));
                            if(empty($JumlahSatuan)){
                                echo '<li class="list-group-item text-danger text-center">Tidak Ada Data Satuan Multi</li>';
                            }else{
                                $no=1;
                                $QrySatuan = mysqli_query($Conn, "SELECT*FROM obat_satuan WHERE id_obat='$id_obat' ORDER BY id_obat_multi ASC");
                                while ($DataSatuan = mysqli_fetch_array($QrySatuan)) {
                                    $id_obat_multi= $DataSatuan['id_obat_multi'];
                                    $SatuanMulti= $DataSatuan['satuan'];
                                    $IsiMultiSatuan= $DataSatuan['isi'];
                                    $UpdatetimeSatuan= $DataSatuan['updatetime'];
                                    $strtotime=strtotime($UpdatetimeSatuan);
                                    $UpdatetimeSatuan=date('d/m/Y H:i',$strtotime);
                                    //Menghitung Stok Berdasarkan Satuan Multi
                                    if(!empty($stok)){
                                        $StokMulti=($isi/$IsiMultiSatuan)*$stok;
                                    }else{
                                        $StokMulti=0;
                                    }
                                    echo '<li class="list-group-item">';
                                    echo '  <dt>';
                                    echo '      <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalEditSatuanMulti" data-id="'.$id_obat_multi.'"><i class="ti ti-pencil"></i> '.$SatuanMulti.'</a>';
                                    echo '  </dt>';
                                    echo '  Isi/Konversi : <code class="text-secondary">'.$IsiMultiSatuan.' '.$satuan.' / '.$SatuanMulti.'</code><br>';
                                    echo '  Stok : <code class="text-secondary">'.$StokMulti.' '.$SatuanMulti.'</code>';
                                    echo '</li>';
                                }
                            }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="card mb-2">
                <div class="card-header text-center">
                    <h4 class="card-title">
                        <i class="ti-layout-grid2"></i> Tempat Penyimpanan
                    </h4>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <?php
                            $JumlahTempatPenyimpanan = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_storage"));
                            if(empty($JumlahTempatPenyimpanan)){
                                echo '<li class="list-group-item text-danger text-center">Tidak Ada Data Tempat Penyimpanan</li>';
                            }else{
                                $no=1;
                                $QryTempatPenyimpanan = mysqli_query($Conn, "SELECT*FROM obat_storage ORDER BY nama_penyimpanan ASC");
                                while ($DataTempatPenyimpanan = mysqli_fetch_array($QryTempatPenyimpanan)) {
                                    $id_obat_storage= $DataTempatPenyimpanan['id_obat_storage'];
                                    $nama_penyimpanan= $DataTempatPenyimpanan['nama_penyimpanan'];
                                    $deskripsi_tempat= $DataTempatPenyimpanan['deskripsi_tempat'];
                                    //Buka Data Posisi
                                    $QryPosisi = mysqli_query($Conn,"SELECT * FROM obat_posisi WHERE id_obat='$id_obat' AND id_obat_storage='$id_obat_storage'")or die(mysqli_error($Conn));
                                    $DataPosisi = mysqli_fetch_array($QryPosisi);
                                    if(empty($DataPosisi['stok'])){
                                        $StokPosisi=0;
                                    }else{
                                        $StokPosisi=$DataPosisi['stok'];
                                    }
                                    echo '<li class="list-group-item">';
                                    echo '  <dt>';
                                    echo '      <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalPosisiObat" data-id="'.$id_obat.','.$id_obat_storage.'"><i class="ti ti-pencil"></i> '.$nama_penyimpanan.'</a>';
                                    echo '  </dt>';
                                    echo '  <small class="text-secondary">'.$deskripsi_tempat.'</small><br>';
                                    echo '  Stok : <code class="text-secondary">'.$StokPosisi.' '.$satuan.'</code>';
                                    echo '</li>';
                                }
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php
            $BulanTahun=date('Y-m');
            $AwalBulan="$BulanTahun-01";
            $Sekarang=date('Y-m-d');
        ?>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">
                    <div class="row mb-4">
                        <div class="col-md-12 text-center">
                            <h4 class="card-title">
                                <i class="ti ti-calendar"></i> Expired Date
                            </h4>
                        </div>
                    </div>
                    <form action="javascript:void(0);" id="FilterExpiredDate">
                        <input type="hidden" name="id_obat" value="<?php echo $id_obat; ?>">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <select name="BatasDataExpired" id="BatasDataExpired" class="form-control">
                                    <option value="5">5</option>
                                    <option selected value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                                <label for="BatasDataExpired"><small>Data</small></label>
                            </div>
                            <div class="col-md-6 mb-3">
                                <select name="KeywordByExpiredDate" id="KeywordByExpiredDate" class="form-control">
                                    <option value="">Pilih</option>
                                    <option value="batch">Kode Batch</option>
                                    <option value="expired">Tanggal Expired</option>
                                    <option value="ingatkan">Tanggal Peringatan</option>
                                    <option value="status">Status</option>
                                </select>
                                <label for="KeywordByExpiredDate"><small>Mode Pencarian</small></label>
                            </div>
                            <div class="col-md-12" id="FormKeywordExpiredDate">
                                <input type="text" class="form-control" name="KeywordExpiredDate" id="KeywordExpiredDate" placeholder="Kata Kunci">
                                <label for="KeywordExpiredDate"><small>Pencarian</small></label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-sm btn-block btn-outline-dark btn-round">
                                    <i class="ti ti-search"></i> Tampilkan
                                </button>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-sm btn-block btn-primary btn-round" data-toggle="modal" data-target="#ModalTambahExpiredDate" data-id="<?php echo $id_obat; ?>">
                                    <i class="ti ti-plus"></i> Tambah Expired Date
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="TabelExpiredDate">
                    <!-- Tabel Expired Date -->
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="row mb-4">
                        <div class="col-md-12 text-center">
                            <h4 class="card-title">
                                <i class="ti ti-shopping-cart"></i> Riwayat Transaksi
                            </h4>
                        </div>
                    </div>
                    <form action="javascript:void(0);" id="FilterRiwayatTransaksi">
                        <input type="hidden" name="id_obat" value="<?php echo $id_obat; ?>">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <select name="BatasData" id="BatasData" class="form-control">
                                    <option value="5">5</option>
                                    <option selected value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                                <label for="BatasData"><small>Data</small></label>
                            </div>
                            <div class="col-md-6 mb-3">
                                <select name="KategoriTransaksi" id="KategoriTransaksi" class="form-control">
                                    <option value="PND">Penjualan</option>
                                    <option value="PMB">Pembelian</option>
                                </select>
                                <label for="KategoriTransaksi"><small>Kategori</small></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-sm btn-block btn-outline-dark btn-round">
                                    <i class="ti ti-search"></i> Tampilkan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="TabelRiwayatTransaksi">

                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            
        </div>
    </div>
    <div class="row">
    </div>
<?php }} ?>