<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    
    //Zona Waktu
    date_default_timezone_set("Asia/Jakarta");

    //Session Akses
    if(empty($_SESSION['id_akses'])){
        echo '
            <div class="row mb-3">
                <div class="col-12 text-center">
                    <div class="alert alert-danger"><small>Sesi Akses Sudah Berakhir! Silahkan Login Ulang.</small></div>
                </div>
            </div>
        ';
        exit;
    }

    //id_setting_analyza wajib terisi
    if(empty($_POST['id_setting_analyza'])){
        echo '
            <div class="row mb-3">
                <div class="col-12 text-center">
                    <div class="alert alert-danger"><small>ID Koneksi Tiidak Boleh Kosong!</small></div>
                </div>
            </div>
        ';
        exit;
    }

    //Buat variabel 'id_setting_analyza' dan sanitasi
    $id_setting_analyza = $_POST['id_setting_analyza'];

    //Buka Detail Koneksi Dengan Prepared Statment
    $Qry = $Conn->prepare("SELECT * FROM setting_analyza WHERE id_setting_analyza = ?");
    $Qry->bind_param("i", $id_setting_analyza);
    if (!$Qry->execute()) {
        $error=$Conn->error;
        echo '
            <div class="alert alert-danger">
                <small>Terjadi kesalahan pada saat membuka data dari database!<br>Keterangan : '.$error.'</small>
            </div>
        ';
        exit;
    }
    
    $Result = $Qry->get_result();
    $Data = $Result->fetch_assoc();
    $Qry->close();

    //Routing Status
    if(empty($Data['status'])){
        $label_active = "";
        $label_none = "selected";
    }else{
        $label_active = "selected";
        $label_none = "";
    }
    echo '
        <input type="hidden" name="id_setting_analyza" value="'.$id_setting_analyza.'">
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="setting_name_edit"><dt>Nama Pengaturan</dt></label>
                <input type="text" name="setting_name" id="setting_name_edit" class="form-control" value="'.$Data['setting_name'].'">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="base_url_edit"><dt>Base Url</dt></label>
                <input type="url" name="base_url" id="base_url_edit" class="form-control" placeholder="https://" value="'.$Data['base_url'].'">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="setting_username_edit"><dt>Username</dt></label>
                <input type="text" name="setting_username" id="setting_username_edit" class="form-control" value="'.$Data['username'].'">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="setting_password_edit"><dt>Password</dt></label>
                <input type="text" name="setting_password" id="setting_password_edit" class="form-control" value="'.$Data['password'].'">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="setting_status_edit"><dt>Status</dt></label>
                <select name="setting_status" id="setting_status_edit" class="form-control">
                    <option '.$label_none.' value="0">Non Aktif</option>
                    <option '.$label_active.' value="1">Aktif</option>
                </select>
            </div>
        </div>
    ';
?>