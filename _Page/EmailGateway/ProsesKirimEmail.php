<?php
    date_default_timezone_set('Asia/Jakarta');

    // Connection
    include "../../_Config/Connection.php";

    // Simrs Function
    include "../../_Config/SimrsFunction.php";

    // Session
    include "../../_Config/Session.php";

    // =====================================
    // VALIDASI SESSION
    // =====================================
    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger text-center">
                <small>
                    Sesi akses sudah berakhir. Silahkan <b>Login</b> ulang!
                </small>
            </div>
        ';
        exit;
    }

    // =====================================
    // VALIDASI METHOD
    // =====================================
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo '
            <div class="alert alert-danger text-center">
                <small>
                    Metode request tidak valid!
                </small>
            </div>
        ';
        exit;
    }

    // =====================================
    // VALIDASI ID
    // =====================================
    $id_setting_email_gateway = $_POST['id_setting_email_gateway'] ?? '';

    if (empty($id_setting_email_gateway)) {
        echo '
            <div class="alert alert-danger text-center">
                <small>
                    ID Email Gateway tidak boleh kosong.
                </small>
            </div>
        ';
        exit;
    }

    // =====================================
    // AMBIL DATA FORM
    // =====================================
    $email_tujuan  = isset($_POST['email_tujuan']) ? trim($_POST['email_tujuan']) : '';
    $nama_penerima = isset($_POST['nama_penerima']) ? trim($_POST['nama_penerima']) : '';
    $subject       = isset($_POST['subject']) ? trim($_POST['subject']) : '';
    $pesan         = isset($_POST['pesan']) ? trim($_POST['pesan']) : '';

    // =====================================
    // VALIDASI FIELD WAJIB
    // =====================================
    $mandatory = [
        $email_tujuan,
        $nama_penerima,
        $subject,
        $pesan
    ];

    foreach ($mandatory as $item) {
        if (empty($item)) {
            echo '
                <div class="alert alert-danger text-center">
                    <small>
                        Masih ada field wajib yang kosong.
                    </small>
                </div>
            ';
            exit;
        }
    }

    // Kirim Email
    $kirim_email = SendEmail($Conn, $id_setting_email_gateway, $subject, $email_tujuan, $nama_penerima, $pesan);
    echo '
        <div class="alert alert-info">
            <small>
                '.$kirim_email.'
            </small>
        </div>
    ';
    exit;
?>