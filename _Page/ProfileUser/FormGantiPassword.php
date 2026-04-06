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
    <div class="row"> 
        <div class="col-md-12 mb-3">
            <div>
                <label for="password1">Password Baru</label>
                <input type="password" class="form-control" id="password1" name="password1" autocomplete="false" required>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <div>
                <label for="password2">Ulangi Password</label>
                <input type="password" class="form-control" id="password2" name="password2" autocomplete="false" required>
                <small>
                    <input type="checkbox" id="TampilkanPasswordProfile" name="TampilkanPasswordProfile"> 
                    <label for="TampilkanPasswordProfile" class="text text-muted">Tampilkan Password</label>
                </small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="alert alert-info text-center">
                <small class="text-muted">
                    Password terdiri dari karakter huruf dan angka sebanyak 6-20 digit.<br>
                    Gunakan password aman dan yang mudah diingat.
                </small>
            </div>
        </div>
    </div>
<?php } ?>