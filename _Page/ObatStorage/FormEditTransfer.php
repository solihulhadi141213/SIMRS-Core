<?php
    include "_Config/SimrsFunction.php";
    if(empty($_GET['id'])){
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12 mb-3">';
        echo '      <div class="card">';
        echo '          <div class="card-body text-center text-danger">';
        echo '              ID Transfer Tidak Boleh Kosong!';
        echo '          </div>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_obat_transfer_alokasi=$_GET['id'];
        $id_obat=getDataDetail($Conn,'obat_transfer_alokasi','id_obat_transfer_alokasi',$id_obat_transfer_alokasi,'id_obat');
        $kode=getDataDetail($Conn,'obat_transfer_alokasi','id_obat_transfer_alokasi',$id_obat_transfer_alokasi,'kode');
        $nama=getDataDetail($Conn,'obat_transfer_alokasi','id_obat_transfer_alokasi',$id_obat_transfer_alokasi,'nama');
        $tanggal=getDataDetail($Conn,'obat_transfer_alokasi','id_obat_transfer_alokasi',$id_obat_transfer_alokasi,'tanggal');
        $keterangan=getDataDetail($Conn,'obat_transfer_alokasi','id_obat_transfer_alokasi',$id_obat_transfer_alokasi,'keterangan');
        $storage_from=getDataDetail($Conn,'obat_transfer_alokasi','id_obat_transfer_alokasi',$id_obat_transfer_alokasi,'storage_from');
        $storage_to=getDataDetail($Conn,'obat_transfer_alokasi','id_obat_transfer_alokasi',$id_obat_transfer_alokasi,'storage_to');
        $qty=getDataDetail($Conn,'obat_transfer_alokasi','id_obat_transfer_alokasi',$id_obat_transfer_alokasi,'qty');
        $nama_petugas=getDataDetail($Conn,'obat_transfer_alokasi','id_obat_transfer_alokasi',$id_obat_transfer_alokasi,'nama_petugas');
        //Format tanggal dan jam
        $strtotime=strtotime($tanggal);
        $Tanggal=date('Y-m-d',$strtotime);
        $Jam=date('H:i',$strtotime);
        //Buka Nama Penyimpanan Tujuan
        $NamaPenyimpananTujuan=getDataDetail($Conn,'obat_storage','id_obat_storage',$storage_to,'nama_penyimpanan');
?>

    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card">
                <form action="javascript:void(0);" id="ProsesEditTransfer">
                    <input type="hidden" name="id_obat_transfer_alokasi" id="id_obat_transfer_alokasi" value="<?php echo $id_obat_transfer_alokasi; ?>">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-10 mb-3">
                                <h4 class="card-title">
                                    <i class="ti ti-pencil"></i> Form Edit Transfer Barang
                                </h4>
                            </div>
                            <div class="col-md-2 mb-3">
                                <a href="index.php?Page=ObatStorage" class="btn btn-sm btn-secondary btn-round btn-block">
                                    <i class="ti ti-arrow-circle-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                        
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label for="id_obat_storage1">Penyimpanan Asal</label>
                            </div>
                            <div class="col-md-9">
                                <select name="id_obat_storage1" id="id_obat_storage1" class="form-control">
                                    <option value="">Pilih</option>
                                    <?php
                                        //List Lokasi Penyimpanan
                                        $QrlPenyimpanan = mysqli_query($Conn, "SELECT*FROM obat_storage ORDER BY nama_penyimpanan DESC");
                                        while ($DataPenyimpanan = mysqli_fetch_array($QrlPenyimpanan)) {
                                            $IdStorageList= $DataPenyimpanan['id_obat_storage'];
                                            $NamaPenyimpananList= $DataPenyimpanan['nama_penyimpanan'];
                                            if($IdStorageList==$storage_from){
                                                echo '<option selected value="'.$IdStorageList.'">'.$NamaPenyimpananList.'</option>';
                                            }else{
                                                echo '<option value="'.$IdStorageList.'">'.$NamaPenyimpananList.'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label for="id_obat_storage2">Penyimpanan Tujuan</label>
                            </div>
                            <div class="col-md-9">
                                <select name="id_obat_storage2" id="id_obat_storage2" class="form-control">
                                    <option value="">Pilih</option>
                                    <option selected value="<?php echo "$storage_to"; ?>"><?php echo "$NamaPenyimpananTujuan"; ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label for="id_obat">Obat/Alkes</label>
                            </div>
                            <div class="col-md-9">
                                <select name="id_obat" id="PutIdObatTransfer" class="form-control"  data-toggle="modal" data-target="#ModalPilihObatUntukTransfer">
                                    <option value="">Pilih</option>
                                    <option selected value="<?php echo "$id_obat"; ?>"><?php echo "$nama"; ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-3 mb-2">
                                <label for="tanggal">Tanggal Alokasi</label>
                            </div>
                            <div class="col-md-5 mb-2">
                                <input type="date" name="tanggal" class="form-control" value="<?php echo $Tanggal; ?>">
                                <small>Tanggal</small>
                            </div>
                            <div class="col-md-4 mb-2">
                                <input type="time" name="jam" class="form-control" value="<?php echo $Jam; ?>">
                                <small>Jam</small>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-3 mb-2">
                                <label for="nama_petugas">Nama Petugas</label>
                            </div>
                            <div class="col-md-9 mb-2">
                                <input type="text" name="nama_petugas" class="form-control" value="<?php echo $nama_petugas; ?>">
                                <small>Nama petugas yang melakukan pemindahan</small>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-3 mb-2">
                                <label for="keterangan">Keterangan</label>
                            </div>
                            <div class="col-md-9 mb-2">
                                <input type="text" name="keterangan" class="form-control" value="<?php echo $keterangan; ?>">
                                <small>Contoh : Pengambilan oleh petugas/perawat untuk pasien</small>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-3 mb-2">
                                <label for="qty">QTY/Jumlah</label>
                            </div>
                            <div class="col-md-9 mb-2">
                                <input type="number" min="1" name="qty" class="form-control" value="<?php echo $qty; ?>">
                                <small id="PutSatuanItem"></small>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-3 mb-2"><dt>Notifikasi</dt></div>
                            <div class="col-md-9 mb-2" id="NotifikasiEditTransfer">
                                <span class="text-primary">
                                    Pastikan data alokasi yang anda input sudah sesuai.
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-sm btn-primary btn-round btn-block">
                            <i class="ti ti-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>