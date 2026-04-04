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
                    <label class="upload-area" for="file_foto">
                        <div class="upload-content">
                            <i class="bi bi-cloud-arrow-up fs-1"></i>
                            <h6 class="mt-2 mb-1">Drop / Upload Here</h6>
                            <small class="text-muted">
                                JPG, JPEG, PNG, GIF (Max 2 MB)
                            </small>
                        </div>
                        <input type="file" id="file_foto" name="foto" hidden required>
                    </label>
                </div>
            </div>

            <div id="preview_foto" class="text-center mt-3"></div>
        ';
    }
?>