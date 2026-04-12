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

    // Validasi id_setting_email_gateway
    if(empty($_POST['id_setting_email_gateway'])){
        echo '
            <div class="alert alert-danger text-center">
                <small>ID Email Gateway Tidak Boleh Kosong!</small>
            </div>
        ';
        exit;
    }

    // Buat Variabel Dan Sanitasi
    $id_setting_email_gateway = validateAndSanitizeInput($_POST['id_setting_email_gateway']);

    // Buka Data Dengan Prepared Statment
    $sql  = "SELECT * FROM  setting_email_gateway WHERE id_setting_email_gateway = ?";
    $stmt = $Conn->prepare($sql);

    // Bind parameter (tipe data integer "i")
    $stmt->bind_param("i", $id_setting_email_gateway);

    // Eksekusi statement
    $stmt->execute();

    // Ambil hasil query
    $result = $stmt->get_result();
    $DataSettingGeneral = $result->fetch_assoc();

    // Simpan hasil ke variabel
    $email_gateway    = $DataSettingGeneral['email_gateway'] ?? null;
    $password_gateway = $DataSettingGeneral['password_gateway'] ?? null;
    $url_provider     = $DataSettingGeneral['url_provider'] ?? null;
    $port_gateway     = $DataSettingGeneral['port_gateway'] ?? null;
    $nama_pengirim    = $DataSettingGeneral['nama_pengirim'] ?? null;
    $url_service      = $DataSettingGeneral['url_service'] ?? null;
    $status           = $DataSettingGeneral['status'] ?? null;

    // Routing Status
    if($status==1){
        $label_status = 'checked';
    }else{
        $label_status = '';
    }

    // Tutup statement
    $stmt->close();

    // Tampilkan Data
    echo '
        <input type="hidden" name="id_setting_email_gateway" value="'.$id_setting_email_gateway.'">
        <div class="row mb-3">
            <div class="col-12">
                <label for="email_tujuan"><small>Email Tujuan</small></label>
                <input type="email" name="email_tujuan" id="email_tujuan" class="form-control" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <label for="nama_penerima"><small>Nama Penerima</small></label>
                <input type="text" name="nama_penerima" id="nama_penerima" class="form-control" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <label for="subject"><small>Subjek</small></label>
                <input type="text" name="subject" id="subject" class="form-control" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <label for="pesan"><small>Isi Pesan</small></label>
                <textarea name="pesan" id="pesan" class="form-control"></textarea>
            </div>
        </div>
    ';

?>