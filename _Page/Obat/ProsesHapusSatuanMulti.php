<?php
    include "../../_Config/Connection.php";
    if(empty($_POST['id_obat_multi'])){
        echo '<span class="text-danger">ID Satuan Tidak Boleh Kosong!</span>';
    }else{
        $id_obat_multi=$_POST['id_obat_multi'];
        $HapusSatuanMulti = mysqli_query($Conn, "DELETE FROM obat_satuan WHERE id_obat_multi='$id_obat_multi'") or die(mysqli_error($Conn));
        if($HapusSatuanMulti){
            $_SESSION['NotifikasiSwal']="Hapus Satuan Multi Berhasil";
            echo '<span class="text-success" id="NotifikasiHapusSatuanMultiBerhasil">Success</span>';
        }else{
            echo '<span class="text-danger">Terjadi kesalahan ketika menghapus data satuan multi!</span>';
        }
    }
?>