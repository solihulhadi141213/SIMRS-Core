<?php
    include "../../_Config/Connection.php";
    //Menampilkan Provinsi
    echo '<option value="">Pilih</option>';
    $query = mysqli_query($Conn, "SELECT*FROM wilayah_mendagri WHERE kategori='Provinsi' ORDER BY nama ASC");
    while ($data = mysqli_fetch_array($query)) {
        $id_wilayah_mendagri= $data['id_wilayah_mendagri'];
        $kategori_list= $data['kategori'];
        $kode= $data['kode'];
        $nama= $data['nama'];
        echo '<option value="'.$kode.'">'.$nama.'</option>';
    }
?>