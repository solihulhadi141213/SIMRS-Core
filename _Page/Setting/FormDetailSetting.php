<?php
    date_default_timezone_set('Asia/Jakarta');

    // Connection
    include "../../_Config/Connection.php";

    // Simrs Function
    include "../../_Config/SimrsFunction.php";

    // Session
    include "../../_Config/Session.php";

    // Validasi Session
    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger text-center">
                <small>Sesi Akses Sudah Berakhir! Silahkan Login Ulang!</small>
            </div>
        ';
        exit;
    }

    // Validasi id_setting
    if(empty($_POST['id_setting'])){
        echo '
            <div class="alert alert-danger text-center">
                <small>ID Pengaturan Tidak Boleh Kosong!</small>
            </div>
        ';
        exit;
    }

    // Buat Variabel Dan Sanitasi
    $id_setting = validateAndSanitizeInput($_POST['id_setting']);

    // Buka Data Dengan Prepared Statment
    $sql  = "SELECT * FROM  setting WHERE id_setting = ?";
    $stmt = $Conn->prepare($sql);

    // Bind parameter (tipe data integer "i")
    $stmt->bind_param("i", $id_setting);

    // Eksekusi statement
    $stmt->execute();

    // Ambil hasil query
    $result = $stmt->get_result();
    $DataSettingGeneral = $result->fetch_assoc();

    // Simpan hasil ke variabel
    $setting_name           = $DataSettingGeneral['setting_name'] ?? null;
    $aplication_name        = $DataSettingGeneral['aplication_name'] ?? null;
    $aplication_description = $DataSettingGeneral['aplication_description'] ?? null;
    $aplication_keyword     = $DataSettingGeneral['aplication_keyword'] ?? null;
    $aplication_author      = $DataSettingGeneral['aplication_author'] ?? null;
    $base_url               = $DataSettingGeneral['base_url'] ?? null;
    $hospital_name          = $DataSettingGeneral['hospital_name'] ?? null;
    $hospital_address       = $DataSettingGeneral['hospital_address'] ?? null;
    $hospital_contact       = $DataSettingGeneral['hospital_contact'] ?? null;
    $hospital_email         = $DataSettingGeneral['hospital_email'] ?? null;
    $hospital_code          = $DataSettingGeneral['hospital_code'] ?? null;
    $hospital_manager       = $DataSettingGeneral['hospital_manager'] ?? null;
    $favicon                = $DataSettingGeneral['favicon'] ?? null;
    $logo                   = $DataSettingGeneral['logo'] ?? null;

    //Ubah keyword menjadi arry
    if(!empty($aplication_keyword)){
        $aplication_keyword      = json_decode($aplication_keyword, true);
        $aplication_keyword_show = strtolower(implode(", ", $aplication_keyword));
    }else{
        $aplication_keyword_show = "";
    }

    // Tutup statement
    $stmt->close();

    // Tampilkan Data
    echo '
        <div class="row mb-2">
            <div class="col-4"><small>Profil Pengaturan</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-muted">'.$setting_name.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Nama Aplikasi</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-muted">'.$aplication_name.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Deskripsi</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-muted">'.$aplication_description.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Keyword</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-muted">'.$aplication_keyword_show.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Author</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-muted">'.$aplication_author.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Base URL</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-muted">'.$base_url.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Nama Faskes</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-muted">'.$hospital_name.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Alamat</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-muted">'.$hospital_address.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Nomor Kontak</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-muted">'.$hospital_contact.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Email</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-muted">'.$hospital_email.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Kode Faskes</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-muted">'.$hospital_code.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Manajer / Direktur</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-muted">'.$hospital_manager.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Favicon</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <a href="../../assets/images/'.$favicon.'" target="_blank">
                    <small class="text text-primary">'.$favicon.'</small>
                </a>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Logo</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <a href="../../assets/images/'.$logo.'" target="_blank">
                    <small class="text text-primary">'.$logo.'</small>
                </a>
            </div>
        </div>
    ';

?>