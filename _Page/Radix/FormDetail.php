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

    //id_setting_radix wajib terisi
    if(empty($_POST['id_setting_radix'])){
        echo '
            <div class="row mb-3">
                <div class="col-12 text-center">
                    <div class="alert alert-danger"><small>ID Koneksi Tiidak Boleh Kosong!</small></div>
                </div>
            </div>
        ';
        exit;
    }

    //Buat variabel 'id_setting_radix' dan sanitasi
    $id_setting_radix = $_POST['id_setting_radix'];

    //Buka Detail Koneksi Dengan Prepared Statment
    $Qry = $Conn->prepare("SELECT * FROM setting_radix WHERE id_setting_radix = ?");
    $Qry->bind_param("i", $id_setting_radix);
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
        $label_status = '<span class="badge bg-danger"><i class="bi bi-x-circle"></i> Inactive</span>';
    }else{
        $label_status = '<span class="badge bg-success"><i class="bi bi-check-circle"></i> Active</span>';
    }
    echo '
        <input type="hidden" name="id_setting_radix" value="'.$id_setting_radix.'">
        <div class="row mb-3">
            <div class="col-4">Nama Pengaturan</div>
            <div class="col-1">:</div>
            <div class="col-7">
                <span class="text text-muted">'.$Data['setting_name'].'</span>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-4">Base URL</div>
            <div class="col-1">:</div>
            <div class="col-7">
                <span class="text text-muted">'.$Data['base_url'].'</span>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-4">Username</div>
            <div class="col-1">:</div>
            <div class="col-7">
                <span class="text text-muted">'.$Data['username'].'</span>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-4">Password</div>
            <div class="col-1">:</div>
            <div class="col-7">
                <span class="text text-muted">'.$Data['password'].'</span>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-4">Token</div>
            <div class="col-1">:</div>
            <div class="col-7">
                <small class="text text-muted">'.$Data['token'].'</small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-4">Creat At</div>
            <div class="col-1">:</div>
            <div class="col-7">
                <span class="text text-muted">'.$Data['creat_at'].'</span>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-4">Expired At</div>
            <div class="col-1">:</div>
            <div class="col-7">
                <span class="text text-muted">'.$Data['expired_at'].'</span>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-4">Status</div>
            <div class="col-1">:</div>
            <div class="col-7">
                <span class="text text-muted">'.$label_status.'</span>
            </div>
        </div>
    ';
?>