<?php
    // ==============================
    // Default Setting
    // ==============================
    $email_gateway    = "";
    $password_gateway = "";
    $url_provider     = "";
    $port_gateway     = "";
    $nama_pengirim    = "";
    $url_service      = "";

    // ==============================
    // Query Setting Aktif
    // ==============================
    $sqlEmailGateway  = "SELECT * FROM setting_email_gateway WHERE status = ?";
    $stmtEmailGateway = $Conn->prepare($sqlEmailGateway);

    $id = 1;
    $stmtEmailGateway->bind_param("i", $id);
    $stmtEmailGateway->execute();

    $resultEmailGateway = $stmtEmailGateway->get_result();

    // Jika data ditemukan, timpa default
    if ($resultEmailGateway->num_rows > 0) {
        $DataEmailGateway = $resultEmailGateway->fetch_assoc();

        $email_gateway    = $DataEmailGateway['email_gateway'] ?? $email_gateway;
        $password_gateway = $DataEmailGateway['password_gateway'] ?? $password_gateway;
        $url_provider     = $DataEmailGateway['url_provider'] ?? $url_provider;
        $port_gateway     = $DataEmailGateway['port_gateway'] ?? $port_gateway;
        $nama_pengirim    = $DataEmailGateway['nama_pengirim'] ?? $nama_pengirim;
        $url_service      = $DataEmailGateway['url_service'] ?? $url_service;
       
    }

    $stmtEmailGateway->close();
?>