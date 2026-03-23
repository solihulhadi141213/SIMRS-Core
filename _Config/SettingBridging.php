<?php
    //Membuka data profile brdiging
    $QryBridging = mysqli_query($Conn,"SELECT * FROM bridging WHERE status='Aktiv'")or die(mysqli_error($Conn));
    $DataBridging = mysqli_fetch_array($QryBridging);
    $id_bridging= $DataBridging['id_bridging'];
    $nama_bridging= $DataBridging['nama_bridging'];
    $consid= $DataBridging['consid'];
    $cons_id_antrol= $DataBridging['cons_id_antrol'];
    $user_key= $DataBridging['user_key'];
    $user_key_antrol= $DataBridging['user_key_antrol'];
    $secret_key= $DataBridging['secret_key'];
    $secret_key_antrol= $DataBridging['secret_key_antrol'];
    $kode_ppk= $DataBridging['kode_ppk'];
    $url_vclaim= $DataBridging['url_vclaim'];
    $url_aplicare= $DataBridging['url_aplicare'];
    $url_faskes= $DataBridging['url_faskes'];
    $url_antrol= $DataBridging['url_antrol'];
    $url_icare= $DataBridging['url_icare'];
    $kategori_ppk= $DataBridging['kategori_ppk'];
    $status= $DataBridging['status'];
?>