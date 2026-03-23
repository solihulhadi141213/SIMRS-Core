<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_obat_transfer_alokasi'])){
        echo '<span class="text-danger">ID Tempat Penyimpanan Tidak Boleh Kosong!</span>';
    }else{
        $id_obat_transfer_alokasi=$_POST['id_obat_transfer_alokasi'];
        //Buka Detail Transfer
        $id_obat=getDataDetail($Conn,'obat_transfer_alokasi','id_obat_transfer_alokasi',$id_obat_transfer_alokasi,'id_obat');
        $storage_from=getDataDetail($Conn,'obat_transfer_alokasi','id_obat_transfer_alokasi',$id_obat_transfer_alokasi,'storage_from');
        $storage_to=getDataDetail($Conn,'obat_transfer_alokasi','id_obat_transfer_alokasi',$id_obat_transfer_alokasi,'storage_to');
        $qty=getDataDetail($Conn,'obat_transfer_alokasi','id_obat_transfer_alokasi',$id_obat_transfer_alokasi,'qty');
        //Informasi Penyimpanan Asal
        $QryStorageAsal = mysqli_query($Conn,"SELECT * FROM obat_posisi WHERE id_obat='$id_obat' AND id_obat_storage='$storage_from'")or die(mysqli_error($Conn));
        $DataStorageAsal = mysqli_fetch_array($QryStorageAsal);
        if(empty($DataStorageAsal['stok'])){
            $stok_asal=0;
        }else{
            $stok_asal= $DataStorageAsal['stok'];
        }
        $stok_asal_baru=$stok_asal+$qty;
        //Update Stok asal
        $UpdateStokAsal=mysqli_query($Conn, "UPDATE obat_posisi SET stok='$stok_asal_baru' WHERE id_obat='$id_obat' AND id_obat_storage='$storage_from'");
        if($UpdateStokAsal){
            //Informasi Penyimpanan Tujuan
            $QryStorageTujuan = mysqli_query($Conn,"SELECT * FROM obat_posisi WHERE id_obat='$id_obat' AND id_obat_storage='$storage_to'")or die(mysqli_error($Conn));
            $DataStorageTujuan = mysqli_fetch_array($QryStorageTujuan);
            if(empty($DataStorageTujuan['stok'])){
                $stok_tujuan=0;
            }else{
                $stok_tujuan= $DataStorageTujuan['stok'];
            }
            $stok_tujuan_baru=$stok_tujuan-$qty;
            //Update Stok Tujuan
            $UpdateStokTujuan=mysqli_query($Conn, "UPDATE obat_posisi SET stok='$stok_tujuan_baru' WHERE id_obat='$id_obat' AND id_obat_storage='$storage_to'");
            if($UpdateStokTujuan){
                //Hapus Transfer
                $HapusTransfer = mysqli_query($Conn, "DELETE FROM obat_transfer_alokasi WHERE id_obat_transfer_alokasi='$id_obat_transfer_alokasi'") or die(mysqli_error($Conn));
                if($HapusTransfer){
                    echo '<span class="text-success" id="NotifikasiHapusTransferBerhasil">Success</span>';
                }else{
                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menghapus Data Transfer Barang</span>';
                }
            }else{
                echo '<span class="text-danger">Terjadi Kesalahan pada saat melakukan update stok penyimpanan tujuan!</span>';
            }
        }else{
            echo '<span class="text-danger">Terjadi Kesalahan pada saat melakukan update stok penyimpanan asal!</span>';
        }
    }
?>