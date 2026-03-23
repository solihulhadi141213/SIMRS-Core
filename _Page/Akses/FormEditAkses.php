<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_akses
    if(empty($_POST['id_akses'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center text-danger mb-3">';
        echo '          ID Akses Tidak Boleh Kosong!.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer bg-info">';
        echo '  <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">';
        echo '      <i class="ti-close"></i> Tutup';
        echo '  </button>';
        echo '</div>';
    }else{
        $id_akses=$_POST['id_akses'];
        $nama=getDataDetail($Conn,'akses','id_akses',$id_akses,'nama');
        $tanggal=getDataDetail($Conn,'akses','id_akses',$id_akses,'tanggal');
        $email=getDataDetail($Conn,'akses','id_akses',$id_akses,'email');
        $kontak=getDataDetail($Conn,'akses','id_akses',$id_akses,'kontak');
        $akses=getDataDetail($Conn,'akses','id_akses',$id_akses,'akses');
        $updatetime=getDataDetail($Conn,'akses','id_akses',$id_akses,'updatetime');
        $gambar=getDataDetail($Conn,'akses','id_akses',$id_akses,'gambar');
?>
    <form action="javascript:void(0);" method="POST" id="ProsesEditAkses" autocomplete="off">
        <div class="modal-body border-0 pb-0">
            <input type="hidden" name="id_akses" value="<?php echo "$id_akses"; ?>">
            <div class="row"> 
                <div class="col-md-12 mb-3">
                    <label for="first_name">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?php echo "$nama"; ?>" required>
                </div>
            </div>
            <div class="row"> 
                <div class="col-md-12 mb-3">
                    <label for="last_name">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo "$email"; ?>" required>
                </div>
            </div>
            <div class="row"> 
                <div class="col-md-12 mb-3">
                    <label for="first_name">No.Kontak</label>
                    <input type="text" class="form-control" id="kontak" name="kontak" value="<?php echo "$kontak"; ?>" required>
                </div>
            </div>
            <div class="row"> 
                <div class="col-md-12 mb-3">
                    <label for="akses">Entitas Akses</label>
                    <select name="akses" id="akses" class="form-control">
                        <?php
                            $QryAkses = mysqli_query($Conn, "SELECT*FROM akses_entitas ORDER BY akses ASC");
                            while ($DataAkses = mysqli_fetch_array($QryAkses)) {
                                $AksesList= $DataAkses['akses'];
                                if($akses==$AksesList){
                                    echo '<option selected value="'.$AksesList.'">'.$AksesList.'</option>';
                                }else{
                                    echo '<option value="'.$AksesList.'">'.$AksesList.'</option>';
                                }
                            }
                        ?>
                    </select>
                    <small>
                        Merubah entitas akses tidak akan merubah pengaturan kontrol ijin akses.
                    </small>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="first_name">Photo</label>
                    <input type="file" class="form-control" id="gambar" name="gambar">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div id="NotifikasiEditAkses">
                        <span class="text-primary">Pastikan Data Informasi Akses yang Anda Input Sudah Benar</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer bg-inverse">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn-light">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </form>
<?php } ?>