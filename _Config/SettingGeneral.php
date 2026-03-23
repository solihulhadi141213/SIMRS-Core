<?php
    // Persiapkan query dengan prepared statement
    $sql  = "SELECT * FROM  setting WHERE id_setting = ?";
    $stmt = $Conn->prepare($sql);

    // Bind parameter (tipe data integer "i")
    $id = 1;
    $stmt->bind_param("i", $id);

    // Eksekusi statement
    $stmt->execute();

    // Ambil hasil query
    $result = $stmt->get_result();
    $DataSettingGeneral = $result->fetch_assoc();

    // Simpan hasil ke variabel
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
    $favicon                = $DataSettingGeneral['favicon'] ?? null;
    $logo                   = $DataSettingGeneral['logo'] ?? null;

    //Ubah keyword menjadi arry
    if(!empty($aplication_keyword)){
        $aplication_keyword      = json_decode($aplication_keyword, true);
        $aplication_keyword_show = strtolower(implode(", ", $aplication_keyword));
    }else{
        $aplication_keyword_show = "";
    }

    // Tutup statement
    $stmt->close();

    
?>