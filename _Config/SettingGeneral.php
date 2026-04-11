<?php
    // ==============================
    // Default Setting
    // ==============================
    $setting_name           = "Default";
    $aplication_name        = "My Application";
    $aplication_description = "Default application description";
    $aplication_keyword     = [];
    $aplication_keyword_show= "";
    $aplication_author      = "Administrator";
    $base_url               = "#";
    $hospital_name          = "My Hospital";
    $hospital_address       = "-";
    $hospital_contact       = "-";
    $hospital_email         = "-";
    $hospital_code          = "-";
    $hospital_manager       = "-";
    $favicon                = "No-Image.png";
    $logo                   = "No-Image.png";

    // ==============================
    // Query Setting Aktif
    // ==============================
    $sql  = "SELECT * FROM setting WHERE status = ?";
    $stmt = $Conn->prepare($sql);

    $id = 1;
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();

    // Jika data ditemukan, timpa default
    if ($result->num_rows > 0) {
        $DataSettingGeneral = $result->fetch_assoc();

        $setting_name           = $DataSettingGeneral['setting_name'] ?? $setting_name;
        $aplication_name        = $DataSettingGeneral['aplication_name'] ?? $aplication_name;
        $aplication_description = $DataSettingGeneral['aplication_description'] ?? $aplication_description;
        $aplication_author      = $DataSettingGeneral['aplication_author'] ?? $aplication_author;
        $base_url               = $DataSettingGeneral['base_url'] ?? $base_url;
        $hospital_name          = $DataSettingGeneral['hospital_name'] ?? $hospital_name;
        $hospital_address       = $DataSettingGeneral['hospital_address'] ?? $hospital_address;
        $hospital_contact       = $DataSettingGeneral['hospital_contact'] ?? $hospital_contact;
        $hospital_email         = $DataSettingGeneral['hospital_email'] ?? $hospital_email;
        $hospital_code          = $DataSettingGeneral['hospital_code'] ?? $hospital_code;
        $hospital_manager       = $DataSettingGeneral['hospital_manager'] ?? $hospital_manager;
        $favicon                = $DataSettingGeneral['favicon'] ?? $favicon;
        $logo                   = $DataSettingGeneral['logo'] ?? $logo;

        // Keyword
        if (!empty($DataSettingGeneral['aplication_keyword'])) {
            $aplication_keyword = json_decode($DataSettingGeneral['aplication_keyword'], true);

            if (is_array($aplication_keyword)) {
                $aplication_keyword_show = strtolower(implode(", ", $aplication_keyword));
            }
        }
    }

    $stmt->close();
?>