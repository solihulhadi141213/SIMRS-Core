<?php 
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //Membuat RM Terbaru
    $Qry=mysqli_query($Conn, "SELECT max(id_pasien) as maksimal FROM pasien")or die(mysqli_error($Conn));
    while($Hasil=mysqli_fetch_array($Qry)){
        $NilaiMaxRm=$Hasil['maksimal'];
    }
    $MaxRm=$NilaiMaxRm+1;
    echo "$MaxRm";
?>