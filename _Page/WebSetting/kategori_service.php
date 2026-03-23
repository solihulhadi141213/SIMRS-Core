<?php
    //Koneksi 
    include "../../_Config/Connection.php";
    if(empty($_POST['GetKategori'])){
        $GetKategori="";
    }else{
        $GetKategori=$_POST['GetKategori'];
    }
    if(empty($GetKategori)){
        echo '<option selected value="">Semua Kategori</option>';
    }else{
        echo '<option value="">Semua Kategori</option>';
    }
    
    $QryKategoriService = mysqli_query($Conn, "SELECT DISTINCT service_category FROM setting_service ORDER BY service_category ASC");
    while ($DataKategoriService = mysqli_fetch_array($QryKategoriService)) {
        $service_category= $DataKategoriService['service_category'];
        if($GetKategori==$service_category){
            echo '<option selected value="'.$service_category.'">'.$service_category.'</option>';
        }else{
            echo '<option value="'.$service_category.'">'.$service_category.'</option>';
        }
    }
?>