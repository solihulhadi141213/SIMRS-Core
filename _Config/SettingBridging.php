<?php
    //Membuka data profile bridging
    $QryBridging = $Conn->prepare('SELECT * FROM bridging WHERE status = ?');
    if (!$QryBridging) {
        die(mysqli_error($Conn));
    }
    $statusBridging = 'Aktiv';
    $QryBridging->bind_param('s', $statusBridging);
    if (!$QryBridging->execute()) {
        die(mysqli_stmt_error($QryBridging));
    }
    $DataBridging = $QryBridging->get_result()->fetch_assoc();
    $QryBridging->close();
    $id_bridging       = $DataBridging['id_bridging'];
    $nama_bridging     = $DataBridging['nama_bridging'];
    $consid            = $DataBridging['consid'];
    $cons_id_antrol    = $DataBridging['cons_id_antrol'];
    $user_key          = $DataBridging['user_key'];
    $user_key_antrol   = $DataBridging['user_key_antrol'];
    $secret_key        = $DataBridging['secret_key'];
    $secret_key_antrol = $DataBridging['secret_key_antrol'];
    $kode_ppk          = $DataBridging['kode_ppk'];
    $url_vclaim        = $DataBridging['url_vclaim'];
    $url_aplicare      = $DataBridging['url_aplicare'];
    $url_faskes        = $DataBridging['url_faskes'];
    $url_antrol        = $DataBridging['url_antrol'];
    $url_icare         = $DataBridging['url_icare'];
    $kategori_ppk      = $DataBridging['kategori_ppk'];
    $status            = $DataBridging['status'];
?>