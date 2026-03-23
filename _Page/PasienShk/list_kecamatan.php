<?php
    include "../../_Config/Connection.php";
    if(!empty($_POST['kabupaten'])){
        $kabupaten=$_POST['kabupaten'];
        //Mencari Kode kabupaten
        $QryParam = mysqli_query($Conn,"SELECT * FROM wilayah_mendagri WHERE nama='$kabupaten'")or die(mysqli_error($Conn));
        $DataParam = mysqli_fetch_array($QryParam);
        if(!empty($DataParam['kode'])){
            $kode=$DataParam['kode'];
            $query = mysqli_query($Conn, "SELECT*FROM wilayah_mendagri WHERE kategori='Kecamatan' AND kode like '%$kode%' ORDER BY nama ASC");
            while ($data = mysqli_fetch_array($query)) {
                $nama = $data['nama'];
                echo '<option value="'.$nama.'">';
            }
        }
        
    }
?>