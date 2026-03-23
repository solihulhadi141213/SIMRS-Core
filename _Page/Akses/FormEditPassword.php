<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Tangkap id_akses
    if(empty($_POST['id_akses'])){
        echo '<div class="card-body border-0 pb-0">';
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          Data ID Akses Tidak Dapat didefinisikan.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_akses=$_POST['id_akses'];
        //Buka data askes
        $QryDetailAkses = mysqli_query($Conn,"SELECT * FROM akses WHERE id_akses='$id_akses'")or die(mysqli_error($Conn));
        $DataDetailAkses = mysqli_fetch_array($QryDetailAkses);
        $nama = $DataDetailAkses['nama'];
        $email= $DataDetailAkses['email'];
        $kontak= $DataDetailAkses['kontak'];
        $Username = $DataDetailAkses['username'];
        $Password= $DataDetailAkses['password'];
        $Password = md5($Password);
        $Akses= $DataDetailAkses['akses'];
        $gambar= $DataDetailAkses['gambar'];
        if(empty($gambar)){
            $LinkGambar="No-Image.png";
        }else{
            $LinkGambar="user/$gambar";
        }
?>
<form action="javascript:void(0);" method="POST" id="ProsesEditPassword" autocomplete="off">
    <div class="modal-body border-0 pb-0">
        <input type="hidden" name="id_akses" value="<?php echo "$id_akses"; ?>">
        <div class="row"> 
            <div class="col-md-12 mb-3">
                <div>
                    <label for="first_name">Password Baru</label>
                    <input type="password" class="form-control" id="password1" name="password1" required>
                </div>
            </div>
        </div>
        <div class="row"> 
            <div class="col-md-12 mb-3">
                <div>
                    <label for="last_name">Ulangi Password</label>
                    <input type="password" class="form-control" id="password2" name="password2" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <div id="NotifikasiEditPassword">
                    <small class="text-primary"><b>Keterangan :</b> Isi Password dengan benar.</small>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-inverse">
        <div class="row">
            <div class="col-md-12 mb-3">
                <div>
                    <button type="submit" class="btn btn-md btn-primary mt-2 ml-2" id="ClickEditAkses">
                        <i class="ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-md btn-light mt-2 ml-2">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
<?php } ?>