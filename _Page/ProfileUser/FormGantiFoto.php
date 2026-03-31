<?php
    //Inclde Koneksi dan akses 
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    if(empty($SessionIdAkses)){
        echo '
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-danger text-center">
                        Sesi Akses Sudah Berakhir. Silahkan Login Ulang!
                    </div>
                </div>
            </div>
        ';
    }else{
        echo '
            <div class="row"> 
                <div class="col-md-12 mb-3">
                    <div>
                        <label for="password1">Pilih Foto Baru</label>
                        <input type="file" class="form-control" id="foto" name="foto" autocomplete="false" required>
                        <small class="text text-muted">
                            File Foto Maksimal 2 Mb (Filetype : JPG, JPEG, PNG, GIF)
                        </small>
                    </div>
                </div>
            </div>
        ';
    }
?>