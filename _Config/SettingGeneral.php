<?php
    // ==============================
    // Default Setting
    // ==============================
    $setting_name           = "Default";
    $aplication_name        = "SIMRS-CORE";
    $aplication_description = "SIMRS Core V3 is an improvement over the previous version, SIMRS V2. This version features significant changes and a different way of working.";
    $aplication_keyword     = ['SIMRS', 'Core', 'Hospital', 'Management', 'System'];
    $aplication_keyword_show= "SIMRS, Core, Hospital, Management, System";
    $aplication_author      = "Solihul Hadi";
    $base_url               = "localhost/SIMRS-Core";
    $hospital_name          = "My Hospital";
    $hospital_address       = "Hospital Address Here";
    $hospital_contact       = "08123456789";
    $hospital_email         = "hospital@example.com";
    $hospital_code          = "HOSP-001";
    $hospital_manager       = "Dr. John Doe";
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
        $aplication_name        = "SIMRS-CORE";
        $aplication_description = "SIMRS Core V3 is an improvement over the previous version, SIMRS V2. This version features significant changes and a different way of working.";
        $aplication_keyword     = ['SIMRS', 'Core', 'Hospital', 'Management', 'System'];
        $aplication_keyword_show= "SIMRS, Core, Hospital, Management, System";
        $aplication_author      = "Solihul Hadi";
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