<?php
    //Zona waktu dan koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $now=date('Y-m-d H:i');
    if(empty($_POST['id_supplier'])){
        echo '<span class="text-danger">ID Supplier Tidak Boleh Kosong</span>';
    }else{
        $id_supplier=$_POST['id_supplier'];
        $JumlahDataTransaksiSupplier = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM transaksi WHERE id_supplier='$id_supplier'"));
        if(!empty($JumlahDataTransaksiSupplier)){
            echo '<span class="text-danger">Data Supplier Tidak Bisa Dihapus Karena Memiliki Data Transaksi</span>';
        }else{
            $HapusSupplier = mysqli_query($Conn, "DELETE FROM supplier WHERE id_supplier='$id_supplier'") or die(mysqli_error($Conn));
            if($HapusSupplier){
                $JsonUrl="../../_Page/Log/Log.json";
                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Hapus Supplier","Supplier",$SessionIdAkses,$JsonUrl);
                echo '<span class="text-success" id="NotifikasiHapusSupplierBerhasil">Success</span>';
            }else{
                echo '<span class="text-danger">Terjadi kesalahan pada saat menghapus supplier</span>';
            }
        }
    }
?>