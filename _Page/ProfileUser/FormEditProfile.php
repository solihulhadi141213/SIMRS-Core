<?php
    //Zona Waktu
    date_default_timezone_set('Asia/Jakarta');

    // Connection
    include "../../_Config/Connection.php";
    
    // Simrs Function
    include "../../_Config/SimrsFunction.php";

    // Session
    include "../../_Config/Session.php";

    // Cek hasil validasi session
    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger">
                Sesi Akses Sudah Berakhir! Silahkan Login Ulang!
            </div>
        ';
    } else {
        echo '
            <div class="row"> 
                <div class="col-md-12 mb-3">
                    <div class="alert alert-warning text-center">
                        <small>
                            <b>PENTING!</b><br>
                            Mulai Aplikasi SIMRS Core Versi 3.0.0 pengguna tidak bisa lagi mengubah data pribadi. Perubahan hanya bisa dilakukan dari sisi admin.
                        </small>
                    </div>
                </div>
            </div>
            <div class="row"> 
                <div class="col-md-12 mb-3">
                    <label for="email"><small>Email</small></label>
                    <input type="email" class="form-control" id="email" name="email" value="'.$SessionEmail.'" required>
                </div>
            </div>
            <div class="row"> 
                <div class="col-md-12 mb-3">
                    <label for="kontak"><small>No.Kontak</small></label>
                    <input type="text" class="form-control" id="kontak" name="kontak" value="'.$SessionKontak.'" required>
                </div>
            </div>
        ';
    }
?>