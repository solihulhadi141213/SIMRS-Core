<?php
    include "../../_Config/Connection.php";
    //Menampilkan Provinsi
    echo '<option value="">Pilih</option>';
    if(!empty($_POST['kode_kabkota'])){
        $kode_kabkota=$_POST['kode_kabkota'];
        $query = mysqli_query($Conn, "SELECT*FROM wilayah_mendagri WHERE kategori='Kecamatan' AND kode like '%$kode_kabkota%' ORDER BY nama ASC");
        while ($data = mysqli_fetch_array($query)) {
            $id_wilayah_mendagri= $data['id_wilayah_mendagri'];
            $kategori_list= $data['kategori'];
            $kode= $data['kode'];
            $nama= $data['nama'];
            echo '<option value="'.$kode.'">'.$nama.'</option>';
        }
    }
?>