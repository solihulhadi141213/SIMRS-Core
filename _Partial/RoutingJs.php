<?php
    $version = date('YmdHis');

    // Tambahan default script (selalu dimuat)
    echo '<script type="text/javascript" src="_Page/Dashboard/Dashboard.js?v='.$version.'"></script>' . PHP_EOL;
    
    // Daftar halaman dan lokasi file JS-nya
    $pages = [
        "Profile"          => "_Page/ProfileUser/ProfileUser.js?v='.$version.'",
        "Setting"          => "_Page/Setting/Setting.js?v='.$version.'",
        "ApiKey"           => "_Page/ApiKey/ApiKey.js?v='.$version.'",
        "EmailGateway"     => "_Page/EmailGateway/EmailGateway.js?v='.$version.'",
        "GoogleCredential" => "_Page/GoogleCredential/GoogleCredential.js?v='.$version.'",
        "AksesFitur"       => "_Page/AksesFitur/AksesFitur.js?v='.$version.'",
        "AksesEntitas"     => "_Page/AksesEntitas/AksesEntitas.js?v='.$version.'",
        "Akses"            => "_Page/Akses/Akses.js?v='.$version.'",
        "AksesPengajuan"   => "_Page/AksesPengajuan/AksesPengajuan.js?v='.$version.'",
        "SettingSatuSehat" => "_Page/SettingSatuSehat/SettingSatuSehat.js?v='.$version.'",
        "SettingBpjs"      => "_Page/SettingBpjs/SettingBpjs.js?v='.$version.'",
    ];

    // Load file JS sesuai halaman aktif
    if (isset($Page) && isset($pages[$Page])) {
        echo '<script type="text/javascript" src="' . htmlspecialchars($pages[$Page], ENT_QUOTES, 'UTF-8') . '"></script>' . PHP_EOL;
    }
?>
