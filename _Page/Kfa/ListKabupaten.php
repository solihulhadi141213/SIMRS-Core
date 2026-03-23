<?php
    include "../../_Config/Connection.php";
    //Menampilkan Provinsi
    echo '<option value="">Pilih</option>';
    if(!empty($_POST['kode_provinsi'])){
        $kode_provinsi=$_POST['kode_provinsi'];
        $query = mysqli_query($Conn, "SELECT*FROM wilayah_mendagri WHERE kategori='Kota Kabupaten' AND kode like '%$kode_provinsi%' ORDER BY nama ASC");
        while ($data = mysqli_fetch_array($query)) {
            $id_wilayah_mendagri= $data['id_wilayah_mendagri'];
            $kategori_list= $data['kategori'];
            $kode= $data['kode'];
            $nama= $data['nama'];
            echo '<option value="'.$kode.'">'.$nama.'</option>';
        }
    }
?>