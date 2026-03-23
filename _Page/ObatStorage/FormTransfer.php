<div class="row mb-3">
    <div class="col-md-12">
        <div class="card">
            <form action="javascript:void(0);" id="ProsesTransfer">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-10 mb-3">
                            <h4 class="card-title">
                                <i class="ti ti-pencil"></i> Form Transfer Barang
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
                                        echo '<option value="'.$IdStorageList.'">'.$NamaPenyimpananList.'</option>';
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
                            </select>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-3 mb-2">
                            <label for="tanggal">Tanggal Alokasi</label>
                        </div>
                        <div class="col-md-5 mb-2">
                            <input type="date" name="tanggal" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                            <small>Tanggal</small>
                        </div>
                        <div class="col-md-4 mb-2">
                            <input type="time" name="jam" class="form-control" value="<?php echo date('H:i'); ?>">
                            <small>Jam</small>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-3 mb-2">
                            <label for="nama_petugas">Nama Petugas</label>
                        </div>
                        <div class="col-md-9 mb-2">
                            <input type="text" name="nama_petugas" class="form-control">
                            <small>Nama petugas yang melakukan pemindahan</small>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-3 mb-2">
                            <label for="keterangan">Keterangan</label>
                        </div>
                        <div class="col-md-9 mb-2">
                            <input type="text" name="keterangan" class="form-control">
                            <small>Contoh : Pengambilan oleh petugas/perawat untuk pasien</small>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-3 mb-2">
                            <label for="qty">QTY/Jumlah</label>
                        </div>
                        <div class="col-md-9 mb-2">
                            <input type="number" min="1" name="qty" class="form-control">
                            <small id="PutSatuanItem"></small>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-3 mb-2"><dt>Notifikasi</dt></div>
                        <div class="col-md-9 mb-2" id="NotifikasiTransfer">
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