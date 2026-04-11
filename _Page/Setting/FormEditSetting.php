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
    $status                 = $DataSettingGeneral['status'] ?? null;

    // Routing $status
    if($status==1){
        $form_status = "checked";
    }else{
        $form_status = "";
    }

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
        <input type="hidden" name="id_setting" value="'.$id_setting.'">
        <div class="row mb-3">
            <div class="col-12">
                <label for="setting_name_edit"><small>Nama Profil Pengaturan</small></label>
                <input type="text" name="setting_name" id="setting_name_edit" class="form-control" required placeholder="Contoh : Development, Staging atau Production" value="'.$setting_name.'">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <label for="aplication_name_edit"><small>Nama Aplikasi</small></label>
                <input type="text" name="aplication_name" id="aplication_name_edit" required class="form-control" value="'.$aplication_name.'">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <label for="aplication_description_edit"><small>Deskripsi</small></label>
                <textarea name="aplication_description" id="aplication_description_edit" required class="form-control">'.$aplication_description.'</textarea>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <label for="aplication_keyword_edit"><small>Kata Kunci (<i>Keyword</i>)</small></label>
                <input type="text" name="aplication_keyword" id="aplication_keyword_edit" required class="form-control" placeholder="Contoh : Key1, Key2, Key3, dst " value="'.$aplication_keyword_show.'">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <label for="aplication_author_edit"><small>Author Aplikasi</small></label>
                <input type="text" name="aplication_author" id="aplication_author_edit" required class="form-control" value="'.$aplication_author.'">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <label for="base_url_edit"><small>Base URL</small></label>
                <input type="url" name="base_url" id="base_url_edit" class="form-control" required placeholder="https://" value="'.$base_url.'">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <label for="hospital_name_edit"><small>Nama Faskes</small></label>
                <input type="text" name="hospital_name" id="hospital_name_edit" class="form-control" required placeholder="" value="'.$hospital_name.'">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <label for="hospital_address_edit"><small>Alamat</small></label>
                <textarea name="hospital_address" id="hospital_address_edit" class="form-control" required>'.$hospital_address.'</textarea>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <label for="hospital_contact_edit"><small>No.Kontak</small></label>
                <input type="text" name="hospital_contact" id="hospital_contact_edit" class="form-control" required placeholder="+62" value="'.$hospital_contact.'">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <label for="hospital_email_edit"><small>Email</small></label>
                <input type="email" name="hospital_email" id="hospital_email_edit" class="form-control" required placeholder="faskes@domain.com" value="'.$hospital_email.'">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <label for="hospital_cod_edite"><small>Kode Faskes (Kemenkes)</small></label>
                <input type="text" name="hospital_code" id="hospital_code_edit" class="form-control" value="'.$hospital_code.'">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <label for="hospital_manager_edit"><small>Nama Manager / Direktur</small></label>
                <input type="text" name="hospital_manager" id="hospital_manager_edit" class="form-control" value="'.$hospital_manager.'">
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6 mb-3">
                <label for="favico_editn"><small>Favicon Aplikasi</small></label>
                <input type="file" name="favicon" id="favicon_edit" class="form-control">
                <small class="text text-muted">
                    Maksimal 1 Mb (ICO, PNG, JPG, GIF)
                </small>
            </div>
            <div class="col-xl-6 mb-3">
                <label for="logo_edit"><small>Logo Faskes</small></label>
                <input type="file" name="logo" id="logo_edit" class="form-control">
                <small class="text text-muted">
                    Maksimal 1 Mb (ICO, PNG, JPG, GIF)
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="aktivasi_setting_edit" name="aktivasi_setting" value="1" '.$form_status.' >
                    <label class="form-check-label" for="aktivasi_setting_edit">Aktifkan Profil Pengaturan Ini</label>
                </div>
            </div>
        </div>
    ';

?>