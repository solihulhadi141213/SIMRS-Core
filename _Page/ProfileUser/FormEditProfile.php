<?php
    //Inclde Koneksi dan akses 
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    if(empty($SessionIdAkses)){
        echo '<div class="card-body border-0 pb-0">';
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          Lakukan lgoin untuk menggunakan fitur ini';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
?>
    <form action="javascript:void(0);" method="POST" id="ProsesEditProfile" autocomplete="off">
        <div class="card-body border-0 pb-0">
            <div class="row"> 
                <div class="col-md-12 mb-3">
                    <label for="nama"><dt>Nama Lengkap</dt></label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?php echo "$SessionNama"; ?>" required>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="email"><dt>Email</dt></label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo "$SessionEmail"; ?>" required>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="kontak"><dt>No.Kontak</dt></label>
                    <input type="text" class="form-control" id="kontak" name="kontak" value="<?php echo "$SessionKontak"; ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div id="NotifikasiEditProfile">
                        <small class="text-primary">
                            Isi data profile dengan benar.
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer bg-primary">
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-sm btn-inverse">
                        <i class="ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn-white ml-2" data-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </form>
<?php } ?>