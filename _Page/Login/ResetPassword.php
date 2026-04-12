<?php
    // Koneksi Dan Function
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/SettingGeneral.php";

    // Function Untuk Tampilan 
    function showResultPage($title, $message, $type = 'success'){
        $icon = $type === 'success' ? '✓' : '✕';
        $color = $type === 'success' ? '#198754' : '#dc3545';

        echo '
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <title>'.$title.'</title>
                <meta name="viewport" content="width=device-width, initial-scale=1">
            </head>
            <body style="
                margin:0;
                font-family:Arial, sans-serif;
                background:#f5f7fa;
                display:flex;
                justify-content:center;
                align-items:center;
                min-height:100vh;
            ">
                <div style="
                    width:100%;
                    max-width:500px;
                    background:#ffffff;
                    border-radius:12px;
                    box-shadow:0 4px 16px rgba(0,0,0,0.08);
                    padding:40px;
                    text-align:center;
                ">
                    <div style="
                        width:70px;
                        height:70px;
                        line-height:70px;
                        margin:0 auto 20px;
                        border-radius:50%;
                        background:'.$color.';
                        color:#fff;
                        font-size:36px;
                        font-weight:bold;
                    ">
                        '.$icon.'
                    </div>

                    <h2 style="margin-bottom:15px; color:#333;">
                        '.$title.'
                    </h2>

                    <p style="color:#666; line-height:1.7;">
                        '.$message.'
                    </p>
                </div>
            </body>
            </html>
        ';
        exit;
    }

    // Validasi id dari LINK
    if(empty($_GET['id'])){
        showResultPage(
            'Opps!',
            'ID Sesi Reset Tidak Boleh Kosong!',
            'error'
        );
        exit;
    }

    // Validasi token dari LINK
    if(empty($_GET['token'])){
        showResultPage(
            'Opps!',
            'Token Reset Tidak Boleh Kosong!',
            'error'
        );
        exit;
    }

    // Buat Variabel Dan Sanitasi
    $id_akses_reset = validateAndSanitizeInput($_GET['id']);
    $token          = validateAndSanitizeInput($_GET['token']);

    // tetapkan Waktu Sekarang Dalam UTC
    $utc = new DateTime('now', new DateTimeZone('UTC'));
    $current_utc = $utc->format('Y-m-d H:i:s');

    // Validasi id_akses_reset dan token
    $qry = $Conn->prepare("SELECT * FROM akses_reset WHERE id_akses_reset = ? LIMIT 1");
    $qry->bind_param("i", $id_akses_reset);
    $qry->execute();
    $result = $qry->get_result();
    $data   = $result->fetch_assoc();
    if (!$data) {
        showResultPage(
            'Opps!',
            'ID Pada Tautan Yang Anda Gunakan Tidak Valid!',
            'error'
        );
        exit;
    }

    if (!password_verify($token, $data['token'])) {
        showResultPage(
            'Opps!',
            'Token Pada Tautan Yang Anda Gunakan Tidak Valid!',
            'error'
        );
        exit;
    }
    $datetime_expired = $data['datetime_expired'];
    if($datetime_expired<$current_utc){
        showResultPage(
            'Opps!',
            'Tautan Telah Melewati Batas Waktu (Expired)',
            'error'
        );
        exit;
    }

    // Validasi Pengaturan Email Gateway
    $id_setting_email_gateway = getDataDetail_v2($Conn, 'setting_email_gateway', 'status', 1, 'id_setting_email_gateway');
    if(empty($id_setting_email_gateway)){
        showResultPage(
            'Opps!',
            'Email Gateway Belum Diatur',
            'error'
        );
        exit;
    }

    // Jika Valid Buat Password Baru Dan Simpan
    $id_akses            = $data['id_akses'];
    $password_baru_plain = GenerateRandomeToken(8);
    $password_baru_hash  = password_hash($password_baru_plain, PASSWORD_DEFAULT);

    // Update database
    $sql = "UPDATE akses SET password = ? WHERE id_akses = ?";
    $stmt = $Conn->prepare($sql);
    if (!$stmt) {
        showResultPage(
            'Opps!',
            'Terjadi Kesalahan Pada Saat Memperbaharui Password',
            'error'
        );
        exit;
    }
    $stmt->bind_param("si", $password_baru_hash,$id_akses);
    if (!$stmt->execute()) {
        showResultPage(
            'Opps!',
            'Terjadi Kesalahan Pada Saat Memperbaharui Password',
            'error'
        );
        exit;
    }

    // Persiapkan Untuk Mengirim Email
    $email       = getDataDetail_v2($Conn, 'akses', 'id_akses', $id_akses, 'email');
    $nama_tujuan = getDataDetail_v2($Conn, 'akses', 'id_akses', $id_akses, 'nama');
    $subjek      = "Informasi Akun Anda";
    $pesan = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Informasi Akun</title>
        </head>
        <body style="
            margin:0;
            padding:0;
            background:#f5f7fa;
            font-family:Arial, Helvetica, sans-serif;
        ">
            <div style="
                max-width:600px;
                margin:40px auto;
                background:#ffffff;
                border-radius:10px;
                overflow:hidden;
                box-shadow:0 4px 12px rgba(0,0,0,0.08);
                border:1px solid #e5e7eb;
            ">
                
                <div style="
                    background:#198754;
                    color:#ffffff;
                    padding:20px;
                    text-align:center;
                    font-size:22px;
                    font-weight:bold;
                ">
                    Reset Password Berhasil
                </div>

                <div style="padding:30px; color:#333; line-height:1.7;">
                    <p>Halo <b>'.$nama_tujuan.'</b>,</p>

                    <p>
                        Password akun Anda berhasil diperbarui melalui proses reset password.
                    </p>

                    <p>
                        Berikut informasi akun Anda:
                    </p>

                    <table style="
                        width:100%;
                        border-collapse:collapse;
                        margin:20px 0;
                    ">
                        <tr>
                            <td style="padding:10px; border:1px solid #ddd;"><b>Email</b></td>
                            <td style="padding:10px; border:1px solid #ddd;">'.$email.'</td>
                        </tr>
                        <tr>
                            <td style="padding:10px; border:1px solid #ddd;"><b>Password Baru</b></td>
                            <td style="padding:10px; border:1px solid #ddd;">'.$password_baru_plain.'</td>
                        </tr>
                    </table>

                    <p>
                        Demi keamanan akun, kami sangat menyarankan Anda untuk segera login dan mengganti password ini.
                    </p>

                    <div style="
                        margin-top:20px;
                        padding:15px;
                        background:#fff3cd;
                        border:1px solid #ffe69c;
                        border-radius:6px;
                        color:#664d03;
                    ">
                        <b>Penting:</b> Jangan bagikan password ini kepada siapa pun.
                    </div>
                </div>

                <div style="
                    background:#f8f9fa;
                    text-align:center;
                    padding:15px;
                    font-size:12px;
                    color:#6c757d;
                ">
                    Email ini dikirim otomatis oleh sistem.<br>
                    Mohon tidak membalas email ini.
                </div>
            </div>
        </body>
        </html>
    ';

    $kirim_email = SendEmail($Conn, $id_setting_email_gateway, $subjek, $email, $nama_tujuan, $pesan);

    // Hapus Token
    $stmtDelete = $Conn->prepare("DELETE FROM akses_reset WHERE id_akses = ?");
    $stmtDelete->bind_param("i", $id_akses);
    $delete = $stmtDelete->execute();

    if ($delete) {
        // Tampilan Berhasil
        showResultPage(
            'Reset Berhasil!',
            'Password Berhasil Di Reset! Silahkan Lihat Informasi AKun Anda Pada Inbox Email Yang Telah Kami Kirim!',
            'success'
        );
    }else{
        showResultPage(
            'Opps!',
            'Terjadi Kesalahan Pada Saat Menghapus Token',
            'error'
        );
    }
?>