<?php
    include "../../_Config/Connection.php";
    if(!empty($_POST['id_obat_storage1'])){
        $id_obat_storage=$_POST['id_obat_storage1'];
        //List Lokasi Penyimpanan
        echo '<option selected value="">Pilih</option>';
        $QrlPenyimpanan = mysqli_query($Conn, "SELECT*FROM obat_storage ORDER BY nama_penyimpanan DESC");
        while ($DataPenyimpanan = mysqli_fetch_array($QrlPenyimpanan)) {
            $IdStorageList= $DataPenyimpanan['id_obat_storage'];
            $NamaPenyimpananList= $DataPenyimpanan['nama_penyimpanan'];
            if($id_obat_storage!==$IdStorageList){
                echo '<option selected value="'.$IdStorageList.'">'.$NamaPenyimpananList.'</option>';
            }
        }
    }
?>