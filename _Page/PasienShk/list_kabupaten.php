<?php
    include "../../_Config/Connection.php";
    if(!empty($_POST['provinsi'])){
        $provinsi=$_POST['provinsi'];
        //Mencari Kode Provinsi
        $QryParam = mysqli_query($Conn,"SELECT * FROM wilayah_mendagri WHERE nama='$provinsi'")or die(mysqli_error($Conn));
        $DataParam = mysqli_fetch_array($QryParam);
        if(!empty($DataParam['kode'])){
            $kode=$DataParam['kode'];
            $query = mysqli_query($Conn, "SELECT*FROM wilayah_mendagri WHERE kategori='Kota Kabupaten' AND kode like '%$kode%' ORDER BY nama ASC");
            while ($data = mysqli_fetch_array($query)) {
                $nama = $data['nama'];
                echo '<option value="'.$nama.'">';
            }
        }
        
    }
?>