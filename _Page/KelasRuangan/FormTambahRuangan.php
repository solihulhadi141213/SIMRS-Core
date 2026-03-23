<?php
    //Koneksi
    include "../../_Config/Connection.php";
    //Menangkap kelas
    if(empty($_POST['PilihKelas'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 mb-3 text-danger">';
        echo '          Silahkan Pilih Kelas Terlebih Dulu!!';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer bg-primary">';
        echo '  <button type="button" class="btn btn-md btn-light mr-2 mt-2" data-dismiss="modal">';
        echo '      <i class="ti-close"></i> Tutup';
        echo '  </button>';
        echo '</div>';
    }else{
        $kelas=$_POST['PilihKelas'];
        //Membuka data kelas 
        $Qry = mysqli_query($Conn,"SELECT * FROM ruang_rawat WHERE kelas='$kelas' AND kategori='kelas'")or die(mysqli_error($Conn));
        $Data = mysqli_fetch_array($Qry);
        $kodekelas = $Data['kodekelas'];
        $kelas = $Data['kelas'];
?>
    <form action="javascript:void(0);" method="POST" id="ProsesTambahRuangan" autocomplete="off">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="kategori"><dt>Kategori</dt></label>
                    <input type="text" readonly name="kategori" id="kategori" class="form-control" value="ruangan" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="kode"><dt>Kode Kelas</dt></label>
                    <input type="text" readonly name="kodekelas" id="kodekelas" class="form-control" value="<?php echo "$kodekelas";?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="kode"><dt>Nama Kelas</dt></label>
                    <input type="text" readonly name="kelas" id="kelas" class="form-control" value="<?php echo "$kelas";?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="ruangan"><dt>Nama Ruangan</dt></label>
                    <input type="text" name="ruangan" id="ruangan" class="form-control" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="status"><dt>Status</dt></label>
                    <select name="status" id="status" class="form-control">
                        <option value="Aktif">Aktif</option>
                        <option value="Renovasi">Renovasi</option>
                        <option value="Tutup">Tutup</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3" id="NotifikasiTambahRuangan">
                    <p class="text-primary">Pastikan data yang anda input sudah benar</p>
                </div>
            </div>
        </div>
        <div class="modal-footer bg-primary">
            <button type="submit" class="btn btn-md btn-inverse mr-2 mt-2"> <i class="ti-save"></i> Simpan</button>
            <button type="button" class="btn btn-md btn-light mr-2 mt-2" data-dismiss="modal"> <i class="ti-close"></i> Tutup</button>
        </div>
    </form>
<?php } ?>