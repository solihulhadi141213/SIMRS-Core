<?php
    if(empty($_GET['id'])){
        echo '<div class="row">';
        echo '  <div class="col col-md-12">';
        echo '      <div class="card">';
        echo '          <div class="card-body text-center">';
        echo '              ID Bantuan Tidak Boleh Kosong!';
        echo '          </div>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_bantuan=$_GET['id'];
        //Membuka detail halaman poliklinik
        $QryBantuan = mysqli_query($Conn,"SELECT * FROM bantuan WHERE id_bantuan='$id_bantuan'")or die(mysqli_error($Conn));
        $DataBantuan = mysqli_fetch_array($QryBantuan);
        $judul = $DataBantuan['judul'];
        $tanggal= $DataBantuan['tanggal'];
        $kategori= $DataBantuan['kategori'];
        $isi= $DataBantuan['isi'];
        $status= $DataBantuan['status'];
?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="javascript:void(0);" id="ProsesEditBantuan" autocomplete="off">
                    <input type="hidden" id="GetIdBantuan" value="<?php echo "$id_bantuan"; ?>">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-10">
                                <h4 class="card-title">
                                    <i class="ti ti-plus"></i> Form Edit Bantuan
                                </h4>
                            </div>
                            <div class="col-md-2">
                                <a href="index.php?Page=Bantuan" class="btn btn-sm btn-dark btn-round btn-block">
                                    <i class="ti ti-arrow-circle-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label for="judul">Judul Bantuan</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" name="judul" id="judul" class="form-control" value="<?php echo "$judul"; ?>">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label for="tanggal">Tanggal</label>
                            </div>
                            <div class="col-md-9">
                                <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?php echo "$tanggal"; ?>">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label for="kategori">Kategori Bantuan</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" name="kategori" id="kategori" list="ListKategori" class="form-control" value="<?php echo "$kategori"; ?>">
                                <datalist id="ListKategori">
                                    <?php
                                        //lakukan Array Kategori Disini
                                        $query = mysqli_query($Conn, "SELECT DISTINCT kategori FROM bantuan ORDER BY kategori ASC");
                                        while ($data = mysqli_fetch_array($query)) {
                                            $kategori= $data['kategori'];
                                            echo '<option value="'.$kategori.'">';
                                        }
                                    ?>
                                </datalist>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label for="status">Status</label>
                            </div>
                            <div class="col-md-9">
                                <select name="status" id="status" class="form-control">
                                    <option <?php if($status=="Terbit"){echo "selected";} ?> value="Terbit">Terbit</option>
                                    <option <?php if($status=="Draft"){echo "selected";} ?> value="Draft">Draft</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label for="isi">Isi Bantuan</label>
                            </div>
                            <div class="col-md-9">
                                <div class="summernote"><?php echo "$isi"; ?></div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                Keterangan
                            </div>
                            <div class="col-md-9" id="NotifikasiEditBantuan">
                                <span class="text-primary">Pastikan Data Bantuan Yang Anda Input Sudah Benar!</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <button type="submit" class="btn btn-sm btn-primary btn-block btn-round">
                                    <i class="ti ti-save"></i> Simpan
                                </button>
                            </div>
                            <div class="col-md-2 mb-3">
                                <button type="reset" class="btn btn-sm btn-secondary btn-block btn-round">
                                    <i class="icofont-undo"></i> Reset
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>