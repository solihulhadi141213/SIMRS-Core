<?php
    session_start();
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";

    // Validasi Email Tidak Boleh Kosong
    if (empty($_POST["email"])) {
        echo '<span class="text-danger">Email Tidak Boleh Kosong</span>';
        exit;
    }

    if (empty($_POST["password"])) {
        echo '<span class="text-danger">Password Tidak Boleh Kosong</span>';
        exit;
    }

    if (empty($_POST["captcha"])) {
        echo '<span class="text-danger">Kode Captcha Tidak Boleh Kosong</span>';
        exit;
    }

    if (empty($_SESSION["code"])) {
        echo '<span class="text-danger">Sesi Kode Captcha Telah Berakhir, Silahkan Muat Ulang Halaman Terlebih Dulu!</span>';
        exit;
    }

    // Ambil Input
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $captcha = trim($_POST["captcha"]);
    $code = $_SESSION["code"];

    // Validasi Format Email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<span class="text-danger">Format Email Tidak Valid</span>';
        exit;
    }

    // Enkripsi Captcha untuk Validasi
    $captchaHash = md5($captcha);
    if ($captchaHash !== $code) {
        echo '<span class="text-danger">Kode Captcha Yang Anda Masukan Tidak Valid</span>';
        exit;
    }

    // Validasi Email
    $queryEmail = $Conn->prepare("SELECT * FROM akses WHERE email = ?");
    $queryEmail->bind_param("s", $email);
    $queryEmail->execute();
    $resultEmail = $queryEmail->get_result();
    $DataEmail = $resultEmail->fetch_assoc();

    if (!$DataEmail) {
        echo '<span class="text-danger">Email Yang Anda Gunakan Tidak Valid</span>';
        exit;
    }

    // Validasi Password dan Email
    $queryAkses = $Conn->prepare("SELECT * FROM akses WHERE email = ? AND password = ?");
    $passwordHash = md5($password); // Menggunakan MD5 sesuai alur, rekomendasi: ubah ke password_hash
    $queryAkses->bind_param("ss", $email, $passwordHash);
    $queryAkses->execute();
    $resultAkses = $queryAkses->get_result();
    $DataAkses = $resultAkses->fetch_assoc();

    if (!$DataAkses) {
        echo '<span class="text-danger">Email Dan Password Yang Anda Gunakan Tidak Valid</span>';
        exit;
    }

    // Login Berhasil
    $id_akses = $DataAkses["id_akses"];
    $WaktuLog = date('Y-m-d H:i');
    $Nama = htmlspecialchars($DataAkses["nama"], ENT_QUOTES, 'UTF-8');
    $nama_log = "Login Berhasil";
    $kategori_log = "Login";
    $JsonUrl = "../../_Page/Log/Log.json";

    // Simpan Log
    $SimpanLog = getSaveLog($Conn, $WaktuLog, $Nama, $nama_log, $kategori_log, $id_akses, $JsonUrl);
    if ($SimpanLog !== "Berhasil") {
        echo $SimpanLog;
        exit;
    }

    // Set Session
    $_SESSION["id_akses"] = $id_akses;
    $_SESSION["email"] = $email;
    $_SESSION['NotifikasiSwal'] = "Login Berhasil";
    echo '<span class="text-success" id="NotifikasiLoginBerhasil">Success</span>';
?>
