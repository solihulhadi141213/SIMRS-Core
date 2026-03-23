<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Tangkap id_akses
    if(empty($_POST['id_akses'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center text-danger mb-3">';
        echo '          ID Akses Tidak Boleh Kosong!.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer bg-inverse">';
        echo '  <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><i class="ti ti-close"></i> Tutup</button>';
        echo '</div>';
    }else{
        $id_akses=$_POST['id_akses'];
        //Buka data askes
        $QryDetailAkses = mysqli_query($Conn,"SELECT * FROM akses WHERE id_akses='$id_akses'")or die(mysqli_error($Conn));
        $DataDetailAkses = mysqli_fetch_array($QryDetailAkses);
        $nama = $DataDetailAkses['nama'];
        $email= $DataDetailAkses['email'];
?>
    <form action="javascript:void(0);" method="POST" id="ProsesUbahPassword" autocomplete="off">
        <div class="modal-body border-0 pb-0">
            <input type="hidden" name="id_akses" value="<?php echo "$id_akses"; ?>">
            <div class="row"> 
                <div class="col-md-12 mb-3">
                    <div>
                        <label for="email"><dt>Email</dt></label>
                        <input type="email" readonly class="form-control" id="email" name="email" value="<?php echo "$email";?>" required>
                        <small>
                            <input checked type="checkbox" id="KirimPassworedBaru" name="KirimPassworedBaru" value="Ya"> 
                            <label for="KirimPassworedBaru">Kirimkan password ke email</label>
                        </small>
                    </div>
                </div>
            </div>
            <div class="row"> 
                <div class="col-md-12 mb-3">
                    <div>
                        <label for="password1"><dt>Password Baru</dt></label>
                        <input type="password" class="form-control" id="password1" name="password1" required>
                    </div>
                </div>
            </div>
            <div class="row"> 
                <div class="col-md-12 mb-3">
                    <div>
                        <label for="password2"><dt>Ulangi Password</dt></label>
                        <input type="password" class="form-control" id="password2" name="password2" required>
                        <small>
                            <input type="checkbox" id="TampilkanPassword" name="TampilkanPassword"> 
                            <label for="TampilkanPassword">Tampilkan Password</label>
                        </small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div id="NotifikasiUbahPassword">
                        <span class="text-primary">Pastikan Password Yang Anda Masukan Sudah Sesuai</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer bg-inverse">
            <button type="submit" class="btn btn-sm btn-primary mt-2 ml-2">
                <i class="ti-save"></i> Simpan
            </button>
            <button type="button" class="btn btn-sm btn-light mt-2 ml-2" data-dismiss="modal">
                <i class="ti-close"></i> Tutup
            </button>
        </div>
    </form>
<?php } ?>