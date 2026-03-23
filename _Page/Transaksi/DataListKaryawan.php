<?php
    include "../../_Config/Connection.php";
    if(!empty($_POST['karyawan'])){
        $karyawan=$_POST['karyawan'];
        $query = mysqli_query($Conn, "SELECT DISTINCT karyawan FROM transaksi WHERE karyawan like '%$karyawan%'");
        while ($data = mysqli_fetch_array($query)) {
            $karyawan= $data['karyawan'];
            echo '<option value="'.$karyawan.'">';
        }
    }
?>