<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //tanggal
    if(!empty($_POST['user'])){
        $user=$_POST['user'];
        $QryDetailAkses = mysqli_query($Conn,"SELECT * FROM akses WHERE nama='$user'")or die(mysqli_error($Conn));
        $DataDetailAkses = mysqli_fetch_array($QryDetailAkses);
        $id_akses = $DataDetailAkses['id_akses'];
        if(!empty($id_akses)){
            echo '<i id="HasilCariUser2">'.$id_akses.'</i>';
        }else{
            echo "";
        }
    }else{
        $user="";
    }
?>