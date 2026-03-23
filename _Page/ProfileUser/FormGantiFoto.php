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
    <form action="javascript:void(0);" method="POST" id="ProsesGantiFoto" autocomplete="off">
        <div class="card-body border-0 pb-0">
            <div class="row"> 
                <div class="col-md-12 mb-3">
                    <div>
                        <label for="password1">Pilih Foto Baru</label>
                        <input type="file" class="form-control" id="foto" name="foto" autocomplete="false" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div id="NotifikasiGantiFoto">
                        <small class="text-primary">
                            Gunakan foto dengan format PNG atau JPG dengan file size kurang dari 2 MB
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