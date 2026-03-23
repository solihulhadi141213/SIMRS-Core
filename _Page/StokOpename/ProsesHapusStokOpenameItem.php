<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $now=date('Y-m-d H:i:s');
    //Validasi Form Data Yang Wajib Diisi
    if(empty($_POST['id_obat_so'])){
        echo '<span class="text-danger">ID Stok Opename Tidak Boleh Kosong</span>';
    }else{
        $id_obat_so=$_POST['id_obat_so'];
        //Buka detail SO
        $id_obat_so=$_POST['id_obat_so'];
        $tanggal=getDataDetail($Conn,'obat_so','id_obat_so',$id_obat_so,'tanggal');
        $id_obat=getDataDetail($Conn,'obat_so','id_obat_so',$id_obat_so,'id_obat');
        $nama=getDataDetail($Conn,'obat_so','id_obat_so',$id_obat_so,'nama');
        $kode=getDataDetail($Conn,'obat_so','id_obat_so',$id_obat_so,'kode');
        $id_obat_storage=getDataDetail($Conn,'obat_so','id_obat_so',$id_obat_so,'id_obat_storage');
        $nama_penyimpanan=getDataDetail($Conn,'obat_so','id_obat_so',$id_obat_so,'nama_penyimpanan');
        $satuan=getDataDetail($Conn,'obat_so','id_obat_so',$id_obat_so,'satuan');
        $harga=getDataDetail($Conn,'obat_so','id_obat_so',$id_obat_so,'harga');
        $stok_awal=getDataDetail($Conn,'obat_so','id_obat_so',$id_obat_so,'stok_awal');
        $stok_akhir=getDataDetail($Conn,'obat_so','id_obat_so',$id_obat_so,'stok_akhir');
        $stok_selisih=getDataDetail($Conn,'obat_so','id_obat_so',$id_obat_so,'stok_selisih');
        //Buka stok obat sekarang
        if(empty($id_obat_storage)){
            $stok_sekarang=getDataDetail($Conn,'obat','id_obat',$id_obat,'stok');
            $stok_sekarang=$stok_sekarang-$stok_selisih;
        }else{
            $QryStokStorage = mysqli_query($Conn,"SELECT * FROM obat_posisi WHERE id_obat_storage='$id_obat_storage' AND id_obat='$id_obat'")or die(mysqli_error($Conn));
            $DataStokStorage = mysqli_fetch_array($QryStokStorage);
            if(empty($DataStokStorage['stok'])){
                $stok_sekarang="0";
            }else{
                $stok_sekarang=$DataStokStorage['stok'];
            }
            $stok_sekarang=$stok_sekarang-$stok_selisih;
        }
        //Kembalikan ke penyimpanan masing-masing
        if(empty($id_obat_storage)){
            $UpdateObat=mysqli_query($Conn, "UPDATE obat SET stok='$stok_sekarang' WHERE id_obat='$id_obat'");
            if($UpdateObat){
                $UpdateStokSemula="Berhasil";
            }else{
                $UpdateStokSemula="Gagal Melakukan Update Ke Data Obat Utama";
            }
        }else{
            $UpdateObat=mysqli_query($Conn, "UPDATE obat_posisi SET stok='$stok_sekarang' WHERE id_obat_storage='$id_obat_storage' AND id_obat='$id_obat'");
            if($UpdateObat){
                $UpdateStokSemula="Berhasil";
            }else{
                $UpdateStokSemula="Gagal Melakukan Update Ke Data Obat Ke Penyimpanan Lain";
            }
        }
        //Hapus Data
        if($UpdateStokSemula=="Berhasil"){
            $HapusStokOpename = mysqli_query($Conn, "DELETE FROM obat_so WHERE id_obat_so='$id_obat_so'") or die(mysqli_error($Conn));
            if($HapusStokOpename){
                $LogJsonFile="../../_Page/Log/Log.json";
                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Hapus Stok Opename Berhasil","Stok Opename",$SessionIdAkses,$LogJsonFile);
                if($MenyimpanLog=="Berhasil"){
                    echo '<span class="text-success" id="NotifikasiHapusItemStokOpenameBerhasil">Success</span>';
                }else{
                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                }
            }else{
                echo '<span class="text-danger">Terjadi kesalahan pada saat menghapus data stok opename</span>';
            }
        }else{
            echo '<span class="text-danger">'.$UpdateStokSemula.'</span>';
        }
    }
?>