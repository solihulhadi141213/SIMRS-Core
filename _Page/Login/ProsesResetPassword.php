<?php
    //Response Format
    header('Content-Type: application/json');
    
    // Koneksi Dan Function
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/SettingGeneral.php";

    // Fungsi Untuk Response
    function respond($status, $message){
        echo json_encode([
            'status' => $status,
            'message' => $message
        ]);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        respond('error', 'Metode tidak diizinkan.');
    }

    // Ambil & sanitasi
    $email = trim($_POST['email'] ?? '');
    if(empty($email)){
        respond('error', 'Email Tidak Boleh Kosong!');
    }

    // Validasi Email
    $id_akses = getDataDetail_v2($Conn, 'akses', 'email', $email, 'id_akses');
    if(empty($email)){
        respond('error', 'Email Tidak Terdaftar!');
    }

    // ID Pengaturan Yang Aktif
    $id_setting_email_gateway = getDataDetail_v2($Conn, 'setting_email_gateway', 'status', 1, 'id_setting_email_gateway');
    if(empty($id_setting_email_gateway)){
        respond('error', 'Email Gateway Belum Diatur!');
        exit;
    }

    // Waktu Sekrang Dalam UTC
    $datetime = new DateTime('now', new DateTimeZone('UTC'));
    $datetime_creat = $datetime->format('Y-m-d H:i:s');

    // Menentukan Expired
    $datetime->modify('+1 hour');
    $datetime_expired = $datetime->format('Y-m-d H:i:s');

    // Token
    $plain_token = GenerateRandomeToken(32);
    $hashed_token = password_hash($plain_token, PASSWORD_DEFAULT);

    // Simpan Ke Database
    $stmt = $Conn->prepare("INSERT INTO  akses_reset (id_akses, datetime_creat, datetime_expired, token) VALUES (?,?,?,?)");
    $stmt->bind_param(
        'isss',
        $id_akses,
        $datetime_creat,
        $datetime_expired,
        $hashed_token
    );

    // Jika Gagal Disimpan Ke Database
    if (!$stmt->execute()) {
        respond('error', 'Terjadi Kesalahan Pada Saat Membuat Token Reset Password!');
        exit;
    }

    //Persiapkan Untuk Mengirim Email
    $id_akses_reset = $stmt->insert_id;
    $link_reset = "$base_url/_Page/Login/ResetPassword.php?token=$plain_token&id=$id_akses_reset";

    // Subjek Pesan
    $subjek = "Tautan Reset Password";

    // Nama Pengguna
    $nama_tujuan = getDataDetail_v2($Conn, 'akses', 'email', $email, 'nama');

    $pesan = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Reset Password</title>
        </head>
        <body style="
            margin:0;
            padding:0;
            font-family: Arial, Helvetica, sans-serif;
            background-color:#f5f5f5;
        ">
            <div style="
                max-width:600px;
                margin:40px auto;
                background:#ffffff;
                border:1px solid #dddddd;
                border-radius:8px;
                overflow:hidden;
                box-shadow:0 2px 8px rgba(0,0,0,0.05);
            ">
                
                <div style="
                    background:#0d6efd;
                    color:#ffffff;
                    padding:20px;
                    text-align:center;
                    font-size:22px;
                    font-weight:bold;
                ">
                    Reset Password Akun
                </div>

                <div style="padding:30px; color:#333333; line-height:1.6;">
                    <p>Halo <b>'.$nama_tujuan.'</b>,</p>

                    <p>
                        Kami menerima permintaan untuk melakukan <b>reset password</b> pada akun Anda.
                    </p>

                    <p>
                        Jika Anda yang melakukan permintaan ini, silakan klik tombol di bawah untuk melanjutkan proses reset password.
                    </p>

                    <div style="text-align:center; margin:30px 0;">
                        <a href="'.$link_reset.'" style="
                            background:#0d6efd;
                            color:#ffffff;
                            text-decoration:none;
                            padding:12px 24px;
                            border-radius:6px;
                            display:inline-block;
                            font-weight:bold;
                        ">
                            Reset Password
                        </a>
                    </div>

                    <p>
                        Tautan ini hanya berlaku selama <b>1 jam</b>.
                    </p>

                    <p>
                        Jika Anda tidak merasa melakukan permintaan ini, abaikan email ini. 
                        Password Anda tetap aman dan tidak akan berubah.
                    </p>

                    <hr style="border:none; border-top:1px solid #eeeeee; margin:25px 0;">

                    <p style="font-size:12px; color:#777777;">
                        Demi keamanan, jangan bagikan tautan ini kepada siapa pun.
                    </p>
                </div>

                <div style="
                    background:#f8f9fa;
                    padding:15px;
                    text-align:center;
                    font-size:12px;
                    color:#666666;
                ">
                    Email ini dikirim secara otomatis oleh sistem.<br>
                    Mohon tidak membalas email ini.
                </div>
            </div>
        </body>
        </html>
    ';
    
    $kirim_email = SendEmail($Conn, $id_setting_email_gateway, $subjek, $email, $nama_tujuan, $pesan);

    // Response Success
    respond('success', 'Kami Telah Mengirim Tautan Reset Password Ke Email Anda');
?>