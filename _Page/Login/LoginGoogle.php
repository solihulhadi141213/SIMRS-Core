<?php
    // Mulai session
    session_start();

    // Koneksi database dan setting umum aplikasi
    include "../../_Config/Connection.php";
    include "../../_Config/SettingGeneral.php";

    // AMBIL GOOGLE CREDENTIAL YANG AKTIF
    $status = 1;
    $stmt = $Conn->prepare("SELECT * FROM setting_google WHERE status=?");
    $stmt->bind_param("i",$status);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();
    if(!$data){
        die("Credential Google tidak ditemukan");
    }

    // BUKA CLIENT ID
    $client_id = $data['client_id'];

    // BANGUN REDIRECT URI
    $redirect_uri = $base_url . "/_Page/Login/GoogleCallback.php";

    // BANGUN URL AUTENTIKASI GOOGLE
    $scope = urlencode("email profile");
    $auth_url =
        "https://accounts.google.com/o/oauth2/v2/auth?" .
        "response_type=code" .
        "&client_id=".$client_id .
        "&redirect_uri=".urlencode($redirect_uri) .
        "&scope=".$scope .
        "&access_type=online" .
        "&prompt=select_account";
        
    // REDIRECT KE GOOGLE

    header("Location: ".$auth_url);
    exit;

?>